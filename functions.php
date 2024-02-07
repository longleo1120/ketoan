<?php

require get_stylesheet_directory() . '/inc/init.php';
require get_stylesheet_directory() . '/inc/ajax-all.php';



function caculator_km_store($lat_curent,$lng_curent,$lat_new,$lng_new){
    $latitude1 = $lat_curent; 
    $longitude1 = $lng_curent; 
    $latitude2 = $lat_new; 
    $longitude2 = $lng_new;  

    //Converting to radians
    $longi1 = deg2rad($longitude1); 
    $longi2 = deg2rad($longitude2); 
    $lati1 = deg2rad($latitude1); 
    $lati2 = deg2rad($latitude2); 

    //Haversine Formula 
    $difflong = $longi2 - $longi1; 
    $difflat = $lati2 - $lati1; 

    $val = pow(sin($difflat/2),2)+cos($lati1)*cos($lati2)*pow(sin($difflong/2),2); 

    $res1 =3936* (2 * asin(sqrt($val))); //for miles
    $res2 =6378.8 * (2 * asin(sqrt($val))); //for kilometers

    return $res2;

}

function get_site_logo() {
    $site_logo_id        = flatsome_option( 'site_logo' );
    $site_logo_sticky_id = flatsome_option( 'site_logo_sticky' );
    $site_logo_dark_id   = flatsome_option( 'site_logo_dark' );
    $site_logo           = wp_get_attachment_image_src( $site_logo_id, 'large' );
    $site_logo_sticky    = wp_get_attachment_image_src( $site_logo_sticky_id, 'large' );
    $site_logo_dark      = wp_get_attachment_image_src( $site_logo_dark_id, 'large' );
    $logo_link           = get_theme_mod( 'logo_link' );
    $logo_link           = $logo_link ? $logo_link : home_url( '/' );
    $width               = get_theme_mod( 'logo_width', 200 );
    $height              = get_theme_mod( 'header_height', 90 );
    ob_start();
    ?>
    <a href="<?php echo esc_url( $logo_link ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?><?php echo get_bloginfo( 'name' ) && get_bloginfo( 'description' ) ? ' - ' : ''; ?><?php bloginfo( 'description' ); ?>" rel="home">
        <?php
        if ( $site_logo ) {
            $site_title = esc_attr( get_bloginfo( 'name', 'display' ) );
            if ( $site_logo_sticky ) echo '<img width="' . esc_attr( $site_logo_sticky[1] ) . '" height="' . esc_attr( $site_logo_sticky[2] ) . '" src="' . esc_url( $site_logo_sticky[0] ) . '" class="header-logo-sticky" alt="'.$site_title.'"/>';
            echo '<img width="' . esc_attr( $site_logo[1] ) . '" height="' . esc_attr( $site_logo[2] ) . '" src="' . esc_url( $site_logo[0] ) . '" class="header_logo header-logo" alt="'.$site_title.'"/>';
            if ( $site_logo_dark ) echo '<img  width="' . esc_attr( $site_logo_dark[1] ) . '" height="' . esc_attr( $site_logo_dark[2] ) . '" src="' . esc_url( $site_logo_dark[0] ) . '" class="header-logo-dark" alt="'.$site_title.'"/>';
            else echo '<img  width="' . esc_attr( $site_logo[1] ) . '" height="' . esc_attr( $site_logo[2] ) . '" src="' . esc_url( $site_logo[0] ) . '" class="header-logo-dark" alt="'.$site_title.'"/>';
        } else {
            bloginfo( 'name' );
        }
        ?>
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('get_site_logo','get_site_logo');

function default_comments_on( $data ) {
    if( $data['post_type'] == 'document' ) {
        $data['comment_status'] = 1;
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'default_comments_on' );