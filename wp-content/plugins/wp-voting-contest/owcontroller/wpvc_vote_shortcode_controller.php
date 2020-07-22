<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Shortcode_Controller')){
	class WPVC_Vote_Shortcode_Controller{
	    
	    public function __construct(){
			$_SESSION['wpvc_profile'] = 0;
			add_shortcode('showcontestants', array($this,'wpvc_votes_shwpvc_contestants'));
			add_shortcode('endcontestants', array($this,'wpvc_voting_end_contestants'));
			add_shortcode('upcomingcontestants', array($this,'wpvc_voting_start_contestants'));			
			add_shortcode('rulescontestants', array($this,'wpvc_voting_rules_contestants'));
			add_shortcode('addcontestants', array($this,'wpvc_voting_add_contestants'));
			add_shortcode('owtotalvotes', array($this,'wpvc_voting_total_votes'));
			
			unset($_SESSION['GET_VIEW_SHORTCODE']);
	    }
		
		/***************** Show Contestants **************/
		public function wpvc_votes_shwpvc_contestants($shwpvc_cont_args){			
			$vote_opt = get_option(WPVC_VOTES_SETTINGS);
			$category_options = get_option($shwpvc_cont_args['id']. '_' . WPVC_VOTES_SETTINGS);
			$inter = WPVC_Vote_Common_Controller::wpvc_vote_get_thumbnail_sizes($vote_opt['page_cont_image']);
			$height_tr =explode('--',$inter);
			$width_t =$height_tr[0];
			$height_t = $height_tr[1];

			$height = $height_t ? $height_t : '';
			$width = $width_t ? $width_t : '';
			$title = $vote_opt['title'] ? $vote_opt['title'] : NULL;
			$orderby = $vote_opt['orderby'] ? $vote_opt['orderby'] : 'votes';
			$order = $vote_opt['order'] ? $vote_opt['order'] : 'desc';
			$onlyloggedinuser = $vote_opt['onlyloggedinuser'] ? $vote_opt['onlyloggedinuser'] : FALSE;
			$pagination_option = get_option('contestpagenavi_options');		
						
			$votes_start_time=get_option($shwpvc_cont_args['id'] . '_' . WPVC_VOTES_TAXSTARTTIME);			
			$tax_hide_photos_live = @$category_options['tax_hide_photos_live'];
												
			if($tax_hide_photos_live == 'on'){				
				$current_time = current_time( 'timestamp', 0 );
				if(($votes_start_time !='' && strtotime($votes_start_time) > $current_time)){
				    $tax_hide_photos_live = 0;
				    $category_thumb = 0 ;
				}
				else{						
				    $category_thumb = ($category_options['imgdisplay']=='on')?1:0;
				    $tax_hide_photos_live = 1;
				}				
			}			
			else{
				$tax_hide_photos_live = 1;
				$category_thumb = ($category_options['imgdisplay']=='on')?1:0;
			}			
			
			$category_term_disp = ($category_options['termdisplay']=='on')?1:0;		
			
			$sort_by = isset($shwpvc_cont_args['orderby'])?0:1;
			$shwpvc_cont_args = wp_parse_args($shwpvc_cont_args, array(
				'height' => $height,
				'width' => $width,
				'title' => $title,
				'orderby' => $orderby,
				'order' => $order,
				'postperpage' => $pagination_option['contestant_per_page'],
				'taxonomy' => WPVC_VOTES_TAXONOMY,
				'id' => 0,
				'paged' => 0,
				'ajaxcontent' => 0,
				'showtimer' => 1,
				'showform' => -1,
				'forcedisplay' => 1,
				'thumb' => $category_thumb,
				'termdisplay' => $category_term_disp,
				'pagination'=>1,
				'sort_by'=>$sort_by,
				'onlyloggedinuser' => $onlyloggedinuser,
				'tax_hide_photos_live' => $tax_hide_photos_live,
				'navbar'	 => 1
			));
			
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_shortcode_showcontest_view.php');
		
			ob_start();
			wpvc_voting_shortcode_showcontestant_view($shwpvc_cont_args,$vote_opt,$category_options);
			return ob_get_clean();
		}
		
		/************ Add contestants  **************/
		public function wpvc_voting_add_contestants($contest_args){			
			$vote_opt = get_option(WPVC_VOTES_SETTINGS);
			$category_options = get_option($contest_args['id']. '_' . WPVC_VOTES_SETTINGS);
			
			$check_status = WPVC_Vote_Common_Controller::wpvc_votes_is_addform_blocked($contest_args['id']);
			$custom_fields = WPVC_Contestant_Model::wpvc_voting_get_all_custom_fields();
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_shortcode_addcontest_view.php');
			
			ob_start();
			wpvc_voting_shortcode_addcontestant_view($contest_args,$vote_opt,$category_options,$check_status,$custom_fields);
			WPVC_Vote_Shortcode_Model::wpvc_voting_insert_contestants($contest_args,$vote_opt,$category_options,$custom_fields,$check_status);
			return ob_get_clean();
		}
		
		/************ Votes Timer Start **************/
		public function wpvc_voting_start_contestants($contest_args){			
			if(!$contest_args['id']) {
			   return '<div class="wpvc_votes_error">'.__('Timer Not Available','voting-contest').'</div>';
			}
			
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_shortcode_startcontest_view.php');
			ob_start();
			wpvc_voting_shortcode_startcontest_view($contest_args);
			return ob_get_clean();
		}
		
		/************ Votes Timer End ****************/
		public function wpvc_voting_end_contestants($contest_args){			
			if(!$contest_args['id']) {
			   return '<div class="wpvc_votes_error">'.__('Timer Not Available','voting-contest').'</div>';
			}
			
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_shortcode_endcontest_view.php');
			ob_start();
			wpvc_voting_shortcode_endcontest_view($contest_args);
			return ob_get_clean();
			
		}
		
				
		/*************** Rules Contest ****************/
		public function wpvc_voting_rules_contestants($args){			
			$out_html='';
			ob_start();
			extract(shortcode_atts( array(
			'id' => NULL,			
			), $args ));
			
			
			$votes_option = get_option($id . '_' . WPVC_VOTES_SETTINGS);
			if($votes_option['vote_contest_rules']!=''){
				$out_html .= '<div class="wpvc_vote_cotest_rules">'.wpautop(html_entity_decode($votes_option['vote_contest_rules'])).'</div>';
			}
			ob_end_clean();
			echo $out_html;
			return;
			
		}
				
		//Show login/ register on front end
		public static function wpvc_votes_custom_registration_fields_show(){			
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_user_register_view.php');
			$votes_settings = get_option(WPVC_VOTES_SETTINGS);
			$custom_field = WPVC_Custom_Field_Model::wpvc_voting_user_get_all_custom_fields();
			echo '<div class="hide">';
			echo wpvc_voting_user_login_view($votes_settings,$custom_field);
			//echo wpvc_voting_user_registration_view($votes_settings,$custom_field);
			echo wpvc_voting_user_forget_view();
			echo '</div>';
		}
		
		
		//Show Email Verification Form on front end
		public static function wpvc_votes_custom_email_form(){
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_email_form.php');
			$votes_settings = get_option(WPVC_VOTES_SETTINGS);			
			echo '<div class="hide">';
			echo wpvc_voting_email_form($votes_settings);
			echo '</div>';
		}
		
		//Grab Email Form on front end for IP and COOKIE
		public static function wpvc_voting_email_grab(){
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_email_grab.php');
			$votes_settings = get_option(WPVC_VOTES_SETTINGS);			
			echo '<div class="hide">';
			echo wpvc_voting_email_grab($votes_settings);
			echo '</div>';
		}
		
		public static function wpvc_get_email_description_with_content($post_id,$mail_content,$cont_details){
			$mail_content = wpautop($mail_content);
			$custom_fields  = WPVC_Contestant_Model::wpvc_voting_get_all_custom_fields($post_id); 
			$custom_entries = WPVC_Contestant_Model::wpvc_voting_get_all_custom_entries($post_id);			
			if(!empty($custom_entries)){
				$field_values = $custom_entries[0]->field_values; 
				if(base64_decode($field_values, true))
					$field_val = maybe_unserialize(base64_decode($field_values));  
				else
					$field_val = maybe_unserialize($field_values);
															
				if(!empty($custom_fields)){								
					$ow = 0;
					foreach($custom_fields as $custom_field){
						$system_name = $custom_field->system_name;
						$system_name = ($system_name != "contestant-desc" && $system_name != "contestant-email_address"  && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link")?'customfield_'.$system_name:$system_name;
						
						if (strpos($mail_content, '{'.$system_name.'}') !== false) {						
							$replace_content='';
							if($custom_field->question_type == 'DATE'){
								$date_format = get_option($custom_field->system_name);
								$date_field = $field_val[$custom_field->system_name];
								list($m, $d, $y) = preg_split('/-/', $date_field);
								$date_field = sprintf('%4d%02d%02d', $y, $m, $d);
								
								$replace_content=date($date_format,strtotime($date_field));
							}
							elseif($system_name=='contestant-desc'){
								$replace_content = $cont_details['contestant_desc'];
							}
							else if(is_array($field_val[$custom_field->system_name ])){
								$multiple = implode(', ',$field_val[$custom_field->system_name ]);
								$replace_content= $multiple;
							}else{
								$replace_content=str_replace("-"," ",stripcslashes($field_val[$custom_field->system_name ]));
							}
							//echo $system_name.' = '.$replace_content."<br/>";
							$mail_content = str_replace('{'.$system_name.'}',$replace_content."<br/>",$mail_content);
						}
					}								
				}
				if (strpos($mail_content, '{contestant-link}') !== false) {
					$replace_content = get_permalink($post_id,FALSE);
					$mail_content = str_replace('{contestant-link}',$replace_content."<br/>",$mail_content);
				}
			}
			return $mail_content;
		}
		
		//On add contestant Mail sent to admin
		public static function wpvc_votes_add_contestant_mail_function($post_id,$cont_details){
			$option_setting = get_option(WPVC_VOTES_SETTINGS);
			if(isset($option_setting['vote_notify_mail'])){
				if($option_setting['vote_admin_mail']!='')
					$admin_email = $option_setting['vote_admin_mail'];
				else
					$admin_email = get_settings('admin_email');
				
				if($option_setting['vote_admin_mail_content'] != null)	{
					$email_description = WPVC_Vote_Shortcode_Controller::wpvc_get_email_description_with_content($post_id,$option_setting['vote_admin_mail_content'],$cont_details);
				}
					
					
				$subject = "New Contestant Entry Is Submitted";
				
				require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_mail_content_view.php');
				$message = wpvc_voting_mail_addcontestant_view($option_setting,$post_id,$cont_details,$email_description);
				if($option_setting['vote_from_name']!='')
					$headers[] = 'From: '.$option_setting['vote_from_name'];
					$headers[] = "Content-type: text/html";
					wp_mail($admin_email, $subject,$message ,$headers);	
			}
		}
		
		//On add contestant Mail sent to added user both Submission 
		public static function wpvc_votes_add_contestant_mail_function_user($post_id,$cont_details){
			$option_setting = get_option(WPVC_VOTES_SETTINGS);
			if(isset($option_setting['vote_notify_contestant'])){
				
				$contestant_email_address = get_post_meta($post_id,'contestant-email_address',true);				
				
				if(isset($contestant_email_address)){
					$user_email = $contestant_email_address;
				}
				else{
					return ;					
				}
				
				if($option_setting['vote_contestant_submit_content'] != null)	{
					//$email_description = $option_setting['vote_contestant_submit_content'];
					$email_description = WPVC_Vote_Shortcode_Controller::wpvc_get_email_description_with_content($post_id,$option_setting['vote_contestant_submit_content'],$cont_details);
				}
				
				if($option_setting['vote_notify_subject'] != null)	{
					$subject = $option_setting['vote_notify_subject'];
				}
				else{	
					$subject = __('Your Entry Is Submitted to Admin. Waiting for Approval','voting-contest');
				}
				
				require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_mail_content_view.php');
				$message = wpvc_voting_mail_addcontestant_view($option_setting,$post_id,$cont_details,$email_description,1);
				
				if($user_email!='')
					$headers[] = 'From: '.$user_email;
					
				$headers[] = "Content-type: text/html";
				wp_mail($user_email, $subject,$message ,$headers);	
			}
		}
		
		
		
		//On add contestant Mail sent to admin
		public static function wpvc_votes_verification_mail_function($verificationcode,$senderemail){
			$option_setting = get_option(WPVC_VOTES_SETTINGS);
			
			if($option_setting['vote_admin_mail']!='')
				$admin_email = $option_setting['vote_admin_mail'];
			else
				$admin_email = get_settings('admin_email');
				
			$subject = __("Email Verification Code","voting-contest");
			
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_mail_content_view.php');
			$message = wpvc_voting_mail_verification_code($verificationcode);
			if($option_setting['vote_from_name']!='')
				$headers[] = 'From: '.$option_setting['vote_from_name'];
				$headers[] = "Content-type: text/html";
				wp_mail($senderemail, $subject,$message ,$headers);	
			
		}
		
		public static function wpvc_voting_total_votes(){			
			$total_votes = WPVC_Contestant_Model::wpvc_total_votes();
			return "<span class='wpvc_total_counter'>".$total_votes."</span>";	
		}
		
	}
}else
die("<h2>".__('Failed to load the Voting Shortcode Controller','voting-contest')."</h2>");

return new WPVC_Vote_Shortcode_Controller();
