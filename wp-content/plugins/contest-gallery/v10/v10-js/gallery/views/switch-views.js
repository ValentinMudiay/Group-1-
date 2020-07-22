cgJsClass.gallery.views.switchView = {
    init: function () {

        jQuery(document).on('click', '.cg_header .cg_gallery_thumbs_control .cg_view_switcher', function(){

            var $element = jQuery(this);

            if($element.hasClass('cg_view_switcher_on')){
                return;
            }

            var mainCGallery = $element.closest('.mainCGdiv');
            var gid = mainCGallery.attr('data-cg-gid');

            // falls ein Bild geöffnet ist, muss alles zurückgesetzt werden!!!!
            if(cgJsData[gid].vars.openedRealId>0){
                cgJsClass.gallery.views.close(gid);
            }
            cgJsData[gid].vars.openedRealId = 0;

            cgJsData[gid].vars.cgCenterDivLastHeight = null;


            cgJsClass.gallery.vars.switchViewsClicked = true;
            cgJsData[gid].vars.openedGalleryImageOrder = null;
           // cgJsData[gid].vars.cgCenterDiv.css('display','none');

           // mainCGallery.find('.cg_view_switcher_off').removeClass('cg_hide');
            //mainCGallery.find('.cg_view_switcher_on').addClass('cg_hide');

            var $mainCGdiv = mainCGallery.closest('.mainCGdiv');

       //     console.log($mainCGdiv.find('.cg_gallery_thumbs_control').height());

       //     $mainCGdiv.find('.cg_gallery_view_sort_control').height($mainCGdiv.find('.cg_sort_div').height());
      //      $mainCGdiv.find('.cg_thumbs_and_categories_control').height($mainCGdiv.find('.cg_gallery_thumbs_control').height());
            $mainCGdiv.find('.cg_gallery_thumbs_control').height($mainCGdiv.find('.cg_gallery_thumbs_control').height());

            cgJsData[gid].vars.cgCenterDivLastHeight = null;

            // !IMPORTANT: zuerst das ausführen! Ansonsten scheint Höheberechnung problematisch wegen box-sizing was zum Springen des Contents führt!
            mainCGallery.find('.cg_view_switcher_on').addClass('cg_hide');

            mainCGallery.find('.cg_view_switcher_off').removeClass('cg_hide');
            mainCGallery.find('.mainCGslider').addClass('cg_hide');

            $element.addClass('cg_hide');

            // Cut data here or something like this if data length higher then PicsPerSite
            var $step = jQuery('#cgFurtherImagesContainerDiv'+gid).find('.cg_further_images[data-cg-step="1"]');
           // var $step = jQuery('#cgFurtherImagesContainerDiv'+gid).find('.cg_further_images[data-cg-step='+cgJsData[gid].vars.currentStep+']');

            if($element.hasClass('cg_view_height')){
                $mainCGdiv.find('.cg_further_images_container').removeClass('cg_hide');
                mainCGallery.find('.cg_view_switcher.cg_view_height.cg_view_switcher_on').removeClass('cg_hide');
                cgJsData[gid].options.general.SliderLook='0';
                cgJsData[gid].vars.currentLook='height';


                if($step.length>=1 && cgJsData[gid].vars.sorting != 'search'){
                    $step.addClass('cg_view_change').click();
                }else{
                    cgJsClass.gallery.heightLogic.init(jQuery,gid,null,null,null,true);
                }

            }
            if($element.hasClass('cg_view_thumb')){
                $mainCGdiv.find('.cg_further_images_container').removeClass('cg_hide');

                cgJsData[gid].options.general.SliderLook='0';
                mainCGallery.find('.cg_view_switcher.cg_view_thumb.cg_view_switcher_on').removeClass('cg_hide');
                cgJsData[gid].vars.currentLook='thumb';


                if($step.length>=1 && cgJsData[gid].vars.sorting != 'search'){
                    $step.addClass('cg_view_change').click();
                }else{
                    cgJsClass.gallery.thumbLogic.init(jQuery,gid,null,null,null,true);
                }

            }
            if($element.hasClass('cg_view_row')){
                $mainCGdiv.find('.cg_further_images_container').removeClass('cg_hide');

                mainCGallery.find('.cg_view_switcher.cg_view_row.cg_view_switcher_on').removeClass('cg_hide');
                cgJsData[gid].options.general.SliderLook='0';
                cgJsData[gid].vars.currentLook='row';


                if($step.length>=1 && cgJsData[gid].vars.sorting != 'search'){
                    $step.addClass('cg_view_change').click();
                }else{
                    cgJsClass.gallery.rowLogic.init(jQuery,gid,null,null,null,true);
                }

            }

            if($element.hasClass('cg_view_slider')){
                $mainCGdiv.find('.cg_further_images_container').addClass('cg_hide');


                $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');


                // sisable till slider fully loaded
                $mainCGdiv.find('.cg_gallery_thumbs_control .cg_view_switcher').addClass('cg_disabled');

                mainCGallery.find('.cg_view_switcher.cg_view_slider.cg_view_switcher_on').removeClass('cg_hide');
                cgJsData[gid].options.general.SliderLook='1';
                cgJsData[gid].vars.currentLook='thumb';
                cgJsClass.gallery.vars.hasToAppend = true;

                cgJsClass.gallery.views.switchView.sortViewSlider(gid);

                // if($step.length>=1){
                 //   $step.addClass('cg_view_change').click();
              //  }else{
                    cgJsClass.gallery.thumbLogic.init(jQuery,gid,true,null,null,null,true);
            //    }

            }


            cgJsClass.gallery.vars.switchViewsClicked=false;

        });


    },
    sortViewSlider: function (gid,cuttedDataSorted) {

        if(typeof cuttedDataSorted == 'dsafdsaf'){

            cgJsData[gid].image = cuttedDataSorted;

            if(cgJsData[gid].vars.sorting == 'random'){
                cgJsData[gid].vars.sortedRandomFullData = cuttedDataSorted;
            }
            else if(cgJsData[gid].vars.sorting == 'date-desc'){
                cgJsData[gid].vars.sortedDateDescFullData = cuttedDataSorted;
            }
            else if(cgJsData[gid].vars.sorting == 'date-asc'){
                cgJsData[gid].vars.sortedDateAscFullData = cuttedDataSorted;
            }
            else if(cgJsData[gid].vars.sorting == 'rating-desc'){
                cgJsData[gid].vars.sortedRatingDescFullData = cuttedDataSorted;
            }
            else if(cgJsData[gid].vars.sorting == 'rating-asc'){
                cgJsData[gid].vars.sortedRatingAscFullData = cuttedDataSorted;
            }
            else if(cgJsData[gid].vars.sorting == 'comments-desc'){
                cgJsData[gid].vars.sortedCommentsDescFullData = cuttedDataSorted;
            }
            else if(cgJsData[gid].vars.sorting == 'comments-asc'){
                cgJsData[gid].vars.sortedCommentsAscFullData = cuttedDataSorted;
            }

        }else{

            if(cgJsData[gid].vars.sorting == 'random'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedRandomFullData;
            }
            else if(cgJsData[gid].vars.sorting == 'date-desc'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedDateDescFullData;
            }
            else if(cgJsData[gid].vars.sorting == 'date-asc'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedDateAscFullData;
            }
            else if(cgJsData[gid].vars.sorting == 'rating-desc'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedRatingDescFullData;
            }
            else if(cgJsData[gid].vars.sorting == 'rating-asc'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedRatingAscFullData;
            }
            else if(cgJsData[gid].vars.sorting == 'comments-desc'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedCommentsDescFullData;
            }
            else if(cgJsData[gid].vars.sorting == 'comments-asc'){
                cgJsData[gid].image = cgJsData[gid].vars.sortedCommentsAscFullData;
            }
            else{
                cgJsData[gid].vars.sorting = 'date-desc';
                cgJsData[gid].image = cgJsClass.gallery.sorting.desc(cgJsData[gid].vars.rawData);
                cgJsClass.gallery.sorting.initSort(gid);
            }

        }

    },
    switch: function () {
        
    }
};