cgJsClass.gallery.comment.showSetCommentsSameGalleryId = function (realId,gid) {

    // check if further galleries exists which have to be update user or normal, both ways
    if(String(gid).indexOf('-u')>=0){// then must be user gallery, check for normal gallery then
        return; // it can't be voted in user gallery
    }
    if(String(gid).indexOf('-u')==-1){// then must be normal gallery, check for user gallery then
        var gidToCheck = gid+'-u';
        // then gallery must be existing
        if(cgJsData[gidToCheck]){
            cgJsClass.gallery.views.close(gidToCheck);
            cgJsClass.gallery.rating.showSetComments(realId,gidToCheck,true);
        }
    }

};
cgJsClass.gallery.comment.appendComment = function (realId,gid,name,comment) {

    jQuery('#cgCenterImageCommentsDivEnterTitle'+gid).val('');
    jQuery('#cgCenterImageCommentsDivEnterTextarea'+gid).val('');

    jQuery('#cgCenterImageCommentsDiv'+gid).removeClass('cg_hide');
    jQuery('#cgCenterImageCommentsDivTitle'+gid).removeClass('cg_hide');
    jQuery('#cgCenterInfoDiv'+gid).find('.cg-center-image-comments-div-parent-parent').removeClass('cg_hide');

    jQuery('#cgCenterImageCommentsDivEnterTitleError'+gid).addClass('cg_hide');
    jQuery('#cgCenterImageCommentsDivEnterTextareaError'+gid).addClass('cg_hide');

    // in der function später kommt *1000 vor weil auf php unix time eingestellt ist welches mit 1000 weniger zurückgibt
    var timestamp = parseInt(new Date().getTime())/1000;

    var date = cgJsClass.gallery.comment.getDateDependsOnLocaleLang(timestamp);

    var commentDiv = jQuery('<div class="cg-center-image-comments-div"></div>');
    commentDiv.append('<p>'+comment+'</p>');
    commentDiv.prepend('<p>'+name+'</p>');
    commentDiv.prepend('<p>'+date+'</p>');
    jQuery("#cgCenterImageCommentsDiv"+gid).prepend(commentDiv);
    jQuery("#cgCenterImageCommentsDiv"+gid).find('.cg-center-for-your-comment-message').remove();


    if(String(gid).indexOf('-u')==-1) {// then must be normal gallery, check for user gallery then
        var thankYouDiv = jQuery('<div class="cg-center-image-comments-div"></div>');
        thankYouDiv.prepend('<p class="cg-center-for-your-comment-message">'+cgJsClass.gallery.language.ThankYouForYourComment+'</p>');
        jQuery("#cgCenterImageCommentsDiv"+gid).prepend(thankYouDiv);
    }

};
cgJsClass.gallery.comment.appendCommentUserGalleryIfExists = function (realId,gid,name,comment) {

    // check if further galleries exists which have to be update user or normal, both ways
    if(String(gid).indexOf('-u')>=0){// then must be user gallery, check for normal gallery then
        return; // it can't be voted in user gallery
    }
    if(String(gid).indexOf('-u')==-1){// then must be normal gallery, check for user gallery then
        var gidToCheck = gid+'-u';
        // then gallery must be existing
        if(cgJsData[gidToCheck]){
         //   cgJsClass.gallery.views.close(gidToCheck);
          //  cgJsClass.gallery.rating.showSetComments(realId,gidToCheck,true);

            // commentar count aktualisieren!
            cgJsClass.gallery.comment.setComment(realId,1,gidToCheck);
            if(cgJsData[gidToCheck].vars.rawData[realId]){// check if image exists in this gallery
                cgJsClass.gallery.comment.appendComment(realId,gidToCheck,name,comment);
                cgJsClass.gallery.comment.checkIfTopBottomArrowsRequired(gidToCheck);
                cgJsClass.gallery.views.scrollInfoOrCommentTopFullHeight(gidToCheck);
            }
        }
    }

};
cgJsClass.gallery.comment.showSetComments = function (realId,gid,isSetFromSameGalleryId) {

    if(String(gid).indexOf('-u')>=0){// then must be from user gallery, user can not comment in own gallery
        cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.YouCanNotCommentInOwnGallery);
        return;
    }

    var name = jQuery('#cgCenterImageCommentsDivEnterTitle'+gid).val();
    var comment = jQuery('#cgCenterImageCommentsDivEnterTextarea'+gid).val();

    if(name.length<2){
        var errorMessage = cgJsClass.gallery.language.TheNameFieldMustContainTwoCharactersOrMore;
        jQuery('#cgCenterImageCommentsDivEnterTitleError'+gid).text(errorMessage).removeClass('cg_hide');
    }

    if(comment.length<3){
        var errorMessage = cgJsClass.gallery.language.TheCommentFieldMustContainThreeCharactersOrMore;
        jQuery('#cgCenterImageCommentsDivEnterTextareaError'+gid).text(errorMessage).removeClass('cg_hide');
    }

    if(name.length<2 || comment.length<3){ return; }

    cgJsClass.gallery.comment.appendComment(realId,gid,name,comment);

    // Anders funktioniert es ansonsten im FullWindow nicht
    if(cgJsClass.gallery.vars.fullwindow){

        location.href = '#cgCenterImageCommentsDiv'+gid;
        cgJsClass.gallery.views.singleView.createImageUrl(gid,realId);

    }else{
        jQuery('html, body').animate({
            scrollTop: jQuery('#cgCenterImageCommentsDiv'+gid).offset().top - 110+'px'
        }, 'fast');
    }

    // commentar count aktualisieren!
    cgJsClass.gallery.comment.setComment(realId,1,gid);

    cgJsClass.gallery.comment.appendCommentUserGalleryIfExists(realId,gid,name,comment);

    var widthButton = jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).width();
            jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).width(widthButton);
            jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).css({
                'pointer-events': 'none',
                'cursor': 'none'
            });


            // timer disabled submit button
            var checkRecursive = function checkRecursive(i){

                setTimeout(function () {

                        i--;

                        if(i==0){
                            jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).prop('disabled',false);
                            jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).text(cgJsClass.gallery.language.Send);
                            jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).removeAttr('style');
                            return;
                        }

                        jQuery('#cgCenterImageCommentsDivEnterSubmit'+gid).text(i);
                        checkRecursive(i,false);

                },1000);

            };

            checkRecursive(11);

            cgJsClass.gallery.comment.checkIfTopBottomArrowsRequired(gid);
            cgJsClass.gallery.views.scrollInfoOrCommentTopFullHeight(gid);

    // 09.03.2020 vorläufig noch nicht aktiviert!!!!
    /*    if(!isSetFromSameGalleryId){// then it is already done
            // maybe same user id or same general id is on same page
            setTimeout(function () {
                cgJsClass.gallery.comment.showSetCommentsSameGalleryId(realId,gid);
            },100);
        }*/


            jQuery.ajax({
                url : cg_show_set_comments_v10_wordpress_ajax_script_function_name.cg_show_set_comments_v10_ajax_url,
                type : 'post',
                data : {
                    action : 'cg_show_set_comments_v10',
                    pid : realId,
                    gid : cgJsData[gid].vars.gidReal,
                    name : name,
                    comment : comment,
                    galeryIDuser : gid,
                    galleryHash : cgJsData[gid].vars.galleryHash
                },
                }).done(function(response) {

                    var parser = new DOMParser();
                    var parsedHtml = parser.parseFromString(response, 'text/html');
                    var script = jQuery(parsedHtml).find('script[data-cg-processing="true"]').first();

                    if(!script.length){

                        cgJsClass.gallery.function.message.show('Your comment could not be saved. Please contact administrator.');

                        // commentar count aktualisieren!
                        cgJsClass.gallery.comment.setComment(realId,-1,gid);
                        jQuery('#cgCenterImageCommentsDiv'+gid).find('.cg-center-image-comments-div').first().remove().next().remove();

                    }

                }).fail(function(xhr, status, error) {

                cgJsClass.gallery.function.message.show('Your comment could not be saved. Please contact administrator.');

                // commentar count aktualisieren!
                cgJsClass.gallery.comment.setComment(realId,-1,gid);
                jQuery('#cgCenterImageCommentsDiv'+gid).find('.cg-center-image-comments-div').first().remove().next().remove();

            }).always(function() {

            });


};

