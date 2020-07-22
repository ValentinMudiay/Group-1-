cgJsClass.gallery.views.initSingleViewScroll = function (){

    //*= benutzen, falls die zweite classe nicht mit -parent endet

    jQuery(document).on('click','.cg-scroll-info-single-image-view .cg-top-bottom-arrow:first-child',function () {

        var $object = jQuery(this);
        cgJsClass.gallery.views.scrollInfoOrCommentTop($object);

    });


    jQuery(document).on('click','.cg-scroll-info-single-image-view .cg-top-bottom-arrow:last-child',function () {

        var $object = jQuery(this);
        cgJsClass.gallery.views.scrollInfoOrCommentBottom($object);

    });

    // mousehold actions
    var interval;

    jQuery(document).on('mousedown','.cg-scroll-info-single-image-view .cg-top-bottom-arrow:first-child',function () {

        var $object = jQuery(this);

        interval = setInterval(function() {
            cgJsClass.gallery.views.scrollInfoOrCommentTop($object);
        },100);

    });
    jQuery(document).on('mousedown','.cg-scroll-info-single-image-view .cg-top-bottom-arrow:last-child',function () {

        var $object = jQuery(this);

        interval = setInterval(function() {
            cgJsClass.gallery.views.scrollInfoOrCommentBottom($object);
        },100);

    });

    jQuery(document).on('mouseup',function () {

        clearInterval(interval);

    });

};
cgJsClass.gallery.views.scrollInfoOrCommentTopFullHeight = function (gid){

    var $element = jQuery('#cgCenterImageCommentsDiv'+gid);
    var $elementParent = jQuery('#cgCenterImageCommentsDivParentParent'+gid);

    if($element.length){
        $element.scrollTop(0);
        if($elementParent.find('.cg-top-bottom-arrow:first-child').length){
            if($elementParent.find('.cg-top-bottom-arrow:first-child').is(':visible')){
                $elementParent.find('.cg-top-bottom-arrow:first-child').addClass('cg_no_scroll');
            }
        }
        if($elementParent.find('.cg-top-bottom-arrow:last-child').length){
            if($elementParent.find('.cg-top-bottom-arrow:last-child').is(':visible')){
                $elementParent.find('.cg-top-bottom-arrow:last-child').removeClass('cg_no_scroll');
            }
        }
    }

};
cgJsClass.gallery.views.scrollInfoOrCommentTop = function ($object){

    var gid = $object.attr('data-cg-gid');

    $object.parent().find('.cg-top-bottom-arrow:last-child').removeClass('cg_no_scroll');

   // var $scrollElement = $object.closest('.cg-scroll-info-single-image-view').find('[class*="-parent"]');
    var $scrollElement = $object.closest('.cg-scroll-info-single-image-view').find('.cg-center-image-info-div-parent-padding');
    $scrollElement.scrollTop($scrollElement.scrollTop()-50);

/*
    var noSlideOut = false;

    if(cgJsData[gid].options.general.FullSizeImageOutGallery==1 || cgJsData[gid].options.general.OnlyGalleryView==1){
        noSlideOut = true;
    }
*/

    if($scrollElement.scrollTop()==0){
       // if(noSlideOut==false){
            $object.addClass('cg_no_scroll');
       // }
    }else{
        $object.removeClass('cg_no_scroll');
    }
};
cgJsClass.gallery.views.scrollInfoOrCommentBottom = function ($object){

    var gid = $object.attr('data-cg-gid');

    $object.parent().find('.cg-top-bottom-arrow:first-child').removeClass('cg_no_scroll');

   // var $scrollElement = $object.closest('.cg-scroll-info-single-image-view').find('[class*="-parent"]');
    var $scrollElement = $object.closest('.cg-scroll-info-single-image-view').find('.cg-center-image-info-div-parent-padding');
    $scrollElement.scrollTop($scrollElement.scrollTop()+50);

    var countHeight = 0;

    $scrollElement.find('.cg-center-image-info-div, .cg-center-image-comments-div').each(function () {

        // +10 because of margin bottom 10px
        countHeight = countHeight + jQuery(this).height()+0;

    });

    var scrollCheck = $scrollElement.scrollTop()+$scrollElement.height();
    var scrollHeightElement = countHeight;
/*


    var noSlideOut = false;

    if(cgJsData[gid].options.general.FullSizeImageOutGallery==1 || cgJsData[gid].options.general.OnlyGalleryView==1){
        noSlideOut = true;
    }
*/

    if(scrollCheck>=scrollHeightElement){
  //      if(noSlideOut==false){
            $object.addClass('cg_no_scroll');
    //    }
    }
    else{
        $object.removeClass('cg_no_scroll');
    }

};
cgJsClass.gallery.comment.scrollInterval = null;
