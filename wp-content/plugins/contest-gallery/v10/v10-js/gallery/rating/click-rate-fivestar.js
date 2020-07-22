cgJsClass.gallery.rating.setDetailsPositionInSlider = function (gid,realId,$cg_gallery_rating_div_child) {

    return;// should not be visible in slider anymore

    var $cg_gallery_rating_div_five_star_details = $cg_gallery_rating_div_child.find('.cg_gallery_rating_div_five_star_details');

    var sliderView = false;

    if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
        sliderView = true;
    }

    if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
        sliderView = true;
    }

    // remove in general at the beginning
    $cg_gallery_rating_div_five_star_details.removeAttr('style');
    $cg_gallery_rating_div_five_star_details.find('progress').removeAttr('style');

    if(sliderView && $cg_gallery_rating_div_child.closest('.mainCGslider').length){

        var $cgShow = $cg_gallery_rating_div_child.closest('#cg_show'+realId);
        var positionTop = $cgShow.find('#cgGalleryInfo'+realId).position().top*-1-5;
        var marginLeft = $cgShow.find('#cg_gallery_rating_div'+realId).position().left*-1;
        $cg_gallery_rating_div_five_star_details.css({'top':positionTop+'px','margin-left':marginLeft+'px'});
        var cg_gallery_rating_div_five_star_details_WIDTH = $cg_gallery_rating_div_five_star_details.removeClass('cg_hide').outerWidth();
        var cg_gallery_rating_div_five_star_details_HEIGHT = $cg_gallery_rating_div_five_star_details.height();
        $cg_gallery_rating_div_five_star_details.addClass('cg_hide');

        var widthDifference = $cgShow.outerWidth()-cg_gallery_rating_div_five_star_details_WIDTH;
        var progressWidth = $cg_gallery_rating_div_five_star_details.find('progress').first().width();
        var progressNewWidth = progressWidth+widthDifference;
        $cg_gallery_rating_div_five_star_details.find('progress').width(progressNewWidth);
        $cg_gallery_rating_div_five_star_details.height(cg_gallery_rating_div_five_star_details_HEIGHT+4);

    }

};
cgJsClass.gallery.rating.clickRateFiveStar = function (gid) {

    if(cgJsClass.gallery.vars.isMobile){

        jQuery( document ).on('click','body.cg_gallery_rating_div_five_star_details_is_opened',function(e) {
            e.preventDefault();
             if(jQuery(e.target).closest('.cg_gallery_rating_div_child').length>=1){
                 return;
             }else{
                var $cg_gallery_rating_div_five_star_details_is_opened = jQuery('#cg_gallery_rating_div_five_star_details_is_opened');
                if($cg_gallery_rating_div_five_star_details_is_opened.length>=1){
                    $cg_gallery_rating_div_five_star_details_is_opened.addClass('cg_hide');
                    $cg_gallery_rating_div_five_star_details_is_opened.removeAttr('id');
                    jQuery(this).removeClass('.cg_gallery_rating_div_five_star_details_is_opened');
                }
             }

        });

        jQuery( document ).on( 'click', '.cg_gallery_rating_div_child.cg_gallery_rating_div_child_five_star', function(e) {
            e.preventDefault();

            var gid = jQuery(this).attr('data-cg-gid');
            var realId = jQuery(this).attr('data-cg-real-id');

            if(cgJsData[gid].options.pro.IsModernFiveStar==1){


                if(jQuery(this).find('.cg_gallery_rating_div_five_star_details').hasClass('cg_hide')){

                    cgJsClass.gallery.rating.setDetailsPositionInSlider(gid,realId,jQuery(this));

                    var $cg_gallery_rating_div_five_star_details_is_opened = jQuery('#cg_gallery_rating_div_five_star_details_is_opened');
                    if($cg_gallery_rating_div_five_star_details_is_opened.length>=1){
                        $cg_gallery_rating_div_five_star_details_is_opened.addClass('cg_hide');
                        $cg_gallery_rating_div_five_star_details_is_opened.removeAttr('id');
                    }

                    jQuery(this).find('.cg_gallery_rating_div_five_star_details').removeClass('cg_hide');
                    jQuery(this).find('.cg_gallery_rating_div_five_star_details').attr('id','cg_gallery_rating_div_five_star_details_is_opened');
                    jQuery('body').addClass('cg_gallery_rating_div_five_star_details_is_opened');
                }else{

                }

            }
        });

        jQuery( document ).on( 'click', '.mainCGslider .cg_gallery_rating_div_five_star_details', function(e) {
            e.preventDefault();
            var $element = jQuery(this);
         //   setTimeout(function () {
                var gid = $element.attr('data-cg-gid');
                var realId = $element.attr('data-cg-real-id');

                var $toClick = jQuery('#mainCGslider'+gid+' .cgGalleryInfo'+realId);
              //  $toClick.addClass('cg-pass-through');
            cgJsClass.gallery.vars.passThrough = true;
                $toClick.click();
   //         },10);

        });

    }else{ // if not mobile!!!!
        jQuery( document ).on( 'mousemove', '.cg_gallery_rating_div_child.cg_gallery_rating_div_child_five_star', function(e) {

            e.preventDefault();

            var gid = jQuery(this).attr('data-cg-gid');
            var realId = jQuery(this).attr('data-cg-real-id');

            var sliderView = false;

            if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
                sliderView = true;
            }

            if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
                sliderView = true;
            }

            var $mainCGslider = jQuery(this).closest('.mainCGslider');

            if(sliderView && $mainCGslider.length){// remove only in slider! Do not remove in single view!
                return;
            }


            if(cgJsData[gid].options.pro.IsModernFiveStar==1){
                if(cgJsData[gid].options.general.HideUntilVote == 1 && (cgJsData[gid].cgJsCountRuser[realId] == 0 || typeof cgJsData[gid].cgJsCountRuser[realId] == 'undefined')){
                    return;
                }
            }

            if(cgJsData[gid].options.pro.IsModernFiveStar==1 && !cgJsClass.gallery.vars.isMobile){

             //   if($mainCGslider.length){

                    cgJsClass.gallery.rating.setDetailsPositionInSlider(gid,realId,jQuery(this));

          //      }

                if(jQuery(e.target).hasClass('.cg_gallery_rating_div_child ') || jQuery(e.target).closest('.cg_gallery_rating_div_child').length>=1){
                    var $cg_gallery_rating_div_five_star_details = jQuery(this).find('.cg_gallery_rating_div_five_star_details');
                    $cg_gallery_rating_div_five_star_details.removeAttr('style');//remove margin-left

                    if((cgJsData[gid].options.visual.RatingPositionGallery==3 || cgJsData[gid].vars.currentLook=='row') && !sliderView){// most like right space is very low in this cases
                        // calculation if margn left required
                        var windowWidth = jQuery(window).width();
                        var eventuallyMinusMarginLeftToSet = $cg_gallery_rating_div_five_star_details.offset().left+$cg_gallery_rating_div_five_star_details.width()-windowWidth+25;//+16=average scrollbar width, but some space left also requied
                        if(eventuallyMinusMarginLeftToSet>0){
                            $cg_gallery_rating_div_five_star_details.css('margin-left','-'+eventuallyMinusMarginLeftToSet+'px');
                        }
                    }

                    if(sliderView && (cgJsClass.gallery.vars.fullwindow || cgJsClass.gallery.vars.fullscreen)){
                        $cg_gallery_rating_div_five_star_details.addClass('cg_hidden').removeClass('cg_hide');// this way real outerHeight can be get
                        var topToSet = $cg_gallery_rating_div_five_star_details.outerHeight()+4;
                        $cg_gallery_rating_div_five_star_details.css('top','-'+topToSet+'px');
                    }else{
                        $cg_gallery_rating_div_five_star_details.removeAttr('style');
                    }

                    $cg_gallery_rating_div_five_star_details.removeClass('cg_hidden cg_hide cg_fade_out');

                }else{
                    jQuery(this).find('.cg_gallery_rating_div_five_star_details').addClass('cg_hide');
                }
            }

        });
        jQuery( document ).on( 'mouseleave', '.cg_gallery_rating_div_child.cg_gallery_rating_div_child_five_star', function(e) {
            e.preventDefault();
            var gid = jQuery(this).attr('data-cg-gid');
            if(cgJsData[gid].options.pro.IsModernFiveStar==1 && !cgJsClass.gallery.vars.isMobile){
                jQuery(this).find('.cg_gallery_rating_div_five_star_details').addClass('cg_hide');
            }
        });
    }




    jQuery( document ).on( 'click', '.cg_rate_star_five_star,.cg_rate_minus.cg_rate_minus_five_star', function(e) {
        e.preventDefault();

        var gid = jQuery(this).attr('data-cg-gid');

        var $cg_gallery_rating_div_child = jQuery(this).closest('.cg_gallery_rating_div_child');

        if(cgJsData[gid].options.pro.IsModernFiveStar==1 && cgJsClass.gallery.vars.isMobile){

            if($cg_gallery_rating_div_child.find('.cg_gallery_rating_div_five_star_details').hasClass('cg_hide')){
                return;
            }

        }

        if((cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow) || (cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1)){

            // then clicked from slider preview
            if(jQuery(this).closest('.mainCGslider').length>=1){

                return;

            }

        }

        var minusVoteNow = 0;

        if(jQuery(this).hasClass('cg_rate_out_gallery_disallowed') && cgJsData[gid].options.general.RatingOutGallery!='1'){
            return;
        }

        if(cgJsData[gid].options.general.AllowRating!='1'){
            return;
        }

        if(jQuery(this).parent().parent().parent().parent().hasClass('cg_gallery_info')){
            var order = jQuery(this).closest('.cg_show').attr('data-cg-order');
            if(cgJsData[gid].vars.openedGalleryImageOrder!=order && cgJsData[gid].options.general.RatingOutGallery!='1'){
                cgJsClass.gallery.views.singleView.openImage(jQuery,order,false,gid);
            }
        }

        if(cgJsData[gid].vars.cg_check_login==1 && cgJsData[gid].vars.cg_user_login_check==0){
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.OnlyRegisteredUsersCanVote);
            return false;
        }


        if(cgJsData[gid].options.pro.MinusVote==1 && jQuery(this).hasClass('cg_rate_minus')){
            minusVoteNow = 1;
        }

        var cg_picture_id = jQuery(this).attr('data-cg_rate_star_id');

        var cg_rate_value = 1;

        if(!jQuery(this).hasClass('cg_rate_minus')){
            cg_rate_value = jQuery(this).attr('data-cg_rate_star');
        }

        var imageObject = cgJsData[gid].imageObject[cg_picture_id];
        imageObject.find('.cg_gallery_rating_div_child').empty().addClass('cg-lds-dual-ring-star-loading');
        var isFromSingleView = false;

        if(jQuery(this).closest('.cgCenterDiv').length>=1){
            isFromSingleView = true;
        }


        var cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;
        if(cgCenterDiv.is(':visible')){
            if(cgJsData[gid].vars.openedRealId==cg_picture_id){
                cgCenterDiv.find('.cg_gallery_rating_div_child').empty().addClass('cg-lds-dual-ring-star-loading');
            }
        }

        jQuery.ajax({
            url : post_cg_rate_v10_fiveStar_wordpress_ajax_script_function_name.cg_rate_v10_fiveStar_ajax_url,
            type : 'post',
            data : {
                action : 'post_cg_rate_v10_fiveStar',
                gid : cgJsData[gid].vars.gidReal,
                galeryIDuser : gid,
                pid : cg_picture_id,
                value : cg_rate_value,
                minusVoteNow : minusVoteNow,
                galleryHash : cgJsData[gid].vars.galleryHash,
                isFromSingleView : isFromSingleView
            }
            }).done(function(response) {

                var parser = new DOMParser();
                var parsedHtml = parser.parseFromString(response, 'text/html');

                jQuery(parsedHtml).find('script[data-cg-processing="true"]').each(function () {

                    var script = jQuery(this).html();
                    eval(script);

                });


        }).fail(function(xhr, status, error) {

            cgJsClass.gallery.rating.setRatingFiveStar(cg_picture_id,0,0,false,gid,false,false);

        }).always(function() {

        });


    });

};