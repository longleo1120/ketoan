<?php
function remove_footer_admin()
{
    echo '<span id="footer-thankyou">Developed by <a href="https://a2ztech.vn">A2Z Tech</a></span>';
}

add_filter('admin_footer_text', 'remove_footer_admin');

add_action('admin_bar_menu', 'add_top_link_to_admin_bar', 1);
function add_top_link_to_admin_bar($admin_bar)
{
    // add a parent item
    $args = array(
        'id' => 'a2ztech',
        'title' => 'A2Z Tech',
        'href' => 'https://a2ztech.vn/', // Showing how to add an external link
    );
    $admin_bar->add_node($args);

    // add a child item to our parent item
    $args = array(
        'parent' => 'a2ztech',
        'id' => 'a2z-home',
        'title' => 'Trang chủ',
        'href' => 'https://a2ztech.vn/',
        'meta' => false
    );
    $admin_bar->add_node($args);

    // add a child item to our parent item
    $args = array(
        'parent' => 'a2ztech',
        'id' => 'a2z-support',
        'title' => 'Hỗ trợ',
        'href' => 'https://crm.a2ztech.vn',
    );
    $admin_bar->add_node($args);
}

// Logo login
function tp_custom_logo()
{ 
$logo = 'https://a2ztech.vn/wp-content/themes/a2ztech/assets/img/logo-a2ztech.png';
if (wp_get_attachment_image_src( flatsome_option( 'site_logo' ), 'large' ) && wp_get_attachment_image_src( flatsome_option( 'site_logo' ), 'large' )[0]) 
    $logo = wp_get_attachment_image_src( flatsome_option( 'site_logo' ), 'large' )[0];
?>
<style type="text/css">
#login h1 a {
    background-image: url(<?php echo $logo; ?>);
    background-size: contain;
    width: 100%;
    height: 100px;
    margin: 0;
}
</style>
<?php }
add_action('login_enqueue_scripts', 'tp_custom_logo');


function remove_admin_bar_links()
{
    global $wp_admin_bar;

    $wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');         // Remove the comments link
    $wp_admin_bar->remove_menu('wp-logo');          // Remove the comments link
}

add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');

//* Hide this administrator account from the users list
add_action('pre_user_query', 'dt_pre_user_query');
function dt_pre_user_query($user_search)
{
    global $current_user;
    $username = $current_user->user_login;

    if ($username != 'a2ztech_admin') {
        global $wpdb;
        
    }
}

function remove_menus(){  
    global $current_user;
    $username = $current_user->user_login;

    if ($username != 'a2ztech_admin') {
        //remove_menu_page( 'themes.php' );               
        //remove_menu_page( 'plugins.php' );             
        // remove_menu_page( 'options-general.php' );      
        // remove_menu_page( 'edit-comments.php' );   
        // remove_menu_page( 'tools.php' );
        //remove_menu_page( 'edit.php?post_type=blocks' );   
    }
}  
add_action( 'admin_menu', 'remove_menus' );  

//add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
  
function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget', 'Bạn cần hỗ trợ?', 'custom_dashboard_help');
}
 
function custom_dashboard_help() {
	echo '<h2>Công ty TNHH Công nghệ A2Z</h2>';
	echo '<p>Website: <a href="https://a2ztech.vn">https://a2ztech.vn</a></p>';
	echo '<p>Hotline: <a href="tel:0829985588">082.998.55.88</a></p>';
	echo '<p>Hướng dẫn sử dụng: <a href="https://docs.a2ztech.vn">Truy cập trang hướng dẫn</a></p>';
}
