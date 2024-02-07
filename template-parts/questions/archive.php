<?php $tax_id = isset( get_queried_object()->term_id ) ? get_queried_object()->term_id : 0;?>



<div class="row align-center category-wrapper">
	<div class="large-12 col">
		<div class="main-title m-auto text-center">
			<p>QUESTIONS - LAW</p>
			<h2>HỎI ĐÁP - PHÁP LUẬT</h2>
		</div>
	<?php if(!is_single()) {?>
		<ul class="list-type-none flex list-cat-blog">
            <li class="<?php if( is_post_type_archive('question')){ echo 'active'; } ?>"><a href="<?php echo get_post_type_archive_link( 'question' ); ?>">Tất cả</a></li>
        	<?php

             $tax_terms = get_terms( array(
                'taxonomy' => 'question_cat',
                'hide_empty' => false
            ));
             foreach ($tax_terms as $key => $value) {
                 $va_id = $value->term_id;
             ?>
             <li class="<?php if( $tax_id == $va_id ){ echo 'active'; } ?>">
                 <a href="<?php echo get_term_link( $value->slug, 'question_cat' ); ?>"><?php echo $value->name; ?></a>
             </li>
            <?php } ?>
        </ul>
	<?php } ?>

	
	</div>

</div>



<?php 
    $ids_featured = array();
    if($tax_id != 0){
        $args = array(
            'posts_per_page' => 2,
            'post_type' => 'question',
            'tax_query' => array(
                array(
                    'taxonomy'  => 'question_cat',
                    'field'     => 'term_id',
                    'terms'     => $tax_id,
                )
            ),
        );
    }else{
        $args = array(
            'posts_per_page' => 2,
            'post_type' => 'question',
        );
    }
 
// get results
$the_query = new WP_Query( $args );
 
// The Loop
?>
<?php if( $the_query->have_posts() ): ?>
    <section>
<div class="wrap-post-featured">
<div class="row large-columns-3 medium-columns- small-columns-1 row-masonry">
	<?php  while ( $the_query->have_posts() ) : $the_query->the_post(); 
    $ids_featured[] = get_the_ID();
        // array_push($ids_featured, get_the_ID());
    ?>
            <div class="col post-item">
                <div class="col-inner">
                    <div class="plain">
                        <div class="box box-text-bottom box-blog-post has-hover">
                            <a href="<?php the_permalink(  ); ?>" class="box-image">
                                <div class="image-cover" style="padding-top:56%;">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                            </a>
                            <div class="box-text text-left">
                                <div class="box-text-inner blog-post-inner">
                                    <?php 
                                    $taxonomy = 'question_cat';
                                    $cat = get_the_terms(get_the_ID(), $taxonomy);
                                    foreach($cat as $key => $value){
                                        echo '<div class="cat-post">';
                                            echo '<a href="' . esc_url( get_category_link( $value->term_id ) ) . '">'.$value->name.'</a>';
                                            echo '<div class="post-news-date">'.get_the_date('d.m.Y').'</div>';
                                        echo '</div>';
                                    } ?>
                                    <h5 class="post-title is-large "><a href="<?php the_permalink(  ); ?>"><?php the_title(); ?></a></h5>
                                    <p class="from_the_blog_excerpt small-font show-next">
                                        <?php
                                        $excerpt      = get_the_excerpt();
                                        $excerpt_more = apply_filters( 'excerpt_more', ' [...]' );
                                        echo flatsome_string_limit_words( $excerpt, 15 ) . $excerpt_more;
                                        ?>
                                    </p>
                                    <button href="<?php the_permalink(  ); ?>" class="btn-reamore"><span>Xem chi tiết</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	<?php endwhile; ?>
    </div>
    </div>
    </section>
<?php endif; ?>

<?php wp_reset_query(); ?>
<?php
    // var_dump($ids_featured);
    // $ids_featured = implode(',', $ids_featured);
    // var_dump($ids_featured);
    // $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    if($tax_id != 0){
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'question',
            'post__not_in' => $ids_featured,
            'tax_query' => array(
                array(
                    'taxonomy'  => 'question_cat',
                    'field'     => 'term_id',
                    'terms'     => $tax_id,
                )
            ),
        );
    }else{
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'question',
            'post__not_in' => $ids_featured,
        );
    }
    
    $the_query2 = new WP_Query( $args );

    if ( $the_query2->have_posts() ) : ?>
        <div class="service-wrap-main blog-archive">
            <div class="row large-columns-3 medium-columns- small-columns-1">

                <?php while ( $the_query2->have_posts() ) : $the_query2->the_post(); 
                        ?>
                        <div class="col service-item post-item">
                            <div class="col-inner">
                                <div class="plain">
                                    <a href="<?php the_permalink() ?>" class="box-image rectangle">
                                        <div class="entry-image-attachment" style="max-height:<?php echo $image_height; ?>;overflow:hidden;">
                                            <?php the_post_thumbnail( 'medium' ); ?>
                                        </div>
                                    </a>
                                    <div class="box-text text-left">
                                        <?php 
                                        $taxonomy = 'question_cat';
                                        $cat = get_the_terms(get_the_ID(), $taxonomy);
                                        foreach($cat as $key => $value){
                                            echo '<div class="cat-post">';
                                                echo '<a href="' . esc_url( get_category_link( $value->term_id ) ) . '">'.$value->name.'</a>';
                                                echo '<div class="post-news-date">'.get_the_date('d.m.Y').'</div>';
                                            echo '</div>';
                                        } ?>
                                        <h5 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h5>
                                        <p class="from_the_blog_excerpt small-font show-next">
                                            <?php
                                            $excerpt      = get_the_excerpt();
                                            $excerpt_more = apply_filters( 'excerpt_more', ' [...]' );
                                            echo flatsome_string_limit_words( $excerpt, 15 ) . $excerpt_more;
                                            ?>
                                        </p>
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
            <div class="row">
                <div class="col">
                    <?php get_template_part( 'template-parts/posts/content','none'); ?>
                </div>
            </div>

        <?php endif; ?>
        
</div>