<?php
if(!function_exists('wpvc_voting_license_view')){
    function wpvc_voting_license_view($license,$status){
	?>
		<div class="wrap">
			<h2><?php _e('Plugin License Options','voting-contest'); ?></h2>
			<form method="post" action="options.php">
		
				<?php settings_fields('wpvc_voting_software_license'); ?>
				
				<?php
                if(isset($_REQUEST['license'])){
					if($_REQUEST['license'] == 'invalid')
						echo '<div id="message" class="error"><p>Invalid License key</p></div>';
                
					if($_REQUEST['license'] == 'valid')
						echo '<div id="message" class="updated notice notice-success is-dismissible"><p>License key validated</p></div>';
                }
				?>
		
				<table class="form-table">
					<tbody>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('License Key','voting-contest'); ?>
							</th>
							<td>
								<input id="wp_voting_software_license_key" name="wp_voting_software_license_key" type="text" class="regular-text" value="<?php esc_attr_e($license); ?>" />
								<label class="description" for="wp_voting_software_license_key"><?php _e('Enter your license key','voting-contest'); ?></label>
							</td>
						</tr>
						
							<tr valign="top">	
								<th scope="row" valign="top">
									<?php _e('Activate License','voting-contest'); ?>
								</th>
								<td>
									<?php if ($status !== false && $status == 'valid') { ?>
										<span style="color:green;"><?php _e('active','voting-contest'); ?></span>
									<?php
									} else {
										wp_nonce_field('wpvc_voting_software_nonce', 'wpvc_voting_software_nonce');
										?>
										<input type="submit" class="button-secondary" name="wpvc_voting_license_activate" value="<?php _e('Activate License','voting-contest'); ?>"/>
									<?php } ?>
								</td>
							</tr>
						
					</tbody>
				</table>	
				<?php submit_button(__('Save Changes','voting-contest'),'primary', 'ow_save_lisence'); ?>
			</form>
		
			
		</div>
<?php
	}
}else{
    die("<h2>".__('Failed to load Voting License view','voting-contest')."</h2>");
}
?>