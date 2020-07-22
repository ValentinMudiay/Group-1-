cgJsClass.gallery.info.checkInfoSingleImageView = function (realId,gid,order) {

  //  setTimeout(function () {
        if(typeof cgJsData[gid].vars.info[realId]=='undefined'){
            cgJsClass.gallery.info.getInfo(realId,gid,true,order);
        }
        else{
            cgJsClass.gallery.views.setInfoSingleImageView(realId,gid,order);
        }
  //  },500);


};
cgJsClass.gallery.views.setInfoSingleImageView = function (realId,gid,infoCatched) {

        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageInfoDiv'+gid).addClass('cg_hide');
        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageInfoDiv'+gid).empty();
        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageInfoDivTitle'+gid).addClass('cg_hide');

        var append = false;
        var thereIsImageInfo = false;

        if(typeof cgJsData[gid].vars.info[realId]=='undefined' && infoCatched!==true){

            cgJsClass.gallery.info.getInfo(realId,gid,true);
            return;

        }

        var data = cgJsData[gid].vars.info[realId];

        for(var index in cgJsData[gid].singleViewOrder){

            if(!cgJsData[gid].singleViewOrder.hasOwnProperty(index)){
                break;
            }

            cgJsData[gid].singleViewOrder[index].append = null;

        }

        // data[realId] ist wie ein array aufgebaut
        for(var i in data){

            if(!data.hasOwnProperty(i)){
                break;
            }

            var fieldId = i;

            if(data[i]['field-content'] != ''){

                if(cgJsData[gid].forms.upload.hasOwnProperty(i)){
                    if(cgJsData[gid].forms.upload[i].Show_Slider==1){

                        thereIsImageInfo = true;
                        cgJsClass.gallery.vars.thereIsImageInfo = true;

                        if(append == false){
                            //  jQuery('#cgCenterImageInfoDiv'+gid).removeClass('cg_hide');
                            //    jQuery('#cgCenterImageInfoDivTitle'+gid).removeClass('cg_hide');
                            append = true;
                        }

                        var title = data[i]['field-title'];
                        var content = data[i]['field-content'];

                        if(data[i]['field-type']=='url-f'){

                            if(content.indexOf('http')==-1){
                                content = 'http://'+content;
                            }
                            var infoContent = '<div class="cg-center-image-info-div"><p><a href="'+content+'" target="_blank">'+title+'</a></p></div>';
                        }else{
                            var infoContent = '<div class="cg-center-image-info-div"><p>'+title+':</p><p>'+content+'</p></div>';
                        }

                        for(var index in cgJsData[gid].singleViewOrder){

                            if(!cgJsData[gid].singleViewOrder.hasOwnProperty(index)){
                                break;
                            }

                            if(cgJsData[gid].singleViewOrder[index].id==fieldId){
                                cgJsData[gid].singleViewOrder[index].append = infoContent;
                            }

                        }

                        // jQuery('#cgCenterImageInfoDiv'+gid).append(jQuery(infoContent));

                    }

                }

            }

        }

        var Category = cgJsData[gid].vars.rawData[realId]['Category'];

        if((Category>0 && cgJsData[gid].vars.showCategories==true) || (cgJsData[gid].vars.showCategories==true && Category==0)){

            var title = cgJsData[gid].vars.categoriesUploadFormTitle;
            if(Category>0){
                var content = cgJsData[gid].vars.categories[Category].Name;
            }else{
                var content = cgJsClass.gallery.language.Other;
            }
            var infoContent = '<div class="cg-center-image-info-div"><p>'+title+':</p><p>'+content+'</p></div>';
            // jQuery('#cgCenterImageInfoDiv'+gid).append(jQuery(infoContent));

            for(var index in cgJsData[gid].singleViewOrder){

                if(!cgJsData[gid].singleViewOrder.hasOwnProperty(index)){
                    break;
                }

                if(cgJsData[gid].singleViewOrder[index].id==cgJsData[gid].vars.categoriesUploadFormId){
                    cgJsData[gid].singleViewOrder[index].append = infoContent;
                    append = true;
                }

            }


        }

        if(append==true){


            for(var index in cgJsData[gid].singleViewOrder){

                if(!cgJsData[gid].singleViewOrder.hasOwnProperty(index)){
                    break;
                }

                if(cgJsData[gid].singleViewOrder[index].append!=null){
                    jQuery('#cgCenterImageInfoDiv'+gid).append(jQuery(cgJsData[gid].singleViewOrder[index].append));
                }

            }

            if(cgJsData[gid].vars.translateX){
                jQuery('#cgCenterImageInfoDivTitle'+gid).removeClass('cg_hide');
            }else{
                jQuery('#cgCenterImageInfoDivTitle'+gid).removeClass('cg_hide');
            }


            // old logic 2019 03 09
            /*        jQuery('#cgCenterImageInfoDiv'+gid).hide().removeClass('cg_hide').slideDown().add(
                        setTimeout(function () {
                            jQuery('#cgCenterDiv'+gid).height('auto');
                        },400)
                    );*/
            jQuery('#cgCenterImageInfoDiv'+gid).removeClass('cg_hide');

        }
        if(thereIsImageInfo==true){
            cgJsClass.gallery.views.checkIfTopBottomArrowsRequired(gid);
        }

        //  jQuery('#cgCenterDiv'+gid).height('auto');

    if(cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageInfoDiv'+gid).find('.cg-center-image-info-div').length){
        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageInfoDivParent'+gid).removeClass('cgCenterImageNoInfo');
        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageCommentsDivParent'+gid).removeClass('cgCenterImageNoInfo');
    }else{
        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageInfoDivParent'+gid).addClass('cgCenterImageNoInfo');
        cgJsData[gid].vars.cgCenterDiv.find('#cgCenterImageCommentsDivParent'+gid).addClass('cgCenterImageNoInfo');
    }


};
cgJsClass.gallery.views.checkIfTopBottomArrowsRequired = function (gid) {

    var $cgCenterInfoDiv = cgJsData[gid].vars.cgCenterDiv;

    // falls diese funktion angwendet dann werden komments definitiv angzeigt und der separator kann auch angezeigt werden
    $cgCenterInfoDiv.find('.cg-center-image-info-info-separator').removeClass('cg_hide');

    setTimeout(function () {

        var collectedHeight = 0;

        $cgCenterInfoDiv.find('.cg-center-image-info-div').each(function () {
            // +10 because of margin bottom 10px
            collectedHeight = collectedHeight + jQuery(this).height()+10;+ jQuery(this).height();

        });

      //  var heightCheck = $cgCenterInfoDiv.find('.cg-center-image-info-div-parent').height();

        var noSlideOut = false;

        if(cgJsData[gid].options.general.FullSizeImageOutGallery==1 || cgJsData[gid].options.general.OnlyGalleryView==1){
            noSlideOut = true;
        }

        // max-height 500px, if there is padding, padding has also to be added
        if(collectedHeight>=500){
            $cgCenterInfoDiv.find('.cg-center-image-info-div-parent-parent .cg-top-bottom-arrow').removeClass('cg_hide');
            if(noSlideOut==false){
                $cgCenterInfoDiv.find('.cg-center-image-info-div-parent-parent .cg-top-bottom-arrow:first-child').addClass('cg_no_scroll');
            }
            $cgCenterInfoDiv.find('.cg-center-image-info-div-parent-parent .cg-top-bottom-arrow:last-child').removeClass('cg_no_scroll');
            $cgCenterInfoDiv.find('.cg-center-image-info-div-container').addClass('cg-center-image-info-div-parent-padding');
        }

    },300)

};