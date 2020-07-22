cgJsClass.gallery.function.search.input = function(){

        jQuery(document).on('input','.cg_search_input',function () {

            var gid = jQuery(this).attr('data-cg-gid');

            var $element = jQuery(this);

            if(cgJsClass.gallery.function.general.tools.setWaitingForValues(gid,$element,'input',true)){
                return;
            }

            cgJsClass.gallery.vars.inputWritten = true;
            cgJsClass.gallery.vars.hasToAppend = true;


            cgJsData[gid].vars.mainCGallery.css('height',cgJsData[gid].vars.mainCGallery.height()+'px');

            //   cgJsClass.gallery.getJson.abortGetJson(gid);

            cgJsData[gid].vars.searchInput = this.value;

            // falls ein Bild geöffnet ist, muss alles zurückgesetzt werden!!!!
            if(cgJsData[gid].vars.openedRealId>0){
                cgJsClass.gallery.views.close(gid);
            }

            var ids = cgJsClass.gallery.function.search.collectData(gid);
            cgJsClass.gallery.function.search.getFullImageDataFiltered(gid,ids);

            var step = 1; // Weil fängt mit erstem Schritt an
            cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,step,true,false,gid);
            //var $step = jQuery('#cgFurtherImagesContainerDiv'+gid).find('.cg_further_images[data-cg-step="1"]');
            //$step.click();

            cgJsClass.gallery.vars.inputWritten = false;

            cgJsData[gid].vars.mainCGallery.css('height','auto');


        });
};