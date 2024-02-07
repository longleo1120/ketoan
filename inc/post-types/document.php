<?php

add_action('init', 'register_document_init');

function register_document_init() {

    $investment_labels = array(
        'name'               => 'Tài liệu',
        'singular_name'      => 'Tài liệu',
        'menu_name'          => 'Tài liệu',
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
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'exclude_from_search' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'supports'           => array( 'title', 'editor','comments', 'revisions', 'custom-fields'),
        'menu_position'      => 2,
        'rewrite'            => array( 'slug' => 'tai-lieu' ),
        'rest_base'          => 'documents',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
    register_post_type('document', $investment_args);

}

add_action( 'init', 'create_document_cat' );
function create_document_cat() {
    register_taxonomy(
        'document_cat',
        'document', 
        array(
            'label' => "Danh mục",
            'rewrite' => array( 'slug' => 'document-cat' ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'parent_item'  => null,
            'parent_item_colon' => null,
            'show_in_rest'       => true,
            'rest_base'          => 'document_cat',
            'rest_controller_class' => 'WP_REST_Terms_Controller', 
        )
    );
}
add_action( 'init', 'create_document_type' );
function create_document_type() {
    register_taxonomy(
        'document_type',
        'document', 
        array(
            'label' => "Loại tài liệu",
            'rewrite' => array( 'slug' => 'document-type' ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'parent_item'  => null,
            'parent_item_colon' => null,
            'show_in_rest'       => true,
            'rest_base'          => 'document_type',
            'rest_controller_class' => 'WP_REST_Terms_Controller', 
        )
    );
}

add_action('init', 'document_type_filter_post_type_by_taxonomy');
function document_type_filter_post_type_by_taxonomy() {
    global $typenow;
    $post_type = 'document'; // change to your post type
    $taxonomy  = 'document_type'; // change to your taxonomy
    if ($typenow == $post_type) {
        $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
        $info_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => __("Show All {$info_taxonomy->label}"),
            'taxonomy'        => $taxonomy,
            'name'            => $taxonomy,
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
        ));
    };
}

add_filter('parse_query', 'document_type_id_to_term_in_query');
function document_type_id_to_term_in_query($query) {
    global $pagenow;
    $post_type = 'document'; // change to your post type
    $taxonomy  = 'document_type'; // change to your taxonomy

    $q_vars    = &$query->query_vars;

    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}

add_action( 'init', function () {
    add_ux_builder_post_type( 'document' );
} );