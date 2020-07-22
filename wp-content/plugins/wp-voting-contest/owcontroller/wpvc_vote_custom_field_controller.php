<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Custom_Field_Controller')){
    class WPVC_Vote_Custom_Field_Controller{
			
		//Contestant custom fields metabox
		public static function wpvc_votes_contestant_custom_field_meta_box()
		{
			global $wpdb;	    			
			$custom_field_action = isset($_POST['vote_action'])?$_POST['vote_action']:isset($_GET['vote_action'])?$_GET['vote_action']:'';
			$custom_fields_id = isset($_GET['field_id'])?$_GET['field_id']:'';
			switch ($custom_field_action) {
				
				case 'edit_fields':
					WPVC_Vote_Custom_Field_Controller::wpvc_vote_contestant_custom_field_edit($custom_fields_id);
					break;
				
				case 'edit_customfield':
					WPVC_Vote_Custom_Field_Controller::wpvc_votes_contestant_insert_custom_field($custom_fields_id);
					break;				
			}
			require_once(WPVC_VIEW_PATH.'wpvc_vote_contestant_custom_field_list_view.php');
			$custom_fields = WPVC_Contestant_Model::wpvc_voting_get_all_custom_fields();			
			wpvc_vote_contestant_custom_field_list_view($custom_fields);
		}			
		
			
		public static function wpvc_vote_contestant_custom_field_edit($custom_fields_id){
			require_once(WPVC_VIEW_PATH.'wpvc_vote_contestant_custom_field_crud_view.php');
			$field_values = WPVC_Custom_Field_Model::wpvc_get_contestant_custom_field_by_id($custom_fields_id);
			wpvc_voting_add_custom_field_contestant($custom_fields_id,$field_values);
			return;
		}
		
		public static function wpvc_votes_contestant_insert_custom_field($custom_fields_id=NULL){
			global $wpdb,$current_user; 
			$go_insert = true;
			
			if($_POST['custfield']!='')
				$insert_data['custfield'] = str_replace("'", "&#039", $_POST['custfield']);
			else{
				$go_insert=false;
			}
			$insert_data['custfield_type'] = $_POST['custfield_type'];
			$insert_data['custfield_values'] = empty($_POST['values']) ? NULL : WPVC_Vote_Common_Controller::wpvc_vote_hyphenize_string($_POST['values']);
			if($insert_data['custfield_values'] == NULL){
				$insert_data['custfield_values'] = empty($_POST['file_types']) ? NULL : WPVC_Vote_Common_Controller::wpvc_vote_hyphenize_string($_POST['file_types']);
			}
			$insert_data['wpvc_file_size'] = !empty($_POST['file_types_size']) ? $_POST['file_types_size']:0;  
			$insert_data['required'] = !empty($_POST['required']) ? $_POST['required']:'N';  
			$insert_data['required_text'] = $_POST['required_text']; 
			$insert_data['admin_only'] = !empty($_POST['admin_only']) ? $_POST['admin_only']:'N';
			$insert_data['shwpvc_labels'] = !empty($_POST['shwpvc_labels']) ? $_POST['shwpvc_labels']:'N';
			$insert_data['grid_only'] = !empty($_POST['grid_only']) ? $_POST['grid_only']:'N';
			$insert_data['list_only'] = !empty($_POST['list_only']) ? $_POST['list_only']:'N';
			$insert_data['sequence'] = $_POST['sequence'] ?  $_POST['sequence']:'0';
			$insert_data['system_name'] = uniqid();
			$insert_data['admin_view'] = $_POST['admin_view']; 
			$insert_data['pretty_view'] = $_POST['pretty_view'];
			$insert_data['set_word_limit'] = !empty($_POST['set_word_limit']) ? $_POST['set_word_limit']:'N';
			$insert_data['set_word_limit_chars'] = $_POST['set_word_limit_chars'];
			$insert_data['current_id']=$current_user->ID;
			
			
			if($go_insert){
				if($custom_fields_id==''){
					$system_name = $insert_data['system_name'];
					$insert_cf = WPVC_Custom_Field_Model::wpvc_insert_contestant_custom_field($insert_data);
					if ($insert_cf){?>
						<div id="message" class="updated fade"><p><strong><?php _e('The Custom Field ','voting-contest'); ?><?php echo htmlentities2($insert_data['custfield']);?> <?php _e('has been added.','voting-contest'); ?></strong></p></div>
					<?php
					}else { ?>
						<div id="message" class="error"><p><strong><?php _e('The Custom Field ','voting-contest'); ?> <?php echo htmlentities2($insert_data['custfield']);?> <?php _e('was not saved.','voting-contest'); ?> <?php $wpdb->print_error(); ?>.</strong></p></div>
					<?php
					}
				}else{
					$system_name = $_POST['system_name'];
					$update_cf = WPVC_Custom_Field_Model::wpvc_update_contestant_custom_field($custom_fields_id,$insert_data);
					if ($update_cf){?>
						<div id="message" class="updated fade"><p><strong><?php _e('The Custom Field ','voting-contest'); ?><?php echo htmlentities2($insert_data['custfield']);?> <?php _e('has been Updated.','voting-contest'); ?></strong></p></div>
					<?php
					}
				}
				
				//Update for DatePicker Field
				if(isset($_POST['datepicker_only']) && $_POST['custfield_type'] == "DATE")
					update_option($system_name,$_POST['datepicker_only']);
						
			}else{
			?>
				<div id="message" class="error"><p><strong><?php _e('Please enter the title for custom field.','voting-contest'); ?>.</strong></p></div>
			<?php   
			}
		}
					
    }
}else
die("<h2>".__('Failed to load Voting Custom Field Controller','voting-contest')."</h2>");

return new WPVC_Vote_Custom_Field_Controller();
