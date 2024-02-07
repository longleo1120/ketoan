<?php get_header(); ?>
    <?php
       
        if (is_tax()) {
            $tax = get_queried_object();
            $ptype = $tax->taxonomy ? str_replace('_cat', '', $tax->taxonomy) : 'post' ;

            get_template_part('template-parts/'.$ptype.'s/archive', 'cat');

        }
        else {

            $ptype = get_query_var('post_type') ? get_query_var('post_type') : 'post' ;
            if($ptype == 'post'){
                get_template_part('template-parts/'.$ptype.'s/layout');
            }else{
                get_template_part('template-parts/'.$ptype.'s/archive');
            }
            
        } 
    ?>
<?php get_footer(); ?>