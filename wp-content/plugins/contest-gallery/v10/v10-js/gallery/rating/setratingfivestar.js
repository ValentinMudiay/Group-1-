// Reihenfolge der Funktionen beachten!!!
cgJsClass.gallery.rating.setStars = function(average,gid){

    // pauschal alle auf off setzen am Anfang

    var stars = {};

    stars.star1 = 'cg_gallery_rating_div_one_star_off';
    stars.star2 = 'cg_gallery_rating_div_one_star_off';
    stars.star3 = 'cg_gallery_rating_div_one_star_off';
    stars.star4 = 'cg_gallery_rating_div_one_star_off';
    stars.star5 = 'cg_gallery_rating_div_one_star_off';

    if(average>=1){stars.star1 = 'cg_gallery_rating_div_one_star_on'}
    if(average>=1.25 && average<1.75){stars.star2 = 'cg_gallery_rating_div_one_star_half_off'}

    if(average>=1.75){stars.star2 = 'cg_gallery_rating_div_one_star_on'}
    if(average>=2.25 && average<2.75){stars.star3 = 'cg_gallery_rating_div_one_star_half_off'}

    if(average>=2.75){stars.star3 = 'cg_gallery_rating_div_one_star_on'}
    if(average>=3.25 && average<3.75){stars.star4 = 'cg_gallery_rating_div_one_star_half_off'}

    if(average>=3.75){stars.star4 = 'cg_gallery_rating_div_one_star_on'}
    if(average>=4.25 && average<4.75){stars.star5 = 'cg_gallery_rating_div_one_star_half_off'}

    if(average>=4.75){stars.star5 = 'cg_gallery_rating_div_one_star_on'}

    return stars;

};
cgJsClass.gallery.rating.generateRatingDiv = function(realId,countR,imageObject,firstLoad,gid,stars,average,isFromSingleView){

    var userVoted = false;

    if(typeof cgJsData[gid].cgJsCountRuser[realId] != 'undefined'){
        if(cgJsData[gid].cgJsCountRuser[realId] > 0){
            userVoted = true;
        }
    }

    if(firstLoad == false){
        cgJsClass.gallery.dynamicOptions.setNewCountToMainImageArray(realId,'CountR',countR,gid);
    }

    var position = '';

    if(cgJsData[gid].options.general.RatingOutGallery!='1'){
        var cg_rate_out_gallery_disallowed = 'cg_rate_out_gallery_disallowed';
    }else{
        var cg_rate_out_gallery_disallowed = '';
    }

    if(cgJsData[gid].options.visual['RatingPositionGallery']==2){
        position = 'cg_center';
    }

    if(cgJsData[gid].options.visual['RatingPositionGallery']==3){
        position = 'cg_right';
    }

    if(cgJsData[gid].options.pro.MinusVote==1 && userVoted && !cgJsData[gid].vars.isUserGallery){
        var cg_rate_minus = '<div data-cg_rate_star_id="' + realId + '" class="cg_rate_minus cg_rate_minus_five_star" data-cg-gid="'+gid+'"></div>';
    }else{
        var cg_rate_minus = '';
    }

    var ratingDivChild = jQuery('<div class="cg_gallery_rating_div_star">' +
        '<div data-cg_rate_star="1" data-cg-gid="' + gid + '"  class="cg_rate_star cg_rate_star_five_star cg_gallery_rating_div_star_one_star '+ stars.star1 +' '+cg_rate_out_gallery_disallowed+'" data-cg_rate_star_id="' + realId + '"></div>' +
        '<div data-cg_rate_star="2" data-cg-gid="' + gid + '" class="cg_rate_star cg_rate_star_five_star cg_gallery_rating_div_star_one_star '+ stars.star2 +' '+cg_rate_out_gallery_disallowed+'" data-cg_rate_star_id="' + realId + '"></div>' +
        '<div data-cg_rate_star="3" data-cg-gid="' + gid + '" class="cg_rate_star cg_rate_star_five_star cg_gallery_rating_div_star_one_star '+ stars.star3 +' '+cg_rate_out_gallery_disallowed+'" data-cg_rate_star_id="' + realId + '"></div>' +
        '<div data-cg_rate_star="4" data-cg-gid="' + gid + '" class="cg_rate_star cg_rate_star_five_star cg_gallery_rating_div_star_one_star '+ stars.star4 +' '+cg_rate_out_gallery_disallowed+'" data-cg_rate_star_id="' + realId + '"></div>' +
        '<div data-cg_rate_star="5" data-cg-gid="' + gid + '" class="cg_rate_star cg_rate_star_five_star cg_gallery_rating_div_star_one_star '+ stars.star5 +' '+cg_rate_out_gallery_disallowed+'" data-cg_rate_star_id="' + realId + '"></div>' +
        '</div>' +
        '<div id="rating_cg-' + realId + '" class="cg_gallery_rating_div_count">' + countR + '</div>' +
        cg_rate_minus);

    if(cgJsData[gid].options.pro.IsModernFiveStar==1){

        //var averageRoundedOneDecimal = Math.round(average * 10)/10;

        var ratingData = cgJsData[gid].rating[realId];

        var percentageR1 = (ratingData['CountR1']==0 && ratingData['addCountR1']==0) ? 0 : Math.round((parseInt(ratingData['CountR1'])+parseInt(ratingData['addCountR1']))*100/parseInt(ratingData['CountRtotal']));
        var percentageR2 = (ratingData['CountR2']==0 && ratingData['addCountR2']==0) ? 0 : Math.round((parseInt(ratingData['CountR2'])+parseInt(ratingData['addCountR2']))*100/parseInt(ratingData['CountRtotal']));
        var percentageR3 = (ratingData['CountR3']==0 && ratingData['addCountR3']==0) ? 0 : Math.round((parseInt(ratingData['CountR3'])+parseInt(ratingData['addCountR3']))*100/parseInt(ratingData['CountRtotal']));
        var percentageR4 = (ratingData['CountR4']==0 && ratingData['addCountR4']==0) ? 0 : Math.round((parseInt(ratingData['CountR4'])+parseInt(ratingData['addCountR4']))*100/parseInt(ratingData['CountRtotal']));
        var percentageR5 = (ratingData['CountR5']==0 && ratingData['addCountR5']==0) ? 0 : Math.round((parseInt(ratingData['CountR5'])+parseInt(ratingData['addCountR5']))*100/parseInt(ratingData['CountRtotal']));
      //  var percentageTotal = percentageR1+percentageR2+percentageR3+percentageR4+percentageR5;
/*        if(percentageTotal > 100){

            var percentageOffset = percentageTotal-100;
            if(percentageR5>0 && percentageOffset!=0){percentageOffset=percentageOffset-1;percentageR5=percentageR5-1;}
            if(percentageR4>0 && percentageOffset!=0){percentageOffset=percentageOffset-1;percentageR4=percentageR4-1;}
            if(percentageR3>0 && percentageOffset!=0){percentageOffset=percentageOffset-1;percentageR3=percentageR3-1;}
            if(percentageR2>0 && percentageOffset!=0){percentageOffset=percentageOffset-1;percentageR2=percentageR2-1;}
            if(percentageR1>0 && percentageOffset!=0){percentageOffset=percentageOffset-1;percentageR1=percentageR1-1;}
        }*/

        var average = ratingData['RatingAverage'];

        var cg_hide = 'cg_hide';

        var $ratingDivChildShowOnHover = jQuery('<div class="cg_gallery_rating_div_star_hover">^</div>' +
            '<div class="cg_gallery_rating_div_five_star_details '+cg_hide+'" data-cg-gid="'+gid+'" data-cg-real-id="'+realId+'" id="cgDetails'+realId+'">' +
                '<div class="cg_five_star_details_average">'+average+' / 5</div>' +
                '<div class="cg_five_star_details_row">' +
                    '<div class="cg_five_star_details_row_number">5</div><div class="cg_five_star_details_row_star"></div>' +
                    '<div class="cg_five_star_details_row_progress"><progress value="'+percentageR5+'" max="100"></progress></div>' +
                    '<div class="cg_five_star_details_row_percentage">'+percentageR5+'%</div>' +
                '</div>' +
                '<div class="cg_five_star_details_row">' +
                    '<div class="cg_five_star_details_row_number">4</div><div class="cg_five_star_details_row_star"></div>' +
                    '<div class="cg_five_star_details_row_progress"><progress value="'+percentageR4+'" max="100"></progress></div>' +
                    '<div class="cg_five_star_details_row_percentage">'+percentageR4+'%</div>' +
                '</div>' +
                '<div class="cg_five_star_details_row">' +
                    '<div class="cg_five_star_details_row_number">3</div><div class="cg_five_star_details_row_star"></div>' +
                    '<div class="cg_five_star_details_row_progress"><progress value="'+percentageR3+'" max="100"></progress></div>' +
                    '<div class="cg_five_star_details_row_percentage">'+percentageR3+'%</div>' +
                '</div>' +
                '<div class="cg_five_star_details_row">' +
                    '<div class="cg_five_star_details_row_number">2</div><div class="cg_five_star_details_row_star"></div>' +
                    '<div class="cg_five_star_details_row_progress"><progress value="'+percentageR2+'" max="100"></progress></div>' +
                    '<div class="cg_five_star_details_row_percentage">'+percentageR2+'%</div>' +
                '</div>' +
                '<div class="cg_five_star_details_row">' +
                    '<div class="cg_five_star_details_row_number">1</div><div class="cg_five_star_details_row_star"></div>' +
                    '<div class="cg_five_star_details_row_progress"><progress value="'+percentageR1+'" max="100"></progress></div>' +
                    '<div class="cg_five_star_details_row_percentage">'+percentageR1+'%</div>' +
                '</div>' +
                '<div class="cg_five_star_details_arrow_up">' +
                '</div>' +
            '</div>'
            );

    }

    if(!imageObject){ // then must be not loaded on same gallery with same id like user gallery for example. It has to be found in dom then.
        imageObject = cgJsData[gid].vars.mainCGallery.find('#cg_show'+realId);
        if(imageObject.length==0){// then simply not existing in dome, nothing has to be done
            return;
        }
    }

     if(firstLoad == true){

        var ratingDiv = '<div class="cg_gallery_rating_div" id="cg_gallery_rating_div' + realId + '">' +
            '<div class="cg_gallery_rating_div_child cg_gallery_rating_div_child_five_star '+position+'" id="cg_gallery_rating_div_child' + realId + '" data-cg-gid="'+gid+'" data-cg-real-id="'+realId+'">' +
            '</div>'+
            '</div>';
        imageObject.find('.cg_gallery_info').append(ratingDiv);
        imageObject.find('.cg_gallery_rating_div_child').removeClass('cg-lds-dual-ring-star-loading').append(ratingDivChild).find('.cg_gallery_rating_div_count').prepend($ratingDivChildShowOnHover);
    }
    else{

        imageObject.find('.cg_gallery_rating_div_child').empty().removeClass('cg-lds-dual-ring-star-loading').append(ratingDivChild).find('.cg_gallery_rating_div_count').prepend($ratingDivChildShowOnHover);
        if(!isFromSingleView && cgJsData[gid].options.pro.IsModernFiveStar==1 && cgJsClass.gallery.vars.isMobile && !firstLoad){
            imageObject.find('.cg_gallery_rating_div_five_star_details').removeClass('cg_hide').attr('id','cg_gallery_rating_div_five_star_details_is_opened');
            jQuery('body').addClass('cg_gallery_rating_div_five_star_details_is_opened');
            cgJsClass.gallery.vars['cg_gallery_rating_div_child'] = imageObject.find('.cg_gallery_rating_div_five_star_details');
        }else if(!isFromSingleView && cgJsData[gid].options.pro.IsModernFiveStar==1 && !cgJsClass.gallery.vars.isMobile && !firstLoad){
            if(countR!=''){
                imageObject.find('.cg_gallery_rating_div_five_star_details').removeClass('cg_hide');
                setTimeout(function () {
                    imageObject.find('.cg_gallery_rating_div_five_star_details').addClass('cg_fade_out');
                },10);
            }
        }

        var cgCenterDiv = cgJsData[gid].vars.cgCenterDiv;
        if(cgCenterDiv.is(':visible')){// then changed in center div! single view

            if(cgJsData[gid].vars.openedRealId==realId){
                cgCenterDiv.find('#cgCenterImageRatingDiv'+gid).empty();
                imageObject.find('.cg_gallery_rating_div').clone().appendTo(cgCenterDiv.find('#cgCenterImageRatingDiv'+gid));
                cgCenterDiv.find('.cg_rate_star').removeClass('cg_rate_out_gallery_disallowed cg-lds-dual-ring-star-loading');
                if(isFromSingleView && cgJsData[gid].options.pro.IsModernFiveStar==1 && cgJsClass.gallery.vars.isMobile && !firstLoad){
                    cgCenterDiv.find('.cg_gallery_rating_div_five_star_details').removeClass('cg_hide').attr('id','cg_gallery_rating_div_five_star_details_is_opened');
                    jQuery('body').addClass('cg_gallery_rating_div_five_star_details_is_opened');
                    cgJsClass.gallery.vars['cg_gallery_rating_div_child'] = cgCenterDiv.find('.cg_gallery_rating_div_five_star_details');
                }else if(isFromSingleView && cgJsData[gid].options.pro.IsModernFiveStar==1 && !cgJsClass.gallery.vars.isMobile && !firstLoad){

                    if(countR!=''){

                        var $cg_gallery_rating_div_five_star_details =  cgCenterDiv.find('.cg_gallery_rating_div_five_star_details');

                        if(cgJsData[gid].vars.mainCGallery.hasClass('cg_slider') && (cgJsClass.gallery.vars.fullwindow || cgJsClass.gallery.vars.fullscreen)){
                            $cg_gallery_rating_div_five_star_details.addClass('cg_hidden').removeClass('cg_hide');// this way real outerHeight can be get
                            var topToSet = $cg_gallery_rating_div_five_star_details.outerHeight()+4;
                            $cg_gallery_rating_div_five_star_details.css('top','-'+topToSet+'px');
                        }else{
                            $cg_gallery_rating_div_five_star_details.removeAttr('style');
                        }

                        $cg_gallery_rating_div_five_star_details.removeClass('cg_hidden cg_hide');
                        setTimeout(function () {
                            cgCenterDiv.find('.cg_gallery_rating_div_five_star_details').addClass('cg_fade_out');
                        },10);

                    }

                }

            }

        }
    }


};
cgJsClass.gallery.rating.setRatingFiveStarSameGalleryId = function (realId, addVoteR,ratingAdd,firstLoad,gid,allVotesUsed,VotesInTimeExceeded,ratingFileData,isFromSingleView,isSetUserVoteToNull) {

// check if further galleries exists which have to be update user or normal, both ways
    if(String(gid).indexOf('-u')>=0){// then must be user gallery, check for normal gallery then
        return; // it can't be voted in user gallery
    }
    if(String(gid).indexOf('-u')==-1){// then must be normal gallery, check for user gallery then
        var gidToCheck = gid+'-u';
        // then gallery must be existing
        if(cgJsData[gidToCheck]){
            cgJsClass.gallery.views.close(gidToCheck);
            cgJsClass.gallery.rating.setRatingFiveStar(realId, addVoteR,ratingAdd,firstLoad,gidToCheck,allVotesUsed,VotesInTimeExceeded,ratingFileData,isFromSingleView,isSetUserVoteToNull,true);
        }
    }

};
cgJsClass.gallery.rating.setRatingFiveStar = function (realId, addVoteR,ratingAdd,firstLoad,gid,allVotesUsed,VotesInTimeExceeded,ratingFileData,isFromSingleView,isSetUserVoteToNull,isSetFromSameGalleryId) {


    if(cgJsData[gid].vars.isOnlyGalleryNoVoting){
        return;
    }


    if(isFromSingleView=='false'){
        isFromSingleView = false;
    }

    if(isSetUserVoteToNull){
        cgJsData[gid].cgJsCountRuser[realId] = 0;
    }

    var onlyLoggedInUserImages = false;
    if(typeof cgJsData[gid].onlyLoggedInUserImages != 'undefined'){
        onlyLoggedInUserImages = true;
    }

    var imageObject = cgJsData[gid].imageObject[realId];
    var CheckLogin = cgJsData[gid].options.general.CheckLogin; // allow only registred uses to vote
    var ShowOnlyUsersVotes = cgJsData[gid].options.general.ShowOnlyUsersVotes;
    var HideUntilVote = cgJsData[gid].options.general.HideUntilVote;
    var Manipulate = cgJsData[gid].options.pro.Manipulate;
    var MinusVote = cgJsData[gid].options.pro.MinusVote;
    var data;

    if(!ratingFileData){
        data = cgJsData[gid].rating[realId];
    }else{
        data = ratingFileData;
    }

    if(Manipulate==0){
        data.addCountR1 = 0;
        data.addCountR2 = 0;
        data.addCountR3 = 0;
        data.addCountR4 = 0;
        data.addCountR5 = 0;
    }

    if(ShowOnlyUsersVotes==1 && addVoteR!==0 && ratingAdd!==0){// then take the votes if votes were added, old logic

        if (typeof cgJsData[gid].cgJsCountRuser[realId] == 'undefined') {
            cgJsData[gid].cgJsCountRuser[realId] = 0;
            cgJsData[gid].cgJsRatingUser[realId] = 0;
        }

        cgJsData[gid].cgJsCountRuser[realId] = parseInt(cgJsData[gid].cgJsCountRuser[realId]) + addVoteR;
        cgJsData[gid].cgJsRatingUser[realId] = parseInt(cgJsData[gid].cgJsRatingUser[realId]) + ratingAdd;
        data.CountR = cgJsData[gid].cgJsCountRuser[realId];
        data.Rating = cgJsData[gid].cgJsRatingUser[realId];

        if(ratingAdd==-1){cgJsData[gid].cgJsCountR1user[realId] = cgJsData[gid].cgJsCountR1user[realId] - 1;}
        if(ratingAdd==-2){cgJsData[gid].cgJsCountR2user[realId] = cgJsData[gid].cgJsCountR2user[realId] - 1;}
        if(ratingAdd==-3){cgJsData[gid].cgJsCountR3user[realId] = cgJsData[gid].cgJsCountR3user[realId] - 1;}
        if(ratingAdd==-4){cgJsData[gid].cgJsCountR4user[realId] = cgJsData[gid].cgJsCountR4user[realId] - 1;}
        if(ratingAdd==-5){cgJsData[gid].cgJsCountR5user[realId] = cgJsData[gid].cgJsCountR5user[realId] - 1;}

        if(ratingAdd==1){cgJsData[gid].cgJsCountR1user[realId] = cgJsData[gid].cgJsCountR1user[realId] + 1;}
        if(ratingAdd==2){cgJsData[gid].cgJsCountR2user[realId] = cgJsData[gid].cgJsCountR2user[realId] + 1;}
        if(ratingAdd==3){cgJsData[gid].cgJsCountR3user[realId] = cgJsData[gid].cgJsCountR3user[realId] + 1;}
        if(ratingAdd==4){cgJsData[gid].cgJsCountR4user[realId] = cgJsData[gid].cgJsCountR4user[realId] + 1;}
        if(ratingAdd==5){cgJsData[gid].cgJsCountR5user[realId] = cgJsData[gid].cgJsCountR5user[realId] + 1;}
    }else if(HideUntilVote==1 && ShowOnlyUsersVotes==0 && addVoteR!==0 && ratingAdd!==0){

        if (typeof cgJsData[gid].cgJsCountRuser[realId] == 'undefined') {
            cgJsData[gid].cgJsCountRuser[realId] = 0;
            cgJsData[gid].cgJsRatingUser[realId] = 0;
        }

        cgJsData[gid].cgJsCountRuser[realId] = parseInt(cgJsData[gid].cgJsCountRuser[realId]) + addVoteR;
        cgJsData[gid].cgJsRatingUser[realId] = parseInt(cgJsData[gid].cgJsRatingUser[realId]) + ratingAdd;
        data.CountR = data.CountR+addVoteR;
        data.Rating = data.Rating+ratingAdd;

    }else if(MinusVote==1 && (ShowOnlyUsersVotes==0 && HideUntilVote==0) && addVoteR!==0 && ratingAdd!==0){

        if (typeof cgJsData[gid].cgJsCountRuser[realId] == 'undefined') {
            cgJsData[gid].cgJsCountRuser[realId] = 0;
            cgJsData[gid].cgJsRatingUser[realId] = 0;
        }

        cgJsData[gid].cgJsCountRuser[realId] = parseInt(cgJsData[gid].cgJsCountRuser[realId]) + addVoteR;
        cgJsData[gid].cgJsRatingUser[realId] = parseInt(cgJsData[gid].cgJsRatingUser[realId]) + ratingAdd;

    }

    // !IMPORTANT TO DO IT HERE
    if(ShowOnlyUsersVotes==1){

        if (typeof cgJsData[gid].cgJsCountRuser[realId] == 'undefined') {
            cgJsData[gid].cgJsCountRuser[realId] = 0;
            cgJsData[gid].cgJsRatingUser[realId] = 0;
        }


        data.CountR = cgJsData[gid].cgJsCountRuser[realId];
        data.Rating = cgJsData[gid].cgJsRatingUser[realId];

        data.addCountR1 = 0;
        data.addCountR2 = 0;
        data.addCountR3 = 0;
        data.addCountR4 = 0;
        data.addCountR5 = 0;

        data.CountR1 = cgJsData[gid].cgJsCountR1user[realId];
        data.CountR2 = cgJsData[gid].cgJsCountR2user[realId];
        data.CountR3 = cgJsData[gid].cgJsCountR3user[realId];
        data.CountR4 = cgJsData[gid].cgJsCountR4user[realId];
        data.CountR5 = cgJsData[gid].cgJsCountR5user[realId];

    }else{

        data.CountR1 = (isNaN(data.CountR1)) ? 0 : data.CountR1;
        data.CountR2 = (isNaN(data.CountR2)) ? 0 : data.CountR2;
        data.CountR3 = (isNaN(data.CountR3)) ? 0 : data.CountR3;
        data.CountR4 = (isNaN(data.CountR4)) ? 0 : data.CountR4;
        data.CountR5 = (isNaN(data.CountR5)) ? 0 : data.CountR5;

    }


    data.addCountR1 = (isNaN(data.addCountR1)) ? 0 : data.addCountR1;
    data.addCountR2 = (isNaN(data.addCountR2)) ? 0 : data.addCountR2;
    data.addCountR3 = (isNaN(data.addCountR3)) ? 0 : data.addCountR3;
    data.addCountR4 = (isNaN(data.addCountR4)) ? 0 : data.addCountR4;
    data.addCountR5 = (isNaN(data.addCountR5)) ? 0 : data.addCountR5;


    // ORDER IMPORTANT HERE!!!!!
    data.CountRtotal  = cgJsClass.gallery.rating.getCountRtotal(gid,data);
    data.RatingTotal  = cgJsClass.gallery.rating.getRatingTotal(gid,data);
    data.RatingAverage = cgJsClass.gallery.rating.getAverage(gid,data);
    data.RatingAverageForSecondarySorting = cgJsClass.gallery.rating.getAverageForSecondarySorting(gid,data);
    var average = data.RatingAverage;

    if(addVoteR){

        // !!!IMPORTANT SORTING WILL WORK AFTER VOTING WITH THIS
        for(var key in cgJsData[gid].fullImageDataFiltered){

            if(!cgJsData[gid].fullImageDataFiltered.hasOwnProperty(key)){
                break;
            }

            var firstKey = Object.keys(cgJsData[gid].fullImageDataFiltered[key])[0];

            if(cgJsData[gid].fullImageDataFiltered[key][firstKey]['id']==realId){

                cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountR'] = data.CountR;
                cgJsData[gid].fullImageDataFiltered[key][firstKey]['Rating'] = data.Rating;
                // !IMPORTANT, SET THIS HERE!!!!
                cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountRtotal'] = data.CountRtotal;
                cgJsData[gid].fullImageDataFiltered[key][firstKey]['RatingAverage'] = data.RatingAverage;
                cgJsData[gid].fullImageDataFiltered[key][firstKey]['RatingTotal'] = data.RatingTotal;
                cgJsData[gid].fullImageDataFiltered[key][firstKey]['RatingAverageForSecondarySorting'] = data.RatingAverageForSecondarySorting;

                if(!ratingFileData){
                    cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountR1'] = data.CountR1;
                    cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountR2'] = data.CountR2;
                    cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountR3'] = data.CountR3;
                    cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountR4'] = data.CountR4;
                    cgJsData[gid].fullImageDataFiltered[key][firstKey]['CountR5'] = data.CountR5;
                }

                break;
            }

        }


        var tstamp = parseInt(new Date().getTime())/1000;
        cgJsData[gid].rating[realId] = data;
        cgJsClass.gallery.indexeddb.saveJsonSortValues(gid,cgJsData[gid].rating,tstamp);
    }

    if(HideUntilVote == 1 && allVotesUsed==true && !onlyLoggedInUserImages){
        var stars = cgJsClass.gallery.rating.setStars(average,gid);
        if(average>0){
            var countRtoSet = data.CountR;
        }else{
            var countRtoSet = '';
        }
        jQuery(cgJsClass.gallery.rating.generateRatingDiv(realId,countRtoSet,imageObject,false,gid,stars,average,isFromSingleView));


        if(VotesInTimeExceeded===true){
            cgJsClass.gallery.function.message.show(cgJsData[gid].options.pro.VotesInTimeIntervalAlertMessage);
        }

        return;
    }

    if (HideUntilVote == 1 && !onlyLoggedInUserImages){

        if (cgJsData[gid].cgJsCountRuser[realId] == 0 || typeof cgJsData[gid].cgJsCountRuser[realId] == 'undefined') {// passiert wenn ShowOnlyUserVotes an ist
            var stars = cgJsClass.gallery.rating.setStars(0,gid);
            jQuery(cgJsClass.gallery.rating.generateRatingDiv(realId,'',imageObject,firstLoad,gid,stars,average,isFromSingleView));
        }else{
            var stars = cgJsClass.gallery.rating.setStars(average,gid);
            jQuery(cgJsClass.gallery.rating.generateRatingDiv(realId,data.CountRtotal,imageObject,firstLoad,gid,stars,average,isFromSingleView));
        }

    }else{
        if (data.CountRtotal < 1){
            var stars = cgJsClass.gallery.rating.setStars(0,gid);
            jQuery(cgJsClass.gallery.rating.generateRatingDiv(realId,0,imageObject,firstLoad,gid,stars,average,isFromSingleView));
        }
        else{
            var stars = cgJsClass.gallery.rating.setStars(average,gid);
            cgJsClass.gallery.rating.generateRatingDiv(realId,data.CountRtotal,imageObject,firstLoad,gid,stars,average,isFromSingleView);
        }
    }

    if(VotesInTimeExceeded===true){
        cgJsClass.gallery.function.message.show(cgJsData[gid].options.pro.VotesInTimeIntervalAlertMessage);
    }

    // Order important! Has to be done at the bottom!
    if(!isSetFromSameGalleryId && addVoteR){// then it is already done
        cgJsClass.gallery.rating.setRatingFiveStarSameGalleryId(realId, addVoteR,ratingAdd,firstLoad,gid,allVotesUsed,VotesInTimeExceeded,ratingFileData,isFromSingleView,isSetUserVoteToNull);
    }

};

cgJsClass.gallery.rating.getRatingTotal = function (gid,data) {

    var countR1total = parseInt(data['addCountR1'])*1;
    var countR2total = parseInt(data['addCountR2'])*2;
    var countR3total = parseInt(data['addCountR3'])*3;
    var countR4total = parseInt(data['addCountR4'])*4;
    var countR5total = parseInt(data['addCountR5'])*5;
    var ratingTotal = data['Rating'] + countR1total+countR2total+countR3total+countR4total+countR5total;

    return ratingTotal;
};
cgJsClass.gallery.rating.getAverage = function (gid,data) {

    var average = (data.RatingTotal)/data.CountRtotal;
    if(isNaN(average)){
        average = 0;
    }else{
        average = Math.round(average * 10)/10;
    }
    return average;

};
cgJsClass.gallery.rating.getCountRtotal = function (gid,data) {

    var addCountRtotal = parseInt(data['addCountR1'])+parseInt(data['addCountR2'])+parseInt(data['addCountR3'])+parseInt(data['addCountR4'])+parseInt(data['addCountR5']);
    var countRtotal = parseInt(data['CountR']) + addCountRtotal;

    return countRtotal;
};
cgJsClass.gallery.rating.getAverageForSecondarySorting = function (gid,data) {

    var averageForSecondarySorting = data['RatingAverage'].toString().replace('.','')+'0'+data['CountRtotal'].toString()+'0000000000000';
    averageForSecondarySorting = averageForSecondarySorting.substr(0, 13);
    averageForSecondarySorting = parseInt(averageForSecondarySorting);

    return averageForSecondarySorting;

};