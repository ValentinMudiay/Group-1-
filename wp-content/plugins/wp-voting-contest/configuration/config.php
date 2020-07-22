<?php
	if (is_admin()){
		
		$auto_ctrl_files = array(					
					'WPVC_Vote_Common_Controller','WPVC_Vote_Taxonomy_Controller',
					'WPVC_Vote_Contestant_Controller','WPVC_Admin_Controller','WPVC_Vote_Save_Controller',
					'WPVC_Vote_Ajax_Controller','WPVC_Vote_Custom_Field_Controller','WPVC_Vote_Common_Settings_Controller',
					'WPVC_Vote_Excerpt_Controller','WPVC_Vote_License_Controller','WPVC_Vote_Updater'
					);
    
		$auto_model_files = array('WPVC_Installation_Model','WPVC_Contestant_Model','WPVC_Custom_Field_Model'
								  ,'WPVC_Vote_Shortcode_Model','WPVC_Votes_Save_Model'
								);
		
	}else{
		
		$auto_ctrl_files = array(
					'WPVC_Vote_Common_Controller', 'WPVC_Admin_Controller',
					'WPVC_Vote_Excerpt_Controller','WPVC_Vote_Shortcode_Controller',
					'WPVC_Vote_Save_Controller','WPVC_Vote_Ajax_Controller','WPVC_Vote_Single_Contestants'
				       );
		$auto_model_files = array('WPVC_Vote_Shortcode_Model','WPVC_Contestant_Model','WPVC_Custom_Field_Model','WPVC_Votes_Save_Model');
		
	}
	
    /***************** File paths ******************/
    define('WPVC_MODEL_PATH',WPVC_VOTES_ABSPATH.'owmodel/');
    define('WPVC_CONTROLLER_PATH',WPVC_VOTES_ABSPATH.'owcontroller/');   
    define('WPVC_VIEW_PATH',WPVC_VOTES_ABSPATH.'owviews/adminend/');
    define('WPVC_VIEW_FRONT_PATH',WPVC_VOTES_ABSPATH.'owviews/frontend/');
	
    define('WPVC_ASSETS_ADMIN_CSS_PATH',WPVC_VOTES_SL_PLUGIN_URL.'assets/css/wpvc_admin_styles.css');
    define('WPVC_ASSETS_FRONT_END_CSS_PATH',WPVC_VOTES_SL_PLUGIN_URL.'assets/css/wpvc_votes_display.css');
    define('WPVC_ASSETS_COLORCSS_PATH',WPVC_VOTES_ABSPATH.'assets/css/wpvc_votes_color.css');	
    define('WPVC_ASSETS_COLOR_RELPATH',WPVC_VOTES_SL_PLUGIN_URL.'assets/css/wpvc_votes_color.css');	
    define('WPVC_ASSETS_CSS_PATH',WPVC_VOTES_SL_PLUGIN_URL.'assets/css/');
    define('WPVC_ASSETS_IMAGE_PATH',WPVC_VOTES_SL_PLUGIN_URL.'assets/image/');
    define('WPVC_ASSETS_JS_PATH',WPVC_VOTES_SL_PLUGIN_URL.'assets/js/');
    define('WPVC_ASSETS_UPLOAD_PATH',WPVC_VOTES_ABSPATH.'assets/uploads/');
    define('WPVC_NO_IMAGE_CONTEST',WPVC_ASSETS_IMAGE_PATH.'/img_not_available.png');
	
    define('WPVC_LOADER_IMAGE',WPVC_ASSETS_IMAGE_PATH.'/fancy/fancy_loader.gif');
	define('WPVC_VOTING_BUTTON',WPVC_ASSETS_IMAGE_PATH.'/wpvc_button-own-icon.png');
    define('WPVC_FILE_IMAGE',WPVC_ASSETS_IMAGE_PATH.'wpvc_file.png');
    define('WPVC_SMALLFILE_IMAGE',WPVC_ASSETS_IMAGE_PATH.'wpvc_file_small.png');
    define('WPVC_CANCEL_IMAGE',WPVC_ASSETS_IMAGE_PATH.'cancel_icon.png');
	
    /*********** Program constants ***********/
    define('WPVC_VOTES_TYPE', 'contestants');
    define('VOTES_TYPE_PAGIN', 'votes_setting_paginate');
    define('WPVC_VOTES_TAXONOMY', 'contest_category');
    define('WPVC_VOTES_CUSTOMFIELD', 'votes_count');
    define('WPVC_VOTES_EXPIRATIONFIELD', 'votes_expiration');
    define('WPVC_VOTES_SETTINGS', 'votes_settings');
    define('WPVC_VOTES_COLORSETTINGS', 'votes_color_settings');
    define('WPVC_VOTES_ACTIVE_THEME', 'votes_current_theme');
    define('WPVC_VOTES_SHWPVC_DESC', 'list');
    define('WPVC_VOTES_ENTRY_LIMIT_FORM', '');
    define('WPVC_VOTES_TEXTDOMAIN', 'wp-pagenavi');
    define('WPVC_VOTES_TAXEXPIRATIONFIELD', 'votes_taxexpiration');
    define('WPVC_VOTES_TAXACTIVATIONLIMIT', 'votes_taxactivationlimit');
    define('WPVC_VOTES_TAXSTARTTIME', 'votes_taxstarttime');
    define('WPVC_VOTES_GENERALEXPIRATIONFIELD', 'votes_generalexpiration');
    define('WPVC_VOTES_GENERALSTARTTIME', 'votes_generalstarttime');
    define('WPVC_VOTES_CONTESTPHOTOGRAPHERNAME', 'contestant_photographer_name');	
    define('WPVC_VOTES_CONTENT_LENGTH', get_option('votesadvancedexcerpt_length'));
    define('WPVC_VOTES_CONTENT_ELLIPSES', get_option('votesadvancedexcerpt_ellipsis'));
    define('WPVC_VOTES_VIEWS', 'votes_viewers');
	define('WPVC_DEF_THEME_SUMMER', 'Summer');
    define('WPVC_DEF_THEME', 'Summer,Noel,New_Years,Christmas,Cupcake');
    define('WPVC_DEF_PUBLISHING', 'pending');
     
    /*************** Table constants **************/
    define('WPVC_VOTES_TBL', $wpdb->prefix . 'votes_tbl');
    define("WPVC_VOTES_ENTRY_CUSTOM_TABLE", $wpdb->prefix . "votes_custom_field_contestant");    
    define("WPVC_VOTES_POST_ENTRY_TABLE", $wpdb->prefix . "votes_post_entry_contestant"); 
    define("WPVC_VOTES_USER_ENTRY_TABLE", $wpdb->prefix . "votes_user_entry_contestant"); 
    define("WPVC_VOTES_USER_CUSTOM_TABLE", $wpdb->prefix . "votes_custom_registeration_contestant");
    define("WPVC_VOTES_POST_ENTRY_TRACK", $wpdb->prefix . "votes_post_contestant_track");
	
    /******** Intialize the needed classes **********/	    
    wpvc_controller_autoload($auto_ctrl_files);
    wpvc_model_autoload($auto_model_files);

    require_once('installation.php');
    require_once('wpvc_hooks.php');	
    include_once WPVC_CONTROLLER_PATH.'/pagination/wp-pagenavi.php';	
    function wpvc_controller_autoload($class_name) 
    {
		if(!empty($class_name)){
			foreach($class_name as $class_nam):
				$filename = strtolower($class_nam).'.php';
				$file = WPVC_CONTROLLER_PATH.$filename;
			
				if (file_exists($file) == false)
				{
					return false;
				}
				include_once($file);
			endforeach;
		}
    }
	    
    function wpvc_model_autoload($class_name) 
    {
		if(!empty($class_name)){
			foreach($class_name as $class_nam):
				$filename = strtolower($class_nam).'.php';
				$file = WPVC_MODEL_PATH.$filename;
			
				if (file_exists($file) == false)
				{
					return false;
				}
				include_once($file);
			endforeach;
		}
    }