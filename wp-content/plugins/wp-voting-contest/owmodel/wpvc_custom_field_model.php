<?php
if(!class_exists('WPVC_Custom_Field_Model')){
	class WPVC_Custom_Field_Model {
	    
		public static function wpvc_insert_contestant_custom_field($input_data){
			global $wpdb;
			$insert = $wpdb->query("INSERT INTO ".WPVC_VOTES_ENTRY_CUSTOM_TABLE." (question_type, question, system_name, response, required, admin_only,required_text, sequence,wp_user,admin_view,pretty_view,wpvc_file_size,grid_only,list_only,shwpvc_labels,set_limit,limit_count)"
					 . " VALUES ('" . $input_data['custfield_type'] . "', '" . $input_data['custfield'] . "', '" . $input_data['system_name'] . "', '"  . $input_data['custfield_values'] . "', '" . $input_data['required'] . "', '" . $input_data['admin_only'] . "', '" . $input_data['required_text'] . "', '" . $input_data['sequence'] . "','".$input_data['current_id']. "','".$input_data['admin_view']."','".$input_data['pretty_view']."','".$input_data['wpvc_file_size']."','".$input_data['grid_only']."','".$input_data['list_only']."','".$input_data['shwpvc_labels']."','".$input_data['set_word_limit']."','".$input_data['set_word_limit_chars']."')");
			return $insert;
		}
		
		public static function wpvc_update_contestant_custom_field($custom_fields_id,$input_data){
			global $wpdb;
			$update = $wpdb->query("UPDATE " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " SET question_type = '" . $input_data['custfield_type'] . "', question = '" . $input_data['custfield'] . "', response = '" . $input_data['custfield_values'] . "', required = '" . $input_data['required'] . "',admin_only = '" . $input_data['admin_only'] . "', required_text = '" . $input_data['required_text'] . "',pretty_view = '" . $input_data['pretty_view']  . "', wpvc_file_size = '" . $input_data['wpvc_file_size'] . "', sequence = '" . $input_data['sequence'] . "',admin_view = '" . $input_data['admin_view'] . "',grid_only = '" . $input_data['grid_only'] . "',list_only = '" . $input_data['list_only'] . "',shwpvc_labels = '" . $input_data['shwpvc_labels'] . "',set_limit = '" . $input_data['set_word_limit'] . "',limit_count = '" . $input_data['set_word_limit_chars'] . "' WHERE id = '" . $custom_fields_id . "'");
			
			
			return $update;
		}
		
		public static function wpvc_get_contestant_custom_field_by_id($custom_fields_id)
		{
			global $wpdb;
			$sql = "SELECT * FROM " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " WHERE id = '" . $custom_fields_id . "'";
			$custom_fields = $wpdb->get_row($sql);
			return $custom_fields;
		}
		
		
		public static function wpvc_custom_field_update_sequence($i,$rwpvc_id){
			global $wpdb;
			$wpdb->query("UPDATE " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " SET sequence=" . $i . " WHERE id='" .$rwpvc_id. "'");
		}
		
		/*********** User functions **********/
		
		public static function wpvc_voting_user_get_all_custom_fields(){
			global $wpdb;
			$sql = "SELECT * FROM " .WPVC_VOTES_USER_CUSTOM_TABLE." WHERE delete_time = 0 order by sequence";
			$question = $wpdb->get_results($sql);
			return $question;
	    }
	
		public static function wpvc_custom_field_user_update_sequence($i,$rwpvc_id){
			global $wpdb;
			$wpdb->query("UPDATE " . WPVC_VOTES_USER_CUSTOM_TABLE . " SET sequence=" . $i . " WHERE id='" .$rwpvc_id. "'");
		}
		
	}
}else
die("<h2>".__('Failed to load Voting Custom Field model')."</h2>");
?>