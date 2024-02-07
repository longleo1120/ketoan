<?php
class News_Document extends WP_Widget {
    function __construct() {
        parent::__construct(
            'news_document',
            'Tài liệu mới',
            array( 'description'  =>  'Widget hiển thị tài liệu mới' )
        );
    }


    function form( $instance ) {
        $default = array(
            'title' => 'Tài liệu mới',
            'post_number' => 3
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = esc_attr($instance['title']);
        $post_number = esc_attr($instance['post_number']);
        echo '<p>Nhập tiêu đề <input type="text" class="widefat" name="'.$this->get_field_name('title').'" value="'.$title.'"/></p>';
        echo '<p>Số lượng bài viết hiển thị <input type="number" class="widefat" name="'.$this->get_field_name('post_number').'" value="'.$post_number.'" placeholder="'.$post_number.'" max="30" /></p>';
    }


    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['post_number'] = strip_tags($new_instance['post_number']);
        return $instance;
    }


    function widget( $args, $instance ) {
        extract($args);
        $title = apply_filters( 'widget_title', $instance['title'] );
        $post_number = $instance['post_number'];


        echo $before_widget;
        echo '<h3 class="title-widget">'.$title.'</h3>';//$before_title.$title.$after_title;

        $args = array(
            'post_type' => 'document',
            'posts_per_page' => $post_number,
            'orderby' => 'ID',
            'order' => 'DESC'
         );
        $news_query = new WP_Query($args);
        if ($news_query->have_posts()):
            echo '<div class="list-news-document">';
            while( $news_query->have_posts() ) :
                $news_query->the_post(); 
                $img_type = type_img_url(get_the_ID());
                ?>
                
                <div class="new-item">
                    <div class="thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php
                               
                                echo '<img width="40" src="'.$img_type.'" />';
                               
                            ?>
                        </a>
                    </div>
                    <div class="title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <span><?php the_time( 'g:i, d/m/Y' ); ?> </span>
                    </div>
                </div>


            <?php endwhile;
            echo '</div>'; ?>
            <div class="load-more">
                <span id="load-more-sidebar">Xem thêm <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/double-arrow-down.svg" alt="" ></span>        
            </div>
        <?php 
        endif;wp_reset_query();
        echo $after_widget;


    }


}


add_action( 'widgets_init', 'create_news_document_widget' );
function create_news_document_widget() {
    register_widget('News_Document');
}