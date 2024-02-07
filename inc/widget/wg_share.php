<?php

function create_share_widget() {
    register_widget( 'Share_Widget' );
}
add_action( 'widgets_init', 'create_share_widget' );
 
class Share_Widget extends WP_Widget {
 
  	function __construct() {
        parent::__construct(
            'post_view',
            __( 'Chia sẻ mạng xã hội', 'shtheme' ),
            array(
                'description'  => __( 'Chia sẻ mạng xã hội', 'shtheme' )
            )
        );
    }
 
    function form($instance) {
        $title = isset( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
    <?php
    }
 
    /*
     * Cập nhật dữ liệu nhập vào form tùy chọn trong database
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }
 
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        // echo do_shortcode('[icon_share_network]');
        echo $args['after_widget'];
    }
    }
?>