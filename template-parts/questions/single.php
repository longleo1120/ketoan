<?php
	do_action('flatsome_before_blog');
?>

<?php if(!is_single() && flatsome_option('blog_featured') == 'top'){ get_template_part('template-parts/posts/featured-posts'); } ?>

<div class="row row-large <?php if(flatsome_option('blog_layout_divider')) echo 'row-divided ';?>">

	<div class="large-8 col">
	<?php if(!is_single() && flatsome_option('blog_featured') == 'content'){ get_template_part('template-parts/posts/featured-posts'); } ?>
	<?php
		if(is_single()){
			get_template_part( 'template-parts/posts/single');
			comments_template(); ?>
			<hr>
			

			<div class="meta-bottom-single">
				<div class="list-tags">
					<?php 
					$posttags = get_the_tags(get_the_ID());
					if ($posttags) {?>
							<?php foreach($posttags as $tag) { ?>
								<a href="<?php echo esc_attr( get_tag_link( $tag->term_id ) ) ?>"><?php echo $tag->name;?></a>
							<?php } ?>
					<?php } ?>
				</div>
				<div class="list-social-share">
					<span>Chia sẻ</span>
					<a class="social-share-item btn-link-copy" data-clipboard-text="<?php echo get_the_permalink(get_the_ID()) ?>">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/link.svg" alt="">
						<span class=" copied" style="display:none">Copied</span>
					</a>
					<a href="https://www.facebook.com/sharer.php?u=<?php echo get_the_permalink(get_the_ID()) ?>" data-label="Facebook" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;" rel="noopener noreferrer nofollow" target="_blank" class="social-share-item" aria-label="Share on Facebook">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/facebook2.svg" alt="">
					</a>
					<a href="https://telegram.me/share/url?url=<?php echo get_the_permalink(get_the_ID()) ?>" class="social-share-item" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/telegram.svg" alt="">
					</a>
					<a href="https://twitter.com/share?url=<?php echo get_the_permalink(get_the_ID()) ?>" class="social-share-item" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px'); return false;">
						<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/twitter.svg" alt="">
					</a>
					
				</div>
			</div>
			<?php echo do_shortcode('[block id="thong-tin-cong-ty"]'); ?>
				<?php

			
			

		} elseif(flatsome_option('blog_style_archive') && (is_archive() || is_search())){
			get_template_part( 'template-parts/posts/archive', flatsome_option('blog_style_archive') );
		} else {
			get_template_part( 'template-parts/posts/archive', flatsome_option('blog_style') );
		}
	?>
	</div>
	<div class="post-sidebar large-4 col">
		<?php flatsome_sticky_column_open( 'blog_sticky_sidebar' ); ?>
		<?php get_sidebar(); ?>
		<?php flatsome_sticky_column_close( 'blog_sticky_sidebar' ); ?>
	</div>

</div>

<?php echo do_shortcode('[block id="block-tri-an"]'); ?>

<?php
	do_action('flatsome_after_blog');
?>
