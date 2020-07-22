<?php
if(!function_exists('wpvc_voting_user_login_view')){
    function wpvc_voting_user_login_view($votes_settings,$custom_field){
		wp_localize_script( 'wpvc_votes_shortcode', 'vote_path_local', array( 'votesajaxurl' => admin_url( 'admin-ajax.php' ),'vote_image_url'=>WPVC_ASSETS_IMAGE_PATH  ) );	
		if (is_ssl())
			$current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		else
			$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		?>		
		<div id="wpvc_vote_login_panel">
			<div class="inner-container login-panel">
			    
				<div class="wpvc_tabs">
					<div class="wpvc_tab_buttons">
						<a href="javascript:void(0)" class="wpvc_tabs_login"><?php _e("LOGIN",'voting-contest'); ?></a>
				     <?php
				     if(@!$votes_settings['vote_hide_account'] == 'on'){
				     if( get_option('users_can_register') ) { ?>
					    <a href="javascript:void(0)" class="wpvc_tabs_register"><?php _e("CREATE ACCOUNT",'voting-contest'); ?></a>					  <?php } }?>
					</div>	    
					
					<div class="clearfix"></div>
					
				    <div class="wpvc_tabs_content">
					<div class="wpvc_tabs_login_content">
					    <h3 class="m_title"><?php _e("YOU MUST BE REGISTERED AND LOGGED TO CONTINUE",'voting-contest');?></h3>
				
					    <form id="login_form" name="login_form" method="post" class="zn_form_login" action="<?php echo site_url('wp-login.php', 'login_post') ?>">
					    
						   
						    <div>
							    <input type="text" name="log" class="inputbox" placeholder="<?php _e("Username",'voting-contest');?>">
						    </div>
						    <div>
							    <input type="password" name="pwd" class="inputbox" placeholder="<?php _e("Password",'voting-contest');?>">
						    </div>
						    <?php do_action('login_form');?>
						    <div class="remember_style">
							    <label class="zn_remember"><input type="checkbox" name="rememberme" value="forever"><?php _e(" Remember Me",'voting-contest');?></label>
						    </div>
						    
						    <div>
							    <input type="submit" name="submit_button" class="zn_sub_button" value="<?php _e("LOG IN",'voting-contest');?>">
						    </div>
						    
						    <input type="hidden" value="login" class="" name="zn_form_action">
						    <input type="hidden" value="wpvc_vote_pretty_login" class="" name="action">
						    <input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect" name="submit">
						    <div class="links"><a href="javascript:void(0)" onClick="wpvc_vote_ppOpen('#wpvc_vote_forgot_panel', '300');"><?php _e("FORGOT YOUR PASSWORD?",'voting-contest');?></a></div>
					    </form>
					    					    
					    <div class="clear"></div>					    
					</div>
					<div class="wpvc_tabs_register_content">
					    <?php echo wpvc_voting_user_registration_view($votes_settings,$custom_field); ?>					    
					</div>
				    </div>
				</div>
			    
				
				
			</div>
		</div>
		<?php
    }
}else{
    die("<h2>".__('Failed to load Voting User Login View','voting-contest')."</h2>");
}

if(!function_exists('wpvc_voting_user_registration_view')){
    function wpvc_voting_user_registration_view($votes_settings,$custom_field){
		wp_localize_script( 'wpvc_votes_shortcode', 'vote_path_local', array( 'votesajaxurl' => admin_url( 'admin-ajax.php' ),'vote_image_url'=>WPVC_ASSETS_IMAGE_PATH  ) );
		if (is_ssl())
			$current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		else
			$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		if( get_option('users_can_register') ) {
			?>
		<div id="wpvc_vote_register_panel">
			
			<div class="inner-container register-panel">
				<h3 class="m_title"><?php _e("CREATE ACCOUNT",'voting-contest');?></h3>
				
				<form id="register_form" name="login_form" method="post" class="zn_form_login" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>">
					<div class="register-panel_inner">
						<label>
							<strong>
							<?php _e('Username','voting-contest'); ?></strong>
							<span class="required-mark">*</span>
						</label>
						<p>
							<input type="text" id="reg-username" name="user_login" class="inputbox required_vote_custom" placeholder="<?php _e("Username",'voting-contest');?>" />
						</p>
					</div>
                            
                    <div class="register-panel_inner">
						<label>
							<strong><?php _e('Email Address','voting-contest'); ?></strong>
							<span class="required-mark">*</span>
						</label>
						<p>
							<input type="text" id="reg-email" name="user_email" class="inputbox required_vote_custom" placeholder="<?php _e("Your email",'voting-contest');?>" />
						</p>
                    </div>
                            
                    <div class="register-panel_inner">
                        <label>
							<strong><?php _e('Password','voting-contest'); ?></strong>
							<span class="required-mark">*</span>
						</label>
						<p>
							<input type="password" id="reg-pass" name="user_password" class="inputbox required_vote_custom" placeholder="<?php _e("Your password",'voting-contest');?>" />
						</p>
                    </div>
                            
                    <div class="register-panel_inner">
						<label>
							<strong><?php _e('Confirm Password','voting-contest'); ?></strong>
							<span class="required-mark">*</span>
						</label>
						<p>
							<input type="password" id="reg-pass2" name="user_password2" class="inputbox required_vote_custom" placeholder="<?php _e("Verify password",'voting-contest');?>" />
						</p>
                    </div>
					
										
					<div class="owt_other_register_fields">
					    <?php do_action( 'register_form' ); ?>
					</div>
					<?php
					?>
					<div class="wpvc_register_submit">
					<input type="submit" id="signup" name="submit" class="zn_sub_button" value="<?php _e("CREATE MY ACCOUNT",'voting-contest');?>"/>
					</div>
					<input type="hidden" value="register" class="" name="zn_form_action">
					<input type="hidden" value="wpvc_vote_pretty_login" class="" name="action">					
					<input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect" name="submit">
					<div class="links"><a class="wpvc_tabs_already" href="javascript:void(0)"><?php _e("ALREADY HAVE AN ACCOUNT?",'voting-contest');?></a></div>
				</form>
			</div>
		</div>
		<?php } ?>
		
		<?php
    }
}else{
    die("<h2>".__('Failed to load Voting User Registration View','voting-contest')."</h2>");
}

if(!function_exists('wpvc_voting_user_forget_view')){
    function wpvc_voting_user_forget_view(){
		?>
		<div id="wpvc_vote_forgot_panel">
    			<div class="inner-container forgot-panel">
    				<h3 class="m_title"><?php _e("FORGOT YOUR DETAILS?",'voting-contest');?></h3>
    				<form id="forgot_form" name="login_form" method="post" class="zn_form_lost_pass" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>">
    					<p>
						<input type="text" id="forgot-email" name="user_login" class="inputbox" placeholder="<?php _e("Username or E-mail",'voting-contest');?>"/>
    					</p>
                                               
    					<p>
    						<input type="submit" id="recover" name="submit" class="zn_sub_button" value="<?php _e("SEND MY DETAILS!",'voting-contest');?>">
    					</p>
    					<div class="links"><a href="javascript:void(0)" onClick="wpvc_vote_ppOpen('#wpvc_vote_login_panel', '300');"><?php _e("AAH, WAIT, I REMEMBER NOW!",'voting-contest');?></a></div>
    				</form>
    				
    			</div>
		</div>
		<?php
	}
}else{
    die("<h2>".__('Failed to load Voting User Forget View','voting-contest')."</h2>");
}
?>
