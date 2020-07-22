cgJsClass.gallery.rating.clickRateOneStar = function (gid) {

    jQuery( document ).on( 'click', '.cg_rate_star,.cg_rate_minus', function(e) {

        e.preventDefault();

        var gid = jQuery(this).attr('data-cg-gid');

        /*
        if(cgJsData[gid].onlyLoggedInUserImages===true){
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.YouCanNotVoteInOwnGallery);
            return;
        }*/

        var minusVoteNow = 0;

        if((cgJsData[gid].options.pro.SliderFullWindow==1 && cgJsClass.gallery.vars.fullwindow) || (cgJsData[gid].vars.currentLook=='thumb' && cgJsData[gid].options.general.SliderLook==1)){

            // then clicked from slider preview
            if(jQuery(this).closest('.mainCGslider').length>=1){

                return;

            }

        }

        if(jQuery(this).hasClass('cg_rate_out_gallery_disallowed') && cgJsData[gid].options.general.RatingOutGallery!='1'){
            return;
        }

        if(cgJsData[gid].options.general.AllowRating!='2'){
            return;
        }

        if(jQuery(this).parent().parent().parent().hasClass('cg_gallery_info')){
            var order = jQuery(this).closest('.cg_show').attr('data-cg-order');
            if(cgJsData[gid].vars.openedGalleryImageOrder!=order && cgJsData[gid].options.general.RatingOutGallery!='1'){
                cgJsClass.gallery.views.singleView.openImage(jQuery,order,false,gid);
            }
        }

        if(cgJsData[gid].options.general.AllowRating!='2'){
            return;
        }

        if(cgJsData[gid].vars.cg_check_login==1 && cgJsData[gid].vars.cg_user_login_check==0){

            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.OnlyRegisteredUsersCanVote);
            return false;
        }


        if(cgJsData[gid].options.pro.MinusVote==1 && jQuery(this).hasClass('cg_rate_minus')){
            minusVoteNow = 1;
        }

        var cg_picture_id = jQuery(this).attr('data-cg_rate_star_id');

        var cg_rate_value = 1;

        var imageObject = cgJsData[gid].imageObject[cg_picture_id];
        imageObject.find('.cg_gallery_rating_div_child').empty().addClass('cg-lds-dual-ring-star-loading');

        var cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;
        if(cgCenterDiv.is(':visible')){
            if(cgJsData[gid].vars.openedRealId==cg_picture_id){
                cgCenterDiv.find('.cg_gallery_rating_div_child').empty().addClass('cg-lds-dual-ring-star-loading');
            }
        }

        jQuery.ajax({
            url : post_cg_rate_v10_oneStar_wordpress_ajax_script_function_name.cg_rate_v10_oneStar_ajax_url,
            type : 'post',
            data : {
                action : 'post_cg_rate_v10_oneStar',
                gid : cgJsData[gid].vars.gidReal,
                galeryIDuser : gid,
                pid : cg_picture_id,
                value : cg_rate_value,
                minusVoteNow : minusVoteNow,
                galleryHash : cgJsData[gid].vars.galleryHash
            }
        }).done(function(response) {

            var parser = new DOMParser();
            var parsedHtml = parser.parseFromString(response, 'text/html');

            jQuery(parsedHtml).find('script[data-cg-processing="true"]').each(function () {

                var script = jQuery(this).html();
                eval(script);

            });

        }).fail(function(xhr, status, error) {

            cgJsClass.gallery.rating.setRatingOneStar(cg_picture_id,0,false,gid,false,false);

        }).always(function() {

        });


    });
    
};