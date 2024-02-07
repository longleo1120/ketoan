<?php
define('PARENT_THEME', get_template_directory() . '/inc/builder/shortcodes');

// Functions
include 'functions/auto-save-image.php';
include 'functions/custom_menu_block.php';
include 'functions/a2ztech_admin.php';


// Functions
include 'post-types/recruitment.php';
include 'post-types/service.php';
include 'post-types/document.php';
include 'post-types/question.php';
include 'post-types/stores.php';

// Functions
include 'shortcodes/ux_recruitment.php';
include 'shortcodes/ux_service.php';
include 'shortcodes/ux_client.php';
include 'shortcodes/ux_store.php';
include 'shortcodes/ux_breadcrumb.php';
include 'shortcodes/ux_blogpost.php';


// Widget
include 'widget/wg-post-news.php';
include 'widget/news_document.php';
include 'widget/list_category.php';
// include 'widget/wg-share.php';
 
if ( function_exists( 'add_image_size' ) ) { 
    
	// add_image_size( 'index_slider_banner_2k', 2560, 1408, false);
	// add_image_size( 'index_slider_banner_fhd', 1920, 1056, false);
	// add_image_size( 'index_slider_banner_hd', 1366, 751, false);

	// add_image_size( 'index_product', 500, 500, false);

     
	// //add_image_size( 'index_slider_banner_mobile', 390, 736, false);
	// add_image_size( 'index_slider_banner_mobile', 480, 480, false);
    

}

add_action( 'after_setup_theme', 'a2z_setup' );
if ( ! function_exists( 'a2z_setup' ) ):
    function a2z_setup() {
        register_nav_menu( 'menu-category', __('Menu Chuyên Mục') );
        
    }
endif;



add_action('init', 'do_output_buffer');
function do_output_buffer() {
        ob_start();
} 

add_action('wp_head', 'a2z_ajaxurl');
function a2z_ajaxurl()
{
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

function debug($var){
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}


function add_acf_option_page() {
    if( function_exists('acf_add_options_page') ) {
      
        acf_add_options_page(array(
            'page_title'  => 'Option Global',
            'menu_title'  => 'Global Options',
            'menu_slug'   => 'theme-general-settings',
            'capability'  => 'edit_posts',
            'redirect'    => false
        ));
        
    
  
    }
}
add_action('acf/init', 'add_acf_option_page' );


add_filter('wpcf7_autop_or_not', '__return_false');
  

// custom css and js
add_action('admin_enqueue_scripts', 'my_scripts_method');
function my_scripts_method()
{
    wp_enqueue_style('boot_css', get_stylesheet_directory_uri() . '/assets/admin.css');
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/admin.js', array('jquery'), 1.1, true);
}

add_filter('use_block_editor_for_post', '__return_false', 10);
add_action('login_head', 'my_scripts_method');

function add_theme_scripts() {
    $rand = rand(0,999);
    wp_enqueue_script( 'js-slick', get_stylesheet_directory_uri() . '/assets/js/slick.js', array ( 'jquery' ), '1.'.$rand, true);
    wp_enqueue_script( 'js-custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array ( 'jquery' ), '1.'.$rand, true);
    wp_enqueue_script( 'js-client', get_stylesheet_directory_uri() . '/assets/client.js', array ( 'jquery' ), '1.'.$rand, true);
   
    wp_enqueue_style( 'css-custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), '1.'.$rand );
    wp_enqueue_style( 'css-phung', get_stylesheet_directory_uri() . '/assets/css/phung.css', array(), '1.'.$rand );
    wp_enqueue_style( 'css-sm', get_stylesheet_directory_uri() . '/assets/css/style-sm.css', array(), '1.'.$rand );
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/assets/css/slick.css', array(), '1.'.$rand );
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts', 99 );

add_action( 'wp_footer', 'popup_apply_job');
function popup_apply_job(){
    $current_date = date('d/m/Y');
    $thoi_han_nop = get_field('han_nop_don');
    $working = get_field('hinh_thuc_cong_viec');
    $location = get_the_terms(get_the_ID(), 'location_cat');
    $site_logo_id        = flatsome_option( 'site_logo' );
    $favicon_logo_id        = flatsome_option( 'site_icon' );
    $site_logo           = wp_get_attachment_image_src( $site_logo_id, 'large' );
    $favicon_logo           = wp_get_attachment_image_src( $favicon_logo_id, 'large' );
    ?>
    <?php 
        if($thoi_han_nop >= $current_date) { 
        if(is_singular( 'recruitment' )){ 
        ?>
        <div id="popup_apply_job" class="lightbox-by-id lightbox-content mfp-hide lightbox-white" style="max-width:644px ;padding:32px;">
            <div class="form-head">
            <?php //echo '<a href="'.home_url().'"><img src="' . esc_url( $favicon_logo[0] ) . '" class="header_logo header-logo"/></a>';?>
            <p class="maintitle"><?php the_title();?></p>
            <?php
                echo '<div class="related-recruitment">';
                    echo '<div class="info-job">';
                        echo '<div class="job fw-700">KETOANTRUONGTHANH</div>';
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
                        if($working){
                            echo '<div class="job">'.$working.'</div>';
                        }
                    echo '</div>';
                echo '</div>';
            ?>
            </div>
            <p class="mb-0 fw-600"><span style="font-size: 24px; color: #151A30;">Gửi đơn đăng ký của bạn</span></p>
            <p><span style="font-size: 16px; color: #97A3B7;">Nội dung sau là bắt buộc và sẽ chỉ được chia sẻ với <b>KETOANTRUONGTHANH</b></span></p>
            <?php echo do_shortcode('[contact-form-7 id="1164" title="Form ứng tuyển"]');?>
        </div>
    <?php } }?>
    <?php
}

add_shortcode('design_by_a2z','design_by_a2z');
function design_by_a2z(){
    ob_start();
    ?>
    <div class="icon-box featured-box icon-box-right text-right align-middle copy-a2z">
        <div class="icon-box-img" style="width: 160px">
            <div class="icon">
                <div class="icon-inner">
                    <img width="259" height="80" src="<?php echo get_stylesheet_directory_uri();?>/assets/img/logo-a2z.svg" class="attachment-medium size-medium pt-0" alt="" decoding="async" loading="lazy"></div>
            </div>
        </div>
        <div class="icon-box-text last-reset">
            <p style="color: ##555555;">Thiết kế và vận hành bởi</p>
        </div>
	</div>
    <?php 
    return ob_get_clean();
}

add_action('flatsome_blog_post_before', 'cat_post_before_title');
function cat_post_before_title(){
    global $post;
    $cat = get_the_category($post->ID);
    foreach($cat as $key => $value){
        if(is_front_page()){
            if($key == 0){
                echo '<div class="cat-post">';
                    echo '<a href="' . esc_url( get_category_link( $value->term_id ) ) . '">'.$value->cat_name.'</a>';
                    echo '<div class="post-news-date">'.get_the_date('d.m.Y').'</div>';
                echo '</div>';
            }
        }
    }
    if(!is_front_page() && !is_single()){
    }
}

add_action('flatsome_blog_post_after', 'btn_view_post');
function btn_view_post(){
    global $post;
    if(!is_front_page() && !is_single()){
        echo '<button href="' . get_the_permalink($post->ID) . '" class="btn-reamore"><span>Xem chi tiết</span></button>';
    }
}
add_action('flatsome_after_header', 'banner_after_header');
function banner_after_header(){
    if(!is_front_page() && !is_page(10) && !is_post_type_archive('document') && !is_tax()) :
    ?> 
    <section class="section" id="section_1899995687">
		<div class="bg section-bg fill bg-fill bg-loaded">
	    </div>
		<div class="section-content relative">
            <div class="banner has-hover" id="banner-428834609">
                <div class="banner-inner fill">
                    <div class="banner-bg fill">
                        <div class="bg fill bg-fill bg-loaded"></div>           
                    </div>
                    <div class="ux-shape-divider ux-shape-divider--bottom ux-shape-divider--style-waves-opacity ux-shape-divider--flip">
                        <svg viewBox="0 0 1000 300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path class="ux-shape-fill" d="M0 300L-1 69.71C216 57 299.47 198.86 403 226C506 253 577 196 660 197C740 198 790.09 234.07 874 267C935.23 291 982 282.61 1000 277.61V300H0Z"></path>
                            <path class="ux-shape-fill" opacity="0.5" d="M1 265.094L0 50.5C217 37.79 300.47 186.36 404 213.5C507 240.5 578 196.5 661 197.5C741 198.5 787.59 239.57 871.5 272.5C932.73 296.5 980.5 284.5 998.5 279.5V298.5L1 265.094Z"></path>
                            <path class="ux-shape-fill" opacity="0.15" d="M0.999878 244.094L-0.00012207 27C217 14.29 300.47 173.86 404 201C507 228 578 196 661 197C741 198 787.59 243.07 871.5 276C932.73 300 980.5 284.5 998.5 279.5V299L0.999878 244.094Z"></path>
                        </svg>
                    </div>
                    <div class="banner-layers container">
                    <div class="fill banner-link"></div>            
                    <div id="text-box-1694898497" class="text-box banner-layer x50 md-x50 lg-x50 y50 md-y50 lg-y50 res-text">
                        <div class="text-box-content text dark">
                            <div class="text-inner text-center">
                                <h3 class="page-title">
                                    <?php if(is_post_type_archive('service')){
                                        echo('DỊCH VỤ CỦA CHÚNG TÔI');
                                    }else if(is_post_type_archive('question')){
                                        echo('ĐẶT CÂU HỎI CHO CHÚNG TÔI');
                                    }else if(is_post_type_archive('recruitment')){
                                        echo('Tham gia với chúng tôi, trở thành một phần của Trường Thành');
                                    } else {
                                        the_title();
                                    };
                                    ?>
                                </h3>
                                <?php if(is_singular('service')) : ?>
                                    <div class="box-text-single">
                                        <p>Cùng đồng hành mọi lúc mọi nơi cùng các cá nhân, doanh nghiệp là điều mà chúng tôi luôn luôn khao khát.</p>
                                        <a href="#form-dangky" class="button primary lowercase btn-call mr-0 ml-half" style="border-radius:10px;">
                                            <span>Liên hệ tư vấn ngay</span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>               
                        <style>
                        #text-box-1694898497 {
                        width: 60%;
                        }
                        #text-box-1694898497 .text-box-content {
                        font-size: 100%;
                        }
                        </style>
                    </div>
                </div>
            </div>
            <style>
            #banner-428834609 {
            padding-top: 500px;
            background-color: rgba(255, 255, 255, 0);
            }
            #banner-428834609 .bg.bg-loaded {
            background-image: url(https://ketoantruongthanh.a2ztech.vn/wp-content/uploads/2024/02/Header-Banner-1024x356.png);
            }
            #banner-428834609 .ux-shape-divider--top svg {
            height: 150px;
            --divider-top-width: 100%;
            }
            #banner-428834609 .ux-shape-divider--bottom svg {
            height: 150px;
            --divider-width: 100%;
            }
            </style>
        </div>
	</div>
    <style>
    #section_1899995687 {
    padding-top: 0px;
    padding-bottom: 0px;
    }
    #section_1899995687 .ux-shape-divider--top svg {
    height: 150px;
    --divider-top-width: 100%;
    }
    #section_1899995687 .ux-shape-divider--bottom svg {
    height: 150px;
    --divider-width: 100%;
    }
    </style>
</section>
    <?php endif;
}
add_action('flatsome_after_header', 'breadcrumb_after_header');
function breadcrumb_after_header(){
    if (function_exists('rank_math_the_breadcrumbs') && !is_front_page() && !is_page(10)){
        echo '<div class="container">';
            echo rank_math_the_breadcrumbs();
        echo '</div>';
    }
}

function remove_comment_form( $comment_template ) {
    if ( is_single() ) {
        // Disable comment form on all post types
        add_filter( 'comments_open', '__return_false', 20, 2 );
        return '';
    }
    return $comment_template;
}

add_filter( 'comments_template', 'remove_comment_form' );

add_shortcode( 'icon_share_network', 'icon_share_network' );
function icon_share_network(){
    ?>
        <div class="list-mxh">
            <a rel="noopener noreferrer nofollow" class="copy-link" title="<?php _e('Share on Link','flatsome'); ?>">
                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/icon-link.svg">
                <span class="tooltiptext">Sao chép</span>
            </a>
            <a href="https://www.facebook.com/sharer.php?u=<?php echo the_permalink(); ?>" data-label="Facebook" onclick="window.open(this.href,this.title,'width=500,height=500,top=300px,left=300px');  return false;" rel="noopener noreferrer nofollow" target="_blank" class="facebook" title="<?php _e('Share on Facebook','flatsome'); ?>" aria-label="<?php esc_attr_e( 'Share on Facebook', 'flatsome' ); ?>">
                <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/facebook.svg">
            </a>
        </div>
    <?php
}

add_action( 'flatsome_blog_recruitment_after', 'job_information');
function job_information() { 
    $working = get_field('hinh_thuc_cong_viec');
    $address = get_field('vi_tri_lam_viec');
    $salary = get_the_terms(get_the_ID(), 'salary_cat');
    $location = get_the_terms(get_the_ID(), 'location_cat');
    ?>
    <div class="job-infor">
        <?php
            if($working){
                echo '<div class="working-job"><span>Hình thức:</span>'.$working.'</div>';
            }
            if(!empty($location)){ ?>
                <div class="address-job">
                    <span>Vị trí:</span>
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
           
            if(!empty($salary)){ ?>
                <div class="salary-job"><span>Lương:</span>
                    <?php
                        foreach($salary as $sal){
                            echo $sal->name;
                        }
                    
                    ?>
                </div>
        <?php 
            }else{
                echo '<div class="salary-job"><span>Lương:</span>Thoả thuận</div>';
            }
        ?>
    </div>
<?php
}


function exclude_document($query) {
    // if (in_array ( $query->get('post_type'), array('document') )) {
    //     $query->set('posts_per_page', 12);
    // }

    if ( ! is_admin() && (is_post_type_archive( 'post' ) || is_category() || is_home()) && $query->is_main_query() ) {
        
            $ids_featured = array();
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => '3',
                'meta_key' => 'select_post_featured',                   
                'meta_value' => true,   
            ); $news = new WP_query($args);
                if($news->have_posts()):
                    while($news->have_posts()): $news->the_post(); 
                        array_push($ids_featured, get_the_ID());
                    endwhile;
                endif;wp_reset_query(); 

        if(!empty($ids_featured)){
            $query->set( 'post__not_in',$ids_featured);
            
        }
        

    }


}

add_action('pre_get_posts', 'exclude_document', 20 );

add_action( 'wp_ajax_save_apply_job', 'save_apply_job' );
add_action( 'wp_ajax_nopriv_save_apply_job', 'save_apply_job' );
function save_apply_job(){
    ob_start();
    $id_post = $_POST['data_id'];
    //$value_job = $_POST['value_job'];
    $current_number = get_field('number_applied_job',$id_post);
    debug($id_post.'- idpost');
    //update_post_meta( $id_post, 'number_applied_job', $current_number + 1 );
    update_field('number_applied_job', $current_number + 1, $id_post);

    $result = ob_get_clean();

    wp_send_json_success($result);  
    die();
}

$sidebar_left = array(
    'id' => 'sidebar-left',
    'before_widget' => '<div class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="widgettitle">',
    'after_title' => '</h2>',
    'name' => __('Sidebar left'),
);
register_sidebar($sidebar_left);

function type_img_url($id_post){
    $terms = get_the_terms( $id_post, 'document_type' );
    $img_type = get_stylesheet_directory_uri().'/assets/img/file.svg';
    if(!empty($terms)){
        foreach($terms as $term){
            if($term->slug == 'hinh-anh'){
                $img_type = get_stylesheet_directory_uri().'/assets/img/file.svg';
            }
            if($term->slug == 'video'){
                $img_type = get_stylesheet_directory_uri().'/assets/img/file.svg';
            }
            if($term->slug == 'tieng-viet'){
                $img_type = get_stylesheet_directory_uri().'/assets/img/file.svg';
            }
            if($term->slug == 'tieng-anh'){
                $img_type = get_stylesheet_directory_uri().'/assets/img/file.svg';
            }
        }
    }
    return $img_type;
}

function category_pre_get_posts( $query ) {


    if ( !is_admin() && ( is_post_type_archive( 'document' ) || is_tax('document_cat') || is_tax('document_type') ) && $query->is_main_query() ) {
        
        if(isset($_GET['chuyennganh']) && $_GET['chuyennganh'] != '' ): 
            $slug = $_GET['chuyennganh'];
            $id = explode('-',$slug);
            $id = end($id);
            $tax_query['relation'] = 'AND';
            $tax_query[] = array(
                array(
                    'taxonomy' => 'document_cat',
                    'field' => 'term_id',
                    'terms' => $id
                )
            );
            $query->set( 'tax_query', $tax_query ); 
        endif;// end if chuyennganh

        if(isset($_GET['theloai']) && $_GET['theloai'] != '' ): 
            $slug = $_GET['theloai'];
            $id = explode('-',$slug);
            $id = end($id);
            $tax_query['relation'] = 'AND';
            $tax_query[] = array(
                array(
                    'taxonomy' => 'document_type',
                    'field' => 'term_id',
                    'terms' => $id
                )
            );
            $query->set( 'tax_query', $tax_query ); 
            
        endif;// end if theloai
        $meta_query = array();

        if(isset($_GET['keyword']) && $_GET['keyword'] != '' ): 
            $query->set( 's', $_GET['keyword']); 
        endif;

        if(isset($_GET['keyword_avc']) && $_GET['keyword_avc'] != '' ): 
            $query->set( 's', $_GET['keyword_avc']); 
        endif;

        if(isset($_GET['s_author']) && $_GET['s_author'] != '' ): 
            $author_name_seach = $_GET['s_author'];
            
            $meta_query[] = array(
                'meta_key'  => 'author_document',
                'value'     => $author_name_seach,
                'compare'   => '='
            );
        endif; 

        if(isset($_GET['nam_xuatban']) && $_GET['nam_xuatban'] != '' ): 
            $year_nxb = $_GET['nam_xuatban'];
            $meta_query[] = array(
                'meta_key'  => 'namxuatban_doc',
                'value'     => $year_nxb,
                'compare'   => '='
            );
        endif;

        if(isset($_GET['name_nxb']) && $_GET['name_nxb'] != '' ): 
            $name_nxb = $_GET['name_nxb'];
            $meta_query[] = array(
                'meta_key'  => 'name_nxb',
                'value'     => $name_nxb,
//                 'type' => 'CHAR',
                'compare'   => '='
            );
        endif;

        if ($meta_query) {
            $meta_query['relation'] = 'AND';
            $query->set( 'meta_query', $meta_query ); 
        }
    }
   

}
add_action( 'pre_get_posts', 'category_pre_get_posts', 20 );

add_action('wp_ajax_nopriv_load_store_by_location','load_store_by_location');
add_action('wp_ajax_load_store_by_location','load_store_by_location');
function load_store_by_location(){
    // $id_province = $_POST['id_province'];
    // $id_ward = $_POST['id_ward'];
    $id_location = $_POST['id_location'];
   
    if($id_location != ''){
        $args = array(
            'post_type' => 'store',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID',
            'tax_query' => array(
                array(
                    'taxonomy' => 'store_cat',
                    'field'    => 'term_id',
                    'terms'    => $id_location,
                ),
            ),
        ); 

    }

        $news = new WP_query($args);
        if($news->have_posts()):
            while($news->have_posts()): $news->the_post();
                $address = get_field('address_store',get_the_ID());
                $hotline = get_field('hotline_store',get_the_ID());
                $open_store = get_field('house_open_store',get_the_ID());
            ?>
                <div class="item-store <?php echo ($i == 0) ? 'active' : '';    ?> store-<?php echo $i++; ?> " data-id="<?php echo get_the_ID(); ?>" data-lat="<?php the_field('latitude_store'); ?>" data-lng="<?php the_field('longitude_store'); ?>">
                    <div class="thumbnail">
                        <div class="image-cover">
                            <?php the_post_thumbnail(); ?>
                        </div>
                    </div>
                    <div class="content">
                        <h4><?php the_title(); ?></h4>
                        <ul>
                            <?php
                                if($address){
                                    echo '<li><span>'.$address.'</span></li>';
                                }
                                if($hotline){
                                    echo '<li><a href="tel:'.$hotline.'">'.$hotline.'</a></li>';
                                }
                                if($open_store){
                                    echo '<li><span>'.$open_store.'</span></li>';
                                }
                            ?>
                        </ul>
                        <textarea name="" class="hidden iframe-textarea" id="" cols="30" rows="10"><?php the_field('map_store'); ?></textarea>
                    </div>  
                    
                </div>             
            <?php endwhile; ?>
        <?php endif;wp_reset_query(); 
    
    
    die();
}

add_action('wp_ajax_nopriv_load_ward_location','load_ward_location');
add_action('wp_ajax_load_ward_location','load_ward_location');
function load_ward_location(){
    $id_province = $_POST['id_province'];
    
    if($id_province != ''){
        $terms = get_terms( array(  'taxonomy' => 'store_cat',  'parent'   => $id_province,'hide_empty' => false) );
        if(!empty($terms)){
            echo '<option value="">Chọn quận/ huyện</option>';
            foreach($terms as $term){
                echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
            }
        }
    }

    die();
}

add_action('wp_ajax_nopriv_load_store_nearby','load_store_nearby');
add_action('wp_ajax_load_store_nearby','load_store_nearby');
function load_store_nearby(){
    // $id_province = $_POST['id_province'];
    // $id_ward = $_POST['id_ward'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
   
    if($lat != '' && $lng != ''){
        $args = array(
            'post_type' => 'store',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID',
        ); 

        $list_store = array();

        $news = new WP_query($args);
        if($news->have_posts()):
            while($news->have_posts()): $news->the_post(); 
                $idp = get_the_ID();
                $lat_store = get_field('latitude_store',$idp);
                $lng_store = get_field('longitude_store',$idp);
                $kilomet = caculator_km_store($lat,$lng,$lat_store,$lng_store);
                $list_store[$idp] = $kilomet;
            ?>
                
            <?php endwhile; ?>
        <?php endif;wp_reset_query(); 
       
        if(!empty($list_store)){
            asort($list_store);
            $i = 0;
            $kilomet_x =  number_format($list_store[array_key_first($list_store)],0,',','');
           
            if((float)$kilomet_x < (float)10){
                foreach($list_store as $key => $kilomet_store){
                    $i++;
                    if($kilomet_store < (float)10):
                    ?>
                    <div class="item-store <?php echo ($i == 1) ? 'active' : '';    ?> store-<?php echo $i; ?> " data-id="<?php echo $key; ?>" data-lat="<?php echo get_field('latitude_store',$key); ?>" data-lng="<?php echo get_field('longitude_store',$key); ?>">
                        <div class="thumbnail">
                            <img src="<?php echo get_the_post_thumbnail_url($key); ?>" alt="">
                        </div>
                        <div class="content">
                            <h4><a href="#" ><?php echo get_the_title($key); ?></a></h4>
                            <div class="address"><?php echo get_field('address_store',$key); ?></div>
                            <?php
                                if(get_field('hotline_store',$key) != ''){
                                    echo '<div class="hotline">HotLine: '.get_field('hotline_store',$key).'</div>';
                                }
                                if(get_field('hotline_store',$key) != ''){
                                    echo '<div class="hotline">Giờ mở cửa: '.get_field('house_open_store',$key).'</div>';
                                }
                            ?>
                            <div class="group-with-km">
                                <a href="<?php echo get_permalink($key); ?>" class="detail-store" >Chi tiết</a>
                                <a href="tel:0971615775" class="detail-store" >Gọi ngay</a>
                                <span><?php echo number_format($kilomet_store,2,',',''); ?> km</span>
                            </div>
                            
                            <textarea name="" class="hidden iframe-textarea" id="" cols="30" rows="10"><?php echo get_field('map_store',$key); ?></textarea>
                        </div>  
                        
                    </div>                        
                    <?php 
                    endif;
                }
            }else{
                foreach($list_store as $key => $kilomet_store){
                    $i++;
                    if($i < 6):
                    ?>
                    <div class="item-store <?php echo ($i == 1) ? 'active' : '';    ?> store-<?php echo $i; ?> " data-id="<?php echo $key; ?>" data-lat="<?php echo get_field('latitude_store',$key); ?>" data-lng="<?php echo get_field('longitude_store',$key); ?>">
                        <div class="thumbnail">
                            <img src="<?php echo get_the_post_thumbnail_url($key); ?>" alt="">
                        </div>
                        <div class="content">
                            <h4><a href="#" ><?php the_title(); ?></a></h4>
                            <div class="address"><?php echo get_field('address_store',$key); ?></div>
                            <?php
                                if(get_field('hotline_store',$key) != ''){
                                    echo '<div class="hotline">HotLine: '.get_field('hotline_store',$key).'</div>';
                                }
                                if(get_field('hotline_store',$key) != ''){
                                    echo '<div class="hotline">Giờ mở cửa: '.get_field('house_open_store',$key).'</div>';
                                }
                            ?>
                            <div class="group-with-km">
                                <a href="<?php echo get_permalink($key); ?>" class="detail-store" >Chi tiết</a>
                                <span><?php echo number_format($kilomet_store,2,',',''); ?> km</span>
                            </div>
                            
                            <textarea name="" class="hidden iframe-textarea" id="" cols="30" rows="10"><?php echo get_field('map_store',$key); ?></textarea>
                        </div>  
                        
                    </div>                        
                    <?php 
                    endif;
                }
            }
        }

    }else{
        echo 'Error';
    }

    die();
}

add_action('wp_ajax_nopriv_load_store_nearby_light_box','load_store_nearby_light_box');
add_action('wp_ajax_load_store_nearby_light_box','load_store_nearby_light_box');
function load_store_nearby_light_box(){
    // $id_province = $_POST['id_province'];
    // $id_ward = $_POST['id_ward'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
   
    if($lat != '' && $lng != ''){
        $args = array(
            'post_type' => 'store',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'ID',
        ); 

        $list_store = array();

        $news = new WP_query($args);
        if($news->have_posts()):
            while($news->have_posts()): $news->the_post(); 
                $idp = get_the_ID();
                $lat_store = get_field('latitude_store',$idp);
                $lng_store = get_field('longitude_store',$idp);
                $kilomet = caculator_km_store($lat,$lng,$lat_store,$lng_store);
                $list_store[$idp] = $kilomet;
            ?>
                
            <?php endwhile; ?>
        <?php endif;wp_reset_query(); 
       
        if(!empty($list_store)){
            asort($list_store);
            $i = 0;

            if($list_store[0] < 10){
                foreach($list_store as $key => $kilomet_store){
                    $i++;
                    if($kilomet_store < 10):
                    ?>
                    <div class="store-list-phone">
                        <div class="content">
                            <h4><a href="#" ><?php echo get_the_title($key); ?></a></h4>
                            <div class="hotline-and-call">
                                <?php
                                    if(get_field('hotline_store',$key) != ''){
                                        echo '<div class="hotline">HotLine: '.get_field('hotline_store',$key).'</div>';
                                    }
                                ?>
                                <a href="tel:<?php echo get_field('hotline_store',$key); ?>" class="detail-store" >Gọi ngay</a>
                            </div>
                            
                              
                        </div>  
                        
                    </div> 
                    <hr>                       
                    <?php 
                    endif;
                }
            }else{
                foreach($list_store as $key => $kilomet_store){
                    $i++;
                    if($i < 6):
                    ?>
                   <div class="store-list-phone">
                        <div class="content">
                            <h4><a href="#" ><?php echo get_the_title($key); ?></a></h4>
                            <div class="hotline-and-call">
                                <?php
                                    if(get_field('hotline_store',$key) != ''){
                                        echo '<div class="hotline">HotLine: '.get_field('hotline_store',$key).'</div>';
                                    }
                                ?>
                                    <a href="tel:<?php echo get_field('hotline_store',$key); ?>" class="detail-store" >Gọi ngay</a>
                            </div>
                        </div>  
                        
                    </div>   
                    <hr>                                          
                    <?php 
                    endif;
                }
            }
        }

    }else{
        echo 'Error';
    }

    die();
}

function list_store($thamso,$content)
{
    ob_start(); 
    
    	//$data = file_get_contents(get_stylesheet_directory_uri().'./data-demo.json',true);
    
    ?> 
        <div class="wrap-store-main">
            <div class="column-left">
                <div class="header-store-list">
                    <div class="main-title">
                        <p>PLACE</p>
                        <h2>HỆ THỐNG CƠ SỞ</h2>
                    </div>
                    <select name="province" id="province-store">
                        <option value="">Chọn tỉnh/ Thành phố</option>
                        <?php 
                            $quanhuyen = get_terms( array(  'taxonomy' => 'store_cat',  'parent'   => 0,'hide_empty' => false) );
                            if(!empty($quanhuyen)){
                                foreach($quanhuyen as $quan){
                                    echo '<option value="'.$quan->term_id.'">'.$quan->name.'</option>';
                                }
                            }
                        ?>

                    </select>
                    <select name="ward" id="ward-store">
                        <option value="">Chọn quận/ huyện</option>
                    </select>
                </div>
 
                <div class="list-store-item">
                    <?php 
                        $args = array(
                            'post_type' => 'store',
                            'posts_per_page' => -1,
                            'order' => 'DESC',
                            'orderby' => 'ID'
                        ); $news = new WP_query($args); ?>
                    <?php if($news->have_posts()): $i = 0;?> 
                        <?php while($news->have_posts()): $news->the_post(); 
                            $address = get_field('address_store',get_the_ID());
                            $hotline = get_field('hotline_store',get_the_ID());
                            $open_store = get_field('house_open_store',get_the_ID());
                        ?>
                                <div class="item-store <?php echo ($i == 0) ? 'active' : '';    ?> store-<?php echo $i++; ?> " data-id="<?php echo get_the_ID(); ?>" data-lat="<?php the_field('latitude_store'); ?>" data-lng="<?php the_field('longitude_store'); ?>">
                                    <div class="thumbnail">
                                        <div class="image-cover">
                                            <?php the_post_thumbnail(); ?>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <h4><?php the_title(); ?></h4>
                                        <ul>
                                            <?php
                                                if($address){
                                                    echo '<li><span>'.$address.'</span></li>';
                                                }
                                                if($hotline){
                                                    echo '<li><a href="tel:'.$hotline.'">'.$hotline.'</a></li>';
                                                }
                                                if($open_store){
                                                    echo '<li><span>'.$open_store.'</span></li>';
                                                }
                                            ?>
                                        </ul>
                                        <textarea name="" class="hidden iframe-textarea" id="" cols="30" rows="10"><?php the_field('map_store'); ?></textarea>
                                    </div>  
                                    
                                </div>                        
                        <?php endwhile; ?>
                    <?php endif;wp_reset_query(); ?>
                </div>

            </div>
            <div id="googleMap" class="column-right">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4304.105983608851!2d105.81916541955832!3d21.005115933658224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1665455648851!5m2!1svi!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
      
        

    <?php 
    $list = ob_get_clean();
    return $list;
}
add_shortcode( 'list_store', 'list_store' );