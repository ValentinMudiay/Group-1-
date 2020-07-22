<?php
if(!function_exists('wpvc_taxonomy_vote_view')){
    function wpvc_taxonomy_vote_view($values){
        
    wp_enqueue_script( 'jquery-ui-datepicker' );
    
    wp_register_style('wpvc_jquery_ui', WPVC_ASSETS_CSS_PATH . 'jquery-ui.css');
    wp_enqueue_style( 'wpvc_jquery_ui');
    
	wp_register_script('wpvc_votes_taxonomy', WPVC_ASSETS_JS_PATH . 'wpvc_vote_taxonomy.js');
	wp_enqueue_script('wpvc_votes_taxonomy',array('jquery'));

	$shwpvc_desc_option = array(
			    '-1'        => 'None',
			    'grid' => 'Grid View',
			    'list' => 'List View',
			    'both'      => 'Both'
			    );
    ?>
	<table class="form-table">
		
	   <input type="hidden" name="votes_category_settings" id="votes_category_settings" value="1">
       
	    <tr valign="top">
			<th scope="row"><label for="votes_starttime"><?php _e('Select Start Date: ','voting-contest'); ?></label></th>
			<td>
				<input type="text" name="votes_starttime" id="votes_starttime" value="<?php  echo $values['start_time']; ?>" autocomplete="off" />
				<input class="button cleartime clearstarttime" type="button" value="Clear"/>
				<br/><span class="description"><p><i><?php _e('Default: No Start Date','voting-contest'); ?></i></p></span>
			</td>
		</tr>
	    <tr valign="top">
			<th scope="row"><label for="votes_expiration"><?php _e('Select End Date: ','voting-contest'); ?></label></th>
			<td>
				<input type="text" name="votes_expiration" id="votes_expiration" value="<?php  echo $values['expiration']; ?>"  autocomplete="off" />
				<input class="button cleartime clearendtime" type="button" name="no_expiration" id="no_expiration" value="Clear"/>
				<br/><span class="description"><p><i><?php _e('Default: No Expiration','voting-contest'); ?></i></p></span>
			</td>
	    </tr>
        
		<tr valign="top">
			<th scope="row"><label for="middle_custom_navigation"><?php _e('Set Gallery Button Link: ','voting-contest'); ?></label></th>
			<td>
			   <input type="text" name="middle_custom_navigation" id="middle_custom_navigation" value="<?php  echo $values['options']['middle_custom_navigation']; ?>"/>
				<span style="display: none;color:red;" id="erro_valid_url"><?php _e('Enter Valid URL','voting-contest'); ?></span>
				<br/><span class="description"><p><?php _e('Enter the URL of this contests main page','voting-contest');?></p></span>
			 </td>
		</tr>
       <?php $vote_contest_rules = isset($values['options']['vote_contest_rules'])?$values['options']['vote_contest_rules']:''; ?>
		<tr valign="top">
			<th scope="row"><label for="vote_contest_rules"><?php _e('Rules & Prizes:','voting-contest'); ?></label></th>
			<td>
			<?php wp_editor(html_entity_decode($vote_contest_rules), 'contest-rules', array()); ?>
			<br/><span class="description"> <p><?php _e('Description of Rules and prizes','voting-contest');?></p></span>
			</td>
        </tr>
        
               
	
    </table>
    
    <?php echo wpvc_category_settings(); ?>

<?php
    }
}else
die("<h2>".__('Failed to load the Voting Taxonomy view','voting-contest')."</h2>");
?>