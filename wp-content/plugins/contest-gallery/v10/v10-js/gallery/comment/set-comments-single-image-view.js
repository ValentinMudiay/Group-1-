cgJsClass.gallery.comment.setCommentsSingleImageView = function (realId,gid,cgCenterDiv,imageObject) {

    var uploadFolderUrl = cgJsData[gid].vars.uploadFolderUrl;
    var galleryId = gid;


    var $cgCenterImageCommentsDiv = jQuery('#cgCenterImageCommentsDiv'+gid);
    var $cgCenterImageCommentsDivTitle = jQuery('#cgCenterImageCommentsDivTitle'+gid);

    $cgCenterImageCommentsDiv.addClass('cg_hide');
    var append = false;

    if(cgJsData[gid].vars.openedRealId){

        // alle getInfo requests abbrechen, damit info nicht mehrfach gesetzt wird
        if(cgJsData[gid].vars.jsonGetComment>0){
            for(var key in cgJsData[gid].vars.jsonGetComment){

                if(!cgJsData[gid].vars.jsonGetComment.hasOwnProperty(key)){
                    break;
                }

                cgJsData[gid].vars.jsonGetComment[key].abort();
            }
        }
        cgJsData[gid].vars.jsonGetComment = [];

    }


    cgJsData[gid].vars.jsonGetComment.push(jQuery.getJSON( uploadFolderUrl+"/contest-gallery/gallery-id-"+cgJsData[gid].vars.gidReal+"/json/image-comments/image-comments-"+realId+".json", {_: new Date().getTime()}).done(function( data ) {

    }).done(function(data){

        if (typeof data === 'object') {

            if(Object.keys(data).length>=1){

                if(append == false){
                    $cgCenterImageCommentsDiv.removeClass('cg_hide');
                    $cgCenterImageCommentsDivTitle.removeClass('cg_hide');
                    jQuery('#cgCenterInfoDiv'+gid).find('.cg-center-image-comments-div-parent-parent').removeClass('cg_hide');
                    append = true;
                }

                for(var value in data){

                    if(!data.hasOwnProperty(value)){
                        break;
                    }

                    var comment = data[value]['comment'];
                    var name = data[value]['name'];
                    var timestamp = parseInt(data[value]['timestamp']);

                    var date = cgJsClass.gallery.comment.getDateDependsOnLocaleLang(timestamp);

                    var commentDiv = jQuery('<div class="cg-center-image-comments-div"></div>');
                    commentDiv.append('<p>'+comment+'</p>');
                    commentDiv.prepend('<p>'+name+'</p>');
                    commentDiv.prepend('<p>'+date+'</p>');

                    $cgCenterImageCommentsDiv.prepend(commentDiv);

                }

                cgCenterDiv.find('#cgCenterImageCommentsDivParentParent'+gid).removeClass('cg_hide');
                cgJsClass.gallery.comment.checkIfTopBottomArrowsRequired(gid);

            }else{

                cgJsClass.gallery.views.singleViewFunctions.cloneCommentDiv(gid,realId,cgCenterDiv,imageObject);

                //  cgCenterDiv.find('#cgCenterImageCommentsDivParentParent'+gid).removeClass('cg_hide');
                $cgCenterImageCommentsDiv.removeClass('cg_hide');
                $cgCenterImageCommentsDivTitle.removeClass('cg_hide');
                jQuery('#cgCenterInfoDiv'+gid).find('.cg-center-image-comments-div-parent-parent').removeClass('cg_hide');
                append = true;
            }



        }

        cgCenterDiv.find('.cg-center-image-comments-div-parent > .cg-center-image-comments-div-add-comment').removeClass('cg_hidden');

    }).fail(function (error) {

        cgCenterDiv.find('.cg-center-image-comments-div-parent > .cg-center-image-comments-div-add-comment').removeClass('cg_hidden');
    }));


};
cgJsClass.gallery.comment.checkIfTopBottomArrowsRequired = function (gid) {


    var $cgCenterInfoDiv = jQuery('#cgCenterInfoDiv'+gid);

    // falls diese funktion angwendet dann werden komments definitiv angzeigt und der separator kann auch angezeigt werden
    //$cgCenterInfoDiv.find('.cg-center-image-info-comments-separator').removeClass('cg_hide');

   // setTimeout(function () {

        var collectedHeight = 0;
        // collect possible margin and padding here!
        var marginTop = parseInt($cgCenterInfoDiv.find('#cgCenterImageCommentsDiv'+gid).css('marginTop'));
        var marginBottom = parseInt($cgCenterInfoDiv.find('#cgCenterImageCommentsDiv'+gid).css('marginBottom'));
        var paddingTop = parseInt($cgCenterInfoDiv.find('#cgCenterImageCommentsDiv'+gid).css('paddingTop'));
        var paddingBottom = parseInt($cgCenterInfoDiv.find('#cgCenterImageCommentsDiv'+gid).css('paddingBottom'));

        $cgCenterInfoDiv.find('#cgCenterImageCommentsDiv'+gid).find('.cg-center-image-comments-div').each(function () {
            collectedHeight = collectedHeight+jQuery(this).outerHeight(true);//include everything padding border margin
        });

        // +20px margin und +20px bottom eventually
        collectedHeight = collectedHeight+marginTop+marginBottom+paddingTop+paddingBottom;

        if(collectedHeight>=300){
            $cgCenterInfoDiv.find('.cg-center-image-comments-div-parent-parent .cg-top-bottom-arrow').removeClass('cg_hide');
            $cgCenterInfoDiv.find('.cg-center-image-comments-div-parent').addClass('cg-center-image-info-div-parent-padding');
        }

  //  },200)

};
cgJsClass.gallery.comment.getDateDependsOnLocaleLang = function (timestamp) {

    var localeLang = cgJsClass.gallery.vars.localeLang;

    if(localeLang=='de_DE'){
        return cgJsClass.gallery.comment.setGermanDateStyle(timestamp);
    }
    else{
        return cgJsClass.gallery.comment.setUsDateStyle(timestamp);
    }

};
cgJsClass.gallery.comment.setUsDateStyle = function (timestamp) {

    var commentDate = new Date(timestamp*1000);

    var month = parseInt(commentDate.getMonth());
    month = month+1;

    var monthUS = month;

    var hours = commentDate.getHours();
    var minutes = commentDate.getMinutes();

    if(commentDate.getMinutes()<10){

        var minutes = "0"+commentDate.getMinutes();

    }

    if(commentDate.getHours()<10){

        var hours = "0"+commentDate.getHours();

    }

    return commentDate.getFullYear()+"/"+monthUS+"/"+commentDate.getDate()+" "+hours+":"+minutes;

};

cgJsClass.gallery.comment.setGermanDateStyle = function (timestamp) {

    var commentDate = new Date(timestamp*1000);

    var month = parseInt(commentDate.getMonth());
    month = month+1;

    var monthUS = month;

    var hours = commentDate.getHours();
    var minutes = commentDate.getMinutes();

    if(commentDate.getMinutes()<10){

        var minutes = "0"+commentDate.getMinutes();

    }

    if(commentDate.getHours()<10){

        var hours = "0"+commentDate.getHours();

    }


    return commentDate.getDate()+"."+monthUS+"."+commentDate.getFullYear()+" "+hours+":"+minutes;


};
