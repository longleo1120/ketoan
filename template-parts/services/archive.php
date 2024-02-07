<div class="main-archive-service">
    <section>
        <div class="row">
            <div class="large-12 col-12 col">
                <div class="col-inner">
                    <div class="text main-title m-auto text-center">
                        <p>SERVICE</p>
                        <h2>DỊCH VỤ</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php 
    $ids_featured = array();

    $args = array(
        'numberposts' => -1,
        'post_type' => 'service',
        'meta_key' => 'host_post',                   
    	'meta_value' => true,
    );
 
// get results
$the_query = new WP_Query( $args );
 
// The Loop
?>
<?php if( $the_query->have_posts() ): ?>
    <section>
	<?php $i=1; while ( $the_query->have_posts() ) : $the_query->the_post(); 
    $ids_featured[] = get_the_ID();
        // array_push($ids_featured, get_the_ID());
    ?>
        <div class="row align-middle box-service-sm flex-sm-column-reverse <?php if($i > 1){echo('row-reverse');} ?>">
            <div class="col medium-6 small-12 large-6">
                <div class="col-inner">
                    <div class="box-service-text">
                        <h5 class="post-title is-large ">
                            <?php 
                                if(get_field('link_external_service',get_the_ID()) != ''){
                                    echo '<a href="'.get_field('link_external_service',get_the_ID()).'" target="_blank">';
                                }else{
                                    echo '<a href="'.get_the_permalink(get_the_ID()).'">';
                                }
                            ?>
                                <?php the_title(); ?>        
                            </a>
                        </h5>
                        <div class="des-service">
                            <?php
                                echo get_field('mo_ta_ngan_dich_vu',get_the_ID());
                            ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="button primary is-outline hide-for-small is-large lowercase btn-main" style="border-radius:99px;">
                            <span>Xem thêm</span>
                        </a>
                        <a href="<?php the_permalink(); ?>" class="view-service show-for-small">
                            <span>Xem thêm</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col medium-6 small-12 large-6">
                <div class="col-inner">
                    <div class="img has-hover x md-x lg-x y md-y lg-y" id="image_989149622">
                        <div class="img-inner dark">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php $i++; endwhile; ?>
    </section>
<?php endif; ?>

<?php wp_reset_query(); ?>
<?php
    // var_dump($ids_featured);
    // $ids_featured = implode(',', $ids_featured);
    // var_dump($ids_featured);
    // $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $args = array(
        'numberposts' => -1,
        'post_type' => 'service',
        'post__not_in' => $ids_featured,
        // 'paged' => $paged,
        // 'posts_per_page' => 6
    );
    $the_query2 = new WP_Query( $args );

    if ( $the_query2->have_posts() ) : ?>
        <div class="service-wrap-main">
            <div class="row large-columns-3 medium-columns- small-columns-1">

                <?php while ( $the_query2->have_posts() ) : $the_query2->the_post(); 
                        ?>
                        <div class="col service-item service-item">
                            <div class="col-inner">
                                <div class="plain">
                                    <div class="box-service">
                                        <div class="box-image">
                                            <div class="image-cover" style="padding-top:75%;">
                                                <?php 
                                                    if(get_field('link_external_service',get_the_ID()) != ''){
                                                        echo '<a href="'.get_field('link_external_service',get_the_ID()).'" target="_blank">';
                                                    }else{
                                                        echo '<a href="'.get_the_permalink(get_the_ID()).'">';
                                                    }
                                                ?>
                                                    <?php the_post_thumbnail('full'); ?>
                                                </a>
                                                
                                            </div>
                                        </div>
                                        <div class="box-service-text">
                                            <h5 class="post-title is-large ">
                                                <?php 
                                                    if(get_field('link_external_service',get_the_ID()) != ''){
                                                        echo '<a href="'.get_field('link_external_service',get_the_ID()).'" target="_blank">';
                                                    }else{
                                                        echo '<a href="'.get_the_permalink(get_the_ID()).'">';
                                                    }
                                                ?>
                                                    <?php the_title(); ?>        
                                                </a>
                                            </h5>
                                            <div class="des-service">
                                                <?php
                                                echo get_field('mo_ta_ngan_dich_vu',get_the_ID());
                                                ?>
                                            </div>
                                            <a href="<?php the_permalink(); ?>" class="view-service">
                                                <span>Xem thêm</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>

            </div>
            <!-- <div class="wrap-pagination">
                <?php //pagination(); ?>                                
            </div> -->
            
        </div>

        <?php else : ?>

            <?php get_template_part( 'template-parts/posts/content','none'); ?>

        <?php endif; ?>
        
</div>


<?php echo do_shortcode('[block id="block-dich-vu"]'); ?>
