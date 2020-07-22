cgJsClass.gallery.info.setInfoGalleryView = function (realId,gid,arrIndex,firstLoad) {

  //  if(firstLoad===true){

    if(typeof cgJsData[gid].infoGalleryViewAppended[realId]=='undefined' && typeof cgJsData[gid].imageObject[realId] != 'undefined'){

        var inputFieldId = cgJsData[gid].options.visual['Field1IdGalleryView'];
        var infoData = cgJsData[gid].vars.info[realId];

        var hideTillHover = '';

        if(cgJsData[gid].options.general.ShowAlways!=1) {

            hideTillHover = 'cg_hide_till_hover';

        }

        var position = '';

        if(cgJsData[gid].options.visual['TitlePositionGallery']==2){
            position = 'class="cg_center"';
        }

        if(cgJsData[gid].options.visual['TitlePositionGallery']==3){
            position = 'class="cg_right"';
        }


        if(cgJsData[gid].options.visual['Field1IdGalleryView']==cgJsData[gid].vars.categoriesUploadFormId){

            var infoTitleDiv = jQuery('<div data-cg-id="'+realId+'" data-cg-gid="'+gid+'" class="cg_gallery_info_title '+hideTillHover+'"></div>');

            var categoryId = cgJsData[gid].vars.rawData[realId]['Category'];


            if(categoryId>0){
                var content = cgJsData[gid].vars.categories[categoryId].Name;
            }else{
                var content = cgJsClass.gallery.language.Other;
            }

            infoTitleDiv.append('<div '+position+'>'+content+'</div>');

            var cgShowObject = cgJsData[gid].imageObject[realId];
            cgShowObject.find('figure').append(infoTitleDiv);
            cgJsData[gid].infoGalleryViewAppended[realId] = true;

            return;
        }

        if(infoData){
            if(infoData.hasOwnProperty(inputFieldId)){

                if(infoData[inputFieldId]['field-content'] != ''){

                    var infoTitleDiv = jQuery('<div data-cg-id="'+realId+'" data-cg-gid="'+gid+'" class="cg_gallery_info_title '+hideTillHover+'"></div>');

                    var content = infoData[inputFieldId]['field-content'];
                    var position = '';

                    if(cgJsData[gid].options.visual['TitlePositionGallery']==2){
                        position = 'class="cg_center"';
                    }

                    if(cgJsData[gid].options.visual['TitlePositionGallery']==3){
                        position = 'class="cg_right"';
                    }

                    infoTitleDiv.append('<div '+position+'>'+content+'</div>');

                    var cgShowObject = cgJsData[gid].imageObject[realId];
                    cgShowObject.find('figure').append(infoTitleDiv);
                    cgJsData[gid].infoGalleryViewAppended[realId] = true;

                }

                return;

            }
        }

    }
  //  }



};