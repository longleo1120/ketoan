<?php

add_action('init', 'register_service_init');

function register_service_init() {

    $investment_labels = array(
        'name'               => 'Dịch vụ',
        'singular_name'      => 'Dịch vụ',
        'menu_name'          => 'Dịch vụ',
        'add_new_item'       => 'Thêm mới',
        'add_new'            => 'Thêm mới',
        'new_item'           => 'Thêm mới',
        'edit_item'          => 'Chỉnh sửa',
        'update_item'        => 'Update tin'
    );

    $investment_args = array(
        'labels'             => $investment_labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-groups',
        'capability_type'    => 'post',
        'publicly_queryable' => true,
        'has_archive'        => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'exclude_from_search' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'supports'           => array( 'title', 'editor', 'revisions', 'thumbnail', 'custom-fields'),
        'menu_position'      => 5,
        'rewrite'            => array( 'slug' => 'dich-vu' ),
        'rest_base'          => 'service',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
    register_post_type('service', $investment_args);

}

add_action( 'init', 'create_taxonomy_service' );

function create_taxonomy_service() {

    register_taxonomy('service_cat',array (0 => 'service',),
        array( 'hierarchical' => true,
        'label' => 'Danh mục dịch vụ',
        'show_ui' => true,
        'query_var' => true,
        'show_admin_column' => true,
        'rewrite'   => array( 'slug' => 'danh-muc-dich-vu' ),
        'labels' => array (
            'search_items' => 'Danh mục dịch vụ',
            'popular_items' => 'Nổi bật',
            'all_items' => 'Tất cả',
            'parent_item' => 'Cha',
            'parent_item_colon' => 'Cha',
            'edit_item' => 'Sửa',
            'update_item' => 'Cập nhật',
            'add_new_item' => 'Thêm',
            'new_item_name' => 'Thêm',
            'separate_items_with_commas' => 'Cách nhau bằng dấu phẩy',
            'add_or_remove_items' => 'Thêm hoặc xóa',
            'choose_from_most_used' => 'Chọn nổi bật nhất',
        )

    ));

}

add_action( 'init', function () {
    add_ux_builder_post_type( 'service' );
} );

function list_service_relate($thamso,$content) {
    ob_start();
    
    $custom_taxterms = wp_get_object_terms( get_the_ID(), 'service_cat', array('fields' => 'ids') );
        // arguments
    $args = array(
    'post_type' => 'service',
    'post_status' => 'publish',
    'posts_per_page' => 3, // you may edit this number
    'orderby' => 'rand',
    'post__not_in' => array (get_the_ID()),
    );
    $related_items = new WP_Query( $args );
    // loop over query
    if ($related_items->have_posts()) :
    echo '<div class="row large-columns-3 medium-columns- small-columns-1">';
    while ( $related_items->have_posts() ) : $related_items->the_post();
    ?>
        <div class="col service-item service-item">
            <div class="col-inner">
                <div class="plain">
                    <div class="box-service">
                        <div class="box-image">
                            <div class="image-cover" style="padding-top:75%;">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('full'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="box-service-text">
                        <h5 class="post-title is-large ">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>   ">
                                <?php the_title(); ?>        
                            </a>
                        </h5>
                        <div class="des-service">
                            <?php
                                echo get_field('mo_ta_ngan_dich_vu',get_the_ID());
                            ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="view-service"><span>Tìm hiểu thêm</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endwhile;
    echo '</div>';
    endif;
    // Reset Post Data
    wp_reset_postdata();


    $list = ob_get_clean();
    return $list;
}
add_shortcode( 'list_service_relate', 'list_service_relate' );



