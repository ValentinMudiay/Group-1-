cgJsClass.gallery.sorting.init = function () {

    cgJsClass.gallery.sorting.initSortRandomButton();
    
    jQuery(document).on( "change", ".cg_select_order", function(){

        var gid = jQuery(this).closest('.mainCGdiv').attr('data-cg-gid');

        var $element = jQuery(this);

        if(cgJsClass.gallery.function.general.tools.setWaitingForValues(gid,$element,'change')){
            return;
        }

        cgJsClass.gallery.vars.hasToAppend = true;


        var sliderView = false;

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            sliderView = true;
        }

        if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
            sliderView = true;
        }

        // falls ein Bild geöffnet ist, muss alles zurückgesetzt werden!!!!
        if(cgJsData[gid].vars.openedRealId>0){
            cgJsClass.gallery.views.close(gid);
        }
        cgJsData[gid].vars.openedRealId = 0;

        if(jQuery(this).find('.cg_date_descend').prop('selected')==true){
            cgJsData[gid].vars.sorting='date-desc';
            cgJsData[gid].vars.sortingLastSelected='date-desc';
            cgJsClass.gallery.sorting.initSort(gid);
        }

        if(jQuery(this).find('.cg_date_ascend').prop('selected')==true){
            cgJsData[gid].vars.sorting='date-asc';
            cgJsData[gid].vars.sortingLastSelected='date-asc';
            cgJsClass.gallery.sorting.initSort(gid);
        }

        if(jQuery(this).find('.cg_rating_descend').prop('selected')==true){
            cgJsData[gid].vars.sorting='rating-desc';
            cgJsClass.gallery.sorting.initSort(gid);
        }
        if(jQuery(this).find('.cg_rating_ascend').prop('selected')==true){
            cgJsData[gid].vars.sorting='rating-asc';
            cgJsData[gid].vars.sortingLastSelected='rating-asc';
            cgJsClass.gallery.sorting.initSort(gid);
        }
        if(jQuery(this).find('.cg_rating_descend_average').prop('selected')==true){
            cgJsData[gid].vars.sorting='rating-desc-average';
            cgJsData[gid].vars.sortingLastSelected='rating-desc-average';
            cgJsClass.gallery.sorting.initSort(gid);
        }
        if(jQuery(this).find('.cg_rating_ascend_average').prop('selected')==true){
            cgJsData[gid].vars.sorting='rating-asc-average';
            cgJsData[gid].vars.sortingLastSelected='rating-asc-average';
            cgJsClass.gallery.sorting.initSort(gid);
        }

        if(jQuery(this).find('.cg_comments_descend').prop('selected')==true){
            cgJsData[gid].vars.sorting='comments-desc';
            cgJsData[gid].vars.sortingLastSelected='comments-desc';
            cgJsClass.gallery.sorting.initSort(gid);
        }
        if(jQuery(this).find('.cg_comments_ascend').prop('selected')==true){
            cgJsData[gid].vars.sorting='comments-asc';
            cgJsData[gid].vars.sortingLastSelected='comments-asc';
            cgJsClass.gallery.sorting.initSort(gid);
        }

        if(jQuery(this).find('.cg_random_sort').prop('selected')==true){
            cgJsData[gid].vars.sorting='random';
            cgJsData[gid].vars.sortingLastSelected='random';
            cgJsClass.gallery.sorting.initSort(gid);
        }

        // !important, will be proccessed later
            // will be processed later
            cgJsData[gid].fullImageDataFiltered = cgJsData[gid].image;

            var fullData = cgJsData[gid].fullImageDataFiltered;
            var length = Object.keys(fullData).length;

            var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);

            // Cut data here or something like this if data length higher then PicsPerSite
        if(length > PicsPerSite && sliderView == false){

            var $step = jQuery('#cgFurtherImagesContainerDiv'+gid).find('.cg_further_images[data-cg-step="'+cgJsData[gid].vars.currentStep+'"]').addClass('cg_sorting_changed');
            $step.click();

          //  var step = cgJsClass.gallery.dynamicOptions.checkIfStepClick();
            //cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,step,true,false,gid);
            cgJsClass.gallery.vars.hasToAppend = false;

            return;

        }else{
         //   jQuery('#mainCGallery'+gid).find('.cg_show').remove();// Absolut wichtig für Thumb view! Sonst Width problem!
        }


        if(cgJsData[gid].vars.currentLook=='row'){
            cgJsClass.gallery.rowLogic.init(jQuery,gid);
        }
        if(cgJsData[gid].vars.currentLook=='height'){
            cgJsClass.gallery.heightLogic.init(jQuery,gid);
        }
        if(cgJsData[gid].vars.currentLook=='thumb'){

            if(sliderView==true){
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
cgJsClass.gallery.sorting.initSort = function(gid,filtered){

    if(typeof filtered == 'undefined'){
        var filtered = cgJsClass.gallery.function.general.checkFiltered(gid);
    }

    if(cgJsData[gid].vars.sorting=='date-desc'){
      //  if(filtered==true){
            var newData = cgJsClass.gallery.sorting.sortByRowIdFiltered(gid);
     //   }else{
          //  var newData = cgJsClass.gallery.sorting.sortByRowId(gid);
      //  }
        cgJsData[gid].image = cgJsClass.gallery.sorting.desc(newData);
        cgJsData[gid].vars.sortedDateDescFullData = cgJsData[gid].image.slice(0);
    }

    if(cgJsData[gid].vars.sorting=='date-asc'){
     //   if(filtered==true){
            var newData = cgJsClass.gallery.sorting.sortByRowIdFiltered(gid);
      //  }else{
      //      var newData = cgJsClass.gallery.sorting.sortByRowId(gid);
       // }
        cgJsData[gid].image = cgJsClass.gallery.sorting.asc(newData);
        cgJsData[gid].vars.sortedDateAscFullData = cgJsData[gid].image.slice(0);

    }

    if(cgJsData[gid].vars.sorting=='rating-desc'){

        if(cgJsData[gid].options.general.AllowRating==2){
            var newData = cgJsClass.gallery.sorting.countS(gid);
        }

        if(cgJsData[gid].options.general.AllowRating==1){
            var newData = cgJsClass.gallery.sorting.countR(gid);
        }

        cgJsData[gid].image = cgJsClass.gallery.sorting.desc(newData);
        cgJsData[gid].vars.sortedRatingDescFullData = cgJsData[gid].image.slice(0);

    }

    if(cgJsData[gid].vars.sorting=='rating-asc'){

        if(cgJsData[gid].options.general.AllowRating==2){
            var newData = cgJsClass.gallery.sorting.countS(gid);
        }
        if(cgJsData[gid].options.general.AllowRating==1){
            var newData = cgJsClass.gallery.sorting.countR(gid);
        }

        cgJsData[gid].image = cgJsClass.gallery.sorting.asc(newData);
        cgJsData[gid].vars.sortedRatingAscFullData = cgJsData[gid].image.slice(0);

    }

    if(cgJsData[gid].vars.sorting=='rating-desc-average'){

        if(cgJsData[gid].options.general.AllowRating==1){
            var newData = cgJsClass.gallery.sorting.countRaverage(gid);
        }

        cgJsData[gid].image = cgJsClass.gallery.sorting.desc(newData);
        cgJsData[gid].vars.sortedRatingDescAverageFullData = cgJsData[gid].image.slice(0);

    }

    if(cgJsData[gid].vars.sorting=='rating-asc-average'){

        if(cgJsData[gid].options.general.AllowRating==1){
            var newData = cgJsClass.gallery.sorting.countRaverage(gid);
        }

        cgJsData[gid].image = cgJsClass.gallery.sorting.asc(newData);
        cgJsData[gid].vars.sortedRatingAscAverageFullData = cgJsData[gid].image.slice(0);

    }



    if(cgJsData[gid].vars.sorting=='comments-desc'){
        var newData = cgJsClass.gallery.sorting.countC(gid);
        cgJsData[gid].image = cgJsClass.gallery.sorting.desc(newData);
        cgJsData[gid].vars.sortedCommentsDescFullData = cgJsData[gid].image.slice(0);

    }
    if(cgJsData[gid].vars.sorting=='comments-asc'){
        var newData = cgJsClass.gallery.sorting.countC(gid);
        cgJsData[gid].image = cgJsClass.gallery.sorting.asc(newData);
        cgJsData[gid].vars.sortedCommentsAscFullData = cgJsData[gid].image.slice(0);
    }

    if(cgJsData[gid].vars.sorting=='random'){
        cgJsData[gid].image = cgJsClass.gallery.sorting.random(gid);
    }

};
cgJsClass.gallery.sorting.returnFullImageDataSorted = function(gid){

    // Array will be returned
    var fullImageDataToUse;

    if(cgJsData[gid].vars.sorting == 'random'){
        fullImageDataToUse = cgJsData[gid].vars.sortedRandomFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'date-desc'){
        fullImageDataToUse = cgJsData[gid].vars.sortedDateDescFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'date-asc'){
        fullImageDataToUse = cgJsData[gid].vars.sortedDateAscFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'rating-desc'){
        fullImageDataToUse = cgJsData[gid].vars.sortedRatingDescFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'rating-asc'){
        fullImageDataToUse = cgJsData[gid].vars.sortedRatingAscFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'rating-desc-average'){
        fullImageDataToUse = cgJsData[gid].vars.sortedRatingDescAverageFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'rating-asc-average'){
        fullImageDataToUse = cgJsData[gid].vars.sortedRatingAscAverageFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'comments-desc'){
        fullImageDataToUse = cgJsData[gid].vars.sortedCommentsDescFullData;
    }
    else if(cgJsData[gid].vars.sorting == 'comments-asc'){
        fullImageDataToUse = cgJsData[gid].vars.sortedCommentsAscFullData;
    }else{
        fullImageDataToUse = cgJsData[gid].fullImageDataFiltered;
    }

    return fullImageDataToUse;

};
