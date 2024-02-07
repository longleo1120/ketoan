<?php
    the_content();
    
?>
        <?php
            $args = array( 
                'post__not_in' => array(get_the_ID()),
                'post_type' => 'client',
                'posts_per_page' => 8,
            );
            $loop = new WP_Query($args);?>
            <?php if( $loop->have_posts() ) { ?>
                <div class="relate-project home-service">
                    <div class="text-center list-service">
                        <h2>Các dịch vụ của <span style="color: #d93b49;">S</span><span style="color: #00827c;">GROW</span></h2>
                        <p><span style="color: #556987;">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa libero labore natus atque, ducimus sed.</span></p>
                    </div>
                    <div class="row large-columns-3 medium-columns-2 small-columns-1 slider row-slider slider-nav-simple slider-nav-push is-draggable flickity-enabled slider-lazy-load-active" data-flickity-options='{"cellAlign": "left","wrapAround": true,"autoPlay": false,"prevNextButtons":true,"adaptiveHeight": true,"imagesLoaded": true,"dragThreshold" : 5,"pageDots": false,"rightToLeft": false}'>
                        <?php while( $loop->have_posts() ) : $loop->the_post(); ?>
                            <div class="col service-item post-item <?php echo implode(' ', $col_class); ?>" <?php echo $animate;?>>
                                <div class="col-inner">
                                    <div class="plain">
                                        <div class="box-service">
                                            <div class="box-service-img">
                                                <div class="image-cover" style="padding-top: 75%;">
                                                    <a href="<?php the_permalink() ?>">
                                                        <?php the_post_thumbnail(); ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-service-text">
                                                <h5 class="post-title is-<?php echo $title_size; ?> <?php echo $title_style;?>">
                                                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h5>
                                                <div class="des-service">
                                                    <?php
                                                        $des_service = get_field('mo_ta_ngan_dich_vu');
                                                        echo $des_service;
                                                    ?>
                                                </div>
                                                <a href=<?php the_permalink() ?>" class="view-service"><span>Tìm hiểu thêm</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <a href="/dich-vu" target="_self" class="button primary lowercase btn-link btn-link-v1 m-auto">
                        <span>Các dịch vụ khác</span>
                    </a>
                </div>
            <?php } 
        wp_reset_query();?>
</div>