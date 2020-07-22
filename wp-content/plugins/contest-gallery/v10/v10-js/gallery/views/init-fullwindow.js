cgJsClass.gallery.views.fullwindow = {
    init:function () {

        this.openEvent();
        this.closeEvent();

    },
    openEvent:function(){

        jQuery(document).on('click', '.cg-center-image-fullwindow', function () {

            var gid = jQuery(this).attr('data-cg-gid');
            var $mainCGdivContainer = jQuery('#mainCGdivContainer'+gid);

            // !Important, otherwise buggy behaviour appearing centerDiv not in right place
            cgJsData[gid].vars.cgCenterDiv.hide();

            $mainCGdivContainer.css('height','1200px');
            location.href = '#mainCGdivContainer'+gid;
            cgJsClass.gallery.views.fullwindow.openFunction(gid,true);
            $mainCGdivContainer.css('height','unset');

            /*            if(cgJsData[gid].vars.openedRealId>=1 && jQuery(this).hasClass('cg-inside-center-image-div')){
                            //  setTimeout(function () {
                            jQuery('#cg_show'+cgJsData[gid].vars.openedRealId+' .cg_gallery_info').click();
                            //  },100);
                        }*/

        });

        jQuery(document).on('click', '.cg-fullwindow-configuration-button', function () {

            var $element = jQuery(this);

            var gid = $element.attr('data-cg-gid');

            cgJsClass.gallery.upload.close(gid);

            var $mainCGdivHelperParent = $element.closest('.mainCGdivHelperParent');

            if(cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened){
                $mainCGdivHelperParent.find('.mainCGdivFullWindowConfigurationArea').removeClass('cg_opened');
                cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened = false;
            }else{
                $mainCGdivHelperParent.find('.mainCGdivFullWindowConfigurationArea').addClass('cg_opened');
                setTimeout(function () {
                    cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened = true;
                },10);
            }

        });

        jQuery(document).on("click", "body > .mainCGdivHelperParent .mainCGdivFullWindowConfigurationArea .cg_select_order", function(){
            var $mainCGdivFullWindowConfigurationArea = jQuery(this).closest('.mainCGdivFullWindowConfigurationArea');
            $mainCGdivFullWindowConfigurationArea.addClass('cg_cant_be_closed');// otherwise will close settings
            if(jQuery(this).is(':focus')){
                $mainCGdivFullWindowConfigurationArea.find('.cg_search_input').addClass('cg_opacity_0_3');
                $mainCGdivFullWindowConfigurationArea.find('.cg-cat-select-area').addClass('cg_opacity_0_3');
            }
            setTimeout(function () {
                $mainCGdivFullWindowConfigurationArea.removeClass('cg_cant_be_closed');
            },10);
        });

        jQuery(document).on("change", "body > .mainCGdivHelperParent .mainCGdivFullWindowConfigurationArea .cg_select_order", function(){
            var $mainCGdivFullWindowConfigurationArea = jQuery(this).closest('.mainCGdivFullWindowConfigurationArea');
            setTimeout(function () {
                $mainCGdivFullWindowConfigurationArea.find('.cg_search_input').removeClass('cg_opacity_0_3');
                $mainCGdivFullWindowConfigurationArea.find('.cg-cat-select-area').removeClass('cg_opacity_0_3');
                $mainCGdivFullWindowConfigurationArea.removeClass('cg_cant_be_closed');
            },10);
        });

        jQuery(document).on("change", "body > .mainCGdivHelperParent .mainCGdivFullWindowConfigurationArea .cg_select_cat_label ", function(){
            var $mainCGdivFullWindowConfigurationArea = jQuery(this).closest('.mainCGdivFullWindowConfigurationArea');
            $mainCGdivFullWindowConfigurationArea.addClass('cg_cant_be_closed');// otherwise will close settings
            setTimeout(function () {
                $mainCGdivFullWindowConfigurationArea.find('.cg_search_input').removeClass('cg_opacity_0_3');
                $mainCGdivFullWindowConfigurationArea.find('.cg-cat-select-area').removeClass('cg_opacity_0_3');
                $mainCGdivFullWindowConfigurationArea.removeClass('cg_cant_be_closed');
            },10);
        });

        jQuery(document).on("focusout", "body > .mainCGdivHelperParent .mainCGdivFullWindowConfigurationArea .cg_select_order", function(){
            var $mainCGdivFullWindowConfigurationArea = jQuery(this).closest('.mainCGdivFullWindowConfigurationArea');
            $mainCGdivFullWindowConfigurationArea.find('.cg_search_input').removeClass('cg_opacity_0_3');
            $mainCGdivFullWindowConfigurationArea.find('.cg-cat-select-area').removeClass('cg_opacity_0_3');
        });


        // consider order! Has to be before configuration button!
        jQuery(document).on("click", "body > .mainCGdivHelperParent", function(e){

            if(cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened){

                var $eTarget = jQuery(e.target);

                var gid = jQuery(this).attr('data-cg-gid');

                var sliderView = false;

                if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
                    sliderView = true;
                }

                if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
                    sliderView = true;
                }

                // check !($eTarget.hasClass('cg_append') && sliderView==true) important! Otherwise settings will always disappear when something changed slider is visible
                // for !$eTarget.hasClass('cg_further_images') is same!!!
                if(!$eTarget.is('.mainCGdivFullWindowConfigurationArea') && $eTarget.closest('.mainCGdivFullWindowConfigurationArea').length==0 &&
                    !$eTarget.hasClass('cg_further_images') && !$eTarget.hasClass('cg_fe_controls_style_white') && !($eTarget.hasClass('cg_append') && sliderView==true)
                    && !$eTarget.hasClass('cgChangeTopControlsStyleOptionTest')){
                    var $element = jQuery(this);
                    var gid = $element.attr('data-cg-gid');
                    if(!$element.find('#mainCGdivFullWindowConfigurationArea'+gid).hasClass('cg_cant_be_closed')){
                        $element.find('#mainCGdivFullWindowConfigurationArea'+gid).removeClass('cg_opened');
                    }
                    cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened = false;
                }

            }

        });



    },
    openFunction: function (gid,openImage) {

        cgJsClass.gallery.upload.close(gid);

        cgJsData[gid].vars.mainCGdiv.addClass('cg_display_inline_block');
        cgJsData[gid].vars.mainCGallery.addClass('cg_full_window');

        cgJsClass.gallery.vars.fullwindow = gid;
        cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened = false;

        cgJsData[gid].vars.cgCenterDivLastHeight = null;

        // jQuery('#mainCGdivHelperParent'+gid).appendTo('body').addClass('cg_blink_image_appear_gallery_load');
        // jQuery('#mainCGdivHelperParent'+gid).hide().appendTo('body').fadeIn();
        var $mainCGdivHelperParent = jQuery('#mainCGdivHelperParent'+gid);
        // $mainCGdivHelperParent.find('#mainCGdiv'+gid).addClass('cg_hide_override').removeClass('cg_fade_in');
        $mainCGdivHelperParent.find('#mainCGslider'+gid).addClass('cg_hide_override');
        $mainCGdivHelperParent.appendTo('body');

        var $mainCGdivFullWindowConfigurationArea = jQuery('#mainCGdivFullWindowConfigurationArea'+gid);
        $mainCGdivFullWindowConfigurationArea.removeClass('cg_opened');
        $mainCGdivHelperParent.find('.cg_sort_div').appendTo($mainCGdivFullWindowConfigurationArea);
        $mainCGdivHelperParent.find('.cg-cat-select-area').appendTo($mainCGdivFullWindowConfigurationArea);

        cgJsClass.gallery.categories.setRemoveTitleAttributeForSmallWindow();

        // is required because full window might clicked right after load!
        cgJsClass.gallery.sorting.showRandomButtonInstantly(gid);

        var sliderView = false;
        cgJsData[gid].vars.previousLookSlider = false;

        if((cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1)){
            cgJsData[gid].vars.previousLookSlider = true;
        }


        if((cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1) || (cgJsData[gid].options.pro.SliderFullWindow==1)){
            sliderView = true;
        }

        if(cgJsData[gid].options.pro.SliderFullWindow==1){
            cgJsData[gid].vars.previousLook = cgJsData[gid].vars.currentLook;
        }

        if(sliderView){

            if(cgJsData[gid].options.pro.SliderFullWindow==1){
                $mainCGdivHelperParent.find('.cg_gallery_thumbs_control').addClass('cg_hide');
            }

            cgJsClass.gallery.views.switchView.sortViewSlider(gid);
            $mainCGdivHelperParent.find('.cg_further_images_container').addClass('cg_hide');
        }

        // jQuery('#mainCGdivHelperParent'+gid).addClass('cg_hide').appendTo('body').removeClass('cg_hide').addClass('cg_blink_image_appear_gallery_load');
        $mainCGdivHelperParent.find('#cgCenterImageClose'+gid).removeClass('cg_hide');
        $mainCGdivHelperParent.find('#cgCenterImageFullwindowHeader'+gid).addClass('cg_hide');
        $mainCGdivHelperParent.find('#cgCenterImageFullwindow'+gid).addClass('cg-center-image-close-fullwindow').removeClass('cg-center-image-fullwindow');
        cgJsClass.gallery.vars.dom.body.addClass('cg_body_overflow_hidden');
        cgJsClass.gallery.vars.dom.html.addClass('cg_no_scroll cg_body_overflow_hidden');
        //cgJsData[gid].vars.cgCenterDivAppearenceHelper.removeClass('cg_hide');
        cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');

        cgJsClass.gallery.views.initOrderGallery(gid,false,null,openImage,false,false,false,sliderView);

        $mainCGdivHelperParent.find('#mainCGdiv'+gid).removeClass('cg_hide_override');
        $mainCGdivHelperParent.find('#mainCGslider'+gid).removeClass('cg_hide_override');
        $mainCGdivHelperParent.find('.cg-header-controls-show-only-full-window').removeClass('cg_hide');
        $mainCGdivHelperParent.find('.cg_sort_div .cg-gallery-upload').addClass('cg_hide');

        // FullSize is full screen and full sull size gallery is full window
        if(!cgJsClass.gallery.vars.fullscreen && cgJsData[gid].options.general.FullSize==1 && cgJsData[gid].options.general.FullSizeGallery==1){
            $mainCGdivHelperParent.find('.cgCenterDiv .cg-fullscreen-button').removeClass('cg_hide');
        }

    },
    closeEvent: function () {

        jQuery(document).on('click', '.cg-center-image-close-fullwindow', function () {

            jQuery('html').removeClass('cg_no_scroll');

            var gid = jQuery(this).attr('data-cg-gid');

            if(cgJsClass.gallery.vars.fullscreen){
                cgJsClass.gallery.views.fullscreen.close(gid);
                cgJsData[gid].vars.cgCenterDivLastHeight = null;
            }else{
                cgJsClass.gallery.views.fullwindow.closeFunction(gid,true);
                cgJsData[gid].vars.cgCenterDivLastHeight = null;
            }

        });

    },
    closeFunction: function (gid,openImage) {

        cgJsClass.gallery.upload.close(gid);

        cgJsData[gid].vars.mainCGdiv.removeClass('cg_display_inline_block');

        cgJsClass.gallery.vars.fullwindow = null;

        cgJsData[gid].vars.cgCenterDivLastHeight = null;

        cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened = false;

        cgJsData[gid].vars.mainCGallery.addClass('cg_invisible').css('height','1000px');
        cgJsData[gid].vars.mainCGdivContainer.css('height','1200px');

        //cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');

        cgJsData[gid].vars.cgCenterDiv.hide();
        var $mainCGdivHelperParent = jQuery('#mainCGdivHelperParent'+gid);

        var $mainCGdivFullWindowConfigurationArea = jQuery('#mainCGdivFullWindowConfigurationArea'+gid);
        $mainCGdivFullWindowConfigurationArea.find('.cg_sort_div').appendTo($mainCGdivHelperParent.find('.cg_gallery_view_sort_control'));
        $mainCGdivFullWindowConfigurationArea.find('.cg-cat-select-area').prependTo($mainCGdivHelperParent.find('.cg_thumbs_and_categories_control '));
        $mainCGdivFullWindowConfigurationArea.removeClass('cg_opened');


        cgJsClass.gallery.categories.removeTitleAttributeGeneral(gid);


        location.href = '#mainCGdivHelperParent'+gid;
        $mainCGdivHelperParent.prependTo(cgJsData[gid].vars.mainCGdivContainer).slideDown();
        $mainCGdivHelperParent.find('.cg_gallery_thumbs_control').removeClass('cg_hide');

        var $mainCGslider = $mainCGdivHelperParent.find('.mainCGslider');
        $mainCGslider.addClass('cg_hide');
        $mainCGdivHelperParent.find('#cgCenterImageFullwindowHeader'+gid).removeClass('cg_hide');
        $mainCGdivHelperParent.find('#cgCenterImageFullwindow'+gid).addClass('cg-center-image-fullwindow').removeClass('cg-center-image-close-fullwindow');
        $mainCGdivHelperParent.find('#cgCenterImageClose'+gid).addClass('cg_hide');
        cgJsClass.gallery.vars.dom.body.removeClass('cg_body_overflow_hidden');
        cgJsClass.gallery.vars.dom.html.removeClass('cg_no_scroll cg_body_overflow_hidden');
        cgJsData[gid].vars.cgCenterDivLastHeight = undefined;

        // has to be done extra and in this order. Maybe developer tools started before for mobile view check and then ended. Then this will stay always hidden!
        // show has also to be done!
        $mainCGdivHelperParent.find('.cg-center-image-fullwindow').show().removeClass('cg_hide');

        var sliderView = false;

        if((cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1) || (cgJsData[gid].options.pro.SliderFullWindow==1)){
            sliderView = true;
        }

        if(cgJsData[gid].options.pro.SliderFullWindow==1){
            cgJsData[gid].vars.currentLook = cgJsData[gid].vars.previousLook;
            if(!(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1)){
                var step = cgJsClass.gallery.dynamicOptions.getCurrentStep(gid,cgJsData[gid].vars.openedRealId); // Weil fängt mit erstem Schritt an
                cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,step,false,true,gid);// <<< no append here and no cg show remove with this parameters
                $mainCGslider.find('.cg_show').remove();
                cgJsClass.gallery.vars.hasToAppend=true;
            }
        }

        /*        var sliderView = false;

                if((cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1) || (cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsData[gid].vars.currentLook=='thumb')){
                    sliderView = true;
                }*/

        if(cgJsData[gid].vars.previousLookSlider==false){
            cgJsData[gid].vars.openedRealId = 0;
        }

        cgJsClass.gallery.views.initOrderGallery(gid,true,null,openImage,false,false,false,sliderView);

        // 04.04.2020 seems to be the best behaviour doing scrolling already here!
        cgJsClass.gallery.vars.dom.html.addClass('cg_scroll_behaviour_initial');
        cgJsClass.gallery.vars.dom.body.addClass('cg_scroll_behaviour_initial');
        $mainCGdivHelperParent.find('#cgViewHelper'+gid).get(0).scrollIntoView();
        cgJsClass.gallery.vars.dom.html.removeClass('cg_scroll_behaviour_initial');
        cgJsClass.gallery.vars.dom.body.removeClass('cg_scroll_behaviour_initial');

        setTimeout(function () {
            cgJsData[gid].vars.mainCGdivContainer.css('height','unset');
            cgJsData[gid].vars.mainCGallery.removeClass('cg_invisible').css('height','unset').addClass('cg_fade_in');
        },400);

        /*
                    var order = cgJsData[gid].vars.openedGalleryImageOrder;

                    cgJsClass.gallery.views.close(gid);
                    cgJsClass.gallery.views.singleView.openAgain(gid, order);*/

        $mainCGdivHelperParent.find('.cg_sort_div .cg-gallery-upload').removeClass('cg_hide');
        $mainCGdivHelperParent.find('.cg-fullwindow-configuration-button').addClass('cg_hide');
        $mainCGdivHelperParent.find('.cg-fullscreen-button').addClass('cg_hide');

        $mainCGdivHelperParent.find('.cg-gallery-upload.cg-header-controls-show-only-full-window').addClass('cg_hide');

        // FullSize is full screen and full sull size gallery is full window
        if(cgJsData[gid].options.general.FullSize==1 && cgJsData[gid].options.general.FullSizeGallery==1){
            $mainCGdivHelperParent.find('.cgCenterDiv .cg-fullscreen-button').addClass('cg_hide');
        }

        cgJsData[gid].vars.mainCGallery.removeClass('cg_full_window');


    },
    checkIfGalleryAlreadyFullWindow: function (gid) {

        if(cgJsClass.gallery.vars.isMobile){
            var windowWidth = screen.width;
        }else{
            var windowWidth = jQuery(window).width();
        }

       // var widthMainCGallery = parseInt(jQuery('#mainCGdivContainer'+gid).parent().width());
     //   var cssWidth = jQuery('#mainCGdivContainer'+gid).parent().css('width');
        var mainCGdivContainerWidth = jQuery('#mainCGdivContainer'+gid).width();
     //   debugger
        var widthDifferenceCheck = windowWidth-mainCGdivContainerWidth;

        if(widthDifferenceCheck<100){
            cgJsData[gid].vars.galleryAlreadyFullWindow = true;
            jQuery('#cgCenterImageFullwindowHeader'+gid).hide();
            jQuery('#cgCenterImageFullwindow'+gid).hide();
        }else{
            cgJsData[gid].vars.galleryAlreadyFullWindow = false;
            if(!cgJsClass.gallery.vars.fullwindow){
                jQuery('#cgCenterImageFullwindowHeader'+gid).show();
            }
            jQuery('#cgCenterImageFullwindow'+gid).show();
        }

    }
};