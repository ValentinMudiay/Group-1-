cgJsClass.gallery.views.singleViewClickEvents = {
    init: function ($) {

        $(document).on('click','.cg-center-image-info-div-title .cg-center-image-comments-div-add-comment',function () {
            $(this).hide();
            $(this).closest('.cg-center-image-comments-div-parent').find('.cg-center-image-comments-div-enter').slideDown();

        });
        $(document).on('click','.cg-center-image-comments-div-parent > .cg-center-image-comments-div-add-comment',function () {
            $(this).hide();
            $(this).closest('.cg-center-image-comments-div-parent').find('.cg-center-image-comments-div-enter').slideDown();

        });

        $(document).on('click','.cg-center-image-close',function () {

            var gid = $(this).closest('.cgCenterDiv').attr('data-cg-gid');
            var realId = $(this).attr('data-cg-actual-realId');

            cgJsClass.gallery.views.close(gid,false,realId);

        });

        $(document).on('click','.cg-center-arrow-left',function () {

            jQuery(window).off('hashchange');
            cgJsClass.gallery.vars.keypressStartInSeconds = new Date().getTime()/1000;

            // braucht man zur Orientierung zwecks hash change
            cgJsClass.gallery.vars.showImageClicked = true;

            var gid = $(this).closest('.cgCenterDiv').attr('data-cg-gid');

            var order = parseInt(cgJsData[gid].vars.openedGalleryImageOrder)-1;

            //cgJsClass.gallery.views.singleViewFunctions.setSliderMargin(order,gid,'left');
            cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,order,cgJsData[gid].vars.maximumVisibleImagesInSlider,cgJsData[gid].vars.mainCGslider);


            cgJsClass.gallery.views.singleView.openImage($,order,false,gid,'left');

            cgJsClass.gallery.hashchange.activateHashChangeEvent();

        });

        $(document).on('click','.cg-center-arrow-right',function () {

            jQuery(window).off('hashchange');
            cgJsClass.gallery.vars.keypressStartInSeconds = new Date().getTime()/1000;

            // braucht man zur Orientierung zwecks hash change
            cgJsClass.gallery.vars.showImageClicked = true;

            var gid = $(this).closest('.cgCenterDiv').attr('data-cg-gid');

            var order = parseInt(cgJsData[gid].vars.openedGalleryImageOrder)+1;


            // cgJsClass.gallery.views.singleViewFunctions.setSliderMargin(order,gid,'right');
            cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,order,cgJsData[gid].vars.maximumVisibleImagesInSlider,cgJsData[gid].vars.mainCGslider);

            cgJsClass.gallery.views.singleView.openImage($,order,false,gid,'right');

            cgJsClass.gallery.hashchange.activateHashChangeEvent();

        });

        $(document).on('click', '.cg_append, .cg_gallery_info, .cg_gallery_info_title, div[id^="cg_show"] .cg_gallery_info', function(e){

            if($(e.target).hasClass('cg_delete_user_image')){
                return;
            }

            var $mainCGallery = $(this).closest('.mainCGallery');
            var $mainCGslider = $(this).closest('.mainCGslider');

            var gid = $mainCGallery.attr('data-cg-gid');

            if(cgJsData[gid].options.pro.IsModernFiveStar==1 && cgJsData[gid].options.general.RatingOutGallery==1 && cgJsClass.gallery.vars.isMobile && !$(this).hasClass('cg-pass-through') && !cgJsClass.gallery.vars.passThrough){

                if(($(e.target).closest('.cg_gallery_rating_div_child').length==1 && $(e.target).closest('.cg-center-image-rating-div').length==0)
                    || ($(e.target).hasClass('.cg_gallery_rating_div_child') && $(e.target).closest('.cg-center-image-rating-div').length==0)){

                    if(!$mainCGslider.length){
                        return;
                    }
                }

            }

            if(cgJsData[gid].options.pro.IsModernFiveStar==1 && cgJsData[gid].options.general.AllowRating==1){
                if($mainCGslider.length>=1){
                    var $cg_show = $(this).closest('.cg_show');
                    if($cg_show.length>=1){
                        $cg_show.find('.cg_gallery_rating_div_five_star_details').addClass('cg_hide');
                    }
                }
            }


            $(this).removeClass('cg-pass-through');
            cgJsClass.gallery.vars.passThrough = false;

            // braucht man zur Orientierung zwecks hash change
            cgJsClass.gallery.vars.showImageClicked = true;


            cgJsClass.gallery.function.general.tools.checkErrorAbort(gid);

            var sliderView = false;

            if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
                sliderView = true;
            }

            if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
                sliderView = true;
            }

            if(cgJsData[gid].options.general.FullSizeImageOutGallery==1 && sliderView == false){
                return;
            }

            if(cgJsData[gid].options.general.OnlyGalleryView==1 && sliderView == false){
                return;
            }

            e.preventDefault();

            var $element = $(this);
            var order = $element.closest('.cg_show').attr('data-cg-order');
            cgJsClass.gallery.views.functions.appendAndRemoveImagesInSlider(gid,order,cgJsData[gid].vars.maximumVisibleImagesInSlider,cgJsData[gid].vars.mainCGslider);
            var firstKey = Object.keys(cgJsData[gid].image[order])[0];
            var realId = cgJsData[gid].image[order][firstKey]['id'];
            var isGalleryOpened = false;

            var initFullWindow = false;

            if(cgJsData[gid].options.pro.SliderFullWindow==1){// has to be set to false then that always opens full window
                initFullWindow = true;
            }

            if(((cgJsData[gid].options.general.FullSizeSlideOutStart==1 || cgJsData[gid].options.pro.SliderFullWindow==1)
                && cgJsClass.gallery.vars.fullwindow==null
                && cgJsData[gid].vars.galleryAlreadyFullWindow==false)
                ||(!cgJsClass.gallery.vars.fullwindow && initFullWindow==true)
            ){// cgJsData[gid].vars.galleryAlreadyFullWindow ganz wichtig!
                if(!sliderView){

                    // then rating must be clicked!!!!! SAME CONDITION IS BELOW, HAS TO BE SUMERRIZED
                    if(typeof $element.find('.cg_rate_star')[ 0 ] == 'undefined' && $element.hasClass('cg_gallery_info')){

                        if(cgJsData[gid].options.general.RatingOutGallery != '1'){
                            cgJsData[gid].vars.openedRealId = realId;
                            cgJsClass.gallery.views.fullwindow.openFunction(gid);
                        }else{
                            return;
                        }

                    }else{

                        cgJsData[gid].vars.openedRealId = realId;
                        cgJsClass.gallery.views.fullwindow.openFunction(gid);

                    }

                    // jQuery('#cg_append'+realId+'').click();
                    return;
                }

            }


            var isGalleryOpenedSliderLook = false;

            if($element.hasClass('cg_open_gallery')){
                $element.removeClass('cg_open_gallery');
                isGalleryOpened = true;
            }
            if($element.hasClass('cg_open_gallery_slider_look')){

                $element.removeClass('cg_open_gallery_slider_look');

                if(sliderView==true){
                    isGalleryOpenedSliderLook = true;
                }
            }

            var direction = undefined;
            if(typeof cgJsData[gid].vars.openedGalleryImageOrder != null){
                if(parseInt(order) >= parseInt(cgJsData[gid].vars.openedGalleryImageOrder)){
                    direction = 'right';
                }
                if(parseInt(order) < parseInt(cgJsData[gid].vars.openedGalleryImageOrder)){
                    direction = 'left';
                }
            }

            //cgJsClass.gallery.views.singleViewFunctions.setSliderMargin(order,gid,direction,isGalleryOpenedSliderLook,realId);

            // then rating must be clicked!!!!!
            if(typeof $element.find('.cg_rate_star')[ 0 ] == 'undefined' && $element.hasClass('cg_gallery_info')){

                if(cgJsData[gid].options.general.RatingOutGallery != '1'){
                    cgJsClass.gallery.views.singleView.openImage($,order,false,gid,direction,isGalleryOpened,isGalleryOpenedSliderLook);
                }else{
                    return;
                }

            }else{
                cgJsClass.gallery.views.singleView.openImage($,order,false,gid,direction,isGalleryOpened,isGalleryOpenedSliderLook);
            }


        });


    }
};