cgJsClass.gallery.hashchange = {
    initCheckHashChangeEvent: function () {

        jQuery(window).on('hashchange', function () {

            return;

/*            console.log('keypress')
            console.log(cgJsClass.gallery.vars.arrowKeyPress)
            return;
            if(cgJsClass.gallery.vars.arrowKeyPress){
                return;
            }*/


            if(cgJsClass.gallery.vars.openedUploadFormGalleryId){
                cgJsClass.gallery.upload.close(cgJsClass.gallery.vars.openedUploadFormGalleryId);
            }

            var gid = 0;

            if (location.href.indexOf('#!gallery/') >= 0) {
                var hash = location.hash.split("/");
                gid = hash[1];
                cgJsClass.gallery.vars.showImageClicked = false;
            }

            // fire only if hash hast step (stepchange)
            if (location.href.indexOf('#!gallery/'+gid+'/step/') >= 0) {
                var length = Object.keys(cgJsData[gid].fullImageData).length;
                var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);

                // Cut data here or something like this if data length higher then PicsPerSite
                if (length > PicsPerSite) {

                    var step = cgJsClass.gallery.dynamicOptions.checkIfStepClick();
                    cgJsClass.gallery.dynamicOptions.checkStepsCutImageData(jQuery, step, true,true,gid);
                    //  cgJsClass.gallery.views.clickFurtherImagesStep.init();

                }
                return;

            }
            else{

                if(cgJsClass.gallery.vars.fullscreen==true){
                    return;
                }

                cgJsClass.gallery.hashchange.checkHash(jQuery,true);
            }


        });

    },
    activateHashChangeEvent: function(){

        clearTimeout(cgJsClass.gallery.hashchange.setTimeoutEvent);
        cgJsClass.gallery.hashchange.setTimeoutEvent = setTimeout(function () {

            var checkDifference = new Date().getTime()/1000-cgJsClass.gallery.vars.keypressStartInSeconds;
            if(checkDifference>0.5){
                cgJsClass.gallery.hashchange.initCheckHashChangeEvent();
            }

        },3000);

    },
    setTimeoutEvent: null,
    checkHash: function ($,backButton,counter,isOpenedPage) {


        // dann nicht weitermachen weil hashchange von von show image click
        if(cgJsClass.gallery.vars.showImageClicked == true){
            setTimeout(function () {
                cgJsClass.gallery.vars.showImageClicked = false;
            },100);
            return;
        }

        // open image if right url
        if (location.href.indexOf('#!gallery') > 0) {

            if(backButton === true){

                cgJsClass.gallery.hashchange.checkHashFunction($,backButton,counter,isOpenedPage);

            }else{

                setTimeout(function(){

                    cgJsClass.gallery.hashchange.checkHashFunction($,backButton,counter,isOpenedPage);

                },200);

            }

        }
        else{
            //cgJsClass.gallery.views.closeCenterDiv();
        }



    },
    checkHashFunction: function($,backButton,counter,isOpenedPage){

        var obj = cgJsClass.gallery.hashchange.getRealIdAndGid(isOpenedPage);
        var realId = obj['realId'];
        var gid = obj['gid'];


        if(cgJsClass.gallery.vars.openedRealId==realId){
            return;
        }

        if(typeof realId == 'undefined'){
            return;
        }

        if(cgJsData[gid].hasOwnProperty('options')){
            if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                return;
            }
            if(cgJsData[gid].options.general.OnlyGalleryView==1){
                return;
            }
        }

        cgJsClass.gallery.vars.galleryForRecursiveNavigation = gid;

        if(backButton != true){
            jQuery('#mainCGdiv'+gid).find('.cg-lds-dual-ring-div').removeClass('cg_hide').addClass('cg_fade_in_loader');
        }


        // IMPORTANT!!! Check if images loaded if not try again till loaded
        if(typeof cgJsData[gid].image != 'object'){

            if(typeof counter == 'undefined'){
                counter = 0;
            }else{
                counter++;
            }
            if(counter==50){
                jQuery('#mainCGdiv'+gid).find('.cg-lds-dual-ring-div').addClass('cg_hide').removeClass('cg_fade_in_loader');
                return;
            }
            cgJsClass.gallery.hashchange.checkHash($,false,counter);

        }else{
            if(Object.keys(cgJsData[gid].image).length==0){
                if(typeof counter == 'undefined'){
                    counter = 0;
                }else{
                    counter++;
                }
                if(counter==50){
                    jQuery('#mainCGdiv'+gid).find('.cg-lds-dual-ring-div').addClass('cg_hide').removeClass('cg_fade_in_loader');
                    return;
                }
                cgJsClass.gallery.hashchange.checkHash($,false,counter);
            }
        }

        try {

            var firstStep = false;

            jQuery(cgJsData[gid].image).each(function (index,value) {

                if(Object.keys(value)[0]==realId){

                    firstStep = true;

                }

            });



            if(cgJsData[gid].options.general.SliderLook==1){
                cgJsData[gid].vars.openedRealId = realId;
            }


            if(firstStep==false){

                var i=1;

                var length = Object.keys(cgJsData[gid].fullImageData).length;
                var PicsPerSite = parseInt(cgJsData[gid].options.general.PicsPerSite);

                jQuery(cgJsData[gid].fullImageData).each(function (index,value) {

                    // cgJsClass.gallery.hashchange.rowIdOfRealId weil nach rowId immer sortiert
                    // cgJsClass.gallery.hashchange.rowIdOfRealId kommt aus init-gallery-v10
                    if(Object.keys(value)[0]==cgJsClass.gallery.hashchange.rowIdOfRealId){

                        var step = Math.floor(i/PicsPerSite)+1;

                        /*
                                                        console.log('step')
                                                        console.log(step)
                                                        console.log('i')
                                                        console.log(i)
                                                        console.log('PicsPerSite')
                                                        console.log(PicsPerSite)
                                                        var result = i/PicsPerSite;
                                                        console.log('result')
                                                        console.log(result)*/

                        if(cgJsData[gid].options.general.SliderLook!=1){

                            jQuery('#mainCGdiv'+gid).find('.cg_further_images[data-cg-step='+step+']').first().click();

                            var order = i-PicsPerSite-1;

                            setTimeout(function () {
                                if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                                    return;
                                }

                                if(cgJsData[gid].options.general.OnlyGalleryView==1){
                                    return;
                                }

                                //cgJsClass.gallery.views.singleView.openImage($, order, false, gid);
                                jQuery('#cg_append'+realId+'').addClass('cg_open_gallery').click();
                            },100);

                        }



                        return;

                    }

                    i++;

                });

            }



            //load recursive function till   element exists
            function checkRecursive(i, breakCheck, realId) {

                var check = false;

                setTimeout(function () {

                    var gid =cgJsClass.gallery.vars.galleryForRecursiveNavigation;

                    if ($('#cg_show' + realId).length >= 1) {
                        // var order = $('#cg_show' + realId).attr('data-cg-order');
                        jQuery('#mainCGdiv'+gid).find('.cg-lds-dual-ring-div').addClass('cg_hide').removeClass('cg_fade_in_loader');

                        if(cgJsData[gid].options.general.SliderLook!=1){

                            if(cgJsData[gid].options.general.FullSizeImageOutGallery==1){
                                return;
                            }

                            if(cgJsData[gid].options.general.OnlyGalleryView==1){
                                return;
                            }

                            //cgJsClass.gallery.views.singleView.openImage($, order, false, gid);
                            jQuery('#cg_append'+realId+'').addClass('cg_open_gallery').click();
                        }

                        check = true;

                        return;

                    } else {
                        /*
                                                        console.log('checkRecursiveAgain')
                                                        console.log(i)

                                                        console.log('realId')
                                                        console.log(realId)
                                                        console.log('gid')
                                                        console.log(gid)*/

                        i++;


                        if (i == 35) {


                            jQuery('#mainCGdiv'+gid).find('.cg-lds-dual-ring-div').addClass('cg_hide');
                            return;
                        }

                        checkRecursive(i, false, realId);

                    }

                }, 100);

            }


            var i = 0;

            checkRecursive(i, false, realId)

        }
        catch (e) {
            jQuery('#mainCGdiv'+gid).find('.cg-lds-dual-ring-div').addClass('cg_hide');
        }


    },
    getRealIdAndGid: function (isOpenedPage) {

        var hashArr = location.hash.split("/");
        var gid = hashArr[1];

        var realId = hashArr[3];

        // wenn url manuel vom user abgeändert wurde
        if(typeof realId == 'undefined' || realId == '' || typeof gid == 'undefined' || gid == ''){
            location.hash = '';
            location.reload();
        }

        var obj = {};
        obj['realId'] = realId;
        obj['gid'] = gid;

        if(isOpenedPage==true){
            cgJsClass.gallery.vars.byStartPageOpenedImageId=realId;
        }

        return obj;
    },
    rowIdOfRealId: null
};