<?php

add_action('init', 'register_question_init');

function register_question_init() {

    $investment_labels = array(
        'name'               => 'Hỏi đáp',
        'singular_name'      => 'Hỏi đáp',
        'menu_name'          => 'Hỏi đáp',
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
        'supports'           => array( 'title', 'editor','thumbnail','comments', 'revisions', 'custom-fields'),
        'menu_position'      => 2,
        'rewrite'            => array( 'slug' => 'hoi-dap' ),
        'rest_base'          => 'question',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
    );
    register_post_type('question', $investment_args);

}

add_action( 'init', 'create_question_cat' );
function create_question_cat() {
    register_taxonomy(
        'question_cat',
        'question', 
        array(
            'label' => "Danh mục",
            'rewrite' => array( 'slug' => 'question-cat' ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'parent_item'  => null,
            'parent_item_colon' => null,
            'show_in_rest'       => true,
            'rest_base'          => 'question_cat',
            'rest_controller_class' => 'WP_REST_Terms_Controller', 
        )
    );
}


add_action('init', 'question_type_filter_post_type_by_taxonomy');
function question_type_filter_post_type_by_taxonomy() {
    global $typenow;
    $post_type = 'question'; // change to your post type
    $taxonomy  = 'question_cat'; // change to your taxonomy
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

add_filter('parse_query', 'question_type_id_to_term_in_query');
function question_type_id_to_term_in_query($query) {
    global $pagenow;
    $post_type = 'question'; // change to your post type
    $taxonomy  = 'question_cat'; // change to your taxonomy

    $q_vars    = &$query->query_vars;

    if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
        $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
        $q_vars[$taxonomy] = $term->slug;
    }
}

add_action( 'init', function () {
    add_ux_builder_post_type( 'question' );
} );