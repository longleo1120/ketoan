<?php 

if(get_field('link_external_service',get_the_ID()) != ''){
    wp_redirect(get_field('link_external_service',get_the_ID()));
}
?>


<div class="main-single-service">
    <?php the_content(); ?>
</div>