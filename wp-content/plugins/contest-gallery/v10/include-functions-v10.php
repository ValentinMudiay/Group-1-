<?php

function cg_options_tabcontent_v10() {
    /* Register our stylesheet. */

    if(!empty($_GET['page'])){
        $check = $_GET['page'];
    }
    else{
        $check = '';
    }

    if ($check!='contest-gallery/index.php') {
        return;
    }

    #wp_enqueue_style( 'cg_options_tabcontent_v10', plugins_url('/v10-admin/options/cg_options_tabcontent.css', __FILE__), false , '10.9.8.8.1' );
    wp_enqueue_style( 'cg_wp_styles_v10', plugins_url('/v10-css/wp-styles.css', __FILE__), false , '10.9.8.8.1' );
    wp_enqueue_style( 'cg_options_style_v10', plugins_url('/v10-css/cg_options_style.css', __FILE__), false , '10.9.8.8.1' );
    wp_enqueue_style( 'cg_backend_gallery', plugins_url('v10-css/backend/cg_backend_gallery.css', __FILE__), false, '10.9.8.8.1' );
    wp_enqueue_style( 'cg_main_menu_css', plugins_url('/v10-css/backend/cg_main_menu.css', __FILE__), false, '10.9.8.8.1' );


}

add_action('admin_enqueue_scripts', 'cg_options_tabcontent_v10' );


// AJAX Script für Check Admin Image Upload im Backend
// Achtung! Für Backend AJAX Calls ist der FrontEnd Aufbau nicht erforderlich, nur die Action muss registriert werden

add_action( 'wp_ajax_nopriv_cg_check_wp_admin_upload_v10', 'cg_check_wp_admin_upload_v10' );
add_action( 'wp_ajax_cg_check_wp_admin_upload_v10', 'cg_check_wp_admin_upload_v10' );

function cg_check_wp_admin_upload_v10(){

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        require_once('v10-admin/gallery/wp-uploader.php');
        die();
    }
    else {
        exit();
    }

}

// AJAX Script für Check Admin Image Upload im Backend ---- ENDE

function cg_custom_login_direct_after_reg() {

    if(!empty($_GET['cg_gallery_id_registry']) && !empty($_GET['cg_login_user_after_registration']) && !is_user_logged_in()){
       // global $wp;
        global $wpdb;

        $tablenameWpUsers = $wpdb->prefix . "users";

        // $wp->reuest is not available here!
      //  $currentURL = home_url($wp->request);

        $galleryID = sanitize_text_field($_GET['cg_gallery_id_registry']);
        $activation_key = sanitize_text_field($_GET['cg_activation_key']);

        $wpUser = $wpdb->get_row("SELECT ID FROM $tablenameWpUsers WHERE user_activation_key LIKE '%" . $activation_key . "%'");

        // set cookie only first time!!! Then it should be not possible anymore to login by activation_key
        if(strpos($wpUser->user_activation_key,'-unconfirmed')===false AND strpos($wpUser->user_activation_key,'-confirmed')===false){

            // '-created' was added update 10.9.8.8.1
            // set user id here by activation key, because created!!!
            // This has to be set, so it should be not possible anymore to login by activation_key
            // It means not that user is totally confirmed, only-when main-mail and main-username is removed, then totally confirmed!
            $wpdb->update(
                "$tablenameWpUsers",
                array('user_activation_key' => $activation_key.'-unconfirmed'),
                array('ID' => $wpUser->ID),
                array('%s'),
                array('%d')
            );

            wp_set_auth_cookie( $wpUser->ID,true );

        }

        //wp_set_current_user( $wpUser->ID, $wpUser->user_login );
      //  do_action('wp_login', $wpUser->user_login);

    }

}

// setup_theme runs before theme is loaded!
// see https://codex.wordpress.org/Plugin_API/Action_Reference
add_action( 'setup_theme', 'cg_custom_login_direct_after_reg' );


add_shortcode( 'cg_users_reg', 'contest_gal1ery_users_registry' );

function contest_gal1ery_users_registry($atts){

    // PLUGIN VERSION CHECK HERE

    contest_gal1ery_db_check();

    if(is_admin()){
        return '';
    }

    // PLUGIN VERSION CHECK HERE --- END

    global $wp_version;
    $sanitize_textarea_field = ($wp_version<4.7) ? 'sanitize_text_field' : 'sanitize_textarea_field';
    wp_enqueue_style( 'cg_contest_style',  plugins_url('/../v10/v10-css/style.css', __FILE__), false, '10.9.8.8.1' );
    wp_enqueue_style( 'cg_general_form_style', plugins_url('/../v10/v10-css/cg_general_form_style.css', __FILE__), false , '10.9.8.8.1' );
    wp_enqueue_style( 'cg_form_style', plugins_url('/../v10/v10-css/cg_form_style.css', __FILE__), false , '10.9.8.8.1' );
    wp_enqueue_script( 'cg_js_general_frontend', plugins_url( '/../v10/v10-js/general_frontend.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
    wp_enqueue_script( 'cg_registry', plugins_url( '/../v10/v10-js/registry/users-registry.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

    wp_localize_script( 'cg_registry', 'post_cg_registry_wordpress_ajax_script_function_name', array(
        'cg_registry_ajax_url' => admin_url( 'admin-ajax.php' )
    ));

    ob_start();
    include(__DIR__.'/../v10/v10-admin/users/frontend/users-registry.php');
    $contest_gal1ery_users_registry = ob_get_clean();

    //apply_filters( 'cg_filter_users_registry', $contest_gal1ery_users_registry );

    return $contest_gal1ery_users_registry;

}

add_action('wp_ajax_nopriv_post_cg_registry','post_cg_registry');
add_action('wp_ajax_post_cg_registry','post_cg_registry');

function post_cg_registry(){

    global $wpdb;

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

        require_once(__DIR__.'/../v10/v10-admin/users/frontend/users-registry-check-name-mail-ajax.php');
        die();

    }
    else {

        exit();
    }

}

add_action( 'wp_ajax_nopriv_post_cg_login', 'post_cg_login' );
add_action( 'wp_ajax_post_cg_login', 'post_cg_login' );

if(!function_exists('post_cg_login')){

    function post_cg_login(){

        global $wpdb;

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {

            require_once(__DIR__.'/../v10/v10-admin/users/frontend/users-login-check-ajax.php');

            die();
        }
        else {

            exit();
        }
    }

}

add_shortcode( 'cg_users_login', 'contest_gal1ery_users_login' );

if(!function_exists('contest_gal1ery_users_login')){

    function contest_gal1ery_users_login($atts){

        // PLUGIN VERSION CHECK HERE

        contest_gal1ery_db_check();

        if(is_admin()){
            return '';
        }

        // PLUGIN VERSION CHECK HERE --- END

        wp_enqueue_style( 'cg_contest_style',  plugins_url('/../v10/v10-css/style.css', __FILE__), false, '10.9.8.8.1' );
        wp_enqueue_style( 'cg_form_style', plugins_url('/../v10/v10-css/cg_form_style.css', __FILE__), false, '10.9.8.8.1' );
        wp_enqueue_style( 'cg_general_form_style', plugins_url('/../v10/v10-css/cg_general_form_style.css', __FILE__), false, '10.9.8.8.1' );
        wp_enqueue_script( 'cg_js_general_frontend', plugins_url( '/../v10/v10-js/general_frontend.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );
        wp_enqueue_script( 'cg_login', plugins_url( '/../v10/v10-js/login/users-login.js', __FILE__ ), array('jquery'), '10.9.8.8.1' );

        wp_localize_script( 'cg_login', 'post_cg_login_wordpress_ajax_script_function_name', array(
            'cg_login_ajax_url' => admin_url( 'admin-ajax.php' )
        ));

        ob_start();
        include(__DIR__.'/../v10/v10-admin/users/frontend/users-login.php');
        $contest_gal1ery_users_login = ob_get_clean();

        //apply_filters( 'cg_filter_users_login', $contest_gal1ery_users_login );

        return $contest_gal1ery_users_login;

    }

}


?>