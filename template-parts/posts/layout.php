<?php $tax_id = isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : 0;?>

<?php
	do_action('flatsome_before_blog');
?>

<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'top'){ get_template_part('template-parts/posts/featured-posts'); } ?>
<div class="row align-center category-wrapper">
	<div class="large-12 col">
		<div class="main-title m-auto text-center">
			<p>NEWS</p>
			<h2>TIN TỨC</h2>
		</div>
	<?php if(!is_single()) {?>
		<ul class="list-type-none flex list-cat-blog">
            <li class="<?php if( !is_archive()){ echo 'active'; } ?>"><a href="<?php echo get_post_type_archive_link( 'post' ); ?>">Tất cả</a></li>
        	<?php

             $tax_terms = get_terms( array(
                'taxonomy' => 'category',
                'hide_empty' => false
            ) );
             foreach ($tax_terms as $key => $value) {
                 $va_id = $value->term_id;
             ?>
             <li class="<?php if( $tax_id == $va_id ){ echo 'active'; } ?>">
                 <a href="<?php echo get_term_link( $value->slug, 'category' ); ?>"><?php echo $value->name; ?></a>
             </li>
            <?php } ?>
        </ul>
	<?php } ?>
	<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'content'){ get_template_part('template-parts/posts/featured-posts'); } ?>

	<?php
		if(is_single()){
			get_template_part( 'template-parts/posts/single');
			comments_template();
		} elseif(get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())){
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style_archive', '') );
		} else{
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style', 'normal') );
		}
	?>
	</div>

</div>

<?php do_action('flatsome_after_blog');
