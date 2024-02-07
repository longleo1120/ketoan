<?php
add_action('init', 'register_store_init');
function register_store_init() {
    $investment_labels = array(
        'name'               => 'Cơ sở',
        'singular_name'      => 'Cơ sở',
        'menu_name'          => 'Cơ sở',
        'add_new_item'       => 'Thêm mới',
        'add_new'            => 'Thêm mới',
        'new_item'           => 'Thêm mới',
        'edit_item'          => 'Chỉnh sửa',
        'update_item'        => 'Update tin'
    );
    $investment_args = array(
        'labels'             => $investment_labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-store',
        'capability_type'    => 'post',
        'publicly_queryable' => true,
        'has_archive'        => true,
        'hierarchical' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => false,
        'exclude_from_search' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'supports'           => array( 'title', 'thumbnail', 'revisions'),
        'menu_position'      => 5,
        'rewrite'            => array( 'slug' => 'danh-sach-co-so' ),
        'rest_base'          => 'stores',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
    register_post_type('store', $investment_args);
}


add_action( 'init', 'create_location_stores' );
function create_location_stores() {
    register_taxonomy('store_cat',array (0 => 'store',),
        array( 'hierarchical' => true,
        'label' => 'Quận Huyện',
        'show_ui' => true,
        'query_var' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => false,
        'rewrite'   => array( 'slug' => 'quan-huyen' ),
        'labels' => array (
            'search_items' => 'Quận Huyện',
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

