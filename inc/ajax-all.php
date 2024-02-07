<?php 

add_action( 'wp_ajax_load_more_new_document', 'load_more_new_document' );
add_action( 'wp_ajax_nopriv_load_more_new_document', 'load_more_new_document' );
function load_more_new_document() {

	$number_post = $_POST['numItems'];
    
    $args = array(
        'post_type' => 'document',
        'offset' => $number_post,
        'posts_per_page' => 3,
        'orderby' => 'ID',
        'order' => 'DESC'
     );
    $news_query = new WP_Query($args);
    if ($news_query->have_posts()):
        while( $news_query->have_posts() ) :
            $news_query->the_post(); 
            $img_type = type_img_url(get_the_ID());

            ?>
            
            <div class="new-item">
                <div class="thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo '<img width="40" src="'.$img_type.'" />'; ?>
                    </a>
                </div>
                <div class="title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span><?php the_time( 'g:i, d/m/Y' ); ?> </span>
                </div>
            </div>

        <?php endwhile;
    endif;wp_reset_query();
	die;
}