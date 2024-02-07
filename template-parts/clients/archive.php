<?php echo do_shortcode('[block id="block-khach-hang"]');?>
<?php if ( have_posts() ) : ?>
<div class="page-wrapper">
    <div class="row row-collapse large-columns-3 medium-columns-2 small-columns-1">

    <?php while ( have_posts() ) : the_post(); ?>

    <div class="col client-item">
        <div class="col-inner">
            <div class="plain">
                <div class="box-client">
                    <div class="box-client-img">
                        <?php the_post_thumbnail();?>
                        <div class="overlay"></div>
                    </div>
                    <div class="box-client-text">
                        <h3 class="post-title is-large ">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>     ">
                                <?php the_title(); ?>                    
                            </a>
                        </h3>
                        <a href="<?php the_permalink(); ?>" class="view-client"><span>Tìm hiểu thêm</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php endwhile; ?>

    <?php flatsome_posts_pagination(); ?>

    </div>
</div>
<?php else : ?>

	<?php get_template_part( 'template-parts/posts/content','none'); ?>

<?php endif; ?>