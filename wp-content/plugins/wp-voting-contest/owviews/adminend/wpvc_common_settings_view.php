<?php
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script('wp-color-picker');
wp_register_style('WPVC_ADMIN_STYLES', WPVC_ASSETS_ADMIN_CSS_PATH);
wp_enqueue_style('WPVC_ADMIN_STYLES');

if(!function_exists('wpvc_common_settings_view')){
    
    function wpvc_common_settings_view($selected){
		
	wp_register_style('wpvc_tabs_setting', WPVC_ASSETS_CSS_PATH.'wpvc_tabs.css');
	wp_enqueue_style('wpvc_tabs_setting');
	
	wp_register_script('wpvc_admin_js', WPVC_ASSETS_JS_PATH . 'wpvc_admin_js.js');
	wp_enqueue_script('wpvc_admin_js',array('jquery'));
    
	wp_enqueue_style('qtip', WPVC_ASSETS_CSS_PATH.'jquery.qtip.min.css', null, false, false);
	wp_enqueue_script('qtip', WPVC_ASSETS_JS_PATH . 'jquery.qtip.min.js', array('jquery'), false, true);
	
?>
	
	<div class="sidebar_wpvc_vote">
		<a id="mobile-toggle-menu"><?php _e('Settings Menu') ?><span class="wt-arrow"></span></a>
		<nav class="wpvc_settings_menu">
		    
			<ul>
				
				<li class="<?php echo ($selected=='common')?'current':'';?>">
					<a href="admin.php?page=votes_settings&vote_action=common" class="wpvc_set_links">
					<span class="owvotingicon owfa-list"></span>
					<span class="wpvc_vote_links"><?php _e('Common Settings','voting-contest'); ?></span>
					</a>
				</li>
				
				<li class="<?php echo ($selected=='contest')?'current':'';?>">
					<a href="admin.php?page=votes_settings&vote_action=contest" class="wpvc_set_links">
					<span class="owvotingicon owfa-camera"></span>
					<span class="wpvc_vote_links"><?php _e('Contest Settings','voting-contest'); ?></span>
					</a>
				</li>
				
				<li class="<?php echo ($selected=='color')?'current':'';?>">
					<a href="admin.php?page=votes_settings&vote_action=color" class="wpvc_set_links">
					<span class="owvotingicon owfa-color"></span>
					<span class="wpvc_vote_links"><?php _e('Style Settings','voting-contest'); ?></span>
					</a>
				</li>
					
				<li class="<?php echo ($selected=='share')?'current':'';?>" >
					<a href="admin.php?page=votes_settings&vote_action=share" class="wpvc_set_links">
					<span class="owvotingicon owfa-share-alt"></span>
					<span class="wpvc_vote_links"><?php _e('Share Settings','voting-contest'); ?></span>
					</a>
				</li>
				
				<li class="<?php echo ($selected=='script')?'current':'';?>">
					<a href="admin.php?page=votes_settings&vote_action=script" class="wpvc_set_links">
					<span class="owvotingicon owfa-strikethrough"></span>
					<span class="wpvc_vote_links"><?php _e('Script Settings','voting-contest'); ?></span>
					</a>
				</li>
				
				<li class="<?php echo ($selected=='expert')?'current':'';?>">
					<a href="admin.php?page=votes_settings&vote_action=expert" class="wpvc_set_links">
					<span class="owvotingicon owfa-eraser"></span>
					<span class="wpvc_vote_links"><?php _e('Excerpt Settings','voting-contest'); ?></span>
					</a>
				</li>
				
				<li class="<?php echo ($selected=='paginate')?'current':'';?>">
					<a href="admin.php?page=votes_setting_paginate" class="wpvc_set_links">
					<span class="owvotingicon owfa-sort-numeric-asc"></span>
					<span class="wpvc_vote_links"><?php _e('Pagination Settings','voting-contest'); ?></span>
					</a>
				</li>
				
				<li class="<?php echo ($selected=='emailnotification')?'current':'';?>">
					<a href="admin.php?page=votes_settings&vote_action=emailnotification" class="wpvc_set_links">
					<span class="owvotingicon owfa-email"></span>
					<span class="wpvc_vote_links"><?php _e('Email Notifications','voting-contest'); ?></span>
					</a>
				</li>
				
				
			</ul>
		</nav>
	</div>
	<?php
    }
}else{
    die("<h2>".__('Failed to load Voting common menu view','voting-contest')."</h2>");
}

if(!function_exists('wpvc_contest_settings_view')){
	function wpvc_contest_settings_view($option){
		?>
		<h2 class="color_h2"><?php _e('Global Contest Settings','voting-contest'); ?></h2>
		
		<div class="settings_content">
			
			<form action="" method="post">		
                <h4><?php _e('Contest Options','voting-contest'); ?></h4>
                
                <?php echo wpvc_add_vote_contest_settings(); ?>
                
                <table class="form-table">
                <tr  valign="top">
                            <th scope="row">
                        <label for="vote_truncation_grid"><?php _e('Title Truncation grid view','voting-contest'); ?> </label>
                        <div class="hasTooltip"></div>
                        <div class="hidden">
                        <p class="description"><?php _e('Limit the title characters show on contestant listing (grid view)','voting-contest'); ?></p>
                        </div>
                    </th>
                            <td colspan="2">
                                <input type="text" id="vote_truncation_grid" onkeypress="return wpvc_isnumber(event);" name="vote_truncation_grid"  value="<?php echo isset($option['vote_truncation_grid'])?$option['vote_truncation_grid']:'' ?>"/>
                                
                            </td>
                        </tr>
                        
                        <tr  valign="top">
                            <th  scope="row">
                                <label for="vote_truncation_list"><?php _e('Title Truncation list view','voting-contest'); ?> </label>
                                <div class="hasTooltip"></div>
                                <div class="hidden">
                                <p class="description"><?php _e('Limit the title characters show on contestant listing (List view)','voting-contest'); ?></p>
                                </div>
                            </th>
                            <td colspan="2">
                                <input type="text" id="vote_truncation_list" onkeypress="return wpvc_isnumber(event);" name="vote_truncation_list"  value="<?php echo isset($option['vote_truncation_list'])?$option['vote_truncation_list']:'' ?>"/>
                                
                            </td>
                        </tr>
                        
                <tr valign="top">
                    <th  scope="row"><label for="vote_publishing_type"><?php _e('Auto Approve Contestants','voting-contest'); ?> </label>
                    <div class="hasTooltip"></div>
                    <div class="hidden">
                    <p class="description"><?php _e('Select for Publishing Automatically<br />Unselect for Pending State','voting-contest'); ?></p>
                    </div>
                    
                    </th>
                            <td colspan="2">
                                <label class="switch switch-slide">
                                    <input class="switch-input" type="checkbox" id="vote_publishing_type" name="vote_publishing_type" <?php checked('on', $option['vote_publishing_type']); ?>/>
                                    <span class="switch-label" data-on="Yes" data-off="No"></span>
                                    <span class="switch-handle"></span>
                                </label>
                    </td>
                        </tr>
                         
                        <tr valign="top">
                            <th  scope="row">
                    <label for="vote_tobestarteddesc"><?php _e('To Be Started Description','voting-contest'); ?> </label>
                    
                    <div class="hasTooltip"></div>
                     <div class="hidden">
                            <p class="description"><?php _e('Start time Description.','voting-contest'); ?></p></td>
                     </div>
                    </th>
                            <td colspan="2"> <input type="text" id="vote_tobestarteddesc" name="vote_tobestarteddesc"  value="<?php echo $option['vote_tobestarteddesc'] ?>"/>
                    
                        </tr>
                        
                        <tr valign="top">
                            <th  scope="row"><label for="vote_reachedenddesc"><?php _e('Closed Description','voting-contest'); ?> </label>
                    
                     <div class="hasTooltip"></div>
                     <div class="hidden">
                            <p class="description"><?php _e('Closed Description.','voting-contest'); ?></p></td>
                     </div>
                     
                    </th>
                            <td colspan="2"> <input type="text" id="vote_reachedenddesc" name="vote_reachedenddesc"  value="<?php echo $option['vote_reachedenddesc'] ?>"/>
                   
                        </tr>
                         
                        <tr valign="top">
                            <th  scope="row"><label for="vote_entriescloseddesc"><?php _e('Entries Closed Description','voting-contest'); ?> </label>
                    
                     <div class="hasTooltip"></div>
                    <div class="hidden">
                            <p class="description"><?php _e('Entries Closed Description.','voting-contest'); ?></p></td>
                    </div>
                    </th>
                            <td colspan="2"> <input type="text" id="vote_entriescloseddesc" name="vote_entriescloseddesc"  value="<?php echo $option['vote_entriescloseddesc'] ?>"/>
                   
                        </tr> 
                        
                        <tr valign="top">
                            <th  scope="row"><input type="submit" value="<?php _e('Update','voting-contest'); ?>" name="Submit" class="button-primary"></th>
                        </tr>
                        <input type="hidden" name="setting_action" value="contest_save" />	
                    </table>
			
			</form>
			
		</div>
		<?php
	}
}else
die("<h2>".__('Failed to load Voting admin contest settings view','voting-contest')."</h2>");

if(!function_exists('wpvc_emailnotifications_view')){
	function wpvc_emailnotifications_view($option){
		?>
		<h2 class="color_h2"><?php _e('Email Notification Settings','voting-contest'); ?></h2>
		
		<div class="settings_content">
			
			<form action="" method="post">
				<h4><?php _e('Usage Variables','voting-contest'); ?></h4>
				<p><?php _e('You can use the following email tags to customize the email notifications.','voting-contest'); ?></p>
				<?php
					$custom_fields = WPVC_Contestant_Model::wpvc_voting_get_all_custom_fields();
					if(!empty($custom_fields)){
						?>
						<table>
							<tr>
								<td><strong>Contestant link</strong></td>
								<td>&nbsp;&nbsp:&nbsp;&nbsp;</td>
								<td id="text_area_contestant-link"><textarea onclick="wpvc_copyFunction(this,'contestant-link');" class="form_build_textarea mail_copy_textarea" rows="2" readonly="readonly" title="Click to Copy">{contestant-link}</textarea></td>
								
							</tr>
						<?php
						foreach($custom_fields as $custom_field){
						    $system_name = $custom_field->system_name;
							?>
							<tr>
								<td><strong><?php echo $custom_field->question;?></strong></td>
								<td>&nbsp;&nbsp:&nbsp;&nbsp;</td>
								<td id="<?php echo 'text_area_'.$system_name ?>">
									<textarea onclick="wpvc_copyFunction(this,'<?php echo $system_name;?>');" class="form_build_textarea mail_copy_textarea" rows="2" readonly="readonly" title="Click to Copy"><?php echo ($system_name != "contestant-desc" && $system_name != "contestant-email_address"  && $system_name != "contestant-title" && $system_name != "contestant-ow_video_url" && $system_name != "contestant-ow_music_url" && $system_name != "contestant-ow_music_url_link")?'{customfield_'.$system_name.'}':'{'.$system_name.'}'; ?></textarea>
								</td>
							</tr>
							<?php } ?>
						</table>
						<?php
					}
				?>
				<h4><?php _e('Admin Email Notification','voting-contest'); ?></h4>
				<table class="form-table">
					
				<tr valign="top">
					<th scope="row"><label for="vote_notify_mail"><?php _e('Admin Notification','voting-contest'); ?> </label>
					<div class="hasTooltip"></div>
						<div class="hidden">
						<span class="description"><?php _e('Admin notify on contestant entry submission.','voting-contest'); ?></span>
						</div>
					</th>
					<td colspan="2">
						<label class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="vote_notify_mail" name="vote_notify_mail" <?php checked('on', isset($option['vote_notify_mail'])?$option['vote_notify_mail']:''); ?>/>
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
						</label>
					</td>
				</tr>        

				<tr valign="top">
                    <th  scope="row"><label for="vote_admin_mail"><?php _e('Notification E-Mail Id','voting-contest'); ?> </label>		    
					<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Admin notification E-mail Id','voting-contest'); ?></p>
						<p class="description"><?php _e('Note: If no Email Id is set. Mail will be sent to admin email (Settings->General)','voting-contest'); ?></p>
						</div>
					</th>
                    <td colspan="2">
						<input type="text" id="vote_admin_mail" name="vote_admin_mail"  value="<?php echo isset($option['vote_admin_mail'])?$option['vote_admin_mail']:''; ?>"/>
						
					</td>
                </tr>
				
				<tr valign="top">
                    <th  scope="row"><label for="vote_admin_mail_content"><?php _e('Admin Email Notification','voting-contest'); ?> </label>		    
					<div class="hasTooltip"></div>
						<div class="hidden">
							<p class="description"><?php _e('Admin notification E-mail Content','voting-contest'); ?></p>
							<p class="description"><?php _e('Note: This text will be appended after the Link of Contestants','voting-contest'); ?></p>
						</div>
					</th>
                    <td colspan="2">
						<?php
						$settings = array('wpautop'=>true,'media_buttons' => true ,'editor_height' => 200 );
						wp_editor(html_entity_decode(stripcslashes(isset($option['vote_admin_mail_content'])?$option['vote_admin_mail_content']:'')), 'vote_admin_mail_content', $settings);
						?>
					</td>
                </tr>				
				</table>
				
				
				<h4><?php _e('Contestant Success Email Notification','voting-contest'); ?></h4>
				<table class="form-table">
					
				<tr valign="top">
					<th scope="row"><label for="vote_notify_contestant"><?php _e('Contestant Success Notification','voting-contest'); ?> </label>
					<div class="hasTooltip"></div>
						<div class="hidden">
						<span class="description"><?php _e('Contestant will be notified when an entry is submitted.','voting-contest'); ?></span>
						</div>
					</th>
					<td colspan="2">
						<label class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="vote_notify_contestant" name="vote_notify_contestant" <?php checked('on', isset($option['vote_notify_contestant'])?$option['vote_notify_contestant']:''); ?>/>
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
						</label>
					</td>
				</tr>        

				<tr valign="top">
                    <th  scope="row"><label for="vote_notify_subject"><?php _e('Email Notification Subject','voting-contest'); ?> </label>		    
					<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Add Email Notification Subject when an contestant is submitted ','voting-contest'); ?></p>						
						</div>
					</th>
                    <td colspan="2">
						<input type="text" id="vote_notify_subject" name="vote_notify_subject"  value="<?php echo isset($option['vote_notify_subject'])?$option['vote_notify_subject']:''; ?>"/>
						
					</td>
                </tr>
				
				<tr valign="top">
                    <th  scope="row"><label for="vote_contestant_submit_content"><?php _e('Contestant Email Notification','voting-contest'); ?> </label>		    
					<div class="hasTooltip"></div>
						<div class="hidden">
							<p class="description"><?php _e('Contestant Success E-mail Notification Content','voting-contest'); ?></p>
							<p class="description"><?php _e('Note: This text will be appended after the Details of Contestants','voting-contest'); ?></p>
						</div>
					</th>
                    <td colspan="2">
						<?php
						$settings = array('wpautop'=>true, 'media_buttons' => true ,'editor_height' => 200 );
						wp_editor(html_entity_decode(stripcslashes(isset($option['vote_contestant_submit_content'])?$option['vote_contestant_submit_content']:'')), 'vote_contestant_submit_content', $settings);
						?>
					</td>
                </tr>				
				</table>
				
				<h4><?php _e('Contestant Published Email Notification','voting-contest'); ?></h4>
				<table class="form-table">
					
				<tr valign="top">
					<th scope="row"><label for="vote_notify_approved"><?php _e('Contestant Approved Notification','voting-contest'); ?> </label>
					<div class="hasTooltip"></div>
						<div class="hidden">
						<span class="description"><?php _e('Contestant will be notified when an entry is Approved/Published.','voting-contest'); ?></span>
						</div>
					</th>
					<td colspan="2">
						<label class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="vote_notify_approved" name="vote_notify_approved" <?php checked('on', isset($option['vote_notify_approved'])?$option['vote_notify_approved']:''); ?>/>
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
						</label>
					</td>
				</tr>        

				<tr valign="top">
                    <th  scope="row"><label for="vote_approve_subject"><?php _e('Email Notification Subject','voting-contest'); ?> </label>		    
					<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Add Email Notification Subject when an contestant is Approved/Published. ','voting-contest'); ?></p>						
						</div>
					</th>
                    <td colspan="2">
						<input type="text" id="vote_approve_subject" name="vote_approve_subject"  value="<?php echo isset($option['vote_approve_subject'])?$option['vote_approve_subject']:''; ?>"/>
						
					</td>
                </tr>
				
				<tr valign="top">
                    <th  scope="row"><label for="vote_contestant_approved_content"><?php _e('Contestant Email Notification','voting-contest'); ?> </label>		    
					<div class="hasTooltip"></div>
						<div class="hidden">
							<p class="description"><?php _e('Contestant Approved/Published E-mail Notification Content','voting-contest'); ?></p>
							<p class="description"><?php _e('Note: This text will be appended after the Details of Contestants','voting-contest'); ?></p>
						</div>
					</th>
                    <td colspan="2">
						<?php
						$settings = array('wpautop'=>true, 'media_buttons' => true ,'editor_height' => 200 );
						wp_editor(html_entity_decode(stripcslashes(isset($option['vote_contestant_approved_content'])?$option['vote_contestant_approved_content']:'')), 'vote_contestant_approved_content', $settings);
						?>
					</td>
                </tr>				
				</table>
				
				
				
				
				<table class="form-table"> 		
				<tr valign="top">
						<th  scope="row"><input type="submit" value="<?php _e('Update','voting-contest'); ?>" name="Submit" class="button-primary"></th>
				</tr>					
				</table>
				
				<input type="hidden" name="setting_action" value="emailnotification" />
			</form>
		</div>
		<?php
	}
}else
die("<h2>".__('Failed to load Voting Email Notification settings view','voting-contest')."</h2>");

if(!function_exists('wpvc_common_page_settings_view')){
	function wpvc_common_page_settings_view($option){
		 $all_sizes = WPVC_Vote_Common_Controller::wpvc_vote_list_thumbnail_sizes();
	?>
		<h2 class="color_h2"><?php _e('Common Settings','voting-contest'); ?></h2>
		<div class="settings_content">
			<h4><?php _e('Image Settings','voting-contest'); ?></h4>
            
            <?php echo wpvc_add_vote_type_settings(); ?>
            
			<form action="" method="post">
				<table class="form-table"> 		
					<tr valign="top">
						<th scope="row"><label for="short_cont_image"><?php _e('Shortcode Contest Image','voting-contest'); ?> </label></th>
						<td>
						<select class="size" data-user-setting="imgsize" data-setting="size" name="short_cont_image" id="short_cont_image">
						<?php foreach($all_sizes as $key=>$val): ?>
						<?php $selected = ($key == $option['short_cont_image'])?'selected':''; ?>
						<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
						<?php endforeach;?>
						</select>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><label for="page_cont_image"><?php _e('Contestants Page Image','voting-contest'); ?> </label></th>
						<td>
						<select class="size" data-user-setting="imgsize" data-setting="size" name="page_cont_image" id="page_cont_image">
						<?php foreach($all_sizes as $key=>$val): ?>
						<?php $selected = ($key == $option['page_cont_image'])?'selected':''; ?>
						<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $val; ?></option>
						<?php endforeach;?>
						</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="single_page_cont_image_m"><?php _e('Mobile Contestant Image','voting-contest'); ?> </label>
						<div class="hasTooltip"></div>
							<div class="hidden">
							<p class="description"><?php _e('Specify the Width of Image on Contestant Listing','voting-contest'); ?></p>
							</div>
						</th>
						<td colspan="2" style="float: left">
						<input type="text" id="single_page_cont_image_m" name="single_page_cont_image_m"  value="<?php echo $option['single_page_cont_image_m'] ?>"/>
						</td>
						
						<td colspan="2" style="float: left">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="single_page_cont_image_m_px" name="single_page_cont_image_m_px" <?php checked('on', $option['single_page_cont_image_m_px']); ?>/>
							<span class="switch-label" data-on="px" data-off="%"></span>
							<span class="switch-handle"></span>
						</label>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="single_page_cont_image"><?php _e('Single Contestant Image','voting-contest'); ?> </label>
						<div class="hasTooltip"></div>
							<div class="hidden">
							<p class="description"><?php _e('Specify the Width of Image','voting-contest'); ?></p>
							</div>
						</th>
						<td colspan="2" style="float: left">
						<input type="text" id="single_page_cont_image" name="single_page_cont_image"  value="<?php echo $option['single_page_cont_image'] ?>"/>
						</td>
					
						<td colspan="2" style="float: left">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="single_page_cont_image_px" name="single_page_cont_image_px" <?php checked('on', isset($option['single_page_cont_image_px'])?$option['single_page_cont_image_px']:'%'); ?>/>
							<span class="switch-label" data-on="px" data-off="%"></span>
							<span class="switch-handle"></span>
						</label>
						</td>
					</tr>
                    
                    <tr  valign="top">
					<th  scope="row"><label for="vote_turn_lazy"><?php _e('Enable Lazy Load in Listings','voting-contest'); ?> </label>
					<div class="hasTooltip"></div>
						<div class="hidden">
						<span class="description"><?php _e('Turn On/Off Enable Lazy Load in Listings','voting-contest'); ?></span>
						</div>
					</th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_turn_lazy" name="vote_turn_lazy" <?php checked('on', $option['vote_turn_lazy']); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
					</tr>
                    
                    
				</table>
				
				<h4><?php _e('Single Contestant Page Settings','voting-contest'); ?></h4>
				
				<table class="form-table"> 
					<tr valign="top">
						<th scope="row"><label for="single_page_title"><?php _e('Title Position: ','voting-contest'); ?></label>
							<div class="hasTooltip"></div>
							<div class="hidden">
							<span class="description"><?php _e('Shows the title in the Top of Image/Video/Music grid view.','voting-contest'); ?></span>
							</div>
						</th>
						<td>
							<label class="switch switch-slide">
                                <?php $single_page_title  = isset($option['single_page_title'])?$option['single_page_title']:''; ?>
								<input class="switch-input" type="checkbox" id="single_page_title" name="single_page_title" <?php if ($single_page_title == 'on')
							echo 'checked="checked"'; ?>/>
								<span class="switch-label" data-on="Top" data-off="Bottom"></span>
								<span class="switch-handle"></span>
							</label>
						</td>
					</tr>
					
					<tr  valign="top">
						<th  scope="row"><label for="vote_prettyphoto_disable_single"><?php _e('Disable PrettyPhoto','voting-contest'); ?> </label>
						
						<div class="hasTooltip"></div>
							<div class="hidden">
							<span class="description"><?php _e('Disables PrettyPhoto in Single Contestants Page','voting-contest'); ?></span>
							</div>
						
						</th>
						<td colspan="2">
							<label class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="vote_prettyphoto_disable_single" name="vote_prettyphoto_disable_single" <?php checked('on', isset($option['vote_prettyphoto_disable_single'])?$option['vote_prettyphoto_disable_single']:''); ?>/>
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
						</td>
					</tr>
					
				</table>
				
				<h4><?php _e('Content Settings','voting-contest'); ?></h4>
				
				<table class="form-table"> 
					<tr valign="top">
						<th scope="row"><label for="vote_title_alocation"><?php _e('Title/Category Position: ','voting-contest'); ?></label>
							<div class="hasTooltip"></div>
							<div class="hidden">
							<span class="description"><?php _e('Shows the title in the Top of Image/Video/Music grid view.','voting-contest'); ?></span>
							</div>
						</th>
						<td>
                            <?php $vote_title_alocation = isset($option['vote_title_alocation'])?$option['vote_title_alocation']:''; ?>
							<label  class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="vote_title_alocation" name="vote_title_alocation" <?php if ($vote_title_alocation == 'on')
							echo 'checked="checked"'; ?>/>
								<span class="switch-label" data-on="Top" data-off="Bottom"></span>
								<span class="switch-handle"></span>
							</label>
						</td>
					</tr>
					
					
        
				<tr  valign="top">
                    <th scope="row"><label for="vote_title"><?php _e('Display Title','voting-contest'); ?> </label>
		    
		    <div class="hasTooltip"></div>
						<div class="hidden"><p class="description"><?php _e('Title.','voting-contest'); ?></p></div>
		    </th>
                    <td colspan="2">
						<input type="text" id="vote_title" name="vote_title"  value="<?php echo $option['title'] ?>"/>
						
					</td>
                </tr>
        
	
				<tr valign="top">
                    <th scope="row"><label for="vote_orderby"><?php _e('Order by','voting-contest'); ?></label> </th>
                    <td colspan="2"> 
                        <select id="vote_orderby" name="vote_orderby" >
                            <option value="author"<?php selected($option['orderby'], 'author'); ?>><?php _e('Author','voting-contest'); ?></option>
                            <option value="date"<?php selected($option['orderby'], 'date'); ?>><?php _e('Date','voting-contest'); ?></option>
                            <option value="title"<?php selected($option['orderby'], 'title'); ?>><?php _e('Title','voting-contest'); ?></option>
                            <option value="modified"<?php selected($option['orderby'], 'modified'); ?>><?php _e('Modified','voting-contest'); ?></option>
                            <option value="menu_order"<?php selected($option['orderby'], 'menu_order'); ?>><?php _e('Menu Order','voting-contest'); ?></option>
                            <option value="parent"<?php selected($option['orderby'], 'parent'); ?>><?php _e('Parent','voting-contest'); ?></option>
                            <option value="id"<?php selected($option['orderby'], 'id'); ?>><?php _e('ID','voting-contest'); ?> </option>
                            <option value="votes"<?php selected($option['orderby'], 'votes'); ?>><?php _e('Votes','voting-contest'); ?></option>
			    <option value="rand"<?php selected($option['orderby'], 'rand'); ?>><?php _e('Random','voting-contest'); ?></option>
                        </select>
                       
                    </td>
                </tr>
				
		    <tr>
		    <th scope="row"><label for="vote_order"><?php _e('','voting-contest'); ?></label> </th>
		    <td>
			
			<label class="switch switch-slide">
				<input class="switch-input" type="checkbox" id="vote_order" name="vote_order" <?php checked('on', $option['order']); ?>/>
				<span class="switch-label" data-on="Asc" data-off="Desc"></span>
				<span class="switch-handle"></span>
			</label>
				     
                   </td>
                   </tr>
                
				<tr  valign="top">
					<th  scope="row"><label for="vote_select_sidebar"><?php _e('Select Sidebar','voting-contest'); ?> </label>
					
					<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Selected Sidebar Will Be Displayed In Contestant Description Page.','voting-contest'); ?></p>
						</div>
					
					</th>
					<td colspan="2">
						<select name="vote_select_sidebar" id="vote_select_sidebar">
							<option value="">None</option>
						<?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
							 <option value="<?php echo ucwords( $sidebar['id'] ); ?>"
							 <?php echo ($option['vote_select_sidebar']==ucwords($sidebar['id']))?'selected':'';?>>
									  <?php echo ucwords( $sidebar['name'] ); ?>
							 </option>
						<?php } ?>
						</select>
						
					</td>
				</tr>
			
				<tr  valign="top">
					<th  scope="row"><label for="vote_sidebar"><?php _e('Disable Sidebar','voting-contest'); ?> </label>
					
					<div class="hasTooltip"></div>
						<div class="hidden">
						<span class="description"><?php _e('Disable Sidebar In Contestant Description Page.','voting-contest'); ?></span>
						</div>
					
					</th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_sidebar" name="vote_sidebar" <?php checked('on', isset($option['vote_sidebar'])?$option['vote_sidebar']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
				</tr>
				
				<tr  valign="top">
					<th  scope="row"><label for="vote_readmore"><?php _e('Disable More Info Button','voting-contest'); ?> </label>
					
					<div class="hasTooltip"></div>
						<div class="hidden">
						<span class="description"><?php _e('Disable More Info Button In Contestant Page.','voting-contest'); ?></span>
						</div>
					
					</th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_readmore" name="vote_readmore" <?php checked('on', isset($option['vote_readmore'])?$option['vote_readmore']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
				</tr>
				
				<tr valign="top">
				<th  scope="row"><label for="vote_entry_form"><?php _e('Default State of Entry Form','voting-contest'); ?> </label></th>
				<td colspan="2">
				
			<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_entry_form" name="vote_entry_form" <?php checked('on', isset($option['vote_entry_form'])?$option['vote_entry_form']:''); ?>/>
							<span class="switch-label" data-on="Closed" data-off="Open"></span>
							<span class="switch-handle"></span>
						</label>
			
			
				</td>
				</tr>
						
						
				
										
				</table>
				
				<table class="form-table"> 
					
										
					<tr valign="top">
						<th  scope="row"><input type="submit" value="<?php _e('Update','voting-contest'); ?>" name="Submit" class="button-primary"></th>
					</tr>
					
				</table>
				
				
				
				<input type="hidden" name="setting_action" value="common_save" />
			</form>
		</div>
		
	<?php
	}
}else
die("<h2>".__('Failed to load Voting admin common settings view','voting-contest')."</h2>");

if(!function_exists('wpvc_color_page_settings_view')){
	function wpvc_color_page_settings_view($color_option,$active = null){		 
		 $option = $color_option[$active];
		 ?>
		
		<h2 class="color_h2"><?php _e('Style Settings','voting-contest'); ?></h2>
		<div class="settings_content">
			<input type="hidden" id="wpvc_default_theme" name="wpvc_default_theme" value="<?php echo WPVC_DEF_THEME; ?>" />
			<form action="" id="wpvc_color_styler" method="post">
			    
			    <label for="owt_color_select"><?php _e('Select Color Theme','voting-contest'); ?></label>
			    <select name="owt_color_select" id="owt_color_select">
				<?php foreach($color_option as $key => $opt): ?>
				    <?php $selected = ($key == $active)?'selected':''; ?>
				    <option value="<?php echo $key; ?>" <?php echo $selected; ?>>
					<?php echo str_replace("_"," ",$key); ?>
				    </option>
				<?php endforeach;?>				
			    </select>
			    
			   	    
			    <?php $style_class = (strpos(WPVC_DEF_THEME, $active) !== false)?'style="display:none;"':''; ?>
			    <button <?php echo $style_class; ?>id="wpvc_delete_current_theme" name="wpvc_delete_current_theme" class="button-primary"><?php _e('Delete Current Theme','voting-contest'); ?></button>
			    
			    <div id="wpvc_loader_image">
                    <img src="<?php echo WPVC_LOADER_IMAGE; ?>"/>
			    </div>
			    
			    <div class="owt_accordion_load">
				<?php echo wpvc_render_accordion($option); ?>
			    </div>
			    
			    <tr valign="top">
					<th  scope="row">
						<td colspan="2" style="margin:0px;padding:0px;"> 
						<span style="font-size:12px;padding-left:8px;"><?php _e('Check if the permission is set to 777 for the file "wp-content/plugins/wp-voting-contest/assets/css/wpvc_votes_color.css"','voting-contest'); ?></span>
						</td>
					</th>
			    </tr>
			    
			    <table>
				
			    <tr valign="top" class="save_as_template">
				<th  scope="row">				    
				    <td colspan="4"><label for="save_as_template"><?php _e('Name of the Template','voting-contest'); ?> </label></td>
				    <td class="save_as_template_col"></td>
				</th>
			    </tr>
				
			    <tr valign="top">
				<th  scope="row">
				    <td><input type="submit" id="vi_color_save" value="<?php _e('Save','voting-contest'); ?>" name="Submit" class="button-primary"></td>
				    <td><button id="save_as" name="save_as" class="button-primary"><?php _e('Save As','voting-contest'); ?></button></td>				 </th>
			    </tr>
			    
			    
			    
			    </table>				    
			    <input type="hidden" name="setting_action" value="vi_color_save" />
			</form>
		</div>
		
	<?php
	}
}else
die("<h2>".__('Failed to load Voting admin color settings view','voting-contest')."</h2>");


if(!function_exists('wpvc_share_contestant_settings_view')){
	function wpvc_share_contestant_settings_view($option){
		$path =  wp_upload_dir();
	?>
		<h2 class="color_h2"><?php _e('Share Settings','voting-contest'); ?></h2>
		<div class="settings_content">
			<form action="" method="post" enctype="multipart/form-data">
			<h4><?php _e('Facebook Sharing','voting-contest'); ?></h4>
			<table class="form-table">
				<tr>
					<th  scope="row"><label for="vote_fb_appid"><?php _e('Facebook App ID','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" value="<?php echo isset($option['vote_fb_appid'])?$option['vote_fb_appid']:'' ?>" name="vote_fb_appid" id="vote_fb_appid" />					
					</td>
				</tr>
				<tr valign="top">
					<th  scope="row"><label for="vote_facebook"><?php _e('Enable Facebook Sharing?','voting-contest'); ?> </label></th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_facebook" name="vote_facebook" <?php checked('on', isset($option['facebook'])?$option['facebook']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
				</tr>
								
				<tr>
					<th  scope="row"><label for="vote_facebook_default_img"><?php _e('Use default Facebook image?','voting-contest'); ?> </label></th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_facebook_default_img" name="vote_facebook_default_img" <?php checked('on', isset($option['file_fb_default'])?$option['file_fb_default']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
						<input type="hidden" name="fb_uploaded_image" value="<?php echo $option['file_facebook']; ?>" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2">
						<input type="file" name="facebook_image" />
                        <?php $file_facebook = isset($option['file_facebook'])?$option['file_facebook']:''; ?>
						<?php if($file_facebook !='' && $option['file_fb_default']==''){?>
						<span style="position: relative;top: 10px;"><img style="height:auto;width:auto;" src="<?php echo $path['url'].'/'.$option['file_facebook']?>"/></span>
						<?php } ?>
						<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Suggested Image Size is max 105px width - max 36px height.','voting-contest'); ?></p>
						<p class="description"><?php _e('Upload image to change the default facebook image.','voting-contest'); ?></p>
						</div>
					</td> 
				</tr>   
            </table>
						
			 <!-- Pinterest Sharing -->
            <h4><?php _e('Pinterest Sharing','voting-contest'); ?></h4>
			<table class="form-table">
				<tr  valign="top">
					<th scope="row"><label for="vote_pinterest"><?php _e('Enable Pinterest Sharing?','voting-contest'); ?> </label></th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_pinterest" name="vote_pinterest" <?php checked('on', isset($option['pinterest'])?$option['pinterest']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
				</tr>
				<tr>
					<th  scope="row"><label for="vote_pinterest_default_img"><?php _e('Use default pinterest image?','voting-contest'); ?> </label></th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_pinterest_default_img" name="vote_pinterest_default_img" <?php checked('on', isset($option['file_pinterest_default'])?$option['file_pinterest_default']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
						<input type="hidden" name="pinterest_uploaded_image" value="<?php echo $option['file_pinterest']; ?>" />
					</td>
				</tr> 
				<tr>
					<td></td>
					<td colspan="2">
						<input type="file" name="pinterest_image" />
                        <?php $file_pinterest = isset($option['file_pinterest'])?$option['file_pinterest']:''; ?>
						<?php if($file_pinterest !='' && $option['file_pinterest_default']==''){?>
						<span style="position: relative;top: 10px;"><img style="height:auto;width:auto;" src="<?php echo $path['url'].'/'.$option['file_pinterest']?>"/></span>
						<?php } ?>
						<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Suggested Image Size is max 105px width - max 36px height.','voting-contest'); ?></p>
						<p class="description"><?php _e('Upload image to change the default pinterest image.','voting-contest'); ?></p>
						</div>
					</td> 
				</tr>
				
            </table>
			
						
			<!-- Tumblr Sharing -->
            <h4><?php _e('Tumblr Sharing','voting-contest'); ?></h4>
			<table class="form-table">
				<tr  valign="top">
					<th  scope="row"><label for="vote_tumblr"><?php _e('Enable Tumblr Sharing?','voting-contest'); ?> </label></th>
					<td  colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_tumblr" name="vote_tumblr" <?php checked('on', isset($option['tumblr'])?$option['tumblr']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
				</tr>				
				<tr>
					<th  scope="row"><label for="vote_tumblr_default_img"><?php _e('Use default tumblr image?','voting-contest'); ?> </label></th>
					<td  colspan="2"> 
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_tumblr_default_img" name="vote_tumblr_default_img" <?php checked('on', isset($option['file_tumblr_default'])?$option['file_tumblr_default']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
						<input type="hidden" name="tumblr_uploaded_image" value="<?php echo $option['file_tumblr']; ?>" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td  colspan="2">
						<input type="file" name="tumblr_image" />
                        <?php $file_tumblr = isset($option['file_tumblr'])?$option['file_tumblr']:''; ?>
						<?php if($file_tumblr !='' && $option['file_tumblr_default']==''){?>
						<span style="position: relative;top: 10px;"><img style="height:auto;width:auto;" src="<?php echo $path['url'].'/'.$option['file_tumblr']?>"/></span>
						<?php } ?>
						<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Suggested Image Size is max 105px width - max 36px height.','voting-contest'); ?></p>
						<p class="description"><?php _e('Upload image to change the default Tumblr image.','voting-contest'); ?></p>
						</div>
					</td> 
				</tr>
            </table>
			
			<h4><?php _e('Twitter Sharing','voting-contest'); ?></h4>
            <table class="form-table">
				
								
				<tr  valign="top">
					<th  scope="row"><label for="vote_twitter"><?php _e('Enable Twitter Sharing?','voting-contest'); ?> </label></th>
					<td colspan="2">
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_twitter" name="vote_twitter" <?php checked('on', isset($option['twitter'])?$option['twitter']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
					</td>
				</tr>
				 
				<tr>
					<th  scope="row"><label for="vote_twitter_default_img"><?php _e('Use default Twitter image?','voting-contest'); ?> </label></th>
					<td colspan="2"> 
						<label class="switch switch-slide">
							<input class="switch-input" type="checkbox" id="vote_twitter_default_img" name="vote_twitter_default_img" <?php checked('on', isset($option['file_tw_default'])?$option['file_tw_default']:''); ?>/>
							<span class="switch-label" data-on="Yes" data-off="No"></span>
							<span class="switch-handle"></span>
						</label>
						<input type="hidden" name="tw_uploaded_image" value="<?php echo $option['file_twitter']; ?>" />
					</td>
			   </tr>
				<tr>
					<th></th>
					<td colspan="2">
						<input type="file" name="twitter_image" />
                        <?php $file_twitter = isset($option['file_twitter'])?$option['file_twitter']:'' ?>
						<?php if($file_twitter !='' && $option['file_tw_default']==''){  ?>
						<span style="position: relative;top: 10px;"><img style="height:auto;width:auto;" src="<?php echo $path['url'].'/'.$option['file_twitter']?>"/></span>
						<?php } ?>
						<div class="hasTooltip"></div>
						<div class="hidden">
						<p class="description"><?php _e('Upload image to change the default tweet image.','voting-contest'); ?></p>
						<p class="description"><?php _e('Suggested Image Size is max 105px width - max 36px height.','voting-contest'); ?></p>
						</div>
					</td>
				</tr> 
                 
				<tr valign="top">
					<th  scope="row"><input type="submit" value="<?php _e('Update','voting-contest'); ?>" name="Submit" class="button-primary"></th>
				</tr>
            </table>
            
           
				<input type="hidden" name="setting_action" value="share_save" />
			</form>
		</div>
	<?php
	}
}else
die("<h2>".__('Failed to load Voting admin Share settings view','voting-contest')."</h2>");

if(!function_exists('wpvc_script_contestant_settings_view')){
	function wpvc_script_contestant_settings_view($option){
	?>
		<h2 class="color_h2"><?php _e('Script Settings','voting-contest'); ?></h2>
		<div class="settings_content">
			<form action="" method="post">
			<h4><?php _e('Deactivation Settings','voting-contest'); ?></h4>
			<table class="form-table">
				<tr  valign="top">
					   <th  scope="row"><label for="vote_deactivation"><?php _e('Deactivation Settings','voting-contest'); ?> </label></th>
					   <td colspan="2">
							<label class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="vote_deactivation" name="vote_deactivation" <?php checked('on', $option['deactivation']); ?>/>
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
						<span class="description"><?php _e('Data will get retained after Deactivation.','voting-contest'); ?></span>
					   </td>
				</tr>
            </table>
			
			<h4><?php _e('Turn Off the Loading Scripts','voting-contest'); ?></h4>  
	
			<table class="form-table">
				<tr  valign="top">
						<th  scope="row"><label for="disable_jquery"><?php _e('Jquery','voting-contest'); ?> </label></th>
						<td colspan="2">
							<label class="switch switch-slide">
								<input class="switch-input" type="checkbox" id="disable_jquery" name="disable_jquery" <?php checked('on', isset($option['vote_disable_jquery'])?$option['vote_disable_jquery']:''); ?>/>
								<span class="switch-label" data-on="Yes" data-off="No"></span>
								<span class="switch-handle"></span>
							</label>
							<span class="description"><?php _e('Disable Jquery from Loading.','voting-contest'); ?></span>
						</td>
				</tr>
	     
				 
				<tr valign="top">
					<th  scope="row"><input type="submit" value="<?php _e('Update','voting-contest'); ?>" name="Submit" class="button-primary"></th>
				</tr>       
            
			</table>
			<input type="hidden" name="setting_action" value="script_save" />
			</form>
		</div>
	<?php	
	}
}else
die("<h2>".__('Failed to load Voting admin Script settings view','voting-contest')."</h2>");


if(!function_exists('wpvc_render_accordion')){
    function wpvc_render_accordion($option){	
	ob_start();
	?>
		<div id="owt-accordion" class="owt-accordion">
			    <ul>
				<li>
				   <a href="#"><i class="owvotingicon owfa-list"></i><?php _e('Counter Colors','voting-contest'); ?><span class="st-arrow"></span></a>			      <div class="st-content">
					<table class="form-table">				    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_counter_font_size"><?php _e('Counter Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_counter_font_size" id="votes_counter_font_size" value="<?php  echo $option['votes_counter_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    <tr  valign="top">
						<th  scope="row"><label for="votes_timertextcolor"><?php _e('Count Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_timertextcolor" id="votes_timertextcolor" value="<?php  echo $option['votes_timertextcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_timerbgcolor"><?php _e('Counter Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_timerbgcolor" id="votes_timerbgcolor" value="<?php echo $option['votes_timerbgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					</table>		
				    </div>
				</li>
				
				<li>
				    <a href="#"><i class="owvotingicon owfa-compass"></i><?php _e('Navigation Bar','voting-contest'); ?><span class="st-arrow"></span></a>
				    <div class="st-content">
						
				<table class="form-table"> 
				    <tr  valign="top">
					<th  scope="row"><label for="votes_navigation_font_size"><?php _e('Navigation Font Size','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="number" min="0" max="60" name="votes_navigation_font_size" id="votes_navigation_font_size" value="<?php  echo $option['votes_navigation_font_size']; ?>" class="votes-font-text"/>
					<span class="votes-font-text-px">px</span>
				        </td>
				    </tr>
				    
				    <tr  valign="top">
					<th  scope="row"><label for="votes_navigation_text_color"><?php _e('Navigation Font Color','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="votes_navigation_text_color" id="votes_navigation_text_color" value="<?php  echo $option['votes_navigation_text_color']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>			    
				   
				    
				    
				    <tr valign="top">
					<th  scope="row"><label for="votes_navigation_text_color_hover"><?php _e('Navigation Font Color:Hover','voting-contest'); ?> </label></th>
					<td colspan="2"> 
				        <input type="text" maxlength="7" name="votes_navigation_text_color_hover" id="votes_navigation_text_color_hover" value="<?php echo $option['votes_navigation_text_color_hover']; ?>" class="votes-color-field"/>
					</td>
				    </tr>
				    <tr  valign="top">
					<th  scope="row"><label for="votes_navigationbgcolor"><?php _e('Navigation Background Color','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="votes_navigationbgcolor" id="votes_navigationbgcolor" value="<?php  echo $option['votes_navigationbgcolor']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
				    
				    <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('List View & Grid View Settings','voting-contest'); ?></div>
				        </th>
				    </tr>
				    
				    
				     <tr  valign="top">
					<th  scope="row"><label for="votes_list_active"><?php _e('List View Active','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="votes_list_active" id="votes_list_active" value="<?php  echo $option['votes_list_active']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
				    <tr  valign="top">
					<th  scope="row"><label for="votes_list_inactive"><?php _e('List View Inactive','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="votes_list_inactive" id="votes_list_inactive" value="<?php  echo $option['votes_list_inactive']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
				      
				    <tr  valign="top">
					<th  scope="row"><label for="votes_grid_active"><?php _e('Grid View Active','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="votes_grid_active" id="votes_grid_active" value="<?php  echo $option['votes_grid_active']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
				    <tr  valign="top">
					<th  scope="row"><label for="votes_grid_inactive"><?php _e('Grid View Inactive','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="votes_grid_inactive" id="votes_grid_inactive" value="<?php  echo $option['votes_grid_inactive']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
					
					<tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Menu Button Style Settings','voting-contest'); ?></div>
				        </th>
				    </tr>
					
					<tr  valign="top">
					<th  scope="row"><label for="vote_navbar_button_background"><?php _e('Inactive Button Background','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="vote_navbar_button_background" id="vote_navbar_button_background" value="<?php  echo $option['vote_navbar_button_background']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
					
					<tr  valign="top">
					<th  scope="row"><label for="vote_navbar_active_button_background"><?php _e('Active Button Background','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="vote_navbar_active_button_background" id="vote_navbar_active_button_background" value="<?php  echo $option['vote_navbar_active_button_background']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
					
					<tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Mobile Menu Style Settings','voting-contest'); ?></div>
				        </th>
				    </tr>
					
					<tr  valign="top">
					<th  scope="row"><label for="vote_navbar_button_background"><?php _e('Menu Arrow & Font Color','voting-contest'); ?> </label></th>
					<td colspan="2"> 
					<input type="text" maxlength="7" name="vote_navbar_mobile_font" id="vote_navbar_mobile_font" value="<?php  echo $option['vote_navbar_mobile_font']; ?>" class="votes-color-field"/>
				        </td>
				    </tr>
					
				</table>
				
						
				    </div>
				</li>
				
				<li>
				    <a href="#"><i class="owvotingicon owfa-university"></i><?php _e('Contestant Title','voting-contest'); ?><span class="st-arrow"></span></a>
				    <div class="st-content">
					<table class="form-table">
					    
					    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_cont_title_font_size"><?php _e('Contestant Title Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_cont_title_font_size" id="votes_cont_title_font_size" value="<?php  echo $option['votes_cont_title_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_cont_title_bgcolor"><?php _e('Contestant Title Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_title_bgcolor" id="votes_cont_title_bgcolor" value="<?php echo $option['votes_cont_title_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					    <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('List View Settings','voting-contest'); ?></div>
						</th>
					    </tr>
					      
					    <tr  valign="top">
						<th  scope="row"><label for="votes_cont_title_color"><?php _e('Contestant Title Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_title_color" id="votes_cont_title_color" value="<?php echo $option['votes_cont_title_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_cont_title_color_hover"><?php _e('Contestant Title Font Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_title_color_hover" id="votes_cont_title_color_hover" value="<?php echo $option['votes_cont_title_color_hover']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					     <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Grid View Settings','voting-contest'); ?></div>
						</th>
					    </tr>
					      
					    <tr  valign="top">
						<th  scope="row"><label for="votes_cont_title_color_grid"><?php _e('Contestant Title Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_title_color_grid" id="votes_cont_title_color_grid" value="<?php echo $option['votes_cont_title_color_grid']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_cont_title_color_hover_grid"><?php _e('Contestant Title Font Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_title_color_hover_grid" id="votes_cont_title_color_hover_grid" value="<?php echo $option['votes_cont_title_color_hover_grid']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					</table>		
				    </div>
				</li>
				
				<li>
				    <a href="#"><i class="owvotingicon owfa-desc"></i><?php _e('Contestant Description','voting-contest'); ?><span class="st-arrow"></span></a>
				    <div class="st-content">
					<table class="form-table">				    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_cont_desc_font_size"><?php _e('Contestant Description Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_cont_desc_font_size" id="votes_cont_desc_font_size" value="<?php  echo $option['votes_cont_desc_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    <tr  valign="top">
						<th  scope="row"><label for="votes_cont_dese_color"><?php _e('Contestant Description Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_dese_color" id="votes_cont_dese_color" value="<?php echo $option['votes_cont_dese_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_cont_desc_bgcolor"><?php _e('Contestant Description Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_cont_desc_bgcolor" id="votes_cont_desc_bgcolor" value="<?php echo $option['votes_cont_desc_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Read More Settings','voting-contest'); ?></div>
						</th>
					    </tr>
					    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_readmore_font_size"><?php _e('Read More Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_readmore_font_size" id="votes_readmore_font_size" value="<?php  echo $option['votes_readmore_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					     <tr valign="top">
						<th  scope="row"><label for="votes_readmore_fontcolor"><?php _e('Read More Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_readmore_fontcolor" id="votes_readmore_fontcolor" value="<?php echo $option['votes_readmore_fontcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					     <tr valign="top">
						<th  scope="row"><label for="votes_readmore_fontcolor_hover"><?php _e('Read More Font Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_readmore_fontcolor_hover" id="votes_readmore_fontcolor_hover" value="<?php echo $option['votes_readmore_fontcolor_hover']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     <tr valign="top">
					        <th  scope="row"><label for="votes_readmore_bgcolor"><?php _e('Read More Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_readmore_bgcolor" id="votes_readmore_bgcolor" value="<?php echo $option['votes_readmore_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     <tr valign="top">
						<th  scope="row"><label for="votes_readmore_bgcolor_hover"><?php _e('Read More Background Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_readmore_bgcolor_hover" id="votes_readmore_bgcolor_hover" value="<?php echo $option['votes_readmore_bgcolor_hover']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					    <tr valign="top">
						<th  scope="row"><label for="votes_readmore_padding_top"><?php _e('Read More Padding Top','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number"  name="votes_readmore_padding_top" id="votes_readmore_padding_top" value="<?php  echo $option['votes_readmore_padding_top']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_readmore_padding_bottom"><?php _e('Read More Padding Bottom','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" name="votes_readmore_padding_bottom" id="votes_readmore_padding_bottom" value="<?php  echo $option['votes_readmore_padding_bottom']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_readmore_padding_left"><?php _e('Read More Padding Left','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" name="votes_readmore_padding_left" id="votes_readmore_padding_left" value="<?php  echo $option['votes_readmore_padding_left']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					     
					    <tr valign="top">
						<th  scope="row"><label for="votes_readmore_padding_right"><?php _e('Read More Padding Right','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" name="votes_readmore_padding_right" id="votes_readmore_padding_right" value="<?php  echo $option['votes_readmore_padding_right']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr> 
					     
					</table>		
				    </div>
				</li>
				
				<li>
				    <a href="#"><i class="owvotingicon owfa-voting"></i><?php _e('Voting and Sharing','voting-contest'); ?><span class="st-arrow"></span></a>
				    <div class="st-content">
					<table class="form-table">
					    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_bar_border_color"><?php _e('Vote Bar Border Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_bar_border_color" id="votes_bar_border_color" value="<?php echo $option['votes_bar_border_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>		    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_bar_border_size"><?php _e('Vote Bar Border Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_bar_border_size" id="votes_bar_border_size" value="<?php  echo $option['votes_bar_border_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    
					    <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Vote Count Settings','voting-contest'); ?></div>
						</th>
					    </tr>
					    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_count_font_size"><?php _e('Vote Count Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_count_font_size" id="votes_count_font_size" value="<?php  echo $option['votes_count_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_count_font_color"><?php _e('Vote Count Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_count_font_color" id="votes_count_font_color" value="<?php echo $option['votes_count_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     <tr valign="top">
						<th  scope="row"><label for="votes_count_bgcolor"><?php _e('Vote Count Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_count_bgcolor" id="votes_count_bgcolor" value="<?php echo $option['votes_count_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					    <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Vote Button Settings','voting-contest'); ?></div>
						</th>
					    </tr> 
					    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_button_font_size"><?php _e('Vote Button Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_button_font_size" id="votes_button_font_size" value="<?php  echo $option['votes_button_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					     <tr valign="top">
						<th  scope="row"><label for="votes_button_font_color"><?php _e('Vote Button Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_button_font_color" id="votes_button_font_color" value="<?php echo $option['votes_button_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_button_font_color_hover"><?php _e('Vote Button Font Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_button_font_color_hover" id="votes_button_font_color_hover" value="<?php echo $option['votes_button_font_color_hover']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_button_bgcolor"><?php _e('Vote Button Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_button_bgcolor" id="votes_button_bgcolor" value="<?php echo $option['votes_button_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    <tr valign="top">
						<th  scope="row"><label for="votes_button_bgcolor_hover"><?php _e('Vote Button Background Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_button_bgcolor_hover" id="votes_button_bgcolor_hover" value="<?php echo $option['votes_button_bgcolor_hover']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
						<tr valign="top">
						<th  scope="row"><label for="votes_highlight_button_bgcolor"><?php _e('Highlight Voted Button Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_highlight_button_bgcolor" id="votes_highlight_button_bgcolor" value="<?php echo $option['votes_highlight_button_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						<tr valign="top">
							<td colspan="2" style="margin:0px;padding:0px;"> 
							<span style="font-size:12px;"><?php _e('Highlight Voted button (vote registered) only works for voting frequency is set to "Per Category and Per Calendar Day"','voting-contest'); ?></span>
							</td>
						</tr>
						
						<tr valign="top">
						<th  scope="row"><label for="votes_already_button_bgcolor"><?php _e('Other Voted Button Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_already_button_bgcolor" id="votes_already_button_bgcolor" value="<?php echo $option['votes_already_button_bgcolor']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						<tr valign="top">
							<td colspan="2" style="margin:0px;padding:0px;"> 
							<span style="font-size:12px;"><?php _e('Other Voted button (Non votable) only works for voting frequency is set to "Per Category and Per Calendar Day"','voting-contest'); ?></span>
							</td>
						</tr>
					   
					    
					    <tr  valign="top">					
						<th colspan="10"> 
						<div class="wpvc_setting_info"><?php _e('Social Icons Settings','voting-contest'); ?></div>
						</th>
					    </tr>
					     <tr  valign="top">
						<th  scope="row"><label for="votes_social_font_size"><?php _e('Social Icon Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_social_font_size" id="votes_social_font_size" value="<?php  echo $option['votes_social_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					      <tr valign="top">
						<th  scope="row"><label for="votes_social_icon_color"><?php _e('Social Icon Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_social_icon_color" id="votes_social_icon_color" value="<?php echo $option['votes_social_icon_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					       <tr valign="top">
						<th  scope="row"><label for="votes_social_icon_color_hover"><?php _e('Social Icon Color:Hover','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_social_icon_color_hover" id="votes_social_icon_color_hover" value="<?php echo $option['votes_social_icon_color_hover']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					</table>		
				    </div>
				</li>
				
			    <li>
					<a href="#"><i class="owvotingicon owfa-single wpvc_padding_5"></i><?php _e('Single Contestants page','voting-contest'); ?><span class="st-arrow"></span></a>
					<div class="st-content">
					<table class="form-table">
						
						<tr valign="top">
							<th  scope="row"><label for="single_navigation_button"><?php _e('Navigation Button Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="single_navigation_button" id="single_navigation_button" value="<?php echo $option['single_navigation_button']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="single_navigation_button_hover"><?php _e('Navigation Button Hover Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="single_navigation_button_hover" id="single_navigation_button_hover" value="<?php echo $option['single_navigation_button_hover']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_cont_title_color_single"><?php _e('Contestant Title Text Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_cont_title_color_single" id="votes_cont_title_color_single" value="<?php echo $option['votes_cont_title_color_single']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_cont_content_color_single"><?php _e('Contestant Content Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_cont_content_color_single" id="votes_cont_content_color_single" value="<?php echo $option['votes_cont_content_color_single']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="single_contestant_content_bg"><?php _e('Contestant Content Background','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="single_contestant_content_bg" id="single_contestant_content_bg" value="<?php echo $option['single_contestant_content_bg']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_single_social_sharing"><?php _e('Social Sharing Bar','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_single_social_sharing" id="votes_single_social_sharing" value="<?php echo $option['votes_single_social_sharing']; ?>" class="votes-color-field"/>
							</td>
						</tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_single_social_sharing_url_color"><?php _e('Social Sharing Url Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_single_social_sharing_url_color" id="votes_single_social_sharing_url_color" value="<?php echo $option['votes_single_social_sharing_url_color']; ?>" class="votes-color-field"/>
							</td>
						</tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_single_social_sharing_bg"><?php _e('Social Sharing Box Background','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_single_social_sharing_bg" id="votes_single_social_sharing_bg" value="<?php echo $option['votes_single_social_sharing_bg']; ?>" class="votes-color-field"/>
							</td>
						</tr>
					</table>
					</div>
				</li>
				
				<li>
					<a href="#"><i class="owvotingicon owfa-popup wpvc_padding_5"></i><?php _e('Contestant Pop-up','voting-contest'); ?><span class="st-arrow"></span></a>
					<div class="st-content">
					<table class="form-table">				    
					   <!--YST-->
						<tr valign="top">
							<th  scope="row"><label for="votes_popup_content_bg"><?php _e('Contestant Pop-up Background','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_popup_content_bg" id="votes_popup_content_bg" value="<?php echo $option['votes_popup_content_bg']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_popup_additional_info_color"><?php _e('Additional Info Title Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_popup_additional_info_color" id="votes_popup_additional_info_color" value="<?php echo $option['votes_popup_additional_info_color']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_popup_additional_info_bg"><?php _e('Additional Info Background','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_popup_additional_info_bg" id="votes_popup_additional_info_bg" value="<?php echo $option['votes_popup_additional_info_bg']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
						
						<tr valign="top">
							<th  scope="row"><label for="votes_popup_content_color"><?php _e('Contestant Content Font Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
							<input type="text" maxlength="7" name="votes_popup_content_color" id="votes_popup_content_color" value="<?php echo $option['votes_popup_content_color']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
					</table>
					</div>
				</li>
				
				<li>
				    <a href="#"><i class="owvotingicon owfa-sort-numeric-asc wpvc_padding_5"></i><?php _e('Pagination','voting-contest'); ?><span class="st-arrow"></span></a>
				    <div class="st-content">
					<table class="form-table">				    
					    <tr  valign="top">
						<th  scope="row"><label for="votes_pagination_font_size"><?php _e('Pagination Font Size','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="number" min="0" max="60" name="votes_pagination_font_size" id="votes_pagination_font_size" value="<?php  echo $option['votes_pagination_font_size']; ?>" class="votes-font-text"/>
						<span class="votes-font-text-px">px</span>
						</td>
					    </tr>
					    <tr  valign="top">
						<th  scope="row"><label for="votes_pagination_font_color"><?php _e('Pagination Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_pagination_font_color" id="votes_pagination_font_color" value="<?php echo $option['votes_pagination_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_pagination_active_font_color"><?php _e('Pagination Active Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_pagination_active_font_color" id="votes_pagination_active_font_color" value="<?php echo $option['votes_pagination_active_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_pagination_active_bg_color"><?php _e('Pagination Active Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_pagination_active_bg_color" id="votes_pagination_active_bg_color" value="<?php echo $option['votes_pagination_active_bg_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_pagination_hover_bg_color"><?php _e('Pagination Hover Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_pagination_hover_bg_color" id="votes_pagination_hover_bg_color" value="<?php echo $option['votes_pagination_hover_bg_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="votes_pagination_hover_font_color"><?php _e('Pagination Hover Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="votes_pagination_hover_font_color" id="votes_pagination_hover_font_color" value="<?php echo $option['votes_pagination_hover_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					     
					     
					     
					</table>		
				    </div>
				</li>
				
				<li>
				    <a href="#"><i class="owvotingicon owfa-login"></i><?php _e('Login/Register Pop-up','voting-contest'); ?><span class="st-arrow"></span></a>
				    <div class="st-content">
					<table class="form-table">
						
						<tr valign="top">
						<th  scope="row"><label for="login_tab_active_bg_color"><?php _e('Tab Active Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_tab_active_bg_color" id="login_tab_active_bg_color" value="<?php echo $option['login_tab_active_bg_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="login_tab_hover_bg_color"><?php _e('Tab Hover Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_tab_hover_bg_color" id="login_tab_hover_bg_color" value="<?php echo $option['login_tab_hover_bg_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr  valign="top">
						<th  scope="row"><label for="login_tab_font_color"><?php _e('Tab Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_tab_font_color" id="login_tab_font_color" value="<?php echo $option['login_tab_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
					    
					    <tr valign="top">
						<th  scope="row"><label for="login_tab_active_font_color"><?php _e('Tab Active Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_tab_active_font_color" id="login_tab_active_font_color" value="<?php echo $option['login_tab_active_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
						<tr valign="top">
						<th  scope="row"><label for="login_tab_hover_font_color"><?php _e('Tab Hover Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_tab_hover_font_color" id="login_tab_hover_font_color" value="<?php echo $option['login_tab_hover_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
					    <tr valign="top">
						<th  scope="row"><label for="login_body_background_color"><?php _e('Popup Body Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_body_background_color" id="login_body_background_color" value="<?php echo $option['login_body_background_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
						<tr valign="top">
						<th  scope="row"><label for="popup_body_text_color"><?php _e('Popup Body Text Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="popup_body_text_color" id="popup_body_text_color" value="<?php echo $option['popup_body_text_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
						<tr valign="top">
						<th  scope="row"><label for="login_button_background_color"><?php _e('Button Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_button_background_color" id="login_button_background_color" value="<?php echo $option['login_button_background_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
						<tr valign="top">
						<th  scope="row"><label for="login_button_hover_bg_color"><?php _e('Button Hover Background Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_button_hover_bg_color" id="login_button_hover_bg_color" value="<?php echo $option['login_button_hover_bg_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
						<tr valign="top">
						<th  scope="row"><label for="login_button_font_color"><?php _e('Button Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_button_font_color" id="login_button_font_color" value="<?php echo $option['login_button_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
						<tr valign="top">
						<th  scope="row"><label for="login_button_hover_font_color"><?php _e('Button Hover Font Color','voting-contest'); ?> </label></th>
						<td colspan="2"> 
						<input type="text" maxlength="7" name="login_button_hover_font_color" id="login_button_hover_font_color" value="<?php echo $option['login_button_hover_font_color']; ?>" class="votes-color-field"/>
						</td>
					    </tr>
						
					     
					     
					     
					</table>		
				    </div>
				</li>
				
				<li>
				   <a href="#"><i class="owvotingicon owfa-list"></i><?php _e('Show All Contestants Page','voting-contest'); ?><span class="st-arrow"></span></a>
				   <div class="st-content">
					<table class="form-table">				    
					    <tr  valign="top">
							<th  scope="row"><label for="votes_showallcont_font"><?php _e('Font Color','voting-contest'); ?> </label></th>
							<td colspan="2"> 
									<input type="text" maxlength="7" name="votes_showallcont_font" id="votes_showallcont_font" value="<?php  echo $option['votes_showallcont_font']; ?>" class="votes-color-field"/>
							</td>
					    </tr>
					    <tr valign="top">
							<th  scope="row"><label for="votes_showallcont_bg"><?php _e('Background Color','voting-contest'); ?> </label></th>
								<td colspan="2"> 
										<input type="text" maxlength="7" name="votes_showallcont_bg" id="votes_showallcont_bg" value="<?php echo $option['votes_showallcont_bg']; ?>" class="votes-color-field"/>
								</td>
					    </tr>
					</table>		
				    </div>
				</li>
			    
			    </ul>
			    </div>
			    
	<?php
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
    }
}

?>

<script type="text/javascript">
	jQuery(document).ready(function(){
	    
	    jQuery('.votes-color-field').wpColorPicker({
		change: function(event, ui)
		{
		    wpvc_check_default_theme();
		}
	    });
	    
	    jQuery(".votes-font-text").change(function() {
		wpvc_check_default_theme();  
	    });
	    
	    jQuery(function() {			
		jQuery('#owt-accordion').accordion({
			open : 0,
			oneOpenedItem	: true
		});				
	    });  
	    
	    
    jQuery('.hasTooltip').each(function() { // Notice the .each() loop, discussed below
    jQuery(this).qtip({
        content: {
            text: jQuery(this).next('div') // Use the "div" element next to this for the content
        }
    });
    });
		
	});
	
	function wpvc_check_default_theme(){	   
	    var wpvc_default_theme = jQuery('#wpvc_default_theme').val();
	    var wpvc_current_theme = jQuery('#owt_color_select').val();
	    
	    if (wpvc_default_theme.includes(wpvc_current_theme)) {
            jQuery('#vi_color_save').hide();
	    }
	}
	
	function wpvc_isnumber(evt){
	  var charCode = (evt.which) ? evt.which : evt.keyCode
	   //var charCode = evt.keyCode == 0 ? evt.charCode : evt.keyCode;
	  if (charCode > 31 && (charCode < 48 || charCode > 57))
		  return false;	  
	  return true;
	}
	
	function wpvc_copyFunction(textarea,id) {
		/* Get the text field */
		var copyText = textarea;
		/* Select the text field */
		copyText.select();
		/* Copy the text inside the text field */
		document.execCommand("Copy");
		jQuery('.copy_text').remove();
		jQuery( '<td class="copy_text" style="width: 250px;">Copied the text</td>').insertAfter('#text_area_'+id);
    }
</script>
