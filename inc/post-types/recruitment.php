<?php

add_action('init', 'register_recruitment_init');

function register_recruitment_init() {

    $investment_labels = array(

        'name'               => 'Tuyển dụng',

        'singular_name'      => 'Tuyển dụng',

        'menu_name'          => 'Tuyển dụng',

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

        'supports'           => array( 'title', 'editor', 'revisions'),

        'menu_position'      => 5,

        'rewrite'            => array( 'slug' => 'tuyen-dung' ),

        'rest_base'          => 'recruitments',

        'rest_controller_class' => 'WP_REST_Posts_Controller',

    );

    register_post_type('recruitment', $investment_args);

}



// add_action( 'init', 'create_taxonomy_recruitment' );

// function create_taxonomy_recruitment() {

//     register_taxonomy('recruitment_cat',array (0 => 'recruitment',),

//         array( 'hierarchical' => true,

//         'label' => 'Danh mục tuyển dụng',

//         'show_ui' => true,

//         'query_var' => true,

//         'show_admin_column' => true,

//         'rewrite'   => array( 'slug' => 'danh-muc-tuyen-dung' ),

//         'labels' => array (

//             'search_items' => 'Danh mục tuyển dụng',

//             'popular_items' => 'Nổi bật',

//             'all_items' => 'Tất cả',

//             'parent_item' => 'Cha',

//             'parent_item_colon' => 'Cha',

//             'edit_item' => 'Sửa',

//             'update_item' => 'Cập nhật',

//             'add_new_item' => 'Thêm',

//             'new_item_name' => 'Thêm',

//             'separate_items_with_commas' => 'Cách nhau bằng dấu phẩy',

//             'add_or_remove_items' => 'Thêm hoặc xóa',

//             'choose_from_most_used' => 'Chọn nổi bật nhất',

//         )

//     ));

// }



add_action( 'init', 'create_location_recruitment' );

function create_location_recruitment() {

    register_taxonomy('location_cat',array (0 => 'recruitment',),

        array( 'hierarchical' => true,

        'label' => 'Địa điểm làm việc',

        'show_ui' => true,

        'query_var' => true,

        'show_admin_column' => true,

        'rewrite'   => array( 'slug' => 'dia-diem' ),

        'labels' => array (

            'search_items' => 'Địa điểm làm việc',

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



add_action( 'init', 'create_salary_recruitment' );

function create_salary_recruitment() {

    register_taxonomy('salary_cat',array (0 => 'recruitment',),

        array( 'hierarchical' => true,

        'label' => 'Mức lương',

        'show_ui' => true,

        'query_var' => true,

        'show_admin_column' => true,

        'rewrite'   => array( 'slug' => 'salary' ),

        'labels' => array (

            'search_items' => 'Mức lương',

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