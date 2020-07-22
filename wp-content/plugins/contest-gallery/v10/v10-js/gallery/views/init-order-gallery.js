cgJsClass.gallery.views.initOrderGallery = function (gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked, sliderView,isCopyUploadToAnotherGallery) {

  //  debugger
    // abort all actual requests for this gallery
    if(cgJsData[gid].vars.getJson.length>0 && openPage==false){
        cgJsClass.gallery.getJson.abortGetJson(gid);
    }

    var sliderFullWindow = false;

    if(cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow){
        sliderFullWindow = true;
    }

    // if current Look already defined then this can be init
    if(cgJsData[gid].vars.currentLook=='row' && !sliderFullWindow){
        cgJsClass.gallery.rowLogic.init(jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery);
       // cgJsClass.gallery.resize.resizeInfo(gid);
        cgJsClass.gallery.views.cloneFurtherImagesStep(gid);

      //  cgJsClass.gallery.dynamicOptions.getCurrentRatingAndCommentsData(gid); MUST BE NOT REQUIRED ANYMORE 21.03.2020

        return;

    }
    if(cgJsData[gid].vars.currentLook=='height' && !sliderFullWindow){
        cgJsClass.gallery.heightLogic.init(jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery);
    //    cgJsClass.gallery.resize.resizeInfo(gid);
        cgJsClass.gallery.views.cloneFurtherImagesStep(gid);

       // cgJsClass.gallery.dynamicOptions.getCurrentRatingAndCommentsData(gid); MUST BE NOT REQUIRED ANYMORE 21.03.2020

        return;
    }
    if((cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook!='1') || sliderFullWindow==true){
        cgJsClass.gallery.thumbLogic.init(jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery);
    //   cgJsClass.gallery.resize.resizeInfo(gid);
        cgJsClass.gallery.views.cloneFurtherImagesStep(gid);

       // cgJsClass.gallery.dynamicOptions.getCurrentRatingAndCommentsData(gid); MUST BE NOT REQUIRED ANYMORE 21.03.2020

        return;
    }

    if((cgJsData[gid].options.general.SliderLook=='1' && cgJsData[gid].vars.orderGalleries[1]=='SliderLookOrder') || sliderView==true){
        cgJsClass.gallery.thumbLogic.init(jQuery,gid,openPage,calledFromUpload,openImage,stepChange,viewChange,randomButtonClicked,isCopyUploadToAnotherGallery);
        return;
    }

};

cgJsClass.gallery.views.checkOrderGallery = function (gid) {

    var sliderView = false;

    if((cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow) || (cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1)){
        sliderView = true;
    }

    if(typeof cgJsData[gid].vars.currentLook != 'undefined'){

        if(sliderView){
            cgJsData[gid].vars.currentLook='thumb';
            cgJsData[gid].options.general.SliderLook='1';
            cgJsData[gid].vars.orderGalleries[1]='SliderLookOrder';
            return;
        }

        if(cgJsData[gid].vars.currentLook=='thumb'){
            cgJsData[gid].options.general.SliderLook='0';
            return;
        }

        if(cgJsData[gid].vars.currentLook=='height'){
            cgJsData[gid].options.general.SliderLook='0';
            return;
        }
        if(cgJsData[gid].vars.currentLook=='row'){
            cgJsData[gid].options.general.SliderLook='0';
            return;
        }

    }

    // Check wich view to start
    // WIRD NUR BEIM ERSTEN LOAD GEMACHT
    // DANACH SIND LOOKS GESETZT
    for(var property in cgJsData[gid].vars.orderGalleries){

        if(!cgJsData[gid].vars.orderGalleries.hasOwnProperty(property)){
            break;
        }

        if(cgJsData[gid].vars.orderGalleries[property]=='SliderLookOrder' && cgJsData[gid].options.general.SliderLook=='1' || sliderView==true){
            cgJsData[gid].vars.currentLook='thumb';
            cgJsData[gid].options.general.SliderLook='1';
            cgJsData[gid].vars.orderGalleries[1]='SliderLookOrder';
            break;
        }

        if(cgJsData[gid].vars.orderGalleries[property]=='ThumbLookOrder' && cgJsData[gid].options.general.ThumbLook=='1'){
            cgJsData[gid].vars.currentLook='thumb';
            cgJsData[gid].options.general.SliderLook='0';
            //     cgJsClass.gallery.resize.resizeInfo(gid,openPage);

            break;
        }

        if(cgJsData[gid].vars.orderGalleries[property]=='HeightLookOrder' && cgJsData[gid].options.general.HeightLook=='1'){
            cgJsData[gid].vars.currentLook='height';
            cgJsData[gid].options.general.SliderLook='0';
            //    cgJsClass.gallery.resize.resizeInfo(gid,openPage);

            break;
        }

        if(cgJsData[gid].vars.orderGalleries[property]=='RowLookOrder' && cgJsData[gid].options.general.RowLook=='1'){
            cgJsData[gid].vars.currentLook='row';
            cgJsData[gid].options.general.SliderLook='0';
            //    cgJsClass.gallery.resize.resizeInfo(gid,openPage);
            break;
        }

    }

};