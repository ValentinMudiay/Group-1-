<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Common_Controller')){
    class WPVC_Vote_Common_Controller{
	
		public function __construct(){			
			add_action('before_delete_post',array(&$this,'wpvc_voting_delete_post_entry_track'),1);			
		}
		public static function wpvc_votes_form_select_input($name, $values, $default = '', $parameters = '') {
			$field = '<select id="' . WPVC_Vote_Common_Controller::wpvc_vote_dropdown_output_string($name) . '" name="' . WPVC_Vote_Common_Controller::wpvc_vote_dropdown_output_string($name) . '"';
				if (WPVC_Vote_Common_Controller::wpvc_vote_dropdown_not_null($parameters))
					$field .= ' ' . $parameters;
			$field .= '>';
		
			if (empty($default) && isset($GLOBALS[$name]))
				$default = stripslashes($GLOBALS[$name]);
		
			for ($i = 0, $n = sizeof($values); $i < $n; $i++) {
				$field .= '<option value="' . $values[$i]['id'] . '"';
				if ($default == $values[$i]['id']) {
					$field .= 'selected = "selected"';
				}
				$field .= '>' . $values[$i]['text'] . '</option>';
			}
			$field .= '</select>';
		
			return $field;
		}
		
		public static function wpvc_vote_dropdown_output_string($string, $translate = false, $protected = false) {
			if ($protected == true) {
				return htmlspecialchars($string);
			} else {
				if ($translate == false) {
					return WPVC_Vote_Common_Controller::wpvc_votes_parse_input_field_data($string, array('"' => '&quot;'));
				} else {
					return WPVC_Vote_Common_Controller::wpvc_votes_parse_input_field_data($string, $translate);
				}
			}
		}
		
		public static function wpvc_votes_parse_input_field_data($data, $parse) {
			return strtr(trim($data), $parse);
		}
		
		public static function wpvc_vote_dropdown_not_null($value) {
			if (is_array($value)) {
				if (sizeof($value) > 0) {
					return true;
				} else {
					return false;
				}
			} else {
				if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
					return true;
				} else {
					return false;
				}
			}
		}
		
		public static function wpvc_vote_hyphenize_string($string) {
			return 
				  preg_replace(
					array('#[\\s-]+#', '#[^A-Za-z0-9\., -]+#'),
					array('-', ''),
					  urldecode($string)
				);
		}
		
		public static function wpvc_vote_list_thumbnail_sizes(){
			global $_wp_additional_image_sizes;
			   $sizes = array();
			   foreach( get_intermediate_image_sizes() as $s ){
				   $sizes[ $s ] = array( 0, 0 );
				   if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
					   $sizes[ $s ][0] = get_option( $s . '_size_w' );
					   $sizes[ $s ][1] = get_option( $s . '_size_h' );
				   }else{
					   if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
						   $sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], $_wp_additional_image_sizes[ $s ]['height'], );
				   }
			   }
			   $all_sizes = array();
			   foreach( $sizes as $size => $atts ){
					$all_sizes[$size] = $size . ' - ' .implode( 'x', $atts ); 			
			   }
			   return $all_sizes;
		}
		
		public static function wpvc_vote_get_thumbnail_sizes($get_seperate){
			global $_wp_additional_image_sizes;
			   $sizes = array();
			   foreach( get_intermediate_image_sizes() as $s ){
				   if( in_array( $s, array( $get_seperate) ) ){
					   $sizes[ $s ][0] = get_option( $s . '_size_w' );
					   $sizes[ $s ][1] = get_option( $s . '_size_h' );
				   }
			   }
			   $all_sizes = array();
			   foreach( $sizes as $size => $atts ){
					$all_sizes[$size] = implode( '--', $atts ); 			
			   }
			   return $all_sizes[$get_seperate];
		}
		
		public static function wpvc_vote_image_proportionate($imageFile,$size){			
			list($originalWidth, $originalHeight) = getimagesize(realpath($imageFile));
			$ratio = $originalWidth / $originalHeight;
			$targetWidth = $targetHeight = min($size, max($originalWidth, $originalHeight));

			if ($ratio < 1) {
			    $targetWidth = $targetHeight * $ratio;
			} else {
			    $targetHeight = $targetWidth / $ratio;
			}
			return(array($targetWidth,$targetHeight));
		}
		
		public static function wpvc_vote_seo_friendly_alternative_text($string){
			$string = str_replace(array('[\', \']'), '', $string);
			$string = preg_replace('/\[.*\]/U', '', $string);
			$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
			$string = htmlentities($string, ENT_COMPAT, 'utf-8');
			$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
			$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
			$string = str_replace('-',' ',$string);
			return strtolower(trim($string, '-'));
		}
		
		public static function wpvc_vote_is_contest_started($id = FALSE) {	     
			$curterm = $time = NULL;
			if( !is_wp_error($curterm = get_term( $id, WPVC_VOTES_TAXONOMY)) && isset($curterm)) {	
				if( !WPVC_Vote_Common_Controller::wpvc_votes_validateby_activation_limit($curterm->term_id) ){	
				   return FALSE;
				}
				$time = get_option($curterm->term_id . '_' . WPVC_VOTES_TAXSTARTTIME);
			}
			if($time != '0' && trim($time) && $time) {
				   $timeentered = strtotime(str_replace("-", "/", $time));
				   $currenttime = current_time( 'timestamp', 0 );
				   $time = date('Y-m-d-H-i-s', strtotime(str_replace('-', '/', $time)));
				   if($currenttime <= $timeentered) {
					   return FALSE;
				   }
			}else {
				   return TRUE;
			}
			return TRUE;
		}
		
		public static function wpvc_vote_is_contest_reachedend($id = FALSE) {
			$idarr = explode(',', $id);
			$curterm = $time = NULL;
	 
			if( !is_wp_error($curterm = get_term( $id, WPVC_VOTES_TAXONOMY)) && isset($curterm) ) {
				if(!WPVC_Vote_Common_Controller::wpvc_votes_validateby_activation_limit($curterm->term_id)){
					return TRUE;
				}
				$time = get_option($curterm->term_id . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
			}
			if($time != '0' && trim($time) && $time) {
			   $timeentered = strtotime(str_replace("-", "/", $time));
			   $currenttime = current_time( 'timestamp', 0 );
			   $time = date('Y-m-d-H-i-s', strtotime(str_replace('-', '/', $time)));
			   if($currenttime <= $timeentered) {
				   return FALSE;
			   }
			}else {
			   return FALSE;
			}
			return TRUE;
		}
		
		public static function wpvc_votes_validateby_activation_limit($id = NULL) {
			$limitcnt = (int)trim(get_option($id.'_'.WPVC_VOTES_TAXACTIVATIONLIMIT));
			$postcnt = WPVC_Vote_Common_Controller::wpvc_get_term_post_count_by_type($id);
			if(!$limitcnt ) {
				return TRUE;
			}else if($limitcnt > $postcnt){
				return FALSE;
			}else if( $postcnt >= $limitcnt ){
				return TRUE;
			}else {
				return TRUE;
			}
		}
		
		public static function wpvc_get_term_post_count_by_type($term, $taxonomy = WPVC_VOTES_TAXONOMY, $type = WPVC_VOTES_TYPE) {
			$args = array(
				'fields' => 'ids',
				'posts_per_page' => -1,
				'post_type' => $type,
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field' => 'id',
						'terms' => $term
					)
				),
				'post_status' => 'publish'
			);
	
			$posts = get_posts($args);
			
			if (count($posts) > 0) {
				return count($posts);
			} else {
				return 0;
			}
		}
		
		public static function wpvc_votes_is_addform_blocked($id = NULL) {
			$starttime = get_option($id . '_' . WPVC_VOTES_TAXSTARTTIME);
			$expirytime = get_option($id . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
			$starttimetimestamp = strtotime(str_replace("-", "/", $starttime));
			$expirytimetimestamp = strtotime(str_replace("-", "/", $expirytime));
			$currenttimestamp = current_time( 'timestamp', 0 );
			$isstarted = TRUE;
			$blocked = FALSE;
			$msg = FALSE;
			if( !trim($starttimetimestamp)) {
				$isstarted = FALSE;
				$blocked = FALSE;
			}else if($currenttimestamp > $starttimetimestamp){
				$blocked = TRUE;
				$isstarted = TRUE;
				if($blocked){
					$option = get_option(WPVC_VOTES_SETTINGS);
					$msg = $option['vote_entriescloseddesc'];
				}
			}
			if(!$isstarted) {
				if(!trim($expirytimetimestamp)) {
					$blocked = FALSE;
				}else if($currenttimestamp > $expirytimetimestamp) {
					$blocked = TRUE;
					if($blocked){
						$option = get_option(WPVC_VOTES_SETTINGS);
						$msg = $option['vote_reachedenddesc'];
					}
				}
			}
			return $msg;
		}
		
		
		public static function wpvc_votes_redirect_go_home(){ 
		  $previous_url = $_SERVER['HTTP_REFERER']; 
		  wp_redirect($previous_url);
		  exit();
		}
		
		public static function wpvc_vote_get_contestant_image($post_id,$short_cont_image){
			if (has_post_thumbnail($post_id)) {
				$wpvc_image_arr = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $short_cont_image);
				$data['wpvc_original_img'] = wp_get_attachment_url(get_post_thumbnail_id($post_id)).'?'.uniqid();
				$data['wpvc_image_src'] = $wpvc_image_arr[0];				
				
			}else{
				$data['wpvc_image_src'] = WPVC_NO_IMAGE_CONTEST;
				$data['wpvc_original_img'] = WPVC_NO_IMAGE_CONTEST;
			}
			return $data;
		}
		
		public static function wpvc_vote_get_all_global_settings($vote_opt){
			$data=array();
			//Get all global options
			$data['short_cont_image'] = isset($vote_opt['short_cont_image'])?$vote_opt['short_cont_image']:'';
			$data['page_cont_image'] = isset($vote_opt['page_cont_image'])?$vote_opt['page_cont_image']:'';
			$data['vote_select_sidebar'] = isset($vote_opt['vote_select_sidebar'])? $vote_opt['vote_select_sidebar'] : 'off';
			$data['vote_sidebar'] = isset($vote_opt['vote_sidebar']) ? $vote_opt['vote_sidebar'] : 'off';
			$data['vote_readmore'] = isset($vote_opt['vote_readmore']) ? $vote_opt['vote_readmore'] : 'off';
			$data['vote_entry_form'] = isset($vote_opt['vote_entry_form']) ? $vote_opt['vote_entry_form'] : '0';
			$data['vote_turn_lazy'] = isset($vote_opt['vote_turn_lazy'])?$vote_opt['vote_turn_lazy']:'off';
			$data['vote_turn_related'] = isset($vote_opt['vote_turn_related'])?$vote_opt['vote_turn_related']:'off';
			$data['single_page_cont_image_px'] = isset($vote_opt['single_page_cont_image_px'])?$vote_opt['single_page_cont_image_px']:'%';
			$data['vote_video_width'] = isset($vote_opt['vote_video_width'])?$vote_opt['vote_video_width']:'off';
			$data['single_page_cont_image'] = isset($vote_opt['single_page_cont_image'])?$vote_opt['single_page_cont_image']:'';
			$data['single_contestants_video_width'] = isset($vote_opt['single_contestants_video_width'])?$vote_opt['single_contestants_video_width']:'';
			$data['single_contestants_video_width_px'] = isset($vote_opt['single_contestants_video_width_px'])?$vote_opt['single_contestants_video_width_px']:'%';
			$data['single_page_cont_image_m'] = isset($vote_opt['single_page_cont_image_m'])?$vote_opt['single_page_cont_image_m']:'';
			$data['single_page_cont_image_m_px'] = isset($vote_opt['single_page_cont_image_m_px'])?$vote_opt['single_page_cont_image_m_px']:'%';
			$data['vote_audio_width'] = isset($vote_opt['vote_audio_width'])?$vote_opt['vote_audio_width']:'';
			$data['vote_audio_height'] = isset($vote_opt['vote_audio_height'])?$vote_opt['vote_audio_height']:'';
			$data['vote_audio_skin'] = isset($vote_opt['vote_audio_skin'])?$vote_opt['vote_audio_skin']:'hu-css';
			$data['vote_essay_width'] = isset($vote_opt['vote_essay_width'])?$vote_opt['vote_essay_width']:'';
			$data['vote_title_alocation']=isset($vote_opt['vote_title_alocation'])?$vote_opt['vote_title_alocation']:'off';
			$data['single_page_title']=isset($vote_opt['single_page_title'])?$vote_opt['single_page_title']:'off';
			$data['vote_notify_mail'] = isset($vote_opt['vote_notify_mail'])?$vote_opt['vote_notify_mail']:'off';
			$data['vote_admin_mail'] = isset($vote_opt['vote_admin_mail'])?$vote_opt['vote_admin_mail']:'';
			$data['vote_admin_mail_content'] = isset($vote_opt['vote_admin_mail_content'])?wpautop($vote_opt['vote_admin_mail_content']):'';
			$data['vote_from_name'] = isset($vote_opt['vote_from_name'])?$vote_opt['vote_from_name']:'';
			$data['votes_timertextcolor'] = isset($vote_opt['votes_timertextcolor'])?$vote_opt['votes_timertextcolor']:'';
			$data['votes_timerbgcolor'] = isset($vote_opt['votes_timerbgcolor'])?$vote_opt['votes_timerbgcolor']:'';			
			$data['vote_shwpvc_date_prettyphoto'] = isset($vote_opt['vote_shwpvc_date_prettyphoto'])?$vote_opt['vote_shwpvc_date_prettyphoto']:'off';
			$data['vote_newlink_tab'] = isset($vote_opt['vote_newlink_tab'])?$vote_opt['vote_newlink_tab']:'off';
			$data['vote_prettyphoto_disable'] = isset($vote_opt['vote_prettyphoto_disable'])?$vote_opt['vote_prettyphoto_disable']:'off';
			$data['vote_prettyphoto_disable_single'] = isset($vote_opt['vote_prettyphoto_disable_single'])?$vote_opt['vote_prettyphoto_disable_single']:'off';
			$data['vote_hide_account'] = isset($vote_opt['vote_hide_account'])?$vote_opt['vote_hide_account']:'off';
			$data['vote_openclose_menu'] = isset($vote_opt['vote_openclose_menu'])?$vote_opt['vote_openclose_menu']:'off';
			$data['vote_enable_all_contest'] = isset($vote_opt['vote_enable_all_contest'])?$vote_opt['vote_enable_all_contest']:'masonry-grid';
			$data['vote_all_contest_design'] = isset($vote_opt['vote_all_contest_design'])?$vote_opt['vote_all_contest_design']:'swipe-down';
			$data['vote_enable_ended'] = isset($vote_opt['vote_enable_ended'])?$vote_opt['vote_enable_ended']:'off';
			$data['vote_count_showhide'] = isset($vote_opt['vote_count_showhide'])?$vote_opt['vote_count_showhide']:'off';
			$data['vote_onlyloggedcansubmit'] = isset($vote_opt['vote_onlyloggedcansubmit'])?$vote_opt['vote_onlyloggedcansubmit']:FALSE;			
			
			$data['vote_tracking_method'] = isset($vote_opt['vote_tracking_method'])?$vote_opt['vote_tracking_method']:'';
			$data['vote_truncation_grid'] = isset($vote_opt['vote_truncation_grid'])?$vote_opt['vote_truncation_grid']:'';
			$data['vote_truncation_list'] = isset($vote_opt['vote_truncation_list'])?$vote_opt['vote_truncation_list']:'';
			$data['frequency'] = isset($vote_opt['frequency'])?$vote_opt['frequency']:'';
			
			$data['vote_frequency_count']=isset($vote_opt['vote_frequency_count'])?$vote_opt['vote_frequency_count']:'';
			$data['vote_votingtype_val']=isset($vote_opt['vote_votingtype'])?$vote_opt['vote_votingtype']:'';
			
			$data['vote_votingtype']  = isset($vote_opt['vote_votingtype'])?$vote_opt['vote_votingtype']:'';
			$data['vote_publishing_type']  = isset($vote_opt['vote_publishing_type'])?$vote_opt['vote_publishing_type']:'';
			$data['vote_grab_email_address']  = isset($vote_opt['vote_grab_email_address'])?$vote_opt['vote_grab_email_address']:'';
			$data['vote_tobestarteddesc'] = isset($vote_opt['vote_tobestarteddesc'])?$vote_opt['vote_tobestarteddesc']:'';
			$data['vote_reachedenddesc']  = isset($vote_opt['vote_reachedenddesc'])?$vote_opt['vote_reachedenddesc']:'';
			$data['vote_entriescloseddesc'] = isset($vote_opt['vote_entriescloseddesc'])?$vote_opt['vote_entriescloseddesc']:'';
					
			$data['facebook'] = isset($vote_opt['facebook']) ? $vote_opt['facebook'] : 'off';
			$data['file_facebook'] = isset($vote_opt['file_facebook']) ?$vote_opt['file_facebook']:'';
			$data['file_fb_default'] = isset($vote_opt['file_fb_default']) ?$vote_opt['file_fb_default']:'';
			$data['pinterest'] = isset($vote_opt['pinterest']) ? $vote_opt['pinterest'] : 'off';
			$data['file_pinterest'] = isset($vote_opt['file_pinterest'])?$vote_opt['file_pinterest']:'';
			$data['file_pinterest_default'] = isset($vote_opt['file_pinterest_default'])?$vote_opt['file_pinterest_default']:'';			
			$data['tumblr'] = isset($vote_opt['tumblr']) ? $vote_opt['tumblr'] : 'off';
			$data['file_tumblr'] = isset($vote_opt['file_tumblr']) ? $vote_opt['file_tumblr'] : '';
			$data['file_tumblr_default'] = isset($vote_opt['file_tumblr_default']) ? $vote_opt['file_tumblr_default'] : '';
			$data['facebook_login'] = isset($vote_opt['facebook_login'])?$vote_opt['facebook_login']:'';
			$data['vote_fb_appid'] = isset($vote_opt['vote_fb_appid'])?$vote_opt['vote_fb_appid']:"";
			$data['twitter'] = isset($vote_opt['twitter']) ? $vote_opt['twitter'] : 'off';
			$data['file_twitter'] = isset($vote_opt['file_twitter']) ?$vote_opt['file_twitter']:'';
			$data['file_tw_default'] = isset($vote_opt['file_tw_default']) ?$vote_opt['file_tw_default']:'';
			$data['twitter_login'] = isset($vote_opt['twitter_login'])?$vote_opt['twitter_login']:'';
			$data['vote_tw_appid'] = isset($vote_opt['vote_tw_appid'])?$vote_opt['vote_tw_appid']:'';
			
			$data['vote_tw_secret'] = isset($vote_opt['vote_tw_secret'])?$vote_opt['vote_tw_secret']:'';
			$data['deactivation']= isset($vote_opt['deactivation'])?$vote_opt['deactivation']:'';
			
			$data['vote_disable_jquery'] = isset($vote_opt['vote_disable_jquery'])?$vote_opt['vote_disable_jquery']:'';
			$data['vote_disable_jquery_cookie'] = isset($vote_opt['vote_disable_jquery_cookie'])?$vote_opt['vote_disable_jquery_cookie']:'';
			$data['vote_disable_jquery_fancy'] = isset($vote_opt['vote_disable_jquery_fancy'])?$vote_opt['vote_disable_jquery_fancy']:'';
			$data['vote_disable_jquery_pretty'] = isset($vote_opt['vote_disable_jquery_pretty'])?$vote_opt['vote_disable_jquery_pretty']:'';
			$data['vote_disable_jquery_validate'] =isset($vote_opt['vote_disable_jquery_validate'])?$vote_opt['vote_disable_jquery_validate']:'';
			
			//Needed for shortcode page
			$data['onlyloggedinuser'] = isset($vote_opt['onlyloggedinuser'])?$vote_opt['onlyloggedinuser']:'';
			
			return $data;
		}
		
		public static function wpvc_voting_encrypt($data)
		{
			$key = 'AShyelwmeifmoriemwpf8892=';
			/*
		    $length = $size - strlen($data); 
		    $enc_data =  $data . str_repeat(chr($length), $length);		
		    return openssl_encrypt($enc_data,'AES-256-CBC',$encryption_key,0);*/
		
			// Remove the base64 encoding from our key
			$encryption_key = base64_decode($key);
			// Generate an initialization vector
			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
			// Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
			$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
			// The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
			return base64_encode($encrypted . '::' . $iv);

		}
		
		public static function wpvc_voting_decrypt($data)
		{
			//return $data1 =  openssl_decrypt($enc_name,'AES-256-CBC',$encryption_key,0);
			
			$key = 'AShyelwmeifmoriemwpf8892=';
			// Remove the base64 encoding from our key
			$encryption_key = base64_decode($key);
			// To decrypt, split the encrypted data from our IV - our unique separator used was "::"
			list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
			return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);

		}
		
		public static function wpvc_voting_base64_encode($data)
		{
		    return base64_encode($data);
		}
		
		public static function wpvc_voting_base64_decode($data)
		{
		   	return base64_decode($data);	  
		}
		
		
		public function wpvc_voting_delete_post_entry_track($postid)
		{			
		    global $post;
		    
		    if($post == null)
			$post = get_post( $postid ); 
		    
		    if($post->post_type == WPVC_VOTES_TYPE):
		    
			$term_list = get_the_terms($post->ID,WPVC_VOTES_TAXONOMY);						
			//$term_list = wp_get_post_terms($post->ID, WPVC_VOTES_TAXONOMY, array("fields" => "ids"));
			$post_author = $post->post_author;
			$term_id = $term_list[0]->term_id;			
			$wpvc_contestant_author = get_post_meta($postid,'_wpvc_contestant_author_'.$term_id,true);
				
			if($wpvc_contestant_author != null){
				WPVC_Contestant_Model::wpvc_voting_delete_post_entry_track($wpvc_contestant_author,$term_id);
				delete_post_meta($postid, '_wpvc_contestant_author_'.$term_id, $wpvc_contestant_author);
			}
			return;			
		    endif;
		}
		
		public static function wpvc_votes_get_contestant_link($post_id){
			$custom_link = get_post_meta($post_id,'wpvc_contestant_link',true);
			if($custom_link == null)
				return get_permalink($post_id);
			else
				return $custom_link;
			
		}
		
				
		public static function wpvc_getplaintextintrofromhtml($html, $numchars) {
			// Remove the HTML tags
			$html = strip_tags($html);
			// Convert HTML entities to single characters
			$html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
			// Make the string the desired number of characters
			// Note that substr is not good as it counts by bytes and not characters
			$html = mb_substr($html, 0, $numchars, 'UTF-8');
			// Add an elipsis
			$html .= "…";
			return $html;
		}
		
		
		public static function wpvc_get_mime_type($extension) {
			
			
			$idx = explode( ',', $extension );			
					
			$mimet = array( 
				'txt' => 'text/plain',
				'htm' => 'text/html',
				'html' => 'text/html',
				'php' => 'text/html',
				'css' => 'text/css',
				'js' => 'application/javascript',
				'json' => 'application/json',
				'xml' => 'application/xml',
				'swf' => 'application/x-shockwave-flash',
				'flv' => 'video/x-flv',
		
				// images
				'png' => 'image/png',
				'jpe' => 'image/jpeg',
				'jpeg' => 'image/jpeg',
				'jpg' => 'image/jpeg',
				'gif' => 'image/gif',
				'bmp' => 'image/bmp',
				'ico' => 'image/vnd.microsoft.icon',
				'tiff' => 'image/tiff',
				'tif' => 'image/tiff',
				'svg' => 'image/svg+xml',
				'svgz' => 'image/svg+xml',
		
				// archives
				'zip' => 'application/zip',
				'rar' => 'application/x-rar-compressed',
				'exe' => 'application/x-msdownload',
				'msi' => 'application/x-msdownload',
				'cab' => 'application/vnd.ms-cab-compressed',
		
				// audio/video
				'mp3' => 'audio/mpeg',
				'qt' => 'video/quicktime',
				'mov' => 'video/quicktime',
		
				// adobe
				'pdf' => 'application/pdf',
				'psd' => 'image/vnd.adobe.photoshop',
				'ai' => 'application/postscript',
				'eps' => 'application/postscript',
				'ps' => 'application/postscript',
		
				// ms office
				'doc' => 'application/msword',
				'rtf' => 'application/rtf',
				'xls' => 'application/vnd.ms-excel',
				'ppt' => 'application/vnd.ms-powerpoint',
				'docx' => 'application/msword',
				'xlsx' => 'application/vnd.ms-excel',
				'pptx' => 'application/vnd.ms-powerpoint',
		
		
				// open office
				'odt' => 'application/vnd.oasis.opendocument.text',
				'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			);
		
			foreach($idx as $mimes){
				$mime[] = $mimet[$mimes];
			}
			if (isset( $mime )) {
				return $mime;
			} else {
				return 'application/octet-stream';
			}
		 }
		 
		public static function wpvc_clean_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = strip_tags($data);
			$data = htmlspecialchars($data);
			return $data;
		}
		
 
		
	
    }
}else
die("<h2>".__('Failed to load the Voting Common Controller','voting-contest')."</h2>");

return new WPVC_Vote_Common_Controller();
