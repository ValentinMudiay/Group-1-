<?php
if(!function_exists('wpvc_voting_single_contestant_view')){
    function wpvc_voting_single_contestant_view($option){

		do_action('single_contestants_head');

		global $wpdb,$post;
		add_action('wp_head', 'wpvc_sharing_contestant_function');
		get_header();

		$global_options = WPVC_Vote_Common_Controller::wpvc_vote_get_all_global_settings($option);
		if(!empty($global_options)){
			foreach($global_options as $variab => $glob_opt){
				$$variab = $glob_opt;
			}
		}

		if($onlyloggedinuser!='' && !is_user_logged_in()){
			WPVC_Vote_Shortcode_Controller::wpvc_votes_custom_registration_fields_show();
		}

		wp_enqueue_script("jquery");

		wp_register_style('WPVC_FRONT_CONTESTANT_STYLES', WPVC_ASSETS_FRONT_END_CSS_PATH);
		wp_enqueue_style('WPVC_FRONT_CONTESTANT_STYLES');


		wp_register_style('WPVC_FRONT_COLOR', WPVC_ASSETS_COLOR_RELPATH);
		wp_enqueue_style('WPVC_FRONT_COLOR');


		wp_register_script('wpvc_votes_block', WPVC_ASSETS_JS_PATH . 'wpvc_vote_block_div.js');
		wp_enqueue_script('wpvc_votes_block',array('jquery'));

		if($option['vote_disable_jquery_pretty']!='on'){
			wp_register_style('wpvc_vote_css_pretty', WPVC_ASSETS_CSS_PATH.'wpvc_vote_prettyPhoto.css');
			wp_enqueue_style('wpvc_vote_css_pretty');

			wp_register_script('wpvc_votes_pretty', WPVC_ASSETS_JS_PATH . 'wpvc_vote_prettyPhoto.js');
			wp_enqueue_script('wpvc_votes_pretty',array('jquery'));
		}

		if($option['vote_disable_jquery_fancy']!='on'){
			wp_register_style('wpvc_vote_css_fancy_box', WPVC_ASSETS_CSS_PATH.'wpvc_vote_fancybox.css');
			wp_enqueue_style('wpvc_vote_css_fancy_box');

			wp_register_script('wpvc_vote_fancy_box', WPVC_ASSETS_JS_PATH . 'wpvc_vote_fancybox.js');
			wp_enqueue_script('wpvc_vote_fancy_box',array('jquery'));
		}


		wp_register_script('wpvc_votes_shortcode', WPVC_ASSETS_JS_PATH . 'wpvc_vote_shortcode_jquery.js');
		wp_enqueue_script('wpvc_votes_shortcode',array('jquery'));

		wp_localize_script( 'wpvc_votes_shortcode', 'vote_path_local', array('votesajaxurl' => admin_url( 'admin-ajax.php' ),'vote_image_url'=>WPVC_ASSETS_IMAGE_PATH ) );

		$votes_view = (int)get_post_meta($post->ID, WPVC_VOTES_VIEWS, true);
		update_post_meta($post->ID, WPVC_VOTES_VIEWS, $votes_view + 1);

		//For css design stuffs
		if($vote_sidebar=='on')
			$align_center = 'wpvc_align_center';
		elseif($vote_select_sidebar=='')
			$align_center = 'wpvc_align_center';
		else
			$align_center = 'wpvc_no_align_center';

		$post_id = $post->ID;
		$terms = get_the_terms($post_id, WPVC_VOTES_TAXONOMY);

		foreach ($terms as $term) {
			$termids[] = $term->term_id;
			$term_id = $term->term_id;
			$cat_name    = $term->name;
		}
		$category_options = get_option($term_id . '_' . WPVC_VOTES_SETTINGS);

		$enc_termid = WPVC_Vote_Common_Controller::wpvc_voting_encrypt($term_id);
		$enc_postid = WPVC_Vote_Common_Controller::wpvc_voting_encrypt(get_the_ID());

		$main_navigation = $category_options['middle_custom_navigation'];
		$permalink = isset($_SESSION['wpvc_voting_page_permalink'])?$_SESSION['wpvc_voting_page_permalink']:'';

		if (false !== strpos($permalink,'?'))
			$url_prefix = '&amp;';
		else
			$url_prefix = '?';


		if($category_options['vote_contest_rules']==''){
			$no_border = 'wpvc_vote_no_border';
		}else{
			$no_border = '';
		}

		if(isset($global_options['single_contestants_video_width'])){
		    $video_width = $global_options['single_contestants_video_width'];
		}

		if(isset($global_options['single_page_title'])){
		    $single_title_position = $global_options['single_page_title'];
		}

		?>

		<section class="wpvc_vote_single_section">
			<div class="wpvc_vote_single_container">
				<div class="wpvc_contestant_values <?php echo $align_center; ?>">

					<div class="wpvc_vote_contest_top_bar">
						<div class="wpvc_tog menudiv">
							<a href="javascript:" class="togglehide"><span class="wpvc_vote_icons votecontestant-menu-down"></span></a>
						</div>
						<ul class="wpvc_vote_menu_links">
							<li class="wpvc_vote_navmenu_link">
								<a href="<?php echo ($main_navigation!='')?$main_navigation:$permalink;?>">
									<span class="wpvc_vote_icons voteconestant-camera"></span><?php _e('Gallery','voting-contest'); ?>
								</a>
							</li>


							<?php
							if($category_options['vote_contest_rules']!=''){ ?>
								<li class="wpvc_vote_navmenu_link wpvc_vote_no_border">
								<a href="<?php echo $permalink.$url_prefix.'contest=contestrules&amp;contest_id='.base64_encode($term_id); ?>">
								<span class="wpvc_vote_icons voteconestant-gift"></span><?php _e('Rules and Prizes','voting-contest'); ?>
								</a>
								</li>
							<?php } ?>

							<li class="wpvc_vote_float_right wpvc_vote_no_border">
								<span class="category_head"><?php _e("Category : ","voting-contest"); ?></span>
								<span class="single-category_head"><a href="<?php echo $main_navigation; ?>"><?php echo $cat_name; ?></a></span>
							</li>

						</ul>

					</div>

					<?php $image_contest = $category_options['imgcontest']; ?>

					<div class="wpvc_vote_content_container">

						<?php
							//Check Contestant is Ended and Hide the Vote Button
							$votes_start_time=get_option($term_id . '_' . WPVC_VOTES_TAXSTARTTIME);
							$votes_end_time  = get_option($term_id. '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
							$current_time = current_time( 'timestamp', 0 );

							//StartTime Limit
							if($votes_start_time !='' && strtotime($votes_start_time) > $current_time){
							echo "<input type='hidden' id='wpvc_contest_closed_".$term_id."' value='start' />";
							$closed_desc = $global_options['vote_tobestarteddesc'];
							echo "<input type='hidden' class='wpvc_contest_closed_desc' value='".$closed_desc."' />";
							}

							$exipration = $term_id. '_' . WPVC_VOTES_TAXEXPIRATIONFIELD;
							$dateexpiry =  get_option($exipration);
							$cur_time = current_time( 'timestamp', 0 );
							if($dateexpiry==''){
								$dateexpiry = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
							}
						if(strtotime($dateexpiry) >= $cur_time){
						?>
						<div class="wpvc_vote_btn_container">
							<div class="wpvc_voting_left">
								<?php echo WPVC_Vote_Single_Contestants::wpvc_vote_previous_post_link('%link', '%title',true,$termids); ?>
							</div>

							<div class="wpvc_voting_button_now">

							    <?php

                                if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
                                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                                 } else {
                                 $ip = $_SERVER['REMOTE_ADDR'];
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
								    $is_votable = WPVC_Vote_Save_Controller::wpvc_check_contestant_is_votable(get_the_ID(), $ip, $term_id);

								    if(!$is_votable){
									    if($vote_votingtype != null && $frequency == 11){
										    $grey_class = (WPVC_Vote_Save_Controller::wpvc_is_current_user_voted(get_the_ID(), $ip, $term_id))?'':'wpvc_voting_grey_button';
									    }
									    else
										    $grey_class = '';
									    ?>
									    <div class="wpvc_votes_btn_single<?php echo $post_id; ?>">

                                        <?php apply_filters('wpvc_votes_btn_before',$term_id,get_the_ID());  ?>

									    <a class="wpvc_votebutton <?php echo $grey_class .' '.$wpvc_login_class; ?> voter_a_btn_term<?php echo $term_id; ?> <?php echo apply_filters('wpvc_votes_btn_class',$term_id); ?>"
									    data-vote-count="<?php echo $category_options['vote_count_per_contest'];?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $term_id; ?>" data-vote-id="<?php echo get_the_ID(); ?>">
									    <span class="wpvc_vote_icons votecontestant-check" aria-hidden="true"></span>
                                            <span class="wpvc_vote_button_content votr_btn_cont<?php echo get_the_ID();?>">
                                                <?php echo apply_filters('wpvc_votes_btn',__('Voted','voting-contest'),$term_id) ;?>
                                            </span>
									    </a>
									    </div>
									    <?php
								    }else{
									    ?>


									    <div class="wpvc_votes_btn_single<?php echo $post_id; ?>">

                                        <a class="wpvc_votebutton <?php echo $wpvc_login_class; ?> voter_a_btn_term<?php echo $term_id; ?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $term_id; ?>"
                                        data-vote-count="<?php echo $category_options['vote_count_per_contest'];?>"	data-vote-id="<?php echo get_the_ID(); ?>">
                                            <span class="wpvc_vote_icons votecontestant-check" aria-hidden="true"></span>
                                            <span class="wpvc_vote_button_content votr_btn_cont<?php echo get_the_ID();?>"><?php _e('Vote Now','voting-contest'); ?></span>
                                        </a>

									    </div>
									    <?php
								    }

							    }
							    ?>

							</div>

							<div class="wpvc_voting_right">
								<?php echo WPVC_Vote_Single_Contestants::wpvc_votes_next_post_link('%link', '%title',true,$termids); ?>
							</div>
						</div>
						<?php } ?>

						<?php
						//Check the title in the Form Contestant Builder
						$title_rs = WPVC_Vote_Shortcode_Model::wpvc_voting_get_contestant_title();


						if($single_title_position == 'on') {
							if($title_rs[0]->admin_view == "Y"){
								?>

								<h2 class="wpvc_vote_single-title">
									<?php the_title(); ?>
								</h2>
								<?php
							}

						}

						wpvc_votes_the_post_thumbnail($post_id,$termids,$category_options,$global_options,$title_rs[0]->pretty_view);
						?>

						<?php
						$custom_fields = WPVC_Contestant_Model::wpvc_voting_get_all_custom_fields();
						$custom_entries = WPVC_Contestant_Model::wpvc_voting_get_all_custom_entries($post_id);
						?>

						<div class="wpvc_single_page_content <?php echo $image_contest; ?>">
							<?php
                                if($single_title_position == 'off' || $single_title_position == null) {
                                    if($title_rs[0]->admin_view == "Y"){
                                        ?>

                                        <h2 class="wpvc_vote_single-title">
                                            <?php the_title(); ?>
                                        </h2>
                                        <?php
                                    }

                                }
								the_content();
							?>
						</div>


					</div>

                    <?php apply_filters('wpvc_vote_single_shortcode_bottom',$enc_termid); ?>

					<!-- Vote Counter and Share option  -->
					<div class="wpvc_votes_social_container">
						<?php
							$totvotesarr = get_post_meta(get_the_ID(), WPVC_VOTES_CUSTOMFIELD);
							$totvotes = isset($totvotesarr[0]) ? $totvotesarr[0] : 0;
							if($totvotes == NULL) $totvotes = 0;
							?>
							<div class="wpvc_votes_counter_content votes_count_single<?php echo $post_id; ?>">
								<span aria-hidden="true" class="wpvc_vote_icons votecontestant-check"></span>
								<p class="votes_single_counter votes_count_single_count<?php echo $post_id; ?>"><?php echo $totvotes; ?></p>
							</div>

							<div class="wpvc_votes_view_content">
								<span aria-hidden="true" class="wpvc_vote_icons votecontestant-eye-open"></span>
								<?php echo $votes_view; ?>
							</div>

							<div class="wpvc_vote_share_shrink wpvc_vote_float_right">
								<a class="wpvc_share_click_expand"><span>Share</span></a>
							</div>
					</div>


					<?php echo WPVC_Vote_Ajax_Controller::wpvc_social_share_icons($post_id,$termids,$category_options,$option); ?>

					<?php
					if ( is_user_logged_in() && isset($_GET['con'])) {
					    $author_id = base64_decode($_GET['con']);
					    $user_ID = get_current_user_id();
					    if ( $author_id == $user_ID ) { ?>
						<div class="single_page_payments"> <?php
						echo $output = apply_filters('wpvc_payment_single_page',$post_id,$term_id);
						?>
						</div>
						<?php
					    }
					}
					if (!is_user_logged_in() && isset($_GET['con'])) {
					    ?>
					    <script type="text/javascript">
						    jQuery(document).ready(function(){
							wpvc_vote_ppOpen('#wpvc_vote_login_panel', '300',1);
							//Tab in the Login Popup
							jQuery('.wpvc_tabs_login_content').show();
							jQuery('.wpvc_tabs_register_content').hide();
							jQuery( '.wpvc_tabs_login' ).addClass('active');
						    });
					    </script>
					    <?php
					}
					?>

					<div class="wpvc_vote_content_comment"><?php comments_template(); ?></div>
				</div>

			<?php
			if($vote_sidebar!='on'){
				if($vote_select_sidebar!=''){

					if($vote_select_sidebar=='Contestants_sidebar'){
						echo '<div class="wpvc_votes_sidebar">';
						   dynamic_sidebar('contestants_sidebar');
						echo '</div>';
					}else{
						echo '<div class="wpvc_votes_sidebar">';
						get_sidebar($vote_select_sidebar);
						echo '</div>';
					}
				}
			}
			?>
			</div>

		</section>
		<div class="wpvc_single_footer_div">
		<?php
		get_footer();
		?>
		</div>
		<?php
		exit;
	}
}else{
    die("<h2>".__('Failed to load Voting Single Contestant view','voting-contest')."</h2>");
}

if(!function_exists('wpvc_sharing_contestant_function')){
	function wpvc_sharing_contestant_function(){
		global $wpdb,$post;
		$post_id = $post->ID;
		//for sharing
		$permalink1 = get_permalink( get_the_ID());
		$image_path = WPVC_Vote_Common_Controller::wpvc_vote_get_contestant_image($post_id,'large');
		$wpvc_image_src = $image_path['wpvc_image_src'];
		$content_desc = strip_tags($post->post_content);

		$custom_entries = WPVC_Contestant_Model::wpvc_voting_get_all_custom_entries(get_the_ID());
		if(!empty($custom_entries)){
			$field_values = $custom_entries[0]->field_values;
			if(base64_decode($field_values, true))
				$field_val = maybe_unserialize(base64_decode($field_values));
			else
				$field_val = maybe_unserialize($field_values);

		}
		$term_list = wp_get_post_terms(get_the_ID(), WPVC_VOTES_TAXONOMY, array("fields" => "ids"));
        $term_id = $term_list[0];
        $category_options = get_option($term_id.'_'.WPVC_VOTES_SETTINGS);
		$contest_type = $category_options['imgcontest'];

		?>
			<!-- for Google -->
			<meta name="description" content="<?php echo $content_desc; ?>" />
			<meta name="keywords" content="" />

			<meta name="author" content="" />
			<meta name="copyright" content="" />
			<meta name="application-name" content="" />

			<!-- for Facebook -->
            <meta property="fb:app_id" content="966242223397117" />
			<meta property="og:title" content="<?php echo htmlentities(get_the_title(),ENT_QUOTES); ?>" />
			<meta property="og:type" content="article" />
			<meta property="og:url" content="<?php echo $permalink1;?>" />

            <meta property="og:image" content="<?php echo $wpvc_image_src; ?>" />

			<meta property="og:description" content='<?php echo $content_desc; ?>' />
			<meta name="og:author" content="Voting"/>

			<!-- for Twitter -->
			<meta name="twitter:card" content="summary" />
			<meta name="twitter:title" content="<?php echo htmlentities(get_the_title(),ENT_QUOTES); ?>" />
			<meta name="twitter:description" content="<?php echo $content_desc; ?>" />
			<meta name="twitter:image" content="<?php echo $wpvc_image_src; ?>" />
		<?php
	}
}
else{
    die("<h2>".__('Failed to load Voting Single Contestant Share view','voting-contest')."</h2>");
}


if(!function_exists('wpvc_votes_the_post_thumbnail')){
	function wpvc_votes_the_post_thumbnail($post_id,$termids,$category_options,$global_options,$title_option = null){

		$cat_id = $termids[0];

		$votes_start_time=get_option($cat_id . '_' . WPVC_VOTES_TAXSTARTTIME);

		$enc_termid = WPVC_Vote_Common_Controller::wpvc_voting_encrypt($cat_id);
		$enc_postid = WPVC_Vote_Common_Controller::wpvc_voting_encrypt(get_the_ID());

		$current_time = current_time( 'timestamp', 0 );

		if(is_array($category_options)){
			$image_contest = $category_options['imgcontest'];
		}
		else{
			$image_contest = '';
		}

		if($image_contest=='photo'){

			//$adv_excerpt = WPVC_Vote_Excerpt_Controller::Instance();
			//$shor_desc = $adv_excerpt->filter(get_the_excerpt());

			$get_content = get_post($post_id);
			$shor_desc= $get_content->post_content;
			$shwpvc_desc_pretty = WPVC_Vote_Shortcode_Model::wpvc_vote_shwpvc_desc_prettyphoto();
			$pretty_excerpt = ($shwpvc_desc_pretty == 1)?strip_tags($shor_desc):'';

			$wpvc_image_alt_text=WPVC_Vote_Common_Controller::wpvc_vote_seo_friendly_alternative_text(get_the_title());
			$image_path = WPVC_Vote_Common_Controller::wpvc_vote_get_contestant_image($post_id,'large');
			$wpvc_image_src = $image_path['wpvc_image_src'];
			$wpvc_original_img = $image_path['wpvc_original_img'];


			//PrettyPhoto Disable in Single Contestant Page
			if(isset($global_options['vote_prettyphoto_disable_single'])){
				$vote_prettyphoto_disable_single = $global_options['vote_prettyphoto_disable_single'];
			}
			else{
				$vote_prettyphoto_disable_single = "";
			}

			?>
			<div class="wpvc_vote_cont_img" data-id="<?php echo $cat_id; ?>">

			<?php $vote_single_img_width_value = $global_options['single_page_cont_image_px'];
				if($vote_single_img_width_value == 'on') {
					$vote_single_img_width_value = 'px';
				}
				$vote_single_img_width = $global_options['single_page_cont_image'];
				   $num = $vote_single_img_width;
				   $int = (int)$num;
				if($int == null){
					$int = 100;
				}
			?>

			<?php if($vote_prettyphoto_disable_single == null || $vote_prettyphoto_disable_single == 'off'): ?>
			<a class="single_contestant_pretty wpvc_hover_image" data-pretty-title="<?php echo $pretty_excerpt; ?>" href="<?php echo $wpvc_original_img; ?>" data-vote-id="<?php echo get_the_ID(); ?>">
			<div class="wpvc_overlay_bg wpvc_overlay_<?php echo get_the_ID(); ?>">
			    <span><i class="wpvc_vote_icons voteconestant-zoom"></i></span>
			</div>
				<img style="width: <?php echo $int.$vote_single_img_width_value; ?>" class="wpvc_image_responsive" id="wpvc_image_responsive<?php echo get_the_ID(); ?>" src="<?php echo $wpvc_image_src; ?>" title="<?php echo $wpvc_image_alt_text; ?>" alt="<?php echo $wpvc_image_alt_text; ?>" data-pretty-alt="<?php echo ($title_option == 'Y')?$wpvc_image_alt_text:''; ?>" data-vote-id="<?php echo get_the_ID(); ?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $cat_id; ?>"/>
			</a>
			<?php else: ?>
				<img style="width: <?php echo $int.$vote_single_img_width_value; ?>" class="wpvc_image_responsive" id="wpvc_image_responsive<?php echo get_the_ID(); ?>" src="<?php echo $wpvc_image_src; ?>" title="<?php echo $wpvc_image_alt_text; ?>" alt="<?php echo $wpvc_image_alt_text; ?>" data-pretty-alt="<?php echo ($title_option == 'Y')?$wpvc_image_alt_text:''; ?>" data-vote-id="<?php echo get_the_ID(); ?>" data-enc-id="<?php echo $enc_termid; ?>" data-enc-pid="<?php echo $enc_postid; ?>" data-term-id="<?php echo $cat_id; ?>"/>
			<?php endif; ?>
			</div>
		<?php
		}
	}
}else{
    die("<h2>".__('Failed to load Voting Single Contestant Thumbnail view','voting-contest')."</h2>");
}



?>
