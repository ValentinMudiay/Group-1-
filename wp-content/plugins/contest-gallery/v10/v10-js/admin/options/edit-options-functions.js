cgJsClassAdmin.options = cgJsClassAdmin.options || {};
cgJsClassAdmin.options.vars = cgJsClassAdmin.options.vars || {};
cgJsClassAdmin.options.functions = cgJsClassAdmin.options.functions || {};

cgJsClassAdmin.options.vars = {
    $cgGoTopOptions: null,
    $cg_main_options_tab: null,
    $cg_main_options_content: null,
    $cg_view_select_objects: null,
    $wpadminbar: null,
    windowHeight: null,
    lastScrollTop: null,
    clickTime: null
};

cgJsClassAdmin.options.functions = {
    setVars: function($,$formLinkObject,$response){

        cgJsClassAdmin.options.vars.$cgGoTopOptions = $('#cgGoTopOptions');
        cgJsClassAdmin.options.vars.$cg_main_options_tab = $('#cg_main_options_tab');
        cgJsClassAdmin.options.vars.$cg_main_options_content = $('#cg_main_options_content');
        cgJsClassAdmin.options.vars.$cg_view_select_objects = cgJsClassAdmin.options.vars.$cg_main_options_tab.find('.cg_view_select');
        cgJsClassAdmin.options.vars.$wpadminbar = $('#wpadminbar');
        cgJsClassAdmin.options.vars.windowHeight = $(window).height();
        cgJsClassAdmin.options.vars.lastScrollTop = 0;
        cgJsClassAdmin.options.vars.clickTime = 0;

    },
    loadOptionsArea: function ($,$formLinkObject,$response) {

        setTimeout(function () {
            $('#ui-datepicker-div').hide();// needs to be done for some WordPress instances, dont know why
        },50);

        this.setVars($);

        cgJsClassAdmin.index.functions.setEditors($,$response.find('#cg_main_options_content .cg-wp-editor-template'));

        // show hash
        setTimeout(function () {// timeout because of 500 options load
            if(location.hash=='#cgTranslationOtherHashLink'){
                location.href = '#cgTranslationOtherHashLink';
                $('#cgTranslationOther').addClass('cg_mark_green');
            }
        },600);

        // Only numbers allowed --- END

        // $('#cgScrollSpyContainer').scrollspy({ target: '#navbar-example2' }); <<< without bootstrap.js integrated it breaks the functionallaty!

      //  setTimeout(function () {
            $("#cgOptionsLoader").addClass('cg_hide');
            //$("#cg_main_options").addClass('cg_fade_in_0_2');
            $("#cg_main_options").removeClass('cg_hidden');
            $("#cg_save_all_options").removeClass('cg_hidden');
       // },500);

        if($formLinkObject.attr('data-cg-go-to')){

            var $elementToGo = $('#'+$formLinkObject.attr('data-cg-go-to'));

            setTimeout(function () {
                $("html, body").animate({
                    scrollTop: $elementToGo.offset().top
                }, 0);
                $('#cgTranslationOther').addClass('cg_mark_green');
            },100);

        }



  //      $("#cg_changes_saved").fadeOut(4000);

        $(function() {
            $( "#cg_datepicker_start" ).datepicker();
        });

        $( "#cg_datepicker_start" ).datepicker("option", "dateFormat", "yy-mm-dd");

        $('#cg_datepicker_start').datepicker('setDate', $( "#cg_datepicker_start_value_to_set" ).attr("value"));// have to be done additionally


/*        var cgDateFormat =  $(this).closest('.cg_image_title_container').find('.cg_date_format').val().toLowerCase().replace('yyyy','yy');
        var value = $( this ).val();
        // have to be done in extra row here
        $( this ).datepicker("option", "dateFormat", cgDateFormat);
        $( this ).val(value);// value has to be set again after format is set!*/
/*
        $( "#cg_datepicker_start" ).attr('value',$( "#cg_datepicker_start" ).attr("value"));
        */

/*setTimeout(function () {
    $( "#cg_datepicker_start" ).datepicker("option", "dateFormat", "yy-mm-dd");
    $( "#cg_datepicker_start" ).val($( "#cg_datepicker_start" ).attr("value"));
    alert($( "#cg_datepicker_start" ).attr("value"));

},2000);*/

        $(function() {
            $( "#cg_datepicker" ).datepicker();
        });
        $( "#cg_datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");

        $('#cg_datepicker').datepicker('setDate', $( "#cg_datepicker_value_to_set" ).attr("value"));// have to be done additionally


        cgJsClassAdmin.options.functions.cg_VotesInTime($);

        cgJsClassAdmin.options.functions.cg_ContestStart($);

        cgJsClassAdmin.options.functions.cg_ContestEnd($);

        cgJsClassAdmin.options.functions.cg_ContestEndInstant($);

        cgJsClassAdmin.options.functions.cg_AllowRating($);

        cgJsClassAdmin.options.functions.cg_FbLike($);

        cgJsClassAdmin.options.functions.cg_AllowComments($);

        cgJsClassAdmin.options.functions.cgCheckPreselect($);

        cgJsClassAdmin.options.functions.cg_AllowGalleryScript(false,$);

        cgJsClassAdmin.options.functions.cg_SliderFullWindow(false,$);

        cgJsClassAdmin.options.functions.cg_FullSizeImageOutGallery(false,$);

        cgJsClassAdmin.options.functions.cg_OnlyGalleryView(false,$);

        // Check gallery

        if($("#ScaleSizesGalery").is( ":checked" )){

//$( "#ScaleWidthGalery" ).attr("disabled",true);

            if($("#SinglePicView").is( ":checked" )){$("#ScaleWidthGalery").prop("disabled",false);}
            else{}

        }
        else{
            $( "#ScaleSizesGalery1" ).attr("disabled",true);
            $( "#ScaleSizesGalery2" ).attr("disabled",true);
            $( "#ScaleSizesGalery1" ).css({ 'background': '#e0e0e0' });
            $( "#ScaleSizesGalery2" ).css({ 'background': '#e0e0e0' });

        }

        if($("#ScaleWidthGalery").is( ":checked" )){
//$( "#ScaleSizesGalery" ).attr("disabled",true);
            $( "#ScaleSizesGalery2" ).attr("disabled",true);
            $( "#ScaleSizesGalery2" ).css({ 'background': '#e0e0e0' });

        }

        if($("#ScaleWidthGalery").is( ":checked" )){

            if($("#SinglePicView").is( ":checked" )){
                $( "#ScaleSizesGalery1" ).attr("disabled",false);
                $( "#ScaleSizesGalery1" ).css({ 'background': '#ffffff' });
            }

            else{}

        }


        // Check gallery END


        cgJsClassAdmin.options.functions.cg_ActivatePostMaxMB($);

        cgJsClassAdmin.options.functions.cg_ActivateBulkUpload($);

        cgJsClassAdmin.options.functions.cg_allowRESjpg($);

        cgJsClassAdmin.options.functions.cg_allowRESpng($);

        cgJsClassAdmin.options.functions.cg_allowRESgif($);

        cgJsClassAdmin.options.functions.cg_HeightLook(false,$);

        cgJsClassAdmin.options.functions.cg_ThumbLook(false,$);

        cgJsClassAdmin.options.functions.cg_RowLook(false,$);

        cgJsClassAdmin.options.functions.checkInGalleryUpload($);

        cgJsClassAdmin.options.functions.cg_confirm_after_upload($);

        cgJsClassAdmin.options.functions.cg_forward_after_upload($);

        cgJsClassAdmin.options.functions.cg_inform_admin_after_upload($);

        cgJsClassAdmin.options.functions.cg_after_login($);

        cgJsClassAdmin.options.functions.cg_after_confirm_text($);


        cgJsClassAdmin.options.functions.cg_mail_confirm_email($);


        cgJsClassAdmin.options.functions.cg_image_activation_email($);

        cgJsClassAdmin.options.functions.cgRegUserTextShowCheck($);

        cgJsClassAdmin.options.functions.cgUploadRequiresCookieMessageCheck($);

        cgJsClassAdmin.options.functions.cgRegUserGalleryOnly($);

        cgJsClassAdmin.options.functions.cg_pro_version_wp_editor_check($);

        cgJsClassAdmin.options.functions.cg_user_reocgnising_method($);

        cgJsClassAdmin.options.functions.cg_set_wpnonce($);

        cgJsClassAdmin.options.functions.cg_HideRegFormAfterLogin($);

        cgJsClassAdmin.options.functions.cg_HideRegFormAfterLoginShowTextInstead($);

        // replace reset votes

        var reloadUrl = window.location.href;

        if (reloadUrl.indexOf("reset_votes") >= 0){
            reloadUrl = reloadUrl.replace(/reset_votes/gi,'reset_votes_done');
        }

        if (reloadUrl.indexOf("reset_users_votes") >= 0){
            reloadUrl = reloadUrl.replace(/reset_users_votes/gi,'reset_users_votes_done');
        }

        if (reloadUrl.indexOf("reset_votes2") >= 0){
            reloadUrl = reloadUrl.replace(/reset_votes2/gi,'reset_votes2_done');
        }

        if (reloadUrl.indexOf("reset_users_votes2") >= 0){
            reloadUrl = reloadUrl.replace(/reset_users_votes2/gi,'reset_users_votes2_done');
        }

        if (reloadUrl.indexOf("reset_admin_votes") >= 0){
            reloadUrl = reloadUrl.replace(/reset_admin_votes/gi,'reset_admin_votes_done');
        }

        if (reloadUrl.indexOf("reset_admin_votes2") >= 0){
            reloadUrl = reloadUrl.replace(/reset_admin_votes2/gi,'reset_admin_votes2_done');
        }

        history.replaceState(null,null,reloadUrl);

        // replace reset votes --- ENDE

        setTimeout(function () {
            // change iframe body css
            $('.cg-small-textarea-container iframe').contents().find('body').css({
                'margin':'10px',
                'width':'auto'
            });
        },1000);

        cgJsClassAdmin.options.functions.cgAllowSortCheck($);


    },
    cg_VotesInTime: function ($) {

        if($("#VotesInTime").is( ":checked" )){
            $("#VotesInTimeQuantity").removeClass("cg_disabled");
            $("#cg_date_hours_vote_interval").removeClass("cg_disabled");
            $("#cg_date_mins_vote_interval").removeClass("cg_disabled");
            $("#VotesInTimeIntervalAlertMessage").removeClass("cg_disabled");
        }
        else{
            $("#VotesInTimeQuantity").addClass("cg_disabled");
            $("#cg_date_hours_vote_interval").addClass("cg_disabled");
            $("#cg_date_mins_vote_interval").addClass("cg_disabled");
            $("#VotesInTimeIntervalAlertMessage").addClass("cg_disabled");
        }

    },
    cg_ContestStart: function ($) {

        if($("#ContestStart").is( ":checked" )){

            $("#cg_datepicker_start").removeClass("cg_disabled");
            $("#cg_date_hours_contest_start").removeClass("cg_disabled");
            $("#cg_date_mins_contest_start").removeClass("cg_disabled");

        }
        else{

            $("#cg_datepicker_start").addClass("cg_disabled");
            $("#cg_date_hours_contest_start").addClass("cg_disabled");
            $("#cg_date_mins_contest_start").addClass("cg_disabled");

        }

    },
    cg_ContestEnd: function ($) {

        if($("#ContestEnd").is( ":checked" )){

            $("#cg_datepicker").removeClass("cg_disabled");
            $("#cg_date_hours_contest_end").removeClass("cg_disabled");
            $("#cg_date_mins_contest_end").removeClass("cg_disabled");
            $("#ContestEndInstant").prop("checked",false);

        }
        else{

            $("#cg_datepicker").addClass("cg_disabled");
            $("#cg_date_hours_contest_end").addClass("cg_disabled");
            $("#cg_date_mins_contest_end").addClass("cg_disabled");

        }

    },
    cg_ContestEndInstant: function ($) {

        if($("#ContestEndInstant").is( ":checked" )){

            $("#ContestEnd").prop("checked",false);
            $("#cg_datepicker").addClass("cg_disabled");
            $("#cg_date_hours_contest_end").addClass("cg_disabled");
            $("#cg_date_mins_contest_end").addClass("cg_disabled");
        }
        else{

        }

    },
    cg_AllowRating: function($){

        if($("#AllowRating").is( ":checked" ) || $("#AllowRating2").is( ":checked" )){

            $("#RatingOutGallery").removeClass("cg_disabled");
            $(".RatingPositionGallery").removeClass("cg_disabled");
            $("#HideUntilVote").removeClass("cg_disabled");
            $("#VotesPerUser").removeClass("cg_disabled");
            $("#VoteNotOwnImage").removeClass("cg_disabled");
            $("#ShowOnlyUsersVotes").removeClass("cg_disabled");
            $("#IpBlock").removeClass("cg_disabled");

        }
        else{

            $("#RatingOutGallery").addClass("cg_disabled");
            $(".RatingPositionGallery").addClass("cg_disabled");
            $("#HideUntilVote").addClass("cg_disabled");
            $("#VotesPerUser").addClass("cg_disabled");
            $("#VoteNotOwnImage").addClass("cg_disabled");
            $("#ShowOnlyUsersVotes").addClass("cg_disabled");
            $("#IpBlock").addClass("cg_disabled");

        }


    },
    cg_FbLike: function ($) {

        if($("#FbLike").is( ":checked" )){

            $("#FbLikeGallery").removeClass("cg_disabled");
            $("#FbLikeGalleryVote").removeClass("cg_disabled");
            $("#FbLikeGoToGalleryLink").removeClass("cg_disabled");
            $("#FbLikeNoShare").removeClass("cg_disabled");

        }
        else{

            $("#FbLikeGallery").addClass("cg_disabled");
            $("#FbLikeGalleryVote").addClass("cg_disabled");
            $("#FbLikeGoToGalleryLink").addClass("cg_disabled");
            $("#FbLikeNoShare").addClass("cg_disabled");

        }

    },
    cg_AllowComments: function ($) {

        if($("#AllowComments").is( ":checked" )){

            $(".CommentPositionGallery").removeClass("cg_disabled");

        }
        else{

            $(".CommentPositionGallery").addClass("cg_disabled");

        }

    },
    cgCheckPreselect: function ($) {


        if($("#RandomSort").is( ":checked" )){
            $("#PreselectSort").addClass("cg_disabled");
            $("#cgPreselectSortMessage").removeClass("cg_hide");
        }
        else{
            $("#PreselectSort").removeClass("cg_disabled");
            $("#cgPreselectSortMessage").addClass("cg_hide");
        }

    },
    cg_AllowGalleryScript: function (click,$) {

        if($("#AllowGalleryScript").is( ":checked" ) || $("#SliderFullWindow").is( ":checked" ) ){
            // $("#FullSizeSlideOutStart").removeClass('cg_disabled');
            //   cg_FullSizeGallery();// Beeinflusst FullSizeSlideOutStart

            $("#OriginalSourceLinkInSlider").removeClass('cg_disabled');
            $("#ShowNickname").removeClass('cg_disabled');
            $("#SlideVertical").removeClass('cg_disabled');
            $("#ShowExif").removeClass('cg_disabled');
            $("#SlideHorizontal").removeClass('cg_disabled');
            $("#FullSizeSlideOutStart").removeClass('cg_disabled');
            $("#FullSizeImageOutGallery").prop('checked',false);
            $("#OnlyGalleryView").prop('checked',false);
            if(click && !$("#SliderFullWindow").is( ":checked" )){
                $("#SliderFullWindow").prop('checked',false);
            }
            if($("#AllowGalleryScript").is( ":checked" )){
                $("#SliderFullWindow").prop('checked',false);
            }
            if($("#SliderFullWindow").is( ":checked" ) ){
                $("#FullSizeSlideOutStart").addClass('cg_disabled');
            }

        }else if(!$("#AllowGalleryScript").is( ":checked" ) && click){

            if(click){
                $("#AllowGalleryScript").prop('checked',true);
            }
        }
        else{

            $("#FullSizeSlideOutStart").addClass('cg_disabled');
            $("#OriginalSourceLinkInSlider").addClass('cg_disabled');
            $("#ShowNickname").addClass('cg_disabled');
            $("#ShowExif").addClass('cg_disabled');
            $("#SlideVertical").addClass('cg_disabled');
            $("#SlideHorizontal").addClass('cg_disabled');

            if(click){
                $("#AllowGalleryScript").prop('checked',true);
            }

        }
    },
    cg_SliderFullWindow: function (click,$) {

        cgJsClassAdmin.options.functions.cg_AllowGalleryScript(false,$);

        if($("#SliderFullWindow").is( ":checked" )){

            $("#AllowGalleryScript").prop('checked',false);
            $("#FullSizeSlideOutStart").addClass('cg_disabled');
            /*        $("#OnlyGalleryView").prop('checked',false);
                    $("#FullSizeImageOutGallery").prop('checked',false);
                    //$("#FullSizeSlideOutStart").addClass('cg_disabled');
                 //   cg_FullSizeGallery(); // Beeinflusst FullSizeSlideOutStart

                    $("#OriginalSourceLinkInSlider").addClass('cg_disabled');
                    $("#ShowNickname").addClass('cg_disabled');
                    $("#SlideVertical").addClass('cg_disabled');
                    $("#ShowExif").addClass('cg_disabled');
                    $("#SlideHorizontal").addClass('cg_disabled');
                    $("#FullSizeSlideOutStart").addClass('cg_disabled');*/


        }else{

            if(click){
                $("#AllowGalleryScript").prop('checked',false);
                $("#SliderFullWindow").prop('checked',true);
                $("#FullSizeSlideOutStart").addClass('cg_disabled');

            }

        }

    },
    cg_FullSizeImageOutGallery: function (click,$) {

        if($("#FullSizeImageOutGallery").is( ":checked" )){
            $("#AllowGalleryScript").prop('checked',false);
            $("#OnlyGalleryView").prop('checked',false);
            $("#SliderFullWindow").prop('checked',false);
            //$("#FullSizeSlideOutStart").addClass('cg_disabled');
            //  cg_FullSizeGallery(); // Beeinflusst FullSizeSlideOutStart

            $("#OriginalSourceLinkInSlider").addClass('cg_disabled');
            $("#ShowNickname").addClass('cg_disabled');
            $("#SlideVertical").addClass('cg_disabled');
            $("#ShowExif").addClass('cg_disabled');
            $("#SlideHorizontal").addClass('cg_disabled');
            $("#FullSizeSlideOutStart").addClass('cg_disabled');


        }else{

            if(click){
                $("#FullSizeImageOutGallery").prop('checked',true);
            }

        }

    },
    cg_CheckFullSize: function ($) {

        if($("#FullSizeGallery").is( ":checked" )){
            $("#FullSize").removeClass("cg_disabled");
        }
        else{
            $("#FullSize").addClass("cg_disabled");
        }

    },
    cg_OnlyGalleryView: function (click,$) {

        if($("#OnlyGalleryView").is( ":checked" )){

            $("#AllowGalleryScript").prop('checked',false);
            $("#FullSizeImageOutGallery").prop('checked',false);
            $("#SliderFullWindow").prop('checked',false);
            //$("#FullSizeSlideOutStart").addClass('cg_disabled');
            //    cg_FullSizeGallery(); // Beeinflusst FullSizeSlideOutStart

            $("#OriginalSourceLinkInSlider").addClass('cg_disabled');
            $("#ShowNickname").addClass('cg_disabled');
            $("#ShowExif").addClass('cg_disabled');
            $("#SlideVertical").addClass('cg_disabled');
            $("#SlideHorizontal").addClass('cg_disabled');
            $("#FullSizeSlideOutStart").addClass('cg_disabled');


        }else{

            if(click){
                $("#OnlyGalleryView").prop('checked',true);
            }

        }

    },
    cg_ActivatePostMaxMB: function ($) {

        if($("#ActivatePostMaxMB").is( ":checked" )){
            $("#PostMaxMB").removeClass("cg_disabled");
        }
        else{
            $("#PostMaxMB").addClass("cg_disabled");
        }

    },
    cg_ActivateBulkUpload: function ($) {


        if($("#ActivateBulkUpload").is( ":checked" )){

            $("#BulkUploadQuantity").removeClass("cg_disabled");
            $("#BulkUploadMinQuantity").removeClass("cg_disabled");

        }
        else{

            $("#BulkUploadQuantity").addClass("cg_disabled");
            $("#BulkUploadMinQuantity").addClass("cg_disabled");

        }

    },
    cg_allowRESjpg: function ($) {

        if($("#allowRESjpg").is( ":checked" )){

            $("#MaxResJPGwidth").removeClass("cg_disabled");
            $("#MaxResJPGheight").removeClass("cg_disabled");

        }
        else{

            $("#MaxResJPGwidth").addClass("cg_disabled");
            $("#MaxResJPGheight").addClass("cg_disabled");

        }

    },
    cg_allowRESpng: function ($) {

        if($("#allowRESpng").is( ":checked" )){

            $("#MaxResPNGwidth").removeClass("cg_disabled");
            $("#MaxResPNGheight").removeClass("cg_disabled");

        }
        else{

            $("#MaxResPNGwidth").addClass("cg_disabled");
            $("#MaxResPNGheight").addClass("cg_disabled");

        }

    },
    cg_allowRESgif: function ($) {

        if($("#allowRESgif").is( ":checked" )){

            $("#MaxResGIFwidth").removeClass("cg_disabled");
            $("#MaxResGIFheight").removeClass("cg_disabled");

        }
        else{

            $("#MaxResGIFwidth").addClass("cg_disabled");
            $("#MaxResGIFheight").addClass("cg_disabled");

        }

    },
    cg_HeightLook: function (click,$) {

        if($("#HeightLook").is(':checked')){

            $("#HeightLookHeight").removeClass("cg_disabled");
            $("#HeightViewSpaceWidth").removeClass("cg_disabled");
            $("#HeightViewSpaceHeight").removeClass("cg_disabled");
            $("#HeightViewBorderWidth").removeClass("cg_disabled");
            $("#HeightViewBorderColor").removeClass("cg_disabled");

        }else if(!$("#HeightLook").is( ":checked" ) && click && (!$("#RowLook").is(':checked') && !$("#ThumbLook").is(':checked') && !$("#SliderLook").is(':checked'))){

            $("#HeightLook").prop('checked',true);

        }else{

            $("#HeightLookHeight").addClass("cg_disabled");
            $("#HeightViewSpaceWidth").addClass("cg_disabled");
            $("#HeightViewSpaceHeight").addClass("cg_disabled");
            $("#HeightViewBorderWidth").addClass("cg_disabled");
            $("#HeightViewBorderColor").addClass("cg_disabled");

        }

    },
    cg_ThumbLook: function (click,$) {
        if($("#ThumbLook").is(':checked')){

            $("#WidthThumb").removeClass("cg_disabled");
            $("#HeightThumb").removeClass("cg_disabled");
            $("#DistancePics").removeClass("cg_disabled");
            $("#DistancePicsV").removeClass("cg_disabled");
            $("#ThumbViewBorderWidth").removeClass("cg_disabled");
            $("#ThumbViewBorderColor").removeClass("cg_disabled");

        }else if(!$("#ThumbLook").is( ":checked" ) && click && (!$("#RowLook").is(':checked') && !$("#HeightLook").is(':checked') && !$("#SliderLook").is(':checked'))){

            $("#ThumbLook").prop('checked',true);

        }
        else{

            $("#WidthThumb").addClass("cg_disabled");
            $("#HeightThumb").addClass("cg_disabled");
            $("#DistancePics").addClass("cg_disabled");
            $("#DistancePicsV").addClass("cg_disabled");
            $("#ThumbViewBorderWidth").addClass("cg_disabled");
            $("#ThumbViewBorderColor").addClass("cg_disabled");

        }

    },
    cg_RowLook: function (click,$) {

        if($("#RowLook").is(':checked')){

            $("#PicsInRow").removeClass("cg_disabled");
            $("#RowViewSpaceWidth").removeClass("cg_disabled");
            $("#RowViewSpaceHeight").removeClass("cg_disabled");
            $("#RowViewBorderWidth").removeClass("cg_disabled");
            $("#RowViewBorderColor").removeClass("cg_disabled");

        }else if(!$("#RowLook").is( ":checked" ) && click && (!$("#ThumbLook").is(':checked') && !$("#HeightLook").is(':checked') && !$("#SliderLook").is(':checked'))){

            $("#RowLook").prop('checked',true);

        }
        else{

            $("#PicsInRow").addClass("cg_disabled");
            $("#RowViewSpaceWidth").addClass("cg_disabled");
            $("#RowViewSpaceHeight").addClass("cg_disabled");
            $("#RowViewBorderWidth").addClass("cg_disabled");
            $("#RowViewBorderColor").addClass("cg_disabled");

        }

    },
    cg_SliderLook: function (click,$) {

        if(!$("#SliderLook").is( ":checked" ) && click && (!$("#RowLook").is(':checked') && !$("#HeightLook").is(':checked') && !$("#SliderLook").is(':checked'))){

            $("#SliderLook").prop('checked',true);

        }

    },
    checkInGalleryUpload: function ($) {


        if($('#GalleryUpload').is(":checked")){

            $( "#GalleryUploadOnlyUser" ).removeClass("cg_disabled");
            $( "#wp-GalleryUploadTextBefore-wrap" ).removeClass("cg_disabled");
            $( "#wp-GalleryUploadTextAfter-wrap" ).removeClass("cg_disabled");
            $( "#wp-GalleryUploadConfirmationText-wrap" ).removeClass("cg_disabled");

        }
        else{

            $( "#GalleryUploadOnlyUser" ).addClass("cg_disabled");
            $( "#wp-GalleryUploadTextBefore-wrap" ).addClass("cg_disabled");
            $( "#wp-GalleryUploadTextAfter-wrap" ).addClass("cg_disabled");
            $( "#wp-GalleryUploadConfirmationText-wrap" ).addClass("cg_disabled");

        }

    },
    cg_confirm_after_upload: function ($) {

        if($('#cg_confirm_text').is(":checked")){

            $( "#forward_url" ).addClass('cg_disabled');
            $( "#wp-confirmation_text-wrap" ).removeClass('cg_disabled');
            $( "#forward" ).prop('checked',false);
            $( "#ShowFormAfterUpload" ).removeClass('cg_disabled');

        }
        else{

            $( "#forward_url" ).removeClass('cg_disabled');
            $( "#wp-confirmation_text-wrap" ).addClass('cg_disabled');
            $( "#forward" ).prop('checked',true);
            $( "#ShowFormAfterUpload" ).addClass('cg_disabled');

        }

    },
    cg_forward_after_upload: function ($) {

        if($('#forward').is(":checked")){

            $( "#forward_url" ).removeClass('cg_disabled');
            $( "#wp-confirmation_text-wrap" ).addClass('cg_disabled');
            $( "#cg_confirm_text" ).prop('checked',false);
            $( "#ShowFormAfterUpload" ).addClass('cg_disabled');

        }
        else{

            $( "#forward_url" ).addClass('cg_disabled');
            $( "#wp-confirmation_text-wrap" ).removeClass('cg_disabled');
            $( "#cg_confirm_text" ).prop('checked',true);
            $( "#ShowFormAfterUpload" ).removeClass('cg_disabled');


        }

    },
    cg_inform_admin_after_upload: function ($) {

        if($('#InformAdmin').is(":checked")){

            $( "#cgInformAdminFrom" ).removeClass('cg_disabled');
            $( "#cgInformAdminAdminMail" ).removeClass('cg_disabled');
            $( "#cgInformAdminReply" ).removeClass('cg_disabled');
            $( "#cgInformAdminCc" ).removeClass('cg_disabled');
            $( "#cgInformAdminBcc" ).removeClass('cg_disabled');
            $( "#cgInformAdminHeader" ).removeClass('cg_disabled');
            $( "#wp-InformAdminText-wrap" ).removeClass('cg_disabled');

        }
        else{

            $( "#cgInformAdminFrom" ).addClass('cg_disabled');
            $( "#cgInformAdminAdminMail" ).addClass('cg_disabled');
            $( "#cgInformAdminReply" ).addClass('cg_disabled');
            $( "#cgInformAdminCc" ).addClass('cg_disabled');
            $( "#cgInformAdminBcc" ).addClass('cg_disabled');
            $( "#cgInformAdminHeader" ).addClass('cg_disabled');
            $( "#wp-InformAdminText-wrap" ).addClass('cg_disabled');

        }

    },
    cg_after_login: function ($) {


        if($("#ForwardAfterLoginUrlCheck").is(":checked")){

            $( "#ForwardAfterLoginUrl" ).removeClass("cg_disabled");
            $( "#wp-ForwardAfterLoginText-wrap" ).addClass("cg_disabled");
            $( "#ForwardAfterLoginTextCheck" ).prop("checked",false);

        }

        else{

            $( "#ForwardAfterLoginUrl" ).addClass("cg_disabled");
            $( "#wp-ForwardAfterLoginText-wrap" ).removeClass("cg_disabled");
            $( "#ForwardAfterLoginTextCheck" ).prop("checked",true);

        }

    },
    cg_after_confirm_text: function ($) {

        if($("#ForwardAfterLoginTextCheck").is(":checked")){

            $( "#wp-ForwardAfterLoginText-wrap" ).removeClass("cg_disabled");
            $( "#ForwardAfterLoginUrl" ).addClass("cg_disabled");
            $( "#ForwardAfterLoginUrlCheck" ).prop("checked",false);

        }

        else{

            $( "#wp-ForwardAfterLoginText-wrap" ).addClass("cg_disabled");
            $( "#ForwardAfterLoginUrl" ).removeClass("cg_disabled");
            $( "#ForwardAfterLoginUrlCheck" ).prop("checked",true);

        }

    },
    cg_mail_confirm_email: function ($) {

        if($("#mConfirmSendConfirm").is(":checked")){

            $( "#mConfirmAdmin" ).removeClass("cg_disabled");
            $( "#mConfirmReply" ).removeClass("cg_disabled");
            $( "#mConfirmCC" ).removeClass("cg_disabled");
            $( "#mConfirmBCC" ).removeClass("cg_disabled");
            $( "#mConfirmHeader" ).removeClass("cg_disabled");
            $( "#mConfirmURL" ).removeClass("cg_disabled");
            $( "#wp-mConfirmContent-wrap" ).removeClass("cg_disabled");
            $( "#wp-mConfirmConfirmationText-wrap" ).removeClass("cg_disabled");


        }

        else{

            $( "#mConfirmAdmin" ).addClass("cg_disabled");
            $( "#mConfirmReply" ).addClass("cg_disabled");
            $( "#mConfirmCC" ).addClass("cg_disabled");
            $( "#mConfirmBCC" ).addClass("cg_disabled");
            $( "#mConfirmHeader" ).addClass("cg_disabled");
            $( "#mConfirmURL" ).addClass("cg_disabled");
            $( "#wp-mConfirmContent-wrap" ).addClass("cg_disabled");
            $( "#wp-mConfirmConfirmationText-wrap" ).addClass("cg_disabled");

        }

    },
    cg_image_activation_email: function ($) {

        if($("#InformUsers").is(":checked")){

            $( "#from_user_mail" ).removeClass("cg_disabled");
            $( "#reply_user_mail" ).removeClass("cg_disabled");
            $( "#cc_user_mail" ).removeClass("cg_disabled");
            $( "#bcc_user_mail" ).removeClass("cg_disabled");
            $( "#header_user_mail" ).removeClass("cg_disabled");
            $( "#url_user_mail" ).removeClass("cg_disabled");
            $( "#wp-cgEmailImageActivating-wrap" ).removeClass("cg_disabled");

        }

        else{

            $( "#from_user_mail" ).addClass("cg_disabled");
            $( "#reply_user_mail" ).addClass("cg_disabled");
            $( "#cc_user_mail" ).addClass("cg_disabled");
            $( "#bcc_user_mail" ).addClass("cg_disabled");
            $( "#header_user_mail" ).addClass("cg_disabled");
            $( "#url_user_mail" ).addClass("cg_disabled");
            $( "#wp-cgEmailImageActivating-wrap" ).addClass("cg_disabled");

        }

    },
    cgRegUserTextShowCheck: function ($) {

        if($('#CheckLoginUpload').is(":checked") ){

            $( "#wp-RegUserUploadOnlyText-wrap" ).removeClass("cg_disabled");

        }
        else{

            $( "#wp-RegUserUploadOnlyText-wrap" ).addClass("cg_disabled");

        }

    },
    cgUploadRequiresCookieMessageCheck: function ($) {

        if($('#CheckCookieUpload').is(":checked") ){

            $( "#UploadRequiresCookieMessage" ).removeClass("cg_disabled");

        }
        else{

            $( "#UploadRequiresCookieMessage" ).addClass("cg_disabled");

        }

    },
    cgRegUserGalleryOnly: function ($) {

        if($('#RegUserGalleryOnly').is(":checked")){

            $( "#wp-RegUserGalleryOnlyText-wrap" ).removeClass("cg_disabled");

        }
        else{

            $( "#wp-RegUserGalleryOnlyText-wrap" ).addClass("cg_disabled");

        }

    },
    cg_pro_version_wp_editor_check: function ($) {


        $('.cg-pro-false-container').find('.wp-switch-editor:first-child').click();
        $('.cg-pro-false-container').find('.wp-core-ui.wp-editor-wrap').addClass('cg_disabled');

    },
    cg_user_reocgnising_method: function ($) {

        if($('.CheckMethod:checked').val()=='cookie'){
            $('#CheckCookieAlertMessage').removeClass('cg_disabled');
        }else{
            $('#CheckCookieAlertMessage').addClass('cg_disabled');
        }

    },
    cg_set_wpnonce: function ($) {

        $('.cg-rating-reset').each(function () {

            $(this).attr('href',$(this).attr('href')+'&_wpnonce='+$('#_wpnonce').val());

        });

    },
    cg_HideRegFormAfterLogin: function ($) {

        if($('#HideRegFormAfterLogin').prop('checked')){
            $('#HideRegFormAfterLoginShowTextInstead').removeClass('cg_disabled');
            //   $('#wp-HideRegFormAfterLoginTextToShow-wrap').removeClass('cg_disabled');
        }else{
            $('#HideRegFormAfterLoginShowTextInstead').addClass('cg_disabled');
            $('#wp-HideRegFormAfterLoginTextToShow-wrap').addClass('cg_disabled');
        }

    },
    cg_HideRegFormAfterLoginShowTextInstead: function ($) {

        if($('#HideRegFormAfterLoginShowTextInstead').prop('checked') && $('#HideRegFormAfterLogin').prop('checked')){
            $('#wp-HideRegFormAfterLoginTextToShow-wrap').removeClass('cg_disabled');
        }else{
            $('#wp-HideRegFormAfterLoginTextToShow-wrap').addClass('cg_disabled');
        }

    },
    cgAllowSortCheck: function ($) {

        if($('#AllowSort').prop('checked')){
            $('#cgAllowSortOptionsContainer .cg-allow-sort-option').removeClass('cg_disabled');
            $('#cgAllowSortDependsOnMessage').addClass('cg_hide');
        }else{
            $('#cgAllowSortOptionsContainer .cg-allow-sort-option').addClass('cg_disabled');
            $('#cgAllowSortDependsOnMessage').addClass('cg_hide');
        }

    }
};
