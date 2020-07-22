<?php
if(!class_exists('WPVC_Vote_Shortcode_Model')){
	class WPVC_Vote_Shortcode_Model {

	   public static function wpvc_get_shwpvc_contest_query($shwpvc_cont_args,$ajax = null){
			global $wpdb;
			$search_id = "";
			if(isset($_POST['filter_votes']))
				$search_filter=$_POST['filter_votes'];

			if(isset($_POST['category_id']))
				$search_id=$_POST['category_id'];

			if(isset($_SESSION['wpvc_vote_search_filter'.$shwpvc_cont_args['id']]))
				$session_filter = $_SESSION['wpvc_vote_search_filter'.$shwpvc_cont_args['id']];

			if(isset($search_filter)){
				if(!(isset($session_filter)) &&  $search_filter!='sort'){
					$_SESSION['wpvc_vote_search_filter'.$search_id] = $search_filter;
					$session_filter = $_SESSION['wpvc_vote_search_filter'.$search_id];
				}
			}

			if(isset($session_filter)){
				if(($session_filter!=$search_filter) && ($search_filter!='sort') && ($search_filter!='')){
					$_SESSION['wpvc_vote_search_filter'.$search_id] = $search_filter;
				}
			}

			if(((isset($session_filter)) && ($search_filter!='sort'))||$search_id!=$shwpvc_cont_args['id']){
				$search_filter = isset($_SESSION['wpvc_vote_search_filter'.$shwpvc_cont_args['id']])?$_SESSION['wpvc_vote_search_filter'.$shwpvc_cont_args['id']]:'';;
			}else{
				unset($_SESSION['wpvc_vote_search_filter'.$shwpvc_cont_args['id']]);
				unset($_SESSION['wpvc_vote_search_filter'.$search_id]);
			}

			//Unset the Session If Orderby is set and It is ajax
			if($shwpvc_cont_args['orderby'] != "" && !isset($_POST['filter_votes']) && $ajax == null){
			 unset($_SESSION['wpvc_vote_search_filter'.$shwpvc_cont_args['id']]);
			 unset($_SESSION['wpvc_vote_search_filter'.$search_id]);
			}

			if($shwpvc_cont_args['id']==0)
			return 'error';

			//If in case user tries to add multiple ids remove one id
			$ids = explode(',', $shwpvc_cont_args['id']);
			if (count($ids) > 1) {
				   return FALSE;
			}

			if ($shwpvc_cont_args['id'] != 0 && explode(',', $shwpvc_cont_args['id']))
				$shwpvc_cont_args['id'] = explode(',', $shwpvc_cont_args['id']);

			if (isset($shwpvc_cont_args['paged']) && $shwpvc_cont_args['paged'] > 0)
				$paged = $shwpvc_cont_args['paged'];
			else{
				if ( get_query_var('paged') ) {
					$paged = get_query_var('paged');
				} elseif ( get_query_var('page') ) {
					$paged = get_query_var('page');
				} else {
					$paged = 1;
				}
			}

			if(isset($shwpvc_cont_args['exclude']) && $shwpvc_cont_args['exclude'] != null):
				$excluded_ids = explode(',',$shwpvc_cont_args['exclude']);
			else:
				$excluded_ids = array();
			endif;

			if($ajax == null){
				$postargs = array(
					'post_type' => WPVC_VOTES_TYPE,
					'post_status' => 'publish',
					'posts_per_page' => $shwpvc_cont_args['postperpage'],
					'tax_query' => array(
						array(
								'taxonomy' => $shwpvc_cont_args['taxonomy'],
								'field' => 'id',
								'terms' => $shwpvc_cont_args['id'],
								'include_children' => false
							)
					),
					'paged' => $paged,
					'post__not_in' => $excluded_ids
				);
			}
			else{
				$postargs = array(
					'post_type' => WPVC_VOTES_TYPE,
					'post_status' => 'publish',
					'posts_per_page' => $shwpvc_cont_args['postperpage'],
					'offset' => $_POST['offset'],
					'tax_query' => array(
						array(
								'taxonomy' => $shwpvc_cont_args['taxonomy'],
								'field' => 'id',
								'terms' => $shwpvc_cont_args['id'],
								'include_children' => false
							)
					),
					//'paged' => $paged,
					'post__not_in' => $excluded_ids
				);
			}

			if($shwpvc_cont_args['order']=='on')
			{
				$shwpvc_args='asc';
			}
			else
			{
				$shwpvc_args='desc';
			}


			if($search_filter=='' || $search_filter=='sort'){
				if($shwpvc_cont_args['orderby'] == 'votes') {
					$postargs['meta_key'] = WPVC_VOTES_CUSTOMFIELD;
					$postargs['orderby'] = 'meta_value_num';
					$postargs['order'] = $shwpvc_args;
				}
				elseif($shwpvc_cont_args['orderby'] == 'top') {
					$postargs['meta_key'] = WPVC_VOTES_CUSTOMFIELD;
					$postargs['orderby'] = 'meta_value_num';
					$postargs['order'] = 'DESC';
				}
				elseif($shwpvc_cont_args['orderby'] == 'bottom') {
					$postargs['meta_key'] = WPVC_VOTES_CUSTOMFIELD;
					$postargs['orderby'] = 'meta_value_num';
					$postargs['order'] = 'ASC';
				}else{
					$postargs['orderby'] = $shwpvc_cont_args['orderby'];
					$postargs['order'] = $shwpvc_args;
				}
			}



			if($search_filter!=''){
				if($search_filter=='new_contestant'){
					$postargs['orderby'] = 'date';
					$postargs['order'] = 'desc';
				}elseif($search_filter=='old_contestant'){
					$postargs['orderby'] = 'date';
					$postargs['order'] = 'asc';
				}elseif($search_filter=='votes_top'){
					$postargs['meta_key'] = WPVC_VOTES_CUSTOMFIELD;
					$postargs['orderby'] = 'meta_value_num';
					$postargs['order'] = 'DESC';
				}elseif($search_filter=='votes_down'){
					$postargs['meta_key'] = WPVC_VOTES_CUSTOMFIELD;
					$postargs['orderby'] = 'meta_value_num';
					$postargs['order'] = 'ASC';
				}
			}

			if($postargs['orderby'] == 'rand'){
				$_SESSION['random_order'] = 1;
			}
			else{
				unset($_SESSION['random_order']);
			}


			if (is_array($shwpvc_cont_args['id']) && count($shwpvc_cont_args['id']) > 1) {
				add_filter('posts_where_request', array('WPVC_Vote_Shortcode_Model','wpvc_votes_expiration_basedon_general'));
			}
			else {
				global $taxid;
				$taxid = isset($shwpvc_cont_args['id'][0]) ? $shwpvc_cont_args['id'][0] : 0;
				add_filter('posts_where_request',array('WPVC_Vote_Shortcode_Model','wpvc_votes_expiration_basedon_taxid'));
			}

			$contest_post = new WP_Query($postargs);

			return $contest_post;
		}

		public static function wpvc_votes_expiration_basedon_general($where){
			global $wpdb;
			return $where.' AND ( select option_id from '.$wpdb->prefix.'options where (`option_name` = "'.WPVC_VOTES_GENERALEXPIRATIONFIELD.'" AND `option_value` = 0 ) or (`option_name` = "'.WPVC_VOTES_GENERALEXPIRATIONFIELD.'" AND `option_value` > "'.date('Y-m-d H:i:s').'" ) ) ';
		}

		public static function wpvc_votes_expiration_basedon_taxid($where){
			global $wpdb,$taxid;
			return $where.' AND ( select option_id from '.$wpdb->prefix.'options where (`option_name` = "'.$taxid.'_'.WPVC_VOTES_TAXEXPIRATIONFIELD.'" AND `option_value` = 0 ) or (`option_name` = "'.$taxid.'_'.WPVC_VOTES_TAXEXPIRATIONFIELD.'" ) ) ';
		}

		public static function wpvc_vote_shwpvc_desc_prettyphoto(){
			global $wpdb;
			$sql = "SELECT * FROM " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " where system_name='contestant-desc' and pretty_view='Y' order by sequence";
			$questions = $wpdb->get_results($sql);
			if(count($questions) > 0)
				return 1;
			else
				return 0;
		}
		public static function wpvc_get_total_vote_count_by_term_id($id){
			global $wpdb;
			$args = array (
				'post_type'    => WPVC_VOTES_TYPE,
				'post_status'  => 'publish',
				'posts_per_page' => -1,
				'tax_query'    => array(
						array(
							'taxonomy' => WPVC_VOTES_TAXONOMY,
							'field' => 'id',
							'terms' => $id
						)
					)
			);

			// The Query
			$query = new WP_Query( $args );
			return $query;
		}

		public static function wpvc_voting_get_contestant_desc(){
		    global $wpdb;
			$sql     = "SELECT * FROM " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " WHERE system_name = 'contestant-desc'";
			$desc_rs = $wpdb->get_results($sql);
			return $desc_rs;
		}


		public static function wpvc_voting_get_contestant_title(){
		    global $wpdb;
			$sql     = "SELECT * FROM " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " WHERE system_name = 'contestant-title'";
			$desc_rs = $wpdb->get_results($sql);
			return $desc_rs;
		}

		public static function wpvc_voting_get_contestant_main_fields(){
		    global $wpdb;
			$sql     = "SELECT * FROM " . WPVC_VOTES_ENTRY_CUSTOM_TABLE . " WHERE system_name = 'contestant-title' OR system_name = 'contestant-desc' OR system_name = 'contestant-image'";
			$desc_rs = $wpdb->get_results($sql,ARRAY_A);
			return $desc_rs;
		}

		public static function wpvc_array_search(Array $array, $key, $value)
		{
			foreach ($array as $subarray){
				if (isset($subarray[$key]) && $subarray[$key] == $value)
				  return $subarray;
			}
		}

		public static function wpvc_voting_get_post_entry_track($where){
		    global $wpdb;
			$sql     = "Select * from ".WPVC_VOTES_POST_ENTRY_TRACK.$where;
			$get_count_track = $wpdb->get_results($sql);
			return $get_count_track;
		}

		public static function wpvc_voting_update_post_entry_track($new_count,$id,$term_id){
			global $wpdb;
			$save_sql = "UPDATE " . WPVC_VOTES_POST_ENTRY_TRACK . " SET count_post=" . $new_count . " WHERE id='" .$id. "' and wpvc_term_id='".$term_id."'";
			$wpdb->query($save_sql);
		}

		public static function wpvc_voting_insert_post_entry_track($user_ID,$ip,$term_id){
			global $wpdb;
			$save_sql = 'INSERT INTO `' . WPVC_VOTES_POST_ENTRY_TRACK . '` (`user_id_map`,`ip`,
									`count_post`,`wpvc_term_id`) VALUES ("' . $user_ID . '", "' . $ip . '", 1 , "'.$term_id.'") ';
			$wpdb->query($wpdb->prepare( $save_sql));
		}


		public static function wpvc_voting_insert_contestants($contest_args,$vote_opt,$category_options,$custom_fields,$check_status){
			global $wpdb;
			$imgcontest = $category_options['imgcontest'];
			$vote_onlyloggedcansubmit = $vote_opt['vote_onlyloggedcansubmit'];
			extract( shortcode_atts( array(
			'id' => NULL,
			'showcontestants' => 1,
			'message' => 1,
			'contestshowfrm'=>1,
			'displayform'=>0,
			'loggeduser'=>$vote_onlyloggedcansubmit,
			), $contest_args ));

			if($check_status && $displayform==0){
				return ;
			}
			else{
				$formProcessed = $formError  = FALSE;

				if(isset($_POST['contestantform'.$contest_args['id']])) {
					$error = new WP_Error();

					//Validate the post values
					if(!get_term_by( 'id', $_POST['contest-id'], WPVC_VOTES_TAXONOMY)) {
						$error->add(__('Invalid Save','voting-contest'), '<strong>'.__('Error','voting-contest').'</strong>: '.__('Some problem in Saving. Please Try Later','voting-contest'));
					}

					$cat_id = $_POST['contest-id'];

					$contestant_title = strip_tags($_POST['contestant-title']);
					$contestant_desc = $_POST['contestant-desc'.$contest_args['id']];
					if(!trim($contestant_title)) {
						$error->add(__('Invalid Title','voting-contest'), '<strong>'.__('Error','voting-contest').'</strong>: '.__('Enter the Contestants Title','voting-contest'));
					}

					$desc_rs = WPVC_Vote_Shortcode_Model::wpvc_voting_get_contestant_desc();
					if($desc_rs[0]->admin_only == "Y"){
						if($desc_rs[0]->required == "Y"){
							if(!trim($contestant_desc)) {
								$error->add(__('Invalid Description','voting-contest'), '<strong>'.__('Error','voting-contest').'</strong>: '.__('Enter the Contestants Description','voting-contest'));
							}
						}
					}



					//Prevent Edit Image
					if($_POST['contestant-image-hidden'] == 0){
						$supportedFormat = array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF');
						$uploadedMeta = wp_check_filetype_and_ext('contestant-image'.$cat_id, $_FILES['contestant-image'.$cat_id]['name']);
						if($category_options['imgcontest']!='')
							$image_contest = $category_options['imgcontest'];

						if($image_contest=='photo'){
							if( !class_exists('wp_voting_photo_extension') ) {
								if(($_FILES['contestant-image'.$cat_id]['error']) || ($_FILES['contestant-image'.$cat_id]['size'] <=0 )) {
									$error->add('Invalid File', '<strong>'.__('Error','voting-contest').'</strong>: '.__('Problem in File Upload','voting-contest'));
								}
								else if(!in_array($uploadedMeta['ext'], $supportedFormat)) {
									$error->add('Invalid File Format', '<strong>'.__('Error','voting-contest').'</strong>: '.__('Invalid File Format. (Note: Supported File Formats ','voting-contest').implode($supportedFormat, ', ').')');
								}
							}
						}
					}


					if(!empty($custom_fields)){
						$posted_val=array();
						foreach($custom_fields as $custom_field){

						   if($custom_field->system_name != 'contestant-desc' && $custom_field->system_name !=  'contestant-ow_video_url' && $custom_field->system_name !=  'contestant-ow_music_url_link' && $custom_field->system_name !=  'contestant-email_address'):
								if($custom_field->question_type != "FILE"){
								 $posted_val[$custom_field->system_name]=$_POST[$custom_field->system_name];
								}
						   endif;
						}
					}

					if( isset( $error->errors  ) && $error->errors != null ) {
						$formError = TRUE;
					?>
						<div class="wpvc_contestants-errors">
							<?php
							foreach ($error->get_error_codes() as $errcode) {
								echo '<div class="error-rows">'.$error->errors($errcode) . '</div>';
							}
							?>
						</div>
					<?php
					}else{
						$vote_publishing_type = ($vote_opt['vote_publishing_type'] == 'on')?'publish':WPVC_DEF_PUBLISHING;
						global $user_ID;
						if($contestant_desc == null){
							$contestant_desc = $contestant_title;
						}
						$args = array(
							'post_author' => $user_ID,
							'post_content' => $contestant_desc,
							'post_status' => $vote_publishing_type ,
							'post_type' => WPVC_VOTES_TYPE,
							'post_title' => $contestant_title
						);

						$cont_details = array('contestant_title' => $contestant_title, 'contestant_desc' => $contestant_desc);

					//INSERT CONTESTANT
					if(!isset($_POST['conid'])){

						if(isset($category_options['vote_contest_entry_person'])){
							$user_ID = get_current_user_id();

							if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARTDED_FOR'] != '') {
								$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
							} else {
								$ip = $_SERVER['REMOTE_ADDR'];
							}

							if(is_user_logged_in()){
								$where_query =" where user_id_map='".$user_ID."' and wpvc_term_id='".$contest_args['id']."'";
								$contestant_author = $user_ID;
							}
							else{
								$where_query =" where ip='".$ip."' and wpvc_term_id='".$contest_args['id']."'";
								$contestant_author = $ip;
							}

							$get_count_track = WPVC_Vote_Shortcode_Model::wpvc_voting_get_post_entry_track($where_query);
							$count_val = count($get_count_track);
							if($count_val>0){
								if($category_options['vote_contest_entry_person'] > $get_count_track[0]->count_post)
								{
									$post_id = wp_insert_post($args);
									$new_count = $get_count_track[0]->count_post+1;
									WPVC_Vote_Shortcode_Model::wpvc_voting_update_post_entry_track($new_count,$get_count_track[0]->id,$contest_args['id']);
								}
								else{
								  $formError = TRUE;
									?>
									<div class="wpvc_contestants-errors">
										<div class="error-rows">
											<strong><?php _e('Error:','voting-contest'); ?></strong>
											<?php _e('You Already Submitted ','voting-contest'); ?>
											<?php echo $get_count_track[0]->count_post;?> <?php _e('Entries.','voting-contest'); ?>
										</div>
									</div>
								<?php
								}
							}else{
								WPVC_Vote_Shortcode_Model::wpvc_voting_insert_post_entry_track($user_ID,$ip,$contest_args['id']);
								$post_id = wp_insert_post($args);
							}

							//Added for the Contestant Entered person
							update_post_meta($post_id, '_wpvc_contestant_author_'.$contest_args['id'], $contestant_author);

						}else{

							$post_id = wp_insert_post($args);
							if(is_user_logged_in()){
								$user_ID = get_current_user_id();
								$contestant_author = $user_ID;
								//Added for the Contestant Entered person
								update_post_meta($post_id, '_wpvc_contestant_author_'.$contest_args['id'], $contestant_author);
							}

						}
						update_post_meta($post_id, WPVC_VOTES_CUSTOMFIELD, 0);
						do_action('wpvc_save_contestant',$post_id,$category_options);

					}
					else{
						$args['ID'] = $_POST['conid'];
						$post_id = wp_update_post( $args );
						do_action('wpvc_save_contestant',$post_id,$category_options);
					}

						if(!empty($custom_files)){
							$i = 0;
							foreach($custom_files as $key => $files){
								$upload = wp_upload_bits($_FILES[$key]['name'], null, file_get_contents($_FILES[$key]['tmp_name']));
								update_post_meta($post_id, 'wpvc_custom_attachment_'.$i, $upload);
								$posted_val[$key] = $i;
								$i++;
							}
						}

						foreach($posted_val as $key => $values){
							//Updating the Custome Fields in POST META for search Fix in Future -- After Voting Upgrade Module Version
							if($key != 'contestant-title' && $key != 'contestant-desc'){
								update_post_meta($post_id, $key, $values);
							}
						}

						$val_serialized = base64_encode(maybe_serialize($posted_val));

						if(!isset($_POST['conid'])){
							WPVC_Contestant_Model::wpvc_voting_insert_post_entry($post_id,$val_serialized);
							do_action('wpvc_save_custom_fields',$post_id,$category_options);
							do_action( 'mail_hook_add_contestant', $post_id,$cont_details);
						}
						else{
							//Updating the Custom Fields in Table WPVC_VOTES_POST_ENTRY_TABLE
							do_action('wpvc_save_custom_fields',$post_id,$category_options);
							WPVC_Contestant_Model::wpvc_voting_contestant_update_field($val_serialized,$post_id);
						}

						$attach_id = FALSE;
						if($post_id && !is_wp_error( $post_id )) {

							if($_FILES['contestant-image'.$cat_id]['size']) {
								require_once (ABSPATH.'/wp-admin/includes/media.php');
								require_once (ABSPATH.'/wp-admin/includes/file.php');
								require_once (ABSPATH.'/wp-admin/includes/image.php');
								$attach_id = media_handle_upload('contestant-image'.$cat_id, $post_id);
							}
							if($attach_id) {
								set_post_thumbnail($post_id, $attach_id);
							}
							wp_set_post_terms( $post_id, $_POST['contest-id'], WPVC_VOTES_TAXONOMY);
							if(is_user_logged_in()){
								//Send Mail for Contestant
								do_action( 'mail_hook_add_contestant_user', $post_id,$cont_details);
							}

							unset($_POST);

							$contesturl = get_permalink(get_the_ID());
							if(stripos($contesturl, '?')) {
								$contesturl .= '&success=1';
							}
							else {
								$contesturl .= '?success=1';
							}
							ob_end_flush();
							ob_start();
							$contesturl = get_permalink(get_the_ID());
							if(stripos($contesturl, '?')) {
								$contesturl .= '&success='.$id;
							}
							else
							{
								$contesturl .= '?success='.$id;
							}
							
							//Hook Only on Insert
							if(!isset($_POST['conid'])){
								do_action('wpvc_voting_contestants_entry',$post_id,$id);
							}


							echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$contesturl.'&owsuccess='.$post_id.'">';

							$formProcessed = $id;
						}
						else {
							if(!$formError){
							$formError = TRUE;
							?>
							<div class="wpvc_contestants-errors">
								<div class="error-rows"><strong><?php _e('Error:','voting-contest'); ?></strong><?php _e(' Problem in Saving. Please try it later.','voting-contest'); ?></div>
							</div>
							<?php
							}
						}


					}
				}


				if((isset($_GET['success']) && ($_GET['success'] == $id)) || $formProcessed == $id ){
				if($vote_opt['vote_publishing_type'] == 'on'){
				?>
					<input type="hidden" id="wpvc_sucess_message" value="<?php _e('Your entry has been successfully submitted. You will receive a confirmation email.','voting-contest'); ?>" />
					<input type="hidden" id="wpvc_sucess_approve" value="<?php echo $_GET['owsuccess']; ?>" />
				<?php
				}
				else{
				?>
					<input type="hidden" id="wpvc_sucess_message" value="<?php _e('Contestant Successfully Added. Waiting for Admin Approval.You will receive a confirmation email.','voting-contest'); ?>" />
					<input type="hidden" id="wpvc_sucess_approve" value="0" />
				<?php
				}
				}

			}

		}

		public static function wpvc_votes_get_adjacent_post_model($in_same_cat, $excluded_categories, $previous){
			global $wpdb;
			if ( ! $post = get_post() )
				return null;
			$current_post_date = $post->post_date;
			$join = '';
			$posts_in_ex_cats_sql = '';

			if ( $in_same_cat || ! empty( $excluded_categories ) ) {
			  $join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
			  if ( $in_same_cat ) {
				  $cat_array = $excluded_categories;
				  if ( ! $cat_array || is_wp_error( $cat_array ) )
					  return '';
				  $join .= " AND tt.taxonomy = 'contest_category' AND tt.term_id IN (" . implode(',', $cat_array) . ")";
			  }
			  $posts_in_ex_cats_sql = "AND tt.taxonomy = 'contest_category'";

			}
			$adjacent = $previous ? 'previous' : 'next';
			$op = $previous ? '<' : '>';
			$order = $previous ? 'DESC' : 'ASC';
			$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_cat, $excluded_categories );
			$where = apply_filters( "get_{$adjacent}_post_where", "WHERE p.ID $op $post->ID AND p.post_type = '".WPVC_VOTES_TYPE."' AND p.post_status = 'publish' $posts_in_ex_cats_sql", $in_same_cat, $excluded_categories );
			$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.ID $order LIMIT 1" );
			$query = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort";
			$query_key = 'adjacent_post_' . md5($query);

			$result = wp_cache_get($query_key, 'counts');
			if ( false !== $result ) {
				if ( $result )
					$result = get_post( $result );
				return $result;
			}
			$result = $wpdb->get_var( $query );
			return $result;
		}

	}

}else
die("<h2>".__('Failed to load Voting Shortcode model')."</h2>");
?>
