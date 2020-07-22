cgJsClass.gallery.upload.preventDefault = function(e){
    e.preventDefault();
    cgJsClass.gallery.upload.validationResult = false;
};
cgJsClass.gallery.upload.validationResult = true;
cgJsClass.gallery.upload.previewContainerWithLodader = '<div class="cg_form_div_image_upload_preview_div_container"><div class="cg_form_div_image_upload_preview_loader_container cg-lds-dual-ring-div-gallery-hide cg-lds-dual-ring-div-gallery-hide-mainCGallery">' +
    '<div class="cg_form_div_image_upload_preview_loader cg-lds-dual-ring-gallery-hide cg-lds-dual-ring-gallery-hide-mainCGallery">' +
    '</div>' +
    '</div>';
cgJsClass.gallery.upload.previewOnload = function (fileReaderBase64,index,$mainCGdivUploadForm) {

    fileReaderBase64.onload = function () {

        var base64url = this.result;

        setTimeout(function () {
            $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview').find('#cg_form_div_image_upload_preview_div_container'+index).empty();
            $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview #cg_form_div_image_upload_preview_div_container'+index).append(
                jQuery('<div class="cg_form_div_image_upload_preview_img" />').css({
                    'background': 'url("'+base64url + '") no-repeat center center',
                    'display': 'none'
                })
            );
            $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview .cg_form_div_image_upload_preview_img').slideDown();

            cgJsClass.gallery.upload.resizeVertical($mainCGdivUploadForm);
        },1000);

        // this.result.split('data:application/pdf;base64,')[1];
    };

};
cgJsClass.gallery.upload.validation = function($){

    // Scroll Function here
    $.fn.cgGoToGalleryUploadForm = function(gid) {
        $('#cgGalleryUploadForm'+gid).animate({
            scrollTop: $(this).offset().top - 40+'px'
        }, 'fast');
        return this; // for chaining...
    };

    /*I am not a robot captcha here*/

    // Prüfen der Wordpress Session id
    var check = cgJsClass.gallery.vars.wp_create_nonce;

    // hier noch keine gid übergeben als okein mainCGdivUploadForm+gid
//
    $('.cg_captcha_not_a_robot_field_in_gallery').each(function () {

        var $element = $(this);
        var gid = $(this).attr('data-cg-gid');

        $("<input type='checkbox' class='cg_upload_form_field_in_gallery' id='cg_"+check+"' data-cg-gid='"+gid+"' >").insertBefore($element.find('.cg_input_error'));

        //data-cg-gid='$galeryID'
    });

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

    function checkPicCgGalleryUpload(e,gid,$imageUploadField) {

        var preventDefault = cgJsClass.gallery.upload.preventDefault;

        var $mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);
     //   var $cgGalleryUploadForm = $('#cgGalleryUploadForm'+gid);

        $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').removeClass('cg_form_div_error').find('.cg_input_error').addClass('cg_hide');

//var filename = $('input[type=file]')[0].files[0].name;
        var filename = $mainCGdivUploadForm.find('input[type=file].cg_input_image_upload_id_in_gallery').val().split('\\').pop();

        if(!filename){

            var cg_no_picture_is_choosed = cgJsClass.gallery.language.ChooseYourImage;
            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_no_picture_is_choosed+'');
            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
            preventDefault(e);

        }
        else{

            $mainCGdivUploadForm.find('.cg_input_error_image_upload').empty();

           // var fileType = document.getElementById('cg_input_image_upload_id_in_gallery').files[0].type;
            var fileType = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').prop('files')[0].type;
            var fileTypeEndingString= filename.split('.')[filename.split('.').length-1].toLowerCase();
            var allowedFileEndings = ['jpg','jpeg','gif','png'];

            var restrictJpg = cgJsData[gid].options.general.MaxResJPGon;
            var restrictPng = cgJsData[gid].options.general.MaxResPNGon;
            var restrictGif = cgJsData[gid].options.general.MaxResGIFon;

            if (restrictJpg==1) {var MaxResJPGwidth = cgJsData[gid].options.general.MaxResJPGwidth;var MaxResJPGheight = cgJsData[gid].options.general.MaxResJPGheight;}
            if (restrictPng==1) {var MaxResPNGwidth = cgJsData[gid].options.general.MaxResPNGwidth;var MaxResPNGheight = cgJsData[gid].options.general.MaxResPNGheight;}
            if (restrictGif==1) {var MaxResGIFwidth = cgJsData[gid].options.general.MaxResGIFwidth;var MaxResGIFheight = cgJsData[gid].options.general.MaxResGIFheight;}

            if ((fileType != 'image/jpeg' && fileType != 'image/png' && fileType != 'image/gif') || allowedFileEndings.indexOf(fileTypeEndingString)==-1)
            {
                var cg_file_not_allowed = cgJsClass.gallery.language.ThisFileTypeIsNotAllowed;
                $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_file_not_allowed+'');
                cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                preventDefault(e);
            }

            //- Prüfen ob das berechtigte Bildformat übergeben wurde   --- ENDE

            //- Prüfen ob der Größe der Bilder in MB

            // Überprüfen ob der File größer ist als vorgegebene Uploadgröße

            var upload_max_filesize_php_ini = cgJsClass.gallery.vars.php_upload_max_filesize;
            var upload_max_filesize_user_config = cgJsData[gid].options.general.PostMaxMB;// Maximum upload size in MB per image option in backend
            var ActivatePostMaxMB = cgJsData[gid].options.general.ActivatePostMaxMB;

            if(ActivatePostMaxMB!='1'){
                upload_max_filesize_user_config = upload_max_filesize_php_ini;
            }

            // PHP ini configuration will be always prefered
            if(upload_max_filesize_php_ini < upload_max_filesize_user_config){
                var upload_max_filesize = upload_max_filesize_php_ini;
            }
            else{
                var upload_max_filesize = upload_max_filesize_user_config;
            }

            //alert(upload_max_filesize);
            // Wenn Null dann sozusagen unlimited
            if(upload_max_filesize==0){upload_max_filesize=upload_max_filesize_php_ini;}
            //alert(upload_max_filesize);

            // alert("Post max size:"+upload_max_filesize);

            //alert(upload_max_filesize);

            var file = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery')[0].files[0];

            // alert('file: '+file);
            var sizePic = file.size;

            //Umwandeln in MegaByte
            sizePic = sizePic/1000000;


            // alert(all_files.length);
            //alert("Aktuelle Größe: "+sizePic);


            if (sizePic >= upload_max_filesize) {

                var cg_file_size_to_big = cgJsClass.gallery.language.TheFileYouChoosedIsToBigMaxAllowedSize;

                $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_file_size_to_big+': '+upload_max_filesize+'MB');
                cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                preventDefault(e);

            }

            // Überprüfen ob der File größer ist als vorgegebene Uploadgröße --- ENDE


            // Überprüfen ob Bulk Upload aktiviert ist und die Anzahl wieviel Bilder hochgeladen werden können

            var ActivateBulkUpload = cgJsData[gid].options.general.ActivateBulkUpload;

            var all_files = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery')[0].files;

            // Max users upload check

            if(cgJsData[gid].options.pro.RegUserUploadOnly>=1 && cgJsData[gid].options.pro.RegUserMaxUpload>=1){

                $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').each(function( i ) {

                    var filesCount = all_files.length;

                    var filesCountTotal = parseInt($('#cgRegUserMaxUploadCountInGallery'+gid).val()) + filesCount;

                    cgJsData[gid].vars.UploadedFilesAmountTotal = filesCountTotal;

                    //   console.log(cgJsData[gid].options.pro.RegUserMaxUpload);
                  //  console.log(filesCountTotal);

                    if (filesCountTotal > cgJsData[gid].options.pro.RegUserMaxUpload) {

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cgJsClass.gallery.language.MaximumAmountOfUploadsIs+': '+cgJsData[gid].options.pro.RegUserMaxUpload+'');
                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                        preventDefault(e);

                    }

                });

            }

            // Max users upload check --- END


            if(ActivateBulkUpload==1){

                all_files_length = all_files.length;
                var BulkUploadQuantity = cgJsData[gid].options.general.BulkUploadQuantity;
                var BulkUploadMinQuantity = cgJsData[gid].options.general.BulkUploadMinQuantity;

                // Wenn Null dann sozusagen unlimited
                if(BulkUploadQuantity==0){BulkUploadQuantity=1000;}
                if(BulkUploadMinQuantity==0){BulkUploadMinQuantity=1;}

                if(all_files_length>BulkUploadQuantity){

                    var cg_language_BulkUploadQuantityIs = cgJsClass.gallery.language.BulkUploadQuantityIs;
                    $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_BulkUploadQuantityIs+': '+BulkUploadQuantity+'');
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }

                if(all_files_length<BulkUploadMinQuantity){

                    var cg_language_BulkUploadLowQuantityIs = cgJsClass.gallery.language.BulkUploadLowQuantityIs;
                    $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_BulkUploadLowQuantityIs+': '+BulkUploadMinQuantity+'');
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }


            }

            // Überprüfen ob Bulk Upload aktiviert ist und die Anzahl wieviel Bilder hochgeladen werden können --- ENDE

            // überprüfen auflösung für jpg
            // Check the resolution of a pic

            if (fileType == 'image/jpeg' && restrictJpg == 1) {

                var _URL = window.URL || window.webkitURL;

                var file, img;
                if (file = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery')[0].files[0]) {
                    img = new Image();
                    // Aufgrund onload findet diese Prüfung als aller letztens staat!
                    img.onload = function () {

                        if (this.width > MaxResJPGwidth && MaxResJPGwidth!=0) {

                            //var cg_to_high_resolution = $("#cg_to_high_resolution").val();
                            //var cg_max_allowed_resolution_jpg = $("#cg_max_allowed_resolution_jpg").val();
                            var cg_max_allowed_width_jpg = cgJsClass.gallery.language.MaximumAllowedWidthForJPGsIs;
                            //alert(cg_max_allowed_width_jpg);
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_width_jpg+' '+MaxResJPGwidth+'px.');
                            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                            preventDefault(e);

                        }

                        if (this.height > MaxResJPGheight && MaxResJPGheight!=0) {

                            var cg_max_allowed_height_jpg = cgJsClass.gallery.language.MaximumAllowedHeightForJPGsIs;
                            //alert(cg_max_allowed_height_jpg);
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_height_jpg+' '+MaxResJPGheight+'px.');
                            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                            preventDefault(e);

                        }

                    };

                    img.src = _URL.createObjectURL(file);

                }

            }

            // überprüfen auflösung für png
            if (fileType == 'image/png' && restrictPng == 1) {

                var _URL = window.URL || window.webkitURL;

                var file, img;
                if (file = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery')[0].files[0]) {
                    img = new Image();
                    // Aufgrund onload findet diese Prüfung als aller letztens staat!
                    img.onload = function () {
                        //alert("testRES"+this.width + " " + this.height);

                        if (this.width > MaxResPNGwidth  && MaxResPNGwidth!=0) {

                            var cg_max_allowed_width_png = cgJsClass.gallery.language.MaximumAllowedWidthForPNGsIs;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_width_png+' '+MaxResPNGwidth+'px.');
                            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                            preventDefault(e);
                            //alert('geklappt!res');


                        }


                        if (this.height > MaxResPNGheight  && MaxResPNGheight!=0) {

                            var cg_max_allowed_height_png = cgJsClass.gallery.language.MaximumAllowedHeightForPNGsIs;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_height_png+' '+MaxResPNGheight+'px.');
                            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                            preventDefault(e);
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
                if (file = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery')[0].files[0]) {
                    img = new Image();
                    // Aufgrund onload findet diese Prüfung als aller letztens staat!
                    img.onload = function () {
                        //alert("testRES"+this.width + " " + this.height);

                        if (this.width > MaxResGIFwidth && MaxResGIFwidth!=0) {

                            var cg_max_allowed_width_gif = cgJsClass.gallery.language.MaximumAllowedWidthForGIFsIs;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_width_gif+' '+MaxResGIFwidth+'px.');
                            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                            preventDefault(e);

                        }


                        if (this.height > MaxResGIFheight && MaxResGIFheight!=0) {

                            var cg_max_allowed_height_gif = cgJsClass.gallery.language.MaximumAllowedHeightForGIFsIs;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_allowed_height_gif+' '+MaxResGIFheight+'px.');
                            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                            $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').closest('.cg_form_div').addClass('cg_form_div_error');
                            preventDefault(e);

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

                        $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview').append(
                            $(cgJsClass.gallery.upload.previewContainerWithLodader).attr('id','cg_form_div_image_upload_preview_div_container'+index)
                        );

                        cgJsClass.gallery.upload.previewOnload(fileReaderBase64,index,$mainCGdivUploadForm);

                    }
                }
            }

        }

    }


// <<< Ende überprüfen der Change() Funktion


    var cgCheckFieldsInGalleryForm = function(e,$field,submit){

        var preventDefault = cgJsClass.gallery.upload.preventDefault;

        preventDefault(e);

        var gid = $field.attr('data-cg-gid');
        var $mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);
        var $cgGalleryUploadForm = $('#cgGalleryUploadForm'+gid);
        $cgGalleryUploadForm.addClass('cg_form_validated');

        $mainCGdivUploadForm.find('.cg_form_div').removeClass('cg_form_div_error');
        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 0;
        $mainCGdivUploadForm.find('.cg_input_error').addClass('cg_hide').empty();

        var cg_ContestEnd = cgJsData[gid].options.general.ContestEnd;

        var cg_ContestEndTime = cgJsData[gid].options.general.ContestEndTime;
        if(cg_ContestEnd==1 && cg_ContestEndTime != 0){

            var ActualTimeSeconds = Math.round((new Date).getTime()/1000);

            if(ActualTimeSeconds>cg_ContestEndTime){

                cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.ThePhotoContestIsOver);

                preventDefault(e);
                return false;

            }

        }

        if(cg_ContestEnd==2){

//	var cg_photo_contest_over = $("#cg_photo_contest_over").val();
//	alert(cg_photo_contest_over);
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.ThePhotoContestIsOver);

            preventDefault(e);
            return false;

        }

        if($cgGalleryUploadForm.find('.cg_recaptcha_not_valid_in_gallery_form_error').length>=1){
            var cg_language_pleaseConfirm = cgJsClass.gallery.language.pleaseConfirm;
            $cgGalleryUploadForm.find('.cg_recaptcha_not_valid_in_gallery_form_error').text(cg_language_pleaseConfirm).removeClass('cg_hide');
            cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
            $cgGalleryUploadForm.find('.cg_recaptcha_not_valid_in_gallery_form_error').closest('.cg_form_div').addClass('cg_form_div_error');
            preventDefault(e);
        }

        // var emailRegex = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

        // new regEx RFC 5322
        var emailRegex = /^[a-zA-Z0-9_!#$%&’*+/=?`{|}~^.-]+@[a-zA-Z0-9.-]+$/;

        $mainCGdivUploadForm.find('.cg_check_agreement_class').each(function( i ) {

            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();

            if (checkIfNeed == 'on') {

                if(!$(this).prop('checked')){

                    $( this ).closest('.cg_form_div').find('.cg_input_error').removeClass('cg_hide').text(''+cgJsClass.gallery.language.YouHaveToCheckThisAgreement+'');
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }

            }

        });


        $mainCGdivUploadForm.find('.cg_input_email_class').each(function( i ) {

            var email = $(this).val();

            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();


            if (checkIfNeed == 'on' || email.length > 0) {

                if(email.length == 0){

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(cgJsClass.gallery.language.PleaseFillOut);
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }

                if(email.length > 0){

                    if (!emailRegex.test(email)){

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(cgJsClass.gallery.language.EmailAdressHasToBeValid);
                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                        preventDefault(e);

                    }
                }

            }

            //alert('check: '+check);

        });

// Validate Emailadress --- ENDE



// Überprüfen ob die Anzahl der Buchstaben in den Feldern stimmt

        $mainCGdivUploadForm.find('.cg_input_text_class').each(function( i ) {
            // $(this).attr( "width", "200px" );

            var minsize = $( this ).parent().find(".minsize").val();
            var maxsize = $( this ).parent().find(".maxsize").val();
            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();

            var realsize = $( this ).val().length;

            // 	  alert('nf');

            var cg_min_characters_text = cgJsClass.gallery.language.MinAmountOfCharacters;
            var cg_max_characters_text = cgJsClass.gallery.language.MaxAmountOfCharacters;

            if (checkIfNeed == 'on') {

                if(realsize == 0){
                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(cgJsClass.gallery.language.PleaseFillOut);
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);
                }
                else if (realsize<minsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');

                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;

                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                    preventDefault(e);
                }


                else if (realsize>maxsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');

                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;

                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                    preventDefault(e);
                }

            }else{

                if(minsize && realsize>=1){

                    if (realsize<minsize) {

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');

                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;

                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                        preventDefault(e);

                    }
                }

                if(maxsize && realsize>=1){

                    if (realsize>maxsize) {

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');

                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;

                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                        preventDefault(e);

                    }

                }

            }

        });

        $mainCGdivUploadForm.find('.cg_input_date_class').each(function( i ) {
            // $(this).attr( "width", "200px" );

            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();
            var realsize = $( this ).val().length;

            // 	  alert('nf');

            if (checkIfNeed == 'on') {

                if(realsize == 0){
                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(cgJsClass.gallery.language.PleaseFillOut);
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);
                }
            }

        });

        // Überprüft ob URL verlangt ist und richtig geschrieben wird
        $mainCGdivUploadForm.find('.cg_input_url_class').each(function( i ) {

            var cg_language_URLnotValid = cgJsClass.gallery.language.URLnotValid;

            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();
            if (checkIfNeed == 'on') {
                var value = $( this ).val();

                if(value.length==0){
                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(cgJsClass.gallery.language.PleaseFillOut);
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);
                }
                else{
                    var result = value.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
                    if(result == null){
                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();
                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_URLnotValid+'');
                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                        preventDefault(e);

                    }
                }


            }

        });

        // Überprüfen ob leeres select field gewählt wurde
        $mainCGdivUploadForm.find('.cg_input_select_class').each(function( i ) {

            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();
            var cg_language_youHaveNotSelected = cgJsClass.gallery.language.youHaveNotSelected;

            if (checkIfNeed == 'on') {

                if ($(this).val()=='0') {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').empty();
                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_language_youHaveNotSelected+'');

                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;

                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');

                    preventDefault(e);

                }

            }


        });


// Überprüfen ob die Anzahl der Buchstaben in den Kommentar-Feldern stimmt
        $mainCGdivUploadForm.find('.cg_textarea_class').each(function( i ) {
            // $(this).attr( "width", "200px" );

            var minsize = $( this ).parent().find(".minsize").val();
            var maxsize = $( this ).parent().find(".maxsize").val();
            var checkIfNeed = $( this ).parent().find(".cg_form_required").val();

            var realsize = $( this ).val().length;

            var cg_min_characters_text = cgJsClass.gallery.language.MinAmountOfCharacters;
            var cg_max_characters_text = cgJsClass.gallery.language.MaxAmountOfCharacters;

            if (checkIfNeed == 'on') {

                if(realsize == 0){

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(cgJsClass.gallery.language.PleaseFillOut);
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }

                else if (realsize<minsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }

                else if (realsize>maxsize) {

                    $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');
                    cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                    $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                    preventDefault(e);

                }
                else{

                }

            }else{

                if(minsize && realsize>=1){

                    if (realsize<minsize) {

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_min_characters_text+': '+minsize+'');
                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                        preventDefault(e);

                    }
                }

                if(maxsize && realsize>=1){

                    if (realsize>maxsize) {

                        $( this ).parent().find('.cg_input_error').removeClass('cg_hide').text(''+cg_max_characters_text+': '+maxsize+'');
                        cgJsClass.gallery.upload.cg_upload_form_e_prevent_default = 1;
                        $(this).closest('.cg_form_div').addClass('cg_form_div_error');
                        preventDefault(e);

                    }

                }


            }

        });

        // Check captcha I am not a robot
        if($mainCGdivUploadForm.find('.cg_captcha_not_a_robot_field_in_gallery  input[type="checkbox"]' ).length >= 1 && $mainCGdivUploadForm.find('.cg_captcha_not_a_robot_field_in_gallery  input[type="checkbox"]' ).is(':checked')===false){
            preventDefault(e);
            var cg_language_pleaseConfirm = cgJsClass.gallery.language.pleaseConfirm;
            $mainCGdivUploadForm.find('.cg_captcha_not_a_robot_field_in_gallery').find('.cg_input_error').removeClass('cg_hide').text(cg_language_pleaseConfirm);
        }

        //Funktion zum Überprüfen des Bildes
        checkPicCgGalleryUpload(e,gid);

        // Falls das Bild in der Funktion nicht zugelassen wird, wird da der Wert für prevent default auf 1 gesetzt.
        var cg_upload_form_e_prevent_default = cgJsClass.gallery.upload.cg_upload_form_e_prevent_default;


        if(cg_upload_form_e_prevent_default==1){

            if(submit===true){

                $mainCGdivUploadForm.find('.cg_form_div_error:first').cgGoToGalleryUploadForm(gid);
            }

            preventDefault(e);

            cgJsClass.gallery.upload.resizeVertical($mainCGdivUploadForm);

        }else{
            if(submit===true){

                // Korgieren der Anzahl der hochgeladen wurde, falls auf der selben Seite nochmal hochgeladen wird
                if(String(gid).indexOf('-u')>=0){// then must be user id
                    $('#cgRegUserMaxUploadCountInGallery'+gid).val(cgJsData[gid].vars.UploadedFilesAmountTotal);
                    $('#cgRegUserMaxUploadCountInGallery'+cgJsData[gid].vars.gidReal).val(cgJsData[gid].vars.UploadedFilesAmountTotal);
                }else{
                    var userGid = gid+'-u';
                    $('#cgRegUserMaxUploadCountInGallery'+gid).val(cgJsData[gid].vars.UploadedFilesAmountTotal);
                    $('#cgRegUserMaxUploadCountInGallery'+userGid).val(cgJsData[gid].vars.UploadedFilesAmountTotal);
                }

                $('#cg_upload_form_container[data-cg-gid="'+cgJsData[gid].vars.gidReal+'"]').find('#cgRegUserMaxUploadCount').val(cgJsData[gid].vars.UploadedFilesAmountTotal);// FOR USER UPLOAD FORM WITHOUT GALLERY!

                cgJsClass.gallery.upload.submitForm(e,$,gid);
            }

        }

// Überprüfen ob die Anzahl der Buchstaben in den Feldern stimmt --- ENDE

        /*if (check == 1) {
        alert('Form has to be blocked');



        preventDefault(e);
        } */



//});

    };


//$( "#cg_users_upload_submit" ).click(function() {
    $(document).on('click', '.cg_users_upload_submit', function(e){

        cgJsClass.gallery.upload.validationResult = true;
        cgCheckFieldsInGalleryForm(e,$(this),true);

    });


    $(document).on('input change', '.cg_upload_form_field_in_gallery', function(e){

        cgJsClass.gallery.upload.validationResult = true;
        var $field = $(this);

        if($field.closest('form').hasClass('cg_form_validated')){
            cgCheckFieldsInGalleryForm(e,$field);
        }

    });

    $('input[type="file"].cg_input_image_upload_id_in_gallery').change(function (e) {

        cgJsClass.gallery.views.fullscreen.fullScreenBodyCheck(cgJsClass.gallery.vars.dom.body);

        cgJsClass.gallery.upload.validationResult = true;
        var gid = $(this).attr('data-cg-gid');

        var $mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);
        $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview').empty();
        var all_files = $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery')[0].files;
        if(all_files.length<1){
            $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview').addClass('cg_hide');
        }else{
            $mainCGdivUploadForm.find('.cg_form_div_image_upload_preview').removeClass('cg_hide');
        }

        checkPicCgGalleryUpload(e,gid,$(this));

    });

    // cg_recaptcha_form can be displayed only 1 time! Otherwise validation on second form does not work!
    $('.cg_recaptcha_form').each(function(index){

        if(index>=1){
           $(this).closest('.cg_form_div').remove();
        }

    });


};
