<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Single_Contestants')){
	class WPVC_Vote_Single_Contestants{
		
		public function __construct(){
			add_filter('query_vars', array($this,'wpvc_votes_add_my_query_var'));
			add_action('parse_query',array($this,'wpvc_votes_parse_query_function'));
						
			add_action('admin_bar_menu', array($this,'wpvc_voting_custom_toolbar_link'), 999);
			
		}
		
		public function wpvc_voting_custom_toolbar_link($wp_admin_bar){
			
			//In Front End for Edit Contestant
			if(is_singular(WPVC_VOTES_TYPE)){
				$args = array(
					'id' => 'edit_contestant',
					'title' => 'Edit Contestant', 
					'href' =>  get_edit_post_link() , 
					'meta' => array(
						'class' => 'edit_contestant', 
						'title' => __('Edit Contestant','voting-contest')
						)
				);
				$wp_admin_bar->add_node($args);
			}			
		}
		
		public function wpvc_votes_add_my_query_var($vars){
			$vars[] = 'contestants';
			$vars[] = 'wpvc_cont';
			$vars[] = 'wpvc_sort';
			$vars[] = 'wpvc_search';
			return $vars;
		}
		
		public function wpvc_votes_parse_query_function(){
			global $wp_query;
			if(isset($wp_query->query_vars['contestants'])){
				if($wp_query->query_vars['contestants']!=''){
					$_SESSION['votingoption'] = get_option(WPVC_VOTES_SETTINGS);
					add_filter('the_content', array($this,'wpvc_votes_contestant_content_update')); 
					add_filter('single_template', array($this,'wpvc_vote_contestant_body_content_class'));    
				} 
			}  
		}
		
		
		
		public function wpvc_votes_contestant_content_update(){
			$desc_rs = WPVC_Vote_Shortcode_Model::wpvc_voting_get_contestant_desc();
			if($desc_rs[0]->admin_view == "Y"){        
				$post_id = get_the_ID();
				$post_content = get_post($post_id);
				$vote_content ='<div class="vote_content"> 
						 '.wpautop($post_content->post_content).'
						</div>';			  
				return $vote_content;
			}
		}
		
		public function wpvc_vote_contestant_body_content_class($single){
			$option = get_option(WPVC_VOTES_SETTINGS);
			require_once(WPVC_VIEW_FRONT_PATH.'wpvc_voting_single_contestant_view.php');
			ob_start();
			wpvc_voting_single_contestant_view($option);
			return ob_get_clean();
		}
		
	
		public static function wpvc_vote_previous_post_link($format='&laquo; %link', $link='%title', $in_same_cat = false, $excluded_categories = '') {
			WPVC_Vote_Single_Contestants::wpvc_votes_post_next_previous_link($format, $link, $in_same_cat, $excluded_categories, true);
		}
  
  
		public static function wpvc_votes_next_post_link($format='%link &raquo;', $link='%title', $in_same_cat = false, $excluded_categories = ''){
			WPVC_Vote_Single_Contestants::wpvc_votes_post_next_previous_link($format, $link, $in_same_cat, $excluded_categories, false);
		}


		public static function wpvc_votes_post_next_previous_link($format, $link, $in_same_cat, $excluded_categories = '', $previous){
			if ( $previous && is_attachment() ){
				$post = get_post( get_post()->post_parent );
			}else{
				$post = WPVC_Vote_Single_Contestants::wpvc_votes_get_adjacent_post( $in_same_cat, $excluded_categories, $previous );
			}     
			if ( ! $post ) {
				$output = '';
			} else {
				$title = $post->post_title;
	
				if ( empty( $post->post_title ) )
					$title = $previous ? __( 'Previous Post','voting-contest' ) : __( 'Next Post','voting-contest' );
					
				$title = apply_filters( 'the_title', $title, $post->ID );
				$date = mysql2date( get_option( 'date_format' ), $post->post_date );
				$rel = $previous ? 'prev' : 'next';
				$rel_lr = $previous ? 'left' : 'right';
				$string = '<a href="' . get_permalink( $post ) . '" rel="'.$rel.'">';
				$inlink = str_replace( '%title', $title, $link );
				$inlink = str_replace( '%date', $date, $inlink );        
				$inlink = $string .'<span class="wpvc_vote_icons votecontestant-chevron-'.$rel_lr.' votecontestant-next-prev"></span></a>';
		   
				$output = str_replace( '%link', $inlink, $format );
			}
			$adjacent = $previous ? 'previous' : 'next';
			echo apply_filters( "{$adjacent}_post_link", $output, $format, $link, $post );
		}
		
		public static function wpvc_votes_get_adjacent_post( $in_same_cat, $excluded_categories, $previous) {
			$result = WPVC_Vote_Shortcode_Model::wpvc_votes_get_adjacent_post_model($in_same_cat, $excluded_categories, $previous );
			if ( null === $result )
				$result = '';
			if(isset($query_key))
			wp_cache_set($query_key, $result, 'counts');
    
			if ( $result )
				$result = get_post( $result );
			return $result;
		}
		
				
	}
}else
die("<h2>".__('Failed to load the Voting Single Contestant Controller','voting-contest')."</h2>");

return new WPVC_Vote_Single_Contestants();
