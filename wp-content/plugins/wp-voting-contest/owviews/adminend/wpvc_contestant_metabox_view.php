<?php
if(!function_exists('wpvc_votes_count_metabox_view')){
    function wpvc_votes_count_metabox_view($cnt)
    {
	?>
	<h1> <?php echo  $cnt ? $cnt.' ' : '0'.' '; _e('Votes','voting-contest'); ?> </h1> 
	<?php $cnt = ($cnt == null)?0:$cnt; ?>
	<input type="hidden" value="<?php echo $cnt; ?>" name="votes_counter" />
	<?php  
    }
}else
die("<h2>".__('Failed to load Voting contestant count box view','voting-contest')."</h2>");


?>

