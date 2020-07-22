<?php
/*
Plugin Name: Contest Gallery
Description: Professional photo contest gallery plugin for WordPress. Create image upload frontend forms. Create user registration frontend forms. Create responsive galleries and allow to vote images.
Version: 10.9.8.8.1
Author: Contest Gallery
Author URI: http://www.contest-gallery.com/
Text Domain: contest-gallery
Domain Path: /languages
*/
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);
error_reporting(E_STRICT);
define('WP_DEBUG',true);*/
/*define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);*/
//exit( var_dump( $wpdb->last_query ) ); auch eine möglichkeit

// Query debug example
//$wpdb->show_errors(); //setting the Show or Display errors option to true
//$wpdb->query();
//$wpdb->print_error();

/*add_filter( 'avatar_defaults', 'wpb_new_gravatar' );
function wpb_new_gravatar ($avatar_defaults) {
    $myavatar = 'http://example.com/wp-content/uploads/2017/01/wpb-default-gravatar.png';
    $avatar_defaults[$myavatar] = "Default Gravatar";
    return $avatar_defaults;
}*/

if(!defined('ABSPATH')){exit;}

if(!function_exists('cg_add_defer_to_cg_js_files')){
    function cg_add_defer_to_cg_js_files( $url)
    {
        if (strpos( $url, 'contest-gallery/v10/v10-js/' ) !== false)
        {
            return "$url' defer='defer";
        }
        return $url;
    }
}

add_filter( 'clean_url', 'cg_add_defer_to_cg_js_files');// clean url is available since 2.3 WP version

include('functions/general/cg-on-wp-mail-error.php');
include('functions/general/cg-create-json-files-when-activating.php');
include('functions/general/convert-values.php');
include('functions/frontend/cg-create-noscript-html.php');

if(!empty($_POST['cg_export_votes'])){

    if(is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && $_GET['page']=='contest-gallery/index.php'){

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if(is_plugin_active( 'contest-gallery/index.php' )==false){
            echo "Please contact site administrator if you see this, code 855";exit();
        }

        include('v10/v10-admin/export/export-votes.php');
        add_action('cg_votes_csv_export','cg_votes_csv_export');
        do_action('cg_votes_csv_export');

    }

}

if(!empty($_POST['contest_gal1ery_post_create_data_csv']) && !empty($_GET['edit_gallery']) && !empty($_GET['option_id']) && $_GET['page']=='contest-gallery/index.php'){

    if(is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && $_GET['page']=='contest-gallery/index.php'){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if(is_plugin_active( 'contest-gallery/index.php' )==false){
            echo "Please contact site administrator if you see this, code 856";exit();
        }

        include('v10/v10-admin/export/export-images-data.php');
        add_action('cg_images_data_csv_export','cg_images_data_csv_export');
        do_action('cg_images_data_csv_export');

        include('v10/v10-admin/export/controller.php');
        add_action('cg_remove_not_required_coded_csvs','cg_remove_not_required_coded_csvs');
        do_action('cg_remove_not_required_coded_csvs');

    }

}

if(!empty($_POST['cg_create_user_data_csv']) && !empty($_GET['users_management']) && !empty($_GET['option_id']) && $_GET['page']=='contest-gallery/index.php'){
    if(is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && $_GET['page']=='contest-gallery/index.php'){

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if(is_plugin_active( 'contest-gallery/index.php' )==false){
            echo "Please contact site administrator if you see this, code 857";exit();
        }

        if(!empty($_POST['cg_create_user_data_csv_new_export'])){
            include('v10/v10-admin/export/export-user-data-registry-new-export.php');
            add_action('cg_user_data_registry_csv_new_export','cg_user_data_registry_csv_new_export');
            do_action('cg_user_data_registry_csv_new_export');
        }else{
            include('v10/v10-admin/export/export-user-data-registry.php');
            add_action('cg_user_data_registry_csv_export','cg_user_data_registry_csv_export');
            do_action('cg_user_data_registry_csv_export');
        }

        include('v10/v10-admin/export/controller.php');
        add_action('cg_remove_not_required_coded_csvs','cg_remove_not_required_coded_csvs');
        do_action('cg_remove_not_required_coded_csvs');

    }

}

if(!empty($_POST['cg_action_check_and_download_mail_log_for_gallery'])){

    if(is_admin() && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) && $_GET['page']=='contest-gallery/index.php'){

        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

        if(is_plugin_active( 'contest-gallery/index.php' )==false){
            echo "Please contact site administrator if you see this, code 8561";exit();
        }

        include('v10/v10-admin/export/export-mail-log-data.php');

    }

}

//Create MySQL WP Table

// Register a new shortcode: [book]
add_shortcode( 'cg_gallery', 'contest_gal1ery_frontend_gallery' );
add_shortcode( 'cg_gallery_user', 'contest_gal1ery_frontend_gallery_user_images' );
add_shortcode( 'cg_gallery_no_voting', 'contest_gal1ery_frontend_gallery_no_voting' );
add_shortcode( 'cg_users_upload', 'contest_gal1ery_users_upload' );
add_shortcode( 'cg_mail_confirm', 'contest_gal1ery_check_confirmation_link' );// Achtung !!! Mail Confirm wird schon verwendet in users-upload-check

function contest_gal1ery_check_confirmation_link($atts){

    // PLUGIN VERSION CHECK HERE
    contest_gal1ery_db_check();

    extract( shortcode_atts( array(
        'id' => ''
    ), $atts ) );
    $galeryID = trim($atts['id']);

    $wp_upload_dir = wp_upload_dir();
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-options.json';

    ob_start();

    if(file_exists($optionsFile)){

        include('v10/v10-frontend/mail_confirm/mail_confirm_email_link.php');

    }
    else{

        $usedShortcode = 'cg_mail_confirm';

        include('prev10/information.php');

    }


    $mail_confirm = ob_get_clean();

    return $mail_confirm;

}

function contest_gal1ery_frontend_gallery($atts){

    // PLUGIN VERSION CHECK HERE

    contest_gal1ery_db_check();

    if(is_admin()){
        return '';
    }

    extract( shortcode_atts( array(
        'id' => ''
    ), $atts ) );
    $galeryID = trim($atts['id']);

    $frontend_gallery = '';

    $wp_upload_dir = wp_upload_dir();
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-options.json';

    if(file_exists($optionsFile)){

        $onlyLoggedInUserImages = false;

        $fp = fopen($optionsFile, 'r');
        $options =json_decode(fread($fp,filesize($optionsFile)),true);
        fclose($fp);
        include('v10/include-scripts-v10.php');

    }
    else{

        $usedShortcode = 'cg_gallery';


        include('prev10/information.php');

    }

    return $frontend_gallery;

}

function contest_gal1ery_frontend_gallery_user_images($atts){

    // PLUGIN VERSION CHECK HERE

    contest_gal1ery_db_check();

    if(is_admin()){
        return '';
    }

    extract( shortcode_atts( array(
        'id' => ''
    ), $atts ) );
    $galeryID = trim($atts['id']);

    $frontend_gallery = '';

    $wp_upload_dir = wp_upload_dir();
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-options.json';

    if(file_exists($optionsFile)){

        $onlyLoggedInUserImages = true;

        $fp = fopen($optionsFile, 'r');
        $options =json_decode(fread($fp,filesize($optionsFile)),true);
        fclose($fp);
        include('v10/include-scripts-v10.php');

    }
    else{

        $usedShortcode = 'cg_gallery_user';

        include('prev10/information.php');

    }

    return $frontend_gallery;

}

function contest_gal1ery_frontend_gallery_no_voting($atts){

    // PLUGIN VERSION CHECK HERE

    contest_gal1ery_db_check();

    if(is_admin()){
        return '';
    }

    extract( shortcode_atts( array(
        'id' => ''
    ), $atts ) );
    $galeryID = trim($atts['id']);

    $frontend_gallery = '';

    $wp_upload_dir = wp_upload_dir();
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-options.json';

    if(file_exists($optionsFile)){

        $isOnlyGalleryNoVoting = true;

        $fp = fopen($optionsFile, 'r');
        $options =json_decode(fread($fp,filesize($optionsFile)),true);
        fclose($fp);
        include('v10/include-scripts-v10.php');

    }
    else{

        $usedShortcode = 'cg_gallery_no_voting';

        include('prev10/information.php');

    }

    return $frontend_gallery;

}


function contest_gal1ery_users_upload($atts){

    // PLUGIN VERSION CHECK HERE

    contest_gal1ery_db_check();

    if(is_admin()){
        return '';
    }

    extract( shortcode_atts( array(
        'id' => ''
    ), $atts ) );
    $galeryID = trim(trim($atts['id']));

    $wp_upload_dir = wp_upload_dir();
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-options.json';

    global $wp_version;
    $sanitize_textarea_field = ($wp_version<4.7) ? 'sanitize_text_field' : 'sanitize_textarea_field';
    if(file_exists($optionsFile)){
        // PLUGIN VERSION CHECK HERE --- END

        wp_enqueue_script( 'jquery-ui-dialog' );
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_style( 'cg_contest_style',  plugins_url('/v10/v10-css/style.css', __FILE__), false, '10.9.8.8.1' );
        wp_enqueue_style( 'cg_datepicker_frontend',  plugins_url('/v10/v10-css/cg_datepicker_frontend.css', __FILE__), false, '10.9.8.8.1' );
        wp_enqueue_style( 'cg_form_style', plugins_url('/v10/v10-css/cg_form_style.css', __FILE__), false , '10.9.8.8.1' );
        wp_enqueue_style( 'cg_general_form_style', plugins_url('/v10/v10-css/cg_general_form_style.css', __FILE__), false , '10.9.8.8.1' );
        wp_enqueue_script( 'cg_js_general_frontend', plugins_url( '/v10/v10-js/general_frontend.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
        wp_enqueue_script( 'cg_js_upload_init_upload', plugins_url( '/v10/v10-js/upload/init-upload.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
        wp_enqueue_script( 'cg_js_upload_users_upload', plugins_url( '/v10/v10-js/upload/users_upload.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
        wp_enqueue_script( 'cg_gallery_form_upload_functions', plugins_url( '/v10/v10-js/gallery/upload/functions.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
        wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_function_message_show_message', plugins_url( '/v10/v10-js/gallery/function/message/message.js', __FILE__ ), array('jquery'), '10.9.8.8.1');
        // cg_v10_show_gallery_jquery_gallery_dynamic_options take care of order, have to be bottom. Do not rename, because will be also used for gallery same name (if both shortcodes are on the site)
        wp_enqueue_script( 'cg_v10_show_gallery_jquery_gallery_dynamic_options', plugins_url( '/v10/v10-js/gallery/dynamic-options.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

        ob_start();
        include('v10/v10-frontend/user_upload/users-upload.php');
        $users_upload = ob_get_clean();

        //apply_filters('cg_filter_users_upload', $users_upload);
    }
    else{

        $usedShortcode = 'cg_users_upload';

        include('prev10/information.php');

    }

    return $users_upload;

}


include('functions/general/sql/contest-gallery-create-tables.php');

register_activation_hook( __FILE__, 'contest_gal1ery_db_check' );

include('functions/general/contest-gallery-db-version-check.php');


// Update DB


// Update DB - END







// Add a top level menu to wordpress

// page_title â€” The title of the page as shown in the <title> tags
// menu_title â€” The name of your menu displayed on the dashboard
// capability â€” Minimum capability required to view the menu
// menu_slug â€” Slug name to refer to the menu; should be a unique name
// function : Function to be called to display the page content for the item
// icon_url â€” URL to a custom image to use as the Menu icon
// position â€” Location in the menu order where it should appear

//create submenu items

// parent_slug : Slug name for the parent menu ( menu_slug previously defi ned)
// page_title : The title of the page as shown in the <title> tags
// menu_title : The name of your submenu displayed on the dashboard
// capability : Minimum capability required to view the submenu
// menu_slug : Slug name to refer to the submenu; should be a unique name
// function : Function to be called to display the page content for the item


/*

add_action( 'wp_enqueue_scripts', 'ajax_test_enqueue_scripts1' );
if(!function_exists('ajax_test_enqueue_scripts1')){
function ajax_test_enqueue_scripts1() {
	if( is_single() ) {
		wp_enqueue_style( 'love1', plugins_url( '/love1.css', __FILE__ ) );
	}

	wp_enqueue_script( 'cg_rate', plugins_url( '/cg_rate2.js', __FILE__ ), array('jquery'), '1.0', true );

	wp_localize_script( 'cg_rate', 'postlove1', array(
		'ajax_url1' => admin_url( 'admin-ajax.php' )
	));

}
}*/

// Register CSS



add_action( 'wp_ajax_nopriv_post_cg_rate_v10_oneStar', 'post_cg_rate_v10_oneStar' );
add_action( 'wp_ajax_post_cg_rate_v10_oneStar', 'post_cg_rate_v10_oneStar' );

function post_cg_rate_v10_oneStar() {

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        require_once('v10/v10-frontend/data/rating/rate-picture-one-star.php');

        exit();
    }
    else {
        exit();
    }
}

add_action( 'wp_ajax_nopriv_post_cg_rate_v10_fiveStar', 'post_cg_rate_v10_fiveStar' );
add_action( 'wp_ajax_post_cg_rate_v10_fiveStar', 'post_cg_rate_v10_fiveStar' );

function post_cg_rate_v10_fiveStar() {

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        require_once('v10/v10-frontend/data/rating/rate-picture-five-star.php');

        exit();
    }
    else {
        exit();
    }
}

// AJAX Script für rate picture ---- ENDE

// Add image gallery form upload

add_action( 'wp_ajax_nopriv_post_cg_gallery_form_upload', 'post_cg_gallery_form_upload' );
add_action( 'wp_ajax_post_cg_gallery_form_upload', 'post_cg_gallery_form_upload' );

function post_cg_gallery_form_upload() {

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        include('v10/v10-frontend/user_upload/users-upload-check.php');

        exit();
    }
    else {
        exit();
    }
}

// Add image gallery form upload ---- END

// Remove image user gallery

add_action( 'wp_ajax_nopriv_post_cg_gallery_user_delete_image', 'post_cg_gallery_user_delete_image' );
add_action( 'wp_ajax_post_cg_gallery_user_delete_image', 'post_cg_gallery_user_delete_image' );

function post_cg_gallery_user_delete_image() {

    if(!is_user_logged_in()){
        return;
    }

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        include('v10/v10-frontend/gallery/gallery-user-delete-image.php');

        exit();
    }
    else {
        exit();
    }
}

// Remove image user gallery ---- END

// Remove image user gallery

add_action( 'wp_ajax_nopriv_post_cg_changes_recognized', 'post_cg_changes_recognized' );
add_action( 'wp_ajax_post_cg_changes_recognized', 'post_cg_changes_recognized' );

function post_cg_changes_recognized() {

    if(!is_user_logged_in()){
        return;
    }

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        include('v10/v10-frontend/gallery/changes-recognized.php');

        exit();
    }
    else {
        exit();
    }
}

// Remove image user gallery ---- END

// view control backend

add_action( 'wp_ajax_post_cg_gallery_view_control_backend', 'post_cg_gallery_view_control_backend' );

function post_cg_gallery_view_control_backend() {

    $isBackendCall = true;
    $isAjaxCall = true;
    $isAjaxGalleryCall = true;

    global $wp_version;
    $sanitize_textarea_field = ($wp_version<4.7) ? 'sanitize_text_field' : 'sanitize_textarea_field';

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        $user = wp_get_current_user();

        if (
            is_super_admin($user->ID) ||
            in_array( 'administrator', (array) $user->roles ) ||
            in_array( 'editor', (array) $user->roles ) ||
            in_array( 'author', (array) $user->roles )
        ) {

            if(!empty($isBackendCall)){

                if(empty($_POST['cgGalleryHash'])){
                    echo 0;die;
                }else{

                    $galleryHash = $_POST['cgGalleryHash'];
                    $galleryHashDecoded = wp_salt( 'auth').'---cngl1---'.$_POST['cg_id'];
                    $galleryHashToCompare = md5($galleryHashDecoded);

                    if ($galleryHash != $galleryHashToCompare){
                        echo 0;die;
                    }

                }

            }

            include('v10/v10-admin/gallery/gallery.php');

        }else{
            echo "<h2>MISSINGRIGHTS<br>This area can be edited only as administrator, editor or author.</h2>";
            exit();
        }

        exit();
    }
    else {
        exit();
    }
}

// view control backend ---- END

// view control backend

add_action( 'wp_ajax_post_cg_gallery_save_categories_changes', 'post_cg_gallery_save_categories_changes' );

function post_cg_gallery_save_categories_changes() {

    $isBackendCall = true;
    $isAjaxCall = true;

    $isAjaxCategoriesCall = true;


    global $wp_version;
    $sanitize_textarea_field = ($wp_version<4.7) ? 'sanitize_text_field' : 'sanitize_textarea_field';


    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        $user = wp_get_current_user();

        if (
            is_super_admin($user->ID) ||
            in_array( 'administrator', (array) $user->roles ) ||
            in_array( 'editor', (array) $user->roles ) ||
            in_array( 'author', (array) $user->roles )
        ) {
            include('v10/v10-admin/gallery/save-categories-changes.php');
        }else{
            echo "<div id='cgSaveCategoriesCouldNotBeChanged'><h2>MISSINGRIGHTS<br>This area can be edited only as administrator, editor or author.</h2></div>";
            exit();
        }

        exit();
    }
    else {
        exit();
    }
}

// view control backend ---- END


// AJAX Script für set comment ---- ENDE


// AJAX Script für set comment Slider ---- ENDE
/*
add_action( 'wp_ajax_nopriv_post_cg_set_comment_v10', 'post_cg_set_comment_v10' );
add_action( 'wp_ajax_post_cg_set_comment_v10', 'post_cg_set_comment_v10' );
function post_cg_set_comment_v10() {

	global $wpdb;

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

		require_once('v10/v10-frontend/data/comment/set-comment-v10.php');
		die();

	}
	else {

		exit();
	}
}*/


// AJAX Script für set comment Slider ---- ENDE


// AJAX Script show comment Slider or out of Gallery





add_action( 'wp_ajax_nopriv_cg_show_set_comments_v10', 'cg_show_set_comments_v10' );
add_action( 'wp_ajax_cg_show_set_comments_v10', 'cg_show_set_comments_v10' );

function cg_show_set_comments_v10(){

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        require_once('v10/v10-frontend/data/comment/show-set-comments-v10.php');
        exit();

    }
    else {

        exit();
    }

}


// AJAX Script show comment Slider or out of Gallery ---- ENDE




// init languages

if(!function_exists('contest_gallery_init_languages')){
    function contest_gallery_init_languages() {

        $folderName = (basename(dirname(__FILE__))=='trunk') ? 'contest-gallery' :  basename(dirname(__FILE__)); // check if offline development
        load_plugin_textdomain( 'contest-gallery', false, $folderName . '/languages/' );

    }
}
add_action('plugins_loaded', 'contest_gallery_init_languages');


// init languages --- ENDE


// localize Scripts --- ENDE


add_action('admin_menu', 'contest_gallery_add_page');
if(!function_exists('contest_gallery_add_page')){
    function contest_gallery_add_page() {
        add_menu_page( 'Contest Gallery', 'Contest Gallery', 'edit_posts', __FILE__, 'contest_gallery_action', plugins_url('v10/v10-css/star_48_reduced.png', __FILE__ ));
    }
}


// WP Media Upload wird hier aktiviert!!!!!
if (is_admin ()){
    add_action ( 'admin_enqueue_scripts', 'wp_enqueue_media');
}
// WP Media Upload wird hier aktiviert!!!!! ---- ENDE





// Prüfen ob eingeloggt und welche Role
if(!function_exists('cg_remove_admin_bar_links')){

    function cg_remove_admin_bar_links() {
        global $wp_admin_bar, $current_user;

        if(in_array("contest_gallery_user",$current_user->roles)==true){
            $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
            $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
            $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
            $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
            $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
            $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
            $wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
            $wp_admin_bar->remove_menu('view-site');        // Remove the view site link
            $wp_admin_bar->remove_menu('updates');          // Remove the updates link
            $wp_admin_bar->remove_menu('comments');         // Remove the comments link
            $wp_admin_bar->remove_menu('new-content');      // Remove the content link
            $wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
            $wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
            $wp_admin_bar->remove_menu('search');       // Remove the user details tab

            $AccountTitle = __("Account","contest-gallery");
            $LogoutTitle = __("Logout?","contest-gallery");

            $args = array(
                'id'    => 'contest_gallery_user_bar',
                'title' => "$AccountTitle: $current_user->display_name",
            );
            $wp_admin_bar->add_node($args);

            $args = array(
                'id'    => 'contest_gallery_user_bar_logout',
                'parent'    => 'contest_gallery_user_bar',
                'title' => $LogoutTitle,
                'href' => wp_logout_url(get_permalink())
            );
            $wp_admin_bar->add_node($args);       // Remove the user details tab
        }
    }

}
add_action( 'wp_before_admin_bar_render', 'cg_remove_admin_bar_links' );


// NOTE: Of course change 3 to the appropriate user ID
//$u = new WP_User( 106 );

// Remove role
//$u->remove_role( 'contest_gallery_user' );

// Add role
//$u->add_role( 'contest_gallery_user' );


// ----------------------------------------------------------- Pro Version Abschnitt ----------------------ENDE


//------------------------------------------------------------
// ----------------------------------------------------------- Hauptseite fÃ¼r hochgeladene Bilder ----------------------------------------------------------
//------------------------------------------------------------

include('functions/general/json-data/cg-json-single-view-order.php');
include('functions/general/json-data/cg-json-upload-form.php');
include('functions/general/json-data/cg-json-upload-form-info-data-files.php');
include('functions/general/sql/cg-copy-rating.php');
include('functions/general/sql/cg-copy-comments.php');
include('functions/general/cg-copy-pre7-gallery-images.php');
include('functions/general/cg-copy-fb-sites.php');
include('functions/general/cg-create-fb-html.php');
include('functions/general/cg-create-fb-sites.php');
include('functions/general/cg-create-exif-data.php');
include('functions/general/cg-get-user-ip.php');
include('functions/general/cg-delete-images.php');
include('functions/general/cg-plugin-mce-css-to-add.php');
include('functions/general/json-data/cg-actualize-all-images-data-info-file.php');
include('functions/general/json-data/cg-actualize-all-images-data-sort-values-file.php');
include('functions/general/json-data/cg-actualize-all-images-data-sort-values-file-set-array.php');
include('functions/general/json-data/cg-set-data-in-images-files-with-all-data.php');


add_action('cg_delete_files_and_folder','cg_delete_files_and_folder');

function cg_delete_files_and_folder($folderName){

    if(is_dir($folderName)){

        $folderContent = scandir($folderName);

        foreach ($folderContent as $item){
            if(is_file($folderName.'/'.$item)){
                unlink($folderName.'/'.$item);
            }
        }
        rmdir($folderName);

    }

}

// do not remove this!
include('v10/include-functions-v10.php');

//  add contest_gallery_action as ajax

// view control backend

add_action( 'wp_ajax_post_contest_gallery_action_ajax', 'post_contest_gallery_action_ajax' );

function post_contest_gallery_action_ajax() {

    $isBackendCall = true;
    $isAjaxCall = true;

    global $wp_version;
    $sanitize_textarea_field = ($wp_version<4.7) ? 'sanitize_text_field' : 'sanitize_textarea_field';

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        $user = wp_get_current_user();

        if (
            is_super_admin($user->ID) ||
            in_array( 'administrator', (array) $user->roles ) ||
            in_array( 'editor', (array) $user->roles ) ||
            in_array( 'author', (array) $user->roles )
        ) {

            if(!empty($isBackendCall)){
                if(empty($_POST['cgBackendHash'])){
                    echo 0;die;
                }else{

                    $cgBackendHashHash = $_POST['cgBackendHash'];
                    $cgBackendHashDecoded = wp_salt( 'auth').'---cgbackend---';
                    $cgBackendHashToCompare = md5($cgBackendHashDecoded);

                    if ($cgBackendHashHash != $cgBackendHashToCompare){
                        echo 0;die;
                    }

                }

            }

            $isGalleryAjaxBackendLoad = true;
            $cgVersion = '10.9.8.8.1';

            include('index-functions.php');

        }else{
            echo "<h2>MISSINGRIGHTS<br>This area can be edited only as administrator, editor or author.</h2>";
            exit();
        }

        exit();
    }
    else {
        exit();
    }

}

//  add contest_gallery_action as ajax ---- END


if(!function_exists('contest_gallery_action')){

    function contest_gallery_action() {

        $cgVersion = '10.9.8.8.1';

        include('index-scripts.php');
        include('index-functions.php');

    }
}

?>