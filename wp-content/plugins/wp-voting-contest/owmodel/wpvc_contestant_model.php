<?php
if(!class_exists('WPVC_Contestant_Model')){
	class WPVC_Contestant_Model {
	    
	    public static function wpvc_get_votes_count_post($post){
			global $wpdb;
			$new_sql = "SELECT SUM(votes)  FROM " . WPVC_VOTES_TBL ." WHERE post_id =".$post->ID;
			$count_vote = $wpdb->get_var($new_sql);
			return $count_vote;
	    }
	   
	    
	    public static function wpvc_voting_insert_post_entry($cur_id,$val_serialized)
	    {
			global $wpdb;
			$wpdb->query("INSERT INTO " . WPVC_VOTES_POST_ENTRY_TABLE . " (post_id_map,field_values)". " VALUES ('".$cur_id."', '".$val_serialized. "')");
	    }
		
	    		
		public static function wpvc_voting_get_all_terms(){
			$terms = get_terms(WPVC_VOTES_TAXONOMY, array('hide_empty' => false));
			return $terms;
	    }
	    
	    public static function wpvc_voting_get_all_custom_fields(){
			global $wpdb;
			$sql = "SELECT * FROM " .WPVC_VOTES_ENTRY_CUSTOM_TABLE." WHERE delete_time = 0 order by sequence";
			$custom_fields = $wpdb->get_results($sql);
			return $custom_fields;
	    }
	    
		public static function wpvc_voting_get_all_custom_entries($post_id){
			global $wpdb;
			$sql1 = "SELECT * FROM " . WPVC_VOTES_POST_ENTRY_TABLE . " WHERE post_id_map  = '".$post_id."'";
			$custom_entries = $wpdb->get_results($sql1);
			return $custom_entries;
		}
		
		public static function wpvc_voting_contestant_update_field($val_serialized,$post_id){
			global $wpdb;
			$wpdb->query("UPDATE " . WPVC_VOTES_POST_ENTRY_TABLE . " SET field_values = '" . $val_serialized . "' WHERE post_id_map = '" . $post_id . "'");
		}
		    	    
	    public static function wpvc_total_votes_count(){
			global $wpdb;
			$sql = "SELECT id FROM " . WPVC_VOTES_TBL ;
			$total   =  $wpdb->get_results($sql);
			return $total;
	    }
		
		 public static function wpvc_total_votes(){
			global $wpdb;
			$sql = "SELECT SUM(votes) as total FROM " . WPVC_VOTES_TBL ;
			$total   =  $wpdb->get_row($sql);
			return $total->total;
	    }
	    
	    public static function wpvc_voting_log_entries($log_entries){		
			global $wpdb;
		
			if($log_entries['orderby'] == 'log.post_email'){
				
				if($log_entries['rpp'] != 'all')
					$sql = "SELECT log.*,pst.post_title,pst.post_author FROM " . WPVC_VOTES_TBL ." as log LEFT JOIN ".$wpdb->prefix."posts as pst on log.post_id=pst.ID ORDER BY log.ip ".$log_entries['order']." LIMIT {$log_entries['startat']}, {$log_entries['rpp']} ";
				else
					$sql = "SELECT log.*,pst.post_title,pst.post_author FROM " . WPVC_VOTES_TBL ." as log LEFT JOIN ".$wpdb->prefix."posts as pst on log.post_id=pst.ID ORDER BY log.ip ".$log_entries['order'];
					
				//$sql = "SELECT log.*,pst.post_title,pst.post_author FROM " . WPVC_VOTES_TBL ." as log LEFT JOIN ".$wpdb->prefix."posts as pst on log.post_id=pst.ID ORDER BY log.ip ".$log_entries['order']." LIMIT {$log_entries['startat']}, {$log_entries['rpp']} ";
			}
			else{		
				if($log_entries['rpp'] != 'all')
					$sql = "SELECT log.*,pst.post_title,pst.post_author FROM " . WPVC_VOTES_TBL ." as log LEFT JOIN ".$wpdb->prefix."posts as pst on log.post_id=pst.ID ORDER BY ".$log_entries['orderby']." ".$log_entries['order']." LIMIT {$log_entries['startat']}, {$log_entries['rpp']} ";
				else
					$sql = "SELECT log.*,pst.post_title,pst.post_author FROM " . WPVC_VOTES_TBL ." as log LEFT JOIN ".$wpdb->prefix."posts as pst on log.post_id=pst.ID ORDER BY ".$log_entries['orderby']." ".$log_entries['order'];
			}
			$log_entries = $wpdb->get_results($sql);
			return $log_entries;
	    }
		
		public static function wpvc_vote_contestant_bulk_pending($exploded_ids){
			global $wpdb;
			 //Get the Status Changing Contestants
            $query = "SELECT ID FROM $wpdb->posts WHERE ID IN ({$exploded_ids}) AND post_status = 'pending'";          
            $result_ids = $wpdb->get_results($query,'ARRAY_A');
			return $result_ids;
		}
		
		public static function wpvc_voting_delete_entries($vote_id,$id){
			global $wpdb;
			//Get the Count of Votes 
			$no_votes = $wpdb->get_var( "SELECT votes FROM ".WPVC_VOTES_TBL." WHERE id = ".$id);
			$wpdb->delete( WPVC_VOTES_TBL, array( 'id' => $id ), array( '%d' )  );
			$vote_count = get_post_meta( $vote_id, WPVC_VOTES_CUSTOMFIELD, true );
			if($vote_count != 0)
				update_post_meta($vote_id, WPVC_VOTES_CUSTOMFIELD, $vote_count - $no_votes, $vote_count);
		}
		
	        
		public static function wpvc_voting_delete_post_entry_track($wpvc_contestant_author,$term_id){
			global $wpdb;
			
			if (!filter_var($wpvc_contestant_author, FILTER_VALIDATE_IP) === false) {
				$where = ' ip = '.$wpvc_contestant_author;
			} else {
				$where = ' user_id_map = '.$wpvc_contestant_author;
			}			
			$save_sql = "UPDATE " . WPVC_VOTES_POST_ENTRY_TRACK . " SET count_post= count_post -1 WHERE ".$where." and wpvc_term_id='".$term_id."'";		
			$wpdb->query($save_sql);
		}
		
		
		
	}
}else
die("<h2>".__('Failed to load Voting contestant model')."</h2>");
?>
