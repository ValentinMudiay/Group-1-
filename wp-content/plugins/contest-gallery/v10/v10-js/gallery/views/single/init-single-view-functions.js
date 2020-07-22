cgJsClass.gallery.views.singleViewFunctions = {
    showExif: function(gid,realId,$cgCenterDiv){

        if(cgJsData[gid].options.pro.hasOwnProperty('ShowExif')){

            if(cgJsData[gid].options.pro.ShowExif==1){

                if(!cgJsData[gid].vars.rawData[realId].hasOwnProperty('Exif')){

                    jQuery.getJSON( cgJsData[gid].vars.uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/image-data/image-data-"+realId+".json",{_: new Date().getTime()}).done(function( data ) {

                    }).done(function(data) {

                        data = cgJsClass.gallery.function.general.tools.calculateSizeGetJsonImageData(data,realId,gid);

                        // has to be set here, because was not set in php. Also image Object has to be reset on some places.
                        data.id = realId;
                        data.imageObject = cgJsData[gid].imageObject[realId];


                        if(data.hasOwnProperty('Exif')){
                            if(data.Exif!=0){
                                cgJsData[gid].vars.rawData[realId].Exif = data.Exif;
                                cgJsClass.gallery.views.singleViewFunctions.showExifData(gid,realId,$cgCenterDiv);
                            }
                        }

                    });

                }else{

                    if(cgJsData[gid].vars.rawData[realId].Exif!=0){
                        cgJsClass.gallery.views.singleViewFunctions.showExifData(gid,realId,$cgCenterDiv);
                    }

                }

            }

        }


    },
    showExifData: function(gid,realId,$cgCenterDiv){

        var show = false;

        if(cgJsData[gid].vars.rawData[realId].Exif.hasOwnProperty('MakeAndModel')){

            $cgCenterDiv.find('#cgCenterImageExifData'+gid+ ' .cg-exif-model').removeClass('cg_hide').find('.cg-exif-model-text').text(cgJsData[gid].vars.rawData[realId].Exif.MakeAndModel);
            show = true;

        }else if(cgJsData[gid].vars.rawData[realId].Exif.hasOwnProperty('Model')){

            $cgCenterDiv.find('#cgCenterImageExifData'+gid+ ' .cg-exif-model').removeClass('cg_hide').find('.cg-exif-model-text').text(cgJsData[gid].vars.rawData[realId].Exif.Model);

            show = true;

        }

        if(cgJsData[gid].vars.rawData[realId].Exif.hasOwnProperty('ApertureFNumber')){

            $cgCenterDiv.find('#cgCenterImageExifData'+gid+ ' .cg-exif-aperturefnumber').removeClass('cg_hide').find('.cg-exif-aperturefnumber-text').text(cgJsData[gid].vars.rawData[realId].Exif.ApertureFNumber);
            show = true;

        }

        if(cgJsData[gid].vars.rawData[realId].Exif.hasOwnProperty('ExposureTime')){

            $cgCenterDiv.find('#cgCenterImageExifData'+gid+ ' .cg-exif-exposuretime').removeClass('cg_hide').find('.cg-exif-exposuretime-text').text(cgJsData[gid].vars.rawData[realId].Exif.ExposureTime);
            show = true;

        }

        if(cgJsData[gid].vars.rawData[realId].Exif.hasOwnProperty('ISOSpeedRatings')){

            $cgCenterDiv.find('#cgCenterImageExifData'+gid+ ' .cg-exif-isospeedratings').removeClass('cg_hide').find('.cg-exif-isospeedratings-text').text(cgJsData[gid].vars.rawData[realId].Exif.ISOSpeedRatings);
            show = true;

        }
        if(cgJsData[gid].vars.rawData[realId].Exif.hasOwnProperty('FocalLength')){

            $cgCenterDiv.find('#cgCenterImageExifData'+gid+ ' .cg-exif-focallength').removeClass('cg_hide').find('.cg-exif-focallength-text').text(cgJsData[gid].vars.rawData[realId].Exif.FocalLength);
            show = true;

        }

        if(show){
            $cgCenterDiv.find('#cgCenterImageExifData'+gid).removeClass('cg_hide');
        }


    },
    setFurtherSteps: function(gid,order){

        // check steps
        var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);
        var stepNumber = Math.floor(order/PicsPerSite+1);
        jQuery('#cgFurtherImagesContainerDiv'+gid).find('.cg_further_images').removeClass('cg_further_images_selected');
        jQuery('#cgFurtherImagesContainerDiv'+gid).find('[data-cg-step='+stepNumber+']').addClass('cg_further_images_selected');

    },
    setSliderMargin: function(order,gid,direction,isGalleryOpenedSliderLook,realId){// old method scroll horizontal in slider

        var sliderView = false;

        if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
            sliderView = true;
        }

        if(cgJsData[gid].options.general.SliderLook==1 || sliderView){

            /*            if(cgJsClass.gallery.vars.isEdge){

                            var mainCGdivWidth = jQuery('#mainCGdiv'+gid).width();
                            var $mainCGallery = jQuery('#mainCGallery'+gid);
                            var newMarginLeft;

                            //var id = jQuery('#mainCGslider'+gid).find('.cg_show[data-cg-order='+order+']').attr('id');
                            var multiplikator = Math.floor(order/cgJsData[gid].vars.maximumVisibleImagesInSlider);

                            newMarginLeft = multiplikator*mainCGdivWidth*-1;
                            $mainCGallery.css('margin-left',newMarginLeft+'px');

                            cgJsClass.gallery.views.singleViewFunctions.setFurtherSteps(gid,order);

                        }else{*/

            var checkStart = Math.floor(cgJsData[gid].vars.maximumVisibleImagesInSlider/2);
            var $mainCGslider = jQuery('#mainCGslider'+gid);

            if(isGalleryOpenedSliderLook == true){
                for(var index in cgJsData[gid].image){

                    if(!cgJsData[gid].image.hasOwnProperty(index)){
                        break;
                    }

                    // firstkey is rowid not realId
                    var firstKey = Object.keys(cgJsData[gid].image[index])[0];
                    if(cgJsData[gid].image[index][firstKey].id==realId){

                        order = parseInt(index);
                    }
                }
            }

            if(order>checkStart){

                //var id = jQuery('#mainCGslider'+gid).find('.cg_show[data-cg-order='+order+']').attr('id');
                // var multiplikator = Math.floor(order)/Math.floor(cgJsData[gid].vars.maximumVisibleImagesInSlider);
                var newMarginLeft = order*cgJsData[gid].vars.widthSliderPreview;

                newMarginLeft = newMarginLeft-((cgJsData[gid].vars.widthmain-cgJsData[gid].vars.widthSliderPreview)/2);

            }else{

                newMarginLeft = 0;

            }

            if(cgJsData[gid].vars.imageDataLength*cgJsData[gid].vars.widthSliderPreview > cgJsData[gid].vars.widthmain){
                //if(newMarginLeft > cgJsData[gid].vars.widthmain){
                $mainCGslider.removeClass('cgCenterDivBackgroundColor');
            }else{
                $mainCGslider.addClass('cgCenterDivBackgroundColor');
            }

            jQuery($mainCGslider).animate({
                scrollLeft: newMarginLeft+'px'
            }, 'fast');

            cgJsClass.gallery.views.singleViewFunctions.setFurtherSteps(gid,order);

            //  }

        }

    },
    slideOutAppend:function (gid,order,realId,firstKey,isGalleryOpened,offsetLeftClickedImage,imageObject,cgCenterDiv) {

        var last = parseInt(order)+1;

        var FbLike = cgJsData[gid].options.general.FbLike;
        var FbLikeGallery = cgJsData[gid].options.general.FbLikeGallery;
        var AllowRating = cgJsData[gid].options.general.AllowRating;


        //  var collectedWidth = 0;
        // debugger
        // Dann letztes Bild angeklickt
        if(typeof cgJsData[gid].image[last] === 'undefined'){

            cgCenterDiv.insertAfter(imageObject);
            //  cgCenterDiv.insertAfter(cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide'));
            cgCenterDiv.css('display','table');
            //    cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');
            //  cgJsClass.gallery.views.singleView.goToLocation(gid,realId,isGalleryOpened,order,firstKey);
            //     cgJsClass.gallery.views.singleView.createImageUrl(gid,realId,isGalleryOpened);

            cgCenterDiv.find('.cg-center-image').show();
            if(FbLike>=1){
                if(FbLikeGallery>=1){
                }else{
                    cgCenterDiv.find('#cgCenterImageFbLikeDiv'+gid).show();
                }
            }
            if(AllowRating>=1){
                cgCenterDiv.find('#cgCenterImageRatingDiv'+gid).show();
            }

        }
        else{

            var set = false;

            for(var i = parseInt(order)+1; i<=1000; i++){

                if(typeof cgJsData[gid].image[i] !== 'undefined'){

                    //  debugger
                    var firstKeyToCompare = Object.keys(cgJsData[gid].image[i])[0];

                    var categoryId = cgJsData[gid].image[i][firstKeyToCompare]['Category'];

                    if(typeof cgJsData[gid].vars.categories[categoryId] != 'undefined'){


                        if(cgJsData[gid].vars.showCategories == true && cgJsData[gid].vars.categories[categoryId]['Checked']==false){

                            //cgJsData[gid].image[index][firstKey]['imageObject'].remove();

                            return;

                        }

                    }

                    var imageObjectToCompare = cgJsData[gid].image[i][firstKeyToCompare]['imageObject'];

                    var offsetLeftToCompare = imageObjectToCompare.get(0).offsetLeft;// so ist schneller

                    if(offsetLeftToCompare <= offsetLeftClickedImage){

                        set = true;

                        cgCenterDiv.insertBefore(imageObjectToCompare);
                        cgCenterDiv.css('display','table');
                        //      cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');
                        //    cgJsClass.gallery.views.singleView.goToLocation(gid,realId,isGalleryOpened,order,firstKey);
                        //   cgJsClass.gallery.views.singleView.createImageUrl(gid,realId,isGalleryOpened);

                        cgCenterDiv.find('.cg-center-image').show();
                        if(FbLike>=1){
                            if(FbLikeGallery>=1){
                            }else{
                                cgCenterDiv.find('#cgCenterImageFbLikeDiv'+gid).show();
                            }
                        }
                        if(AllowRating>=1){
                            cgCenterDiv.find('#cgCenterImageRatingDiv'+gid).show();
                        }

                        break;

                    }

                }

            }

            // dann wurde ein bild in der letzten reihe geklickt
            if(set==false){

                var key = Object.keys(cgJsData[gid].image[cgJsData[gid].image.length-1])[0];
                var lastImageObject = cgJsData[gid].image[cgJsData[gid].image.length-1][key]['imageObject'];

                cgCenterDiv.insertAfter(lastImageObject);
                cgCenterDiv.css('display','table');
                //     cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');

                cgCenterDiv.find('.cg-center-image').show();

                if(FbLike>=1){
                    if(FbLikeGallery>=1){
                    }else{
                        cgCenterDiv.find('#cgCenterImageFbLikeDiv'+gid).show();
                    }
                }

                if(AllowRating>=1){
                    cgCenterDiv.find('#cgCenterImageRatingDiv'+gid).show();
                }

                //  if(cgJsClass.gallery.vars.fullwindow){
                //   cgJsData[gid].vars.mainCGdiv.addClass('cg_display_inline_block');
                //   cgJsData[gid].vars.cgCenterDivAppearenceHelper.removeClass('cg_hide');
                // }else{
                //   cgJsData[gid].vars.cgCenterDivAppearenceHelper.addClass('cg_hide');
                //  }

                //    setTimeout(function () {
                //       cgJsClass.gallery.views.singleView.goToLocation(gid,realId,isGalleryOpened,order,firstKey);
                //    cgJsClass.gallery.views.singleView.createImageUrl(gid,realId,isGalleryOpened);

                //  },100); <<< warum wurde vorher setTimeout gemacht :)?

            }else{
                //  cgJsData[gid].vars.mainCGdiv.removeClass('cg_display_inline_block');
            }


        }

    },
    clickNextStep:function (gid) {

        var sliderView = false;

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            sliderView = true;
        }

        if(sliderView==false){
            var $cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;
            var $nextStepArrow = $cgCenterDiv.find('.cg-center-arrow-right-next-step');
            if($nextStepArrow.length>=1){
                if($nextStepArrow.hasClass('cg-center-pointer-event-none')==false){
                    $nextStepArrow.click();
                }
            }
        }

    },
    clickPrevStep:function (gid) {

        var sliderView = false;

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            sliderView = true;
        }

        if(sliderView==false){
            var $cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;
            var $prevStepArrow = $cgCenterDiv.find('.cg-center-arrow-left-prev-step');
            if($prevStepArrow.length>=1){
                if($prevStepArrow.hasClass('cg-center-pointer-event-none')==false){
                    $prevStepArrow.click();
                }
            }
        }

    },
    showCGcenterDivAfterGalleryLoad: function (gid,$mainCGallery) {

        setTimeout(function () {


            var $mainCGdiv = $mainCGallery.closest('.mainCGdiv');

            $mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).addClass('cg_hide');
            $mainCGallery.css('visibility','visible').addClass('cg_fade_in').removeClass('cg_hidden');

            $mainCGdiv.find('.cg_gallery_thumbs_control .cg_view_switcher').removeClass('cg_disabled');
        },400);

        return;

        $mainCGdiv.find('.cg_gallery_thumbs_control .cg_view_switcher').addClass('cg_disabled');

        setTimeout(function () {

            $mainCGallery.find('.cgCenterDiv').hide();
            $mainCGallery.css('visibility','visible');
            $mainCGallery.removeClass('cg_fade_in');
            $mainCGallery.removeClass('cg_fade_in_new');
            $mainCGallery.find('.cgCenterDiv').css('min-height','unset');
            $mainCGallery.find('.cgCenterDiv').css('height','unset');
            $mainCGallery.find('.cgCenterDiv').removeClass('cg_hide_override').slideDown(function () {
                $mainCGallery.find('.cgCenterDiv').css('display','table');
                $mainCGdiv.find('.cg_gallery_thumbs_control .cg_view_switcher').removeClass('cg_disabled');
            });


        },300);

    },
    cloneCommentDiv: function (gid,realId,cgCenterDiv,imageObject) {
        // clone append comment div
        cgCenterDiv.find('#cgCenterImageCommentsDivTitle'+gid+'').empty();
        imageObject.find('.cg_gallery_comments_div').clone().appendTo(cgCenterDiv.find('#cgCenterImageCommentsDivTitle'+gid+'')).find('.cg_gallery_comments_div').removeClass('cg_center').removeClass('cg_right');
        cgCenterDiv.find('#cgCenterImageCommentsDivTitle'+gid+'').append('<hr>');
        cgCenterDiv.find('.cg_gallery_comments_div').removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
        cgCenterDiv.find('.cg_gallery_comments_div .cg_gallery_comments_div_icon').removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
        cgCenterDiv.find('.cg_gallery_comments_div .cg_gallery_comments_div_count').removeClass('cg_sm').removeClass('cg_xs').removeClass('cg_xxs');
        cgCenterDiv.find('.cg_gallery_comments_div_icon').addClass('cg_inside_center_div');
        if(cgJsData[gid].comment[realId] == 0){
            cgCenterDiv.find('#cgCenterImageCommentsDivTitle'+gid+'').append('<span class="cg-center-image-comments-div-add-comment"></span>');
        }

        if(cgJsData[gid].comment[realId] >= 1){
            cgCenterDiv.find('.cg-center-image-comments-div-parent > .cg-center-image-comments-div-add-comment').show();
        }

    }
};