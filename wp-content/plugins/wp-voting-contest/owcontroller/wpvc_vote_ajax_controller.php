<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Ajax_Controller')){
    class WPVC_Vote_Ajax_Controller{
	
		public function __construct(){
			//Ajax 			
			add_action('wp_ajax_wpvc_vote_update_sequence', array($this,'wpvc_votes_contestant_update_seq_custom_field'));
			add_action('wp_ajax_wpvc_vote_user_update_sequence', array($this,'wpvc_votes_user_update_seq_custom_field'));
			
			add_action("wp_ajax_nopriv_wpvc_vote_pretty_login", array($this,'wpvc_votes_user_login'));
			add_action("wp_ajax_wpvc_vote_pretty_login", array($this,'wpvc_votes_user_login'));
				
						
			add_action( 'wp_ajax_wpvc_render_accordion',array($this,'wpvc_render_accordion_ajax')  );
			add_action( 'wp_ajax_nopriv_wpvc_render_accordion', array($this,'wpvc_render_accordion_ajax') );			
					
			
			add_action( 'wp_ajax_owtotalvotes',array($this,'wpvc_voting_total_votes')  );
			add_action( 'wp_ajax_nopriv_owtotalvotes', array($this,'wpvc_voting_total_votes') );			
			
			add_action('wp_ajax_wpvc_social_share_icons', array($this,'wpvc_social_share_icons_ajax'));
			add_action('wp_ajax_nopriv_wpvc_social_share_icons', array($this,'wpvc_social_share_icons_ajax'));
		
			
		}
		
	
		public function wpvc_votes_user_update_seq_custom_field()
		{
			$rows = explode(",", $_POST['rwpvc_ids']);
			for ($i = 0; $i < count($rows); $i++) {
				WPVC_Custom_Field_Model::wpvc_custom_field_user_update_sequence($i,$rows[$i]);
			}
			die();
		}
		
		public function wpvc_votes_contestant_update_seq_custom_field()
		{
			$rows = explode(",", $_POST['rwpvc_ids']);
			for ($i = 1; $i < count($rows); $i++) {
				WPVC_Custom_Field_Model::wpvc_custom_field_update_sequence($i,$rows[$i]);
			}
			die();
		}
		
		
		
		public function wpvc_votes_user_login(){
			if($_SERVER[ 'HTTP_X_REQUESTED_WITH' ]=='XMLHttpRequest'){
				if ( $_POST['zn_form_action'] == 'login' ) {
					$user = wp_signon();
					if ( is_wp_error($user) ) {
					   echo '1'.'~~'.'<div class="login_error">'.$user->get_error_message().'</div>';
					   die();
					}
					else{
						echo '0'.'~~'.'success';
						die();
					}
				}
				elseif( $_POST['zn_form_action'] == 'register' ){
					$zn_error = false;
					$zn_error_message = array();
					
					if ( !empty( $_POST['user_login'] ) ) {
						if ( username_exists( $_POST['user_login'] ) ){	
							$zn_error = true;
							$zn_error_message[] = __('The username already exists','voting-contest');
						}
						else {
							$username = $_POST['user_login'];
						}
					}
					else {
						$zn_error = true;
						$zn_error_message[] = __('Please enter an username','voting-contest');
					}
		
					if ( !empty( $_POST['user_password'] ) ) {
						$password = $_POST['user_password'];
					}
					else {
						$zn_error = true;
						$zn_error_message[] = __('Please enter a password','voting-contest');
					}
		
					if ( ( empty( $_POST['user_password'] ) && empty( $_POST['user_password2'] ) ) || $_POST['user_password'] != $_POST['user_password2'] ) {
						$zn_error = true;
						$zn_error_message[] = __('Passwords do not match','voting-contest');
					}
					
					if ( !empty( $_POST['user_email'] ) ) {
						if( !email_exists( $_POST['user_email'] )) {
							if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
								$zn_error = true;
								$zn_error_message[] = __('Please enter a valid EMAIL address','voting-contest');
							}
							else{
								$email = $_POST['user_email'];
							}
						}
						else {
							$zn_error = true;
							$zn_error_message[] = __('This email address has already been used','voting-contest');
						}
					}
					else {
						$zn_error = true;
						$zn_error_message[] = __('Please enter an email address','voting-contest');
					}
					
					
					if ( $zn_error ){
						echo '1'.'~~'.'<div class="login_error">';
						foreach ( $zn_error_message as $error) {
							echo $error.'<br />';
						}
						echo '</div>';
						die();
					}
					else {
						
						$user_data = array(
							'ID' => '',
							'user_pass' => $password,
							'user_login' => $username,
							'display_name' => $username,
							'user_email' => $email,
							'role' => get_option('default_role') // Use default role or another role, e.g. 'editor'
							);
						
						
						
						$user_id = wp_insert_user( $user_data );
						
						do_action('owt_register_form_hook',$user_id);
						
						wp_new_user_notification($user_id);
            if (!is_user_logged_in()) {
              //determine WordPress user account to impersonate
              $user_login = 'guest';
    
               //get user's ID
              //$user = get_user_by($user_login);
    
              // Set the global user object
              $user = get_user_by( 'id', $user_id );
              $user_data = get_userdata ($user_id);
    
              //login
              wp_set_current_user($user_id, $user_login);
              //wp_set_auth_cookie($user_id);
    
              $secure_cookie = is_ssl() ? true : false;
              wp_set_auth_cookie( $user_id, true, $secure_cookie );
    
              do_action('wp_login', $user_login,$user_data);
            }
						echo '0'.'~~'.'<div class="login_error">'.__('Your account has been created.','voting-contest').'</div>';
						die();
					}
				}
				elseif( $_POST['zn_form_action'] == 'reset_pass' ){
					echo do_action('login_form', 'resetpass');
				}
			}else{
				wp_redirect( home_url() );
				die();	
			}
		}
				
		public function wpvc_render_accordion_ajax(){			
			if(isset($_POST['color'])){
			    $coloroption = get_option(WPVC_VOTES_COLORSETTINGS);			    
			    $option = $coloroption[$_POST['color']];			    
			}
			require_once(WPVC_VIEW_PATH.'wpvc_common_settings_view.php');
			echo wpvc_render_accordion($option);
			exit;
		}
		
				
		public function wpvc_sanitize_output($buffer) {

			$search = array(
			    '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
			    '/[^\S ]+\</s',  // strip whitespaces before tags, except space
			    '/(\s)+/s'       // shorten multiple whitespace sequences
			);
		    
			$replace = array(
			    '>',
			    '<',
			    '\\1'
			);
		    
			$buffer = preg_replace($search, $replace, $buffer);			
			return $buffer;
		}
		
				
		public function wpvc_votes_update_contestant_field($post_id,$system_name,$value){
			
			$custom_entries = WPVC_Contestant_Model::wpvc_voting_get_all_custom_entries($post_id);
			if(!empty($custom_entries)){ 
				$field_values = $custom_entries[0]->field_values;
				if(base64_decode($field_values, true))
					$field_val = maybe_unserialize(base64_decode($field_values));  
				else
					$field_val = maybe_unserialize($field_values);
					
				foreach($field_val as $key => $fields)	{
					
					if($key == $system_name){
						$posted_val[$key] = $value;
					}else{
						$posted_val[$key] = $fields;
					}					
					
				}
				
				$val_serialized = base64_encode(maybe_serialize($posted_val)); 
				WPVC_Contestant_Model::wpvc_voting_contestant_update_field($val_serialized,$post_id);
			
			}
						
			//Update in the Post meta table
			update_post_meta($post_id,$system_name,$value);
			
		}
		
		public static function wpvc_voting_total_votes(){			
			$total_votes = WPVC_Contestant_Model::wpvc_total_votes();
			echo "<span class='wpvc_total_counter'>".$total_votes."</span>";
			exit;
		}
		
		public function wpvc_social_share_icons_ajax(){
			$post_id = $_POST['post_id'];
			$option = get_option(WPVC_VOTES_SETTINGS);
			echo $this->wpvc_social_share_icons($post_id,'','',$option,1);
			exit;
		}
		public static function wpvc_social_share_icons($post_id,$termids = null,$category_options= null,$option,$ajax_flag = null){
			ob_start();
			$permalink = get_permalink($post_id);
			$up_path =  wp_upload_dir();
			
			$facebook = $option['facebook'] ? $option['facebook'] : 'off';
			$twitter = $option['twitter'] ? $option['twitter'] : 'off';
			$pinterest = $option['pinterest'] ? $option['pinterest'] : 'off';
			$tumblr = $option['tumblr'] ? $option['tumblr'] : 'off';
			
			$file_facebook = @$option['file_facebook'] ?$option['file_facebook']:'';
			$file_twitter = @$option['file_twitter'] ?$option['file_twitter']:'';
			$file_pinterest = @$option['file_pinterest'] ?$option['file_pinterest']:'';			
			$file_tumblr = @$option['file_tumblr'] ?$option['file_tumblr']:'';
			
			
			$file_fb_default = $option['file_fb_default'] ?$option['file_fb_default']:'';
			$file_tw_default = $option['file_tw_default'] ?$option['file_tw_default']:'';
			$file_pinterest_default = $option['file_pinterest_default'] ?$option['file_pinterest_default']:'';			
			$file_tumblr_default = $option['file_tumblr_default'] ?$option['file_tumblr_default']:'';
			
			$image_path = WPVC_Vote_Common_Controller::wpvc_vote_get_contestant_image($post_id,'large');
			$wpvc_image_src = $image_path['wpvc_image_src'];
			$wpvc_original_img = $image_path['wpvc_original_img'];
			
			$hide_class = ($ajax_flag  != 1)?'wpvc_make_hide':'';
			?>
			<div class="wpvc_total_share_single <?php echo $hide_class; ?>">
				<div class="wpvc_face_social_icons wpvc_pretty_content_social<?php echo $post_id; ?>">
				<div class="wpvc_fancy_content_social wpvc_fancy_content_social<?php echo get_the_ID(); ?>">
				<?php
				if($facebook!='off') {
					if($file_fb_default=='' && $file_facebook!=''){
						if(file_exists($up_path['path'].'/'.$file_facebook))
							$face_img_path = $up_path['url'].'/'.$file_facebook;
						else
							$face_img_path = WPVC_ASSETS_IMAGE_PATH.'facebook-share.png';
					}else{
						$face_img_path = WPVC_ASSETS_IMAGE_PATH.'facebook-share.png';
					}?>
					<a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>&amp;t=<?php echo htmlentities(get_the_title(),ENT_QUOTES); ?>">
						<img alt="Facebook share" src="<?php echo $face_img_path;?>">
					</a>
				
				<?php
				}
				if($twitter!='off') { 
					if($file_tw_default=='' && $file_twitter!=''){
						if(file_exists($up_path['path'].'/'.$file_twitter))
							$twt_img_path = $up_path['url'].'/'.$file_twitter;
						else
						$twt_img_path = WPVC_ASSETS_IMAGE_PATH.'tweet.png';
					}else{
						$twt_img_path = WPVC_ASSETS_IMAGE_PATH.'tweet.png';
					}?>
					<a target="_blank" href="http://twitter.com/home?status=<?php echo htmlentities(get_the_title(),ENT_QUOTES).'%20'.$permalink; ?>">
						<img alt="Tweet share" src="<?php echo $twt_img_path;?>">
					</a>
				
				<?php
				}
				
				if($pinterest!='off') {
					if($file_pinterest_default=='' && $file_pinterest!=''){
						if(file_exists($up_path['path'].'/'.$file_pinterest))
							$pinterest_img_path = $up_path['url'].'/'.$file_pinterest;
						else
						$pinterest_img_path = WPVC_ASSETS_IMAGE_PATH.'pinterest.png';
					}else{
						$pinterest_img_path = WPVC_ASSETS_IMAGE_PATH.'pinterest.png';
					}
					?>
					<a target="_blank" href="http://www.pinterest.com/pin/create/button/?url=<?php echo htmlentities($permalink).'&amp;media='.htmlentities($wpvc_image_src).'&amp;description='.htmlentities(get_the_title(),ENT_QUOTES);?>">
						<img alt="Tweet share" src="<?php echo $pinterest_img_path;?>">
					</a>
					<?php
				}
				
				
				
				if($tumblr!='off') {
					if($file_tumblr_default=='' && $file_tumblr!=''){
						if(file_exists($up_path['path'].'/'.$file_tumblr))
							$tumb_img_path  = $up_path['url'].'/'.$file_tumblr;
						else
							$tumb_img_path    = WPVC_ASSETS_IMAGE_PATH.'tumblr.png';
					}else{
						$tumb_img_path   = WPVC_ASSETS_IMAGE_PATH.'tumblr.png';
					}
					?>
					<a target="_blank" href="http://www.tumblr.com/share/photo?source=<?php echo htmlentities($wpvc_image_src).'&amp;caption='.htmlentities(get_the_title(),ENT_QUOTES).'&amp;clickthru='.htmlentities($permalink); ?>" >
						<img alt="Tumblr share" src="<?php echo $tumb_img_path;?>">
					</a>
					<?php
				}
				?>
				</div>
				</div>
				
				<?php if($ajax_flag  != 1){ ?>
				<div class="share_text_box_single">
					<div class="copied_message"><span>Copied!</span></div>
					<div class="wpvc_vote_share_parent"><input type="text" id="wpvc_vote_share_url_copy" readonly name="share_url" class="wpvc_vote_share_url" value="<?php echo $permalink; ?>" /></div>
				</div>
				<?php } ?>
			</div>
			
			<?php
			$out = ob_get_contents();
			ob_end_clean();
			return $out;
		}
		
    }
}else
die("<h2>".__('Failed to load Voting Ajax Controller','voting-contest')."</h2>");


return new WPVC_Vote_Ajax_Controller();
