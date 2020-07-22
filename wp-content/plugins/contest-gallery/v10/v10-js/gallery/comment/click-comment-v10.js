cgJsClass.gallery.comment.clickComment = function () {

/*    jQuery(document).on('click', '.cg_gallery_comments_div_icon', function(e){

        e.preventDefault();
        e.stopPropagation();
        return;
        if(jQuery(this).hasClass('cg_inside_center_div')){
            return;
        }

        var gid = jQuery(this).closest('.mainCGallery').attr('data-cg-gid');

        if(cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1){
            return;
        }

        if(cgJsData[gid].options.general.AllowComments!='1'){
            return;
        }

        if(cgJsData[gid].options.general.OnlyGalleryView==1){
            return;
        }

        var order = jQuery(this).closest('.cg_show').attr('data-cg-order');
        var openComment = true;

        cgJsClass.gallery.views.singleView.openImage(jQuery,order,openComment,gid);

    });*/

    jQuery(document).on('click', '.cg-center-image-comments-div-enter-submit', function(e){

        e.preventDefault();
        e.stopPropagation();

        var gid = jQuery(this).closest('.mainCGallery').attr('data-cg-gid');

        var order = cgJsData[gid].vars.openedGalleryImageOrder;
        var firstKey = Object.keys(cgJsData[gid].image[order])[0];
        var realId = cgJsData[gid].image[order][firstKey]['id'];
        cgJsClass.gallery.comment.showSetComments(realId,gid);

    });

};