jQuery(document).ready(function($){

    // Scroll Function here
    $.fn.cgGoTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 30+'px'
        }, 'fast');
        return this; // for chaining...
    }

		  $("#cg_user_login_div").show();  // Document is ready

		  // Objekt wird so festgelegt um später angezielt zu werden
		  /*var $mail = $(".cg_user_registry_instant_mail_check");

		$(".cg_main-mail").keyup(function() {
			 // Man könnte hier auch direkt die objektschreibweise $(".cg_main-mail") anwenden
			$mail.val( this.value );
		});*/



$(document).on('click', '#cg_user_login_check', function(e){
	//	e.preventDefault();

    var $form = $(this).closest('form');
    var $field = $(this);

    //alert(cg_main_mail);
    $form.find('.cg_form_div').removeClass('cg_form_div_error');
    $form.find('.cg_input_error').addClass('cg_hide').empty();

	$('#cg_append_login_name_mail_fail').empty();
	$('#cg_append_login_password_fail').empty();

	var check = 0;

		$( "#cg_login_name_mail" ).each(function( i ) {

			var cg_login_name_mail = $(this).val();
			var cg_language_EmailRequired = $("#cg_language_EmailRequired").val();


				if(cg_login_name_mail.length==0){

					$(this).parent().find('#cg_append_login_name_mail_fail').removeClass('cg_hide').append(cg_language_EmailRequired);
					check = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
					e.preventDefault();
				}

		});

		$( "#cg_login_password" ).each(function( i ) {

			var cg_login_password = $(this).val();
			var cg_language_PasswordRequired = $("#cg_language_PasswordRequired").val();

				if(cg_login_password.length==0){

					$(this).parent().find('#cg_append_login_password_fail').removeClass('cg_hide').append(cg_language_PasswordRequired);
					check = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
					e.preventDefault();
				}

		});

		if(check==1){
			$(".cg_form_div_error").cgGoTo();
		}


		// AJAX Action
		if(check==0){

			$("#cg_message").empty();

			var cg_check = $("#cg_login_check").val();
			var cg_login_name_mail = $( "#cg_login_name_mail" ).val();
			var cg_login_password = $( "#cg_login_password" ).val();
			var cg_gallery_id_login = $( "#cg_gallery_id_login" ).val();
			//alert(cg_check);
			//alert(cg_login_name_mail);
			//alert(cg_login_password);
			//var cg_plugins_url = $( "#cg_plugins_url" ).val();
		//	var loadingSource = cg_plugins_url+"/admin/users/css/loading.gif";

			//$("#cg_message").append("<img id='#cg_message_img' src='"+loadingSource+"' width='22px' height='22px' style='display:inline;'>");

		//	 $("#cg_message_img").load(function(){$(this).toggle();});

			 //$("#ipm_input_name").val('');
            //$("#ipm_input_check").prop('checked',false);
            var inputValue = $field.val();

            contGallSubmitLoaderShow($,$field);

            //e.preventDefault();
			jQuery.ajax({
				//url : cg_site_url+"/wp-admin/admin-ajax.php",
				url : post_cg_login_wordpress_ajax_script_function_name.cg_login_ajax_url,
				type : 'post',
				data : {
					action : 'post_cg_login',
					action1 : cg_login_name_mail,
					action2 : cg_login_password,
					action3 : cg_check,
					action4 : cg_gallery_id_login
					},
				async: false,	// Ganz wichtig! Führt die Operation live aus. Nicht asynchron!
				}).done(function(response) {

                    jQuery("#cg_message").html( response );
                    //var script = jQuery(response).text();
                    // eval(script);

            }).fail(function(xhr, status, error) {

            	var test = 1;

                }).always(function() {

                var test = 1;

            });


            contGallSubmitLoaderShow($,$field);

			if(document.readyState === "complete"){
				var cg_check_mail_name_value = $("#cg_check_mail_name_value").val();// Wird auf 1 gesetzt wenn Login Daten unkorrekt
				if(cg_check_mail_name_value==1){
                    contGallSubmitLoaderHide($,$field,inputValue);
                    $("#cg_check_mail_name_value").val(0);
					e.preventDefault();
				}
				else{
					var cg_ForwardAfterLoginUrlCheck = $("#cg_ForwardAfterLoginUrlCheck").val();
					if(cg_ForwardAfterLoginUrlCheck==1){
						e.preventDefault();
						var cg_ForwardAfterLoginUrl = $("#cg_ForwardAfterLoginUrl").val();
						window.location.href = cg_ForwardAfterLoginUrl;
					}
				}
			}

		}

});


});