cgJsClass.gallery.info.setInfo = function (realId,gid,setInfoSingleView,arrIndex,data,firstLoad,collectInfo) {

    var cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;
    cgCenterDiv.find('.cg-top-bottom-arrow').addClass('cg_hide');// wichtig! ansonsten arrows kurz über dem Bild zu sehen!

    if(data==null){
        data = [];
    }

    var infoSetDone = false;

    if(typeof cgJsData[gid].imageCheck[realId] == 'undefined'){
        cgJsData[gid].imageCheck[realId] = {};
        cgJsData[gid].imageCheck[realId]['has-no-bottom-space'] = cgJsClass.gallery.function.general.tools.checkHasNoBottomSpace(gid,data);
    }

    if (Object.keys(data).length > 0) {

        infoSetDone=true;

        cgJsData[gid].vars.info[realId] = data;

        cgJsClass.gallery.info.collectInfo(gid,realId,data);

        // set info in gallery for SEO

        if(typeof cgJsData[gid].imageObject[realId] != 'undefined'){

            var imageObject = cgJsData[gid].imageObject[realId];

            for(var fieldId in data){

                if(!data.hasOwnProperty(fieldId)){
                    break;
                }

                imageObject.find('figcaption').append(jQuery('<h4>'+data[fieldId]['field-title']+'</h4>'));
                imageObject.find('figcaption').append(jQuery('<p>'+data[fieldId]['field-content']+'</p>'));
                imageObject.find('figcaption').append(jQuery('<hr>'));

            }

            // set title tag
            if(cgJsData[gid].options.visual['Field2IdGalleryView']>=1){
                if(typeof data[cgJsData[gid].options.visual['Field2IdGalleryView']] == 'object'){

                    if(typeof data[cgJsData[gid].options.visual['Field2IdGalleryView']]['field-content'] != 'undefined'){
                        imageObject.find('.cg_append').attr('title',data[cgJsData[gid].options.visual['Field2IdGalleryView']]['field-content']);
                    }else{
                        imageObject.find('.cg_append').attr('title','');
                    }
                }else{
                    if(cgJsData[gid].vars.isShowTagInGallery){
                        var categoryId = cgJsData[gid].vars.rawData[realId]['Category'];
                        if(categoryId>0){
                            var title = cgJsData[gid].vars.categories[categoryId].Name;
                        }else{
                            var title = cgJsClass.gallery.language.Other;
                        }
                        imageObject.find('.cg_append').attr('title',title);
                    }else{
                        imageObject.find('.cg_append').attr('title','');
                    }
                }
            }

        }

        // set info in gallery for SEO --- END.vars.info
        if(collectInfo!==true){
            cgJsClass.gallery.info.setInfoGalleryView(realId,gid,arrIndex,firstLoad);
        }

        if(setInfoSingleView == true){
            cgJsClass.gallery.views.setInfoSingleImageView(realId,gid,true);
        }

        cgJsClass.gallery.info.setDeleteImageIcon(realId,gid);


        return;

    }
    else{

        cgJsData[gid].vars.info[realId] = null;
        cgJsData[gid].fullImageInfoData[realId] = null;

        cgJsClass.gallery.info.collectInfo(gid,realId,data);

        // set title tag
        if(cgJsData[gid].options.visual['Field2IdGalleryView']>=1){
            if(typeof cgJsData[gid].imageObject[realId] != 'undefined'){
                var imageObject = cgJsData[gid].imageObject[realId];
                imageObject.find('.cg_append').attr('title','');
            }
        }

    }

    cgJsClass.gallery.info.setDeleteImageIcon(realId,gid);

    if((cgJsData[gid].options.visual['Field1IdGalleryView']==cgJsData[gid].vars.categoriesUploadFormId && infoSetDone==false && firstLoad != true)|| (cgJsData[gid].vars.showCategories==true)){
        cgJsClass.gallery.info.setInfoGalleryView(realId,gid,arrIndex);
        return;
    }

};
cgJsClass.gallery.info.setDeleteImageIcon = function (realId,gid) {

    var imageObject = cgJsData[gid].imageObject[realId];

    if(imageObject){
        var hideTillHover = '';

        if(cgJsData[gid].options.general.ShowAlways!=1) {

            hideTillHover = 'cg_hide_till_hover';

        }


        if(cgJsData[gid].vars.isUserGallery){
            if(!imageObject.find('.cg_delete_user_image').length){
                var infoTitleDiv = imageObject.find('.cg_gallery_info_title');
                if(!infoTitleDiv.length){
                    infoTitleDiv = jQuery('<div data-cg-id="'+realId+'" data-cg-gid="'+gid+'" class="cg_gallery_info_title '+hideTillHover+'"></div>');
                    infoTitleDiv.addClass('cg_gallery_info_title_no_title');
                }
                infoTitleDiv.addClass('cg_is_user_gallery').append('<div class="cg_delete_user_image" data-cg-gid="'+gid+'" data-cg-image-id="'+realId+'">X</div>');
                imageObject.find('figure').append(infoTitleDiv);
            }
        }
    }





};