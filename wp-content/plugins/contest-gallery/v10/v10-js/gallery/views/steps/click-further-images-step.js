cgJsClass.gallery.views.clickFurtherImagesStep = {
    waitingInterval: null,
    init: function () {

        jQuery(document).on('click','.cg_further_images',function () {

            var $element = jQuery(this);

            var gid = $element.attr('data-cg-gid');

            if(cgJsClass.gallery.function.general.tools.setWaitingForValues(gid,$element,'click')){
                return;
            }

            var stepNumber = parseInt($element.attr('data-cg-step'));

            cgJsData[gid].vars.currentStep = stepNumber;

            var isViewChange = false;

            if($element.hasClass('cg_view_change')){
                $element.removeClass('cg_view_change');
                isViewChange = true;
            }
            var cg_sorting_changed = false;

            if($element.hasClass('cg_sorting_changed')){
                $element.removeClass('cg_sorting_changed');
                cg_sorting_changed = true;
            }
            var cg_random_button_clicked = false;

            if($element.hasClass('cg_random_button_clicked')){
                $element.removeClass('cg_random_button_clicked');
                cg_random_button_clicked = true;
            }

            var sliderView = false;

            if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
                sliderView = true;
            }


            if(cgJsData[gid].options.general.SliderLook==1 || sliderView==true){

                var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);

                var order = stepNumber*PicsPerSite-PicsPerSite;

           //     var openedRealId = jQuery('#mainCGslider'+gid).find('.cg_show[data-cg-order='+order+']').attr('data-cg-id');
                var imageData = cgJsData[gid].image[order];
                var firstKey = Object.keys(imageData)[0];
                var realId = imageData[firstKey]['id'];

                if(!isViewChange && !cg_sorting_changed && !cg_random_button_clicked){
                    cgJsData[gid].vars.openedRealId = realId;
                }

                cgJsClass.gallery.views.singleViewFunctions.setFurtherSteps(gid,order);

                jQuery('#mainCGallery'+gid+' + .cg_further_images_container').remove();

                if(cg_random_button_clicked){
                    cgJsClass.gallery.views.initOrderGallery(gid,null,null,true,true,null,true);
                    //cgJsClass.gallery.views.initOrderGallery(gid,null,null,true,null,true);
                    //cgJsClass.gallery.thumbLogic.init(jQuery,gid,null,null,true,null,null,true);

                }else{

                    if(isViewChange){
                        cgJsClass.gallery.views.initOrderGallery(gid,null,null,true,null,true);
                    }else{
                        cgJsClass.gallery.views.initOrderGallery(gid,null,null,true,true,null);
                    }

                }


            }else{

                // Pauschal für Slider Look notwendig damit diese Funktion richtig funktioniert
                if($element.hasClass('cg_random_button_clicked')){
                    $element.removeClass('cg_random_button_clicked');
                }

                cgJsClass.gallery.vars.hasToAppend = true;


                // falls ein Bild geöffnet ist, muss alles zurückgesetzt werden!!!!
                if(cgJsData[gid].vars.openedRealId>0){
                    cgJsClass.gallery.views.close(gid);
                }

                // hier am Anfang machen sonst funktioniert es nicht!
                // spring zum oberen further images falls das untere geklickt wurde
                /*            if(jQuery(this).closest('.cg_further_images_container').prev().hasClass('mainCGallery')){ // geht ehe nicht!!!!
                                jQuery('#cgFurtherImagesContainerDiv'+gid).cgGoTo();
                            }*/

                // height setzten damit es nicht springt weil empty und append von bildern gemacht wird
                jQuery('#mainCGallery'+gid).height(jQuery('#mainCGallery'+gid).height());

                if($element.hasClass('cg-center-arrow-right-next-step')){
                    var nextRealId = $element.attr('data-cg-step-next-real-id');
                    cgJsData[gid].vars.openedRealId = nextRealId;
                }

                if($element.hasClass('cg-center-arrow-left-prev-step')){
                    var prevRealId = $element.attr('data-cg-step-prev-real-id');
                    cgJsData[gid].vars.openedRealId = prevRealId;
                }

                if($element.hasClass('cg-center-arrow-right-next-step') || $element.hasClass('cg-center-arrow-right-next-step')){
                    setTimeout(function () {
                        jQuery('html').addClass('cg_scroll_behaviour_initial');
                        jQuery('body').addClass('cg_scroll_behaviour_initial');
                        cgJsData[gid].vars.cgCenterDivAppearenceHelper.removeClass('cg_hide');
                        cgJsData[gid].vars.mainCGdiv.get(0).scrollIntoView();
                        cgJsData[gid].vars.mainCGdiv.find('.cg_header').addClass('cg_pointer_events_none');
                        cgJsData[gid].vars.mainCGdiv.find('.cg_further_images_container').add('cg_pointer_events_none');
                        jQuery('html').removeClass('cg_scroll_behaviour_initial');
                        jQuery('body').removeClass('cg_scroll_behaviour_initial');
                        // to go sure remove it here also
                        setTimeout(function () {
                            cgJsData[gid].vars.mainCGdiv.find('.cg_header').removeClass('cg_pointer_events_none');
                            cgJsData[gid].vars.mainCGdiv.find('.cg_further_images_container').removeClass('cg_pointer_events_none');
                        },700);
                    },1);
                }

                cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,stepNumber,true,false,gid,null,null,isViewChange);

                // height wieder rausnehmen
                jQuery('#mainCGallery'+gid).height('auto');

                if(jQuery(this).hasClass('cg_cloned')){
                    location.href = '#cgFurtherImagesContainerDivPositionHelper'+gid;
                }

                // untere steps pauschal entfernen, aber erst hier
                jQuery('#mainCGallery'+gid).next('.cg_further_images_container').remove();


                if(cgJsClass.gallery.vars.isMobile==true){

                    jQuery('html').removeClass('cg_no_scroll');
                    jQuery('body').removeClass('cg_body_overflow_hidden');

                }

                /*                if($element.hasClass('cg-center-arrow-right-next-step')){
                                    var nextRealId = $element.attr('data-cg-step-next-real-id');
                                    jQuery('#cg_append'+nextRealId).click();
                                }

                                if($element.hasClass('cg-center-arrow-left-prev-step')){
                                    var prevRealId = $element.attr('data-cg-step-prev-real-id');
                                    jQuery('#cg_append'+prevRealId).click();
                                }*/

           //     setTimeout(function () {
            //        cgJsClass.gallery.views.cloneFurtherImagesStep(gid); // disabled since 31.07.2019
             //   },500);

            }



            // weil bilder neu appenden muss scroll gemacht werden


/*            jQuery('html, body').animate({
                scrollTop: jQuery('#mainCGallery'+gid).offset().top - 100+'px'
            }, 'fast');*/

          //  location.hash = 'mainCGallery'+gid;
           // jQuery('#mainCGallery'+gid).cgGoTo();

        });

    }
};