cgJsClass.gallery.views.close = function (gid,closeAnotherGallery,realId) {


    if(typeof gid == 'undefined'){
      gid = cgJsClass.gallery.vars.openedGallery;
    }

    var cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;

    // fblike extra append back wenn fblikeoutgallery on
    var FbLike = cgJsData[gid].options.general.FbLike;
    var FbLikeGallery = cgJsData[gid].options.general.FbLikeGallery;
    if(FbLike >=1 && FbLikeGallery>=1 && cgJsData[gid].vars.openedRealId>=1){

        var fbContent = cgCenterDiv.find('#cgCenterImageFbLikeDiv'+gid).html();
        cgJsData[gid].imageObject[cgJsData[gid].vars.openedRealId].find('.cg_gallery_facebook_div').html(fbContent).removeClass('cg_hide');

    }

    cgCenterDiv.css('display','none');

    cgJsData[gid].vars.openedGalleryImageOrder = null;

    cgJsClass.gallery.vars.openedRealId = 0;
    cgJsData[gid].vars.openedRealId = 0;



    // remove hash
    history.pushState("", document.title, window.location.pathname);

    if(closeAnotherGallery != true){
      //  jQuery('#cgCenterDiv'+gid).cgGoTo();
        cgJsClass.gallery.vars.openedGallery = null;
    }
    cgJsClass.gallery.views.cloneFurtherImagesStep(gid);


};
cgJsClass.gallery.views.closeCenterDiv = function (gid) {
        return;
    // falls ein Bild geöffnet ist, muss alles zurückgesetzt werden!!!!
    if(jQuery('.cgCenterDiv').is(':visible')){
        jQuery('.cgCenterDiv').css('display','none');
        if(typeof gid != 'undefined'){
            cgJsData[gid].vars.openedGalleryImageOrder = null;
        }else{
            jQuery('.cgCenterDiv').each(function () {

                var gid = jQuery(this).attr('data-cg-gid');
                cgJsData[gid].vars.openedGalleryImageOrder = null;

            });
        }

    }

};