<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_License_Controller')){
	class WPVC_Vote_License_Controller{
		
		public function __construct(){
			add_action('admin_init', array($this,'wpvc_voting_software_register_option'));
			add_action('admin_init', array($this,'wpvc_voting_software_activate_license'));
		}
		
		public static function wpvc_voting_software_license_page() {
			$license = get_option('wp_voting_software_license_key');
			$status = get_option('wp_voting_software_license_status');
			require_once(WPVC_VIEW_PATH.'wpvc_voting_license_view.php');
			wpvc_voting_license_view($license,$status);
		}
		
		public function wpvc_voting_software_register_option() {
			register_setting('wpvc_voting_software_license', 'wp_voting_software_license_key', array($this,'wpvc_voting_sanitize_license'));
		}
		
		public function wpvc_voting_sanitize_license($new) {
			$old = get_option('wp_voting_software_license_key');
			if ($old && $old != $new) {
				delete_option('wp_voting_software_license_status'); 
			}
			return $new;
		}
	
		public function wpvc_voting_software_activate_license() {
			
			if (isset($_POST['wpvc_voting_license_activate'])) {
				if (!check_admin_referer('wpvc_voting_software_nonce', 'wpvc_voting_software_nonce'))
					return;
				
				//Saving the Entered License Data
				update_option('wp_voting_software_license_key',trim($_POST['wp_voting_software_license_key']));
				
				$license = trim($_POST['wp_voting_software_license_key']);
				$api_params = array(
					'edd_action' => 'activate_license',
					'license' => $license,
					'item_id' => WPVC_WP_VOTING_SL_PRODUCT_ID
				);				
				$response = wp_remote_get(add_query_arg($api_params, WPVC_WP_VOTING_SL_STORE_API_URL)); 
				
				$license_data = json_decode(wp_remote_retrieve_body($response));		
				
				if( $license_data->license == 'invalid' ) {		
					wp_redirect(admin_url().'admin.php?page=votes-license&license=invalid');
					exit;
				}
				else{
					update_option('wp_voting_software_license_status', $license_data->license);
					wp_redirect(admin_url().'admin.php?page=votes-license&license=valid');
					exit;
				}
			}
		}
	}
}else
die("<h2>".__('Failed to load the Voting License Controller','voting-contest')."</h2>");

return new WPVC_Vote_License_Controller();
