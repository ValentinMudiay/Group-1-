cgJsClass.gallery.sorting.initSortRandomButton = function (gid){

    jQuery(document).on( "click", ".cg_random_button", function() {

        cgJsClass.gallery.vars.hasToAppend = true;

        var gid = jQuery(this).attr('data-cg-gid');
        cgJsData[gid].vars.sortingLastSelected='random';

        var $element = jQuery(this);

        if(cgJsClass.gallery.function.general.tools.setWaitingForValues(gid,$element,'change')){
            return;
        }

        var sliderView = false;

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            sliderView = true;
        }

        if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
            sliderView = true;
        }

        cgJsData[gid].vars.sorting = 'random';

        // falls ein Bild geöffnet ist, muss alles zurückgesetzt werden!!!!
        if(cgJsData[gid].vars.openedRealId>0 && (!sliderView)){
            cgJsClass.gallery.views.close(gid);
        }

        if(cgJsData[gid].options.general.AllowSort==1){
            if(cgJsData[gid].vars.mainCGdiv.find('#cg_select_order'+gid).find('.cg_random_sort').length){// only if random option exists

                cgJsData[gid].vars.mainCGdiv.find('#cg_select_order'+gid).val("7");
            }
        }

        cgJsData[gid].image = cgJsClass.gallery.sorting.random(gid);

     //   var fullData = cgJsData[gid].fullImageData;
      //  var length = Object.keys(fullData).length;

        var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);

        // Cut data here or something like this if data length higher then PicsPerSite
        if(cgJsData[gid].image.length>PicsPerSite && sliderView == false){
            // click always step 1
            var $step = jQuery('#cgFurtherImagesContainerDiv'+gid).find('.cg_further_images[data-cg-step="1"]').addClass('cg_sorting_changed');
            $step.addClass('cg_random_button_clicked').click();
          //  var step = cgJsClass.gallery.dynamicOptions.checkIfStepClick();
           // cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,step,true,false,gid);
            cgJsClass.gallery.vars.hasToAppend = false;

        }else{
            // jQuery('#mainCGallery'+gid).find('.cg_show').remove();// Absolut wichtig für Thumb view! Sonst Width problem!
        }

/*
        if(cgJsData[gid].options.general.SliderLook==1){

            var $cgCenterDiv = jQuery('#cgCenterDiv'+gid);

            $cgCenterDiv.css(
                {
                    'width' : $cgCenterDiv.width(),
                    'min-height' : $cgCenterDiv.height()
                }
            );

        }
*/

        if(cgJsData[gid].vars.currentLook=='row'){
            cgJsClass.gallery.rowLogic.init(jQuery,gid);
        }
        if(cgJsData[gid].vars.currentLook=='height'){
            cgJsClass.gallery.heightLogic.init(jQuery,gid);
        }
        if(cgJsData[gid].vars.currentLook=='thumb'){

            if(sliderView==true){
                cgJsData[gid].vars.openedRealId = 0;
                jQuery('#mainCGdiv'+gid).find('#mainCGslider'+gid).find('.cg_show').remove();
            }

            if(cgJsData[gid].options.general.SliderLook==1){
                cgJsClass.gallery.thumbLogic.init(jQuery,gid,null,null,true,null,null,true);
            }else{
                cgJsClass.gallery.thumbLogic.init(jQuery,gid);
            }

        }

        cgJsClass.gallery.vars.hasToAppend = false;

    });

};
cgJsClass.gallery.sorting.showRandomButton = function (gid){
    // otherwise random button might unnecessary appear!
    if(Object.keys(cgJsData[gid].vars.rawData).length==0){
        var cgGalleryViewSortControl = jQuery('#mainCGdivHelperParent'+gid);// take from mainCGdivHelperParent because full window might be clicked instantly
        cgGalleryViewSortControl.find('.cg-lds-dual-ring').addClass('cg_hide');
        cgGalleryViewSortControl.find('.cg_random_button').addClass('cg_hide');
    }
    else if(Object.keys(cgJsData[gid].vars.rawData).length>0){
        setTimeout(function () {
            var cgGalleryViewSortControl = jQuery('#mainCGdivHelperParent'+gid);// take from mainCGdivHelperParent because full window might be clicked instantly
            cgGalleryViewSortControl.find('.cg-lds-dual-ring').addClass('cg_hide');
            cgGalleryViewSortControl.find('.cg_random_button').removeClass('cg_hide');
        },6000);
    }
};
cgJsClass.gallery.sorting.showRandomButtonInstantly = function (gid){// ALL three big requests has to be done before, image-data, sorting-data, info-data!

    // otherwise random button might unnecessary appear!
    if(Object.keys(cgJsData[gid].vars.rawData).length==0){
        var cgGalleryViewSortControl = jQuery('#mainCGdivHelperParent'+gid);// take from mainCGdivHelperParent because full window might be clicked instantly
        cgGalleryViewSortControl.find('.cg-lds-dual-ring').addClass('cg_hide');
        cgGalleryViewSortControl.find('.cg_random_button').addClass('cg_hide');
    }
    else if(Object.keys(cgJsData[gid].vars.rawData).length>0){
        var cgGalleryViewSortControl = jQuery('#mainCGdivHelperParent'+gid);// take from mainCGdivHelperParent because full window might be clicked instantly
        cgGalleryViewSortControl.find('.cg-lds-dual-ring').addClass('cg_hide');
        cgGalleryViewSortControl.find('.cg_random_button').removeClass('cg_hide');
    }

};
cgJsClass.gallery.sorting.showRandomButtonDelayed = function (gid,delayTime){// ALL three big requests has to be done before, image-data, sorting-data, info-data!

    setTimeout(function () {
        var cgGalleryViewSortControl = jQuery('#mainCGdivHelperParent'+gid);// take from mainCGdivHelperParent because full window might be clicked instantly
        cgGalleryViewSortControl.find('.cg-lds-dual-ring').addClass('cg_hide');
        cgGalleryViewSortControl.find('.cg_random_button').removeClass('cg_hide');
    },delayTime);

};