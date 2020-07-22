<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Contestant_Controller')){
    class WPVC_Vote_Contestant_Controller{

		public function __construct(){
			//Add the field colums to the contestant
			add_filter('manage_edit-' . WPVC_VOTES_TYPE . '_columns',array($this,'wpvc_contestant_post_add_columns'));
			add_filter('manage_edit-' . WPVC_VOTES_TYPE . '_sortable_columns',array($this,'wpvc_votes_custom_post_page_sort'), 10, 2);
			//Get the values of the custom added fields
			add_action('manage_' . WPVC_VOTES_TYPE . '_posts_custom_column', array($this,'wpvc_custom_new_votes_column'), 10, 2);

			//Custom contestant meta boxes
			add_action('add_meta_boxes', array($this,'wpvc_custom_meta_box_contestant'));
			 //Tab menu on contestant
			add_action( 'wp_after_admin_bar_render', array($this,'wpvc_contestant_custom_menu_bar'));

			//Bulk Approval
			add_action('admin_footer-edit.php', array($this,'wpvc_voting_bulk_add_approve'));
			add_action('load-edit.php', array($this,'wpvc_voting_bulk_add_approve_action'));
			add_action('admin_notices',array($this,'wpvc_voting_bulk_add_approve_notices'));

			//Adding the enctype in Wordpress form
			add_action('post_edit_form_tag', array($this,'wpvc_post_edit_form_tag'));

			//Add Sorting Code in the Contestants
			add_action( 'pre_get_posts', array($this,'wpvc_manage_wp_posts_be_qe_pre_get_posts'), 1 );
			add_filter( 'posts_clauses', array($this,'wpvc_contest_category_clauses'), 10, 2 );

			//Adding Taxonomy Filter in admin end
			add_action('restrict_manage_posts', array($this,'wpvc_filter_post_type_by_taxonomy'));
			add_filter('parse_query', array($this,'wpvc_convert_id_to_term_in_query'));

			add_filter('post_rwpvc_actions',array($this,'wpvc_remove_quick_edit'),10,2);

		}

		public function wpvc_remove_quick_edit( $actions,$post ) {
			global $typenow;
			if ($typenow == WPVC_VOTES_TYPE) {
				unset($actions['inline hide-if-no-js']);
			}
			return $actions;
		}

		public function wpvc_filter_post_type_by_taxonomy() {
			global $typenow;
			$post_type = WPVC_VOTES_TYPE; // change to your post type
			$taxonomy  = WPVC_VOTES_TAXONOMY; // change to your taxonomy
			if ($typenow == $post_type) {
				$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
				$info_taxonomy = get_taxonomy($taxonomy);
				wp_dropdown_categories(array(
					'shwpvc_option_all' => __("Show All {$info_taxonomy->label}"),
					'taxonomy'        => $taxonomy,
					'name'            => $taxonomy,
					'orderby'         => 'name',
					'selected'        => $selected,
					'shwpvc_count'      => false,
					'hide_empty'      => true,
				));
			};
		}

		public function wpvc_convert_id_to_term_in_query($query) {
			global $pagenow;
			$post_type = WPVC_VOTES_TYPE; // change to your post type
			$taxonomy  = WPVC_VOTES_TAXONOMY; // change to your taxonomy
			$q_vars    = &$query->query_vars;
			if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
				$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
				$q_vars[$taxonomy] = $term->slug;
			}
		}

		public function wpvc_manage_wp_posts_be_qe_pre_get_posts($query){
			if ( $query->is_main_query() && ( $orderby = $query->get( 'orderby' ) ) ) {
				switch( $orderby ) {
				   case 'votes':
					$query->set( 'meta_key', WPVC_VOTES_CUSTOMFIELD );
				        $query->set( 'orderby', 'meta_value' );
					break;
				}
			}
		}

		public function wpvc_contest_category_clauses($clauses, $wp_query){
			global $wpdb;

			if ( isset( $wp_query->query['orderby'] ) && 'contest_category' == $wp_query->query['orderby'] ) {
				$clauses['join'] .= " LEFT JOIN (
					SELECT object_id, GROUP_CONCAT(name ORDER BY name ASC) AS color
					FROM $wpdb->term_relationships
					INNER JOIN $wpdb->term_taxonomy USING (term_taxonomy_id)
					INNER JOIN $wpdb->terms USING (term_id)
					WHERE taxonomy = 'contest_category'
					GROUP BY object_id
				) AS color_terms ON ($wpdb->posts.ID = color_terms.object_id)";
				$clauses['orderby'] = 'color_terms.color ';
				$clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
			}

			return $clauses;


		}

		public function wpvc_post_edit_form_tag() {
			echo ' enctype="multipart/form-data"';
		}

		//Add columns to custom post(contestants)
		public function wpvc_contestant_post_add_columns($add_columns)
		{
			unset($add_columns['taxonomy-contest_category']);
			unset($add_columns['date']);
			unset($add_columns['author']);
			unset($add_columns['comments']);
			unset($add_columns['title']);
			$add_columns['cb'] = '<input type="checkbox" />';
			$add_columns['image'] = __('Featured Image', 'voting-contest');
			$add_columns['title'] = __('Title', 'voting-contest');
			$add_columns['info'] = __('Info', 'voting-contest');
			$add_columns[WPVC_VOTES_TAXONOMY] = __('Contest Category', 'voting-contest');
			$add_columns['votes'] = __('Votes', 'voting-contest');
			//

			return $add_columns;
		}

		//Specify the columns that need to be sortable
		public function wpvc_votes_custom_post_page_sort($columns) {
			$columns[WPVC_VOTES_TAXONOMY]= 'contest_category';
			$columns['votes']='votes';
			return $columns;
		}

		//Get the values of the post contestants
		public function wpvc_custom_new_votes_column($column, $post_id) {
			add_thickbox();

			wp_register_script('wpvc_admin_js', WPVC_ASSETS_JS_PATH . 'wpvc_admin_js.js');
			wp_enqueue_script('wpvc_admin_js',array('jquery'));

			$terms = wp_get_post_terms($post_id, WPVC_VOTES_TAXONOMY);
			if (!empty($terms)) {
				$current_term_id = $terms[0]->term_id;
				$category_options = get_option($current_term_id. '_' . WPVC_VOTES_SETTINGS);
				$imgcontest = $category_options['imgcontest'];
			}
			else{
				$imgcontest = '';
			}

			switch ($column) {

			case 'voteid':
				echo $post_id;
			break;

			case WPVC_VOTES_TAXONOMY:
				$terms = get_the_terms($post_id, WPVC_VOTES_TAXONOMY);
				if (!empty($terms)) {
				$out = array();
				foreach ($terms as $c) {
					$_taxonomy_title = esc_html(sanitize_term_field('name', $c->name, $c->term_id, 'category', 'display'));
					$out[] = "<a href='edit.php?" . WPVC_VOTES_TAXONOMY . "=$c->slug&post_type=" . WPVC_VOTES_TYPE . "'>$_taxonomy_title</a>";
				}
				echo join(', ', $out);
				} else {
					_e('Uncategorized','voting-contest');
				}
			break;

			case 'image':
				if (has_post_thumbnail($post_id)) {
				$image_arr = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail');
				$image_src = $image_arr[0];
					echo "<img src=".$image_src." width='200' height='150' class='left-img-thumb' />";
				} else {
					echo "<img src=".WPVC_NO_IMAGE_CONTEST." width='200px' class='left-img-thumb' />";
				}
				break;


			case 'votes':
				$votes = get_post_meta($post_id, WPVC_VOTES_CUSTOMFIELD,'true');
				echo ($votes == null)?0:$votes;
				break;

			case 'info':
				echo "<i class='owvotingicon owicon-date'></i><span class='wpvc_admininfo'>".get_the_date().'</span> <br/>';
				$author = get_the_author();
				$author = ($author != null)?$author:'Admin';
				echo "<i class='owvotingicon owicon-authors'></i><span class='wpvc_admininfo'>".$author.'</span> <br/>';
				echo "<i class='owvotingicon owicon-imgcontest'></i><span class='wpvc_admininfo'>".ucfirst($imgcontest).'</span>';
				break;

			}
		}

		//Add the custom meta boxes on add/edit
		public function wpvc_custom_meta_box_contestant(){
			add_meta_box('votesstatus', __('Votes For this Contestant','voting-contest'), array($this,'wpvc_votes_count_meta_box'), WPVC_VOTES_TYPE, 'normal', 'high');

		}

		public function wpvc_votes_custom_link(){
			global $post,$wpdb;
			$custom_link = get_post_meta($post->ID,'wpvc_contestant_link',true);
			require_once(WPVC_VIEW_PATH.'wpvc_contestant_metabox_view.php');
			wpvc_votes_custom_link_metabox_view($custom_link);
		}



		//Votes count metabox
		public function wpvc_votes_count_meta_box() {
			global $post,$wpdb;
			require_once(WPVC_VIEW_PATH.'wpvc_contestant_metabox_view.php');
			$cnt = WPVC_Contestant_Model::wpvc_get_votes_count_post($post);
			wpvc_votes_count_metabox_view($cnt);
		}

		//Tab menu on the contestant page
		public function wpvc_contestant_custom_menu_bar()
		{
			require_once(WPVC_VIEW_PATH.'wpvc_contestant_common_view.php');
			wpvc_votes_admin_menu_custom();
		}

		public static function wpvc_voting_vote_logs(){
			global $wpdb;
			require_once(WPVC_VIEW_PATH.'wpvc_vote_log_view.php');

			$log_entries['orderby'] = !isset($_GET['orderby'])?'log.date':$_GET['orderby'];
			$log_entries['order'] = !isset($_GET['order'])?'desc':$_GET['order'];

			//Get counts
			$total   =  WPVC_Contestant_Model::wpvc_total_votes_count();

			if(empty($_GET['paged'])) {
			$paged = 1;
			}
			else {
			$paged = ((int) $_GET['paged']);
			}
			// $records_per_page = isset($_GET['logs_per_page'])?$_GET['logs_per_page']:'';
			$records_per_page = isset($_GET['logs_per_page']) ? $_GET['logs_per_page'] : 10;


			if ( isset( $records_per_page ) && $records_per_page )
			$log_entries['rpp'] = $records_per_page;
			else
			$log_entries['rpp'] = 10;

			$log_entries['startat'] = ($paged - 1) * $log_entries['rpp'];

			$trans_navigation = paginate_links( array(
				'base' => add_query_arg( 'paged', '%#%' ),
				'format' => '',
				'total' => ceil(count($total) / $log_entries['rpp']),
				'current' => $paged,
			));

			$log_no = (isset($log_entries['rpp']))?'&logs_per_page='.$log_entries['rpp']:'';
			$voting_logs['actual_link'] = admin_url().'admin.php?page=votinglogs'.$log_no;
			$voting_logs['yet_to_order'] = ($log_entries['order'] == 'asc')?'desc':'asc';


			if(isset($_POST['action'])){
				if($_POST['action'] == "delete" ){
					foreach($_POST['checkbox'] as $key => $check_val){
						WPVC_Contestant_Model::wpvc_voting_delete_entries($check_val,$key);
					}
					$redirect_link = admin_url().'admin.php?page=votinglogs&delete_success=2';
					echo '<meta http-equiv="refresh" content="0;url='.$redirect_link.'">';
				}
			}

			if(isset($_POST['delete_tbl_id']) && isset($_POST['delete_vote_id']))
			{
				WPVC_Contestant_Model::wpvc_voting_delete_entries($_POST['delete_vote_id'],$_POST['delete_tbl_id']);
				$redirect_link = admin_url().'admin.php?page=votinglogs&delete_success=1';
				echo '<meta http-equiv="refresh" content="0;url='.$redirect_link.'">';
			}

			$voting_logs['log_entries'] = WPVC_Contestant_Model::wpvc_voting_log_entries($log_entries);

			wpvc_vote_log_view($voting_logs,$log_entries,$trans_navigation);

		}

		public function wpvc_voting_bulk_add_approve(){
			global $post_type;
			if(isset($_REQUEST['post_status'])){
				if($post_type == WPVC_VOTES_TYPE && ($_REQUEST['post_status'] == '' || $_REQUEST['post_status'] == 'pending' || $_REQUEST['post_status'] == 'pending_approval' || $_REQUEST['post_status'] == 'payment_pending' || $_REQUEST['post_status'] == 'draft')) {
				  ?>
				  <script type="text/javascript">
					jQuery(document).ready(function() {
					  jQuery('<option>').val('contestant_approve').text('<?php _e('Approve')?>').appendTo("select[name='action']");
					  jQuery('<option>').val('contestant_approve').text('<?php _e('Approve')?>').appendTo("select[name='action2']");
					});
				  </script>
				  <?php
				}
			}
		}

		public function wpvc_voting_bulk_add_approve_action(){
			$screen = get_current_screen();
			if (!isset($screen->post_type) || WPVC_VOTES_TYPE !== $screen->post_type) {
				return;
			}
			$wp_list_table = _get_list_table('WP_Posts_List_Table');
			$action = $wp_list_table->current_action();
			$approved = 0;

			switch($action)
			{
				case 'contestant_approve':
					// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
					if(isset($_REQUEST['post'])) {
							$post_ids = array_map('intval', $_REQUEST['post']);
					}
					if(empty($post_ids)) return;

					$sendback = remove_query_arg( array('exported', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
					if ( ! $sendback )
						$sendback = admin_url( "edit.php?post_type=".WPVC_VOTES_TYPE );

					$pagenum = $wp_list_table->get_pagenum();
					$sendback = add_query_arg( 'paged', $pagenum, $sendback );
					$exploded_ids = implode(',',$post_ids);
					$result_ids =   WPVC_Contestant_Model::wpvc_vote_contestant_bulk_pending($exploded_ids);

					//Change the Status of the Contestants
					foreach($post_ids as $pid):
						$contestants = array( 'ID' => $pid, 'post_status' => 'publish' );
						if(get_post_status( $pid ) != 'publish'){
							wp_update_post($contestants);
						}
					endforeach;

					$sendback = add_query_arg( array('approved' => $approved, 'ids' => count($result_ids) ), $sendback );
				break;

				default: return;
			}
		}

		public function wpvc_voting_bulk_add_approve_notices(){
			global $post_type, $pagenow;
			if($pagenow == 'edit.php' && $post_type == WPVC_VOTES_TYPE) {
				if (isset($_REQUEST['approved'])) {
					//Print notice in admin bar
                    $message = sprintf( _n( 'Contestants approved.', '%s Contestants approved.', $_REQUEST['approved'] ), number_format_i18n( $_REQUEST['ids']) ) ;
					if(!empty($message)) {
							echo "<div class=\"updated\"><p>{$message}</p></div>";
					}
				}
			}
		}

    }
}else
die("<h2>".__('Failed to load Voting Contestant Controller','voting-contest')."</h2>");

return new WPVC_Vote_Contestant_Controller();
