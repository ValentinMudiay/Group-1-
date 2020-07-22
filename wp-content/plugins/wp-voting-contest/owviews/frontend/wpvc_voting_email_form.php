<?php
if(!function_exists('wpvc_voting_email_form')){
    function wpvc_voting_email_form($votes_settings){	    
		wp_localize_script( 'wpvc_votes_shortcode', 'vote_path_local', array( 'votesajaxurl' => admin_url( 'admin-ajax.php' ),'vote_image_url'=>WPVC_ASSETS_IMAGE_PATH  ) );	
		if (is_ssl())
			$current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		else
			$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		?>		
		<div id="wpvc_vote_email_panel">
			<div class="inner-container login-panel">
			    <div class="wpvc_voting_verification">
				<?php if($votes_settings['onlyloggedinuser'] == 'on'): ?>
				    <h3 class="m_title"><?php _e("CLICK SEND TO RECIEVE ACTIVATION CODE TO YOUR EMAIL ADDRESS",'voting-contest');?></h3>
				    <?php $disabled = "readonly";$current_user = wp_get_current_user();	$email = $current_user->user_email; ?>
				<?php else: ?>
				    <h3 class="m_title m_title_email"><?php _e("ENTER EMAIL TO RECEIVE VOTING CODE",'voting-contest');?></h3>
				    <?php $disabled = $email  = ""; ?>
				<?php endif; ?>
				
				<form id="login_form" name="login_form" method="post" class="zn_email_verification" action="<?php echo site_url('wp-login.php', 'login_post') ?>">			
					<div>
					    <input type="text" name="wpvc_voting_email" class="inputbox wpvc_voting_email" value="<?php echo $email; ?>" placeholder="<?php _e("Email",'voting-contest');?>" <?php echo $disabled; ?>>
					</div>
					
					<?php do_action('wpvc_voting_email_form');?>			
										
					<div class="wpvc_email_button">
						<input type="submit" name="submit_button" class="zn_sub_button wpvc_grab_email_send" value="<?php _e("SEND",'voting-contest');?>">
					</div>
					
					<input type="hidden" value="login" class="" name="zn_form_action">
					<input type="hidden" value="voting_email_verification" class="" name="action">
					<input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect" name="submit">
					
				</form>				
								
				<div class="clear"></div>
			    </div>
				<div class="wpvc_voting_verification_code_div">
				    <h3 class="m_title m_title_code"><?php _e("ENTER EMAILED VOTING CODE",'voting-contest');?></h3>
				    <form id="login_form" name="login_form" method="post" class="zn_email_verification_code" action="<?php echo site_url('wp-login.php', 'login_post') ?>">			
					    <div>
						    <input type="text" maxlength=6 name="wpvc_voting_verifcation_code" class="inputbox wpvc_voting_verifcation_code" placeholder="<?php _e("Email Verification Code",'voting-contest');?>">
					    </div>
					    
					    <?php do_action('wpvc_voting_verification_code');?>			
										    
					    <div class="wpvc_email_button">
						    <input type="submit" name="submit_button" class="zn_sub_button" value="<?php _e("SUBMIT",'voting-contest');?>">
					    </div>
					    
					    <input type="hidden" value="login" class="" name="zn_form_action">
					    <input type="hidden" value="voting_email_verification" class="" name="action">
					    <input type="hidden" value="<?php echo $current_url; ?>" class="zn_login_redirect" name="submit">
					    
				    </form>
				    
				    <div class="clear"></div>				
				</div>
				
			</div>
		</div>
		<?php
    }
}else{
    die("<h2>".__('Failed to load Voting Email Login View','voting-contest')."</h2>");
}
?>
