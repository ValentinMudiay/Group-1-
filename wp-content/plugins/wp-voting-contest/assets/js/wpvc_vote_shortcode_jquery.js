jQuery(document).ready(function(){	
	 
	//Make the listing page title and right side content fix to the width
	wpvc_votes_list_page_shwpvc_contest();
	//Count down timer
	votes_countdown('.wpvc_countdown_dashboard');
	//Sorting filter
	wpvc_vote_sorting_filter();
	//Grid view function
	wpvc_vote_shwpvc_contest_grid_function();
	//List view function
	wpvc_vote_shwpvc_contest_list_function();
	//Pagination ajax
	wpvc_vote_pagination_click_function();
	wpvc_vote_pagination_change_function();
	//Add contestant validate the custom fields
	wpvc_vote_add_contestant_function();
	//Login/Registration form functionalities
	wpvc_vote_submit_user_form();
	//Gallery on show contestant
	wpvc_pretty_photo_gallery();
	//vote function
	wpvc_vote_click_function();
				
	//Single contestant page
	wpvc_single_contestant_function();
	wpvc_single_contestant_pretty();
	
	//Success Message Check
	wpvc_success_message();
		
	
	//Single page share url copy text function start
	function copyToClipboard(elem) {
		  // create hidden text element, if it doesn't already exist
		var targetId = "_hiddenCopyText_";
		var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
		var origSelectionStart, origSelectionEnd;
		if (isInput) {
			// can just use the original source element for the selection and copy
			target = elem;
			origSelectionStart = elem.selectionStart;
			origSelectionEnd = elem.selectionEnd;
		} else {
			// must use a temporary form element for the selection and copy
			target = document.getElementById(targetId);
			if (!target) {
				var target = document.createElement("textarea");
				target.style.position = "absolute";
				target.style.left = "-9999px";
				target.style.top = "0";
				target.id = targetId;
				document.body.appendChild(target);
			}
			target.textContent = elem.textContent;
		}
		// select the content
		var currentFocus = document.activeElement;
		target.focus();
		target.setSelectionRange(0, target.value.length);
		
		// copy the selection
		var succeed;
		try {
			  succeed = document.execCommand("copy");
		} catch(e) {
			succeed = false;
		}
		// restore original focus
		if (currentFocus && typeof currentFocus.focus === "function") {
			currentFocus.focus();
		}
		
		if (isInput) {
			// restore prior selection
			elem.setSelectionRange(origSelectionStart, origSelectionEnd);
		} else {
			// clear temporary content
			target.textContent = "";
		}
		return succeed;
	}
	
	var copiedurl = document.getElementById("wpvc_vote_share_url_copy");
	if(copiedurl) {
		document.getElementById("wpvc_vote_share_url_copy").addEventListener("focus", function() {
			copyToClipboard(document.getElementById("wpvc_vote_share_url_copy"));
			jQuery("#wpvc_vote_share_url_copy").select();
			jQuery(".copied_message span").slideDown("slow");
			setTimeout(function() {
				jQuery(".copied_message span").slideUp("slow");
			}, 3000);
		});
	}
	//Single page share url copy text function end
	
		
		
	jQuery(document).on('change','#wpvc_tax_select',function(e){
		var contest_id = jQuery(this).val();		
		var insert_param = wpvc_insertParam('wpvc_cont',contest_id);
		var url = document.URL;
		var shortUrl=url.substring(0,url.lastIndexOf("/page/"));
		window.location.href = shortUrl + '?' + insert_param;
	});	
	
	
	jQuery(document).on('change','#wpvc_sort_select',function(e){
		var wpvc_sort = jQuery(this).val(); 
		if(wpvc_sort !== 'Sort'){
			var insert_param = wpvc_insertParam('wpvc_sort',wpvc_sort);
			var url = document.URL;
			var shortUrl=url.substring(0,url.lastIndexOf("/page/"));
			window.location.href = shortUrl + '?' + insert_param;
		}
		
	});
	
	function wpvc_insertParam(key, value)
	{
		key = encodeURI(key); value = encodeURI(value);	
		var kvp = document.location.search.substr(1).split('&');	
		var i=kvp.length; var x; while(i--) {
			x = kvp[i].split('=');			
			if (x[0]==key)
			{
				x[1] = value;
				kvp[i] = x.join('=');
				break;
			}
		}	
		if(i<0) {kvp[kvp.length] = [key,value].join('=');}	
		//this will reload the page, it's likely better to store this until finished
		return kvp.join('&');
		//document.location.search = kvp.join('&'); 
	}
	
	function wpvc_preview_img(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();						
			reader.onload = function (e) {
				jQuery('#uploaded_img').attr('src', e.target.result);
				jQuery('#uploaded_img').show();
			}						
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	jQuery(document).on('click','.wpvc_tog',function(e){
		e.preventDefault();
		if (jQuery(".wpvc_vote_shwpvc_contestants .wpvc_vote_menu_links").is(':hidden')) {
			jQuery(".wpvc_vote_shwpvc_contestants .wpvc_vote_menu_links").attr("style", "display: block !important");
			jQuery(".wpvc_tog a.togglehide span.wpvc_vote_icons").addClass('menu_open');
		}
		else{
			jQuery(".wpvc_vote_shwpvc_contestants .wpvc_vote_menu_links").attr("style", "display: none !important");
			jQuery(".wpvc_vote_shwpvc_contestants .wpvc_tog a.togglehide span.wpvc_vote_icons").removeClass('menu_open');
		}
		if (jQuery(".wpvc_vote_single_section .wpvc_vote_menu_links").is(':hidden')) {
			jQuery(".wpvc_vote_single_section .wpvc_vote_menu_links").attr("style", "display: block !important");
			jQuery(".wpvc_tog a.togglehide span.wpvc_vote_icons").addClass('menu_open');	
		}
		else{
			jQuery(".wpvc_vote_single_section .wpvc_vote_menu_links").attr("style", "display: none !important");
			jQuery(".wpvc_vote_single_section .wpvc_tog a.togglehide span.wpvc_vote_icons").removeClass('menu_open');
		}
	});
	
	
	jQuery(document).on('click','.wpvc_tabs_register',function (e){
		jQuery('.wpvc_tabs_login_content').hide();
		jQuery('.wpvc_tabs_register_content').show();
		jQuery('.forgot-panel').hide();
		
		jQuery( ".inner-container" ).removeClass('login-panel_add');
		jQuery( ".inner-container" ).removeClass('register-panel_add'); 
		jQuery( ".inner-container" ).removeClass('forgot-panel_add'); 
	        jQuery( ".inner-container" ).addClass('register-panel_add');
		
		
		jQuery( this ).addClass('active');
		jQuery( '.wpvc_tabs_login' ).removeClass('active');
		
	    
	});
	jQuery(document).on('click','.wpvc_tabs_login,.wpvc_tabs_already,.wpvc_votebutton',function (e){
		jQuery('.wpvc_tabs_login_content').show();
		jQuery('.wpvc_tabs_register_content').hide();
		jQuery( ".inner-container" ).removeClass('login-panel_add');
		jQuery( ".inner-container" ).removeClass('register-panel_add'); 
		jQuery( ".inner-container" ).removeClass('forgot-panel_add'); 
		jQuery( ".inner-container" ).addClass('login-panel_add');
		
		jQuery( '.wpvc_tabs_login' ).addClass('active');
		jQuery( '.wpvc_tabs_register' ).removeClass('active');
	});
	
	//On Page Load
	var windwpvc_width = jQuery(window).width();
	if (windwpvc_width < 600) {
		wpvc_change_grid_list(windwpvc_width);
	}
	
	jQuery(window).resize(function () {
		var windwpvc_width = jQuery(window).width();
		wpvc_change_grid_list(windwpvc_width);		
	});
	
	
	function wpvc_change_grid_list(windwpvc_width){
		if (windwpvc_width < 600) {
			jQuery(".wpvc_views_container").each(function(){
				//Show In List When It is Video Contest Else Show in GRID
				if (jQuery(this).hasClass('wpvc_video_contest')) {
					var wpvc_views_container = jQuery(this).attr('id');				
					var res = wpvc_views_container.split("wpvc_views_container_");
					var term_id = res[1];
					wpvc_shwpvc_contest_list(term_id);
				}
				else{
					var wpvc_views_container = jQuery(this).attr('id');				
					var res = wpvc_views_container.split("wpvc_views_container_");
					var term_id = res[1];
					wpvc_shwpvc_contest_grid(term_id);					
				}
				jQuery('li.wpvc_vote_float_right').hide();
			});			
		}
		else{
			jQuery('.wpvc_vote_list_shwpvc_contest').click();
			jQuery('li.wpvc_vote_float_right').show();			
		}
	}
	
	jQuery(document).on({		
		mouseenter : function(){
			var cont_id = jQuery(this).attr('data-vote-id');
			var win_width = jQuery( window ).width();
			if( win_width > '450'){
				var width = jQuery('#wpvc_image_responsive'+cont_id).width();
				var height = jQuery('#wpvc_image_responsive'+cont_id).height();
				jQuery('.wpvc_overlay_bg').css("width",width);
				jQuery('.wpvc_overlay_bg').css("height",height);
			}else{
				var width = jQuery('#wpvc_image_responsive'+cont_id).data('mob');
				var height = 'auto';
				jQuery('.wpvc_vote_showcontent_view').css("width",width);
				jQuery('.wpvc_overlay_bg').css("width",width);
				jQuery('.wpvc_img_class').css("width",width);
			}
			jQuery('.wpvc_overlay_'+cont_id).css('opacity','1');
			jQuery( '.wpvc_overlay_'+cont_id).children().addClass('wpvc_overlay_bg_bottom_0',{duration:500});
			
		},mouseleave : function(){
			var cont_id = jQuery(this).attr('data-vote-id');
			jQuery('.wpvc_overlay_'+cont_id).css('opacity','0');
			jQuery( '.wpvc_overlay_'+cont_id).children().removeClass('wpvc_overlay_bg_bottom_0',{duration:500});
		}
        }, 'a.wpvc_hover_image');
		
				
		resize_window();
		jQuery( window ).resize(function() {
			resize_window();
		});
});

function resize_window(){
	var win_width = jQuery( window ).width();
	if( win_width <= '450'){
		var width = jQuery('.wpvc_overlay_bg').data('mob');
		var height = 'auto';
		if(width!==''){
			jQuery('.wpvc_vote_showcontent_view').css("width",width);
			jQuery('.wpvc_overlay_bg').css("width",width);
			jQuery('.wpvc_img_class').css("width",width);
		}
	}else{
		var widths = jQuery('.wpvc_vote_img_wdth').val();
		jQuery('.wpvc_vote_showcontent_view').css("width",'');
		jQuery('.wpvc_overlay_bg').css("width",'');
		jQuery('.wpvc_img_class').css("width",widths);
		
	}
}

	function wpvc_single_contestant_function(){
		jQuery(document).on('click','.wpvc_share_click_expand',function(e){
			if(jQuery('.wpvc_total_share_single').is(':hidden')) {
				jQuery('.wpvc_vote_share_shrink').addClass('active');
				jQuery('.wpvc_total_share_single').show();
			}else{
				jQuery('.wpvc_vote_share_shrink').removeClass('active');
				jQuery('.wpvc_total_share_single').hide();
			}
		});
		
	}
	
	function wpvc_single_contestant_pretty() {
		jQuery('.single_contestant_pretty').wpvc_vote_prettyPhoto({
			hook:'data-vote-gallery',
			markup: wpvc_pretty_photo_theme_markupp(),
			social_tools: false,
			deeplinking: false,
			shwpvc_title: true,
			theme:'pp_kalypso',  
			changepicturecallback: function(wpvc_vote_id,wpvc_term_id)
			{                    
				
				var votes_counter = jQuery('.votes_count_single'+wpvc_vote_id).html();
				var get_html_count = "";var get_vote_btn = "";
				
				var wpvc_vote_button = jQuery('.wpvc_votes_btn_single'+wpvc_vote_id).html();
				
				if (wpvc_vote_button != undefined) {	
					var get_vote_btn = "<div class='wpvc_pp_vote_btn_single'>"+wpvc_vote_button+'</div>';
				}				
				
				if (votes_counter != undefined) {					
					var get_html_count = "<div class='wpvc_pp_vote_count'>"+votes_counter+'</div>';
				}				
				var get_html_pretty = jQuery('.wpvc_pretty_content_social'+wpvc_vote_id).html();
				
				if (get_html_pretty != undefined) {
					jQuery('.pp_social').html(get_html_count+get_vote_btn+get_html_pretty);
					jQuery('.pp_pic_holder').css('margin-top','20px');
					jQuery('.pp_social').css('margin-right','20px');
					
				}
			}                   	                            		
		});
	}
	
	function wpvc_vote_add_contestant_function() {
		//jQuery('.add_form_contestant_wpvc_vote').hide();
		
		jQuery(document).on('click','.wpvc_vote_submit_entry',function(e){

			var voter_submitter = jQuery('.voter_submitter').val();

			//Check If User is voter or submitter
			if(voter_submitter == 0){
				jQuery.fancybox.open(
				'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">Submitting Not Allowed</h2>'+
				'<div class="wpvc_vote_fancybox_result"><div class="owt_danger"><i class="wpvc_vote_icons voteconestant-warning"></i>Submitting Contestants Not Allowed for Voter</div></div>',
				{
					'padding':0,	
					'width':500,
					'height':280,
					'maxWidth': 500,
					'maxHeight': 280,
					'minWidth': 350,
					'minHeight': 220
				});
				return false;
			}

			var form_shwpvc_logged = jQuery(this).hasClass( "wpvc_logged_in_enabled" );
			if (!form_shwpvc_logged) {		
				var term_id = jQuery(this).attr('data-id');
				var close_button_text = jQuery('.close_btn_text'+term_id).val();
				var open_button_text = jQuery('.open_btn_text'+term_id).val();
				var _self = jQuery(this);
				
				if(jQuery('.wpvc_form_add-contestants'+term_id).is(':visible'))
					jQuery('.wpvc_form_add-contestants'+term_id).slideToggle('slow', function(){
						_self.html(open_button_text);	
					});
				else{
					
					jQuery('.wpvc_contestants-success').hide();
					jQuery('.wpvc_form_add-contestants'+term_id).slideToggle('slow', function(){
						_self.html('X '+close_button_text );	
					});
				}
			}else{
				wpvc_vote_ppOpen('#wpvc_vote_login_panel', '300',1);
				
				//Tab in the Login Popup
				jQuery('.wpvc_tabs_login_content').show();
				jQuery('.wpvc_tabs_register_content').hide();
				jQuery( '.wpvc_tabs_login' ).addClass('active');
			}
		});
		
	}
	
	//Sorting filter
	function wpvc_vote_sorting_filter(){
		jQuery('.wpvc_vote_filter_votes').change(function(){
			var term_id = jQuery(this).attr('id');
			var view = jQuery('.wpvc_vote_view_'+term_id).attr('data-view');
			jQuery('#wpvc_filter_view'+term_id).val(view);
			jQuery('#wpvc_vote_select_filter'+term_id).submit();
		});
	}
	
	//Grid view click function
	function wpvc_vote_shwpvc_contest_grid_function(){		
		jQuery(document).on('click','.wpvc_vote_grid_shwpvc_contest',function(e){
			var term_id = jQuery(this).attr('data-id');
			wpvc_shwpvc_contest_grid(term_id);
		});
	}
	
	function wpvc_shwpvc_contest_grid(term_id){
		var shwpvc_desc = jQuery('.wpvc_shwpvc_description'+term_id).val();
		jQuery('.wpvc_vote_view_'+term_id).attr('data-view','grid');
		jQuery('.wpvc_right_dynamic_content'+term_id).removeAttr('style');	
		//Remove list functionalities
		jQuery('#list_show'+term_id).removeClass('wpvc_list_active');
		jQuery('.wpvc_vote_view_'+term_id).removeClass('wpvc_vote_list');
		jQuery('.wpvc_list_title'+term_id).hide();		
		jQuery('.custom_field_entry_'+term_id+'.list').html('');
		jQuery('.custom_field_entry_'+term_id).removeClass('list');

		//Add Grid to the html
		var width_img = jQuery('.wpvc_vote_img_width'+term_id).val();
		jQuery('.wpvc_right_dynamic_content'+term_id).css('width',width_img+'px');
		jQuery('#grid_show'+term_id).addClass('wpvc_grid_active');
		jQuery('.wpvc_vote_view_'+term_id).addClass('wpvc_vote_grid');
		jQuery('.wpvc_grid_title'+term_id).show();
		jQuery('.custom_field_entry_'+term_id).addClass('grid');
		
		var post_ids = new Array();
		jQuery('.custom_field_entry_'+term_id).each(function (index, value) {
			if(jQuery(this).children().length <= 0){
				post_id = jQuery(this).attr('data-post_id');
				post_ids.push(post_id);
			}
		});
		if (post_ids.length >= 1)
		{
			jQuery.ajax({
			   url: vote_path_local.votesajaxurl,
			   data:{
				action:'voting_load_custom_fields',			
				cat_id:term_id,
				post_idds : post_ids,
				wpvc_view:'grid'
			   },
			   type: 'POST',
			   cache: false,
			   dataType: 'json',
			   success: function( response ) {				
					if(response!==''){
						jQuery('.custom_field_entry_'+term_id).each(function (index, value) {
							if(jQuery(this).children().length <= 0){
								post_id = jQuery(this).attr('data-post_id');
								jQuery(this).html(response[post_id]);
							}
						});
					}
			   }	
			});
		}
		//jQuery('.wpvc_grid_only').show();
		
		if(shwpvc_desc=='grid' || shwpvc_desc=='both')
			jQuery('.wpvc_shwpvc_desc_view_'+term_id).show();
		else
			jQuery('.wpvc_shwpvc_desc_view_'+term_id).hide();
			
		var title_alocation = jQuery('.wpvc_title_alocation_description'+term_id).val();
		if (title_alocation=='on') {
			var wpvc_image_contest = jQuery('.wpvc_image_contest'+term_id).val();
			if (wpvc_image_contest=='photo') {
				jQuery('.wpvc_vote_showcontent_'+term_id).each(function(){
					var check_content = jQuery(this).find('.wpvc_vote_title_content'+term_id).hasClass("wpvc_vote_title_added"+term_id);
					if (!check_content) {
						jQuery(this).find(".vote_left_sid"+term_id).before("<div class='title_trnc_grid"+term_id+"'>"+jQuery(this).find('.wpvc_vote_title_content'+term_id).html()+"</div>");
						jQuery(this).find('.wpvc_vote_title_content'+term_id).hide();
						jQuery(this).find('.wpvc_vote_title_content'+term_id).addClass('wpvc_vote_title_added'+term_id);
					}
				});
			}
		}else{
			var wpvc_image_contest = jQuery('.wpvc_image_contest'+term_id).val();
			if (wpvc_image_contest=='video') {
				jQuery('.wpvc_vote_showcontent_'+term_id).each(function(){
					var check_content = jQuery(this).find('.wpvc_vote_title_content'+term_id).hasClass("wpvc_vote_title_added"+term_id);
					if (!check_content) {
						jQuery(this).find(".video_contest_desc"+term_id).after("<div class='title_trnc_grid"+term_id+"'>"+jQuery(this).find('.wpvc_vote_title_content'+term_id).html()+"</div>");
						jQuery(this).find('.wpvc_vote_title_content'+term_id).hide();
						jQuery(this).find('.wpvc_vote_title_content'+term_id).addClass('wpvc_vote_title_added'+term_id);
					}
				});
			}else if (wpvc_image_contest=='music') {
				jQuery('.wpvc_vote_showcontent_'+term_id).each(function(){
					var check_content = jQuery(this).find('.wpvc_vote_title_content'+term_id).hasClass("wpvc_vote_title_added"+term_id);
					if (!check_content) {
						jQuery(this).find(".wpvc_msc_content"+term_id).after("<div class='title_trnc_grid"+term_id+"'>"+jQuery(this).find('.wpvc_vote_title_content'+term_id).html()+"</div>");
						jQuery(this).find('.wpvc_vote_title_content'+term_id).hide();
						jQuery(this).find('.wpvc_vote_title_content'+term_id).addClass('wpvc_vote_title_added'+term_id);
					}
				});
			}
		}	
		
	}
	
	//List view click function
	function wpvc_vote_shwpvc_contest_list_function(){		
		jQuery(document).on('click','.wpvc_vote_list_shwpvc_contest',function(e){
			var term_id = jQuery(this).attr('data-id');
			wpvc_shwpvc_contest_list(term_id);
			wpvc_votes_list_page_shwpvc_contest();
		});
	}
	
	function wpvc_shwpvc_contest_list(term_id) {
		var shwpvc_desc = jQuery('.wpvc_shwpvc_description'+term_id).val();
		jQuery('.wpvc_vote_view_'+term_id).attr('data-view','list');
		//Remove grid functionalities
		jQuery('#grid_show'+term_id).removeClass('wpvc_grid_active');
		jQuery('.wpvc_vote_view_'+term_id).removeClass('wpvc_vote_grid');
		jQuery('.wpvc_grid_title'+term_id).hide();
		jQuery('.custom_field_entry_'+term_id+'.grid').html('');
		jQuery('.custom_field_entry_'+term_id).removeClass('grid');

		//Add List to the html
		jQuery('#list_show'+term_id).addClass('wpvc_list_active');
		jQuery('.wpvc_right_dynamic_content'+term_id).css('width','auto');
		jQuery('.wpvc_vote_view_'+term_id).addClass('wpvc_vote_list');
		jQuery('.wpvc_list_title'+term_id).show();
		jQuery('.custom_field_entry_'+term_id).addClass('list');
		
		var post_ids = new Array();
		jQuery('.custom_field_entry_'+term_id).each(function (index, value) {
			if(jQuery(this).children().length <= 0){
				post_id = jQuery(this).attr('data-post_id');
				post_ids.push(post_id);
			}
		});
		if (post_ids.length >= 1)
		{
			jQuery.ajax({
			   url: vote_path_local.votesajaxurl,
			   data:{
				action:'voting_load_custom_fields',			
				cat_id:term_id,
				post_idds : post_ids,
				wpvc_view:'list'
			   },
			   type: 'POST',
			   cache: false,
			   dataType: 'json',
			   success: function( response ) {				
					if(response!==''){
						jQuery('.custom_field_entry_'+term_id).each(function (index, value) {
							if(jQuery(this).children().length <= 0){
								post_id = jQuery(this).attr('data-post_id');
								jQuery(this).html(response[post_id]);
							}
						});
					}
			   }	
			});
		}
				
		if((shwpvc_desc=='list') || (shwpvc_desc=='both'))
			jQuery('.wpvc_shwpvc_desc_view_'+term_id).show();
		else
			jQuery('.wpvc_shwpvc_desc_view_'+term_id).hide();
		
		var title_alocation = jQuery('.wpvc_title_alocation_description'+term_id).val();
		if (title_alocation=='on') {
			var wpvc_image_contest = jQuery('.wpvc_image_contest'+term_id).val();
			if (wpvc_image_contest=='photo') {
				jQuery('.wpvc_vote_showcontent_'+term_id).each(function(){
					jQuery(this).find('.title_trnc_grid'+term_id).remove();
					jQuery(this).find('.wpvc_vote_title_content'+term_id).show();
					jQuery(this).find('.wpvc_vote_title_content'+term_id).removeClass('wpvc_vote_title_added'+term_id);
				});
			}
		}else{
			var wpvc_image_contest = jQuery('.wpvc_image_contest'+term_id).val();
			if (wpvc_image_contest=='video') {
				jQuery('.wpvc_vote_showcontent_'+term_id).each(function(){
					jQuery(this).find('.title_trnc_grid'+term_id).remove();
					jQuery(this).find('.wpvc_vote_title_content'+term_id).show();
					jQuery(this).find('.wpvc_vote_title_content'+term_id).removeClass('wpvc_vote_title_added'+term_id);
				});
			}else if (wpvc_image_contest=='music') {
				jQuery('.wpvc_vote_showcontent_'+term_id).each(function(){
					jQuery(this).find('.title_trnc_grid'+term_id).remove();
					jQuery(this).find('.wpvc_vote_title_content'+term_id).show();
					jQuery(this).find('.wpvc_vote_title_content'+term_id).removeClass('wpvc_vote_title_added'+term_id);
				});
			}
		}
		
	}
	
	//Pagination ajax
	function wpvc_vote_pagination_click_function(){
		jQuery(document).on('click', '.wpvc_votes-pagination a',function(e){
			
			var all_contest_page = jQuery('#all_contest_page').val();
			if(all_contest_page == "1"){				
				return;
			}
			
			e.preventDefault();
			
			var term_id = jQuery(this).parent().attr('id');
			var view = jQuery('.wpvc_vote_view_'+term_id).attr('data-view');
			var link = jQuery(this).attr('href');
						
			
			jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_block({
				message: '<img src="'+vote_path_local.vote_image_url+'wait_please.gif" />', 
				overlayCSS: { 
				backgroundColor: '#fff', 
				opacity:         0.6 
				}
			});
			jQuery('.wpvc_vote_view_'+term_id).load(link+' .wpvc_contest-posts-container'+term_id,function(){
				if (view=='list') {
					wpvc_shwpvc_contest_list(term_id);
					wpvc_votes_list_page_shwpvc_contest();
				}else{
					wpvc_shwpvc_contest_grid(term_id);
				}
				
				//Gallery on show contestant
				wpvc_pretty_photo_gallery();
				
				jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_unblock();
				jQuery('html,body').animate({
					scrollTop: jQuery('.wpvc_vote_view_'+term_id).offset().top},
					'slow');
				
				
				jQuery(window).owllazyLoadXT();
			});
			
			
		resize_window();	
		});
	}
		
	function wpvc_vote_pagination_change_function() {
		jQuery(document).on('change','.wpvc_votes-pagination select', function(e){
			
			var all_contest_page = jQuery('#all_contest_page').val();
			if(all_contest_page == "1"){
				var url      = jQuery(this).val();
				window.location.href = url;
				return;
			}
			
			e.preventDefault();
			
			var term_id = jQuery(this).attr('class');
			var view = jQuery('.wpvc_vote_view_'+term_id).attr('data-view');
			var link = jQuery(this).val();
			
						
			jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_block({
				message: '<img src="'+vote_path_local.vote_image_url+'wait_please.gif" />', 
				overlayCSS: { 
				backgroundColor: '#fff', 
				opacity:         0.6 
				}
			});
			jQuery('.wpvc_vote_view_'+term_id).load(link+' .wpvc_contest-posts-container'+term_id,function(){
				if (view=='list') {
					wpvc_shwpvc_contest_list(term_id);
					wpvc_votes_list_page_shwpvc_contest();
				}else{
					wpvc_shwpvc_contest_grid(term_id);
				}
				//Gallery on show contestant
				wpvc_pretty_photo_gallery();
				jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_unblock();
				jQuery('html,body').animate({
					scrollTop: jQuery('.wpvc_vote_view_'+term_id).offset().top},
					'slow');
				
				
				jQuery(window).owllazyLoadXT();
			});
		});
		resize_window();
	}
	
	
	function wpvc_votes_list_page_shwpvc_contest(){
		jQuery('.wpvc_vote_showcontent_view').each(function(){
			var term_id = jQuery(this).attr('data-id');
			var view = jQuery('.wpvc_vote_view_'+term_id).attr('data-view');
			var shwpvc_desc = jQuery('.wpvc_shwpvc_description'+term_id).val();
			
			if (view=='list') {
				var main_div_width = parseInt(jQuery(this).width());
				var image_width = parseInt(jQuery('.wpvc_vote_img_width'+term_id).val());
				if (image_width=='') {
					image_width = parseInt(jQuery('.wpvc_vote_img_style'+term_id).width());
				}
				var pixels = ((image_width/main_div_width)*100)-100;
				pixels = Math.abs(pixels)-0.12;
				if (!isNaN(pixels)) {
					//jQuery('.wpvc_right_dynamic_content'+term_id).css('width',Math.abs(pixels)+'%');	
				}
			}else{
				var image_width = parseInt(jQuery('.wpvc_vote_img_width'+term_id).val());
				if (image_width=='') {
					image_width = parseInt(jQuery('.wpvc_vote_img_style'+term_id).width());
				}
				
				if(jQuery(this).hasClass( "wpvc_video_get" )){
					image_width=jQuery(this).find('iframe').width();
					if (jQuery.trim(image_width)=='') {
						image_width=jQuery('.wpvc_video_get').width();
					}
				}
				
				
				if (!isNaN(image_width)) {
					jQuery(this).find('.wpvc_right_dynamic_content'+term_id).css('width',Math.abs(image_width)+'px');	
				}			
				
			}
			
			if((shwpvc_desc==view) || (shwpvc_desc=='both'))
				jQuery('.wpvc_shwpvc_desc_view_'+term_id).show();
			else
				jQuery('.wpvc_shwpvc_desc_view_'+term_id).hide();
			
			
		});
	}
	
	//Contestant validation
	function add_contestant_validation(term_id,title_error_message) {
		jQuery('.wpvc_form_add-contestants'+term_id).wpvc_vote_validate({
			wpvc_vote_rules: {
			'contestant-title': "required",
			},
			wpvc_vote_messages: {
			'contestant-title': title_error_message,
			}
		});
		
	}
	
	function add_contestant_validation_method(id_validate,message) {
		jQuery(document).ready(function(){
			jQuery("#"+id_validate).wpvc_vote_rules( "add", {
				required:true,                                
				wpvc_vote_messages:{
					required:message
				}
			});
		});
	}
	
	function add_contestant_validation_method_file(id_validate,message,size = "") {				
		jQuery(document).ready(function(){		
			if(size != 0){						
			jQuery("#"+id_validate).wpvc_vote_rules( "add", {
				required:true,        
				maxFileSize: {
                        "unit": "MB",
                        "size": size
                    },
			});
			}
			else{
				add_contestant_validation_method(id_validate,message)
			}
		});
	}
	
	
	jQuery(document).on('change','.wpvc_checkbox_restrict', function(){		
		var thislinked = this.id;		
		vote_restrict_extension(jQuery('.'+thislinked)[0]);		
		return false;
	});
	
	function vote_restrict_extension(thislinked){			
		var vote_id = jQuery(thislinked).attr('data-vote-id');				
		var wpvc_restriction_count = jQuery('#wpvc_restriction_count').val();				
		var checkbox_count = jQuery('.wpvc_checkbox_restrict:checked').size();
															
		if(parseInt(checkbox_count) == parseInt(wpvc_restriction_count)){			
			jQuery('html,body').animate({
				scrollTop: jQuery(".wpvc_restrict_description").offset().top},
			'slow');					 
		}
		else if(parseInt(checkbox_count) > parseInt(wpvc_restriction_count)){
			jQuery('#wpvc_restrict_'+vote_id).prop('checked', false);
		}
		
		var wpvc_restriction_count = jQuery('#wpvc_restriction_count').val();
		var vote_cookie_count = jQuery('#vote_cookie_count').val();
		var checkbox_count = jQuery('.wpvc_checkbox_restrict:checked').size();
		
		var total_vote_count = parseInt(vote_cookie_count)+	parseInt(checkbox_count);
		
		
		if(vote_cookie_count >= wpvc_restriction_count || total_vote_count > wpvc_restriction_count){
			jQuery.fancybox.open(
				'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">Voting Not Allowed</h2>'+
				'<div class="wpvc_vote_fancybox_result"><div class="owt_danger"><i class="wpvc_vote_icons voteconestant-warning"></i>More than '+wpvc_restriction_count+' votes not allowed</div></div>',
				{
					'padding':0,	
					'width':500,
					'height':280,
					'maxWidth': 500,
					'maxHeight': 280,
					'minWidth': 350,
					'minHeight': 220
				});
			jQuery('.wpvc_button_all').hide();
			//setTimeout(function(){ window.location.replace(wpvc_restrict_redirect); }, 2000);
			return false;					
		}
		else if(total_vote_count == wpvc_restriction_count){
			jQuery('html,body').animate({
				scrollTop: jQuery(".wpvc_restrict_description").offset().top},
			'slow');
			jQuery('.wpvc_button_all').show();
				
		}
		return false;
	}
	
	//Vote click function
	function wpvc_vote_click_function() {
		jQuery(document).on('click','a.wpvc_votebutton', function(){
			
			//Vote Restrict Extension
			if(jQuery(this).hasClass('wpvc_vote_restriction')){	
				var vote_id = jQuery(this).attr('data-vote-id');
				
				if(jQuery('#wpvc_restrict_'+vote_id)[0].checked === true){ 
					jQuery('#wpvc_restrict_'+vote_id).prop('checked', false);
				}else{			
					jQuery('#wpvc_restrict_'+vote_id).prop('checked', true);
				}				
				vote_restrict_extension(this);		
				return false;
			}

			var voter_submitter = jQuery('.voter_submitter').val();

			//Check If User is voter or submitter
			if(voter_submitter == 1){
				jQuery.fancybox.open(
				'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">Voting Not Allowed</h2>'+
				'<div class="wpvc_vote_fancybox_result"><div class="owt_danger"><i class="wpvc_vote_icons voteconestant-warning"></i>Voting Not Allowed for Contestant Submitter</div></div>',
				{
					'padding':0,	
					'width':500,
					'height':280,
					'maxWidth': 500,
					'maxHeight': 280,
					'minWidth': 350,
					'minHeight': 220
				});
				return false;
			}

			var link_clicked  = this;
			var form_shwpvc_logged = jQuery(this).hasClass( "wpvc_logged_in_enabled" );
			var wpvc_voting_email = jQuery(this).hasClass( "wpvc_voting_email" );
			var wpvc_voting_grab = jQuery(this).hasClass( "wpvc_voting_grab" );
			
			var term_id = jQuery(link_clicked).attr('data-term-id');
			var wpvc_contest_closed = jQuery('#wpvc_contest_closed_'+term_id).val();
			
			if (wpvc_voting_email || wpvc_voting_grab) {
				if(form_shwpvc_logged && wpvc_contest_closed!='start'){
					wpvc_vote_ppOpen('#wpvc_vote_login_panel', '300',1);
				}
				else{
					var term_id = jQuery(link_clicked).attr('data-term-id');
					var vote_id = jQuery(link_clicked).attr('data-vote-id');
					var wpvc_contest_closed = jQuery('#wpvc_contest_closed_'+term_id).val();
					
					if (wpvc_contest_closed == 'start') {						
						jQuery.fancybox.open(
							'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">Processing...</h2>'+
							'<div class="wpvc_vote_fancybox_result"></div>',
							{
								'padding':0,	
								'width':500,
								'height':280,
								'maxWidth': 500,
								'maxHeight': 280,
								'minWidth': 350,
								'minHeight': 220
							});
						
						jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_unblock();
						jQuery('.wpvc_vote_fancybox_result').css("background","none");
						jQuery('.wpvc_vote_fancybox_result_header').html('Restricted');
						jQuery('.wpvc_vote_fancybox_result').html("<div class='owt_danger'><i class='wpvc_vote_icons voteconestant-warning'></i>"+jQuery('.wpvc_contest_closed_desc').val()+"</div>");
						var get_html_pretty = jQuery('.wpvc_fancy_content_social'+vote_id).html();
						if(get_html_pretty !== undefined){
							jQuery('.wpvc_vote_fancybox_result').append("Share with your Friends");
							jQuery('.wpvc_vote_fancybox_result').append("<div class='wpvc_fancy_content_social'>"+get_html_pretty+"</div>");
						}
				
						return false;
					}					
					else{
						wpvc_vote_ppOpen('#wpvc_vote_email_panel', '300',1);
						window.link_btn = link_clicked;
						return false;
					}
					
					
				}
			}			
			vote_button_function(link_clicked,form_shwpvc_logged);
			
		});
	}
	
	
	//Vote Button Function
	function vote_button_function(link_clicked,form_shwpvc_logged){		
		if (!form_shwpvc_logged) {
			
			//BuyVotes Extension Patch
			if(jQuery(link_clicked).hasClass('wpvc_buy_votes')){
				wpvc_buy_votes_func(link_clicked);
				return false;
			}
			
			var term_id = jQuery(link_clicked).attr('data-term-id');
			var vote_id = jQuery(link_clicked).attr('data-vote-id');
			
			var enc_term_id = jQuery(link_clicked).attr('data-enc-id');
			var enc_vote_id = jQuery(link_clicked).attr('data-enc-pid');
			
			var votes_count = jQuery(link_clicked).attr('data-vote-count');
			
			var today= new Date();
			var current_time  = today.toUTCString();
			var gmt_offset = today.getTimezoneOffset();
			var cur_timeinfo = new Array();
			
			jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_block({
				message: '<img src="'+vote_path_local.vote_image_url+'wait_please.gif" />', 
				overlayCSS: { 
				backgroundColor: '#fff', 
				opacity:         0.6 
				}
			});
			//console.log(link_clicked);
			jQuery.ajax({
			   url: vote_path_local.votesajaxurl,
			   data:{
				action:'wpvc_save_votes',			
				pid:enc_vote_id,
				termid: enc_term_id,
				current_time:current_time,
				gmt_offset:gmt_offset,
				votes_count:votes_count
			   },
			   type: 'GET',
			   cache: false,
			   dataType: 'jsonp',
			   beforeSend:function(){
				
				jQuery.fancybox.open('<div class="message"><div class="wpvc_vote_fancybox_result"><div class="wpvc_vote_fancybox_result_loader">Processing...</div></div></div>');
				
			   },
			   success: function( result ) {
				
				jQuery('.wpvc_vote_view_'+term_id).wpvc_vote_unblock();  
				
				if(result.success==1){
					jQuery('.wpvc_vote_count'+vote_id).text(result.votes);
					jQuery('.votes_count_single_count'+vote_id).text(result.votes);
					//Based on frequency
					if (result.button_flag==1) {
						jQuery('.voter_a_btn_term'+term_id).each(function(){
							var voting_type= jQuery(this).attr('data-voting-type');
							if (voting_type==0) {
								jQuery('.votr_btn_cont'+vote_id).text('Voted');
								jQuery('.voter_btn_term'+term_id).text('Voted');
								
								jQuery('.voter_a_btn_term'+term_id).each(function(){
									var new_vote_id = jQuery(this).attr('data-vote-id');
									if (new_vote_id==vote_id) {
										jQuery(this).addClass('wpvc_voting_green_button');	
									}else
									jQuery(this).addClass('wpvc_voting_grey_button');
								});
							}else if (voting_type==1 || voting_type==2) {
								if (voting_type==1)
								jQuery('.votr_btn_cont'+vote_id).text('Voted');
								var count_frequency = jQuery(this).attr('data-frequency-count');
								var total_count_voted = jQuery(this).attr('data-current-user-votecount');
								var total_count_votes = parseInt(total_count_voted) + parseInt(1);
								jQuery(this).attr('data-current-user-votecount',total_count_votes);
								var new_vote_id = jQuery(this).attr('data-vote-id');
								if (new_vote_id==vote_id) {
									if (voting_type==1)
									jQuery(this).addClass('wpvc_voting_green_button');	
								}
								if (new_vote_id==vote_id){
									jQuery(this).removeClass('wpvc_voting_grey_button');
								}
							}
						});
						
					}else if(result.button_flag==2){
						
						if (result.frequency==1) {
							jQuery('.voter_a_btn_term'+term_id).each(function(){
								var voting_type= jQuery(this).attr('data-voting-type');
								if (voting_type==0) {
									jQuery('.votr_btn_cont'+vote_id).text('Voted');
									jQuery('.voter_btn_term'+term_id).text('Voted');
									
									jQuery('.voter_a_btn_term'+term_id).each(function(){
										var new_vote_id = jQuery(this).attr('data-vote-id');
										if (new_vote_id==vote_id) {
											jQuery(this).addClass('wpvc_voting_green_button');	
										}else
										jQuery(this).addClass('wpvc_voting_grey_button');
									});
								}else if (voting_type==1 || voting_type==2) {
									jQuery('.votr_btn_cont'+vote_id).text('Voted');
									var count_frequency = jQuery(this).attr('data-frequency-count');
									var total_count_voted = jQuery(this).attr('data-current-user-votecount');
									var total_count_votes = parseInt(total_count_voted) + parseInt(1);
									jQuery(this).attr('data-current-user-votecount',total_count_votes);
									var new_vote_id = jQuery(this).attr('data-vote-id');
									if (new_vote_id==vote_id) {
										if (voting_type==1)
										jQuery(this).addClass('wpvc_voting_green_button');
										if (voting_type==2)
										jQuery(this).addClass('wpvc_voting_green_button');
									}
									if (new_vote_id==vote_id){
										jQuery(this).removeClass('wpvc_voting_grey_button');
									}
								}
							});
						}
						if (result.frequency==0) {
							jQuery('.voter_a_btn_term'+term_id).each(function(){
								var voting_type= jQuery(this).attr('data-voting-type');
								if (voting_type==0) {
									jQuery('.voter_a_btn_term'+term_id).each(function(){
										var new_vote_id = jQuery(this).attr('data-vote-id');
										if (new_vote_id==vote_id) {
											jQuery(this).addClass('wpvc_voting_green_button');	
										}else{
											jQuery('.voter_btn_term'+term_id).text('Voted');
											jQuery(this).addClass('wpvc_voting_grey_button');
										}
									});
								}
							});
						}
						if (result.frequency==2) {
							jQuery('.voter_a_btn_term'+term_id).each(function(){
								var voting_type= jQuery(this).attr('data-voting-type');
								if (voting_type==0) {
									jQuery('.voter_a_btn_term'+term_id).each(function(){
										var new_vote_id = jQuery(this).attr('data-vote-id');
										if (new_vote_id==vote_id) {
											jQuery(this).addClass('wpvc_voting_green_button');	
										}else{
											jQuery('.voter_btn_term'+term_id).text('Voted');
											jQuery(this).addClass('wpvc_voting_grey_button');
										}
									});
								}
								else if (voting_type==1 || voting_type==2) {
									jQuery('.votr_btn_cont'+vote_id).text('Voted');
									var count_frequency = jQuery(this).attr('data-frequency-count');
									var total_count_voted = jQuery(this).attr('data-current-user-votecount');
									var total_count_votes = parseInt(total_count_voted) + parseInt(1);
									jQuery(this).attr('data-current-user-votecount',total_count_votes);
									var new_vote_id = jQuery(this).attr('data-vote-id');
									if (new_vote_id==vote_id) {
										if (voting_type==1)
										jQuery(this).addClass('wpvc_voting_green_button');
										if (voting_type==2)
										jQuery(this).addClass('wpvc_voting_green_button');
									}
									if (new_vote_id==vote_id){
										jQuery(this).removeClass('wpvc_voting_grey_button');
									}
								}
							});
						}
					}
					
				}
				
				
				//Check Counter class exists and show the Total Votes count - Shortcode : owtotalvotes
				var istotalcounter = document.getElementsByClassName('wpvc_total_counter');
				if (istotalcounter.length > 0) {
					//Get Total Votes						
					jQuery.ajax({
						url: vote_path_local.votesajaxurl,
						data:{
						 action:'owtotalvotes',			 
						},
						type: 'GET',
						cache: false,														
						success: function( result ) {
							jQuery('.wpvc_total_counter').html(result);
						}
					});
				}
				
				jQuery('.wpvc_vote_fancybox_result').css("background","none");
				jQuery('.wpvc_vote_fancybox_result_header').html(result.msg);
				jQuery('.wpvc_vote_fancybox_result').html(result.msg_html); 
				var get_html_pretty = jQuery('.wpvc_fancy_content_social'+vote_id).html();
				if(get_html_pretty !== undefined){
					jQuery('.wpvc_vote_fancybox_result').append("Share with your Friends");
					jQuery('.wpvc_vote_fancybox_result').append("<div class='wpvc_fancy_content_social'>"+get_html_pretty+"</div>");
				}
			   }	
			});
			return false;
		}else{
			wpvc_vote_ppOpen('#wpvc_vote_login_panel', '300',1);
		}
	}
	
	//Timer votes
	function votes_countdown(el) {
		var countdown = jQuery(el); 
		if (!countdown.length) return false;
			countdown.each(function(i, e) {
				var timer 	= jQuery(this).data('datetimer').split("-");
				var currenttimer = jQuery(this).data('currenttimer').split("-");
				jQuery(this).wpvc_vote_countDown({
					omitWeeks: false, 
					targetDate: {					
						'year':     timer[0],
						'month':    timer[1],
						'day':      timer[2],
						'hour':     timer[3],
						'min':      timer[4],
						'sec':      timer[5]
					},
					currentDate: {					
						'year':     currenttimer[0],
						'month':    currenttimer[1],
						'day':      currenttimer[2],
						'hour':     currenttimer[3],
						'min':      currenttimer[4],
						'sec':      currenttimer[5]
					},
					onComplete: function() {
						//console.log('Completed');
					}
				});
				countdown.css('visibility','visible');
			});
	}
	
	//PrettyPhoto
	function wpvc_vote_ppOpen(panel, width,flag){
		
		jQuery(function() { 
			jQuery('.date_picker').on('click', function () {
				jQuery(this).owvotedatetimepicker('destroy').owvotedatetimepicker({format:'m-d-Y',
				    step:10,
				    timepicker: false,}).focus();
			});
		});
		
		 if(panel=='#wpvc_vote_forgot_panel'){
			jQuery('.forgot-panel').show();
            jQuery( ".inner-container" ).removeClass('login-panel_add');
            jQuery( ".inner-container" ).removeClass('register-panel_add'); 
            jQuery( ".inner-container" ).removeClass('forgot-panel_add');  
            jQuery( ".inner-container" ).addClass('forgot-panel_add');  
        }else if(panel=='#wpvc_vote_login_panel'){
            jQuery( ".inner-container" ).removeClass('login-panel_add');
            jQuery( ".inner-container" ).removeClass('register-panel_add'); 
            jQuery( ".inner-container" ).removeClass('forgot-panel_add'); 
            jQuery( ".inner-container" ).addClass('login-panel_add');  
        }else if(panel=='#wpvc_vote_register_panel'){
            jQuery( ".inner-container" ).removeClass('login-panel_add');
            jQuery( ".inner-container" ).removeClass('register-panel_add'); 
            jQuery( ".inner-container" ).removeClass('forgot-panel_add'); 
            jQuery( ".inner-container" ).addClass('register-panel_add');
        }
		
		jQuery( ".error_empty" ).remove();		
		jQuery( ".voting_success" ).remove();
        
        if(jQuery('.pp_pic_holder').size() > 0){
            jQuery.wpvc_vote_prettyPhoto.close();
        }

        setTimeout(function() {
			jQuery.fn.wpvc_vote_prettyPhoto({
				social_tools: false,
				deeplinking: false,
				shwpvc_title: false,
				default_width: width,
				theme:'pp_kalypso'
			});
			jQuery.wpvc_vote_prettyPhoto.open(panel);
		}, 300);
	}
	
	//User registration and login	
	function wpvc_vote_submit_user_form(){
		jQuery(document).on('submit','.zn_form_login',function(event){
			event.preventDefault();
			
			var form = jQuery(this),
			warning = false,
			button = jQuery('.zn_sub_button',this),
			values = form.serialize();
			var get_reg_or_login = '';
			
			if(jQuery( ".inner-container" ).hasClass( "register-panel_add" )){
				get_reg_or_login='register';
				//Validation for custom fields 	
                jQuery('.required_vote_custom').filter(':visible').each(function(){  
                    var type_bos = jQuery(this).attr('type'); 
                    var in_id = jQuery(this).attr('id');
                    if(type_bos=='checkbox'){    
                          var in_idc = jQuery(this).attr('id');
                          if (jQuery('.reg_check_'+in_idc+':checked').length > 0){
                            jQuery('.'+in_idc).attr('style','');
                          }
                          else{
                            jQuery('.'+in_idc).attr('style','color:red');
                            warning = true;
                          }
                    }else if(type_bos=='radio'){
                        var in_ids = jQuery(this).attr('id');
                           if (jQuery('.reg_radio_'+in_ids+':checked').length > 0){
                              jQuery('.'+in_ids).attr('style',''); 
                           }else{
                              jQuery('.'+in_ids).attr('style','color:red');
                              warning = true;
                           }
                    }
                    else{
        				if ( !jQuery(this).val() ) { 
        				    jQuery(this).attr('style','border:1px solid red;');
                            warning = true;
        				}else{
        				   jQuery(this).attr('style','border:none;'); 
        				}
                    }
    			});            
            }else{
			  get_reg_or_login='login';
              jQuery('input',form).each(function(){
				if ( !jQuery(this).val() ) {
					warning = true;
				}
              });   
            }
			
			if( warning ) {
			     jQuery(".error_empty").remove();
    			 
                 if(jQuery( ".inner-container" ).hasClass( "register-panel_add" )){
    			     jQuery( ".m_title" ).after( "<p class='error_empty'>Please Fill In The Required Fields Below. </p>" );    
    			 }
                 if(jQuery( ".inner-container" ).hasClass( "login-panel_add" )){
    			     jQuery( ".m_title" ).after( "<p class='error_empty'>Please Enter The Username and Password. </p>" );    
    			 }
				button.removeClass('zn_blocked');
				return false;
			}
			if( button.hasClass('zn_blocked')) {
				return;
			}
			button.addClass('zn_blocked');

			jQuery.post(vote_path_local.votesajaxurl, values, function(resp) { 
			    jQuery(".error_empty").remove();
				var res = resp.split("~~");
				var data = jQuery(document.createElement('div')).html(res[1]);				
				if (get_reg_or_login=='login') {
					if (res[0]==1) {
						data.find('a').attr('onClick','wpvc_vote_ppOpen(\'#wpvc_vote_forgot_panel\', \'300\');return false;');
						jQuery('div.links', form).html(data);
						button.removeClass('zn_blocked');
					}else{						
						if (jQuery('.zn_login_redirect', form).length > 0) {
							jQuery.wpvc_vote_prettyPhoto.close();
							redirect = jQuery('.zn_login_redirect', form);
							href = redirect.val();
							if (jQuery('.wpvc_open_login_form').val() == 1) {								
								jQuery('.wpvc_open_login_form').val('0');
								jQuery('.wpvc_form_add-contestants'+window.contest_id).submit(); 
								return true;
							}
							else{
								window.location = href;
							}
						}
					}
				}else{
					if(res[0]==0){
							button.addClass('zn_blocked');
							
							jQuery.fancybox.open('<div class="message">'+
						'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">User Registration</h2>'+
						'<div class="wpvc_vote_fancybox_result"><div class="owt_success"><i class="wpvc_vote_icons voteconestant-warning"></i>Your account has been created and you will be now logged in</div></div></div>');
							
							
							if (jQuery('.wpvc_open_login_form').val() == 1) {
								jQuery('.wpvc_open_login_form').val('0');
								jQuery('.wpvc_form_add-contestants'+window.contest_id).submit(); 
								return false;
							}
							else{
								setTimeout(function() {
									jQuery.wpvc_vote_prettyPhoto.close();
									redirect = jQuery('.zn_login_redirect', form);
									href = redirect.val();
									window.location = href;
								}, 2000);
							}
						
					}
					else{
						button.removeClass('zn_blocked');
						
						jQuery.fancybox.open('<div class="message">'+
						'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">User Registration</h2>'+
						'<div class="wpvc_vote_fancybox_result"><div class="owt_danger"><i class="wpvc_vote_icons voteconestant-warning"></i>'+res[1]+'</div></div></div>');
						
					}
				}
			    return false;
				button.removeClass('zn_blocked');
			});
		});
		
		// LOST PASSWORD
		jQuery(document).on('submit','.zn_form_lost_pass',function(event){
			event.preventDefault();
			var form = jQuery(this),
			warning = false,
			button = jQuery('.zn_sub_button',this),
			values = form.serialize()+'&ajax_login=true';
			jQuery('input',form).each(function(){
				if ( !jQuery(this).val() ) {
					warning = true;
				}
			}); 
			if( warning ) {
			     jQuery(".error_empty").remove();
			     if(jQuery( ".inner-container" ).hasClass( "forgot-panel_add" )){
    			     jQuery( ".m_title" ).after( "<p class='error_empty'>Please Enter The Username / Email. </p>" );
    			 }
				button.removeClass('zn_blocked');
				return false;
			}
			if( button.hasClass('zn_blocked')) {
				return;
			}
			button.addClass('zn_blocked');
	        jQuery(".error_empty").remove();                        
			jQuery.ajax({
				url: form.attr('action'),
				data: values,
				type: 'POST',
				cache: false,
				success: function (resp) {
					var data = jQuery(document.createElement('div')).html(resp);
					
					jQuery('div.links', form).html('');
					
					if ( jQuery('#login_error', data).length ) {
					
						// We have an error
						var error = jQuery('#login_error', data);
						error.find('a').attr('onClick','ppOpen(\'#forgot_panel\', \'350\');return false;');
						jQuery('div.links', form).html(error);

					}
					else if ( jQuery('.message', data).length ) {
						var message = jQuery('.message', data);
						jQuery('div.links', form).html(message);
					}
					else {
					
						jQuery.prettyPhoto.close();
						redirect = jQuery('.zn_login_redirect', form);
						href = redirect.val();
						location.reload(true);
					}
					
					button.removeClass('zn_blocked');
				},
				error: function (jqXHR , textStatus, errorThrown ) {
					jQuery('div.links', form).html(errorThrown);

				}
			});
		});
		
		 // EMAIL - TWITTER LOGIN
		jQuery(document).on('submit','.zn_form_save_email',function(event){
			event.preventDefault();
		
			var form = jQuery(this),
				warning = false,
				button = jQuery('.zn_sub_button',this),
				values = form.serialize()+'&ajax_login=true&action=voting_save_twemail_session';   
                
			
			jQuery('input',form).each(function(){
				if ( !jQuery(this).val() ) {
					warning = true;
				}
			}); 
			
			if( warning ) {
			     jQuery(".error_empty").remove();
			     if(jQuery( ".inner-container" ).hasClass( "forgot-panel_add" )){
    			     jQuery( ".m_title" ).after( "<p class='error_empty'>Please Enter The Email. </p>" );
    			 }
				button.removeClass('zn_blocked');
				return false;
			}
			
			if( button.hasClass('zn_blocked')) {
				return;
			}
			
			button.addClass('zn_blocked');
	        jQuery(".error_empty").remove();                        
				jQuery.ajax({
				url: vote_path_local.votesajaxurl,
				data: values,
				type: 'POST',
				cache: false,
				success: function (resp) {
				    if(resp == 0){
				        jQuery( ".m_title" ).after( "<p class='error_empty'>Please Enter The Valid Email. </p>" );
                        button.removeClass('zn_blocked');
				    }
                    else{
                        jQuery(".error_empty").remove();
                        votes_twitter_authentication();
                    }
				},
				error: function (jqXHR , textStatus, errorThrown ) {
					jQuery('div.links', form).html(errorThrown);

				}
			});		 
			 
		});
		
		
		// EMAIL - Verification form
		jQuery(document).on('submit','.zn_email_verification',function(event){
			event.preventDefault();
			
			var form = jQuery(this),
				warning = false,
				button = jQuery('.zn_sub_button',this),
				values = form.serialize()+'&ajax_login=true&action=voting_email_verification';   
               			
			jQuery('input',form).each(function(){
				if ( !jQuery(this).val() ) {
					warning = true;
				}
			}); 
			
			if( warning ) {
			     jQuery(".error_empty").remove();
			     if(jQuery( ".inner-container" ).hasClass( "login-panel" )){
				jQuery( ".m_title_email" ).after( "<p class='error_empty'>Please Enter The Email. </p>" );
			     }
				button.removeClass('zn_blocked');
				return false;
			}
			
			if( button.hasClass('zn_blocked')) {
				return;
			}
			
			button.addClass('zn_blocked');
			jQuery(".error_empty").remove();                        
			jQuery.ajax({
				url: vote_path_local.votesajaxurl,
				data: values,
				type: 'POST',
				cache: false,
				success: function (resp) {
				    if(resp == 0){
				        jQuery( ".m_title_email" ).after( "<p class='error_empty'>Please Enter The Valid Email. </p>" );
						button.removeClass('zn_blocked');
				    }
				    else{
					jQuery(".error_empty").remove();
					jQuery(".voting_success").remove();
					jQuery(".wpvc_grab_email_send").after( "<p class='voting_success'>Email Verification Code Sent Successfully</p>" );
										
				    }
				},
				error: function (jqXHR , textStatus, errorThrown ) {
					jQuery('div.links', form).html(errorThrown);

				}
			});		 
			 
		});
		
		// EMAIL - Verification Code
		jQuery(document).on('submit','.zn_email_verification_code',function(event){
			event.preventDefault();
		
			var form = jQuery(this),
				warning = false,
				button = jQuery('.zn_sub_button',this),
				values = form.serialize()+'&ajax_login=true&action=voting_email_code';   
               			
			jQuery('input',form).each(function(){
				if ( !jQuery(this).val() ) {
					warning = true;
				}
			}); 
			
			if( warning ) {
			     jQuery(".error_empty").remove();
			     if(jQuery( ".inner-container" ).hasClass( "login-panel" )){
				jQuery( ".m_title_code" ).after( "<p class='error_empty'>Please Enter Valid Code. </p>" );
			     }
				button.removeClass('zn_blocked');
				return false;
			}
			
			if( button.hasClass('zn_blocked')) {
				return;
			}
			
			button.addClass('zn_blocked');
			jQuery(".error_empty").remove();                        
			jQuery.ajax({
				url: vote_path_local.votesajaxurl,
				data: values,
				type: 'POST',
				cache: false,
				success: function (resp) {
				    if(resp == 0){
				        jQuery( ".m_title_code" ).after( "<p class='error_empty'>Please Enter Valid Code. </p>" );
					button.removeClass('zn_blocked');
				    }
				    else{
					jQuery(".error_empty").remove();
					jQuery.wpvc_vote_prettyPhoto.close();
					vote_button_function(window.link_btn,"");									
				    }
				},
				error: function (jqXHR , textStatus, errorThrown ) {
					jQuery('div.links', form).html(errorThrown);

				}
			});		 
			 
		});
		
		// EMAIL Grab for IP and COOKIE
		jQuery(document).on('submit','.zn_email_grab',function(event){
			event.preventDefault();
		
			var form = jQuery(this),
				warning = false,
				button = jQuery('.zn_sub_button',this),
				values = form.serialize()+'&ajax_login=true&action=wpvc_voting_grab_email';   
               			
			jQuery('input',form).each(function(){
				if ( !jQuery(this).val() ) {
					warning = true;
				}
			}); 
			
			if( warning ) {
			     jQuery(".error_empty").remove();
			     if(jQuery( ".inner-container" ).hasClass( "login-panel" )){
				jQuery( ".m_title" ).after( "<p class='error_empty'>Please Enter Valid Email Address. </p>" );
			     }
				button.removeClass('zn_blocked');
				return false;
			}
			
			if( button.hasClass('zn_blocked')) {
				return;
			}
			
			button.addClass('zn_blocked');
			jQuery(".error_empty").remove();                        
			jQuery.ajax({
				url: vote_path_local.votesajaxurl,
				data: values,
				type: 'POST',
				cache: false,
				success: function (resp) {
				    if(resp == 0){
				        jQuery( ".m_title" ).after( "<p class='error_empty'>Please Enter Valid Email Address. </p>" );
						button.removeClass('zn_blocked');
				    }
				    else{
					jQuery(".error_empty").remove();
					jQuery.wpvc_vote_prettyPhoto.close();
					vote_button_function(window.link_btn,"");					
					jQuery(".wpvc_voting_verification").show();					
				    }
				},
				error: function (jqXHR , textStatus, errorThrown ) {
					jQuery('div.links', form).html(errorThrown);

				}
			});		 
			 
		});
		
	}
	
	
	function wpvc_pretty_photo_gallery(){
		var vote_prettyphoto_disable = jQuery('.vote_prettyphoto_disable').val();		
		if (vote_prettyphoto_disable == 1) {			
			jQuery('a[data-vote-gallery^=wpvc_vote_prettyPhoto]').wpvc_vote_prettyPhoto({
				hook:'data-vote-gallery',
				markup: wpvc_pretty_photo_theme_markupp(),
				social_tools: false,
				deeplinking: false,
				shwpvc_title: true,
				theme:'pp_kalypso',  
				changepicturecallback: function(wpvc_vote_id,wpvc_term_id)
				{
					//console.log(wpvc_vote_id);
					var get_html_pretty = jQuery('.wpvc_pretty_content_social'+wpvc_vote_id).html();
					jQuery('.pp_social').html(get_html_pretty);
					
				}                   	                            		
			});
		}
	}
	
	
	function wpvc_pretty_photo_theme_markupp() {
		window.markupp = '<div class="pp_pic_holder"> \
                \     <div class="pp_social"></div> \
    						<div class="ppt">&nbsp;</div> \
    						<div class="pp_top"> \
    							<div class="pp_left"></div> \
    							<div class="pp_middle"></div> \
    							<div class="pp_right"></div> \
    						</div> \
    						<div class="pp_content_container"> \
    							<div class="pp_left"> \
    							<div class="pp_right"> \
    								<div class="pp_content"> \
    									<div class="pp_loaderIcon"></div> \
    									<div class="pp_fade pp_single"> \
    										<a href="#" class="pp_expand" title="Expand the image">Expand</a> \
    										<div class="pp_hoverContainer"> \
    											<a class="pp_next" href="#">next</a> \
    											<a class="pp_previous" href="#">previous</a> \
    										</div> \
    										<div id="pp_full_res" class=""></div> \
    										<div class="pp_details"> \
    											<div class="pp_nav"> \
    												<a href="#" class="pp_arrwpvc_previous">Previous</a> \
    												<p class="currentTextHolder">0/0</p> \
    												<a href="#" class="pp_arrwpvc_next">Next</a> \
    											</div> \
    											<p class="pp_description"></p> \
                                                <p class="pp_mult_desc"></p> \
    											\
    											<a class="pp_close" href="#">Close</a> \
    										</div> \
    									</div> \
    								</div> \
    							</div> \
    							</div> \
    						</div> \
    						<div class="pp_bottom"> \
    							<div class="pp_left"></div> \
    							<div class="pp_middle"></div> \
    							<div class="pp_right"></div> \
    						</div> \                                                                                                                                                      </div> \
    					<div class="pp_overlay"></div>'; 
		
		return window.markupp;
	}
	
	function confirm_delete_single(vote_id)
	{
		var r = confirm(jQuery('#confirm_delete_single').val());
		if (r == true) {
		   jQuery("#delete_contestants"+vote_id).submit();
		   return true;
		} else {
		   return false;
		}
	}
	
	
	
	


function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}


function wpvc_success_message(){
	var wpvc_sucess_message = jQuery('#wpvc_sucess_message').val();
	var wpvc_sucess_approve = jQuery('#wpvc_sucess_approve').val();
	var social_share = "";
	var success = getUrlParameter('success');
	if (wpvc_sucess_message != undefined && success != undefined) {
		if(wpvc_sucess_approve != undefined && wpvc_sucess_approve != 0){			
			//Show Social Share buttons if Contestants is approved
			jQuery.ajax({
			   url: vote_path_local.votesajaxurl,
			   data:{
				action:'wpvc_social_share_icons',			
				post_id:wpvc_sucess_approve,
			   },
			   type: 'POST',
			   cache: false,
			   dataType: 'html',
			   success: function( response ) {				
										
					jQuery.fancybox.open('<div class="message">'+'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">Contestant Submission</h2>'+
			'<div class="wpvc_vote_fancybox_result"><div class="owt_success"><i class="wpvc_vote_icons voteconestant-success"></i>'+wpvc_sucess_message+'</div>'+response+'</div></div>');
					
					
			   }	
			}); 
		}
		else{
			//Do not Show Social Share buttons if Contestants is pending
			social_share = "";
		
			jQuery.fancybox.open('<div class="message">'+'<h2 class="wpvc_vote_fancybox_result_header" style="margin:10px 0  0 10px;font-size:inherit;">Contestant Submission</h2>'+
			'<div class="wpvc_vote_fancybox_result_submission"><div class="owt_success"><i class="wpvc_vote_icons voteconestant-success"></i>'+wpvc_sucess_message+'</div>'+social_share+'</div></div>');
			
		}
	
		
	}
}