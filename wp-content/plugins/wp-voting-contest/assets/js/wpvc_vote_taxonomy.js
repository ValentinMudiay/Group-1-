
jQuery(document).ready(function(){
    
    jQuery('#votes_starttime').datepicker({
		dateFormat:'mm-dd-yy',		
		maxDate:jQuery('#votes_expiration').val()?jQuery('#votes_expiration').val():""		
    });
    jQuery('#votes_expiration').datepicker({
		dateFormat:'mm-dd-yy',		
		minDate:jQuery('#votes_starttime').val()?jQuery('#votes_starttime').val():""
    });
    
    jQuery('.clearstarttime').click(function() {
		jQuery('#votes_starttime').val('');
    });
    
    jQuery('.clearendtime').click(function() {
		jQuery('#votes_expiration').val('');
    });
    jQuery('.shwpvc_image_man').not( "#edit_image_man" ).hide();
    jQuery('#imgcontest').change(function() {
	
        
        if(jQuery(this).val() == 'music'){
            jQuery('.shwpvc_music_man').show();
        }
        else{
            jQuery('.shwpvc_music_man').hide();
        }
		
		if(jQuery(this).val() == 'video' || jQuery(this).val() == 'music' || jQuery(this).val() == 'essay'){
			jQuery('.shwpvc_image_man').show();
		}else{
			jQuery('.shwpvc_image_man').hide();
		}
    });
    
    jQuery('#tax_activationcount').keyup(function () { 
		this.value = this.value.replace(/[^0-9\.]/g,'');
	}); 

    jQuery("#middle_custom_navigation").keydown(function(){
		if(validateURL(jQuery(this).val())){
			jQuery('#erro_valid_url').hide();
		}else{
			jQuery('#erro_valid_url').show();
		}
    });
    
    jQuery('form').submit(function(){
		var middle_navigat =  jQuery('#middle_custom_navigation').val();
		jQuery('#erro_valid_url').hide();
		if (middle_navigat!='') {	 
			if(validateURL(jQuery('#middle_custom_navigation').val())){
				return true;
			}else{
				jQuery('#erro_valid_url').show();
				return false;
			}
		}else
		return true;
    });   
    
});
	
function validateURL(textval) {
    var urlregex = new RegExp(
	  "^(http|https|ftp)\://([a-zA-Z0-9\.\-]+(\:[a-zA-Z0-9\.&amp;%\$\-]+)*@)*((25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9])\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[1-9]|0)\.(25[0-5]|2[0-4][0-9]|[0-1]{1}[0-9]{2}|[1-9]{1}[0-9]{1}|[0-9])|([a-zA-Z0-9\-]+\.)*[a-zA-Z0-9\-]+\.(com|edu|gov|int|mil|net|org|biz|arpa|info|name|pro|aero|coop|museum|[a-zA-Z]{2}))(\:[0-9]+)*(/($|[a-zA-Z0-9\.\,\?\'\\\+&amp;%\$#\=~_\-]+))*$");
    return urlregex.test(textval);
}