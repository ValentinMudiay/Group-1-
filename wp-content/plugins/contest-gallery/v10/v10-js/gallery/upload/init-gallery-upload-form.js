cgJsClass.gallery.upload = {
    init: function ($) {

        cgJsClass.gallery.uploadGeneral.functions.events($);

        $(document).on('click','.cg-gallery-upload',function () {

            if(cgJsClass.gallery.vars.dom.body.hasClass('cg_upload_in_progress')){
                $('#mainCGdivUploadForm'+cgJsClass.gallery.vars.openedUploadFormGalleryId).removeClass('cg_upload_in_progress');
                cgJsClass.gallery.vars.dom.html.addClass('cg_no_scroll');
                return;
            }

            var gid = $(this).attr('data-cg-gid');

            cgJsClass.gallery.vars.dom.html.addClass('cg_no_scroll');
            cgJsClass.gallery.vars.dom.body.addClass('cg_upload_modal_opened');

            var $mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);
            cgJsData[gid].vars.mainCGdivUploadForm = $mainCGdivUploadForm;
            $mainCGdivUploadForm.css('height','unset');

            $mainCGdivUploadForm.find('#mainCGdivUploadFormLdsDualRing'+gid).addClass('cg_hide');
            $mainCGdivUploadForm.find('.cg-refresh-upload-form').addClass('cg_hide');

            $mainCGdivUploadForm.find('#mainCGdivUploadFormResult'+gid).addClass('cg_hide');
            $mainCGdivUploadForm.find('#mainCGdivUploadFormResultFailed'+gid).addClass('cg_hide');

            $mainCGdivUploadForm.find('#mainCGdivUploadFormContainer'+gid).removeClass('cg_hide');
            $mainCGdivUploadForm.find('#mainCGdivUploadForm'+gid+' .cg_form_div').removeClass('cg_form_div_error');
            $mainCGdivUploadForm.find('#mainCGdivUploadForm'+gid+' .cg_input_error').addClass('cg_hide').empty();
            $mainCGdivUploadForm.find('#mainCGdivUploadFormContainer'+gid+' .cg_form_div_image_upload_preview').addClass('cg_hide');
            $mainCGdivUploadForm.find('#mainCGdivUploadFormContainer'+gid+' .cg_input_image_upload_id_in_gallery').val('');
            $mainCGdivUploadForm.find('#mainCGdivUploadFormContainer'+gid+' .cg_input_date_class').val('');


            if(cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened){
                var $cgCenterImageFullWindowConfiguration = $('#cgCenterImageFullWindowConfiguration'+gid);
                $cgCenterImageFullWindowConfiguration.click();
            }

            cgJsClass.gallery.vars.openedUploadFormGalleryId = gid;

            $mainCGdivUploadForm.css('height','unset');

            cgJsClass.gallery.upload.resize($mainCGdivUploadForm);

            // cg_invisible invisible für height berechnung
            if(cgJsClass.gallery.vars.fullwindow || cgJsClass.gallery.vars.fullscreen){
                $mainCGdivUploadForm.appendTo('#mainCGdivHelperParent'+gid).removeClass('cg_hide').addClass('cg_invisible');
            }else{
                $mainCGdivUploadForm.appendTo('body').removeClass('cg_hide').addClass('cg_invisible');
            }

            cgJsClass.gallery.upload.resizeVertical($mainCGdivUploadForm);

            if(cgJsClass.gallery.vars.fullwindow || cgJsClass.gallery.vars.fullscreen){
                $mainCGdivUploadForm.appendTo('#mainCGdivHelperParent'+gid).removeClass('cg_invisible');
            }else{
                $mainCGdivUploadForm.appendTo('body').removeClass('cg_invisible');
            }

            cgJsClass.gallery.upload.addCloseUploadFrameOnBodyClick($);


            if(cgJsData[gid].options.pro.RegUserUploadOnly==2 && cgJsData[gid].options.pro.RegUserMaxUpload>=1){

                var cookieName = 'contest-gal1ery-'+gid+'-upload';
                var cookieValue = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

                if(!cookieValue){
                    cgJsClass.gallery.dynamicOptions.setCookie(gid,cookieName,$('#cgUploadCookieId'+gid).val());
                }

                var cookieValue = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

                if(!cookieValue && cgJsData[gid].options.pro.UploadRequiresCookieMessage){
                    cgJsClass.gallery.function.message.show(cgJsData[gid].options.pro.UploadRequiresCookieMessage);
                }

            }

        });

        $(document).on('click','.cg-close-upload-form',function () {

            var gid = $(this).attr('data-cg-gid');

            cgJsClass.gallery.upload.close(gid);

        });

        $(document).on('click','.cg-refresh-upload-form',function () {

            $('#mainCGdivHelperParent'+cgJsClass.gallery.vars.openedUploadFormGalleryId).find('.cg-gallery-upload').click();

        });

        $(document).on('click','.mainCGdivUploadForm.cg_upload_in_progress',function (e) {

            e.preventDefault();

            if($(this).hasClass('cg_upload_in_progress')){
                $(this).removeClass('cg_upload_in_progress');
                cgJsClass.gallery.vars.dom.html.addClass('cg_no_scroll');
            }

        });

        $(document).on('click','.cg-minimize-upload-form',function (e) {

            e.preventDefault();

            var $mainCGdivUploadForm = $(this).closest('.mainCGdivUploadForm');

            cgJsClass.gallery.upload.minimizeUploadForm($mainCGdivUploadForm);

        });

        cgJsClass.gallery.upload.validation($);
        cgJsClass.gallery.upload.addCloseUploadFrameOnBodyClick($);

    },
    minimizeUploadForm: function($mainCGdivUploadForm){

        //$mainCGdivUploadForm.find('.cg-lds-dual-ring-div-gallery-hide').addClass('cg_hide');
        $mainCGdivUploadForm.addClass('cg_upload_in_progress').removeClass('cg_disabled');

        // for better look. Otherwise loader appears from right with latency.
        // transition takes 200(0.2s) miliseconds!
        // looks with timeout of 50 best in the moment
/*        setTimeout(function () {
            $mainCGdivUploadForm.find('.cg-lds-dual-ring-div-gallery-hide').removeClass('cg_hide');
        },150);*/

        cgJsClass.gallery.vars.dom.html.removeClass('cg_no_scroll');

        //   cgJsClass.gallery.views.fullscreen.goBackToFullscreen();

    },
    addCloseUploadFrameOnBodyClick: function($){

        // set that is in fullscreen to put back in full screen later
        $(document).on('click','input[type="file"].cg_input_image_upload_id_in_gallery',function () {

            setTimeout(function () {
                if(cgJsClass.gallery.vars.lastFullscreen){// set that is in fullscreen to put back in full screen later
                    cgJsClass.gallery.vars.fullscreen = cgJsClass.gallery.vars.lastFullscreen;
                    cgJsClass.gallery.vars.dom.body.addClass('cg_browser_input_button_upload_modal_triggered');
                }
            },100);

        });

        // cgJsClass.gallery.vars.fullscreen will be set in on('click','input[type="file"].cg_input_image_upload_id_in_gallery'
        $(document).on('mousemove','body.cg_browser_input_button_upload_modal_triggered',function () {

            cgJsClass.gallery.views.fullscreen.fullScreenBodyCheck($(this));

        });

       // $('body.cg_upload_modal_opened').on('mousedown',function (e) {
        $(document).on('mousedown','body.cg_upload_modal_opened',function (e) {

            var $eTarget = $(e.target);

            if(!$(this).hasClass('cg_upload_modal_opened')){// important. might react even if cg_upload_modal_opened does not appear anymore in dom
                return;
            }

            var isOnUploadFormClicked = false;

            if($eTarget.hasClass('.mainCGdivUploadForm') || $eTarget.closest('.mainCGdivUploadForm').length || $eTarget.hasClass('.ui-datepicker.cg_upload_form_container') || $eTarget.closest('.ui-datepicker.cg_upload_form_container').length){
                isOnUploadFormClicked = true;
            }

            if($(this).hasClass('cg_upload_in_progress') && !cgJsData[cgJsClass.gallery.vars.openedUploadFormGalleryId].vars.mainCGdivUploadForm.hasClass('cg_upload_in_progress') && !isOnUploadFormClicked){// make appear progress loader at the right
                cgJsClass.gallery.upload.minimizeUploadForm(cgJsData[cgJsClass.gallery.vars.openedUploadFormGalleryId].vars.mainCGdivUploadForm);
                cgJsClass.gallery.vars.dom.html.removeClass('cg_no_scroll');
                return;
            }

            if($(this).hasClass('cg_upload_in_progress')){
                return;
            }

            if($(this).hasClass('cg_uncloseable')){
                return;
            }

            if(isOnUploadFormClicked){
                return;
            }else{
                cgJsClass.gallery.upload.close(cgJsClass.gallery.vars.openedUploadFormGalleryId);
            }

        });

    },
    close: function(gid){

        if(!cgJsClass.gallery.vars.dom.body.hasClass('cg_upload_in_progress')){
            cgJsClass.gallery.vars.dom.html.removeClass('cg_no_scroll');
            cgJsClass.gallery.vars.dom.body.removeClass('cg_upload_modal_opened');

            var mainCGdivUploadForm = jQuery('#mainCGdivUploadForm'+gid);
            mainCGdivUploadForm.prependTo('#cgGalleryViewSortControl'+gid).addClass('cg_hide');

            cgJsClass.gallery.vars.openedUploadFormGalleryId = null;
         //   cgJsClass.gallery.views.fullscreen.goBackToFullscreen();
        }

    },
    removeCloseUploadFrameOnBodyClick: function(){

        //  jQuery('body.cg_upload_modal_opened').off('click');
        //   jQuery('body').removeClass('cg_upload_modal_opened');

    },
    resizeAllForms: function (){

        jQuery('.mainCGdivUploadForm:visible').each(function () {
            var $element = jQuery(this);
            cgJsClass.gallery.upload.resize($element);
            cgJsClass.gallery.upload.resizeVertical($element);
        });

    },
    resize: function ($mainCGdivUploadForm){

        // Berechnung Abstand horizontal
        var windowWidth = jQuery(window).width();

        if(windowWidth <= 600){
            var widthUploadForm = windowWidth-50;
            $mainCGdivUploadForm.css({
                'left':0
            });
        }else{
            var widthUploadForm = windowWidth/100*70;
            if(windowWidth <= 600){
                widthUploadForm = 600;
            }
            if(windowWidth > 1000){
                var widthUploadForm = windowWidth/100*50;
            }
            if(windowWidth > 1200){
                var widthUploadForm = windowWidth/100*40;
            }
            var left = (windowWidth-widthUploadForm)/2-30;
            $mainCGdivUploadForm.css('left',left+'px');
        }

        $mainCGdivUploadForm.width(widthUploadForm);

    },
    resizeVertical: function (mainCGdivUploadForm){

        // Berechnung Abstand vertical
        var windowHeight = jQuery(window).height();
        var mainCGdivUploadFormHeight = mainCGdivUploadForm.addClass('cg_hidden').removeClass('cg_hide').height();
        if(mainCGdivUploadFormHeight < windowHeight){
            var distanceTop = (windowHeight-mainCGdivUploadFormHeight)/2-10;
            mainCGdivUploadForm.css('top',distanceTop+'px');
        }
        mainCGdivUploadForm.removeClass('cg_hidden');

    },
    submitForm: function (e,$,gid) {

        e.preventDefault();

        var $mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);

        // have to be done first before! Before cg_hide is added.
        var uploadFormHeight = $mainCGdivUploadForm.outerHeight();

        $('#mainCGdivUploadFormContainer'+gid).addClass('cg_hide');
        $mainCGdivUploadForm.find('.cg-lds-dual-ring-div-gallery-hide').removeClass('cg_hide');

        cgJsClass.gallery.upload.resizeVertical($mainCGdivUploadForm);

        // most low post_max value this way, when creating form complete new FormData and then appending only the required
        var formPostData = new FormData();

        var formInputArray = [];

        $mainCGdivUploadForm.find('[name="form_input[]"]').each(function () {
            formInputArray.push($(this).val());
            formPostData.append('form_input[]', $(this).val());
        });

        for(var index in $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').prop('files')){// important to do it that way! Then same processing like normal upload!

            if(!$mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').prop('files').hasOwnProperty(index)){
                break;
            }
            formPostData.append('data[]', $mainCGdivUploadForm.find('.cg_input_image_upload_id_in_gallery').prop('files')[index]);

        }

        formPostData.append('action', 'post_cg_gallery_form_upload');
        formPostData.append('cg_form_submit', 'Upload');
        formPostData.append('GalleryID', cgJsData[gid].vars.gidReal);
        formPostData.append('cg_from_gallery_form_upload', true);
        formPostData.append('cg_upload_action', true);
        formPostData.append('galeryIDuser', gid);
        formPostData.append('check', $mainCGdivUploadForm.find('#cg_check').val());

        cgJsClass.gallery.upload.activeGalleryId = gid;

        $mainCGdivUploadForm.find('.cg-close-upload-form').addClass('cg_hide');
        $mainCGdivUploadForm.find('.cg-minimize-upload-form').removeClass('cg_hide');

        cgJsClass.gallery.vars.dom.body.addClass('cg_upload_in_progress');

        // AJAX Call - Submit Form
        $.ajax({
            url: post_cg_gallery_form_upload_wordpress_ajax_script_function_name.cg_gallery_form_upload_ajax_url,
            method: 'post',
            data: formPostData,
            /*                data : {
                                action : 'post_cg_gallery_form_upload',
                                gid : 111,
                                pid : 222,
                                value : 3333
                            },*/
            dataType: null,
            contentType: false,
            processData: false,
            xhr: function() {

                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',cg_progress, false);
                }
                return myXhr;

            }
        }).done(function(response) {

     //    setTimeout(function () {  // for test!!!

            clearInterval(cgJsClass.gallery.upload.slowPercentageUpInterval);
            cgJsClass.gallery.upload.slowPercentageUpStartInitiated = false;
            cgJsClass.gallery.upload.activeGalleryId = 0;

            var parser = new DOMParser();
            var parsedHtml = parser.parseFromString(response, 'text/html');
            jQuery(parsedHtml).find('script[data-cg-processing="true"]').each(function () {

                var script = jQuery(this).html();
                eval(script);

            });

            if(cgJsClass.gallery.upload.doneUploadFailed){

                cgJsClass.gallery.upload.failFunction($,gid,uploadFormHeight,cgJsClass.gallery.upload.failMessage);
                cgJsClass.gallery.upload.doneUploadFailed = false;

            }else{

                $mainCGdivUploadForm.find('#mainCGdivUploadProgress'+gid).addClass('cg_hide').text('');

                $mainCGdivUploadForm.show();

                $mainCGdivUploadForm.removeClass('cg_disabled').css('height','unset').find('.cg-lds-dual-ring-div-gallery-hide').addClass('cg_hide');

                var mainCGdivUploadFormContainer = $mainCGdivUploadForm.find('.mainCGdivUploadFormContainer');
                mainCGdivUploadFormContainer.addClass('cg_hide');
                mainCGdivUploadFormContainer.find('.cg_input_image_upload_id_in_gallery, .cg_input_text_class, .cg_textarea_class, .cg_input_url_class').val('');
                mainCGdivUploadFormContainer.find('input[type="checkbox"]').prop('checked',false);
                mainCGdivUploadFormContainer.find('option:selected').prop('selected',false);

                //$('#mainCGdivUploadFormResult'+gid).append($('<div/>').html(cgJsData[gid].options.pro.GalleryUploadConfirmationText).text().replace(/&nbsp;/g,"<br/><br/><br/>"));
                $('#mainCGdivUploadFormResult'+gid).removeClass('cg_hide');
                var mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);
                cgJsClass.gallery.upload.resizeVertical(mainCGdivUploadForm);

                $('#cgSearchInput'+gid).val('');

            }

            $mainCGdivUploadForm.removeClass('cg_upload_in_progress');
            cgJsClass.gallery.vars.dom.html.addClass('cg_no_scroll');

            cgJsClass.gallery.vars.dom.body.addClass('cg_uncloseable');
            cgJsClass.gallery.vars.dom.body.removeClass('cg_upload_in_progress');

            $mainCGdivUploadForm.find('.cg-refresh-upload-form').removeClass('cg_hide');

            $mainCGdivUploadForm.find('.cg-close-upload-form').removeClass('cg_hide');
            $mainCGdivUploadForm.find('.cg-minimize-upload-form').addClass('cg_hide');

            setTimeout(function () {
                cgJsClass.gallery.vars.dom.body.removeClass('cg_uncloseable');
            },3000);

    //     },7000);

        }).fail(function(xhr, status, error) {

            $mainCGdivUploadForm.removeClass('cg_upload_in_progress');
            cgJsClass.gallery.vars.dom.html.addClass('cg_no_scroll');

            clearInterval(cgJsClass.gallery.upload.slowPercentageUpInterval);
            cgJsClass.gallery.upload.slowPercentageUpStartInitiated = false;
            cgJsClass.gallery.upload.activeGalleryId = 0;
            cgJsClass.gallery.upload.failFunction($,gid,uploadFormHeight);
            jQuery('#mainCGdivUploadProgress'+gid).addClass('cg_hide').text('');

            cgJsClass.gallery.vars.dom.body.addClass('cg_uncloseable');
            cgJsClass.gallery.vars.dom.body.removeClass('cg_upload_in_progress');

            $mainCGdivUploadForm.find('.cg-refresh-upload-form').removeClass('cg_hide');
            $mainCGdivUploadForm.find('.cg-close-upload-form').removeClass('cg_hide');
            $mainCGdivUploadForm.find('.cg-minimize-upload-form').addClass('cg_hide');

            setTimeout(function () {
                cgJsClass.gallery.vars.dom.body.removeClass('cg_uncloseable');
            },3000);

        }).always(function() {

        });

    },
    activeGalleryId: 0,
    cg_upload_form_e_prevent_default: 0,
    failFunction: function ($,gid,uploadFormHeight,message) {

        cgJsClass.gallery.vars.dom.body.removeClass('cg_upload_in_progress');

        var mainCGdivUploadForm = $('#mainCGdivUploadForm'+gid);

        mainCGdivUploadForm.removeClass('cg_disabled').css('height','unset').find('.cg-lds-dual-ring-div-gallery-hide').addClass('cg_hide');

        var mainCGdivUploadFormContainer = $('#mainCGdivUploadFormContainer'+gid);
        mainCGdivUploadFormContainer.addClass('cg_hide');
        mainCGdivUploadFormContainer.find('.cg_input_image_upload_id_in_gallery, .cg_input_text_class, .cg_textarea_class, .cg_input_url_class').val('');
        mainCGdivUploadFormContainer.find('input[type="checkbox"]').prop('checked',false);
        mainCGdivUploadFormContainer.find('option:selected').prop('selected',false);

        var mainCGdivUploadFormResultFailed = $('#mainCGdivUploadFormResultFailed'+gid);

        if(message){
            mainCGdivUploadFormResultFailed.html('<p>'+message+'</p>');
        }else{
            mainCGdivUploadFormResultFailed.html('<p>In gallery image upload failed. Please contact administrator.</p>');
        }

        mainCGdivUploadFormResultFailed.removeClass('cg_hide');

        cgJsClass.gallery.upload.resizeVertical(mainCGdivUploadForm);

    },
    doneUploadFailed: false,
    failMessage: 0,
    slowPercentageUpInterval: null,
    slowPercentageUpStartInitiated: false,
    slowPercentageUpStart: 90,
    slowPercentageUpFunction: function (gid) {

        if(cgJsClass.gallery.upload.slowPercentageUpStart>=99){
            cgJsClass.gallery.upload.slowPercentageUpStart = 99;
        }
        jQuery('#mainCGdivUploadProgress'+gid).removeClass('cg_hide').text(cgJsClass.gallery.upload.slowPercentageUpStart +'%');
        if(cgJsClass.gallery.upload.slowPercentageUpStart<99){
            cgJsClass.gallery.upload.slowPercentageUpStart = cgJsClass.gallery.upload.slowPercentageUpStart+1;
        }
    }
};

function cg_progress(e){

    try{

        if(e.lengthComputable){

            var gid = cgJsClass.gallery.upload.activeGalleryId;
            var max = e.total;
            var current = e.loaded;

            var percentage = (current * 100)/max;

            //     if(percentage<=80){
            //         var percentageToShow = percentage+10;
            //     if(percentage>90){
            //          percentage = 90;
            //       jQuery('#mainCGdivUploadProgress'+gid).removeClass('cg_hide').text(percentage+'%');
            //   }
            //  if(percentage>=100){
            //         var percentageToShow = percentage-10;
            //     cgJsClass.gallery.upload.activeGalleryId = 0;
            //     jQuery('#mainCGdivUploadProgress'+gid).removeClass('cg_hide').text('99%');

            //  }else{
            //percentage = Math.round(percentage * 100) / 100;
            if(percentage<=90){
                percentage = Math.floor(percentage);
                jQuery('#mainCGdivUploadProgress'+gid).removeClass('cg_hide').text(percentage+'%');
            }else{
                if(!cgJsClass.gallery.upload.slowPercentageUpStartInitiated){
                    cgJsClass.gallery.upload.slowPercentageUpStartInitiated = true;
                    cgJsClass.gallery.upload.slowPercentageUpStart = 90;
                    cgJsClass.gallery.upload.slowPercentageUpInterval = setInterval(function () {
                        cgJsClass.gallery.upload.slowPercentageUpFunction(gid);
                    },3000);
                }
            }

            //   }

        }

    }catch(error){


    }

}