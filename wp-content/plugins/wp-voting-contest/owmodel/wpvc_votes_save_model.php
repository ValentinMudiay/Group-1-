<?php
if(!class_exists('WPVC_Votes_Save_Model')){
	class WPVC_Votes_Save_Model {
	  
		public static function wpvc_check_is_votable($ip,$where){
			global $wpdb;
			$vote_sql = 'SELECT * FROM `' . WPVC_VOTES_TBL . '` WHERE `ip` =  "' . $ip . '" '.$where;
			//echo $vote_sql;exit;
			$voted = $wpdb->get_results($vote_sql);
			return $voted;
		}

		public static function wpvc_update_vote_contestant($ip,$vote_count,$pid,$termid,$ip_always = null,$email_always = null,$flag=null){
			global $wpdb;
			$catopt = get_option($termid. '_' . WPVC_VOTES_SETTINGS);			
			if($flag != 1){
				$vote_count = $catopt['vote_count_per_contest'];
			}			
			$save_sql = 'INSERT INTO `' . WPVC_VOTES_TBL . '` (`ip` , `votes` , `post_id` , `termid` , `date` ,`ip_always`,`email_always` )
					VALUES ( "' . $ip . '", "'.$vote_count.'"  , ' . $pid . ', "'.$termid.'", "'.date("Y-m-d H:i:s",current_time( 'timestamp', 0 )).'","' . $ip_always . '","' . $email_always . '" ) ';

			$wpdb->query($save_sql);  
		}
		
		public static function wpvc_get_total_vote_count($pid){
			global $wpdb;
			$new_sql = "SELECT SUM(votes)  FROM " . WPVC_VOTES_TBL ." WHERE post_id =".$pid;
			$total_v =  $wpdb->get_var($new_sql);
			update_post_meta($pid, WPVC_VOTES_CUSTOMFIELD, $total_v);
			return $total_v;
		}
		
		
	}
	
}else
die("<h2>".__('Failed to load Voting Save model')."</h2>");
?>