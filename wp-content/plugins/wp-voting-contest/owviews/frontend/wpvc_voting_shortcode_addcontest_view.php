<?php
if(!function_exists('wpvc_voting_shortcode_addcontestant_view')){
    function wpvc_voting_shortcode_addcontestant_view($shwpvc_cont_args,$vote_opt,$category_options,$check_status,$custom_fields){   

		$global_options = WPVC_Vote_Common_Controller::wpvc_vote_get_all_global_settings($vote_opt);
		if(!empty($global_options)){
			foreach($global_options as $variab => $glob_opt){
				$$variab = $glob_opt;
			}
		}		
	
		if(!empty($shwpvc_cont_args)){
			foreach($shwpvc_cont_args as $args => $opt_glob){
				$$args = $opt_glob;
			}
		}
		$permalink = get_permalink( get_the_ID());
		
		if (false !== strpos($permalink,'?')){
			$url_prefix = '&amp;';
		}
		else{
			$url_prefix = '?';
		}
		
		if(isset($_GET['contest']))
		    $action_url  = $_GET['contest'];
		else
		    $action_url  = '';
		
			
		if(isset($_GET['contest_id']))
		    $contest_id = base64_decode($_GET['contest_id']);
			
		extract( shortcode_atts( array(
		   'id' => NULL,
		   'showcontestants' => 0,
		   'message' => 1,
		   'contestshowfrm'=>1,
		   'displayform' =>0,
		   'loggeduser'=>$vote_onlyloggedcansubmit,
		   'showrules' => 1,
		   'conid' => NULL,
		   'display_block' =>1
		), $shwpvc_cont_args ));
		
		
		$shwpvc_form = 'showform=1';
		
		$term_exists = get_term_by('id', $id, WPVC_VOTES_TAXONOMY); 
		if(!is_object($term_exists)){
			?><div class="warning activation-warning constestants-warning">Contest ID Does Not Exists</div><?php
			return;
		}
		
		if($displayform == 0){	
		    if($check_status){
			    if($message) {
				    ?>
						<div class="warning activation-warning constestants-warning"><?php echo $check_status; ?></div>
				    <?php
						$shwpvc_form = 'showform=0';
						if(!$showcontestants)
							return;
			    }
		    }
		}	

		
		
		if($showcontestants){
			echo do_shortcode('[showcontestants id="'.$id.'" forcedisplay=1 showtimer=0 '.$shwpvc_form.' hideerrorcont=1 ]'); 
			return;  
		}

		$image_contest = $votes_start_time='';
		if($category_options['imgcontest']!='')
			$image_contest = $category_options['imgcontest'];
		
		if($id!='')
			$votes_start_time=get_option($id . '_' . WPVC_VOTES_TAXSTARTTIME);
		
		$votes_end_time  = get_option($id. '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
		$current_time = current_time( 'timestamp', 0 );
				
		    
		if($votes_start_time!='' && strtotime($votes_start_time) < $current_time && $displayform != 1 ){			
			return;
		}
		
		if(!isset($_SESSION['GET_VIEW_SHORTCODE'])){
			$_SESSION['GET_VIEW_SHORTCODE']=1;
		}
		else{
			$_SESSION['GET_VIEW_SHORTCODE']=$_SESSION['GET_VIEW_SHORTCODE']+1;
		}
		
		if($vote_onlyloggedcansubmit!='' && !is_user_logged_in()){
			$login_class="wpvc_logged_in_enabled";
			if($_SESSION['GET_VIEW_SHORTCODE']==1)
			WPVC_Vote_Shortcode_Controller::wpvc_votes_custom_registration_fields_show();
		}
		else{$login_class="loggin_disabled";}


		
		
		?>
		<div class="wpvc_vote_add_contestants">
			
			<?php
			
			if($contestshowfrm !=0 && $global_options['vote_entry_form'] != 1){
				?>
				<div class="wpvc_vote_contest_top_bar">
					<ul class="wpvc_vote_menu_links">
						<?php $check_no_border = ($category_options['vote_contest_rules']!='')?'':'class="wpvc_vote_no_border"'; ?>
						<li <?php echo $check_no_border; ?>>
							<a class="wpvc_vote_navmenu_link <?php echo $login_class; ?> wpvc_vote_submit_entry" data-id="<?php echo $id; ?>">
								<span class="wpvc_vote_icons voteconestant-edit" aria-hidden="true"></span>
								<?php _e('Submit Entry','voting-contest'); ?>
							</a>
							<input type="hidden" name="open_button_text" class="open_btn_text<?php echo $id; ?>"
								value="<span class='wpvc_vote_icons voteconestant-edit' aria-hidden='true'></span>
									   <?php _e('Submit Entry','voting-contest'); ?>"/>
							<input type="hidden" name="close_button_text"  class="close_btn_text<?php echo $id; ?>"
															value="<?php _e('Close','voting-contest'); ?>"/>
						</li>
						
						<?php 
						if($category_options['vote_contest_rules']!='' && $showrules !=0){ ?>
							<li class="wpvc_vote_navmenu_link <?php echo ((isset($action_url) && $action_url=='contestrules') && $contest_id==$id)?'wpvc_active_contest_rules active':''; ?>">
								<a href="<?php echo $permalink.$url_prefix.'contest=contestrules&amp;contest_id='.base64_encode($id); ?>">
									<span class="wpvc_vote_icons voteconestant-gift"></span><?php _e('Rules and Prizes','voting-contest'); ?>
								</a>
							</li>
						<?php } ?>
					
					</ul>
				</div>
			<?php } ?>
			
			<?php			
			//Flag Variable if Option for Entry Form is set to Must Login & Open State
			if($global_options['vote_entry_form'] != 'on' && $login_class =='wpvc_logged_in_enabled' && !is_user_logged_in()){ ?>
				<input type="hidden" name="wpvc_open_login_form" class="wpvc_open_login_form" value="1" />				
			<?php } ?>
			
			<script>
				jQuery(document).ready(function(){
					add_contestant_validation("<?php echo $id; ?>","<?php _e('Enter the contestant title','voting-contest'); ?>");
				});
			</script>
			
			<?php
			if($display_block == 1){
				//Global Settings OPen/close Option for Entry Form
				$displayform_css = ($global_options['vote_entry_form'] == 'on')?'display: none;':'display: block;';
			}
			?>
			
			<?php 
			if($conid == null){				
				$form_action = get_permalink(get_the_ID());
				$form_class = "";
			}
			else{				
				//Edit Contestant
				$encrypted_termid = WPVC_Vote_Common_Controller::wpvc_voting_base64_encode($id);
				$encrypted_postid = WPVC_Vote_Common_Controller::wpvc_voting_base64_encode($conid);
				$form_action = get_permalink(get_the_ID()).'?cid='.$encrypted_termid.'&pid='.$encrypted_postid;
				$form_class = "edit_frm_contestant";
			}



			$votes_start_time=get_option($id . '_' . WPVC_VOTES_TAXSTARTTIME);
			$votes_end_time  = get_option($id. '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
			$current_time = current_time( 'timestamp', 0 );
			
			if((($votes_end_time != '' && strtotime($votes_end_time) > $current_time) || $votes_end_time == '') &&
				(($votes_start_time !='' && strtotime($votes_start_time) > $current_time && $votes_end_time=='')
				|| ($votes_start_time == '' && $votes_end_time != '' && strtotime($votes_end_time) < $current_time)
				|| ($votes_start_time=='' && $votes_end_time == '') || ($votes_start_time=='' && $votes_end_time != '')
				|| $showform == 1
				|| ($votes_end_time != '' && strtotime($votes_end_time) > $current_time && $votes_start_time !='' && strtotime($votes_start_time) > $current_time))){
			
			?>
				
						
			
			<form style="<?php echo $displayform_css; ?>" class="wpvc_form_add-contestants<?php echo $id; ?> add_form_contestant_wpvc_vote <?php echo $form_class; ?>" name="add-contestants" action="<?php echo $form_action; ?>" method="post" enctype="multipart/form-data">
			
				<?php if($conid != null){ ?>
					<input type="hidden" name="conid" value="<?php echo $conid; ?>" />
				<?php } ?>
				
				<?php
                    $main_fields = WPVC_Vote_Shortcode_Model::wpvc_voting_get_contestant_main_fields(); 
                    
                    $title_rs = WPVC_Vote_Shortcode_Model::wpvc_array_search($main_fields,'system_name','contestant-title');
                ?>
				<div class="wpvc_add_contestants_row contestant_title">
					<div class="wpvc_add_contestants_label">
						<label><?php echo $title_rs['question']; ?>  <span class="required-mark">*</span></label>
					</div>
					<div class="wpvc_add_contestants_field">
						
						<?php
							if($conid != null){
								$title_val = get_the_title($conid);
							}
							else if(isset($_POST['contestant-title'])){
								$title_val = $_POST['contestant-title'];
							}
							else{
								$title_val = "";
							}
						?>
						
						<input type="text" id="contestant-title<?php echo $id; ?>" name="contestant-title" value="<?php echo $title_val; ?>"/>
						
						<?php if($title_rs['set_limit'] == 'Y'){ ?>
							<div class="wpvc_limit_counter" id="contestant-title<?php echo $id; ?>_limitcount"></div>
							<script type="text/javascript">
								var $ = jQuery.noConflict();
								jQuery(document).ready(function() {
									var text_max = '<?php echo $title_rs['limit_count'] ?>';
									jQuery("#contestant-title<?php echo $id; ?>").attr('maxlength',text_max);
									
									jQuery('#contestant-title<?php echo $id; ?>_limitcount').html(text_max + ' characters remaining');
								
									jQuery('#contestant-title<?php echo $id; ?>').keyup(function() {
										var text_length = jQuery('#contestant-title<?php echo $id; ?>').val().length;
										var text_remaining = text_max - text_length;
								
										jQuery('#contestant-title<?php echo $id; ?>_limitcount').html(text_remaining + ' characters remaining');
									});
								});
							</script>
						<?php } ?>
						
					</div>
				</div>
				
				<?php
                
                $desc_rs = WPVC_Vote_Shortcode_Model::wpvc_array_search($main_fields,'system_name','contestant-desc');
                				
				//Check if it is made visible in the admin end
				if($desc_rs['admin_only'] == "Y"){            
					$required_desc = ($desc_rs['required'] == "Y")?"*":'';
				?>
				
				<div class="wpvc_add_contestants_row contestant_desc">                
					<div class="wpvc_add_contestants_label">
						<label><?php echo $desc_rs['question']; ?>  <span class="required-mark"><?php echo $required_desc; ?></span></label>
					</div>
					<div class="wpvc_add_contestants_field_desc">
						
						<?php
							if($conid != null){
								$content_post = get_post($conid);
								$desc_val = $content_post->post_content;
								$desc_val = apply_filters('the_content', $desc_val);
							}
							else if(isset($_POST['contestant-desc'])){
								$desc_val = $_POST['contestant-desc'];
							}
							else{
								$desc_val = "";
							}
						?>
						
						
						<?php
						if(user_can_richedit()) {							
							$settings = array('media_buttons' => FALSE,'textarea_rows' => 2,'tinymce' => false);
							wp_editor($desc_val, 'contestant-desc'.$id, $settings);
						}
						else {
						?>
							<textarea style="width:100%;" id="contestant-desc<?php echo $id; ?>" name="contestant-desc" class="contestant-desc"><?php echo $desc_val; ?></textarea>
						<?php
						}
						?>
						<?php if($desc_rs['required'] == "Y"){ ?>
						<script>
							jQuery(document).ready(function(){
							add_contestant_validation_method("<?php echo 'contestant-desc'.$id; ?>","<?php _e('Enter the contestant description','voting-contest'); ?>");
							});
						</script>
						<?php } ?>
						<?php if($desc_rs['set_limit'] == 'Y'){ ?>
							<div class="wpvc_limit_counter" id="contestant-desc<?php echo $id; ?>_limitcount"></div>
							<script type="text/javascript">
								var $ = jQuery.noConflict();
								jQuery(document).ready(function() {
									var text_max = '<?php echo $desc_rs['limit_count']; ?>';
									jQuery("#contestant-desc<?php echo $id; ?>").attr('maxlength',text_max);
									
									jQuery('#contestant-desc<?php echo $id; ?>_limitcount').html(text_max + ' characters remaining');
								
									jQuery('#contestant-desc<?php echo $id; ?>').keyup(function() {
										var text_length = jQuery('#contestant-desc<?php echo $id; ?>').val().length;
										var text_remaining = text_max - text_length;
								
										jQuery('#contestant-desc<?php echo $id; ?>_limitcount').html(text_remaining + ' characters remaining');
									});
								});
							</script>
						<?php } ?>
					</div>
				</div>				
				<?php }  ?>
				
				<?php
                    
                    $contest_image = WPVC_Vote_Shortcode_Model::wpvc_array_search($main_fields,'system_name','contestant-image');                    
                    if($image_contest != 'on'){                   
                    
                   $imgrequired='on';
                    
                    if($image_contest == 'photo') { 
						
					?>
					<div class="wpvc_add_contestants_row contestant_image">
						
						<div class="wpvc_add_contestants_label">
							<label><?php echo $contest_image['question']; ?><?php echo ($imgrequired=='on')?'<span class="required-mark">*</span>':''?></label>
						</div>
						
						<div class="wpvc_add_contestants_field">
                            
                             
                            <?php
                                $allowed_filetypes_img = ($contest_image['response'] == null)?__("All","voting-contest"):$contest_image['response'];
								$allowed_filesizes_img = ($contest_image['wpvc_file_size'] == 0)?__("Any Size","voting-contest"):$contest_image['wpvc_file_size'];
                                
                                if($allowed_filetypes_img != 'All'){
                                    $allowed_mime_filetype = WPVC_Vote_Common_Controller::wpvc_get_mime_type($allowed_filetypes_img);
                                    //Form Allowed mime for Javascript
                                    $allowed_types = implode('","',$allowed_mime_filetype);
                                    $allowed_types = '"'.$allowed_types.'"';
                                }
                                
                                
                               
                            ?>
                            
							
							<input type="file" id="contestant-image<?php echo $id; ?>"  name="contestant-image<?php echo $id; ?>" class="contestant-input"  accept="image/*" />
							                            
                            <div class="contestant_image_info">
                                <span class='wpvc_allowed_file'><?php echo __('Allowed File Types : ','voting-contest').$allowed_filetypes_img; ?></span>
    							<span class='wpvc_allowed_file'><?php echo __('Allowed File Size Limit : ','voting-contest').$allowed_filesizes_img; ?>MB</span>
                            </div>
                            
                            <img style="display: none;" id="uploaded_img<?php echo $id; ?>" src="<?php echo get_the_post_thumbnail_url($conid,'thumbnail'); ?>" class="ow_uploaded_image"/>                      
							
							<?php if($conid != null){ ?>															
								<script type="text/javascript">
									jQuery(document).ready(function($) {
										$('#<?php echo 'uploaded_img'.$id; ?>').show();
									});
								</script>								
							<?php } ?>
							
						</div>
					</div>
					
						<script type="text/javascript">
							jQuery(document).ready(function($) {
														
								function wpvc_preview_img(input) {
									if (input.files && input.files[0]) {
										var reader = new FileReader();						
										reader.onload = function (e) {
											$('#<?php echo 'uploaded_img'.$id; ?>').attr('src', e.target.result);
											$('#<?php echo 'uploaded_img'.$id; ?>').show();
										}						
										reader.readAsDataURL(input.files[0]);
									}
								}						
								$("#<?php echo 'contestant-image'.$id; ?>").change(function(){							
									wpvc_preview_img(this);									
								});
								
							});
						</script>
					
						<?php if($imgrequired=='on'){ ?>						
							<?php if($conid == null && $contest_image['wpvc_file_size'] != 0){ ?>                            
							<script type="text/javascript">
                                wpvc_add_contestant_validation_method_file_image("<?php echo 'contestant-image'.$id; ?>","<?php _e('Please upload the file','voting-contest'); ?>",<?php echo $allowed_filesizes_img; ?>);		
                                function wpvc_add_contestant_validation_method_file_image(id_validate,message,size = "") {	
									jQuery(document).ready(function($) {
                                        if(size != 0){
                                            jQuery("#"+id_validate).wpvc_vote_rules( "add", {
                                                required:true,        
                                                maxFileSize: {
                                                        "unit": "MB",
                                                        "size": size
                                                    },
                                                fileType : {
                                                        "types": [<?php echo $allowed_types; ?>]
                                                },
                                            });
                                        }
                                        else{
                                            add_contestant_validation_method("<?php echo $contest_image['system_name'].$id; ?>","<?php echo ($contest_image['required_text'])?$contest_image['required_text']:"This Field is required"; ?>");
                                        }										
									});
                                }
							</script>
							<?php }else{ ?>
                                <script>
                                    jQuery(document).ready(function($) {
                                    add_contestant_validation_method("<?php echo $contest_image['system_name'].$id; ?>","<?php echo ($contest_image['required_text'])?$contest_image['required_text']:"This Field is required"; ?>");
                                    });
                                </script>
                            <?php } ?>
						<?php } ?>
					<?php } ?>		
				<?php } ?>
				
				 <!-- Custom Fields -->
				  <?php
					$wpvc_video_extension = get_option('_wpvc_video_extension');
					
					if($conid != null){
						$custom_entries = WPVC_Contestant_Model::wpvc_voting_get_all_custom_entries($conid); 
						
						if(!empty($custom_entries)){
							$field_values = $custom_entries[0]->field_values;
							if(base64_decode($field_values, true))
								$field_val = maybe_unserialize(base64_decode($field_values));  
							else
								$field_val = maybe_unserialize($field_values);												
						}
						
						
					}
								
					
					
				 ?>
				 
			<script>
			jQuery(document).ready(function(){
			    var valid = true;
			   	jQuery(".wpvc_form_add-contestants<?php echo $id; ?>").submit(function (evt){
					
									
				    if (jQuery('.wpvc_open_login_form').val() == 1) {						    
					jQuery('.wpvc_form_add-contestants<?php echo $id; ?> input').each(function (i) {
					    if(jQuery(this).hasClass('error')){
						valid = false;
						return false;
					    }
					    else{
						 valid = true;
					    }
					});				   
					if (valid == false) {		   			   
						return false;
					}
					else{
						valid = true; 
						//Check the form is open or not logged in 
						if (valid != false) { 
						    window.contest_id = "<?php echo $id;?>";
						    wpvc_vote_ppOpen('#wpvc_vote_login_panel', '300',1);
						    //Tab in the Login Popup
						    jQuery('.wpvc_tabs_login_content').show();
						    jQuery('.wpvc_tabs_register_content').hide();
						    jQuery( '.wpvc_tabs_login' ).addClass('active');
						    evt.preventDefault();
						    return false;
						}
					}
				    }
				});			
		    
			});
			</script>
			<?php if($conid == null){ ?>
			<?php apply_filters('wpvc_add_form_extras',$id); ?>
			<?php } ?>
			 
			<div class="wpvc_add_contestants_row contestant_submit">
    				<div class="wpvc_contestants-label">
    					
    				</div>
    				<div class="wpvc_contestants-field">
    					<input type="hidden" id="contestantform<?php echo $id;?>"  name="contestantform<?php echo $id;?>" value="contestantform<?php echo $id;?>"/>
    					<input type="submit" id="savecontestant<?php echo $id;?>" name="savecontestant" class="savecontestant savecontest" value="<?php _e('Save','voting-contest'); ?>"/>
						<?php do_action('owvoting_preview_button'); ?>
    				</div>
    			</div>
    
    			<input type="hidden" name="contest-id" value="<?php echo $id; ?>"/>		
			
					
			</form>
			
			<?php } ?>
			
		</div>

			

		<?php

		switch($action_url){	
					
			case 'contestrules':					
				$contest_id = base64_decode($_GET['contest_id']);
				if($contest_id==$id){
					$html_out = do_shortcode('[rulescontestants id='.$id.']');
					wp_reset_postdata();
					echo $html_out."</div>";
					return;
				}
			break;
		}
		
    }
}else{
    die("<h2>".__('Failed to load Voting Shortcode view','voting-contest')."</h2>");
}
?>
