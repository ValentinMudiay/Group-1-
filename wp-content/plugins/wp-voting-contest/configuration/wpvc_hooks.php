<?php
    /********* For installation ***********/
	add_action( 'mail_hook_add_contestant', array('WPVC_Vote_Shortcode_Controller','wpvc_votes_add_contestant_mail_function'), 10, 2 );
	add_action( 'mail_hook_add_contestant_user', array('WPVC_Vote_Shortcode_Controller','wpvc_votes_add_contestant_mail_function_user'), 20, 2 ); 	
			
	add_action('wp_logout',array('WPVC_Vote_Common_Controller','wpvc_votes_redirect_go_home'));
	
	add_action('wpvc_update_fields',array('WPVC_Vote_Ajax_Controller','wpvc_votes_update_contestant_field'),10,3);	
	

?>