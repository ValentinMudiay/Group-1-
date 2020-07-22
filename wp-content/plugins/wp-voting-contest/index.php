<?php
/*
Plugin Name: WP Voting Contest
Plugin URI: https://plugins.ohiowebtech.com
Description: Quickly and seamlessly integrate an online contest with voting into your Wordpress 4.0+ website. You can start many types of online contests such as photo names with very little effort..
Author: OhioWebtech
Version: 2.1
Text Domain: voting-contest
Domain Path: /assets/lang
*/

global $wpdb;

define('WPVC_VOTE_VERSION','2.1');
/*********** File path constants **********/
define('WPVC_VOTES_ABSPATH', dirname(__FILE__) . '/');
define('WPVC_VOTES_PATH', plugin_dir_url(__FILE__));
define('WPVC_VOTES_SL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WPVC_VOTES_SL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WPVC_VOTES_SL_PLUGIN_FILE', __FILE__);
define('WPVC_WP_VOTING_SL_STORE_API_URL', 'http://plugins.ohiowebtech.com');
define('WPVC_WP_VOTING_SL_PRODUCT_NAME', 'WordPress Voting Photo Contest Plugin');
define('WPVC_WP_VOTING_SL_PRODUCT_ID', 924);
load_plugin_textdomain( 'voting-contest', '', dirname( plugin_basename( __FILE__ ) ) . '/assets/lang' );
require_once('configuration/config.php');
require_once('configuration/wpvc_html.php');
register_activation_hook(__FILE__,'wpvc_votes_activation_init');
register_deactivation_hook(__FILE__,'wpvc_votes_deactivation_init');

if(!function_exists('wpvc_votes_version_updater_admin')){
    function wpvc_votes_version_updater_admin()
    {
        $wpvc_voting_sl_license_key = trim(get_option('wp_voting_software_license_key'));
        $wpvc_voting = new WPVC_Vote_Updater(WPVC_WP_VOTING_SL_STORE_API_URL, __FILE__, array(
                        'version' => '3.6.4',
                        'license' => $wpvc_voting_sl_license_key,
                        'item_id' => WPVC_WP_VOTING_SL_PRODUCT_ID,
                        'author' => 'Ohio Web Technologies'
                        ));

    }
}
add_action('admin_init', 'wpvc_votes_version_updater_admin');

if(!function_exists('wpvc_votes_add_action_plugin')){
    function wpvc_votes_add_action_plugin( $actions, $plugin_file ){
        static $plugin;
        if (!isset($plugin))
            $plugin = plugin_basename(__FILE__);
        if ($plugin == $plugin_file) {
            $settings   = array('settings'  => '<a href="'.admin_url().'admin.php?page=votes_settings">' . __('Settings', 'voting-contest') . '</a>');
            $site_link  = array('support'   => '<a href="http://plugins.ohiowebtech.com" target="_blank">' . __('Support', 'voting-contest') . '</a>');

            $actions = array_merge($settings, $actions);
            $actions = array_merge($site_link, $actions);
        }
        return $actions;
    }
}
add_filter( 'plugin_action_links', 'wpvc_votes_add_action_plugin', 10, 5 );
