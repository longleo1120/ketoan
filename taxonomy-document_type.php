<?php 
    get_header();

    

?>
<?php get_template_part( 'template-parts/search-section' ); ?>

<section class="main-index">
    <div class="container adong-container" style="position: relative;">
        <div class="row">
            <div class="adong-leftbar col large-4">
                <div class="main-left-side">
                    <?php if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
                            <?php dynamic_sidebar( 'sidebar-left' ); ?>
                    <?php endif; ?>
                </div>
            </div>
 
            <div class="adong-main col large-8">
                <div class="main-content-section">
                   
                        <div class="wrap-title-document">
                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/file-icon.svg" alt="" class="svg-img"> 
                            <h2 class="title-document">Tài liệu <?php echo single_term_title(); ?></h2>
                        </div>
                        <div class="list-document-media">
                            <?php if(have_posts()){ ?>
                                <?php while(have_posts()): the_post(); 
                                    $img_type = type_img_url(get_the_ID());
                                    $term_doc = '';
                                    $terms = get_the_terms( get_the_ID(), 'document_type' );
                                    if(!empty($terms)){
                                        $term_doc = $terms[0]->slug;
                                    }
                                ?>
                                    
                                    <div class="item-document">
                                        <div class="thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo $img_type; ?>" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                                            <div class="meta">
                                                <div class="author">
                                                    <span>Tác giả:</span>
                                                    <span class="name-author"><?php the_field( 'author_document', get_the_ID() ); ?></span>
                                                </div>
                                                <div class="cateogry">
                                                    <?php
                                                        
                                                        if(!empty($terms)){
                                                            foreach($terms as $term){
                                                                echo "<a href=".get_term_link($term->term_id, 'document_type').">".$term->name."</a>";
                                                            }
                                                        }
                                                        $category = get_the_terms( get_the_ID(), 'category' );
                                                        if(!empty($category)){
                                                            foreach($category as $cat){?>
                                                                <a href="<?php echo home_url().'/'. $term_doc; ?>?chuyennganh=<?php echo $cat->slug.'-'.$cat->term_id; ?>"><?php echo $cat->name ?></a>
                                                            <?php 
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; 
                                        if(function_exists('wp_pagenavi')){
                                            wp_pagenavi(); 
                                        }
                                }else{
                                     ?>
                                    <div class="alert alert-danger" role="alert">
                                        Dữ liệu đang được upload...
                                    </div>
                            <?php };wp_reset_query(); ?>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>