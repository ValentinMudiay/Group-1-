<?php
if(!function_exists('wpvc_voting_add_custom_field_contestant')){
    function wpvc_voting_add_custom_field_contestant($custom_fields_id=NULL,$field_values=NULL){
	
	wp_enqueue_style('qtip', WPVC_ASSETS_CSS_PATH.'jquery.qtip.min.css', null, false, false);
	wp_enqueue_script('qtip', WPVC_ASSETS_JS_PATH . 'jquery.qtip.min.js', array('jquery'), false, true);
	
		$values=array(
			array('id'=>'Y','text'=> __('Yes','voting-contest')),
			array('id'=>'N','text'=> __('No','voting-contest'))
		);
		
		$date_values = array(
							array('id'=>'F d, Y','text'=> __('M d Y (Eg : March 20, 2016)','voting-contest')),
							array('id'=>'d m, Y','text'=> __('d M Y (Eg : 20 March, 2016)','voting-contest')),
							array('id'=>'d M, Y','text'=> __('d m Y (Eg : 20 Mar, 2016)','voting-contest')),
							array('id'=>'M d, Y','text'=> __('m d Y (Eg : Mar 20, 2016)','voting-contest')),
						);
	?>
	<div class="metabox-holder">
		<div class="postbox">
			<div title="<?php _e('Click to toggle','voting-contest'); ?>" class="handlediv"><br /></div>
			
			<?php if($custom_fields_id==''){ ?>		
			<h3 class="custom_field_h3"><?php _e('Add New Contestant Custom Fields','voting-contest'); ?></h3>
			<?php } else{ ?>
			<h3 class="custom_field_h3"><?php _e('Edit Contestant Custom Fields','voting-contest'); ?></h3>
			<?php } ?>
			
			<div class="inside">
							
				<form name="newquestion" method="post" action="" id="new-question-form">
					<table class="form-table new_contest_cust_fld">
						<tbody>
							<?php
							if($field_values->system_name == "contestant-title"){ ?>
							<tr>
								<td colspan="2"><?php _e('Title Notes:  The title field is a default field. You may rename it but you cannot delete it or change the sort order. The title field is needed to create a custom post type and a search engine friendly URL.','voting-contest'); ?></td>
							</tr>
							<?php } ?>
							<?php if($field_values->system_name == "contestant-ow_video_url"){ ?>
							<tr>
								<td colspan="2"><?php _e('Video Notes: The video field is a default field. You may rename it but you cannot delete it or change the sort order. The video field will only be shown on your contest form when the category type is set to video. <br />  Accepted link types are from YouTube, Vimeo, an MP4, OGG or WebM. ','voting-contest'); ?></td>
							</tr>
							<?php } ?>
							<?php if($field_values->system_name == "contestant-ow_music_url"){ ?>
							<tr>
								<td colspan="2"><?php _e('Music Notes: The music field is a default field. You may rename it but you cannot delete it or change the sort order. The music field will only be shown on your contest form when the category type is set to music. <br />  This field will only allow uploading of MP3. ','voting-contest'); ?></td>
							</tr>
							<?php } ?>
                            <?php if($field_values->system_name == "contestant-ow_music_url_link"){ ?>
							<tr>
								<td colspan="2"><?php _e('Music Link Notes: The music field is a default field. You may rename it but you cannot delete it or change the sort order. The music field will only be shown on your contest form when the category type is set to music.','voting-contest'); ?></td>
							</tr>
							<?php } ?>
							<?php if($field_values->system_name == "contestant-desc"){ ?>
							<tr>
								<td colspan="2"><?php _e('Description Notes: The description field is a default field. You may rename it but you cannot delete it or change the sort order. It is used for descriptions and embed codes such as the ones from SoundCloud or Video Websites.','voting-contest'); ?></td>
							</tr>
							<?php } ?>
                            <?php if($field_values->system_name == "contestant-email_address"){ ?>
							<tr>
								<td colspan="2"><?php _e('Email Notes: The email field is a default field. You may rename it but you cannot delete it or change the sort order. The email field is needed to for email notifications. This field will only be displayed if you have set the email notifications to YES for the Contestant Success Notification or Contestant Approved Notification.','voting-contest'); ?></td>
							</tr>
							<?php } ?>
							<tr>
								<th>
									<label for="custfield"><?php _e('Field Name'); ?><em title="<?php _e('This field is required','voting-contest') ?>"> *</em></label>
								</th>
								<td>
									<input class="custfield-name"  name="custfield" id="custfield" size="50" value="<?php echo $field_values->question;?>" type="text" />
									<div class="hasTooltip"></div>
									<div class="hidden">
									    <span class="description"><?php _e('Custom Field name','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<?php if(($field_values->question_type == "TEXT" || $field_values->question_type == "TEXTAREA") &&  $field_values->system_name != "contestant-ow_video_url" &&  $field_values->system_name != "contestant-ow_music_url_link"): ?>
							<tr>
								<th>
									<label class="inline" for="set_word_limit"><?php _e('Set Character Limit ','voting-contest'); ?></label>
								</th>
								<td>
									<?php 
									$req_drop = ($field_values->set_limit)?$field_values->set_limit:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('set_word_limit', $values, $req_drop);
								?>
								<div class="hasTooltip"></div>
								<div class="hidden">
								<span class="description"><?php _e('Set Character Limit for the Field.','voting-contest'); ?></span>
								</div>
								</td>
							</tr>
							
							<?php $display_show = ($req_drop == 'Y')?'display:run-in':'display:none'; ?>
							
							<tr class="set_word_limit_chars" style="<?php echo $display_show; ?>">
								<th>
									<label for="set_word_limit_chars"><?php _e('Set Character Limit Count','voting-contest'); ?></label>
								</th>
								<td>
									<input name="set_word_limit_chars" id="set_word_limit_chars" size="50" type="text" value="<?php echo $field_values->limit_count;?>" />
									<div class="hasTooltip"></div>
									<div class="hidden">
									<span class="description"><?php _e('Set Character Limit Count for the Field (Example : 50).','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							<?php  endif; ?>
							
							<?php if($field_values->system_name != "contestant-title" && $field_values->system_name != "contestant-ow_video_url" && $field_values->system_name != "contestant-ow_music_url_link" ): ?>
							
							<?php if($field_values->system_name != "contestant-ow_music_url" && $field_values->system_name != "contestant-image") { ?>
							<tr>
								<th id="custfield-type-select">
									<label for="custfield_type"><?php _e('Type','voting-contest'); ?></label>
								</th>
								<td>
								<?php
										$q_values	=	array(
											array('id'=>'TEXT','text'=> __('Text')),
											array('id'=>'TEXTAREA','text'=> __('Text Area')),
											array('id'=>'SINGLE','text'=> __('Radio Button')),
											array('id'=>'DROPDOWN','text'=> __('Drop Down')),
											array('id'=>'MULTIPLE','text'=> __('Checkbox')),
											array('id'=>'FILE','text'=> __('File')),
											array('id'=>'DATE','text'=> __('DatePicker'))
											);
										echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input( 'custfield_type', $q_values, $field_values->question_type, 'id="custfield_type"');
										
								?>
								<div class="hasTooltip"></div>
								<div class="hidden">
								<span class="description"><?php _e('Type of the Custom Field','voting-contest'); ?></span>
								</div>
								</td>
							</tr>
							
							
							<tr id="add-date-values">
								<th>
									<label class="inline" for="datepicker_only"><?php _e('Display Format ','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$date_only = get_option($field_values->system_name);
									$date_only = ($date_only)?$date_only:'F d, Y';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('datepicker_only', $date_values, $date_only);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('Select Date Display format inorder to show on front end','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							
							
							<tr id="add-question-values">
								<th>
									<label for="values"><?php _e('Values','voting-contest'); ?></label>
								</th>
								<td>
									<input name="values" id="values" size="50" value="<?php echo str_replace("-"," ",$field_values->response);?>" type="text" />
									<div class="hasTooltip"></div>
									<div class="hidden">
									<span class="description"><?php _e('A comma seperated list of values. Eg. black, blue, red','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<?php }
							else{
								echo '<input type="hidden" name="custfield_type" value="FILE" />';
							}
							?>
							
							
							<?php if($field_values->question_type == 'FILE'): ?>
                            <?php if($field_values->system_name == "contestant-ow_music_url"){ ?>
                                <input name="file_types" id="file_types" size="50" value="mp3" type="hidden" />               
                            <?php }else{ ?>
                                <tr class="add-extension-values">
                                    <th>
                                        <label for="file_types"><?php _e('Allowed File Types','voting-contest'); ?></label>
                                    </th>
                                    <td>
                                        <input name="file_types" id="file_types" size="50" value="<?php echo $field_values->response;?>" type="text" />
                                        <div class="hasTooltip"></div>
                                        <div class="hidden">
                                        <span class="description"><?php _e('A comma separated list of extensions. Eg. docx, pdf, doc','voting-contest'); ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
							
							<tr class="add-extension-values1">
								<th>
									<label for="file_types_size"><?php _e('Allowed File Size Limit','voting-contest'); ?></label>
								</th>
								<td>
									<input name="file_types_size" id="file_types_size" size="50" value="<?php echo $field_values->wpvc_file_size;?>" type="text" />
									<div class="hasTooltip"></div>
									<div class="hidden">
									<span class="description"><?php _e('Mention size upload limit in MB. Eg. 3 ','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							<?php endif; ?>
							<?php else: ?>
							<input type="hidden" name="custfield_type" value="TEXT" />
							<?php endif; ?>
							
							<?php if($field_values->system_name != "contestant-title" && $field_values->system_name != "contestant-ow_music_url"):
							//&& $field_values->system_name != "contestant-ow_video_url"
							?>
							<tr>
								<th>
									<label class="inline" for="required"><?php _e('Required:','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$req_drop = ($field_values->required)?$field_values->required:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('required', $values, $req_drop);
								?>
								<div class="hasTooltip"></div>
								<div class="hidden">
								<span class="description"><?php _e('Mark this question as required (Mandatory).','voting-contest'); ?></span>
								</div>
								</td>
							</tr>
							<?php else: ?>
							<input type="hidden" name="required" value="Y" />
							<?php endif; ?>
							
							<?php if($field_values->system_name != "contestant-title" && $field_values->system_name != "contestant-image" && $field_values->system_name != "contestant-ow_video_url" && $field_values->system_name != "contestant-ow_music_url_link" && $field_values->system_name != "contestant-ow_music_url"): ?>
							<tr>
								<th>
									<label class="inline" for="admin_only"><?php _e('Show in contestant form','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$admin_only = ($field_values->admin_only)?$field_values->admin_only:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('admin_only', $values, $admin_only);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('YES: Shows custom field in contestant form.  NO: Shows custom field in admin only','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<?php else: ?>
							<input type="hidden" name="admin_only" value="Y" />
							<?php endif; ?>
							
							<?php if($field_values->system_name != "contestant-title" && $field_values->system_name != "contestant-image" && $field_values->system_name != "contestant-ow_video_url" && $field_values->system_name != "contestant-ow_music_url" && $field_values->system_name != "contestant-ow_music_url_link"): ?>
							
							<tr>
								<th>
									<label class="inline" for="shwpvc_labels"><?php _e('Show Labels In Grid/List view','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$shwpvc_labels = ($field_values->shwpvc_labels)?$field_values->shwpvc_labels:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('shwpvc_labels', $values, $shwpvc_labels);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('YES: Show label in Grid/List View.  NO: Hide label in Grid/List only','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<tr>
								<th>
									<label class="inline" for="grid_only"><?php _e('Show in Grid View','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$grid_only = ($field_values->grid_only)?$field_values->grid_only:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('grid_only', $values, $grid_only);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('YES: Shows custom field in Grid View.  NO: Shows custom field in admin only','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<?php else: ?>
							<input type="hidden" name="grid_only" value="Y" />
							<input type="hidden" name="grid_only" value="Y" />
							<?php endif; ?>
							
							<?php if($field_values->system_name != "contestant-title" && $field_values->system_name != "contestant-image" && $field_values->system_name != "contestant-ow_video_url" && $field_values->system_name != "contestant-ow_music_url" && $field_values->system_name != "contestant-ow_music_url_link"): ?>
							<tr>
								<th>
									<label class="inline" for="list_only"><?php _e('Show in List View','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$list_only = ($field_values->list_only)?$field_values->list_only:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('list_only', $values, $list_only);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('YES: Shows custom field in List View.  NO: Shows custom field in admin only','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<?php else: ?>
							<input type="hidden" name="list_only" value="Y" />
							<?php endif; ?>
                    
							<?php if($field_values->system_name != "contestant-ow_video_url" && $field_values->system_name != "contestant-image" && $field_values->system_name != "contestant-ow_music_url" && $field_values->system_name != "contestant-ow_music_url_link"): ?>
							<tr>
								<th>
									<label class="inline" for="admin_view"><?php _e('Show in Contest description page','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$admin_view = ($field_values->admin_view)?$field_values->admin_view:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('admin_view', $values, $admin_view);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('YES: Shows custom field details in Contestant description page.','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
                   
							<tr>
								<th>
									<label class="inline" for="admin_view"><?php _e('Show in PrettyPhoto Slideshow','voting-contest'); ?></label>
								</th>
								<td>
									<?php
									$pretty_view= ($field_values->pretty_view)?$field_values->pretty_view:'N';
									echo WPVC_Vote_Common_Controller::wpvc_votes_form_select_input('pretty_view', $values, $pretty_view);?>
									<div class="hasTooltip"></div>
									<div class="hidden">
								   <span class="description"><?php _e('YES: Shows custom field details in PrettyPhoto Slideshow.','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
					 <?php else: ?>
							<input type="hidden" name="admin_view" value="Y" />
                     <?php endif; ?>
							<tr>
								<th>
									<label for="required_text"><?php _e('Required Text','voting-contest'); ?></label>
								</th>
								<td>
									<input name="required_text" id="required_text" size="50" type="text" value="<?php echo $field_values->required_text;?>" />
									<div class="hasTooltip"></div>
									<div class="hidden">
									<span class="description"><?php _e('Text to display if field is empty. (Validation Error Message)','voting-contest'); ?></span>
									</div>
								</td>
							</tr>
							
							<tr>
								<th>
									<label for="sequence"><?php   _e('Order/Sequence','voting-contest'); ?></label>
								</th>
								<td>
									<?php $sequence = ($field_values->sequence)?$field_values->sequence:'0'; ?>
								<input name="sequence" id="sequence" size="50" value="<?php if(isset($sequence)) echo $sequence; ?>" type="text" />           	
								  
								  <div class="hasTooltip"></div>
								  <div class="hidden">
								    <span class="description"><?php _e('Order the view of the field by numeric values Ex:(Entering 1- will show first, 2- will be shown second.. etc)','voting-contest'); ?></span>
								    </div>
								</td>
							</tr>
						</tbody>
					</table>
					
					<p class="submit-footer">
						<?php if($custom_fields_id==''){ ?>	
							<input name="vote_action" value="insert_customfield" type="hidden" />
						<?php }else{ ?>
							<input type="hidden" name="vote_action" value="edit_customfield">
							<input name="custom_fields_id" value="<?php echo $custom_fields_id; ?>" type="hidden">
						<?php } ?>
						<?php if($custom_fields_id==''){ ?>	
							<input class="button-primary" name="Submit" value="<?php _e('Add Custom Fields','voting-contest'); ?>" type="submit" />
						<?php }else{ ?>
							<input type="hidden" name="system_name" value="<?php echo $field_values->system_name; ?>" />
							<input class="button-primary" name="Submit" value="<?php _e('Update Custom Fields','voting-contest'); ?>" type="submit" />
						<?php } ?>
					</p>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function(){    
	    jQuery('.hasTooltip').each(function() { // Notice the .each() loop, discussed below
			jQuery(this).qtip({
			content: {
				text: jQuery(this).next('div') // Use the "div" element next to this for the content
			}
			});
	    });
		
		jQuery('#set_word_limit').change(function (){
			var value = this.value;
			if(value == 'Y'){
				jQuery('.set_word_limit_chars').show();
			}
			else{
				jQuery('.set_word_limit_chars').hide();
			}
		});
	});
	</script>
	<?php
	}
}else{
    die("<h2>".__('Failed to load Voting cotestant custom field add view','voting-contest')."</h2>");
}

