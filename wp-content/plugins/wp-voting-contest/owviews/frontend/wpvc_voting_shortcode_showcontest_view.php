<?php
if(!function_exists('wpvc_voting_shortcode_showcontestant_view')){
    function wpvc_voting_shortcode_showcontestant_view($shwpvc_cont_args,$vote_opt,$category_options){
		if(get_query_var('page') == 0){
			$_SESSION['seed'] = "";
		}
		$view = "";
		$tax_hide_photos_live = $shwpvc_cont_args['tax_hide_photos_live'];	
		$permalink = get_permalink( get_the_ID());
		
		if(!isset($_SESSION['GET_VIEW_SHORTCODE'])){
			$_SESSION['GET_VIEW_SHORTCODE']=1;
		}
		else{
			$_SESSION['GET_VIEW_SHORTCODE']=$_SESSION['GET_VIEW_SHORTCODE']+1;
		}
				
		$_SESSION['wpvc_voting_page_permalink']=$permalink;
		
		$global_options =WPVC_Vote_Common_Controller::wpvc_vote_get_all_global_settings($vote_opt);
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
		
		//Open/Close Mobile Menu
		if(!empty($vote_openclose_menu) && $vote_openclose_menu == 'on'){
			$menu_class = 'menu_open';
			echo "<style>@media (min-width:250px) and (max-width:767px) {ul.wpvc_vote_menu_links{display:block !important;}}</style>";			
		}
		else{
			$menu_class = "";
			echo "<style>@media (min-width:250px) and (max-width:767px) {ul.wpvc_vote_menu_links{display:none !important;}}</style>";			
		}
		
		$enc_termid = WPVC_Vote_Common_Controller::wpvc_voting_encrypt($id);
		
		
		if (trim($title)){ ?>
			<div class="wpvc_contest_caption"><h1><?php echo $title; ?></h1></div>
		<?php
		}

		if(isset($_GET['contest']))
		    $action_url  = $_GET['contest'];
		else
		    $action_url  = '';
		 
		   
				
		if(isset($_GET['contest_id']))
		    $contest_id = base64_decode($_GET['contest_id']);
		//Show timer on start/end contestants	
		if($showtimer) {
			if(WPVC_Vote_Common_Controller::wpvc_vote_is_contest_started($id )){
				$out_html = do_shortcode('[endcontestants id='.$id.' message=1]');
			}else
				$out_html = do_shortcode('[upcomingcontestants id='.$id.' showcontestants=0 message=0]');
			
			echo $out_html;
		}		
					
		//Get the query to execute
		$contest_post = WPVC_Vote_Shortcode_Model::wpvc_get_shwpvc_contest_query($shwpvc_cont_args);
						
		if($vote_prettyphoto_disable != 'on'){ //PrettyPhoto Disable is on
		    echo "<input type='hidden' class='vote_prettyphoto_disable' value='1' />";
		}
		else{
		    echo "<input type='hidden' class='vote_prettyphoto_disable' value='0' />";
		}
		
		
		?>
			
		<div class="wpvc_vote_shwpvc_contestants">

			<?php
					if (false !== strpos($permalink,'?')){
						$url_prefix = '&amp;';
					}
					else{
						$url_prefix = '?';
					}
					
					if(($vote_onlyloggedcansubmit!=''||$onlyloggedinuser!='') && !is_user_logged_in()){
						if($_SESSION['GET_VIEW_SHORTCODE']==1)
						WPVC_Vote_Shortcode_Controller::wpvc_votes_custom_registration_fields_show();
					}
					
					if($vote_onlyloggedcansubmit!='' && !is_user_logged_in()){
						$login_class="wpvc_logged_in_enabled";
					}
					else{$login_class="wpvc_loggin_disabled";}
			?>
				
			<?php if($navbar !=0 ){ ?>
			
			<div class="wpvc_vote_contest_top_bar">
				<div class="wpvc_tog menudiv">
					<a href="javascript:" class="togglehide"><span class="wpvc_vote_icons votecontestant-menu-down <?php echo $menu_class; ?>"></span></a>
				</div>
				
				<ul class="wpvc_vote_menu_links">					
					<?php					
					if(($showform != 0) && $global_options['vote_entry_form'] != 1){				    
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
					    <li class="wpvc_vote_navmenu_link">
						
						    <a class="<?php echo $login_class; ?> wpvc_vote_submit_entry" data-id="<?php echo $id; ?>">
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
					    }
					    //else{						
						//StartTime Limit
						if($votes_start_time !='' && strtotime($votes_start_time) > $current_time){
						    echo "<input type='hidden' id='wpvc_contest_closed_".$id."' value='start' />";
						    $closed_desc = $global_options['vote_tobestarteddesc'];
						    echo "<input type='hidden' class='wpvc_contest_closed_desc' value='".$closed_desc."' />";
						}
						
					    //}
					}
					?>
					
					<li class="wpvc_vote_navmenu_link <?php echo (isset($action_url) && $action_url=='gallery' && $contest_id==$id)?'wpvc_active_gallery active':''; ?>">
						<a href="<?php echo $permalink.$url_prefix.'contest=gallery&amp;contest_id='.base64_encode($id);?>">
							<span class="wpvc_vote_icons voteconestant-camera"></span><?php _e('Gallery','voting-contest'); ?>
						</a>
					</li>
										
					<?php
					
					if($category_options['vote_contest_rules']!=''){ ?>
						<li class="wpvc_vote_navmenu_link <?php echo ((isset($action_url) && $action_url=='contestrules') && $contest_id==$id)?'wpvc_active_contest_rules active':''; ?>">
							<a href="<?php echo $permalink.$url_prefix.'contest=contestrules&amp;contest_id='.base64_encode($id); ?>">
								<span class="wpvc_vote_icons voteconestant-gift"></span><?php _e('Rules and Prizes','voting-contest'); ?>
							</a>
						</li>
					<?php } ?>
										
					
					<?php if($sort_by==1){ ?>
					<li class="wpvc_vote_menu_sort">
						<form name="select_filter" id="wpvc_vote_select_filter<?php echo $id; ?>" method="post">
						<?php
						
						if(isset($_SESSION['wpvc_vote_search_filter'.$id])){
						    $session_filter = $_SESSION['wpvc_vote_search_filter'.$id];
						}
						else{
						    $session_filter = '';
						}						
						?>
						<select name="filter_votes" class="wpvc_vote_filter_votes" id="<?php echo $id; ?>">
							<option value="sort">Sort</option>
							<option value="new_contestant" <?php echo($session_filter=='new_contestant')?'selected':'';?>><?php _e('Newest','voting-contest'); ?></option>
							<option value="old_contestant" <?php echo($session_filter=='old_contestant')?'selected':'';?>><?php _e('Oldest','voting-contest'); ?></option>
							<?php if($category_options['votecount'] != 'on'): ?>
							<option value="votes_top" <?php echo($session_filter=='votes_top')?'selected':'';?>><?php _e('Most voted','voting-contest'); ?></option>
							<option value="votes_down"<?php echo($session_filter=='votes_down')?'selected':'';?> ><?php _e('Least voted','voting-contest'); ?></option>
							<?php endif; ?>
						</select>
						<input type="hidden" name="filter_view" id="wpvc_filter_view<?php echo $id; ?>" />
						<input type="hidden" name="category_id" value="<?php echo $id; ?>">
						</form>
					</li>
					<?php } ?>
					
					
					
					<?php
						if($action_url =='topcontestant' && $contest_id != $id){
						
							if($view==''){
							//By default list view
							$view = 'list';$default_view='list';
							}
						}
					if($category_options['imgcontest']=='photo' && current_user_can('administrator')){
						 apply_filters('wpvc_navigation_bar_hook',$id);	
					}
                   
					if($action_url !='topcontestant' && $action_url != 'contestrules') { ?>
							<?php if($view==''){
								//By default list view
								$view = 'list';$default_view='list';
								if(isset($_POST['filter_view'])){$view =$_POST['filter_view']; } 
							?>
							<?php }
							
							
							?>
							<li class="wpvc_vote_float_right wpvc_vote_no_border">
								<a class="wpvc_vote_list_shwpvc_contest wpvc_vote_icons voteconestant-list <?php echo ($view=='list')?'wpvc_list_active':'';?>" data-id="<?php echo $id;?>" id="list_show<?php echo $id; ?>">
								</a>
								<a class="wpvc_vote_grid_shwpvc_contest wpvc_vote_icons voteconestant-grid <?php echo ($view=='grid')?'wpvc_grid_active':'';?>" data-id="<?php echo $id;?>" id="grid_show<?php echo $id; ?>">
								</a>
							</li>
							<?php 
					} ?>
				</ul>
			</div>
			
			<?php } ?>
			
		<?php
		
		if($showform == 1){
			$showform_attr = ' showform=1 ';
		}
		else{
			$showform_attr = ' ';
		}
		if($showform != 0){
			$add_contestant_html = do_shortcode('[addcontestants id='.$id.' '.$showform_attr.' showcontestants=0 displayform=1 contestshowfrm=0 message=0]');	
			echo $add_contestant_html;
		}
	
		switch($action_url){				
			case 'contestrules':					
				$contest_id = base64_decode($_GET['contest_id']);
				if($contest_id==$id){
					
					return;
				}
			break;
		}
			

		if($contest_post=='error'){
			return '<div class="wpvc_vote_shwpvc_contestants">'._e('No contestants to display.','voting-contest').'</div>';
		}

		$image_contest = $category_options['imgcontest'];
	
			
		$title_rs = WPVC_Vote_Shortcode_Model::wpvc_voting_get_contestant_title();
		echo '<input type="hidden" id="contest_post_'.$id.'" value="'.$id.'" />';
		$uploads = wp_upload_dir();
		$export_path = $uploads['url'].'/final.zip';
		echo '<input type="hidden" class="wpvc_upload_directory" value="'.$export_path.'" />';
		if($contest_post){
			if ($contest_post->have_posts()) {
										
				?>				
				<div id="wpvc_views_container_<?php echo $id; ?>" class="wpvc_vote_view_<?php echo $id.' wpvc_vote_'.$view;?> wpvc_views_container" data-view="<?php echo $view; ?>">
					<div class="wpvc_contest-posts-container<?php echo $id; ?> wpvc_vote_post_container_show">
					<?php
					while ($contest_post->have_posts()) {
						$contest_post->the_post();
						$totvotesarr = get_post_meta(get_the_ID(), WPVC_VOTES_CUSTOMFIELD);
						$totvotes = isset($totvotesarr[0]) ? $totvotesarr[0] : 0;
						if($totvotes == NULL) $totvotes = 0;
				
						$enc_postid = WPVC_Vote_Common_Controller::wpvc_voting_encrypt(get_the_ID());
						
						/*********** Style ***********/
						$style_image = $style_image_overlay = '';
						if($height!=''){
							$style_image .='height:'.$height.'px;';
							$style_image_overlay .='height:'.$height.'px;';
						}
						if($width!=''){
							$style_image .='width:'.$width.'px;';
							$style_image_overlay .='width:'.$width.'px;';
						}
						
						$vote_single_img_width_value = $single_page_cont_image_m_px;					
						if($vote_single_img_width_value == 'on') {
							$vote_single_img_width_value = 'px';
						}				
						$vote_single_img_width = $single_page_cont_image_m;
						   $num = $vote_single_img_width;
						   $int = (int)$num;				   
						if($int == null){
							$int = 100;
						}
						$style_mob_image_overlay = $int.$vote_single_img_width_value;
						
						$adv_excerpt = WPVC_Vote_Excerpt_Controller::Instance();
						$shor_desc = $adv_excerpt->filter(get_the_excerpt());
						$term = get_term( $id, WPVC_VOTES_TAXONOMY );
					?>
					<div class="wpvc_vote_showcontent_view wpvc_vote_showcontent_<?php echo $id; ?>" data-id="<?php echo $id; ?>">
						<div class="wpvc_vote_show">
							<div class="wpvc_shwpvc_contestant wpvc_pretty_content<?php echo get_the_ID(); ?>">
								<?php
								//Title code
								if($vote_truncation_list!=''){
									$title_string = strlen(get_the_title());
									if($title_string > $vote_truncation_list){
										$list_details = mb_substr(get_the_title(),'0',$vote_truncation_list).'..';
									}else{
										$list_details= get_the_title();
									}
								}
								else{
									$title_len= strlen(get_the_title());
									if($title_len > 50){
										$list_details= mb_substr(get_the_title(),'0','50').'..';
									}else{
										$list_details= get_the_title();
									}
								}
							
								if($vote_truncation_grid!=''){
									$grid_details = strlen(get_the_title());
									if($grid_details > $vote_truncation_grid){
										$grid_details = mb_substr(get_the_title(),'0',$vote_truncation_grid).'..';
									}else{
										$grid_details= get_the_title();
									}
								}else{
									$title_len= strlen(get_the_title());
									if($title_len > 15){
										$grid_details = substr(get_the_title(),'0','15').'..';
									}else{
										$grid_details = get_the_title();
									}
								}
								
								if($view=='list' || $view ==''){
									$title_vote = $list_details;
								}elseif($view=='grid'){
									$title_vote = $grid_details;
								}
								
								
								//Image code
								$wpvc_image_alt_text=WPVC_Vote_Common_Controller::wpvc_vote_seo_friendly_alternative_text(get_the_title());	
								$perma_link = get_permalink(get_the_ID());
								
								if($tax_hide_photos_live == 0){
								    $thumb = 0;
								}
								if($thumb!='' && $thumb!=0){								    
									$shwpvc_desc_pretty = WPVC_Vote_Shortcode_Model::wpvc_vote_shwpvc_desc_prettyphoto();
									$pretty_excerpt = ($shwpvc_desc_pretty == 1)?strip_tags($shor_desc):'';
									if (has_post_thumbnail(get_the_ID())) {
									    $short_cont_image = ($short_cont_image=='')?'thumbnail':$short_cont_image;
									    $wpvc_image_arr = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $short_cont_image);
									    $wpvc_original_img = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID())).'?'.uniqid();
									    $wpvc_image_src = $wpvc_image_arr[0];
		    									   
									    $img_width = $width;
									    echo '<input type="hidden" class="wpvc_vote_img_wdth wpvc_vote_img_width'.$id.'" value="'.$img_width.'">';
										
									}else{
									    $wpvc_image_src = WPVC_NO_IMAGE_CONTEST;
									    $wpvc_original_img = WPVC_NO_IMAGE_CONTEST;									    
									}
									$perma_link = WPVC_Vote_Common_Controller::wpvc_votes_get_contestant_link(get_the_ID());
									$wpvc_original_img = ($vote_prettyphoto_disable != 'on')?$wpvc_original_img:$perma_link;
									if(($vote_title_alocation!='on') || ($view=='list' || $view=='')){
									?>
									<div class="vote_left_side_content vote_left_sid<?php echo $id; ?>">
										<a alt="<?php echo $wpvc_image_alt_text; ?>" class="wpvc_hover_image"  data-pretty-title="<?php echo $pretty_excerpt; ?>" href="<?php echo $wpvc_original_img; ?>" data-vote-id="<?php echo get_the_ID(); ?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $id; ?>" data-vote-gallery="wpvc_vote_prettyPhoto[<?php echo $term->name; ?>]">
											<?php if($vote_prettyphoto_disable != 'on'): //PrettyPhoto Disable is on ?>
											<div class="wpvc_overlay_bg wpvc_overlay_<?php echo get_the_ID(); ?>"  data-mob="<?php echo $style_mob_image_overlay;?>">
												<span><i class="wpvc_vote_icons voteconestant-zoom"></i></span>
											</div>
											<?php endif; ?>
											<img class="wpvc_vote_img_style<?php echo $id; ?> wpvc_img_class" id="wpvc_image_responsive<?php echo get_the_ID(); ?>" <?php echo ($vote_turn_lazy == 'on')?'data-src':'src'; ?>="<?php apply_filters('wpvc_image_external_src',$wpvc_image_src,get_the_ID()); ?>" style="<?php echo $style_image; ?>" alt="<?php echo $wpvc_image_alt_text; ?>" data-mob="<?php echo $style_mob_image_overlay;?>" data-pretty-alt="<?php echo ($title_rs[0]->pretty_view == 'Y')?$wpvc_image_alt_text:''; ?>"/>
										</a>
									</div>
									<?php
									}
									$wpvc_vote_full_width_class = '';
								}else{
									$wpvc_vote_full_width_class = 'wpvc_full_width_class';
								}
								?>
								<div class="vote_right_side_content wpvc_right_dynamic_content<?php echo $id; ?>">
									<input type="hidden" class="wpvc_title_alocation_description<?php echo $id; ?>" value="<?php echo $vote_title_alocation; ?>">
									<input type="hidden" class="wpvc_image_contest<?php echo $id; ?>" value="<?php echo $image_contest; ?>">
									<input type="hidden" class="wpvc_shwpvc_description<?php echo $id; ?>" value="<?php echo $category_options['shwpvc_description']; ?>">
										<?php
										if($image_contest=='photo'){
											if(($vote_title_alocation=='on' && $view=='grid') || ($view=='list' || $view=='')) {
												wpvc_title_shwpvc_category($vote_title_alocation,$view,$wpvc_vote_full_width_class,$id,$perma_link,$title_vote,$grid_details,$term,$termdisplay,$global_options);
												if($wpvc_vote_full_width_class=='' && $vote_title_alocation=='on' && $view=='grid'){
													?>
													<div class="vote_left_side_content vote_left_sid<?php echo $id; ?>">
														<a alt="<?php echo $wpvc_image_alt_text; ?>" class="wpvc_hover_image"  data-pretty-title="<?php echo $pretty_excerpt; ?>" href="<?php echo $wpvc_original_img; ?>" data-vote-id="<?php echo get_the_ID(); ?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $id; ?>" data-vote-gallery="wpvc_vote_prettyPhoto[<?php echo $term->name; ?>]">
															<?php if($vote_prettyphoto_disable != 'on'): //PrettyPhoto Disable is on ?>
															<div class="wpvc_overlay_bg wpvc_overlay_<?php echo get_the_ID(); ?>"  data-mob="<?php echo $style_mob_image_overlay;?>">
																<span><i class="wpvc_vote_icons voteconestant-zoom"></i></span>
															</div>
															<?php endif; ?>
															<img class="wpvc_vote_img_style<?php echo $id; ?> wpvc_img_class" id="wpvc_image_responsive<?php echo get_the_ID(); ?>" <?php echo ($vote_turn_lazy == 'on')?'data-src':'src'; ?>="<?php echo $wpvc_image_src; ?>" style="<?php echo $style_image; ?>" data-mob="<?php echo $style_mob_image_overlay;?>" alt="<?php echo $wpvc_image_alt_text; ?>" data-pretty-alt="<?php echo ($title_rs[0]->pretty_view == 'Y')?$wpvc_image_alt_text:''; ?>"/>
														</a>
													</div>
													<?php
												}
											}
										}
										
										?>
										<?php 
                                        if($vote_title_alocation=='off' && $view=='grid') { 
                                            wpvc_title_shwpvc_category($vote_title_alocation,$view,$wpvc_vote_full_width_class,$id,$perma_link,$title_vote,$grid_details,$term,$termdisplay,$global_options);
                                        }
                                        ?>
                                        <div class="wpvc_shwpvc_text_desc wpvc_shwpvc_desc_view_<?php echo $id.' '.$wpvc_vote_full_width_class; ?>">
                                        <?php
                                        echo $shor_desc;
                                        echo '</div>';    
										
										?>										
																				
												
										<?php
										if($shor_desc!='' && $vote_readmore=='off'){ ?>
										<div class="wpvc_shwpvc_read_more <?php echo $wpvc_vote_full_width_class; ?>">
											<?php $perma_link = WPVC_Vote_Common_Controller::wpvc_votes_get_contestant_link(get_the_ID()); ?>
											<a href="<?php echo $perma_link; ?>" title="<?php echo $wpvc_image_alt_text; ?>">
											<?php _e('More Info','voting-contest'); ?></a>
										</div>
										<?php } ?>
																	
								</div>	
							</div>
							
							<div class="wpvc_shwpvc_vote_cnt wpvc_pretty_content_social<?php echo get_the_ID(); ?>">
								<div class="wpvc_shwpvc_share_icons_div wpvc_fancy_content_social<?php echo get_the_ID(); ?>">
									<?php if($facebook!='off') { ?>
										<a class="wpvc_shwpvc_share_icons" title="<?php _e('Share on Facebook','voting-contest'); ?>" data-ref="&#xe027;" target="_blank" 
										href="http://www.facebook.com/sharer.php?u=<?php echo $perma_link.'&amp;t='.htmlentities(get_the_title(),ENT_QUOTES); ?>">
										</a>
									<?php }if($twitter!='off') { ?>
										<a class="wpvc_shwpvc_share_icons" title="<?php _e('Share on Twitter','voting-contest'); ?>" data-ref="&#xe086;" target="_blank"
										href="http://twitter.com/home?status=<?php echo htmlentities(get_the_title(),ENT_QUOTES).'%20'.$perma_link;?>">
										</a>
									<?php }if($pinterest!='off') { ?>
										<a class="wpvc_shwpvc_share_icons" title="<?php _e('Share on Pinterest','voting-contest'); ?>" data-ref="&#xe064;" target="_blank"
										href="http://www.pinterest.com/pin/create/button/?url=<?php echo htmlentities($perma_link).'&amp;description='.htmlentities(get_the_title(),ENT_QUOTES).'&amp;media='.htmlentities($wpvc_image_src) ?>">
										</a>
									<?php }if($tumblr!='off') {?>
										<a class="wpvc_shwpvc_share_icons" title="<?php _e('Share on Tumblr','voting-contest'); ?>" data-ref="&#xe085;" target="_blank"
										 href="http://www.tumblr.com/share/photo?source=<?php echo htmlentities($wpvc_image_src).'&amp;caption='.htmlentities(get_the_title(),ENT_QUOTES).'&amp;clickthru='.htmlentities($perma_link); ?>">
										</a>
									<?php } ?>
								</div>
								
								
								<div class="wpvc_shwpvc_vote_square">
									<span class="wpvc_vote_cnt_num wpvc_vote_count<?php echo get_the_ID(); ?>"><?php echo $totvotes; ?></span>
									<span class="wpvc_vote_cnt_content"><?php _e('Votes','voting-contest'); ?></span>
								</div>
								<?php 
								
								$email_class= "";
								
								//Grab Email Address for IP and COOKIE
								if($vote_grab_email_address == "on" && $vote_tracking_method != 'email_verify' && !is_user_logged_in()){
									WPVC_Vote_Shortcode_Controller::wpvc_voting_email_grab();
									$email_class = "wpvc_voting_grab"; 
								}
								
								 
                                if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
                                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                 } else {
                                 $ip = $_SERVER['REMOTE_ADDR'];
                                }
								
								$exipration = $id. '_' . WPVC_VOTES_TAXEXPIRATIONFIELD;
								$dateexpiry =  get_option($exipration);
								$cur_time = current_time( 'timestamp', 0 );
								if($dateexpiry==''){
									$dateexpiry = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
								}
								
								if($onlyloggedinuser!='' && !is_user_logged_in()){
									$wpvc_login_class="wpvc_logged_in_enabled";
								}
								else{
								    $wpvc_login_class="wpvc_loggin_disabled";
								}
									
								if(strtotime($dateexpiry) >= $cur_time){
									if(is_user_logged_in()){
									    $user_id = get_current_user_id();
									    $ip = $user_id;
									}
									$is_votable = WPVC_Vote_Save_Controller::wpvc_check_contestant_is_votable(get_the_ID(), $ip, $id); 
													
									if(!$is_votable){
									    $green_class = (WPVC_Vote_Save_Controller::wpvc_is_current_user_voted_post_id(get_the_ID(), $ip, $id))?'wpvc_voting_green_button':'';
										if($vote_votingtype != null && $frequency == 11){
										    $grey_class = (WPVC_Vote_Save_Controller::wpvc_is_current_user_voted(get_the_ID(), $ip, $id))?'':'wpvc_voting_grey_button';
											if($vote_votingtype==1 || $vote_votingtype_val==2){
												if($grey_class=='' && $green_class!='')
												$grey_class=$green_class;
											}
										}
										else
											$grey_class = ($green_class)?$green_class:'wpvc_voting_grey_button';
										?>
											<div class="wpvc_shwpvc_vote_button">
                                            
                                                <?php apply_filters('wpvc_votes_btn_before',$id,get_the_ID());  ?>
                                            
												<a class="wpvc_votebutton <?php echo $email_class.' '.$grey_class .' '.$wpvc_login_class; ?> voter_a_btn_term<?php echo $id; ?> <?php apply_filters('vote_restriction',get_the_ID()); ?> <?php echo ($grey_class == 'wpvc_voting_green_button')?apply_filters('wpvc_votes_btn_class',$id):''; ?>" data-vote-count="<?php echo $category_options['vote_count_per_contest'];?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $id; ?>" data-vote-id="<?php echo get_the_ID(); ?>" data-frequency-count="<?php echo $vote_frequency_count; ?>" data-voting-type="<?php echo $vote_votingtype_val; ?>" >
                                                
                                                    <span class="wpvc_vote_button_content votr_btn_cont<?php echo get_the_ID();?> voter_btn_term<?php echo $id; ?>">
                                                        <?php if($grey_class == 'wpvc_voting_green_button'){ ?>
                                                            <?php echo apply_filters('wpvc_votes_btn',__('Voted','voting-contest'),$id) ;?>
                                                        <?php } else {?>
                                                            <?php _e('Vote Now','voting-contest') ;?>
                                                        <?php } ?>
                                                    </span>
                                                    
                                                    <?php apply_filters('vote_button_hook',''); ?>
												</a>
											</div>
										<?php
									}else{
										?>
										<div class="wpvc_shwpvc_vote_button">
											<a class="wpvc_votebutton <?php echo $email_class.' '.$wpvc_login_class; ?> voter_a_btn_term<?php echo $id; ?> <?php apply_filters('vote_restriction',get_the_ID()); ?>"  data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $id; ?>" data-vote-count="<?php echo $category_options['vote_count_per_contest'];?>" data-vote-id="<?php echo get_the_ID(); ?>" data-frequency-count="<?php echo $vote_frequency_count; ?>"  data-voting-type="<?php echo $vote_votingtype_val; ?>" >
                                            
                                                <span class="wpvc_vote_button_content votr_btn_cont<?php echo get_the_ID();?> voter_btn_term<?php echo $id; ?>">
                                                    <?php _e('Vote Now','voting-contest') ;?>
                                                </span>
                                            
											</a>
											
											<?php apply_filters('vote_button_hook',get_the_ID()); ?>
										</div>
										<?php
									}
									
								}
								?>
								
							</div>
							
						</div>				
					</div>
				<?php
				}
				
				if(isset($pagination) && $pagination != 0){
				    $pagination_type =  voting_wp_pagenavi(array('query' => $contest_post),$id);				    
				    echo $pagination_type;
				}
              
				wp_reset_postdata();
				
				apply_filters('wpvc_vote_shortcode_bottom',$enc_termid);
				
				?>
				</div>				
				</div>
				<?php
			}else{
				echo '<div class="wpvc_votes_error">'.__('No Contestants to display.','voting-contest').'</div>';				
			}
			}else{
				echo '<div class="wpvc_votes_error">'.__('There is an error with shortcode. Please check the overview page for examples','voting-contest').'</div>';
			}
			?>
		</div>
	<?php
    }
}else{
    die("<h2>".__('Failed to load Voting Shortcode view','voting-contest')."</h2>");
}

if(!function_exists('wpvc_title_shwpvc_category')){
	function wpvc_title_shwpvc_category($vote_title_alocation,$view,$wpvc_vote_full_width_class,$id,$perma_link,$title_vote,$grid_details,$term,$termdisplay,$global_options = ""){		
		 $perma_link = WPVC_Vote_Common_Controller::wpvc_votes_get_contestant_link(get_the_ID());
         if($global_options['vote_newlink_tab'] == 'on' && get_permalink(get_the_ID()) != $perma_link){
            $target = 'target="_blank"';
         }
         else{
            $target = "";
         }
		 ?>
		 <div class="wpvc_vote_title_content<?php echo $id; ?>">
			<h2 class="<?php echo $wpvc_vote_full_width_class; ?> wpvc_list_title<?php echo $id; ?>">
				<a href="<?php echo $perma_link; ?>" <?php echo $target; ?>><?php echo $title_vote; ?></a>
			</h2>
			<h2 style="display: none;" class="<?php echo $wpvc_vote_full_width_class; ?> wpvc_grid_title<?php echo $id; ?>">
				<a href="<?php echo $perma_link; ?>" <?php echo $target; ?>><?php echo $grid_details; ?></a>
			</h2>									
			<?php
			if(strlen($term->name)>29)
				$category_name = substr($term->name,'0','30').' <b>..</b>';
			else
				$category_name = $term->name;
				
			if ($termdisplay==1) {
				?>
				<div class="wpvc_shwpvc_category <?php echo $wpvc_vote_full_width_class; ?>">
				<?php _e('Category','voting-contest') ?> : <span><?php echo $category_name; ?></span>
				</div>
			<?php	
			}?>
		</div>
		<?php 
	}
}
?>
