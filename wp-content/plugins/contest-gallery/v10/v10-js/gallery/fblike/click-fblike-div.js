cgJsClass.gallery.fbLike.clickFbLikeDiv = function (gid) {

/*    jQuery( document ).on( 'mouseleave', '.cg_gallery_facebook_div', function(e) {
        e.stopPropagation();

    });*/

    jQuery( document ).on( 'click', '.cg_gallery_facebook_div, .cg-center-image-fblike-div', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var gid = jQuery(this).attr('data-cg-gid');
        if(gid.indexOf('-u')>=0){
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.YouCanNotVoteInOwnGallery);
            return;
        }
    });

};