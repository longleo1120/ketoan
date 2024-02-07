<?php

function breadcrumb_ux_builder_element() {

    $options =  array( );

    add_ux_builder_shortcode('ux_breadcrumb_rankmath', array(
        'name' => __('A2Z Breadcrumb'),
        'category' => __('A2Z Content'),
        'priority' => 1,
        'options' => $options,
    ));
}

add_action("ux_builder_setup", "breadcrumb_ux_builder_element");

function breadcrumb_rankmath_ux($atts, $content = null, $tag = '' ) {

    ob_start();
    if(is_singular( 'product' )){

        ?>
        <nav aria-label="breadcrumbs" class="rank-math-breadcrumb"><p><a href="<?php echo home_url(); ?>"><?php echo __('Home','flatsome'); ?></a><span class="separator"> » </span><a href="<?php echo home_url(); ?>/collections/"><?php echo __('Collections','flatsome'); ?></a><span class="separator"> » </span><span class="last"><?php echo get_the_title(get_the_ID()); ?></span></p></nav>

        <?php 
    }else{
        if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs();
    }
    


$content = ob_get_contents();
ob_end_clean();
return $content;
}

add_shortcode("ux_breadcrumb_rankmath", "breadcrumb_rankmath_ux");

?>