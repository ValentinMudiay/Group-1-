jQuery(document).ready(function($){


    // Scroll Function here
    $.fn.cgGoTo = function() {
        $('html, body').animate({
            scrollTop: $(this).offset().top - 40+'px'
        }, 'fast');
        return this; // for chaining...
    };

	// var countChildren = $('#cg_upload_form_container.cg_upload_form_container_shortcode_form').children().size()+1;
	 
	  $("#cg_upload_form_container.cg_upload_form_container_shortcode_form").each(function (index) {

	      if(index==0){
              $(this).css('visibility','visible');
          }else{
              $(this).remove();// remove forms might be rendered from other shortcodes
          }

      });

	/*I am not a robot captcha here*/

    // Prüfen der Wordpress Session id
    var check = $("#cg_check").val();
    $("#cg_captcha_not_a_robot_field").prepend("<input type='checkbox' class='cg_upload_form_field' id='cg_"+check+"' >");

var cgPreviewOnload = function (fileReaderBase64,index,$cg_upload_form_container) {

    fileReaderBase64.onload = function () {

        var base64url = this.result;

        setTimeout(function () {
            $cg_upload_form_container.find('.cg_form_div_image_upload_preview').find('#cg_form_div_image_upload_preview_div_container'+index).empty();
            $cg_upload_form_container.find('.cg_form_div_image_upload_preview #cg_form_div_image_upload_preview_div_container'+index).append(
                jQuery('<div class="cg_form_div_image_upload_preview_img" />').css({
                    'background': 'url("'+base64url + '") no-repeat center center',
                    'display': 'none'
                })
            );
            $cg_upload_form_container.find('.cg_form_div_image_upload_preview .cg_form_div_image_upload_preview_img').slideDown();
        },1000);

        // this.result.split('data:application/pdf;base64,')[1];
    };

};


/*
Notwendige Formularprüfung

1. Prüfen der Bilder

- Prüfen ob Bild ausgewählt wurde >>> submit
- Prüfen ob der Größe der Bilder in MB >>> change und submit
- Prüfen ob das berechtigte Bildformat übergeben wurde >>> change und submit
- Prüfen ob die Auflösung der Bilder zu hoch ist >>> change und submit


2. Prüfen der Textfelder
- Prüfen ob E-Mail richtig geschrieben wurde >>> submit
- Prüfen wie viel Buchstaben eingegeben worden sind >>> submit


*/

// 1. Prüfen der Bilder

//- Prüfen ob das berechtigte Bildformat übergeben wurde
//- Funktion bilden

var cgCheckPic = function(e,$imageUploadField) {


    $('#cg_input_image_upload_id').closest('.cg_form_div').removeClass('.cg_form_div_error');

    if(typeof $imageUploadField!=='undefined'){
        $imageUploadField.closest('.cg_form_div').find('.cg_input_error').addClass('cg_hide');
    }
//var filename = $('input[type=file]')[0].files[0].name;
var filename = $('input[type=file]#cg_input_image_upload_id').val().split('\\').pop();
var $cg_input_image_upload_id = $("#cg_input_image_upload_id");


if(!filename){

	var cg_no_picture_is_choosed = $("#cg_no_picture_is_choosed").val();
	$cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_no_picture_is_choosed+'');
    $("#cg_upload_form_e_prevent_default").val(1);
    $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
	 e.preventDefault();
	 
}
else{
	
	$('.cg_input_error_image_upload').empty();
	 
	var fileType = document.getElementById('cg_input_image_upload_id').files[0].type;
    var fileTypeEndingString= filename.split('.')[filename.split('.').length-1].toLowerCase();
    var allowedFileEndings = ['jpg','jpeg','gif','png'];

	var result = true;

	var restrictJpg = $("#restrictJpg").val();
	var restrictPng = $("#restrictPng").val();
	var restrictGif = $("#restrictGif").val();

	if (restrictJpg==1) {var MaxResJPGwidth = $("#MaxResJPGwidth").val();var MaxResJPGheight = $("#MaxResJPGheight").val();}
	if (restrictPng==1) {var MaxResPNGwidth = $("#MaxResPNGwidth").val();var MaxResPNGheight = $("#MaxResPNGheight").val();}
	if (restrictGif==1) {var MaxResGIFwidth = $("#MaxResGIFwidth").val();var MaxResGIFheight = $("#MaxResGIFheight").val();}


			if ((fileType != 'image/jpeg' && fileType != 'image/png' && fileType != 'image/gif') || allowedFileEndings.indexOf(fileTypeEndingString)==-1)
			{
				var cg_file_not_allowed = $("#cg_file_not_allowed").val();
				$cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_file_not_allowed+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
				e.preventDefault();
				result = false;
			}
		
			
			
	//- Prüfen ob das berechtigte Bildformat übergeben wurde   --- ENDE

	//- Prüfen ob der Größe der Bilder in MB	



	// Überprüfen ob der File größer ist als vorgegebene Uploadgröße

			var cg_shortcode_upload_form_upload_max_filesize = $("#cg_shortcode_upload_form_upload_max_filesize").val();
			var cg_shortcode_upload_form_upload_max_filesize_user_config = $("#cg_shortcode_upload_form_upload_max_filesize_user_config").val();

	//alert(cg_shortcode_upload_form_upload_max_filesize);
	//alert(cg_shortcode_upload_form_upload_max_filesize_user_config);
			// PHP ini configuration will be always prefered
			if(cg_shortcode_upload_form_upload_max_filesize < cg_shortcode_upload_form_upload_max_filesize_user_config){
				var upload_max_filesize = cg_shortcode_upload_form_upload_max_filesize;
			}
			else{
				var upload_max_filesize = cg_shortcode_upload_form_upload_max_filesize_user_config;
			}
			
			//alert(upload_max_filesize);
			// Wenn Null dann sozusagen unlimited
			if(upload_max_filesize==0){upload_max_filesize=cg_shortcode_upload_form_upload_max_filesize;}
	//alert(upload_max_filesize);


			//alert(upload_max_filesize);

				var file = $cg_input_image_upload_id[0].files[0];
				
				// alert('file: '+file);
				var sizePic = file.size;
				
				//Umwandeln in MegaByte
				sizePic = sizePic/1000000;
				
				
				// alert(all_files.length);
				//alert("Aktuelle Größe: "+sizePic);

				
				if (sizePic >= upload_max_filesize) {
				
				var cg_file_size_to_big = $("#cg_file_size_to_big").val();

				$cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_file_size_to_big+': '+upload_max_filesize+'MB');
                    $("#cg_upload_form_e_prevent_default").val(1);
                    $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
				 e.preventDefault();
                    result = false;
				
				}
		
	// Überprüfen ob der File größer ist als vorgegebene Uploadgröße --- ENDE 


	// Überprüfen ob Bulk Upload aktiviert ist und die Anzahl wieviel Bilder hochgeladen werden können

			var ActivateBulkUpload = $("#ActivateBulkUpload").val();

            var all_files = $cg_input_image_upload_id[0].files;


           // console.log('all_files');
           // console.log(all_files);


            // Max users upload check

           // console.log($('#cgRegUserUploadOnly').val());
            //console.log($('#cgRegUserMaxUpload').val());

            if($('#cgRegUserUploadOnly').val()>=1 && $('#cgRegUserMaxUpload').val()>=1){

                $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form #cg_input_image_upload_id" ).each(function( i ) {

                    var filesCount = all_files.length;
                    //cgJsClass.gallery.vars.upload.newUploadedFilesAmount = filesCount;

                    var filesCountTotal = parseInt($('#cgRegUserMaxUploadCount').val()) + filesCount;

                    //console.log($('#cgRegUserMaxUpload').val());
                  //  console.log(filesCountTotal);

                    if (filesCountTotal > $('#cgRegUserMaxUpload').val()) {

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$('#cg_language_MaximumAmountOfUploadsIs').val()+': '+$('#cgRegUserMaxUpload').val()+'');
                        $("#cg_upload_form_e_prevent_default").val(1);
                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                        e.preventDefault();
                        result = false;

                    }

                });

            }

            // Max users upload check --- END


            if(ActivateBulkUpload==1){
				
                var BulkUploadQuantity = $("#BulkUploadQuantity").val();
                var BulkUploadMinQuantity = $("#BulkUploadMinQuantity").val();
                //alert(BulkUploadQuantity);
                // Wenn Null dann sozusagen unlimited
                if(BulkUploadQuantity==0){BulkUploadQuantity=1000;}
                if(BulkUploadMinQuantity==0){BulkUploadMinQuantity=1;}
                //alert("all_files "+all_files);
                //alert("BulkUploadQuantity "+BulkUploadQuantity);
			
				if(all_files.length>BulkUploadQuantity){
				
                    var cg_language_BulkUploadQuantityIs = $("#cg_language_BulkUploadQuantityIs").val();
                    $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_BulkUploadQuantityIs+': '+BulkUploadQuantity+'');
                        $("#cg_upload_form_e_prevent_default").val(1);
                        $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                     e.preventDefault();
                    result = false;
					
				}
				
				if(all_files.length<BulkUploadMinQuantity){
				
                    var cg_language_BulkUploadLowQuantityIs = $("#cg_language_BulkUploadLowQuantityIs").val();
                    $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_BulkUploadLowQuantityIs+': '+BulkUploadMinQuantity+'');
                        $("#cg_upload_form_e_prevent_default").val(1);
                        $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                     e.preventDefault();
                    result = false;
					
				}

			}


	// Überprüfen ob Bulk Upload aktiviert ist und die Anzahl wieviel Bilder hochgeladen werden können --- ENDE

	// überprüfen auflösung für jpg
	// Check the resolution of a pic

		if (fileType == 'image/jpeg' && restrictJpg == 1) {
		
             //alert('test');

            var _URL = window.URL || window.webkitURL;

            var file, img;
            if (file = $cg_input_image_upload_id[0].files[0]) {
                img = new Image();
                // Aufgrund onload findet diese Prüfung als aller letztens staat!
                img.onload = function () {
                //    alert("testRES"+this.width + " " + this.height);


                if (this.width > MaxResJPGwidth && MaxResJPGwidth!=0) {

                //var cg_to_high_resolution = $("#cg_to_high_resolution").val();
                //var cg_max_allowed_resolution_jpg = $("#cg_max_allowed_resolution_jpg").val();
                var cg_max_allowed_width_jpg = $("#cg_max_allowed_width_jpg").val();
                //alert(cg_max_allowed_width_jpg);
                $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_width_jpg+' '+MaxResJPGwidth+'px.');
                 $("#cg_upload_form_e_prevent_default").val(1);
                    $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                 e.preventDefault();
                    result = false;

                 // alert('geklappt!res');
                }

                  if (this.height > MaxResJPGheight && MaxResJPGheight!=0) {


                var cg_max_allowed_height_jpg = $("#cg_max_allowed_height_jpg").val();
                //alert(cg_max_allowed_height_jpg);
                $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_height_jpg+' '+MaxResJPGheight+'px.');
                 $("#cg_upload_form_e_prevent_default").val(1);
                      $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                 e.preventDefault();
                      result = false;

                 // alert('geklappt!res');
                }

                };

               img.src = _URL.createObjectURL(file);

            }

		}

        // überprüfen auflösung für png
        if (fileType == 'image/png' && restrictPng == 1) {

            var _URL = window.URL || window.webkitURL;

            var file, img;
            if (file = $cg_input_image_upload_id[0].files[0]) {
                img = new Image();
                // Aufgrund onload findet diese Prüfung als aller letztens staat!
                img.onload = function () {
                    //alert("testRES"+this.width + " " + this.height);

                    if (this.width > MaxResPNGwidth  && MaxResPNGwidth!=0) {

                    var cg_max_allowed_width_png = $("#cg_max_allowed_width_png").val();
                    $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_width_png+' '+MaxResPNGwidth+'px.');
                    $("#cg_upload_form_e_prevent_default").val(1);
                    $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                     e.preventDefault();
                        result = false;
                    //alert('geklappt!res');


                    }


                    if (this.height > MaxResPNGheight  && MaxResPNGheight!=0) {

                    var cg_max_allowed_height_png = $("#cg_max_allowed_height_png").val();
                    $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_height_png+' '+MaxResPNGheight+'px.');
                    $("#cg_upload_form_e_prevent_default").val(1);
                        $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                     e.preventDefault();
                        result = false;
                    //alert('geklappt!res');

                    }

                };

               img.src = _URL.createObjectURL(file);

            }

        }
		
        // überprüfen auflösung für gif
        if (fileType == 'image/gif' && restrictGif == 1) {

            var _URL = window.URL || window.webkitURL;

            var file, img;
            if (file = $cg_input_image_upload_id[0].files[0]) {
                img = new Image();
                // Aufgrund onload findet diese Prüfung als aller letztens staat!
                img.onload = function () {
                    //alert("testRES"+this.width + " " + this.height);

                    if (this.width > MaxResGIFwidth && MaxResGIFwidth!=0) {

                    var cg_max_allowed_width_gif = $("#cg_max_allowed_width_gif").val();
                    $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_width_gif+' '+MaxResGIFwidth+'px.');
                    $("#cg_upload_form_e_prevent_default").val(1);
                        $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                     e.preventDefault();
                        result = false;
                    //alert('geklappt!res');


                    }


                    if (this.height > MaxResGIFheight && MaxResGIFheight!=0) {

                    var cg_max_allowed_height_gif = $("#cg_max_allowed_height_gif").val();
                    $cg_input_image_upload_id.parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_height_gif+' '+MaxResGIFheight+'px.');
                    $("#cg_upload_form_e_prevent_default").val(1);
                        $cg_input_image_upload_id.closest('.cg_form_div').addClass('cg_form_div_error');
                     e.preventDefault();
                        result = false;
                    //alert('geklappt!res');

                    }

                };

               img.src = _URL.createObjectURL(file);

            }

        }


        if(typeof $imageUploadField != 'undefined' && all_files.length>=1){
            for(var index in all_files){

                if(!all_files.hasOwnProperty(index)){
                    break;
                }

                if (isNaN(index)) { // not a number must be a word like length
                    return;
                }else{

                    var file = all_files[index];
                    var fileReaderBase64 = new FileReader(file);
                    fileReaderBase64.readAsDataURL(file);
                    var $cg_upload_form_container = $('#cg_upload_form_container.cg_upload_form_container_shortcode_form');

                    $cg_upload_form_container.find('.cg_form_div_image_upload_preview').append(
                        $(
                            '<div class="cg_form_div_image_upload_preview_div_container">' +
                            '<div class="cg_form_div_image_upload_preview_loader_container cg-lds-dual-ring-div-gallery-hide cg-lds-dual-ring-div-gallery-hide-mainCGallery">' +
                            '<div class="cg_form_div_image_upload_preview_loader cg-lds-dual-ring-gallery-hide cg-lds-dual-ring-gallery-hide-mainCGallery">' +
                            '</div>' +
                            '</div>'
                        ).attr('id','cg_form_div_image_upload_preview_div_container'+index)
                    );

                    cgPreviewOnload(fileReaderBase64,index,$cg_upload_form_container);

                }
            }
        }

	
	}	
	
    //var check = 1;
};


$('#cg_input_image_upload_id').change(function (e) {

    var $cg_upload_form_container = $('#cg_upload_form_container.cg_upload_form_container_shortcode_form');
    $cg_upload_form_container.find('.cg_form_div_image_upload_preview').empty();
    var all_files = $cg_upload_form_container.find('#cg_input_image_upload_id')[0].files;
    if(all_files.length<1){
        $cg_upload_form_container.find('.cg_form_div_image_upload_preview').addClass('cg_hide');
    }else{
        $cg_upload_form_container.find('.cg_form_div_image_upload_preview').removeClass('cg_hide');
    }

	cgCheckPic(e,$(this));

});

// <<< Ende überprüfen der Change() Funktion

var cgCheckFields = function(e,$field,submit){

    //var gid = $field.closest('form').attr('data-cg-gid');

    $field.closest('form').addClass('cg_form_validated');

    $("#cg_upload_form_e_prevent_default").val(0);

    var $form = $field.closest('form');

    $form.find('.cg_form_div').removeClass('cg_form_div_error');
    $form.find('.cg_input_error').addClass('cg_hide').empty();

    var cg_ContestEnd = $("#cg_ContestEnd").val();

    var cg_ContestEndTime = $("#cg_ContestEndTime").val();
    if(cg_ContestEnd==1 && cg_ContestEndTime != 0){

        var ActualTimeSeconds = Math.round((new Date).getTime()/1000);
        //alert(actualTime);

        //alert(cg_ContestEndTime);

        if(ActualTimeSeconds>cg_ContestEndTime){

            //	var cg_photo_contest_over = $("#cg_photo_contest_over").val();
            //	alert(cg_photo_contest_over);

            cgJsClass.gallery.function.message.show($( "#cg_ThePhotoContestIsOver_dialog" ).val());

            e.preventDefault();
            return false;

        }

    }

    if(cg_ContestEnd==2){

//	var cg_photo_contest_over = $("#cg_photo_contest_over").val();
//	alert(cg_photo_contest_over);
        cgJsClass.gallery.function.message.show($( "#cg_ThePhotoContestIsOver_dialog" ).val());

        e.preventDefault();
        return false;


    }


    if($('.cg_recaptcha_not_valid_simple_form_error').length>=1){
        var cg_language_pleaseConfirm = $("#cg_language_pleaseConfirm").val();
        $('.cg_recaptcha_not_valid_simple_form_error').text(cg_language_pleaseConfirm).removeClass('cg_hide');
        $("#cg_upload_form_e_prevent_default").val(1);
        $('.cg_recaptcha_not_valid_simple_form_error').closest('.cg_form_div').addClass('cg_form_div_error');
        e.preventDefault();
    }



    // var emailRegex = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;  

    // new regEx RFC 5322
    var emailRegex = /^[a-zA-Z0-9_!#$%&’*+/=?`{|}~^.-]+@[a-zA-Z0-9.-]+$/;

    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_check_agreement_class" ).each(function( i ) {

        var checkIfNeed = $( this ).closest('.cg_form_div').find(".cg_form_required").val();

        if (checkIfNeed == 'on') {

            if(!$(this).prop('checked')){

                $( this ).closest('.cg_form_div').find('.cg_input_error').removeClass('cg_hide').text(''+$("#cg_check_agreement").val()+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }

        }


    });



    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_input_email_class" ).each(function( i ) {


        var email = $(this).val();

        var checkIfNeed = $( this ).parent().find(".cg_form_required").val();


        if (checkIfNeed == 'on' || email.length > 0) {

            if(email.length == 0){

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$('#cg_language_PleaseFillOut').val()+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }

            if(email.length > 0){

                if (!emailRegex.test(email)){

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$("#cg_check_email_upload").val()+'');
                    $("#cg_upload_form_e_prevent_default").val(1);
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    e.preventDefault();

                }
            }

        }

        //alert('check: '+check);

    });

// Validate Emailadress --- ENDE



// Überprüfen ob die Anzahl der Buchstaben in den Feldern stimmt

    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_input_text_class" ).each(function( i ) {
        // $(this).attr( "width", "200px" );

        var minsize = $( this ).parent().find(".minsize").val();
        var maxsize = $( this ).parent().find(".maxsize").val();
        var checkIfNeed = $( this ).parent().find(".cg_form_required").val();

        var realsize = $( this ).val().length;

        // 	  alert('nf');

        var cg_min_characters_text = $("#cg_min_characters_text").val();
        var cg_max_characters_text = $("#cg_max_characters_text").val();
        if (checkIfNeed == 'on') {


            if(realsize == 0){

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$('#cg_language_PleaseFillOut').val()+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }

            if (realsize<minsize) {


                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');


                $("#cg_upload_form_e_prevent_default").val(1);

                $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                e.preventDefault();
            }


            if (realsize>maxsize) {


                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');

                $("#cg_upload_form_e_prevent_default").val(1);

                $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                e.preventDefault();
            }

        }else{

            if(minsize && realsize>=1){

                if (realsize<minsize) {


                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');


                    $("#cg_upload_form_e_prevent_default").val(1);

                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                    e.preventDefault();
                }
            }


            if(maxsize && realsize>=1){

                if (realsize>maxsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');

                    $("#cg_upload_form_e_prevent_default").val(1);

                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                    e.preventDefault();
                }

            }


        }


    });


    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_input_date_class" ).each(function( i ) {
        // $(this).attr( "width", "200px" );

        var checkIfNeed = $( this ).parent().find(".cg_form_required").val();

        var realsize = $( this ).val().length;


        if (checkIfNeed == 'on') {


            if(realsize == 0){

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$('#cg_language_PleaseFillOut').val()+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }

        }

    });

    // Überprüft ob URL verlangt ist und richtig geschrieben wird
    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_input_url_class" ).each(function( i ) {

        var cg_language_URLnotValid = $("#cg_language_URLnotValid").val();

        var checkIfNeed = $( this ).parent().find(".cg_form_required").val();
        if (checkIfNeed == 'on') {
            var value = $( this ).val();

            if(value.length==0){
                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$('#cg_language_PleaseFillOut').val()+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();
            }
            else{
                var result = value.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
                if(result == null){
                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();
                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_URLnotValid+'');
                    $("#cg_upload_form_e_prevent_default").val(1);
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                    e.preventDefault();

                }
            }


        }

    });

    // Überprüfen ob leeres select field gewählt wurde

    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_input_select_class" ).each(function( i ) {
        // $(this).attr( "width", "200px" );

        var checkIfNeed = $( this ).parent().find(".cg_form_required").val();
        var cg_language_youHaveNotSelected = $("#cg_language_youHaveNotSelected").val();


        if (checkIfNeed == 'on') {

            if ($(this).val()=='0') {

                $( this ).closest('.cg_form_div').find('.cg_input_error').removeClass('cg_hide').empty();
                $( this ).closest('.cg_form_div').find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_youHaveNotSelected+'');

                $("#cg_upload_form_e_prevent_default").val(1);

                $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                e.preventDefault();

            }

        }


    });


// Überprüfen ob die Anzahl der Buchstaben in den Kommentar-Feldern stimmt

    $( "#cg_upload_form_container.cg_upload_form_container_shortcode_form .cg_textarea_class" ).each(function( i ) {
        // $(this).attr( "width", "200px" );

        var minsize = $( this ).parent().find(".minsize").val();
        var maxsize = $( this ).parent().find(".maxsize").val();
        var checkIfNeed = $( this ).parent().find(".cg_form_required").val();

        var realsize = $( this ).val().length;

        var cg_min_characters_text = $("#cg_min_characters_text").val();
        var cg_max_characters_text = $("#cg_max_characters_text").val();
        //  alert(realsize);
        //  alert(maxsize);

        if (checkIfNeed == 'on') {

            if(realsize == 0){

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+$('#cg_language_PleaseFillOut').val()+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }

            else if (realsize<minsize) {

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }

            else if (realsize>maxsize) {

                $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');
                $("#cg_upload_form_e_prevent_default").val(1);
                $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                e.preventDefault();

            }
            else{

            }

        }else{

            if(minsize && realsize>=1){

                if (realsize<minsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');
                    $("#cg_upload_form_e_prevent_default").val(1);
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    e.preventDefault();

                }
            }

            if(maxsize && realsize>=1){

                if (realsize>maxsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');
                    $("#cg_upload_form_e_prevent_default").val(1);
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    e.preventDefault();

                }

            }

        }


    });

    // Check captcha I am not a robot
    if($( "#cg_captcha_not_a_robot_field  input[type='checkbox']" ).length >= 1 && $( "#cg_captcha_not_a_robot_field  input[type='checkbox']" ).is(':checked')===false){
        e.preventDefault();
        var cg_language_pleaseConfirm = $("#cg_language_pleaseConfirm").val();
        $("#cg_captcha_not_a_robot_field").find('.cg_input_error').removeClass('cg_hide').text(cg_language_pleaseConfirm);
        $("#cg_upload_form_e_prevent_default").val(1);

    }



    //alert("check: "+check);

    // alert('end');

    //Funktion zum Überprüfen des Bildes
    cgCheckPic(e);

    // Falls das Bild in der Funktion nicht zugelassen wird, wird da der Wert für prevent default auf 1 gesetzt.
    var cg_upload_form_e_prevent_default = $("#cg_upload_form_e_prevent_default").val();


    if(cg_upload_form_e_prevent_default==1){

        /*             $("#cg_form_upload_submit_div .cg_input_error").text($("#cg_language_sendSubmitError").val());
                    setTimeout(function(){
                        $("#cg_form_upload_submit_div .cg_input_error").empty();
                    },10000);*/

        //location.href = "#cg_input_image_upload_id";

		if(submit===true){
            $(".cg_form_div_error").cgGoTo();
        }

        e.preventDefault();

    }else{

        if(submit===true){


            // NICHT NOTWENDIG!!!! DA ES ZUM SITE RELOAD KOMMT!!!
            // Korgieren der Anzahl der hochgeladen wurde, falls auf der selben Seite nochmal hochgeladen wird
         //   $('#cgRegUserMaxUploadCount').val(parseInt($('#cgRegUserMaxUploadCount'+gid).val()) + cgJsClass.gallery.vars.upload.newUploadedFilesAmount);
         //   $('#cgRegUserMaxUploadCountInGallery'+gid).val(parseInt($('#cgRegUserMaxUploadCountInGallery'+gid).val()) + cgJsClass.gallery.vars.upload.newUploadedFilesAmount);
        //    var userGid = gid+'-u';// falls es eine user gallery auf der Seite gibt
         //   $('#cgRegUserMaxUploadCountInGallery'+userGid).val(parseInt($('#cgRegUserMaxUploadCountInGallery'+userGid).val()) + cgJsClass.gallery.vars.upload.newUploadedFilesAmount);

            contGallSubmitLoaderShow($,$field);

        }

    }

// Überprüfen ob die Anzahl der Buchstaben in den Feldern stimmt --- ENDE 

    /*if (check == 1) {
    alert('Form has to be blocked');

   
   
    e.preventDefault();
    } */






//});

};

//$( "#cg_users_upload_submit" ).click(function() {
	
	 $(document).on('click', '#cg_users_upload_submit', function(e){

         cgCheckFields(e,$(this),true);

	 });

	 $(document).on('input change', '.cg_upload_form_field', function(e){

	 	var $field = $(this);

	 	if($field.closest('form').hasClass('cg_form_validated')){
            cgCheckFields(e,$field);
        }

	 });

	 // cg_recaptcha_form can be displayed only 1 time! Otherwise validation on second form does not work!
	 $('.cg_recaptcha_form').each(function(index){

	     if(index>=1){
            $(this).closest('.cg_form_div').remove();
         }

	 });


 });