<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Save_Controller')){
	class WPVC_Vote_Save_Controller{
	    
		public function __construct(){
			add_action('wp_ajax_wpvc_save_votes', array($this,'wpvc_contest_save_votes_for_post'));
			add_action('wp_ajax_nopriv_wpvc_save_votes', array($this,'wpvc_contest_save_votes_for_post'));
		}
		
		public function wpvc_contest_save_votes_for_post(){			
			global $wpdb;
			if($_SERVER[ 'HTTP_X_REQUESTED_WITH' ]=='XMLHttpRequest'){
				$pid = $_GET['pid'];
				$termid = $_GET['termid'];
				
				$termid = WPVC_Vote_Common_Controller::wpvc_voting_decrypt($termid);
				$pid = WPVC_Vote_Common_Controller::wpvc_voting_decrypt($pid);
				
				//Adding the code for the WP_ID
				$option = get_option(WPVC_VOTES_SETTINGS);
				
				$user_id = get_current_user_id();
				$ip = $user_id; 
				
			
				$result = array();
				$result['button_flag'] = 0; 
				$where = '';
				$freq = $option['frequency'];
				
				
				$is_votable = WPVC_Vote_Save_Controller::wpvc_check_contestant_is_votable($pid, $ip, $termid);
				
				
				// W3c Total cache Plugin
				if(function_exists('w3tc_pgcache_flush')){                
					$votes_page_id = $_GET['votes_page_id']; 
					w3tc_pgcache_flush();   
					w3tc_flush_all();					
					w3tc_pgcache_flush_post($votes_page_id);
				}
				
				//Wp Super Cache Plugin
				if ( function_exists('wp_cache_clear_cache') ) {
					wp_cache_clear_cache();
				}
				if( function_exists('wp_cache_post_change')){
					$votes_page_id = $_GET['votes_page_id']; 
					wp_cache_post_change( $votes_page_id );
				}
				
				if(!WPVC_Vote_Common_Controller::wpvc_vote_is_contest_started($termid)) {
					$result['success'] = 0;
					$result['msg'] = __("Restricted",'voting-contest');
					$result['msg_html'] = "<div class='owt_danger'><i class='wpvc_vote_icons voteconestant-warning'></i>".$option['vote_tobestarteddesc']."</div>";
				}
				else if(WPVC_Vote_Common_Controller::wpvc_vote_is_contest_reachedend($termid)) {
					$result['success'] = 0;
					$result['msg'] = __("Restricted",'voting-contest');
					$result['msg_html'] = "<div class='owt_danger'><i class='wpvc_vote_icons voteconestant-warning'></i>".$option['vote_reachedenddesc']."</div>";
				}
				else if(get_post_status( $pid ) != 'publish' ) {
					$result['success'] = 0;
					$result['msg'] = __('Not Available','voting-contest');
					$result['msg_html'] = "<div class='owt_danger'><i class='wpvc_vote_icons voteconestant-warning'></i>".__('Warning! Contestants not Available ','voting-contest')."</div>";
				}
				else if(!$is_votable){       
					if($option['vote_votingtype']!='' && $freq == 11){
						$result['success'] = 0;
						$result['msg'] = __("Restricted",'voting-contest');
						$result['msg_html'] = "<div class='owt_warning'><i class='wpvc_vote_icons voteconestant-warning'></i>".__('Warning! Vote Limit Reached ','voting-contest')."</div>";
					}
					else if($option['vote_votingtype']=='' && $freq == 11) {
						$result['success'] = 0;
						$result['msg'] = __("Not Allowed ",'voting-contest');
						$result['msg_html'] = "<div class='owt_warning'><i class='wpvc_vote_icons voteconestant-warning'></i>".__('Warning! Multiple Votes Not Allowed For Same Contestant ','voting-contest')."</div>";
					}
					else{
						$result['success'] = 0;
						$result['msg'] = __('Already Voted','voting-contest');
						$result['msg_html'] = "<div class='owt_warning'><i class='wpvc_vote_icons voteconestant-warning'></i>".__('Warning! You have already registered your vote ','voting-contest')."</div>";
					}
				}
				else{
					$cur_vote = get_post_meta($pid, WPVC_VOTES_CUSTOMFIELD);					
					$vote_count = $_GET['votes_count'];
			
					//Adding ip_always in the WP_VOTES_TABLE
					if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
						$ip_always = $_SERVER['HTTP_X_FORWARDED_FOR'];
					}
					else {
						$ip_always = $_SERVER['REMOTE_ADDR'];
					}
					
										
					WPVC_Votes_Save_Model::wpvc_update_vote_contestant($ip,$vote_count,$pid,$termid,$ip_always,$email_always);
					$total_v = WPVC_Votes_Save_Model::wpvc_get_total_vote_count($pid);
					$result['button_flag'] = 2;
					$result['frequency'] = $freq;
					$result['success'] = 1;
					$result['msg'] = __('Voted Successfully ','voting-contest');
					$result['msg_html'] = "<div class='owt_success'><i class='wpvc_vote_icons voteconestant-success'></i>".__('You\'ve Voted!','voting-contest')."</div>";
					$result['votes'] = $total_v;
					$result['args'] = $args;
					
					if($option['vote_votingtype']!='' && $freq == 11){
						 $result['button_flag'] = 1; 
						 $result['tax_id'] = $termid;    
					}
					if($option['vote_votingtype']=='' && $freq == 11) {
						$result['button_flag'] = 2;
					}
				}
				header('content-type: application/json; charset=utf-8');
				echo $_GET['callback'] . '(' . json_encode($result) . ')';
				die();
			}
			else{
				wp_redirect( home_url() );
				die();	
			}
		}
			
		public static function wpvc_is_current_user_voted($pid, $ip, $termid){        
			$option = get_option(WPVC_VOTES_SETTINGS);
			$freq = $option['frequency']; 			
			if($freq == 11 && $option['vote_votingtype']!='') {
				$where .= 'AND `termid` = '.$termid.' AND `post_id` = ' . $pid;
			}
			$voted = WPVC_Votes_Save_Model::wpvc_check_is_votable($ip,$where);
			
			if(count($voted)){
				return true;
			}
			return false;
		}
		
				
		
		public static function wpvc_is_current_user_voted_post_id($pid, $ip, $termid){
			$where = "";
			$option = get_option(WPVC_VOTES_SETTINGS);
			$freq = $option['frequency']; 
						
			$where .= 'AND `termid` = '.$termid.' AND `post_id` = ' . $pid;			
			
			$voted = WPVC_Votes_Save_Model::wpvc_check_is_votable($ip,$where);
			
			if(count($voted)){
				return true;
			}
			return false;
		}
		
		public static function wpvc_check_contestant_is_votable($pid, $ip, $termid){       
			$option = get_option(WPVC_VOTES_SETTINGS);
			$freq = $option['frequency'];
			$vote_frequency_count = $option['vote_frequency_count'];
			$where = '';
				
				if($freq == 1){
					// Once per Calendar day
					$days = 1;
					$where .= 'AND (SELECT DATEDIFF("'.date("Y-m-d",current_time( 'timestamp', 0 )).'", `date`) < '.$days.' )';
				}				
							
				switch($freq){				
				
					case 11:					
						$where .= ' AND `termid` = '.$termid;						
						break;
					
				}
				$where .= ' AND `termid` = '.$termid;
				//echo $where;exit;
				$voted = WPVC_Votes_Save_Model::wpvc_check_is_votable($ip,$where);				
				
				
				switch($freq){
										
					case 1: 
						if($option['vote_frequency_count'] == 1 && $option['vote_votingtype'] == 0){
							if(count($voted) >= 1){
								return false;
							}
						}
						if(count($voted) && $option['vote_votingtype'] == 0){
							$first_voted_post_id = $voted[0]->post_id;					
							if($pid !== $first_voted_post_id)
								return false;
						}
						if(count($voted) && $option['vote_votingtype'] == 1){
							foreach($voted as $post_id){
								$first_voted_post_id[] = $post_id->post_id;
							}											
							if(in_array($pid,$first_voted_post_id))
								return false;							
						}
						if($option['vote_frequency_count'] == 1){
							if(count($voted) && $option['vote_votingtype'] == 2){
							foreach($voted as $post_id){
								$first_voted_post_id[] = $post_id->post_id;
							}											
							if(in_array($pid,$first_voted_post_id))
								return false;							
							}
						}
						break;
					
				}
				
				if($option['vote_frequency_count'] != 1){					
					if((count($voted) >= $option['vote_frequency_count']) && $freq !=0){
						return false;
					}
				}
				
				return true;
			
		}	
		
	}
}else
die("<h2>".__('Failed to load the Voting Save Controller','voting-contest')."</h2>");

return new WPVC_Vote_Save_Controller();
