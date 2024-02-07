<?php get_header(); ?>

    <?php 
        if(get_post_type() == 'post'){
            echo '<div id="content" class="blog-wrapper blog-single page-wrapper">';
           get_template_part( 'template-parts/posts/layout', get_theme_mod('blog_post_layout','right-sidebar') ); 
           echo '</div>';
        }else{
            get_template_part('template-parts/'.get_post_type().'s/single');
        }
    ?>

<?php get_footer(); ?>