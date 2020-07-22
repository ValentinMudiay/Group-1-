cgJsClass.gallery.resize = {
    init: function ($) {

        $( window ).resize(function(e){

            cgJsClass.gallery.vars.isMobileStatusBefore = cgJsClass.gallery.vars.isMobile;
            var event = e;

            cgJsClass.gallery.function.general.mobile.check();

            var timeout = 0;

            if(cgJsClass.gallery.vars.isMobileStatusBefore!=cgJsClass.gallery.vars.isMobile){// then developer tools must be used!
                timeout = 10;
            }

            setTimeout(function () {

                jQuery(window).off('hashchange');

                cgJsClass.gallery.upload.resizeAllForms();

                cgJsClass.gallery.vars.keypressStartInSeconds = new Date().getTime()/1000;

                // prüfen ob sich die Breite überhaupt verändert hat!
                //  if(cgJsClass.gallery.vars.isMobile==true){


                if(cgJsClass.gallery.vars.isMobile==true){
                    var screenWidth = screen.width;
                }else{
                    var screenWidth = $(window).width();
                }

                var screenWidthMore = screenWidth+4;
                var screenWidthLess = screenWidth-4;
                if(cgJsClass.gallery.vars.windowWidthLastResize>screenWidthLess && cgJsClass.gallery.vars.windowWidthLastResize<screenWidthMore){
                    // cgJsClass.gallery.vars.windowWidthLastResize=screenWidth;
                    return;
                }
                cgJsClass.gallery.vars.windowWidthLastResize=screenWidth;

                cgJsClass.gallery.categories.setRemoveTitleAttributeForSmallWindow();


                // fullScreen condition. Im Moment irrelevant.
                if(cgJsClass.gallery.vars.fullscreenStartOpenImage==true){
                    return;
                }
                $('.mainCGallery').each(function(index){

                    var gid = $(this).attr('data-cg-gid');

                    //cgJsClass.gallery.views.fullwindow.checkIfGalleryAlreadyFullWindow(gid);

                    if(cgJsClass.gallery.vars.messageContainerShown==true){
                        cgJsClass.gallery.function.message.resize();
                    }

                    //cgJsClass.gallery.views.closeCenterDiv(gid);

                    if(cgJsData[gid].vars.currentLook=='height'){
                        cgJsClass.gallery.heightLogic.init($,gid);
                    }
                    if(cgJsData[gid].vars.currentLook=='thumb'){
                        cgJsClass.gallery.thumbLogic.init($,gid);
                    }
                    if(cgJsData[gid].vars.currentLook=='row'){
                        cgJsClass.gallery.rowLogic.init($,gid);
                    }

                    if(cgJsData[gid].vars.openedRealId>=1){

                        cgJsData[gid].vars.cgCenterDiv.css('display','none');
                        //     setTimeout(function () {
                        //  jQuery('#cg_show'+cgJsData[gid].vars.openedRealId+' .cg_append').click();
                        //    },300);
                    }

                    //    cgJsClass.gallery.resize.resizeInfo(gid);

                });

                cgJsClass.gallery.hashchange.activateHashChangeEvent();

            },timeout);


        });

    },
    setTimeOut: function () {

    },
    resizeCenter: function (cgCenterDiv,gid,mainCGalleryWidth) {

        var AllowComments = cgJsData[gid].options.general.AllowComments;
        if(mainCGalleryWidth<=10000 || AllowComments!=1){

            cgCenterDiv.find('#cgCenterImageDivButtons'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageDiv'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterInfoDiv'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageRatingDiv'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageFbLikeDiv'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('.cg-center-info-div').removeClass('cg_single_view_full_width');

            return true;

        }
        else{

            cgCenterDiv.find('#cgCenterImageDivButtons'+gid).removeClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageDiv'+gid).removeClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterInfoDiv'+gid).removeClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageRatingDiv'+gid).removeClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageFbLikeDiv'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('.cg-center-info-div').addClass('cg_single_view_full_width');

            return false;

        }

    },
    resizeInfoAndCommentAreas: function (cgCenterDiv,gid,mainCGalleryWidth) {

        var AllowComments = cgJsData[gid].options.general.AllowComments;

        if(mainCGalleryWidth<=680 || AllowComments!=1){

            cgCenterDiv.find('#cgCenterImageInfoDivParent'+gid).addClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageCommentsDivParent'+gid).addClass('cgHundertPercentWidth');

            return true;

        }
        else{

            cgCenterDiv.find('#cgCenterImageInfoDivParent'+gid).removeClass('cgHundertPercentWidth');
            cgCenterDiv.find('#cgCenterImageCommentsDivParent'+gid).removeClass('cgHundertPercentWidth');

            return false;

        }

    },
    offsetThumbCheckToCompare: 0,
    collectedWidth: 0,
    thumbSingleViewResize: function (cgCenterDiv,gid) {

        cgJsClass.gallery.resize.collectedWidth = 0;

        jQuery(cgJsData[gid].image).each(function (index) {

            var firstKey = Object.keys(cgJsData[gid].image[index])[0];
            var offset = cgJsData[gid].image[index][firstKey]['imageObject'].offset().top;
            var offsetThumbCheckToCompare=cgJsClass.gallery.resize.offsetThumbCheckToCompare;
            if(offset>offsetThumbCheckToCompare && offsetThumbCheckToCompare != 0){
                var collectedWidth = cgJsClass.gallery.resize.collectedWidth;
                cgCenterDiv.css('width',collectedWidth+'px');
            }
            else{
                cgJsClass.gallery.resize.collectedWidth = cgJsClass.gallery.resize.collectedWidth + cgJsData[gid].image[index][firstKey]['imageObject'].outerWidth(true);
                cgJsClass.gallery.resize.offsetThumbCheckToCompare = cgJsData[gid].image[index][firstKey]['imageObject'].offset().top;
            }

        });
        return;

        // old code
        /*
                if(cgJsData[index].vars.currentLook=='thumb'){

                    var offsetThumbCheck = 0;
                    var collectedWidth = 0;
                    var i = 0;

                    var cgCenterThumbView = function(collectedWidth,offsetThumbCheck,i){
                        var firstKey = Object.keys(cgJsData[gid].image[i])[0];

                        var offsetThumbCheckToCompare = cgJsData[gid].image[i][firstKey]['imageObject'].offset().top;

                        if(offsetThumbCheckToCompare > offsetThumbCheck && offsetThumbCheck!=0){
                            collectedWidth = collectedWidth+1;
                            cgCenterDiv.css('width',collectedWidth+'px');

                        }
                        else{

                         //   var margin = parseFloat(imageObjects[i][firstKey]['imageObject'].css('margin-left'));
                         //   var border = parseFloat(imageObjects[i][firstKey]['imageObject'].css('border-left')) + parseFloat(imageObjects[i][firstKey]['imageObject'].css('margin-right'));
                      //      var width = imageObjects[i][firstKey]['imageObject'].width();

                         //   var sumWidth = width+margin+border;
        /!*                    console.log('margin')
                            console.log(margin)
                            console.log('border')
                            console.log(border)
                            console.log('width')
                            console.log(width)
                            console.log('sumWidth')
                            console.log(sumWidth)*!/

                            setTimeout(function () {

                                collectedWidth = collectedWidth+cgJsData[gid].image[i][firstKey]['imageObject'].outerWidth(true);
                                cgCenterThumbView(collectedWidth,offsetThumbCheckToCompare,i);
                                i++;

                            },100);


                        }

                    };


                    cgCenterThumbView(collectedWidth,offsetThumbCheck,i);

                }*/


    },
    galleryIcons: function ($mainCGallery,isOpenPage,isJustRemoveClasses,gid,gWidth) {

        if(isJustRemoveClasses){
            $mainCGallery.removeClass('cg_micro cg_xxs cg_sm cg_xs');
            return;
        }

        // only for fivestar rating
        if(cgJsData[gid].vars.currentLook=='row' && gWidth<=400 && cgJsData[gid].options.general.PicsInRow>=2 && cgJsData[gid].options.general.AllowRating==1){

            $mainCGallery.addClass('cg_micro').removeClass('cg_xxs').removeClass('cg_sm').removeClass('cg_xs');

            return;

        }else{
            $mainCGallery.removeClass('cg_micro');
        }

        if(isOpenPage==true){

            setTimeout(function () {
                if(gWidth<=350){
                    $mainCGallery.addClass('cg_xxs').removeClass('cg_sm').removeClass('cg_xs');
                }
                else if(gWidth<=700){
                    $mainCGallery.addClass('cg_xs').removeClass('cg_xxs').removeClass('cg_sm');
                }
                else if(gWidth<=800){
                    $mainCGallery.addClass('cg_sm').removeClass('cg_xxs').removeClass('cg_xs');
                }
                else{
                    $mainCGallery.removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
                }
            },500)

        }
        else{

            if(gWidth<=350){
                $mainCGallery.addClass('cg_xxs').removeClass('cg_sm').removeClass('cg_xs');
            }
            else if(gWidth<=700){
                $mainCGallery.addClass('cg_xs').removeClass('cg_xxs').removeClass('cg_sm');
            }
            else if(gWidth<=800){
                $mainCGallery.addClass('cg_sm').removeClass('cg_xxs').removeClass('cg_xs');
            }
            else{
                $mainCGallery.removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
            }
        }

    },
    galleryIconsSlider: function ($mainCGslider,isOpenPage,isJustRemoveClasses,gid,gWidth) {

        $mainCGslider.removeClass('cg_micro cg_xxs cg_sm cg_xs');

        if(isOpenPage==true){

            setTimeout(function () {
                if(gWidth<=400){
                    $mainCGslider.addClass('cg_xs').removeClass('cg_xxs').removeClass('cg_sm');

                }
                else if(gWidth<=600){
                    $mainCGslider.addClass('cg_sm').removeClass('cg_xxs').removeClass('cg_xs');
                }
                /*else if(gWidth<=800){
                    $mainCGslider.addClass('cg_sm').removeClass('cg_xxs').removeClass('cg_xs');
                }*/
                else{
                    $mainCGslider.removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
                }
            },500)

        }
        else{

            if(gWidth<=400){
                $mainCGslider.addClass('cg_xs').removeClass('cg_xxs').removeClass('cg_sm');

            }
            else if(gWidth<=600){
                $mainCGslider.addClass('cg_sm').removeClass('cg_xxs').removeClass('cg_xs');
            }
            /*else if(gWidth<=800){
                $mainCGslider.addClass('cg_sm').removeClass('cg_xxs').removeClass('cg_xs');
            }*/
            else{
                $mainCGslider.removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
            }
        }

    }
};
