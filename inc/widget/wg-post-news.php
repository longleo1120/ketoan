<?php

function create_postnews_widget() {
    register_widget( 'PostNews_Widget' );
}
add_action( 'widgets_init', 'create_postnews_widget' );
 
class PostNews_Widget extends WP_Widget {
 
    /*
     * Thiết lập tên widget và description của nó (Appearance -> Widgets)
     */
  	function __construct() {
        parent::__construct(
            'post_view',
            __( 'Bài viết mới nhẩt', 'shtheme' ),
            array(
                'description'  => __( 'Hiển thị bài viết mới nhất', 'shtheme' )
            )
        );
    }
 
    /*
     * Tạo form điền tham số cho widget
     * ở đây ta có 3 form là title, postnum (số lượng bài) và postdate (tuổi của bài
     */
    function form($instance) {
        $default = array(
            'title' => 'Bài viết mới nhất',
            'num_posts' => 5,
        );
        $instance = wp_parse_args( (array) $instance, $default );
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        $num_posts = isset( $instance['num_posts'] ) ? $instance['num_posts'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'num_posts' ); ?>"><?php _e( 'Number of posts to display:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'num_posts' ); ?>" name="<?php echo $this->get_field_name( 'num_posts' ); ?>" type="text" value="<?php echo esc_attr( $num_posts ); ?>">
        </p>
    <?php
    }
 
    /*
     * Cập nhật dữ liệu nhập vào form tùy chọn trong database
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['num_posts'] = strip_tags($new_instance['num_posts']);
        return $instance;
    }
 
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        $num_posts = $instance['num_posts'];
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $num_posts,
            'order' => 'DESC',
        );
        $the_query = new WP_Query($args);
        echo '<div class="post-news">';
            while($the_query->have_posts()) : $the_query->the_post(); ?>
                <a class="post-news-item" href="<?php the_permalink(); ?>">
                    <div class="post-news-img">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <div class="post-news-text">    
                        <h3 class="post-title-news">
                            <?php the_title(); ?>
                        </h3>
                        <div class="box-flex-cat">
                            <?php foreach((get_the_category()) as $key => $cat) {
                                echo '<div class="c-meta-category" >';
                                if($key == 0){
                                    echo $cat->cat_name;
                                }
                                echo '</div>';
                            } ?>
                            <p class="news-date"><?php echo get_the_date('d.m.Y');?></p>
                        </div>
                        
                    </div>
                </a>
            <?php endwhile;wp_reset_postdata();
        echo '</div>';
        // echo $args['after_widget'];
    }
    }
?>