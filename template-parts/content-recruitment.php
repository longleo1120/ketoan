<?php

/**

 * Template part for displaying posts

 *

 * @link https://codex.wordpress.org/Template_Hierarchy

 *

 * @package flatsome

 */

$tong_so_suat_lam_viec = get_field('tong_so_suat_viec_lam');

$thoi_han_nop = get_field('han_nop_don');

$hinh_thuc_job = get_field('hinh_thuc_cong_viec');

$muc_luong = get_field('salary_job_rank',get_the_ID());





if(!$thoi_han_nop){

    $thoi_han_nop = 'Đang cập nhật';

}else{

    $thoi_han_nop = $thoi_han_nop;

}



if(!$hinh_thuc_job){

    $hinh_thuc_job = 'Đang cập nhật';

}



$value = get_post_meta(get_the_ID(),'number_apply_job', true);

if($value == null){

    $value = '0';

}else{

    $value = get_post_meta(get_the_ID(),'number_apply_job', true);

}



?>

<div class="recruitment-wrap">
    <div class="container">
        <div class="content-recruitment">
            <div class="content-left">
                <h1 class="title-recruitment"><?php the_title();?></h1>
                <div class="post-meta-single d-flex align-items-center flex-wrap">
                    <div class="post-author">
                        <?php 
                            $get_author_id = get_the_author_meta('ID');
                            $get_author_gravatar = get_avatar_url($get_author_id, array('size' => 32));
                            echo '<img src="'.$get_author_gravatar.'" alt="'.get_the_title().'" />';
                        ?>
                        <span style="color:#414C62;">Đăng bởi</span>
                        <?php 
                            $author_id = get_post_field ('post_author', get_the_ID());
                            $display_name = get_the_author_meta( 'display_name' , $author_id ); 
                            echo $display_name;
                        ?>
                    </div>
                    <div class="post-date">
                        Cập nhật: <?php echo get_the_date('j F Y');?>
                    </div>
                </div>
                <?php the_content();?>
                <?php 
                $current_date = date('d/m/Y');
                if($thoi_han_nop >= $current_date) { ?>
                    <h3>Các thức ứng tuyển</h3>
                    <p>Ứng viên nộp hồ sơ trực tuyến bằng cách bấm nút <a href="#popup_apply_job" style="color:green;text-decoration: underline;">nộp hồ sơ ứng tuyển</a> ngay dưới đây.</p>
                    <a href="#popup_apply_job" class="button primary is-outline is-large lowercase btn-main" id="">Nộp hồ sơ ứng tuyển</a>
                    <?php
                        if($thoi_han_nop){
                            echo '<div class="apply-first">Ứng tuyển trước '.$thoi_han_nop.'</div>';
                        }
                    ?>
                <?php } ?>
            </div>
            <div class="content-right">

                <div class="info-recruitment">
                    <h3>Tổng quan</h3>

                    <?php

                        if(get_field('number_applied_job',get_the_ID()) != ''){

                            $number_aplied = get_field('number_applied_job',get_the_ID());

                        }else{

                            $number_aplied = 0;

                        }



                        $number_max = get_field('tong_so_suat_viec_lam',get_the_ID());

                        if(!empty($number_max)):

                            if($number_aplied == "" || $number_aplied == 0){

                                $number_aplied = 1;

                            }

                            if($number_max == "" || $number_max == 0){

                                $number_max = 10;

                            }



                            $percent = ((int)$number_aplied * 100) / (int)$number_max ;?>

                            <div class="total-apply">

                                <div class="number-apply"><strong><?php echo $number_aplied ?> Đã ứng tuyển</strong> trên <?php echo $number_max ?> suất</div>

                                <div class="progress-bar" data-id="<?php echo get_the_ID() ?>">

                                    <div class="container-progressbar <?php echo ($number_aplied >= $number_max) ? 'full-apl' : 'less-apl'; ?>" style="width:<?php echo $percent; ?>% ">number</div>

                                </div>

                            </div>

                        <?php 

                        endif;


                        if($thoi_han_nop){

                            echo '<div class="item deadline-job">Nộp đơn trước'.'<span>'.$thoi_han_nop.'</span></div>';

                        }

                        echo '<div class="item create-job">Công việc được đăng vào'.'<span>'.get_the_date('d/m/Y').'</span></div>';

                        if($hinh_thuc_job){

                            echo '<div class="item working-job">Hình thức công việc'.'<span>'.$hinh_thuc_job.'</span></div>';

                        }



                        $salary = get_the_terms(get_the_ID(), 'salary_cat');

                        if(!empty($salary)){

                            echo '<div class="item salary-job">Mức lương';

                                foreach($salary as $sl){

                                    echo '<span>'.$sl->name.'</span>';

                                }

                            echo '</div>';

                        }else{

                            echo '<div class="item salary-job">Mức lương <span>Thoả thuận</span></div>';

                        }

                        
                        $location = get_the_terms(get_the_ID(), 'location_cat');

                        if(!empty($location)){ ?>

                            <div class="item salary-job"> Nơi làm việc

                                <?php foreach($location as $loc){

                                    $location_id = $loc->term_id;

                                    echo '<span>'.$loc->name.'</span>';

                                    if( next( $location ) ) {

                                        echo ", ";

                                    }

                                } ?>

                            </div>

                        <?php 

                        }

                    ?>

                    <div class="share-job">

                        <h3>Chia sẻ</h3>

                        <?php echo do_shortcode('[icon_share_network]');?>

                    </div>

                    <?php 

                        global $post;

                        

                        $the_query = new WP_Query( array(

                            'post_type' 		=> 'recruitment',

                            'posts_per_page' 	=> 5,

                            'post__not_in' 		=> array( $post->ID ),

                        ));

                        if( $the_query->have_posts() ) :

                            echo '<div class="related-recruitment">';

                                echo '<h4 class="fs-20 mb-16">Công việc liên quan</h4>';

                                echo '<ul>';

                                    while( $the_query->have_posts() ) : $the_query->the_post();

                                        $working = get_field('hinh_thuc_cong_viec');
                                        $location = get_the_terms(get_the_ID(), 'location_cat');
                                        $salary = get_the_terms(get_the_ID(), 'salary_cat');
                                        echo '<li>';

                                            echo '<h3>';

                                                echo '<a href="' . get_the_permalink() .'" title="' . get_the_title() . '">' . get_the_title() . '</a>';

                                                echo '<div class="info-job">';

                                                if($working){

                                                    echo '<div class="job">'.$working.'</div>';

                                                }

                                                if(!empty($location)){ ?>

                                                    <div class="job">

                                                        <?php foreach($location as $loc){

                                                            $location_id = $loc->term_id;

                                                            echo $loc->name;

                                                            if( next( $location ) ) {

                                                                echo ", ";

                                                            }

                                                        } ?>

                                                    </div>

                                                <?php 

                                                }


                                                if(!empty($salary)){
                                                    echo '<div class="job">';
                                                        foreach($salary as $sl){
                                                            echo '<span>'.$sl->name.'</span>';
                                                        }
                                                    echo '</div>';
                                                }else{
                                                    echo '<div class="job">Thoả thuận</div>';
                                                }
                                                echo '</div>';

                                            echo '</h3>';

                                            echo '<a href="'.get_the_permalink().'" class="readmore-recruitment"></a>';       

                                        echo '</li>';

                                    endwhile;

                                echo '</ul>';

                            echo '</div>';

                        endif;

                        wp_reset_postdata();

                        

                    ?>

                </div>

            </div>
        </div>
    </div>
</div>