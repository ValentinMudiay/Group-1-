<?php
session_start();
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Admin_Controller')){
	class WPVC_Admin_Controller{

	public static $addScript = false;

	public function __construct(){

		    add_action('init', array($this,'wpvc_votes_register_taxonomy'));
		    add_action('admin_menu', array($this, 'wpvc_voting_admin_menu'));
		    add_action('parent_file', array($this,'wpvc_vote_tax_menu_correction'));

		    //Register Widget for admin/Frontend
		    add_action( 'widgets_init', array($this,'wpvc_voting_sidebar_init'));
		    //Script Exclude for Without Shortcode
		    add_filter('the_posts', array($this,'wpvc_votes_conditionally_add_scripts_and_styles'));

		    //Widget shortcode
		    add_filter('widget_text', 'shortcode_unautop');
		    add_filter('widget_text', 'do_shortcode');

		    //Infinite Scroll Random Orderby Fix
		    add_filter('posts_orderby', array($this,'wpvc_votes_posts_orderby_random'));

			//Add Tiny MCE Button for Shortcode
			add_action('admin_head', array($this,'wpvc_votes_addMCE_button'));


			add_action( 'publish_contestants', array($this,'wpvc_votes_add_contestant_mail_function_user_approval'), 11, 2 );

			//Vote Button Text
			add_filter('wpvc_votes_btn', array($this,'wpvc_votes_btn_text'),10,2);

			//External Image Source
			add_filter('wpvc_image_external_src',array($this,'wpvc_image_external_src'),100,2);

			//Admin Settings Save Hook
			add_action('wpvc_voting_admin_settings',array($this,'wpvc_voting_admin_settings'),10,1);

	}

	public function wpvc_voting_admin_settings($options){
		if(is_array($options)){
			$vote_onlyloggedcansubmit = $options['vote_onlyloggedcansubmit'];
			if($vote_onlyloggedcansubmit == 'on'){
				global $wpdb;
				$wpdb->update(
					WPVC_VOTES_ENTRY_CUSTOM_TABLE,
					array(
						'required' => 'N',
						'admin_only' => 'N'
					),
					array( 'system_name' => 'contestant-email_address' ),
					array(
						'%s',
						'%s'
					),
					array( '%s' )
				);
			}
			else{
				$vote_notify_contestant = $options['vote_notify_contestant'];
				$vote_notify_approved = $options['vote_notify_approved'];
				if($vote_notify_contestant == 'on' || $vote_notify_approved == 'on'){
					global $wpdb;
					$wpdb->update(
							WPVC_VOTES_ENTRY_CUSTOM_TABLE,
							array(
								'required' => 'Y',
								'admin_only' => 'Y'
							),
							array( 'system_name' => 'contestant-email_address' ),
							array(
								'%s',
								'%s'
							),
							array( '%s' )
					);
				}
			}
		}
	}
	public function wpvc_image_external_src($imgsrc,$post_id){
		echo $imgsrc;
	}

	public function wpvc_votes_btn_text($btn_text,$curterm){
		return $btn_text;
	}

	//On add contestant Mail sent to added user both Approve/Published
	public function wpvc_votes_add_contestant_mail_function_user_approval($post_id,$post){
		if (WPVC_VOTES_TYPE == $post->post_type) {
			$option_setting = get_option(WPVC_VOTES_SETTINGS);
			if($option_setting['vote_notify_approved']=='on'){

				$contestant_email_address = get_post_meta($post_id,'contestant-email_address',true);


				if(isset($contestant_email_address)){
					$user_email = $contestant_email_address;
				}
				else{
					return ;
				}

				$cont_details = array('contestant_title' => $post->post_title, 'contestant_desc' => get_post_field('post_content', $post_id));

				if($option_setting['vote_contestant_approved_content'] != null)	{
					$email_description = $option_setting['vote_contestant_approved_content'];
				}

				if($option_setting['vote_approve_subject'] != null)	{
					$subject = $option_setting['vote_approve_subject'];
				}
				else{
					$subject = __('Your Entry Is Approved by Admin','voting-contest');
				}

				require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_mail_content_view.php');
				require_once(WPVC_CONTROLLER_PATH.'wpvc_vote_shortcode_controller.php');
				$email_description = WPVC_Vote_Shortcode_Controller::wpvc_get_email_description_with_content($post_id,$email_description,$cont_details);
				$message = wpvc_voting_mail_addcontestant_view($option_setting,$post_id,$cont_details,$email_description,1);


				if($user_email!='')
					$headers[] = 'From: '.$user_email;

				$headers[] = "Content-type: text/html";
				wp_mail($user_email, $subject,$message ,$headers);

			}
		}
	}


	public function wpvc_votes_posts_orderby_random($orderby_statement){
		global $pagenow;
		$votes_settings = get_option(WPVC_VOTES_SETTINGS);
		if($pagenow != 'edit.php' && $_SESSION['wpvc_profile'] != 1 && !isset($_POST['filter_votes']) && ($votes_settings['orderby'] == 'rand' || isset($_SESSION['random_order']))){
			$seed = $_SESSION['seed'];
			if (empty($seed)) {
			  $seed = rand();
			  $_SESSION['seed'] = $seed;
			}

			$orderby_statement = 'RAND('.$seed.')';
		}
		return $orderby_statement;

	}

	//Register taxonomy and post type
	public function wpvc_votes_register_taxonomy(){
		    $menupos=26; // This helps to avoid menu position conflicts with other plugins.
		    $cust_slug	=  get_option(WPVC_VOTES_SETTINGS);
		    $slug 	=  'contestants';
		    while (isset($GLOBALS['menu'][$menupos])) $menupos+=1;


		   /* register_post_type(WPVC_VOTES_TYPE, array('label' => __('Contestants','voting-contest'),
			    'description' => '',
			    'public' => true,
			    'shwpvc_ui' => true,
			    'shwpvc_in_menu' => false,
			    'capability_type' => 'post',
			    'hierarchical' => false,
			    'rewrite' => array('slug' => $slug),
			    'query_var' => true,
			    'supports' => array('title',
			    'editor',
			    'thumbnail',
			    'author',
			    'comments',
			    'page-attributes'),
			    'labels' => array(
			    'name' => __('Contestants','voting-contest'),
			    'singular_name' => __('Contest','voting-contest'),
			    'menu_name' => __('Contests','voting-contest'),
			    'name_admin_bar' => __('Contests','voting-contest'),
			    'add_new' => __('Add Contestant','voting-contest'),
			    'add_new_item' => __('Add New Contestant','voting-contest'),
			    'edit' => __('Edit','voting-contest'),
			    'edit_item' => __('Edit Contestant','voting-contest'),
			    'new_item' => __('New Contestant','voting-contest'),
			    'view' => __('View Contestant','voting-contest'),
			    'view_item' => __('View Contestant','voting-contest'),
			    'search_items' => __('Search Contestant','voting-contest'),
			    'not_found' => __('No Contestants Found','voting-contest'),
			    'not_found_in_trash' => __('No Contestants Found in Trash','voting-contest'),
			    'parent' => 'Parent Contestants',
			    'menu_position' => $menupos,
		    )));*/


            $labels = array(
                   		'name'               => _x( 'Contestants', 'post type general name', 'voting-contest' ),
                   		'singular_name'      => _x( 'Contestant', 'post type singular name', 'voting-contest' ),
                   		'menu_name'          => _x( 'Contestants', 'admin menu', 'voting-contest' ),
                   		'name_admin_bar'     => _x( 'Contestant', 'add new on admin bar', 'voting-contest' ),
                   		'add_new'            => _x( 'Add New', 'Contestant', 'voting-contest' ),
                   		'add_new_item'       => __( 'Add New Contestant', 'voting-contest' ),
                   		'new_item'           => __( 'New Contestant', 'voting-contest' ),
                   		'edit_item'          => __( 'Edit Contestant', 'voting-contest' ),
                   		'view_item'          => __( 'View Contestant', 'voting-contest' ),
                   		'all_items'          => __( 'All Contestants', 'voting-contest' ),
                   		'search_items'       => __( 'Search Contestants', 'voting-contest' ),
                   		'parent_item_colon'  => __( 'Parent Contestants:', 'voting-contest' ),
                   		'not_found'          => __( 'No Contestants found.', 'voting-contest' ),
                   		'not_found_in_trash' => __( 'No Contestants found in Trash.', 'voting-contest' )
                   	);

           	$args = array(
           		'labels'             => $labels,
                   'description'        => __( 'Description.', 'voting-contest' ),
           		'public'             => true,
           		'publicly_queryable' => true,
           		'show_ui'            => true,
                'show_in_rest'       => true, // Set to true for Guttenburg Editor
           		'show_in_menu'       => false,
           		'query_var'          => true,
           		'rewrite'            => array( 'slug' => $slug ),
           		'capability_type'    => 'post',
           		'has_archive'        => true,
           		'hierarchical'       => false,
           		'menu_position'      => $menupos,
           		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'comments' )
           	);

            register_post_type( WPVC_VOTES_TYPE, $args );

		    flush_rewrite_rules();



            $labels = array(
				'name'                       => _x( 'Contest Category', 'taxonomy general name', 'voting-contest' ),
				'singular_name'              => _x( 'Contest Category', 'taxonomy singular name', 'voting-contest' ),
				'search_items'               => __( 'Search Contest Category', 'voting-contest' ),
				'popular_items'              => __( 'Popular Contest Category', 'voting-contest' ),
				'all_items'                  => __( 'All Contest Category', 'voting-contest' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Contest Category', 'voting-contest' ),
				'update_item'                => __( 'Update Contest Category', 'voting-contest' ),
				'add_new_item'               => __( 'Add New Contest Category', 'voting-contest' ),
				'new_item_name'              => __( 'New Contest Category Name', 'voting-contest' ),
				'separate_items_with_commas' => __( 'Separate Contest Category with commas', 'voting-contest' ),
				'add_or_remove_items'        => __( 'Add or remove Contest Category', 'voting-contest' ),
				'choose_from_most_used'      => __( 'Choose from the most used Contest Category', 'voting-contest' ),
				'not_found'                  => __( 'No Contest Category found.', 'voting-contest' ),
				'menu_name'                  => __( 'Contest Category', 'voting-contest' ),
			);


		    register_taxonomy(WPVC_VOTES_TAXONOMY,
				    array(WPVC_VOTES_TYPE),
				    array(
						'hierarchical' => true,
						'labels'       => $labels,
						'show_ui'      => true,
						'query_var'    => true,
                        'publicly_queryable' => false,
                        'public'  => false,
						'show_admin_column'  => true,
						'rewrite'  => false,
                        'show_in_rest'  => true, // Set to true for Guttenburg Editor
					)
		    );

		    $vote_opt = get_option(WPVC_VOTES_SETTINGS);


	}


	public function wpvc_add_styles_to_front_end($vote_opt){

		if(!is_admin()) {

			$vote_opt = get_option(WPVC_VOTES_SETTINGS);

			//Adding styles
			wp_enqueue_script('jquery');
			wp_register_style('WPVC_FRONT_CONTESTANT_STYLES', WPVC_ASSETS_FRONT_END_CSS_PATH);
			wp_enqueue_style('WPVC_FRONT_CONTESTANT_STYLES');

			wp_register_style('WPVC_FRONT_COLOR', WPVC_ASSETS_COLOR_RELPATH);
			wp_enqueue_style('WPVC_FRONT_COLOR');

			wp_register_script('wpvc_votes_block', WPVC_ASSETS_JS_PATH . 'wpvc_vote_block_div.js','','',true);
			wp_enqueue_script('wpvc_votes_block',array('jquery'));

			wp_register_style('wpvc_vote_css_pretty', WPVC_ASSETS_CSS_PATH.'wpvc_vote_prettyPhoto.css');
			wp_enqueue_style('wpvc_vote_css_pretty');

			wp_register_script('wpvc_votes_pretty', WPVC_ASSETS_JS_PATH . 'wpvc_vote_prettyPhoto.js','','',true);
			wp_enqueue_script('wpvc_votes_pretty',array('jquery'));

			wp_register_style('wpvc_vote_css_fancy_box', WPVC_ASSETS_CSS_PATH.'wpvc_vote_fancybox.css');
			wp_enqueue_style('wpvc_vote_css_fancy_box');

			wp_register_script('wpvc_vote_fancy_box', WPVC_ASSETS_JS_PATH . 'wpvc_vote_fancybox.js','','',true);
			wp_enqueue_script('wpvc_vote_fancy_box',array('jquery'));

			wp_register_script('wpvc_votes_validate_js', WPVC_ASSETS_JS_PATH . 'wpvc_vote_validate.js','','',true);
			wp_enqueue_script('wpvc_votes_validate_js',array('jquery'));

			wp_register_script('wpvc_votes_count_down', WPVC_ASSETS_JS_PATH . 'wpvc_count_down.js','','',true);
			wp_enqueue_script('wpvc_votes_count_down',array('jquery'));

			wp_register_script('wpvc_votes_shortcode', WPVC_ASSETS_JS_PATH . 'wpvc_vote_shortcode_jquery.js','','',true);
			wp_enqueue_script('wpvc_votes_shortcode',array('jquery'));


			wp_localize_script( 'wpvc_votes_shortcode', 'vote_path_local', array( 'votesajaxurl' => admin_url( 'admin-ajax.php' ),'vote_image_url'=>WPVC_ASSETS_IMAGE_PATH ) );


			//Genuine Theme Fix
			if(wp_get_theme() == "Genuine" || wp_get_theme() == "Genuine Child Theme"){
				wp_dequeue_script ('jquery-animate-enhanced-min');
			}

			wp_register_script('lazyloadxt', WPVC_ASSETS_JS_PATH.'jquery.lazyloadxt.extra.min.js','','',true);
			wp_enqueue_script('lazyloadxt',array('jquery'));

		}
	}

	public function wpvc_votes_unload_scripts(){
		wp_dequeue_script ('theme-prettyphoto');
	}



	//Admin menu start
	public function wpvc_voting_admin_menu(){

		    add_menu_page('Contests-Voting', 'Contest', 'manage_options',WPVC_VOTES_TYPE, array( $this, 'wpvc_voting_overview'),'dashicons-awards',90);
		    add_submenu_page(WPVC_VOTES_TYPE, __('Overview','voting-contest'), __('Overview','voting-contest'), 'manage_options', WPVC_VOTES_TYPE,array( $this, 'wpvc_voting_overview'));
		    add_submenu_page(WPVC_VOTES_TYPE, __('Contest Category','voting-contest'),"<span class='vote_contest_cat'>".__('Contest Category','voting-contest')."</span>", 'publish_pages', 'edit-tags.php?taxonomy=contest_category&post_type=contestants', '');
		    add_submenu_page(WPVC_VOTES_TYPE, __('Contestants','voting-contest'), "<span class='vote_contest_contestants'>".__('Contestants','voting-contest')."</span>", 'publish_pages', 'edit.php?post_type=contestants', '');

			apply_filters('wpvc_contestant_menu_bottom','');

		    add_submenu_page('', __('Add Contestant','voting-contest'), __('Add Contestant','voting-contest'), 'publish_pages', 'post-new.php?post_type=contestants', '');

		    add_submenu_page('', __('Contestant fields','voting-contest'), __('Contestant fields','voting-contest'), 'publish_pages', 'fieldcontestant',array('WPVC_Vote_Custom_Field_Controller','wpvc_votes_contestant_custom_field_meta_box'));

		    add_submenu_page('', __('Voting Logs','voting-contest'), __('Voting Logs','voting-contest'), 'publish_pages', 'votinglogs', array( 'WPVC_Vote_Contestant_Controller','wpvc_voting_vote_logs'));
		    add_submenu_page(WPVC_VOTES_TYPE, __('Settings','voting-contest'), "<span class='setting_vote_page'>".__('Settings','voting-contest')."</span>", 'publish_pages', 'votes_settings', array( 'WPVC_Vote_Common_Settings_Controller','wpvc_voting_setting_common'));

		    add_submenu_page(WPVC_VOTES_TYPE, __('Plugin License','voting-contest'), __('License','voting-contest'), 'publish_pages', 'votes-license', array('WPVC_Vote_License_Controller','wpvc_voting_software_license_page'));

			add_submenu_page(WPVC_VOTES_TYPE, __('Upgrade to PRO','voting-contest'), __('Upgrade to PRO','voting-contest'), 'publish_pages', 'wpvc_upgrade', 'wpvc_upgrade_text');

	    }

	public function wpvc_vote_tax_menu_correction($parent_file) {
	    global $current_screen,$submenu_file;
		    remove_action( 'admin_notices', 'update_nag', 3 );
		    $base = $current_screen->base;
		    $action = $current_screen->action;
		    $post_type = $current_screen->post_type;
		    $taxonomy = $current_screen->taxonomy;
		    if ($taxonomy == WPVC_VOTES_TAXONOMY){
			    $parent_file = WPVC_VOTES_TYPE;
			    $submenu_file = 'edit-tags.php?taxonomy='.WPVC_VOTES_TAXONOMY.'&post_type='.WPVC_VOTES_TYPE;
		    }

		    //Pagination menu selection not a right way
		    if($parent_file == 'votes_setting_paginate'){ ?>
			    <script type="text/javascript">
			    jQuery(document).ready( function($)
			    {
				    jQuery('li#toplevel_page_contestants').removeClass('wp-not-current-submenu');
				    jQuery('li#toplevel_page_contestants').addClass('wp-has-current-submenu');
				    jQuery('li#toplevel_page_contestants a.toplevel_page_contestants').removeClass('wp-not-current-submenu');
				    jQuery('li#toplevel_page_contestants a.toplevel_page_contestants').addClass('wp-has-current-submenu');

				    var reference = $('.setting_vote_page').parent().parent();
				    // add highlighting to our custom submenu
				    reference.addClass('current');
				    //remove higlighting from the default menu
				    reference.parent().find('li:first').removeClass('current');
			    });
			    </script>
			    <?php
		    }
		    return $parent_file;
	}

	//Overview page
	public function wpvc_voting_overview(){
		    require_once(WPVC_VIEW_PATH.'wpvc_overview_view.php');
	}

		//Register Sidebar
	public function wpvc_voting_sidebar_init() {
			register_sidebar( array(
				'name' => 'Contestants Sidebar',
				'id' => 'contestants_sidebar',
				'before_widget' => '<div class="contestants_sidebar">',
				'after_widget' => '</div>',
				'before_title' => '<h2 class="contestests_sidebar">',
				'after_title' => '</h2>'
			));
	}

	public function wpvc_votes_conditionally_add_scripts_and_styles($posts){
			global $wp_query;
			if (empty($posts)) return $posts;

			$shortcode  = 'showcontestants';
			$shortcode1 = 'endcontestants';
			$shortcode2 = 'upcomingcontestants';
			$shortcode4 = 'rulescontestants';
			$shortcode5 = 'addcontestants';

			$shortcode_found = false; // use this flag to see if styles and scripts need to be enqueued

			//Visual Builder Fix
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if(is_plugin_active('js_composer/js_composer.php'))
			{
				$shortcode_found = true;
			}

			foreach ($posts as $post) {
				if (isset($wp_query->query_vars['contestants']) || stripos($post->post_content, '[' . $shortcode ) !== false || stripos($post->post_content, '[' . $shortcode1 ) !== false || stripos($post->post_content, '[' . $shortcode2 ) !== false || stripos($post->post_content, '[' . $shortcode4 ) !== false  || stripos($post->post_content, '[' . $shortcode5 ) !== false) {
					$_SESSION['wpvc_shortcode_count'] = 1;
					$shortcode_found = true;
					break;
				}
			}


			//Check if it is multiple contestants page
			foreach ($posts as $post) {
				if((substr_count($post->post_content, '['.$shortcode) > 1) || (substr_count($post->post_content, '['.$shortcode1) >1 ) || (substr_count($post->post_content, '['.$shortcode2) > 1)){
					$_SESSION['wpvc_shortcode_count'] = 2;
				}
			}


			if ($shortcode_found) {
			    add_action( 'wp_enqueue_scripts',  array($this,'wpvc_add_styles_to_front_end'), 99);
			    add_action  ('wp_print_scripts',    array($this,'wpvc_votes_unload_scripts'), 99);
			}

			return $posts;
		}

		public function wpvc_votes_addMCE_button(){
			global $typenow;
			// check user permissions
			if ( !current_user_can('edit_posts') &&  !current_user_can('edit_pages') ) {
				return;
			}
			// verify the post type
			if( ! in_array( $typenow, array( 'page' ) ) )
				return;
			// check if WYSIWYG is enabled
			if ( 'true' == get_user_option( 'rich_editing' ) ) {
				add_filter( 'mce_external_plugins', array( $this ,'wpvc_mce_external_plugins' ) );
				add_filter( 'mce_buttons', array($this, 'wpvc_mce_buttons' ) );
			}

			wp_register_style('WPVC_ADMIN_STYLES', WPVC_ASSETS_ADMIN_CSS_PATH);
			wp_enqueue_style('WPVC_ADMIN_STYLES');

		}

		public function wpvc_mce_buttons( $buttons ) {
			$buttons[] = 'wpvc_voting_button';
			return $buttons;
		}

		public function wpvc_mce_external_plugins( $buttons ) {
			$plugin_array['wpvc_voting_button'] = plugins_url( '/assets/js/wpvc_voting_button.js', __DIR__ ); // CHANGE THE BUTTON SCRIPT HERE
			return $plugin_array;
		}




	}
}else
die("<h2>".__('Failed to load the Voting Admin Controller','voting-contest')."</h2>");

return new WPVC_Admin_Controller();
