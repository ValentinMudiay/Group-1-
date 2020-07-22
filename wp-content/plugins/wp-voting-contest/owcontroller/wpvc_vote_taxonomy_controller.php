<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if(!class_exists('WPVC_Vote_Taxonomy_Controller')){
    class WPVC_Vote_Taxonomy_Controller{
	
	public function __construct(){
	    add_filter("manage_edit-". WPVC_VOTES_TAXONOMY ."_columns", array($this,'wpvc_add_new_votestax_column'));
	    add_action('manage_' . WPVC_VOTES_TAXONOMY . '_custom_column', array($this,'wpvc_custom_new_votestax_column'), 10, 3);
	    
	    //Taxonomy Custom fields
	    add_action(WPVC_VOTES_TAXONOMY . '_add_form_fields', array($this,'wpvc_taxonomy_voting_fields'));
	    add_action(WPVC_VOTES_TAXONOMY . '_edit_form', array($this,'wpvc_taxonomy_voting_fields'));
	    
	    //Save values of taxonomy
	    add_action('created_term',  array($this,'wpvc_votes_taxonomy_custom_save'));
	    add_action('edit_term', array($this,'wpvc_votes_taxonomy_custom_save'));
	    add_action('delete_term',array($this,'wpvc_votes_taxonomy_custom_delete'));
	}
	
	public function wpvc_add_new_votestax_column(){
	    wp_register_style('WPVC_ADMIN_STYLES', WPVC_ASSETS_ADMIN_CSS_PATH);
	    wp_enqueue_style('WPVC_ADMIN_STYLES');
	    
	    $add_columns['cb'] = '<input type="checkbox" />';
	    $add_columns['id'] = __('ID', 'voting-contest');
		$add_columns['shortcode'] = __('Shortcode', 'voting-contest');	
	    $add_columns['starttime'] = __('Start Time', 'voting-contest');
	    $add_columns['expiry'] = __('End Time', 'voting-contest');
	    $add_columns['name'] = __('Name', 'voting-contest');
	    $add_columns['description'] = __('Description', 'voting-contest');
	    $add_columns['slug'] = __('Slug', 'voting-contest');
	    $add_columns['posts'] = __('Voting Contest', 'voting-contest');
	    return $add_columns;
	}
	
	public function wpvc_custom_new_votestax_column($out, $column_name, $theme_id){
	    $theme = get_term($theme_id, 'votes');
	    switch ($column_name) {
		case 'id':				
			$out .= $theme_id;
		break;
		case 'shortcode':				
			$out .= "[showcontestants id=".$theme_id."]";
		break;
		case 'expiry':
			$expoption  = get_option($theme_id . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);		
			if(isset($expoption) && $expoption != '0' && $expoption){
				$votes_expiration = date('m-d-Y H:i:s', strtotime(str_replace('-', '/', $expoption )));
			}else{
				$votes_expiration = 'No Expiration';
			}
			$out .= $votes_expiration;
		break;
		case 'starttime':
			$startoption  = get_option($theme_id . '_' . WPVC_VOTES_TAXSTARTTIME);		
			if(isset($startoption) && $startoption != '0' && $startoption){
				$starttime = date('m-d-Y H:i:s', strtotime(str_replace('-', '/', $startoption )));
			}else{
				$starttime = 'Not Set';
			}
			$out .= $starttime;
		break;
		default:
		break;
	    }
	    return $out; 
	}
	
	public function wpvc_taxonomy_voting_fields(){
	    require_once(WPVC_VIEW_PATH.'wpvc_taxonomy_view.php');
	    
	     
	    $votes_expiration = $votes_starttime =  ''; 
	    $option = array('imgdisplay' => NULL,
			    'termdisplay' => NULL,
			    'middle_custom_navigation'=>NULL,
			    'votecount'=>NULL,
			    'shwpvc_description'=>WPVC_VOTES_SHWPVC_DESC,
			    'vote_count_per_contest'=>1
			    );
	    
	    //Edit form values 
	    if(isset($_REQUEST['tag_ID'])) {
		$curterm = $_REQUEST['tag_ID'];
		$option = get_option($curterm . '_' . WPVC_VOTES_SETTINGS);
		$expoption  = get_option($curterm . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);		
		$votes_starttime = get_option($curterm . '_' . WPVC_VOTES_TAXSTARTTIME);
		if(isset($votes_starttime) && $votes_starttime != '0' && $votes_starttime){
		    $votes_starttime = date('m-d-Y', strtotime(str_replace('-', '/', $votes_starttime )));
		}
	    }
	    if(isset($expoption) && $expoption != '0' && $expoption){
			$votes_expiration = date('m-d-Y', strtotime(str_replace('-', '/', $expoption )));
	    }
	    
	    $values = array('expiration'=>$votes_expiration,
			    'start_time'=>$votes_starttime,'options'=>$option
			);
	    
	    wpvc_taxonomy_vote_view($values);
	}
	
	public function wpvc_votes_taxonomy_custom_save($ID){
	    
	    if(isset($_POST['votes_category_settings'])){
			$curterm = $ID;			
			$middle_custom_navigation = isset($_POST['middle_custom_navigation'])?$_POST['middle_custom_navigation']:'';
			$contest_rules = isset($_POST['contest-rules'])?htmlentities(stripslashes($_POST['contest-rules'])):'';
			$args = array(							
				'imgdisplay' => 'on',				
				'termdisplay' => 'on',
				'total_vote_count' => 'on',
				'top_ten_count'=>'on',			
				'imgcontest' => 'photo',
				'vote_count_per_contest' => 1,
				'middle_custom_navigation'=>$middle_custom_navigation,				
				'vote_contest_rules'=>$contest_rules,
			);		
			update_option($curterm . '_' . WPVC_VOTES_SETTINGS, $args);
			$votes_expiration = $votes_starttime  = NULL;
			if(isset($_POST['votes_expiration']) && $_POST['votes_expiration'] != '0' && trim($_POST['votes_expiration'])){
				$votes_expiration = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['votes_expiration'] ))); 
			}
			if(isset($_POST['votes_starttime']) && $_POST['votes_starttime'] != '0' && trim($_POST['votes_starttime'])){
				$votes_starttime = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $_POST['votes_starttime'] )));
			}
			
			update_option($curterm . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD, $votes_expiration);
			update_option($curterm . '_' . WPVC_VOTES_TAXSTARTTIME, $votes_starttime);			
	    }
	}
	
	public function wpvc_votes_taxonomy_custom_delete()
	{
	    if(isset($_REQUEST['tag_ID'])) {
		    $curterm = $_REQUEST['tag_ID'];
		    if(get_option($curterm . '_' . WPVC_VOTES_SETTINGS)){
			    delete_option($curterm . '_' . WPVC_VOTES_SETTINGS);
		    }
		    delete_option($curterm . '_' . WPVC_VOTES_TAXEXPIRATIONFIELD);
		    delete_option($curterm . '_' . WPVC_VOTES_TAXACTIVATIONLIMIT);
		    delete_option($curterm . '_' . WPVC_VOTES_TAXSTARTTIME);
	    }
	}
	
    }
}else
die("<h2>".__('Failed to load Voting Taxonomy Controller','voting-contest')."</h2>");

return new WPVC_Vote_Taxonomy_Controller();
