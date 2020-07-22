<?php
if(!function_exists('wpvc_vote_contestant_custom_field_list_view')){
    function wpvc_vote_contestant_custom_field_list_view($custom_fields=NULL){
	wp_register_style('WPVC_ADMIN_STYLES', WPVC_ASSETS_ADMIN_CSS_PATH);
	wp_enqueue_style('WPVC_ADMIN_STYLES');
	
	wp_register_style('wpvc_vote_datatable_style', WPVC_ASSETS_CSS_PATH.'wpvc_data_tables.css');
	wp_enqueue_style('wpvc_vote_datatable_style');

	wp_register_script('wpvc_votes_data_tables', WPVC_ASSETS_JS_PATH . 'wpvc_vote_data_tables.js');
	wp_enqueue_script('wpvc_votes_data_tables',array('jquery'));
	
	wp_register_script('wpvc_votes_validate_js', WPVC_ASSETS_JS_PATH . 'wpvc_vote_validate.js');
	wp_enqueue_script('wpvc_votes_validate_js',array('jquery'));
		
	wp_enqueue_script('postbox');
	wp_localize_script( 'wpvc_votes_data_tables', 'WPVC_VOTES_LINKS', array('ajaxurl' => admin_url('admin-ajax.php'), 'plugin_url' => WPVC_VOTES_PATH) );
	?>

	<div class="wrap">
	    
	    <h2><?php echo _e('Manage Contestant Custom Fields','voting-contest') ?></h2>
	    
        <?php echo wpvc_add_custom_field_settings(); ?>
	    
	    <form id="form1" name="form1" method="post" action="">
		<table id="custom_table" class="widefat manage-questions">
		    <thead>
			<tr>
			    <th class="manage-column" id="cb" scope="col" style="width:3%;" ></th>
	
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:22%;">
				    <?php _e('Field Name','voting-contest'); ?>
			    </th>
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:15%;">
				    <?php _e('Values','voting-contest'); ?>
			    </th>
	
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort"  style="width:10%;">
				    <?php _e('Type','voting-contest'); ?>
			    </th>
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:10%;">
				    <?php _e('Required','voting-contest'); ?>
			    </th>
	
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:10%;">
				    <?php _e('Show in Form','voting-contest'); ?>
			    </th>
	
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:12%;">
				    <?php _e('Show in Description','voting-contest'); ?>
			    </th>
			    <th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:10%;">
				    <?php _e('Order Sequence','voting-contest'); ?>
			    </th>
				<th class="manage-column column-title" id="values" scope="col" title="Click to Sort" style="width:10%;">
				    <?php _e('Custom Field Name','voting-contest'); ?>
			    </th>
			</tr>
		    </thead>
		    
		    <tbody>
			<?php
			if ( is_super_admin() || is_admin() ) {
			    if(!empty($custom_fields)){
				foreach ($custom_fields as $contestant_field) {
				    $custfield_id = $contestant_field->id;
				    $custfield_name = stripslashes($contestant_field->question);
				    $values = stripslashes($contestant_field->response);
				    $custfield_type = stripslashes($contestant_field->question_type);
				    $required = stripslashes($contestant_field->required);
				    $system_name = $contestant_field->system_name;
				    $sequence = $contestant_field->sequence;
				    $admin_only = $contestant_field->admin_only;
				    $admin_view = $contestant_field->admin_view;
				    
				    $cursor_move = ($system_name != "contestant-desc" && $system_name != "contestant-image" && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link")?'style="cursor: move"':"";
				   
				    $tr_id = ($system_name != "contestant-desc")?$custfield_id:"contestants-desc";				    
				    $tr_title = ($system_name != "contestant-title" && $system_name != "contestant-image" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link")?$custfield_id:"contestants-title";		    
				    $tr_id = ($tr_title == "contestants-title")?$tr_title:$tr_id;
				    
				    ?>
				    
				    <tr <?php echo $cursor_move; ?> id="<?php echo $tr_id ?>">
				    
					<td class="checkboxcol">
					    <input name="rwpvc_id" type="hidden" value="<?php echo $custfield_id ?>" />
					     <?php if($system_name != "contestant-desc" && $system_name != "contestant-image" && $system_name != "contestant-email_address" && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != 'contestant-wpvc_video_upload_url' && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link"): ?>
						 <input name="checkbox[<?php echo $custfield_id ?>]" type="checkbox" class="question_checkbox"  title="Delete <?php echo $custfield_name ?>" />
					     <?php endif; ?>
					</td>
					
					<td class="post-title page-title column-title">
					    <strong><a href="admin.php?page=fieldcontestant&amp;vote_action=edit_fields&amp;field_id=<?php echo $custfield_id ?>"><?php echo $custfield_name ?></a></strong>
						<div class="row-actions">
						    <?php $separator_ed = ($system_name != "contestant-desc" && $system_name != "contestant-image" && $system_name != "contestant-email_address"  && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link" && $system_name !="contestant-wpvc_video_upload_url")?"|":""; ?>
							<span class="edit"><a href="admin.php?page=fieldcontestant&amp;vote_action=edit_fields&amp;field_id=<?php echo $custfield_id ?>"><?php _e('Edit','voting-contest'); ?></a> <?php echo $separator_ed ?> </span>
						    <?php if($system_name != "contestant-desc" && $system_name != "contestant-image" && $system_name != "contestant-email_address"  && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url"  && $system_name != "contestant-ow_music_url_link" && $system_name !="contestant-wpvc_video_upload_url"): ?>
							<span class="delete"><a onclick="return wpvc_confirmDelete('single');" class="submitdelete"  href="admin.php?page=fieldcontestant&amp;vote_action=delete_fields&amp;field_id=<?php echo $custfield_id ?>"><?php _e('Delete','voting-contest'); ?></a></span>
						    <?php endif; ?>
						</div>
					</td>
					<td class="author column-author"><?php echo str_replace("-"," ",$values); ?></td>
					
				    <?php 
				    if($custfield_type=='SINGLE')
					$custfield_type = 'RADIO';
				    else if($custfield_type=='MULTIPLE')
					$custfield_type = 'CHECKBOX';
				    ?>
					    <td class="author column-author"><?php echo $custfield_type ?></td>
					    <td class="author column-author"><?php echo $required ?></td>
					    <td class="author column-author"><?php echo $admin_only ?></td>
					    <td class="author column-author"><?php echo $admin_view ?></td>
					    <td class="author column-author"><?php echo $sequence ?></td>
					    <td class="author column-author">
							<textarea onclick="wpvc_copyFunction(this,'<?php echo $system_name;?>');" id="<?php echo 'text_area_'.$system_name ?>" class="form_build_textarea" rows="2" readonly="readonly" title="Click to Copy"><?php echo ($system_name != "contestant-desc" && $system_name != "contestant-image" && $system_name != "contestant-email_address"  && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link")?'customfield_'.$system_name:$system_name; ?></textarea>
						</td>
				    </tr>				    
				    <?php
				}
			    }
			}
			?>			
		    </tbody>
		</table>
	  
	    
	    <div>
		<p><input type="checkbox" name="sAll" onclick="wpvc_selectAll(this)" class="select_checkbox" />
		    <strong>
			    <?php _e('Check All','voting-contest'); ?>
		    </strong>
		    <input type="hidden" name="vote_action" value="delete_fields" />
		    <input name="delete_question" type="submit" class="button-secondary" id="delete_question" value="<?php _e('Delete Field','voting-contest'); ?>" onclick="return wpvc_confirmDelete('multiple');">
		    
		</p>
	    </div>
	    </form>
	</div>	
	
	<script>
	    jQuery(document).ready(function($) {			
		/* show the table data */
		var mytable = jQuery('#custom_table').wpvc_vote_dataTable({
			"bStateSave": true,
			"sPaginationType": "full_numbers",
		
			"fnDrawCallback": function( oSettings ) {
				jQuery('.question_checkbox').attr('checked',false);
				if(jQuery('.select_checkbox').is(':checked')){
				  jQuery('.select_checkbox').attr('checked',false);
				}
			},
			"oLanguage": {
				"sSearch": "<strong><?php _e('Live Search Filter', 'voting-contest'); ?>:</strong>",
				"sZeroRecords": "<?php _e('No Records Found!', 'voting-contest'); ?>"
			},
			"aoColumns": [
				{ "bSortable": false },
				null,null,null,null,null,null,null,null
			]    
		});
		
		jQuery('#new-question-form').wpvc_vote_validate({
			wpvc_vote_rules: {
				custfield: "required",
				values: "required",
				sequence:{number: true}
			},
			wpvc_vote_messages: {
				custfield: "<?php _e('Please add a field name','voting-contest'); ?>",
				values: "<?php _e('Please add a list of values for the field','voting-contest'); ?>",
				sequence:{number: "Please enter the numeric values"}
			}
		});
				
		var startPosition;
		var endPosition;
		jQuery("#custom_table tbody").sortable({
		    cursor: "move",
		    items: 'tr[id!=contestants-desc][id!=contestants-title]',
		    start:function(event, ui){    
			    startPosition = ui.item.prevAll().length + 1;
		    },
		    update: function(event, ui) {
			    endPosition = ui.item.prevAll().length + 1;
			    var rwpvc_ids="";
			    jQuery('#custom_table tbody input[name="rwpvc_id"]').each(function(i){
				    rwpvc_ids= rwpvc_ids + ',' + jQuery(this).val();
			    });
			    jQuery.post(WPVC_VOTES_LINKS.ajaxurl, { action: "wpvc_vote_update_sequence", rwpvc_ids: rwpvc_ids} );
		    }
		});
		postboxes.add_postbox_toggles('form_builder');    	
	    });
		
		// Remove li parent for input 'values' from page if 'text' box or 'textarea' are selected
	    var selectValue = jQuery('select#custfield_type option:selected').val(); 
	    // hide values field on initial page view
	    if(selectValue == 'TEXT' || selectValue == 'TEXTAREA' || selectValue == 'DATE' || selectValue == 'FILE'){
		    jQuery('#add-question-values').hide();		   
		    // we don't want the values field trying to validate if not displayed, remove its name
		    jQuery('#add-question-values td input').attr("name","notrequired");
		    
		    jQuery('.add-extension-values, .add-extension-values1').hide();
			
		    // we don't want the values field trying to validate if not displayed, remove its name
		    jQuery('.add-extension-values td input').attr("name","notrequired");
			
	    }
	    
	    if (selectValue == 'FILE') {
		     jQuery('.add-extension-values,.add-extension-values1').show();
		     jQuery('.add-extension-values td input').attr("name","file_types");			 
	    }
		
		if (selectValue == 'DATE') {
		    jQuery('#add-date-values').show();		     	 
	    }else{
			jQuery('#add-date-values').hide();		
		}
		
	    jQuery('select#custfield_type').bind('change', function() {
			var selectValue = jQuery('select#custfield_type option:selected').val();
				
			if (selectValue == 'TEXT' || selectValue == 'TEXTAREA' || selectValue == 'DATE') {
				jQuery('#add-question-values').fadeOut('slow');				
				// we don't want the values field trying to validate if not displayed, remove its name
				jQuery('#add-question-values td input').attr("name","notrequired");
				
				jQuery('.add-extension-values, .add-extension-values1').fadeOut('slow');
				// we don't want the values field trying to validate if not displayed, remove its name
				jQuery('.add-extension-values td input').attr("name","notrequired");	
			}
			else if(selectValue == 'FILE'){
				jQuery('#add-question-values, .add-extension-values1').fadeOut('slow');
				// we don't want the values field trying to validate if not displayed, remove its name
				jQuery('#add-question-values td input').attr("name","notrequired");
				
				jQuery('.add-extension-values, .add-extension-values1').fadeIn('slow');
				// add the correct name value back in so we can run validation check.
				jQuery('.add-extension-values td input').attr("name","file_types");	
			}else{
				jQuery('#add-question-values').fadeIn('slow');
				// add the correct name value back in so we can run validation check.
				jQuery('#add-question-values td input').attr("name","values");
				
				jQuery('.add-extension-values, .add-extension-values1').fadeOut('slow');
				// add the correct name value back in so we can run validation check.
				jQuery('.add-extension-values td input').attr("name","notrequired");	
			}
			
			if (selectValue == 'DATE') {
				jQuery('#add-date-values').fadeIn('slow');		     	 
			}else{
				jQuery('#add-date-values').fadeOut('slow');		
			}
		
	    });
		
		function wpvc_selectAll(x) {
			if(x.checked){
				jQuery('.question_checkbox').attr('checked',true);
			}else{
				jQuery('.question_checkbox').attr('checked',false);
			}
		}
		
		function wpvc_confirmDelete(seld){
			if(seld=='multiple'){
				if(jQuery('.question_checkbox').is(':checked')){
					if (confirm('<?php _e("Are you sure want to delete?","voting-contest"); ?>')){
					  return true;
					}
					}else{
						alert('<?php _e("Select atleast one field to delete!","voting-contest"); ?>');
					}
				return false;
			}
			else{
				return true;
			}
	    }
		
		function wpvc_copyFunction(textarea,id) {
			/* Get the text field */
			var copyText = textarea;
			/* Select the text field */
			copyText.select();
			/* Copy the text inside the text field */
			document.execCommand("Copy");
			jQuery('.copy_text').remove();
			jQuery( '<p class="copy_text">Copied the text:'+ copyText.value+'</p>').insertAfter('#text_area_'+id);
		}
	</script>
	
    <?php
	}
}else{
    die("<h2>".__('Failed to load Voting cotestant custom field list view','voting-contest')."</h2>");
}
?>
