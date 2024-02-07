<?php
class List_ChuyenNganh extends WP_Widget {
    function __construct() {
        parent::__construct(
            'list_chuyennganh',
            'Chuyên ngành',
            array( 'description'  =>  'Widget hiển thị danh sách chuyên ngành' )
        );
    }


    function form( $instance ) {
        $default = array(
            'title' => 'Chuyên ngành',
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        // $post_number = esc_attr($instance['post_number']);
        echo '<p>Nhập tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
       
    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }


    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;
        echo '<h3 class="title-widget">'.$title.'</h3>';//$before_title.$title.$after_title;
        $taxonomies = get_terms( array(
            'taxonomy' => 'document_cat',
            'hide_empty' => true,
            'parent' => 0
        ) );

        $term_doc = '';

        if(is_tax('document_cat')){
            $term_doc = get_queried_object()->slug;
        }
        if(is_single()){
            $id_post = get_the_ID();
            $terms = get_the_terms( $id_post, 'document_cat' );
            if(!empty($terms)){
                $term_doc = $terms[0]->slug;
            }
        }
        
        $id_current = '';
        if(isset($_GET['chuyennganh']) && $_GET['chuyennganh'] != '' ): 
            $slug = $_GET['chuyennganh'];
            $id_current = explode('-',$slug);
            $id_current = end($id_current);
        endif;

        $url_home = home_url().'/'. $term_doc;

        foreach($taxonomies as $tax):
            $terms_child = get_terms( 
                array(   'taxonomy' => 'document_cat', 'hide_empty' => false,  'child_of'   => $tax->term_id  ) 
            );
            $args = array(
                // 'tax_query' => array( 
                //     'relation'  => 'AND', 
                //     array(
                //         'taxonomy'          => 'document_cat',        
                //         'field'             => 'term_id',           
                //         'terms'             => $tax->term_id,               
                //     ),
                //     array(
                //         'taxonomy'          => 'document_type',
                //         'field'             => 'slug',
                //         'terms'             => $term_doc,
                //     )
                // ),
                'post_type' => 'document',
            );
            $s = new WP_Query( $args );
            // debug($s);
            if($s->have_posts()){

        ?>
            <div class="item-folder <?php echo (!empty($terms_child )) ? 'has-child' : ''; ?>">
                <a href="<?php echo home_url(); ?>/tai-lieu/?chuyennganh=<?php echo $tax->slug.'-'.$tax->term_id; ?>" class="<?php echo ($id_current == $tax->term_id) ? 'current-term' : 'item-parent'; ?>">
                    <span class="folderimg"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/folder.svg" alt="" class="svg-img img-folder"></span>
                    <span><?php echo $tax->name; ?></span>
                    <?php 
                        if(!empty($terms_child)){ ?>
                            <span class="arrow"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/arrow-down-fill.svg" alt="" class="svg-img img-arrow-down"></span>
                    <?php 
                        }
                    ?>
                    
                </a>
                <?php
                   
                    if(!empty($terms_child)){
                        echo '<div class="child-category" style="display:none">';
                        foreach($terms_child as $child){ 
                        ?>
                            <div class="item-folder">
                                <a href="<?php echo home_url(); ?>/tai-lieu/?chuyennganh=<?php echo $child->slug.'-'.$child->term_id; ?>" class="<?php echo ($id_current == $child->term_id) ? 'current-term' : 'item'; ?>">
                                    <span class="folderimg"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/folder.svg" alt="" class="svg-img img-folder"></span>
                                    <span><?php echo $child->name; ?></span>
                                </a>
                            </div>
                    <?php 
                            
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        <?php 
            }
        endforeach;
        echo $after_widget;


    }


}


add_action( 'widgets_init', 'create_list_chuyennganh_widget' );
function create_list_chuyennganh_widget() {
    register_widget('List_ChuyenNganh');
}