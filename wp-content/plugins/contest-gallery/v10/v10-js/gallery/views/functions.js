cgJsClass.gallery.views.functions = {
    checkAndAppendFromSliderToGallery: function ($mainCGallery,$mainCGslider) {

        var appendNew = false;

        if($mainCGallery.find('> .cg_show').length<1){// then must come from slider look
            //  $('#mainCGallery'+gid).addClass('cg_hidden');
            $mainCGslider.find('.cg_show').appendTo($mainCGallery);
            appendNew = true;
        }

        return appendNew;

    },
    appendAndRemoveImagesInSlider: function (gid,value,maximumVisibleImagesInSlider,$mainCGslider,isFromSlide) {

        var sliderView = false;

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            sliderView = true;
        }

        if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
            sliderView = true;
        }

        if(sliderView){

            value = parseInt(value);
            maximumVisibleImagesInSlider = parseInt(maximumVisibleImagesInSlider);

            var halfMinusOneOfVisibleImages = Math.floor(maximumVisibleImagesInSlider/2);
            var preAppend = false;
            var prePositionAtBeginning = false;
            if(value>halfMinusOneOfVisibleImages){// then has to be centered
                preAppend = true;
            }

            for(var index in cgJsData[gid].image){
                if(!cgJsData[gid].image.hasOwnProperty(index)){
                    break;
                }
                index = parseInt(index);
                var firstKey = Object.keys(cgJsData[gid].image[index])[0];
                var valueToCheck = value+maximumVisibleImagesInSlider;

                // needs to be checked! If many images are loaded imageObject might not be created!
                // maybe not required
                if(cgJsData[gid].image[index][firstKey].imageObject){
                    if(preAppend && index>=value-halfMinusOneOfVisibleImages && index<=value+halfMinusOneOfVisibleImages){
                        cgJsData[gid].image[index][firstKey].imageObject.removeClass('cg_fade_in').appendTo($mainCGslider);
                    }
                    else if((value<=halfMinusOneOfVisibleImages && index<=halfMinusOneOfVisibleImages) || (value<=halfMinusOneOfVisibleImages && index<maximumVisibleImagesInSlider)){
                        cgJsData[gid].image[index][firstKey].imageObject.removeClass('cg_fade_in').appendTo($mainCGslider);
                    }
                    else if((index>=value && index<valueToCheck)){// then value must be 0
                        cgJsData[gid].image[index][firstKey].imageObject.removeClass('cg_fade_in').appendTo($mainCGslider);
                    }else{
                        cgJsData[gid].image[index][firstKey].imageObject.remove();
                    }
                }

            }

            if(!isFromSlide){
                cgJsData[gid].vars.cgSliderRange.slider('value',value);
            }

        }



    },
    destroyRangeSlider: function (gid) {

        if(cgJsData[gid].vars.cgSliderRange){
            try{// put this in try and catch if not initalized error
                cgJsData[gid].vars.cgSliderRange.slider( "destroy" );// destroy before creating new
            }catch(error){

            }
            cgJsData[gid].vars.cgSliderRange.remove();
        }

    }
};