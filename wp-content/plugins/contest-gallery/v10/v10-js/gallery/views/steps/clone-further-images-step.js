cgJsClass.gallery.views.cloneFurtherImagesStep = function (gid,isInit) {


    return; // disabled since 31.07.2019


    var $mainCGdiv = jQuery('#mainCGdiv'+gid);

    if($mainCGdiv.find('.cg_further_images_container').first().is(':visible')){

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            return;
        }

        var heightCheck = jQuery(window).height()/3;
        if($mainCGdiv.find('#mainCGallery'+gid).height()>heightCheck){
            if($mainCGdiv.find('.cg_further_images_container').length>1){
                $mainCGdiv.find('.cg_further_images_container').each(function (index) {

                    if(index>=1){
                        jQuery(this).remove();
                    }

                });
            }
            $mainCGdiv.find('.cg_further_images_container').first().clone().removeAttr('id').appendTo($mainCGdiv).find('.cg_further_images').addClass('cg_cloned');

        }
        else{
            if(Object.keys(cgJsData[gid].fullImageDataFiltered).length<1){
                $mainCGdiv.find('.cg_further_images_container:first-child').hide();
                $mainCGdiv.find('.cg_further_images_container:last-child').remove();
            }else{
                $mainCGdiv.find('.cg_further_images_container:last-child').remove();
                if(cgJsClass.gallery.vars.categoryClicked==false && cgJsClass.gallery.vars.inputWritten == false){
                    jQuery('#cgFurtherImagesContainerDiv'+gid).cgGoTo();
                }
            }

        }

    }

};