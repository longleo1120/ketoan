<?php
/**
 * The blog template file.
 *
 * @package a2ztech
 */

get_header();
$id_post = get_the_ID();
?>

<?php get_template_part( 'template-part/search-section' ); ?>

<div class="blog-wrapper blog-single page-wrapper">
    <div class="container adong-container" style="position: relative;">
        <div class="row flex-sm-column-reverse">
            <div class="adong-leftbar col large-4">
                <div class="main-left-side">
                    <?php if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
                            <?php dynamic_sidebar( 'sidebar-left' ); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="adong-main col large-8">
                <div class="main-content-single">
                    <div class="body-content-single">
                        <h1><?php the_title(); ?></h1>
                        <div class="list-tag">
                           
                            <?php
                                $posttags = get_the_tags($id_post);
                                if ($posttags) {
                                    echo ' <span>Tag #</span>';
                                foreach($posttags as $tag) {
                                    echo '<a href="' . esc_attr( get_tag_link( $tag->term_id ) ) . '">' . $tag->name . '</a>'; 
                                }
                            }
                            ?>
                        </div>
                        
                        <div class="chuyennganh-area">
                            <?php 
                                $terms = get_the_terms( $id_post, 'document_type' );
                                if(!empty($terms)){
                                   
                                    foreach($terms as $term):
                                        echo  '<span> '.$term->name.'</span>';
                                        if (next($terms )) {
                                            echo ','; // Add comma for all elements instead of last
                                        }
                                    endforeach;
                                }
                            ?>
                        </div>

                        <div class="meta-box">
                            <div class="item-meta">
                                <div class="thumb">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/calenda.png" alt="">
                                </div>
                                <div class="content-meta">
                                    <b>Ngày xuất bản</b>
                                    <span><?php echo get_the_date('d/m/Y'); ?></span>
                                </div>
                            </div>

                            <?php 
                                if(!empty(get_field('name_nxb',$id_post))){ ?>
                                    <div class="item-meta">
                                        <div class="thumb">
                                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/nxb.png" alt="">
                                        </div>
                                        <div class="content-meta content-nxb">
                                            <b>Nhà xuất bản</b>
                                            <span>
                                                <?php 
                                                    echo get_field('name_nxb',$id_post);
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                            <?php 
                                }
                            
                            ?>

                            <div class="item-meta">
                                <div class="thumb">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/quyentruycap.png" alt="">
                                </div>
                                <div class="content-meta">
                                    <b>Quyền truy cập</b>
                                    <span>
                                        <?php 
                                            if(get_field('quyen_truy_cap',$id_post) == true){
                                                echo "RIÊNG TƯ";
                                            }else{
                                                echo "CỘNG ĐỒNG";
                                            }
                                        ?>
                                    </span>
                                </div>
                            </div>
                          

                            <?php
                                if(!empty(get_field('author_document',get_the_ID()))){ ?>
                                    <div class="item-meta">
                                        <div class="thumb">
                                            <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/tacgia.png" alt="">
                                        </div>
                                        <div class="content-meta">
                                            <b>Tác giả</b>
                                            <span><?php echo get_field('author_document',get_the_ID()); ?></span>
                                        </div>
                                    </div>
                            <?php 
                                }
                            ?>

                            
                            
                            
                        </div>
                        
                        <?php 
                            if(!empty(get_field('file_mp3',$id_post))){ 
                                $mp3 = get_field('file_mp3',$id_post);
                                ?>
                                <div class="mp3-area">
                                    <audio class="listen" preload="none" data-size="250" src="<?php echo $mp3['url']; ?>"></audio>
                                </div>
                            <?php
                            }

                            
                            if(!empty(get_field('content_comment_by_author',$id_post))){
                                echo '<div class="rencent-comment-area">';
                                ?>
                                    <div class="content-cmt">
                                        <?php echo get_field('content_comment_by_author',$id_post); ?>
                                    </div>
                                    <?php if(get_field('name_comment_by_author',$id_post)) : ?>
                                    <p><?php echo '- '.get_field('name_comment_by_author',$id_post) ?></p>
                                    <?php endif; ?>
                            <?php 
                               
                                echo '</div>';
                            }
                        ?>
                        
                        <div class="content-wrap">
                            <?php 
                                
                                $terms_type = get_the_terms( $id_post, 'document_type' );
                                if(!empty($terms_type)){
                                    if($terms_type[0]->slug == 'tieng-viet' || $terms_type[0]->slug == 'tieng-anh'){
                                        get_template_part( 'template-part/single-content-document' ); 
                                    }else if($terms_type[0]->slug == 'hinh-anh'){
                                        get_template_part( 'template-part/single-content-hinhanh' ); 
                                    }else if($terms_type[0]->slug == 'video'){
                                        get_template_part( 'template-part/single-content-video' ); 
                                    }
                                }else{  
                                    the_content();
                                }
                                the_content();

                            
                            ?>

                        </div>

                        
                    </div>
                    
                    <?php 
                        if ( comments_open() || get_comments_number() ) :
                            echo '<div class="footer-content-single">';
                            comments_template();
                            echo '</div>';
                        endif;
                    ?>

                </div>
                
            </div>

            <div class="adong-rightbar col-md-3 col-sm-12" id="adong-rightbar">
                <div class="main-right-side" id="right-bar-sticky">
                    <?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
                            <?php dynamic_sidebar( 'sidebar-right' ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>