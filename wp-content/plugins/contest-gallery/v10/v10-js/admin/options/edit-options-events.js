jQuery(document).ready(function($){

    // Only numbers allowed
    $(document).on('input','#PicsPerSite,#HeightLookHeight,#HeightViewSpaceWidth,#HeightViewSpaceHeight,#WidthThumb,#HeightThumb,#DistancePics,#DistancePicsV' +
        '#PicsInRow,#RowViewSpaceWidth,#RowViewSpaceHeight',function () {

        // otherwise backspace does not work
        if(this.value==''){
            return;
        }

        if(/^\d+$/.test(this.value)==false){
            this.value=0;
        }

    });

    $(document).on('click',"#SlideHorizontal",function () {
        if($(this).is( ":checked" )){
            $(this).prop( "checked", true);
            $("#SlideVertical").prop( "checked", false);
        }else{
            $(this).prop( "checked", false);
            $("#SlideVertical").prop( "checked", true);
        }
    });

    $(document).on('click',"#SlideVertical",function () {
        if($(this).is( ":checked" )){
            $(this).prop( "checked", true);
            $("#SlideHorizontal").prop( "checked", false);
        }else{
            $(this).prop( "checked", false);
            $("#SlideHorizontal").prop( "checked", true);
        }
    });

    $(document).on('click', '.cg_move_view_to_top', function(e){

        var sortableView = $(this).closest('.cg_options_sortableContainer');
        sortableView.insertBefore(sortableView.prev('.cg_options_sortableContainer'));
        // sortableView.next().find('.cg_move_view_to_top').removeClass('cg_hide');
        //   $('.cg_options_sortableContainer:first-child .cg_move_view_to_bottom, .cg_options_sortableContainer:nth-child(2) .cg_move_view_to_bottom').removeClass('cg_hide');
        //  $('.cg_options_sortableContainer:nth-child(3) .cg_move_view_to_bottom').addClass('cg_hide');

        //  $('.cg_options_sortableContainer:first-child .cg_move_view_to_top').addClass('cg_hide');
        //  $('.cg_options_sortableContainer:nth-child(2) .cg_move_view_to_top').removeClass('cg_hide');
        // $('.cg_options_sortableContainer:nth-child(3) .cg_move_view_to_top').removeClass('cg_hide');

        v = 0;

        $( ".cg_options_order" ).each(function( i ) {
            v++;
            $(this).empty();
            $(this).append('<u>'+v+'. Order</u>');
            $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
            $(this).attr('id','cg_options_order'+v+'');


        });

        var sortableViewIndex = sortableView.index()+1;
        //location.href = '#cg_options_order'+sortableViewIndex+'';
        var scrollTop = $('#cg_options_order'+sortableViewIndex+'').offset().top-55-$('#cg_main_options_tab').outerHeight();
        $(window).scrollTop(scrollTop);
        //  $(window).scrollTop(50);

    });

    $(document).on('click', '.cg_move_view_to_bottom', function(e){
        var sortableView = $(this).closest('.cg_options_sortableContainer');
        sortableView.insertAfter(sortableView.next('.cg_options_sortableContainer'));
        //    $('.cg_options_sortableContainer:first-child .cg_move_view_to_bottom, .cg_options_sortableContainer:nth-child(2) .cg_move_view_to_bottom').removeClass('cg_hide');
        //   $('.cg_options_sortableContainer:nth-child(3) .cg_move_view_to_bottom').addClass('cg_hide');

        //   $('.cg_options_sortableContainer:first-child .cg_move_view_to_top').addClass('cg_hide');
        //   $('.cg_options_sortableContainer:nth-child(2) .cg_move_view_to_top').removeClass('cg_hide');
        //  $('.cg_options_sortableContainer:nth-child(3) .cg_move_view_to_top').removeClass('cg_hide');

        v = 0;

        $( ".cg_options_order" ).each(function( i ) {
            v++;
            $(this).empty();
            $(this).append('<u>'+v+'. Order</u>');
            $(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
            $(this).attr('id','cg_options_order'+v+'');


        });

        var sortableViewIndex = sortableView.index()+1;
        //location.href = '#cg_options_order'+sortableViewIndex+'';
        var scrollTop = $('#cg_options_order'+sortableViewIndex+'').offset().top-55-$('#cg_main_options_tab').outerHeight();
        $(window).scrollTop(scrollTop);
        //  $(window).scrollTop(50);

    });

    // Visual form options here

    $(document).on('click', '#FormInputWidth', function(e){

        if($("#FormInputWidth").is( ":checked" )){
            $(".FormInputWidthExample").css("width","100%");
        }
        else{
            $(".FormInputWidthExample").css("width","auto");
        }

    });

    $(document).on('click', '#FormButtonWidth', function(e){

        if($("#FormButtonWidth").is( ":checked" )){
            $(".FormButtonWidthExample").css("width","100%");
        }
        else{
            $(".FormButtonWidthExample").css("width","auto");
        }

    });

    $(document).on('click', '#FormRoundBorder', function(e){

        if($("#FormRoundBorder").is( ":checked" )){
            $(".FormInputWidthExample").css("border-radius","5px");
            $(".FormButtonWidthExample").css("border-radius","5px");
        }
        else{
            $(".FormInputWidthExample").css("border-radius","0%");
            $(".FormButtonWidthExample").css("border-radius","0%");
        }

    });

    // Visual form options here --- END

    $(document).on('click', '#ThumbViewBorderColor', function(e){
        $(".color-picker").css("top",$("#ThumbViewBorderColor").offset().top+27);
    });
    $(document).on('click', '#HeightViewBorderColor', function(e){
        $(".color-picker").css("top",$("#HeightViewBorderColor").offset().top+27);
    });
    $(document).on('click', '#RowViewBorderColor', function(e){
        $(".color-picker").css("top",$("#RowViewBorderColor").offset().top+27);
    });
    $(document).on('click', '#GalleryBackgroundColor', function(e){
        $(".color-picker").css("top",$("#GalleryBackgroundColor").offset().top+27);
    });


    $( document ).on('change',"#ThumbViewBorderColor",function() {
        var opacityThumbView = $('#ThumbViewBorderColor').attr("data-opacity");
        $('#ThumbViewBorderColor').attr("name","ThumbViewBorderColor["+opacityThumbView+"]");
    });

    $( document ).on('change',"#HeightViewBorderColor",function() {
        var opacityHeightView = $('#HeightViewBorderColor').attr("data-opacity");
        $('#HeightViewBorderColor').attr("name","HeightViewBorderColor["+opacityHeightView+"]");
    });


    $( document ).on('change',"#RowViewBorderColor",function() {
        var opacityRowView = $('#RowViewBorderColor').attr("data-opacity");
        $('#RowViewBorderColor').attr("name","RowViewBorderColor["+opacityRowView+"]");
    });

    $( document ).on('change',"#GalleryBackgroundColor",function() {
        var opacityBackgroundColor = $('#GalleryBackgroundColor').attr("data-opacity");
        $('#GalleryBackgroundColor').attr("name","GalleryBackgroundColor["+opacityBackgroundColor+"]");
    });

    $( document ).on('hover',"#cg_questionJPG",function() {
        $('#cg_answerJPG').toggle();
        $(this).css('cursor','pointer');
    });

    $( document ).on('hover',"#cg_questionPNG",function() {
        $('#cg_answerPNG').toggle();
        $(this).css('cursor','pointer');
    });

    $( document ).on('hover',"#cg_questionGIF",function() {
        $('#cg_answerGIF').toggle();
        $(this).css('cursor','pointer');
    });

    $( document ).on('change',"#cg_datepicker_start",function() {
        $( "#cg_datepicker_start" ).datepicker("option", "dateFormat", "yy-mm-dd");
    });

    $( document ).on('keydown',"#cg_datepicker_start",function() {
        return false;
    });

    $( document ).on('change',"#cg_datepicker",function() {
        $( "#cg_datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");
    });

    $( document ).on('keydown',"#cg_datepicker",function() {
        return false;
    });

    $( document ).on( "input",".cg_date_hours,.cg_date_mins,.cg_date_seconds", function() {

        if(this.value.length>2){
            this.value = this.value.substr(0,2);
            if(this.value.indexOf(0)==0){
                this.value = this.value.substr(1,1);
            }
        }

        if($(this).hasClass('cg_date_hours')){
            if(this.value==25){
                this.value = 0;
            }
            if(this.value==-1){
                this.value = 24;
            }
        }

        if($(this).hasClass('cg_date_mins')){

            if(this.value==60){
                this.value = 0;
            }
            if(this.value==-1){
                this.value = 59;
            }
        }

        if(this.value<10){this.value = '0'+this.value;}

    });

    $( document ).on( "input", ".cg_date_hours_unlimited", function(e) {

        if(this.value==1000){
            this.value = 0;
        }
        if(this.value==-1){
            this.value = 999;
        }

        //if(this.value<10){this.value = '0'+this.value;}

        //	if(this.value<10){this.value = '0'+this.value;}

        if(this.value.length>3){
            this.value = this.value.substr(0,3);
            /*            if(this.value.indexOf(0)==0){
                            this.value = this.value.substr(1,2);
                        }*/
        }

    });

    $( ".cg_date_days" ).on( "input", function() {

        if(this.value==30){
            this.value = 0;
        }
        if(this.value==-1){
            this.value = 30;
        }
        //	if(this.value<10){this.value = '0'+this.value;}

    });

// Check votes in a time

    $(document).on('click',"#VotesInTime",function () {
        cgJsClassAdmin.options.functions.cg_VotesInTime($);
    });


// Check votes in a time --- END

// Check if start contest time is on or not


    $(document).on('click',"#ContestStart",function () {
        cgJsClassAdmin.options.functions.cg_ContestStart($);
    });


// Check if start contest time is on or not --- END

// Check if end contest time is on or not



    $(document).on('click',"#ContestEnd",function () {
        cgJsClassAdmin.options.functions.cg_ContestEnd($);
    });


// Check if end contest time is on or not --- END

// Check if end contest instant is on or not


    $(document).on('click',"#ContestEndInstant",function () {
        cgJsClassAdmin.options.functions.cg_ContestEndInstant($);
    });


// Check if end contest instant is on or not --- END

// Check if voting is activated or not


    $(document).on('click',"#AllowRating",function () {

        if($(this).is( ":checked" )){

            $("#AllowRating").prop( "checked", true);
            $("#AllowRating2").prop( "checked", false);

        }

        cgJsClassAdmin.options.functions.cg_AllowRating($);

    });


    $(document).on('click',"#AllowRating2",function () {

        if($(this).is( ":checked" )){

            $("#AllowRating2").prop( "checked", true);
            $("#AllowRating").prop( "checked", false);

        }

        cgJsClassAdmin.options.functions.cg_AllowRating($);

    });


// Check if voting is activated or not --- END


// Check if facebook like button is activated or not


    $(document).on('click',"#FbLike",function () {
        cgJsClassAdmin.options.functions.cg_FbLike($);
    });


// Check if facebook like button is activated or not --- END

// Check if commenting is activated or not

    $(document).on('click',"#AllowComments",function () {
        cgJsClassAdmin.options.functions.cg_AllowComments($);
    });

// Check if commenting is activated or not --- END


// Check preselect

    $(document).on('click',"#RandomSort",function () {
        cgJsClassAdmin.options.functions.cgCheckPreselect($);
    });

// Check preselect --- END


// Check if slider is activated or not

    $(document).on('click',"#AllowGalleryScript",function () {
        cgJsClassAdmin.options.functions.cg_AllowGalleryScript(true,$);
    });

// Check if slider is activated or not --- END


// Check if SliderFullWindow is activated or not

    $(document).on('click',"#SliderFullWindow",function () {
        cgJsClassAdmin.options.functions.cg_SliderFullWindow(true,$);
    });

// Check if SliderFullWindow is activated or not --- END



// Check if Full Size Image is activated or not

    $(document).on('click',"#FullSizeImageOutGallery",function () {
        cgJsClassAdmin.options.functions.cg_FullSizeImageOutGallery(true,$);
    });


// Check if Full Size Image is activated or not --- END

// Check if full screen can be enabled

    $(document).on('click',"#FullSizeGallery",function () {
        cgJsClassAdmin.options.functions.cg_CheckFullSize($);
    });


// Check if full screen can be enabled --- END

// Check if only gallery view is activated or not

    $(document).on('click',"#OnlyGalleryView",function () {
        cgJsClassAdmin.options.functions.cg_OnlyGalleryView(true,$);
    });


// Check if only gallery view is activated or not --- END


// Allow only to press numbers as keys in input boxes


    $(document).on('keypress',"#ScaleSizesGalery1, #ScaleSizesGalery2, #DistancePicsV, #DistancePicsV, #PicsInRow, #PicsPerSite,#ThumbViewBorderRadius,#RowViewBorderRadius,#HeightViewBorderRadius,#HeightViewSpaceHeight,#WidthThumb,"+
        "#PostMaxMB, #VotesPerUser, #RegUserMaxUpload, #VotesInTimeQuantity, #BulkUploadQuantity,#BulkUploadMinQuantity, #DistancePics, #MaxResJPGwidth, #MaxResJPGheight, #MaxResPNGwidth, #MaxResPNGheight, #MaxResGIFwidth, #MaxResGIFheight, #cg_row_look_border_width,#cg_height_look_border_width,#HeightViewBorderWidth",function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            // $("#cg_options_errmsg").html("Only numbers are allowed").show().fadeOut("slow");
            return false;
        }
    });

// Allow only to press numbers as keys in input boxes --- END

// Click input checkboxes

    // Check gallery
    $(document).on('click',"#ScaleSizesGalery",function(){

        if($("#ScaleSizesGalery").is( ":checked" )){

            $("#ScaleWidthGalery").prop("checked",false);
            $( "#ScaleSizesGalery1" ).attr("disabled",false);
            $( "#ScaleSizesGalery2" ).attr("disabled",false);
            $( "#ScaleSizesGalery1" ).css({ 'background': '#ffffff' });
            $( "#ScaleSizesGalery2" ).css({ 'background': '#ffffff' });

        }

        else{

            $("#ScaleWidthGalery").prop("disabled",false);
            $( "#ScaleSizesGalery1" ).attr("disabled",true);
            $( "#ScaleSizesGalery2" ).attr("disabled",true);
            $( "#ScaleSizesGalery1" ).css({ 'background': '#e0e0e0' });
            $( "#ScaleSizesGalery2" ).css({ 'background': '#e0e0e0' });

            if($("#ScaleWidthGalery").is( ":checked" )){}
            else{
                $( "#ScaleWidthGalery" ).prop("checked",true);
                $( "#ScaleSizesGalery1" ).attr("disabled",false);
                $( "#ScaleSizesGalery1" ).css({ 'background': '#ffffff' });
            }

        }

    });

    $(document).on('click',"#ScaleWidthGalery",function(){

        if($("#ScaleWidthGalery").is( ":checked" )){
            return;
            $("#ScaleSizesGalery").prop("checked",false);
            $("#ScaleSizesGalery1").prop("disabled",false);
            $("#ScaleSizesGalery2").prop("disabled",true);
            $( "#ScaleSizesGalery1" ).css({ 'background': '#ffffff' });
            $( "#ScaleSizesGalery2" ).css({ 'background': '#e0e0e0' });


        }

        else{
            $("#ScaleWidthGalery").prop("checked",true);


            return;

            $( "#ScaleSizesGalery" ).prop("checked",true);
            $("#ScaleSizesGalery").prop("disabled",false);
            $("#ScaleSizesGalery1").prop("disabled",false);
            $("#ScaleSizesGalery2").prop("disabled",false);
            $( "#ScaleSizesGalery2" ).css({ 'background': '#ffffff' });
            $( "#ScaleSizesGalery1" ).css({ 'background': '#ffffff' });

        }

    });

    // Check gallery END



// Check upload size


    $(document).on('click',"#ActivatePostMaxMB",function(){

        cgJsClassAdmin.options.functions.cg_ActivatePostMaxMB($);

    });


    $(document).on('click',"#ActivateBulkUpload",function(){

        cgJsClassAdmin.options.functions.cg_ActivateBulkUpload($);

    });


// Check upload size --- END

// Check resolution

//JPG


    $(document).on('click',"#allowRESjpg",function(){

        cgJsClassAdmin.options.functions.cg_allowRESjpg($);

    });


//PNG

    $(document).on('click',"#allowRESpng",function(){

        cgJsClassAdmin.options.functions.cg_allowRESpng($);

    });



//GIF

    $(document).on('click',"#allowRESgif",function(){

        cgJsClassAdmin.options.functions.cg_allowRESgif($);

    });

// Check resolution END

// Click input checkboxes END

// Check Background color
    $(document).on('click',"#ActivateGalleryBackgroundColor",function(){

        if($(this).is(":checked")){

            $("#GalleryBackgroundColor").attr("disabled",false);
            $("#GalleryBackgroundColor").css({ 'background': '#ffffff' });

        }

        else{

            $("#GalleryBackgroundColor").attr("disabled",true);
            $("#GalleryBackgroundColor").css({ 'background': '#e0e0e0' });

        }

    });

// Check Background color --- ENDE

    $(document).on('click',"#HeightLook",function(){

        cgJsClassAdmin.options.functions.cg_HeightLook(true,$);


    });

    $(document).on('click',"#ThumbLook",function(){

        cgJsClassAdmin.options.functions.cg_ThumbLook(true,$);

    });


    $(document).on('click',"#RowLook",function(){

        cgJsClassAdmin.options.functions.cg_RowLook(true,$);


    });


    $(document).on('click',"#SliderLook",function(){

        cgJsClassAdmin.options.functions.cg_SliderLook(true,$);

    });


// Check if Height Look fields are checked or not

// Check if Height Look fields are checked or not --- ENDE


// Check if Row Fields are checked or not

// Check if Row Fields are checked or not  --- END


// Activate in gallery upload form

    $(document).on('click',"#GalleryUpload",function(){

        cgJsClassAdmin.options.functions.checkInGalleryUpload($);

    });



// Activate in gallery upload form --- END



// Check if forward upload fields are checked or not


    $(document).on('click',"#cg_confirm_text",function(){

        cgJsClassAdmin.options.functions.cg_confirm_after_upload($);

    });


    $(document).on('click',"#forward",function(){

        cgJsClassAdmin.options.functions.cg_forward_after_upload($);

    });


// Check if forward upload fields are checked or not  --- END


    $(document).on('click',"#InformAdmin",function(){

        cgJsClassAdmin.options.functions.cg_inform_admin_after_upload($);

    });


// Check if forward login fields are checked or not

    $(document).on('click',"#ForwardAfterLoginUrlCheck",function(){

        cgJsClassAdmin.options.functions.cg_after_login($);

    });

    $(document).on('click',"#ForwardAfterLoginTextCheck",function(){

        cgJsClassAdmin.options.functions.cg_after_confirm_text($);

    });


// Check if forward login fields are checked or not  --- END


// Check mail confirm email

    $(document).on('click',"#mConfirmSendConfirm",function(){

        cgJsClassAdmin.options.functions.cg_mail_confirm_email($);

    });


// Check mail confirm email --- ENDE


// Check image activation email

    $(document).on('click',"#InformUsers",function(){

        cgJsClassAdmin.options.functions.cg_image_activation_email($);

    });


// Check image activation email --- ENDE


// Check show text instead of upload form or not

/*    var cgRegUserUploadOnly = function(){

        if($('#RegUserUploadOnly').is(":checked")){

           // $( "#wp-RegUserUploadOnlyText-wrap" ).removeClass("cg_disabled");
            $( "#RegUserMaxUpload" ).removeClass("cg_disabled");
            $( "#CheckIpUpload" ).removeClass("cg_disabled");
            $( "#CheckCookieUpload" ).removeClass("cg_disabled");
            $( "#CheckLoginUpload" ).removeClass("cg_disabled");
            $( "#UploadRequiresCookieMessage" ).removeClass("cg_disabled");

        }
        else{

            $( "#wp-RegUserUploadOnlyText-wrap" ).addClass("cg_disabled");
            $( "#RegUserMaxUpload" ).addClass("cg_disabled");
            $( "#CheckIpUpload" ).addClass("cg_disabled");
            $( "#CheckCookieUpload" ).addClass("cg_disabled");
            $( "#CheckLoginUpload" ).addClass("cg_disabled");
            $( "#UploadRequiresCookieMessage" ).addClass("cg_disabled");

        }

    };

    $("#RegUserUploadOnly").click(function() {

        cgRegUserUploadOnly();

    });

    cgRegUserUploadOnly();*/

    $(document).on('change',"#CheckLoginUpload, #CheckIpUpload, #CheckCookieUpload",function(){

        cgJsClassAdmin.options.functions.cgRegUserTextShowCheck($);

    });

    $(document).on('change',"#CheckLoginUpload, #CheckIpUpload, #CheckCookieUpload",function(){

        cgJsClassAdmin.options.functions.cgUploadRequiresCookieMessageCheck($);

    });

    $(document).on('click', '#RegUserGalleryOnly', function(e){

        cgJsClassAdmin.options.functions.cgRegUserGalleryOnly($);

    });

    $(document).on('click', '.CheckMethod', function(e){
        cgJsClassAdmin.options.functions.cg_user_reocgnising_method($);
    });

    // reset votes confirm
    $(document).on('click', '#cg_reset_votes2', function(e){

        var confirmText = $('#cg_reset_votes2_explanation').html();
        confirmText = confirmText.split("<br>").join("\r\n");

        if (confirm(confirmText)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }

    });

    $(document).on('click', '#cg_reset_votes', function(e){

        var confirmText = $('#cg_reset_votes_explanation').html();
        confirmText = confirmText.split("<br>").join("\r\n");

        if (confirm(confirmText)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }

    });

    $(document).on('click', '#cg_reset_users_votes2', function(e){

        var confirmText = $('#cg_reset_users_votes2_explanation').html();
        confirmText = confirmText.split("<br>").join("\r\n");

        if (confirm(confirmText)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }

    });

    $(document).on('click', '#cg_reset_users_votes', function(e){

        var confirmText = $('#cg_reset_users_votes_explanation').html();
        confirmText = confirmText.split("<br>").join("\r\n");

        if (confirm(confirmText)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }

    });

    $(document).on('click', '#cg_reset_admin_votes', function(e){

        var confirmText = $('#cg_reset_admin_votes_explanation').html();
        confirmText = confirmText.split("<br>").join("\r\n");

        if (confirm(confirmText)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }

    });

    $(document).on('click', '#cg_reset_admin_votes2', function(e){

        var confirmText = $('#cg_reset_admin_votes2_explanation').html();
        confirmText = confirmText.split("<br>").join("\r\n");

        if (confirm(confirmText)) {
            return true;
        } else {
            e.preventDefault();
            return false;
        }

    });

    $(document).on('click', '#HideRegFormAfterLogin', function(e){
        cgJsClassAdmin.options.functions.cg_HideRegFormAfterLogin($);

    });

    $(document).on('click', '#HideRegFormAfterLoginShowTextInstead', function(e){
        cgJsClassAdmin.options.functions.cg_HideRegFormAfterLoginShowTextInstead($);
    });


    /*Tab actions*/

    $(document).on('click','#cgGoTopOptions',function () {
        $(window).scrollTop(0);
    });

    $(document).on('click','#cgSaveOptionsNavButton',function () {
        $('#cgSaveOptionsButton').click();
    });

    $(document).on('click','#cg_main_options_tab .cg_view_select',function () {
        clickTime = new Date().getTime();
        //  var viewHelper = $(this).find('a').attr('data-href');
        var viewId = $(this).find('a').attr('data-view');
        var $view = $(viewId);
        var viewOffsetTop = $view.offset().top;
        var heightWpadminbar = $('#wpadminbar').height();
        var height_cg_main_options_tab = $('#cg_main_options_tab').height();
        var $cg_main_options_tab = $('#cg_main_options_tab');

        if($cg_main_options_tab.hasClass('cg_sticky')){
            var totalOffset = viewOffsetTop-heightWpadminbar-height_cg_main_options_tab-10;
        }else{
            var totalOffset = viewOffsetTop-heightWpadminbar-height_cg_main_options_tab-10-$cg_main_options_tab.outerHeight();
        }

        var $cg_main_options_content = $('#cg_main_options_content');
        $cg_main_options_tab.find('.cg_view_select').removeClass('cg_selected');
        $cg_main_options_content.find('.cg_view_header').removeClass('cg_selected');
        $cg_main_options_tab.addClass('cg_sticky');
        $(window).scrollTop(totalOffset);
        var $element = $(this);
        $element.addClass('cg_selected');
        setTimeout(function () {
            $cg_main_options_tab.find('.cg_view_select').removeClass('cg_selected');
            $element.addClass('cg_selected');
        },10);


        //var $viewHelper = $('<div id="'+viewHelper+'" class="cg_view_helper"></div>');
        //var $viewHelper = $viewHelper.css('margin-bottom',totalHeight+'px');
        //   $viewHelper.insertBefore($cg_main_options_content.find(view));
        // $cg_main_options_tab.addClass('cg_sticky');
        // document.getElementById(viewHelper).scrollIntoView();
        // setTimeout(function () {
        // $viewHelper.remove(); will be removed on scroll
        //  },10);
    });


    $( window ).scroll(function() {

        var $cgGoTopOptions = cgJsClassAdmin.options.vars.$cgGoTopOptions;
        var $cg_main_options_tab = cgJsClassAdmin.options.vars.$cg_main_options_tab;
        var $cg_main_options_content = cgJsClassAdmin.options.vars.$cg_main_options_content;
        var $cg_view_select_objects = cgJsClassAdmin.options.vars.$cg_view_select_objects;
        var $wpadminbar = cgJsClassAdmin.options.vars.$wpadminbar;
        var windowHeight = cgJsClassAdmin.options.vars.windowHeight;
        var lastScrollTop = cgJsClassAdmin.options.vars.lastScrollTop;
        var clickTime = cgJsClassAdmin.options.vars.clickTime;

        if(!$cg_main_options_tab){
            return;
        }

        var height_cg_main_options_tab = $cg_main_options_tab.height();
        var heightWpadminbar = $wpadminbar.height();
        var windowScrollTop = $(window).scrollTop();

        if(windowScrollTop>=windowHeight){//then Downscroll
            $cgGoTopOptions.removeClass('cg_hide');
        }else{
            $cgGoTopOptions.addClass('cg_hide');
        }

        if(windowScrollTop>=$cg_main_options_content.offset().top && windowScrollTop>=lastScrollTop){//then Downscroll
            $cg_main_options_tab.addClass('cg_sticky');
        }

        if(windowScrollTop<$cg_main_options_content.offset().top && windowScrollTop<lastScrollTop){//then Downscroll
            $cg_main_options_tab.removeClass('cg_sticky');
        }

        $cg_view_select_objects.each(function () {
            var $cg_view_select = $(this);
            var $view = $cg_main_options_content.find($cg_view_select.attr('data-view'));
            var cg_view_offsetTop = $view.offset().top;
            var elementPositionRelatedToWindow = cg_view_offsetTop-windowScrollTop+$view.outerHeight()+$view.next().outerHeight()-height_cg_main_options_tab-heightWpadminbar;
            if(elementPositionRelatedToWindow > 0 && windowScrollTop>=lastScrollTop){//then Downscroll
                var scrollTime = new Date().getTime()-1000;// if scroll time was later then 1 second of click time
                if(scrollTime>clickTime){
                    $cg_view_select_objects.removeClass('cg_selected');
                    $cg_view_select.addClass('cg_selected');
                }
                return false;
            }
            var heightCheck = windowHeight/4;
            if(elementPositionRelatedToWindow > heightCheck && windowScrollTop<lastScrollTop){//then Downscroll
                var scrollTime = new Date().getTime()-1000;// if scroll time was later then 1 second of click time
                if(scrollTime>clickTime){
                    $cg_view_select_objects.removeClass('cg_selected');
                    $cg_view_select.addClass('cg_selected');
                }
                return false;
            }
        });

        cgJsClassAdmin.options.vars.lastScrollTop = windowScrollTop;

    });


    /*Tab actions - END*/

    // reset votes show info

    $(document).on('hover','#cg_reset_votes2',function (e) {
        e.preventDefault();
        $('#cg_reset_votes2_explanation').toggle();
    });
    $(document).on('hover','#cg_reset_users_votes2',function (e) {
        e.preventDefault();
        $('#cg_reset_users_votes2_explanation').toggle();
    });
    $(document).on('hover','#cg_reset_admin_votes2',function (e) {
        e.preventDefault();
        $('#cg_reset_admin_votes2_explanation').toggle();
    });

    $(document).on('hover','#cg_reset_votes',function (e) {
        e.preventDefault();
        $('#cg_reset_votes_explanation').toggle();
    });
    $(document).on('hover','#cg_reset_users_votes',function (e) {
        e.preventDefault();
        $('#cg_reset_users_votes_explanation').toggle();
    });
    $(document).on('hover','#cg_reset_admin_votes',function (e) {
        e.preventDefault();
        $('#cg_reset_admin_votes_explanation').toggle();
    });

    // reset votes show info --- END

    // go to and blink

    $(document).on('click','a[href="#cgActivateInGalleryUploadForm"]',function (e) {
        e.preventDefault();
        var offsetTop = $('#cgActivateInGalleryUploadForm').offset().top;
        $(window).scrollTop(offsetTop-300);
        $('#cgActivateInGalleryUploadForm').addClass('cg_blink');
    });

    // go to and blink --- END

    // allow sort options
    $(document).on('click','.cg-allow-sort-option',function (e) {
        e.preventDefault();
        var $element = $(this);
        if($element.hasClass('cg_unchecked')){
            $element.removeClass('cg_unchecked');
            $('.cg-allow-sort-input[value="'+$element.attr('data-cg-target')+'"]').prop('disabled',false);
        }else{
            $element.addClass('cg_unchecked');
            $('.cg-allow-sort-input[value="'+$element.attr('data-cg-target')+'"]').prop('disabled',true);
        }
    });

    // set inputs to disabled if unchecked
    $('.cg-allow-sort-option').each(function () {
        if($(this).hasClass('cg_unchecked')){
            $('.cg-allow-sort-input[value="'+$(this).attr('data-cg-target')+'"]').prop('disabled',true);
        }
    });

    // allow sort options --- END

    // allow sort

    $(document).on('click','#AllowSort',function () {
        cgJsClassAdmin.options.functions.cgAllowSortCheck($);
    });

    // allow sort --- END

});