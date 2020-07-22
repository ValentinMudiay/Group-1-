<?php
if(!function_exists('wpvc_votes_activation_init')){
	function wpvc_votes_activation_init() {
		global $wpdb;
		WPVC_Installation_Model::wpvc_create_tables_owvoting();
		$defaults = array(
				'imgheight' => 150,
				'imgwidth' => 100,
				'imgdisplay' => FALSE,
				'short_cont_image' => 'medium',
				'title' => FALSE,
				'orderby' => 'date',
				'order' => 'desc',
				'termdisplay' => FALSE,
				'onlyloggedinuser' => 'on',
				'frequency' => '1',
				'vote_frequency_hours' => '24',
				'vote_tracking_method' => 'ip_traced',				
				'vote_votingtype' => '2',
				'vote_frequency_count' => '1',
				'vote_publishing_type' => FALSE,				
				'deactivation' => 'on',  // MAKE DEACTIVATION TO ON WHILE INSTALLATION TO RETAIN DATA
				'vote_tobestarteddesc' => __('Contest not yet open for voting','voting-contest'),
				'vote_reachedenddesc' => __('There is no Contest at this time','voting-contest'),
				'vote_entriescloseddesc' => __('Contest already Started.','voting-contest'),
				'votes_timertextcolor' => '#000000',
				'votes_timerbgcolor' => '#ffffff',
				'single_page_cont_image_m'	=> '100',
				'single_page_cont_image_m_px' => '%',
				'single_page_cont_image' => '100',
				'single_page_cont_image_px ' => '%',
				'vote_turn_lazy' => 'on',				
				'vote_onlyloggedcansubmit' => 'on',
				'vote_disable_jquery_pretty' => 'on',
				'vote_disable_jquery_fancy' => 'on',
				'facebook' => 'on',
				'twitter' => 'on',
				'pinterest' => 'on',				
				'tumblr' => 'on',				
				'file_fb_default' => 'on',
				'file_tw_default' => 'on',
				'file_pinterest_default' => 'on',				
				'file_tumblr_default' => 'on',
				'vote_sidebar' => 'on'
			);
		$args = get_option(WPVC_VOTES_SETTINGS);
		$args = wp_parse_args($args, $defaults);
		update_option(WPVC_VOTES_SETTINGS, $args);
		update_option(WPVC_VOTES_GENERALEXPIRATIONFIELD, '0');							
		
		/* Style Option Releases */
		$color_check_option = get_option(WPVC_VOTES_COLORSETTINGS);
		if($color_check_option == null){
			$color_settings = array();
			$color_settings[WPVC_DEF_THEME_SUMMER] = array('votes_counter_font_size'=> '14',	'votes_timertextcolor' => '#000000','votes_timerbgcolor' => '#ffffff','votes_navigation_font_size' => '14','votes_navigation_text_color' => '#FFFFFF','votes_navigation_text_color_hover' => '#ffffff','votes_navigationbgcolor' => '#305891','votes_list_active' => '#F26E2A','votes_list_inactive' => '#FFFFFF','votes_grid_active' => '#F26E2A','votes_grid_inactive' => '#FFFFFF','votes_cont_title_font_size' => '16','votes_cont_title_color' => '#FFFFFF','votes_cont_title_color_hover' => '#F26E2A','votes_cont_title_color_grid' => '#f26e2a','votes_cont_title_color_hover_grid' => '#30598f','votes_cont_title_bgcolor' => '#30598f','votes_cont_title_color_single' => '','single_navigation_button' => '','single_navigation_button_hover' => '',	'single_contestant_content_bg' => '','votes_cont_content_color_single' => '','votes_popup_content_bg' => '','votes_popup_additional_info_color' => '','votes_popup_additional_info_bg' => '','votes_popup_content_color' => '','votes_single_social_sharing_url_color' => '','votes_single_social_sharing' => '#30598f','votes_single_social_sharing_bg' => '','votes_cont_desc_font_size' => '16','votes_cont_dese_color' => '#b18f6a','votes_cont_desc_bgcolor' => '#FFFFFF','votes_readmore_font_size' => '14','votes_readmore_fontcolor' => '#F26E2A','votes_readmore_fontcolor_hover' => '#000000','votes_readmore_bgcolor' => '','votes_readmore_bgcolor_hover' => '','votes_readmore_padding_top' => '','votes_readmore_padding_bottom' => '','votes_readmore_padding_left' => '5','votes_readmore_padding_right' => '','votes_bar_border_color' => '#DDDDDD','votes_bar_border_size' => '1','votes_count_font_size' => '16','votes_count_font_color' => '#FFFFFF','votes_count_bgcolor' => '#3276b1','votes_button_font_size' => '16','votes_button_font_color' => '#FFFFFF','votes_button_font_color_hover' => '#FFFFFF','votes_button_bgcolor' => '#305891','votes_button_bgcolor_hover' => '#f26e2a','votes_highlight_button_bgcolor' => '','votes_already_button_bgcolor' => '','votes_social_font_size' => '25','votes_social_icon_color' => '#F26E2A','votes_social_icon_color_hover' => '#30598F','votes_pagination_font_size' => '14','votes_pagination_font_color' => '#f26e2a','votes_pagination_active_font_color' => '#d83c30','votes_pagination_active_bg_color' => '','votes_pagination_hover_bg_color' => '','votes_pagination_hover_font_color' => '','login_tab_active_bg_color' => '','login_tab_hover_bg_color' => '','login_tab_font_color' => '','login_tab_active_font_color' => '','login_tab_hover_font_color' => '','login_body_background_color' => '','login_button_background_color' => '','login_button_hover_bg_color' => '','login_button_font_color' => '','login_button_hover_font_color' => '','popup_body_text_color' => '#000000','vote_navbar_button_background' => '','vote_navbar_active_button_background' => '#d83c30','vote_navbar_mobile_font'	=> '#FFFFFF','votes_showallcont_font' => '#FFFFFF','votes_showallcont_bg' => '#30598f',);
			update_option(WPVC_VOTES_COLORSETTINGS,$color_settings);
			update_option(WPVC_VOTES_ACTIVE_THEME,WPVC_DEF_THEME_SUMMER);
			
			$p= WPVC_Vote_Common_Settings_Controller::wpvc_voting_format_css($color_settings[WPVC_DEF_THEME_SUMMER]);
			$a = fopen(WPVC_ASSETS_COLORCSS_PATH, 'w');
			fwrite($a, $p);
			fclose($a);
			chmod(WPVC_ASSETS_COLORCSS_PATH, 0777);					
		}		
	}
}else
die("<h2>".__('Failed to load Voting activation initial','voting-contest')."</h2>");

if(!function_exists('wpvc_votes_uninstall')){
	function wpvc_votes_uninstall(){
		global $wpdb;				
		WPVC_Installation_Model::wpvc_voting_delete_tables();				
		$mycustomposts = get_posts(array('post_type' => WPVC_VOTES_TYPE, 'numberposts' => -1, 'post_status' => 'any'));
		if (count($mycustomposts) > 0) {
			foreach ($mycustomposts as $mypost) {
				wp_delete_post($mypost->ID, true);
			}
		}
		$taxonomy = WPVC_VOTES_TAXONOMY;
		
		$terms = get_terms($taxonomy, array('hide_empty' => false));
		$count = count($terms);
		if ($count > 0) {
			foreach ($terms as $term) {
				wp_delete_term($term->term_id, $taxonomy);
				delete_option($term->term_id . '_' . WPVC_VOTES_TAXSTARTTIME);
				delete_option($term->term_id . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
				delete_option($term->term_id . '_' . WPVC_VOTES_SETTINGS);
			}
		}		
		delete_option(WPVC_VOTES_SETTINGS);
		delete_option(WPVC_VOTES_GENERALSTARTTIME);
		delete_option(WPVC_VOTES_GENERALEXPIRATIONFIELD);
	}
}else
die("<h2>".__('Failed to load Voting uninstall initial','voting-contest')."</h2>");

if(!function_exists('wpvc_votes_deactivation_init')){				
	function wpvc_votes_deactivation_init() {
		$option = get_option(WPVC_VOTES_SETTINGS); 
		if (!$option['deactivation'] || $option['deactivation'] == 'off') {	
			wpvc_votes_uninstall();			
		}
	}
}else
die("<h2>".__('Failed to load Voting Deactivation initial','voting-contest')."</h2>");
