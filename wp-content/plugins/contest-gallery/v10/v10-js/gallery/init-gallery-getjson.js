cgJsClass.gallery.getJson = {
    init: function ($,$mainCGallery,i,length){

        var $gallery = $($mainCGallery[i]);

        var gid = $gallery.attr('data-cg-gid');

        if(typeof cgJsData=='undefined'){
            return;
        }
        if(typeof cgJsData[gid]=='undefined'){
            return;
        }

        cgJsData[gid].vars.mainCGallery = $gallery;
        cgJsData[gid].vars.mainCGdiv = $gallery.closest('#mainCGdiv'+gid);
        cgJsData[gid].vars.mainCGdivContainer = $gallery.closest('#mainCGdivContainer'+gid);
        cgJsData[gid].vars.mainCGdivHelperParent = $gallery.closest('#mainCGdivHelperParent'+gid);
        cgJsData[gid].vars.cgCenterDivAppearenceHelper = jQuery('#cgCenterDivAppearenceHelper'+gid).removeClass('cg_hide');

        cgJsData[gid].vars.cgCenterDiv = $gallery.find('.cgCenterDiv');

        cgJsData[gid].singleViewOrder = {};
        cgJsData[gid].categories = {};
        cgJsData[gid].image = {};
        cgJsData[gid].imageObject = {};
        cgJsData[gid].images = {};
        cgJsData[gid].forms = {};
        cgJsData[gid].steps = {};
        cgJsData[gid].forms.upload = {};
        cgJsData[gid].rating = {};
        cgJsData[gid].comment = {};
        cgJsData[gid].infoGalleryViewAppended = {};
        cgJsData[gid].imageCheck = {};

        var gid = gid;
        var uploadFolderUrl = cgJsData[gid].vars.uploadFolderUrl;

        cgJsClass.gallery.function.general.tools.setBackgroundColor(gid);

        if(cgJsData[gid].vars.imageDataLength<1 && cgJsData[gid].vars.mainCGdiv.find('#cgGalleryViewSortControl'+gid).find('.cg-gallery-upload').length==0){

            $('#mainCGdivContainer'+gid).empty().html('<p><strong>There are no activated images for this gallery (id: '+gid+')</strong></p>');
            i = i+1;
            if(typeof $mainCGallery[i] != 'undefined'){
                cgJsClass.gallery.getJson.init($,$mainCGallery,i,length);
            }
            return;

        }

      //  if(cgJsData[gid].vars.imageDataLength>10){
          //  $gallery.closest('#mainCGdivHelperParent'+gid).find('#cgLdsDualRingDivGalleryHide'+gid).removeClass('cg_hide');
        //}else{
        cgJsClass.gallery.getJson.showGalleryLoader(gid);
      //  }

        // check slide options
        if(cgJsData[gid].vars.translateX=='slideDown'){
            cgJsData[gid].vars.translateX=false;
        }else{
            cgJsData[gid].vars.translateX=true;
        }

        $.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-options.json", {_: new Date().getTime()}).done(function( data ) {

        }).done(function(data){

            cgJsData[gid].options = data;

            // NULL options in 0 umwandeln

            for(var property in cgJsData[gid].options.visual){

                if(!cgJsData[gid].options.visual.hasOwnProperty(property)){
                    break;
                }

                if(cgJsData[gid].options.visual[property]===null || cgJsData[gid].options.visual[property].length==0){
                    cgJsData[gid].options.visual[property]=0;
                }
            }

            for(var property in cgJsData[gid].options.general){

                if(!cgJsData[gid].options.general.hasOwnProperty(property)){
                    break;
                }

                if(cgJsData[gid].options.general[property]===null || cgJsData[gid].options.general[property].length==0){
                    cgJsData[gid].options.general[property]=0;
                }
            }

            for(var property in cgJsData[gid].options.input){

                if(!cgJsData[gid].options.input.hasOwnProperty(property)){
                    break;
                }


                if(cgJsData[gid].options.input[property]===null || cgJsData[gid].options.input[property].length==0){
                    cgJsData[gid].options.input[property]=0;
                }
            }

            for(var property in cgJsData[gid].options.pro){

                if(!cgJsData[gid].options.pro.hasOwnProperty(property)){
                    break;
                }

                if(cgJsData[gid].options.pro[property]===null || cgJsData[gid].options.pro[property].length==0){
                    cgJsData[gid].options.pro[property]=0;
                }
            }


            if(cgJsData[gid].options.general.CheckCookie==1){


                var cookieName = 'contest-gal1ery-'+gid+'-voting';
                var cookieValue = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

                if(!cookieValue){
                    cgJsClass.gallery.dynamicOptions.setCookie(gid,cookieName,cgJsData[gid].vars.cookieVotingId);
                }

                var cookieValue = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

            }

            $.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-single-view-order.json", {_: new Date().getTime()}).done(function( data ) {
            }).done(function(data){

                cgJsData[gid].singleViewOrder = data;

            $.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-form-upload.json", {_: new Date().getTime()}).done(function( data ) {
            }).done(function(data) {

                cgJsData[gid].forms.upload = data;

                $.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-categories.json", {_: new Date().getTime()}).done(function( data ) {
                }).done(function(data) {

                    // return true oder false für späteren check plus setzt categorien
                    cgJsData[gid].vars.showCategories = cgJsClass.gallery.categories.init(gid,data);

                    cgJsData[gid].vars.categoriesLength = Object.keys(cgJsData[gid].vars.categories).length;

                    $.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-gallery-tstamp.json", {_: new Date().getTime()}).done(function( data ) {
                    }).done(function(tstamp) {

                        cgJsClass.gallery.getJson.lastTstamp = tstamp;

                        try{
                            cgJsClass.gallery.indexeddb.init(uploadFolderUrl,gid,tstamp);

                        }catch(e){

                            cgJsClass.gallery.getJson.getImages(uploadFolderUrl,gid);

                            console.log('indexeddb init did not work')
                            console.log(e);

                        }

                        // for upcomming versions autoreload irgendwann mal
                    //    cgJsClass.gallery.getJson.galleryTstampCheckInit(uploadFolderUrl,gid);

                    });


                });

                i++;

                if(length>i){

                    cgJsClass.gallery.getJson.init($,$mainCGallery,i,length);
                }



            });
            });
        });

    },
    galleryTstampCheckInit: function (uploadFolderUrl,gid){

        this.galleryTstampCheck(uploadFolderUrl,gid);
        this.galleryTstampCheckIntervallSet(uploadFolderUrl,gid);

    },
    galleryTstampCheck: function (uploadFolderUrl,gid){

        jQuery.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+gid+"-gallery-tstamp.json", {_: new Date().getTime()}).done(function( data ) {
        }).done(function(tstamp) {

          //  if(tstamp != cgJsClass.gallery.getJson.lastTstamp){
                cgJsClass.gallery.getJson.lastTstamp = tstamp;
                cgJsClass.gallery.getJson.getImages(uploadFolderUrl,gid,tstamp);
         //   }

        });

    },
    galleryTstampCheckIntervallSet: function (uploadFolderUrl,gid){

        cgJsClass.gallery.getJson.galleryTstampCheckIntervall = setInterval(function () {

            cgJsClass.gallery.getJson.galleryTstampCheck(uploadFolderUrl,gid);

        },5000);

    },
    galleryTstampCheckIntervall: null,
    lastTstamp: null,
    lastTstampSortValues: null,
    getImages: function(uploadFolderUrl,gid,tstamp,isOpenedPage){

        //jQuery('#cgLdsDualRingDivGalleryHide'+gid).removeClass('cg_hide');
        jQuery.ajax({
            cache: false,
            url: uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-images.json",
            dataType: "json",
        }).done(function(data) {
            cgJsData[gid].vars.preRawData = data;
            cgJsClass.gallery.indexeddb.saveJsonGallery(gid,data,tstamp);
            cgJsClass.gallery.getJson.imageDataPreProcess(gid,data,isOpenedPage);
        });

    },
    getImagesOnlyForPreProcessing: function(gid,processedFilesCounter,newImageIdsArray,isCopyUploadToAnotherGallery){

        //jQuery('#cgLdsDualRingDivGalleryHide'+gid).removeClass('cg_hide');
        jQuery.ajax({
            cache: false,
            url: cgJsData[gid].vars.uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-images.json",
            dataType: "json",
        }).done(function(data) {
            cgJsClass.gallery.getJson.imageDataPreProcess(gid,data,false,processedFilesCounter,true,newImageIdsArray,true,isCopyUploadToAnotherGallery);
        });

    },
    newImageIdsArray: [],
    imageDataPreProcess: function(gid,data,isOpenedPage,processedFilesCounter,calledFromUpload,newImageIdsArray,isCalledFromSameFunction,isCopyUploadToAnotherGallery){

        data = cgJsClass.gallery.function.general.tools.calculateSizeImageDataPreProcess(data,gid);

        if(newImageIdsArray){

            this.newImageIdsArray = newImageIdsArray;

            var sliderView = false;

            if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
                sliderView = true;
            }

            if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
                sliderView = true;
            }

            if(sliderView){
                cgJsData[gid].vars.mainCGdiv.find('#mainCGslider'+gid).addClass('cg_hide');
                cgJsData[gid].vars.mainCGdiv.find('#cgSliderRangeContainer'+gid).addClass('cg_hide');
                cgJsData[gid].vars.mainCGdiv.find('#cgLdsDualRingMainCGdivHide'+gid).removeClass('cg_hide');
            }

        }

        cgJsClass.gallery.function.general.tools.checkSetUserGalleryOptions(gid);
        cgJsClass.gallery.function.general.tools.checkIfSettingsRequiredInFullWindow(gid);

        if(calledFromUpload){
            cgJsClass.gallery.vars.isSortingDataAvailable = false;
        }

        var onlyLoggedInUserImages = false;
        if(typeof cgJsData[gid].wpUserImageIds != 'undefined'){// then is only user gallery!!!!!
            onlyLoggedInUserImages = true;
            if(newImageIdsArray){
                newImageIdsArray.forEach(function (id) {
                    cgJsData[gid].wpUserImageIds.push(id);
                });
                cgJsData[gid].vars.imageDataLength = cgJsData[gid].wpUserImageIds.length;
            }
        }

        for(var index in data){

            if(!data.hasOwnProperty(index)){
                break;
            }

            // prüfen ob genug properties vorhanden sind zur weiter verarbeitung
            // ansonsten rauslöschen da folge fehler entstehen können
            // eventuell wurde bei speicherung nicht alle files komplett verarbeitet
            if(Object.keys(data[index]).length<15){
                delete data[index];
                continue;
            }

            // bei einem kaputten index
            if(index==''){
                delete data[index];
                continue;
            }

            // remove categories which should not be displayed
            if(cgJsData[gid].vars.showCategories){

                var category = data[index].Category;

                if(typeof category == 'undefined'){
                    category = 0;
                    data[index].Category = 0;
                }else if(cgJsData[gid].vars.existingCategories.indexOf(parseInt(category))=='-1'){//if from some unexsting category then correct it here and set to 0, Important parseInt: because indexOf compare type always!
                    category = 0;
                    data[index].Category = 0;
                }

                var showInGallery = false;

                for(var categoriesIndex in cgJsData[gid].vars.categories){

                    if(!cgJsData[gid].vars.categories.hasOwnProperty(categoriesIndex)){
                        break;
                    }
                    if(cgJsData[gid].vars.categories[categoriesIndex].id==category || (cgJsData[gid].options.pro.ShowOther==1 && category==0)){
                        showInGallery = true;
                    }

                }

                if(showInGallery==false){
                    delete data[index];
                    continue;
                }

            }

            // remove categories which should not be displayed --- END

            // check if is in user image ids array
            if(onlyLoggedInUserImages){

                if(newImageIdsArray){
                    if(cgJsData[gid].wpUserImageIds.indexOf(index)===-1 && newImageIdsArray.indexOf(index)===-1){
                        delete data[index];
                        continue;
                    }
                }else{
                    if(cgJsData[gid].wpUserImageIds.indexOf(index)===-1){
                        delete data[index];
                        continue;
                    }
                }

            }

            // set real id here, was not set in php
            data[index]['id'] = index;

        }

        this.imageData(gid,data,calledFromUpload,processedFilesCounter,isOpenedPage,isCopyUploadToAnotherGallery,newImageIdsArray);

        // then must be from upload and all galleries with same real gallery id have to be actualized
        // check if further galleries exists which have to be update user or normal, both ways
        if(calledFromUpload && !isCalledFromSameFunction){
           if(String(gid).indexOf('-u')>=0){// then must be user gallery, check for normal gallery then
                var gidToCheck = gid.split('-u')[0];
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.getImagesOnlyForPreProcessing(gidToCheck,processedFilesCounter,newImageIdsArray,true);// false here important to preserve iteration!!!
                }
                // check if no voting allery exists
                var gidToCheck = gid.split('-u')[0]+'-nv';
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.getImagesOnlyForPreProcessing(gidToCheck,processedFilesCounter,newImageIdsArray,true);// false here important to preserve iteration!!!
                }
           }
           else if(String(gid).indexOf('-nv')>=0){// then must be no voting gallery, check for normal gallery then
                var gidToCheck = gid.split('-nv')[0];
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.getImagesOnlyForPreProcessing(gidToCheck,processedFilesCounter,newImageIdsArray,true);// false here important to preserve iteration!!!
                }
                // check if no voting allery exists
                var gidToCheck = gid.split('-nv')[0]+'-u';
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.getImagesOnlyForPreProcessing(gidToCheck,processedFilesCounter,newImageIdsArray,true);// false here important to preserve iteration!!!
                }
           }
           else if(String(gid).indexOf('-u')==-1 && String(gid).indexOf('-nv')==-1){// then must be normal gallery, check for user gallery then
               var gidToCheck = gid+'-u';
               // then gallery must be existing
               if(cgJsData[gidToCheck]){
                   cgJsClass.gallery.views.close(gidToCheck);
                   cgJsClass.gallery.getJson.getImagesOnlyForPreProcessing(gidToCheck,processedFilesCounter,newImageIdsArray,true);// false here important to preserve iteration!!!
               }
               // check if no voting gallery exists
               var gidToCheck = gid+'-nv';
               if(cgJsData[gidToCheck]){
                   cgJsClass.gallery.views.close(gidToCheck);
                   cgJsClass.gallery.getJson.getImagesOnlyForPreProcessing(gidToCheck,processedFilesCounter,newImageIdsArray,true);// false here important to preserve iteration!!!
               }
           }
        }

    },
    removeImageFromImageData: function(gid,realIdToDelete,isCalledFromUserDeleteAjaxRequest,isCopyUploadToAnotherGallery){

        cgJsData[gid].vars.openedRealId = 0;

        // remove from user image ids array
        if(typeof cgJsData[gid].wpUserImageIds != 'undefined'){
            var index = cgJsData[gid].wpUserImageIds.indexOf(realIdToDelete);
            if (index > -1) {
                cgJsData[gid].wpUserImageIds.splice(index, 1);
                cgJsData[gid].vars.imageDataLength = cgJsData[gid].wpUserImageIds.length;
            }
        }

        for(var realId in cgJsData[gid].vars.rawData){
            if(realId==realIdToDelete){
                delete cgJsData[gid].vars.rawData[realId];
                cgJsData[gid].vars.mainCGallery.find('#cg_show'+realId).remove();
            }
        }

      //  var sliderView = false;

      //  if((cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1) || (cgJsData[gid].options.pro.SliderFullWindow==1)){
          //  sliderView = true;
            if(Object.keys(cgJsData[gid].vars.rawData).length>=1){
                cgJsData[gid].vars.isRemoveImageSliderViewCheck = true;
            }
     //   }

       // if(!sliderView){
            cgJsClass.gallery.views.close(gid);

            // otherwise show message inner container will not appear centered
            setTimeout(function () {
                jQuery('#mainCGslider'+gid).addClass('cg_hide');
            },100);
         //
        //}

        // otherwise random button might unnecessary appear!
        // important also to have it here!!!!
        if(Object.keys(cgJsData[gid].vars.rawData).length==0){
            jQuery('mainCGdiv'+gid).find('.cg_random_button').addClass('cg_hide');
        }
        else if(Object.keys(cgJsData[gid].vars.rawData).length>0){
            jQuery('mainCGdiv'+gid).find('.cg_random_button').removeClass('cg_hide');
        }

        cgJsClass.gallery.getJson.imageData(gid,cgJsData[gid].vars.rawData,true,null,true,isCopyUploadToAnotherGallery);

        // then must be from user deleting gallery and all galleries with same real gallery id have to be actualized
        // check if further galleries exists which have to be update user or normal, both ways
        if(isCalledFromUserDeleteAjaxRequest){
            if(String(gid).indexOf('-u')>=0){// then must be user gallery, check for normal gallery then
                var gidToCheck = gid.split('-u')[0];
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.removeImageFromImageData(gidToCheck,realIdToDelete,false,true);// false here important to preserve iteration!!!
                }
                // check if no voting allery exists
                var gidToCheck = gid.split('-u')[0]+'-nv';
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.removeImageFromImageData(gidToCheck,realIdToDelete,false,true);// false here important to preserve iteration!!!
                }
            }
            else if(String(gid).indexOf('-nv')>=0){// then must be no voting gallery, check for normal gallery then
                var gidToCheck = gid.split('-nv')[0];
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.removeImageFromImageData(gidToCheck,realIdToDelete,false,true);// false here important to preserve iteration!!!
                }
                // check if no voting allery exists
                var gidToCheck = gid.split('-nv')[0]+'-u';
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.removeImageFromImageData(gidToCheck,realIdToDelete,false,true);// false here important to preserve iteration!!!
                }
            }
            else if(String(gid).indexOf('-u')==-1 && String(gid).indexOf('-nv')==-1){// then must be normal gallery, check for user gallery then
                var gidToCheck = gid+'-u';
                // then gallery must be existing
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.removeImageFromImageData(gidToCheck,realIdToDelete,false,true);// false here important to preserve iteration!!!
                }
                // check if no voting gallery exists
                var gidToCheck = gid+'-nv';
                if(cgJsData[gidToCheck]){
                    cgJsClass.gallery.views.close(gidToCheck);
                    cgJsClass.gallery.getJson.removeImageFromImageData(gidToCheck,realIdToDelete,false,true);// false here important to preserve iteration!!!
                }
            }
        }

    },
    imageData: function (gid,data,calledFromUpload,processedFilesCounter,isOpenedPage,isCopyUploadToAnotherGallery,newImageIdsArray,isDoNotCheckSortValues) {//if isDoNotCheckSortValues, then must be sorted and everything is fine

        var imageDataPassedArgumentsWithoutIsDoNotCheckSortValues= [gid,data,calledFromUpload,processedFilesCounter,isOpenedPage,isCopyUploadToAnotherGallery,newImageIdsArray];

        var $ = cgJsClass.gallery.vars.jQuery;
        var $mainCGdiv = cgJsData[gid].vars.mainCGdiv;

        //rawData can be set already here
        cgJsData[gid].vars.rawData = data;
        cgJsData[gid].vars.imageDataLength = Object.keys(cgJsData[gid].vars.rawData).length;
        cgJsData[gid].fullImageInfoData = {};

        if(!cgJsData[gid].vars.sorting){// important: set general here at beginning if not set! Check if not set important!
            cgJsData[gid].vars.sorting = 'date-desc';
        }


        // check first if might be another order
      //  if(cgJsData[gid].options.general.AllowSort==1){ // sort check can be without allow sort and with preselect

        if(cgJsData[gid].vars.sortingLastSelected){// then take last selected by user!

            var valueForPreselectSort = cgJsClass.gallery.function.general.tools.getValueForPreselectSort(cgJsData[gid].vars.sortingLastSelected);
            cgJsData[gid].options.pro.PreselectSort = valueForPreselectSort;

        }

        var preselect = cgJsData[gid].options.pro.PreselectSort;

        if(cgJsData[gid].vars.isOnlyGalleryNoVoting && (preselect=='rating_descend' || preselect=='rating_ascend' || preselect=='rating_descend_average' || preselect=='rating_ascend_average')){

            if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_date_descend').length){
                $mainCGdiv.find('#cg_select_order'+gid).val("1");
            }

            cgJsData[gid].vars.sorting = 'date-desc';

        }else{

            if(!cgJsData[gid].options.pro.PreselectSort || !cgJsData[gid].options.pro.PreselectSort=='date_descend'){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_date_descend').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("1");
                }
                cgJsData[gid].vars.sorting = 'date-desc';
            }else if(cgJsData[gid].options.pro.PreselectSort=='date_ascend'){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_date_ascend').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("2");
                }
                cgJsData[gid].vars.sorting = 'date-asc';
            }else if(cgJsData[gid].options.pro.PreselectSort=='comments_descend' && cgJsData[gid].options.general.AllowComments==1){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_comments_descend').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("3");
                }
                cgJsData[gid].vars.sorting = 'comments-desc';
            }else if(cgJsData[gid].options.pro.PreselectSort=='comments_ascend' && cgJsData[gid].options.general.AllowComments==1){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_comments_ascend').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("4");
                }
                cgJsData[gid].vars.sorting = 'comments-asc';
            }else if(cgJsData[gid].options.pro.PreselectSort=='rating_descend' && cgJsData[gid].options.general.AllowRating){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_rating_descend').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("5");
                }
                cgJsData[gid].vars.sorting = 'rating-desc';
            }else if(cgJsData[gid].options.pro.PreselectSort=='rating_ascend' && cgJsData[gid].options.general.AllowRating){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_rating_ascend').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("6");
                }
                cgJsData[gid].vars.sorting = 'rating-asc';
            }else if(cgJsData[gid].options.pro.PreselectSort=='rating_descend_average' && cgJsData[gid].options.general.AllowRating==1){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_rating_descend_average').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("8");
                }
                cgJsData[gid].vars.sorting = 'rating-desc-average';
            }else if(cgJsData[gid].options.pro.PreselectSort=='rating_ascend_average' && cgJsData[gid].options.general.AllowRating==1){
                if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_rating_ascend_average').length){
                    $mainCGdiv.find('#cg_select_order'+gid).val("9");
                }
                cgJsData[gid].vars.sorting = 'rating-asc-average';
            }

        }


        if(cgJsData[gid].options.general['RandomSort']=='1' || cgJsData[gid].vars.sortingLastSelected=='random'){
            if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_random_sort').length){
                // only if random option exists
                $mainCGdiv.find('#cg_select_order'+gid).val("7");
            }

            cgJsData[gid].vars.sorting='random';
            cgJsData[gid].vars.sortingLastSelected='random';// then must be page load random at beginning and will be in future if sort select button not available
        }

        // new! Since 09 July 2020!
        // this has to be done after sorting is setted above!
        // sort values firsT!!! Then data will be get, and better for processing with many images!!!
        if(!isDoNotCheckSortValues){// then check if values have to be sorted
            // this here has to be done one time before to create full imageDataFiltered properly
            var newData = cgJsClass.gallery.sorting.sortByRowId(gid,true,true);
            cgJsData[gid].image = cgJsClass.gallery.sorting.desc(newData);
            cgJsData[gid].fullImageData = cgJsData[gid].image;
            cgJsData[gid].fullImageDataFiltered = cgJsData[gid].image;
            this.getSortValuesTstamp(gid,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);
            return;
        }

    //    }


        // ELEMENTS CONTROL HERE

        var lengthKeys = Object.keys(data).length;

        if(lengthKeys==0){
            if(cgJsData[gid].vars.mainCGdiv.find('#cgGalleryViewSortControl'+gid).find('.cg-gallery-upload').length==0){
                $('#mainCGdivContainer'+gid).addClass('cg_hide');
                cgJsClass.gallery.getJson.hideGalleryLoader(gid);
            }else{
                cgJsData[gid].vars.mainCGdiv.removeClass('cg_hide').show().find('.cg_gallery_control_element').addClass('cg_hide');
                cgJsClass.gallery.getJson.hideGalleryLoader(gid);
                cgJsData[gid].vars.mainCGdiv.find('.cg-gallery-upload').removeClass('cg_hide');
            }
            $('#mainCGdivHelperParent'+gid).removeClass('cg_display_block');
            return;
        }

        cgJsData[gid].vars.mainCGdiv.find('.cg_gallery_control_element').each(function () {

            if($(this).hasClass('cg-center-image-fullwindow') && cgJsClass.gallery.vars.fullwindow){// if full window show full window button has not to be shown
                return;
            }else if($(this).hasClass('cg_random_button')){
                return;
            }else if($(this).hasClass('cg-lds-dual-ring')){
                return;
            }
            else{
                $(this).removeClass('cg_hide');
            }

        });

        var lazy = false;
        var openPage = true;

        var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);
        var $mainCGallery = cgJsData[gid].vars.mainCGallery;
        var realId = 0;

        var sliderView = false;

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            sliderView = true;
        }

        if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
            sliderView = true;
        }

        cgJsClass.gallery.views.checkOrderGallery(gid);

        if(cgJsData[gid].options.general.FullSizeImageOutGallery==1 || cgJsData[gid].options.general.OnlyGalleryView==1){
            cgJsData[gid].vars.mainCGallery.addClass('cg_only_gallery_view');
        }

        if(calledFromUpload === true){

            if(sliderView==false){
                openPage = false;
            }

            // steps will be set here
            if(lengthKeys > PicsPerSite){

                // remove images and imageObject if more then in a step
                if($mainCGdiv.find('.cg_further_images[data-cg-step="1"]').hasClass('cg_further_images_selected')){
                    lazy = true;
                    for(var i = 1; i <= processedFilesCounter; i++){
                        var nthChildToRemove = PicsPerSite-i+2;

                        $mainCGallery.find('.cg_show:nth-child('+nthChildToRemove+')').remove();
                    }
                }else{
                    $mainCGdiv.find('.cg_further_images:first-child').click();
                }

            }

            for(var property in cgJsData[gid].imageObject){

                if(!cgJsData[gid].imageObject.hasOwnProperty(property)){
                    break;
                }

                cgJsData[gid].imageObject[property].addClass('cg_hide');
            }

            if($mainCGdiv.find('#cg_select_order'+gid).find('.cg_date_descend').length){
                $mainCGdiv.find('#cg_select_order'+gid).val("1");
            }

        }

        // reset here
        cgJsData[gid].vars.openedRealId = 0;

        if(calledFromUpload!==true){
            if (location.href.indexOf('#!gallery') > -1) {


                var obj = cgJsClass.gallery.hashchange.getRealIdAndGid(isOpenedPage);
                realId = obj['realId'];
                var gidToCompare = obj['gid'];

                if(gidToCompare==gid){
                    cgJsData[gid].vars.openedRealId = realId;
                    if(typeof data[realId] != 'undefined'){
                        cgJsClass.gallery.hashchange.rowIdOfRealId = data[realId]['rowid'];
                    }
                }

            }
        }

        // show loader, loader will be removed in logic (view) functions
        if(PicsPerSite>10){
            $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').removeClass('cg_hide');
        }
        $mainCGdiv.find('.mainCGallery').addClass('cg_hidden');// WILL BE REMOVED IN LOGIC FUNCTION
        $mainCGdiv.css('display','block').removeClass('cg_hide');

        // set opened real id here first
        if(calledFromUpload && cgJsClass.gallery.getJson.newImageIdsArray.length){
            // will be clicked in logic processing then
            cgJsData[gid].vars.openedRealId = cgJsClass.gallery.getJson.newImageIdsArray[cgJsClass.gallery.getJson.newImageIdsArray.length - 1];
            realId = cgJsData[gid].vars.openedRealId ;
            cgJsClass.gallery.getJson.newImageIdsArray = [];//reset then
        }

        if(isDoNotCheckSortValues){// then everything must be sorted already and can go on
     //       debugger
            // has to be done one time here before
            cgJsClass.gallery.sorting.initSort(gid);

            // Cut data here or something like this if data length higher then PicsPerSite
            if(lengthKeys > PicsPerSite){
                if(realId==0){
                    var step = cgJsClass.gallery.dynamicOptions.checkIfStepClick(gid);
                }else{
                    var step = cgJsClass.gallery.dynamicOptions.getCurrentStep(gid,cgJsData[gid].vars.openedRealId);
                }
            }

            var processingInitated = cgJsClass.gallery.categories.checkAndSetCategoriesAfterUploadIfNecessary(gid,data,newImageIdsArray);

            // third parameter true initStepChange makes initOrder and initLogic later
            if(!processingInitated){
                cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery,step,true,lazy,gid,openPage,calledFromUpload,false,isCopyUploadToAnotherGallery);
            }

        }

        // ELEMENTS CONTROL HERE --- END


        // ELEMENTS CONTROL HERE

        cgJsClass.gallery.hover.init(jQuery);

        // Get rating and data for the rest of fullImaeData, needed later because of sorting
        if(lengthKeys > PicsPerSite){
            //cgJsClass.gallery.dynamicOptions.getRatingAndCommentsFullImageData(gid);
            //cgJsClass.gallery.dynamicOptions.getInfoAndCategoriesFullImageData(gid);
        }else{
            cgJsClass.gallery.sorting.showRandomButtonInstantly(gid);
        }

      //  cgJsClass.gallery.views.fullwindow.checkIfGalleryAlreadyFullWindow(gid);

        cgJsClass.gallery.getJson.hideGalleryLoader(gid);


        // prüfen ob die unteren steps auch agezeigt werden sollen
        setTimeout(function () {
            cgJsClass.gallery.views.cloneFurtherImagesStep(gid,true);
        },500);

        // ELEMENTS CONTROL HERE --- END

        if(!isDoNotCheckSortValues){
            this.getSortValuesTstamp(gid);
        }

    },
    getSortValuesTstamp: function(gid,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues){

        //allow first step data to process. Then initiate get all image-rating
        var uploadFolderUrl = cgJsData[gid].vars.uploadFolderUrl;

        jQuery.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-gallery-sort-values-tstamp.json", {_: new Date().getTime()}).done(function( data ) {
        }).done(function(tstamp) {

            try{
                cgJsClass.gallery.indexeddb.getJsonSortValues(uploadFolderUrl,gid,tstamp,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);
            }catch(e){

                cgJsClass.gallery.getJson.getSortValuesRequest(uploadFolderUrl,gid,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);

                console.log('indexeddb for sort values init did not work')
                console.log(e);

            }

        });

    },
    getSortValuesRequest: function(uploadFolderUrl,gid,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues){

        setTimeout(function () {
            jQuery.ajax({
                cache: false,
                url: uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-images-sort-values.json",
                dataType: "json",
            }).done(function(data) {

                cgJsClass.gallery.getJson.setSortingData(gid,data,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);

            });
        },500);

    },
    setSortingData: function(gid,data,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues){

        // !!!IMPORTANT!!! fullImageData and fullImageDataFiltered, both has to be always modified!!!!!

        var AllowComments = cgJsData[gid].options.general.AllowComments;

        // !IMPORTANT: Configure rating of data first:
        for(var realId in data){

            if(!data.hasOwnProperty(realId)){
                break;
            }

            if(AllowComments==1){
                cgJsData[gid].comment[realId] = (isNaN(data[realId].CountC) || typeof data[realId].CountC == 'undefined') ? 0 : parseInt(data[realId].CountC);
            }

            data[realId] = cgJsClass.gallery.dynamicOptions.configureRating(gid,realId,data[realId]);

        }

        for(var index in cgJsData[gid].fullImageData){

            if(!cgJsData[gid].fullImageData.hasOwnProperty(index)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].fullImageData[index])[0];
            var realId = cgJsData[gid].fullImageData[index][firstKey]['id'];

            for(var key in cgJsData[gid].fullImageData[index][firstKey]){

                if(!cgJsData[gid].fullImageData[index][firstKey].hasOwnProperty(key)){
                    break;
                }

                // set only values from file to object!!!!!
                for(var keyInData in data[realId]){

                    if(!data[realId].hasOwnProperty(keyInData)){
                        break;
                    }

                    // set only values from file to object!!!!!
                    if(!cgJsData[gid].fullImageData[index][firstKey][keyInData]){
                        cgJsData[gid].fullImageData[index][firstKey][keyInData] = data[realId][keyInData];
                    }

                }

            }

        }


        for(var index in cgJsData[gid].fullImageDataFiltered){

            if(!cgJsData[gid].fullImageDataFiltered.hasOwnProperty(index)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].fullImageDataFiltered[index])[0];
            var realId = cgJsData[gid].fullImageDataFiltered[index][firstKey]['id'];

            for(var key in cgJsData[gid].fullImageDataFiltered[index][firstKey]){

                if(!cgJsData[gid].fullImageDataFiltered[index][firstKey].hasOwnProperty(key)){
                    break;
                }


                // set only values from file to object!!!!!
                for(var keyInData in data[realId]){

                    if(!data[realId].hasOwnProperty(keyInData)){
                        break;
                    }

                    // set only values from file to object!!!!!
                    if(!cgJsData[gid].fullImageDataFiltered[index][firstKey][keyInData]){

                        cgJsData[gid].fullImageDataFiltered[index][firstKey][keyInData] = data[realId][keyInData];
                    }

                }

            }

        }

        cgJsClass.gallery.vars.isSortingDataAvailable = true;

        var tstamp = parseInt(new Date().getTime())/1000;

        cgJsClass.gallery.getJson.getInfo(gid,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);

        cgJsClass.gallery.indexeddb.saveJsonSortValues(gid,data,tstamp);

    },
    getInfo: function(gid,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues){

        var uploadFolderUrl = cgJsData[gid].vars.uploadFolderUrl;

        jQuery.ajax({
            cache: false,
            url: uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/"+cgJsData[gid].vars.gidReal+"-images-info-values.json",
            dataType: "json",
        }).done(function(data) {

            cgJsClass.gallery.getJson.setInfo(gid,data,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);

        });

    },
    setInfo: function(gid,data,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues){

        for(var realId in data){

            if(!data.hasOwnProperty(realId)){
                break;
            }

            cgJsClass.gallery.info.collectInfo(gid,realId,data[realId]);
            cgJsData[gid].vars.info[realId] = data[realId];

        }

        cgJsClass.gallery.vars.isInfoDataAvailable = true;

        cgJsClass.gallery.sorting.showRandomButtonDelayed(gid,1500);// ALL three big requests has to be done before, image-data, sorting-data, info-data!

        if(imageDataPassedArgumentsWithoutIsDoNotCheckSortValues){
            imageDataPassedArgumentsWithoutIsDoNotCheckSortValues.push(true);// with push true isDoNotCheckSortValues will be set
            this.imageData.apply(null,imageDataPassedArgumentsWithoutIsDoNotCheckSortValues);
        }

    },
    removeMainCGalleryLoader: function($mainCGdiv){

        // cg_fade_in
        setTimeout(function () {
            $mainCGdiv.find('.cg-lds-dual-ring-div-gallery-hide-mainCGallery').addClass('cg_hide');
            $mainCGdiv.find('.mainCGallery').removeClass('cg_hide').addClass('cg_fade_in');
        },700);

    },
    abortGetJson: function (gid) {

        for(var key in cgJsData[gid].vars.getJson){

            if(!cgJsData[gid].vars.getJson.hasOwnProperty(key)){
                break;
            }

            cgJsData[gid].vars.getJson[key].abort();
        }
        cgJsData[gid].vars.getJson = [];

    },
    showGalleryLoader: function (gid) {
        jQuery('#mainCGdivHelperParent'+gid).addClass('cg_display_block');
        jQuery('#cgLdsDualRingDivGalleryHide'+gid).removeClass('cg_hide');
    },
    hideGalleryLoader: function (gid) {
        jQuery('#mainCGdivHelperParent'+gid).removeClass('cg_display_block');
        jQuery('#cgLdsDualRingDivGalleryHide'+gid).addClass('cg_hide');
    }
};
