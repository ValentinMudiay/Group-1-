jQuery(document).ready(function($){

/*    $(document).on('click', '.cg_step ', function(e){

        var $field = $(this);

        setTimeout(function () {
            $('.cg_step').removeClass('cg_step_selected');
            setTimeout(function () {
                $field.addClass('cg_step_selected');
            },200);
        },200);

    });*/


// View control ajax posts and similiar


    var cgChangedAndSearchedValueSelector = cgJsClassAdmin.gallery.vars.cgChangedAndSearchedValueSelector;


    $(document).on('click','#cgGalleryBackendContainer #cgSortable .informdiv .cg_go_to_save_button',function () {

        $("html, body").animate({ scrollTop: $(document).height() }, 0);

    });

    $(document).on('mouseenter','#cgGalleryBackendContainer .cg_backend_info_container.cg_searched_value',function () {

        $(this).parent().find('.cg-info-container').first().show();

    });

    $(document).on('mouseleave','#cgGalleryBackendContainer .cg_backend_info_container.cg_searched_value',function () {

        $(this).parent().find('.cg-info-container').first().hide();

    });


    // send only values that are needed to send
    $(document).on('change',cgChangedAndSearchedValueSelector,function () {
        $(this).addClass('cg_value_changed');
    });


    $(document).on('click','#cgGalleryBackendContainer #cgPicsPerSite .cg_step',function (e) {
        e.preventDefault();
        cgJsClassAdmin.gallery.functions.abortRequest();

        $('#cgPicsPerSite .cg_step').removeClass('cg_step_selected');

        // have to start from 0 again then
        $('#cgStepsChanged').prop('disabled',false);

        cgJsClassAdmin.gallery.functions.changeViewByControl($,$(this).addClass('cg_step_selected'));

    });

    $(document).on('click','#cgGalleryBackendContainer .cg_steps_navigation .cg_step',function (e) {
        e.preventDefault();
        cgJsClassAdmin.gallery.functions.abortRequest();

        cgJsClassAdmin.gallery.functions.changeViewByControl($,null,$(this));

        if($(this).closest('.cg_steps_navigation').attr('id')=='cgStepsNavigationBottom'){
            document.getElementById('cgGalleryForm').scrollIntoView();
        }

    });

    $(document).on('change','#cgGalleryBackendContainer #cgOrderSelect',function () {
        cgJsClassAdmin.gallery.functions.abortRequest();

        var $selected = $(this).find(':selected');
        $('#cgOrderValue').val($selected.val());

        cgJsClassAdmin.gallery.functions.changeViewByControl($);

    });

    $(document).on('input','#cgGalleryBackendContainer #cgSearchInput',function () {

        cgJsClassAdmin.gallery.functions.abortRequest();
        var $el = $(this);
        $el.val($el.val().trim());
        $('#cgStartValue').val('0');
        if($el.val().length>=1){
            $el.addClass('cg_searched_value');
            $('#cgSearchInputClose').removeClass('cg_hide');
        }else{
            $el.removeClass('cg_searched_value');
            $('#cgSearchInputClose').addClass('cg_hide');
        }

        cgJsClassAdmin.gallery.functions.changeViewByControl($,null,null,null,true);

    });

    $(document).on('submit','#cgGalleryBackendContainer #cgGalleryForm',function (e) {
        e.preventDefault();
        cgJsClassAdmin.gallery.functions.abortRequest();
        // disable all fields which were not changed!!!!
        $(cgChangedAndSearchedValueSelector).not(".cg_value_changed").prop('disabled',true);
        cgJsClassAdmin.gallery.functions.changeViewByControl($,null,null,true);
    });

    $(document).on('click','#cgGalleryBackendContainer #cgSearchInputClose',function (e) {
        e.preventDefault();
        cgJsClassAdmin.gallery.functions.abortRequest();

        var $cgSearchInput = $('#cgSearchInput');

        $cgSearchInput.removeClass('cg_searched_value');

        $(this).addClass('cg_hide');

        $cgSearchInput.val('');

        localStorage.setItem('cgSearch_BG_'+gid, '');
        cgJsClassAdmin.gallery.functions.changeViewByControl($);
    });




// View control ajax posts and similiar -- END





    $(document).on('click', '#cgGalleryBackendContainer #CatWidget', function(e){

        if($(this).is( ":checked" )){
            $("#ShowCatsUnchecked").removeClass("cg_disabled");
        }
        else{
            $("#ShowCatsUnchecked").addClass("cg_disabled");
        }

    });

    $(document).on('keypress', '#cgGalleryBackendContainer .cg_manipulate_plus_value .cg_manipulate_5_star_input', function(e){
            //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            // $("#cg_options_errmsg").html("Only numbers are allowed").show().fadeOut("slow");
            return false;
        }
    });


    $(document).on('input','#cgGalleryBackendContainer .cg_manipulate_plus_value',function (e) {

        if(parseInt(this.value)<0){
            this.value = 0;
        }

        var cgSortableDiv = $(this).closest('.cgSortableDiv');
        var $cg_backend_info_container = $(this).closest('.cg_backend_info_container');


        var cg_rating_value_text = cgSortableDiv.find('.cg_rating_value').text();
        cg_rating_value_width = cg_rating_value_text.length*8;

        var originValue = parseInt(cgSortableDiv.find('.cg_value_origin').val());

        if (this.value.length > 8) {
            this.value = this.value.slice(0,8);
            var addValue = parseInt(this.value);
        }
        else{
           var addValue=parseInt(this.value);
        }

        if(isNaN(addValue)){
            addValue=0;
        }

        if(isNaN(originValue)){
            originValue=0;
        }

        var newValue = originValue+addValue;

        if(newValue<1){
            cgSortableDiv.find('.cg_rating_center img').attr('src',cgJsClassAdmin.gallery.vars.setStarOffSrc);
            newValue = 0;
        }
        else{
            cgSortableDiv.find('.cg_rating_center img[src$="_reduced_with_border.png"]').attr('src',cgJsClassAdmin.gallery.vars.setStarOnSrc);

        }

        cgSortableDiv.find('.cg_rating_value').text(newValue);
        cgSortableDiv.find('.cg_value_add_one_star').val(addValue);

        if(addValue>=1){
            $cg_backend_info_container.find('.cg_rating_value_countR_additional_votes').text(addValue).removeClass('cg_hide');
        }else{
            $cg_backend_info_container.find('.cg_rating_value_countR_additional_votes').addClass('cg_hide');
        }


    });

    $(document).on('input','#cgGalleryBackendContainer .cg_manipulate_5_star_input',function (e) {

        if(parseInt(this.value)<0){
            this.value = 0;
        }

        if (this.value.length > 7) {
            this.value = this.value.slice(0,7);
            var addValue = this.value;
        }
        else{
            var addValue = this.value;
        }

        if(isNaN(addValue)){
            addValue=0;
        }

        var $cg_backend_info_container = $(this).closest('.cg_backend_info_container');
        var dataStar = $(this).attr('data-star');

        var container = $(this).closest('.cgSortableDiv');
        var countRbefore = container.find('.cg_value_origin_5_star_count').val();

        var ratingRnew = container.find('.cg_value_origin_5_star_rating').val();

        addValue = addValue.trim();


        countRbefore = countRbefore.trim();
        ratingRnew = ratingRnew.trim();

        addValue = parseInt(addValue);

        countRbefore = parseInt(countRbefore);
        ratingRnew = parseInt(ratingRnew);


        if($(this).hasClass('cg_manipulate_1_star_number')){

            var originCountR = container.find('.cg_value_origin_5_only_value_1').val();
            originCountR = originCountR.trim();
            originCountR = parseInt(originCountR);

            if(isNaN(originCountR)){
                originCountR=0;
            }

            var valueCountR = originCountR+addValue;

            if(valueCountR<0){

                return false;

            }

            container.find('.cg_value_origin_5_star_addCountR1').val(addValue);

            container.find('.cg_rating_value_countR1').text(valueCountR);


        }


        if($(this).hasClass('cg_manipulate_2_star_number')){

            var originCountR = container.find('.cg_value_origin_5_only_value_2').val();
            originCountR = originCountR.trim();
            originCountR = parseInt(originCountR);

            if(isNaN(originCountR)){
                originCountR=0;
            }

            var valueCountR = originCountR+addValue;

            if(valueCountR<0){

                return false;

            }

            container.find('.cg_value_origin_5_star_addCountR2').val(addValue);

            container.find('.cg_rating_value_countR2').text(valueCountR);

        }


        if($(this).hasClass('cg_manipulate_3_star_number')){

            var originCountR = container.find('.cg_value_origin_5_only_value_3').val();
            originCountR = originCountR.trim();
            originCountR = parseInt(originCountR);

            if(isNaN(originCountR)){
                originCountR=0;
            }

            var valueCountR = originCountR+addValue;

            if(valueCountR<0){

                return false;

            }

            container.find('.cg_value_origin_5_star_addCountR3').val(addValue);

            container.find('.cg_rating_value_countR3').text(valueCountR);

        }


        if($(this).hasClass('cg_manipulate_4_star_number')){

            var originCountR = container.find('.cg_value_origin_5_only_value_4').val();
            originCountR = originCountR.trim();
            originCountR = parseInt(originCountR);

            if(isNaN(originCountR)){
                originCountR=0;
            }

            var valueCountR = originCountR+addValue;

            if(valueCountR<0){

                return false;

            }

            container.find('.cg_value_origin_5_star_addCountR4').val(addValue);

            container.find('.cg_rating_value_countR4').text(valueCountR);

        }


        if($(this).hasClass('cg_manipulate_5_star_number')){

            var originCountR = container.find('.cg_value_origin_5_only_value_5').val();
            originCountR = originCountR.trim();
            originCountR = parseInt(originCountR);

            if(isNaN(originCountR)){
                originCountR=0;
            }

            var valueCountR = originCountR+addValue;

            if(valueCountR<0){

                return false;

            }

            container.find('.cg_value_origin_5_star_addCountR5').val(addValue);

            container.find('.cg_rating_value_countR5').text(valueCountR);

        }

        if(addValue>=1){
            $cg_backend_info_container.find('.cg_rating_value_countR_additional_votes_'+dataStar+'').text(addValue).removeClass('cg_hide');
        }else{
            $cg_backend_info_container.find('.cg_rating_value_countR_additional_votes_'+dataStar+'').addClass('cg_hide');
        }


        var addValue = 0;

      //  console.log('ratingRnew: '+ratingRnew);

        var addCountRtotal = 0;
        container.find('.cg_stars_overview .cg_rating_value_countR_additional_votes').each(function (index) {
            addCountRtotal = addCountRtotal + parseInt($(this).text());
        });

        if(addCountRtotal>0){
            container.find('.cg_rating_value_countR_additional_votes_total').removeClass('cg_hide').text(addCountRtotal);
        }else{
            container.find('.cg_rating_value_countR_additional_votes_total').removeClass('cg_hide').text(0);
        }

        container.find('.cg_value_origin_5_star_to_cumulate').each(function (index) {

            var r = index+1;

            if($(this).val()==''){

                var valueToAdd = 0;

            }
            else{

                var valueToAdd = parseInt($(this).val());

            }


            if($(this).hasClass('cg_value_origin_5_star_addCountR1')){
             //   console.log('ratingRnew1: '+valueToAdd);

                ratingRnew = ratingRnew+valueToAdd*1;
             //   console.log('ratingRnew1ratingRnew: '+ratingRnew);


            }
            if($(this).hasClass('cg_value_origin_5_star_addCountR2')){

                ratingRnew = ratingRnew+valueToAdd*2;

            }
            if($(this).hasClass('cg_value_origin_5_star_addCountR3')){

                ratingRnew = ratingRnew+valueToAdd*3;

            }
            if($(this).hasClass('cg_value_origin_5_star_addCountR4')){

                ratingRnew = ratingRnew+valueToAdd*4;

            }
            if($(this).hasClass('cg_value_origin_5_star_addCountR5')){
                ratingRnew = ratingRnew+valueToAdd*5;
            }


            if(valueToAdd>=1 || valueToAdd<=1){
                addValue= addValue + valueToAdd;
            }

            if(r==5){



                cgJsClassAdmin.gallery.vars.addValue = addValue;
                cgJsClassAdmin.gallery.vars.ratingRnew = ratingRnew;

                return;
            }

        });

        var countRnew = countRbefore+parseInt(cgJsClassAdmin.gallery.vars.addValue);

        var average = cgJsClassAdmin.gallery.vars.ratingRnew/countRnew;
        average = Math.round(average * 10)/10;

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

        // all classes has to be removed before the class which should affect will be added
        $cg_backend_info_container.find('.cg_rating_5_star_img_div_one_star').removeClass('cg_gallery_rating_div_one_star_off cg_gallery_rating_div_one_star_half_off cg_gallery_rating_div_one_star_on').addClass(stars.star1);
        $cg_backend_info_container.find('.cg_rating_5_star_img_div_two_star').removeClass('cg_gallery_rating_div_one_star_off cg_gallery_rating_div_one_star_half_off cg_gallery_rating_div_one_star_on').addClass(stars.star2);
        $cg_backend_info_container.find('.cg_rating_5_star_img_div_three_star').removeClass('cg_gallery_rating_div_one_star_off cg_gallery_rating_div_one_star_half_off cg_gallery_rating_div_one_star_on').addClass(stars.star3);
        $cg_backend_info_container.find('.cg_rating_5_star_img_div_four_star').removeClass('cg_gallery_rating_div_one_star_off cg_gallery_rating_div_one_star_half_off cg_gallery_rating_div_one_star_on').addClass(stars.star4);
        $cg_backend_info_container.find('.cg_rating_5_star_img_div_five_star').removeClass('cg_gallery_rating_div_one_star_off cg_gallery_rating_div_one_star_half_off cg_gallery_rating_div_one_star_on').addClass(stars.star5);

        container.find('.cg_rating_value_countR').text(countRnew);

    });


    $(document).on('input','#cgGalleryBackendContainer .cg_image_title, .cg_image_description, .cg_manipulate_plus_value, .cg_manipulate_5_star_input',function() {

        if(!cgJsClassAdmin.gallery.vars.inputsChanged){
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');
            cgJsClassAdmin.gallery.vars.inputsChanged = true;
        }

    });


    $(document).on('change','#cgGalleryBackendContainer .cg_category_select',function() {

        if(!cgJsClassAdmin.gallery.vars.selectChanged){
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');
            cgJsClassAdmin.gallery.vars.selectChanged = true;
        }

    });
    // without cgGalleryBackendContainer this one!!!! because is over!
    $(document).on('click','#cgAddFieldsPressedAfterContentModification.cg_active',function(e) {

        if($(e.target).closest('#cgAddFieldsPressedAfterContentModificationContent').length || $(e.target).is('#cgAddFieldsPressedAfterContentModificationContent')){

        }else{

            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_hide');

        }

    });

    // without cgGalleryBackendContainer this one!!!! because is over!
    $(document).on('click','#cgAddFieldsPressedAfterContentModificationContent .cg_message_close',function(e) {

        $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_hide');

    });

    $(document).on('click','#cgGalleryBackendContainer .cg_fields_div_add_fields',function(e) {

        if(cgJsClassAdmin.gallery.vars.inputsChanged || cgJsClassAdmin.gallery.vars.selectChanged){
            e.preventDefault();
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').removeClass('cg_hide');
        }

    });

    $(document).on('click','#cgGalleryBackendContainer .cg_title_icon',function() {

        var post_title = $(this).closest('.cg_image_title_container').find('.post_title').val();
        if(post_title === '' || typeof post_title == 'undefined') {
            //$(this).parent().find('.cg_image_title').addClass('cg_value_changed');
            if($(this).closest('.cg_image_title_container').find('.cg_image_title').val()==''){
                $(this).closest('.cg_image_title_container').find('.cg_image_title').attr('placeholder','No WordPress title available');
            }
        }
        else {
            cgJsClassAdmin.gallery.vars.inputsChanged = true;
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');
            var val = $(this).closest('.cg_image_title_container').find('.cg_image_title').val();
            $(this).closest('.cg_image_title_container').find('.cg_image_title').val(val+' '+post_title).addClass('cg_value_changed');
        }

    });

    $(document).on('click','#cgGalleryBackendContainer .cg_description_icon',function() {

        var post_description = $(this).closest('.cg_image_description_container').find('.post_description').val();
        post_description = post_description.replace(/(<([^>]+)>)/ig,"");

        if(post_description === '' || typeof post_description == 'undefined') {
            //$(this).parent().parent().find('.cg_image_description').addClass('cg_value_changed');
            if($(this).closest('.cg_image_description_container').find('.cg_image_description').val()==''){
                $(this).closest('.cg_image_description_container').find('.cg_image_description').attr('placeholder','No WordPress description available').addClass('cg_value_changed');
            }
        }
        else {
            cgJsClassAdmin.gallery.vars.inputsChanged = true;
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');
            var val = $(this).closest('.cg_image_description_container').find('.cg_image_description').val();
            $(this).closest('.cg_image_description_container').find('.cg_image_description').val(val+' '+post_description).addClass('cg_value_changed');
        }

    });

    $(document).on('click','#cgGalleryBackendContainer .cg_excerpt_icon',function() {

        var post_excerpt = $(this).closest('.cg_image_excerpt_container').find('.post_excerpt').val();
        if(post_excerpt === '' || typeof post_excerpt == 'undefined') {
            //$(this).parent().parent().find('.cg_image_excerpt').addClass('cg_value_changed');
            if($(this).closest('.cg_image_excerpt_container').find('.cg_image_excerpt').val()==''){
                $(this).closest('.cg_image_excerpt_container').find('.cg_image_excerpt').attr('placeholder','No WordPress excerpt available');
            }
        }
        else {
            cgJsClassAdmin.gallery.vars.inputsChanged = true;
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');
            var val = $(this).closest('.cg_image_excerpt_container').find('.cg_image_excerpt').val();
            $(this).closest('.cg_image_excerpt_container').find('.cg_image_excerpt').val(val+' '+post_excerpt).addClass('cg_value_changed');
        }

    });





// Nicht löschen, wurde ursprünglich dazu markiert alle Felder auswählen zu lassen die im Slider gezeigt werden sollen, Logik könnte noch nützlich sein! --- ENDE	



    //alert(allFieldClasses);

    function countChar(val) {
        var len = val.value.length;
        if (len >= 1000) {
            val.value = val.value.substring(0, 1000);
        } else {
            $('#charNum').text(1000 - len);
        }
    };





    $(document).on('click','.clickMore',function() {
        // Zeigen oder Verstecken:

        $(this).next().slideDown('slow');
        $(this).next(".mehr").next(".clickBack").toggle();
        $(this).hide();


    });

    $(document).on('click','.clickBack',function() {
        $(this).prev().slideUp('slow');
        $(this).prev(".mehr").prev(".clickMore").toggle();
        $(this).hide();


    });

// Verstecken weiterer Boxen ---- ENDE

// Change Daten ändern oder löschen

    $(document).on('change','#chooseAction1',function(){


        cgJsClassAdmin.gallery.vars.selectChanged = true;
        $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');

        var chooseAction = $( "#chooseAction1 option:selected" ).val();


        if(chooseAction==3){

            $('.cg_image_checkbox:checked').each(function(){
                $(this).closest('.cgSortableDiv').addClass('highlightedRemoveable');
                $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
            });

        }
        else if(chooseAction==2){

            $('.cg_image_checkbox:checked').each(function(){
                $(this).closest('.cgSortableDiv').addClass('highlightedDeactivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
            });

        }
        else if(chooseAction==1){

            $('.cg_image_checkbox:checked').each(function(){
                $(this).closest('.cgSortableDiv').addClass('highlightedActivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
            });

        }
        else{

            $('.cg_image_checkbox:checked').each(function(){
                $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
                $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
            });

        }


    });


//Change Daten ändern oder löschen -- END


    /*
    $("input[class*=deactivate]").change(function(){

    //$( this ).parent( "div input .imageThumb" ).removeAttr("disabled");
    //$( this ).closest( "input" ).removeAttr("disabled");
    //$( this ).parent().find( "input .imageThumb" ).removeAttr("disabled");

    if($(this).is(":checked")){
    var platzhalter = 'keine Aktion';
    $( this ).parent().find(".deactivate").remove();
    $( this ).parent().find( ".image-delete" ).prop("disabled",false);
    }

    else{

    var id = $(this).val();
    $( this ).parent().append("<input type='hidden' name='deactivate[]' value='"+id+"' class='deactivate'>" );
    $( this ).parent().find( ".image-delete" ).prop("disabled",true);
    }


    });*/

    $(document).on('change','.cg_image_checkbox',function(){


        cgJsClassAdmin.gallery.vars.selectChanged = true;
        $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');

        var chooseAction = $( "#chooseAction1 option:selected" ).val();

        $(this).closest('.cg_sortable_div').find(cgJsClassAdmin.gallery.vars.cgChangedValueSelectorInTargetedSortableDiv).addClass('cg_value_changed');

        if($(this).is(":checked")){
            if(chooseAction==3){
                $(this).closest('.cgSortableDiv').addClass('highlightedRemoveable');
                $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
            }
            else if(chooseAction==2){
                $(this).closest('.cgSortableDiv').addClass('highlightedDeactivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
            }
            else if(chooseAction==1){
                $(this).closest('.cgSortableDiv').addClass('highlightedActivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
            }
        }
        else{
            $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
            $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
            $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
        }

    });


// Duplicate email to a hidden field for form


    $(document).on('change','.email',function(){

        var email = $( this ).val();
        $( this ).parent().find( ".email-clone" ).val(email);

    });

// Duplicate email to a hidden field for form -- END 


    $(document).on('click','div input #activate',function() {
        $("input #inform").prop("disabled", this.checked);
    });

    /*function informAll(){

    //alert(arg);
    alert(arg1);

    if($("#informAll").is( ":checked" )){
    $( "input[class*=inform]").removeAttr("checked",true);
    $( "input[class*=inform]").click();
    }

    else{
    $( "input[class*=inform]").click();

    }

    }*/

// Alle Bilder auswählen 

    var n = 0;

    $(document).on('click','#chooseAll',function(){


        cgJsClassAdmin.gallery.vars.selectChanged = true;
        $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').addClass('cg_active');

        n++;
        $("#click-count").val(n);

        var chooseAction = $( "#chooseAction1 option:selected" ).val();

        $(cgJsClassAdmin.gallery.vars.cgChangedAndSearchedValueSelector).addClass('cg_value_changed');

        if($("#chooseAll").is( ":checked" )){

            $(".cg_image_checkbox").prop("checked",true);

            if(chooseAction==3){

                $('.cgSortableDiv').each(function(){
                    $(this).addClass('highlightedRemoveable');
                    $(this).removeClass('highlightedActivate');
                    $(this).removeClass('highlightedDeactivate');
                });

            }
            else if(chooseAction==2){

                $('.cgSortableDiv').each(function(){
                    $(this).addClass('highlightedDeactivate');
                    $(this).removeClass('highlightedActivate');
                    $(this).removeClass('highlightedRemoveable');
                });

            }
            else if(chooseAction==1){

                $('.cgSortableDiv').each(function(){
                    $(this).addClass('highlightedActivate');
                    $(this).removeClass('highlightedDeactivate');
                    $(this).removeClass('highlightedRemoveable');
                });

            }

        }
        else{

            //$(".cg_image_checkbox").prop("checked",false);

            $('.cg_image_checkbox').each(function(){
                $(this).closest('.cgSortableDiv').removeClass('highlightedRemoveable');
                $(this).closest('.cgSortableDiv').removeClass('highlightedDeactivate');
                $(this).closest('.cgSortableDiv').removeClass('highlightedActivate');
                $(this).prop("checked",false);
            });

        }

    });

// Alle Bilder auswählen --- END


// show exif data

/*    $(document).on('click','.cg-exif-container button',function () {

        $(this).closest('.cg-exif-container').find('.cg-exif-append').show();

    });*/


// show exif data --- ENDE

    $(document).on('click','.cg_category_checkbox_images_area input[type="checkbox"]',function () {

        var $element = $(this);

     //   setTimeout(function () {
            if(!$element.prop('checked')==true){
                $element.addClass('cg_checked');
            }else{
                $element.removeClass('cg_checked');
            }
    //    },1000);


    });


    // save category changes


    $(document).on('click','#cgSaveCategoriesForm',function () {

        var form = document.getElementById('cgCategoriesForm');
        var formPostData = new FormData(form);

        $('#cgSaveCategoriesLoader').removeClass('cg_hide');

        setTimeout(function () {

            $.ajax({
                url: 'admin-ajax.php',
                method: 'post',
                data: formPostData,
                dataType: null,
                contentType: false,
                processData: false
            }).done(function(response) {
                $('#cgSaveCategoriesLoader').addClass('cg_hide');
                $("#cg_changes_saved_categories").show().fadeOut(4000);

            }).fail(function(xhr, status, error) {

                $('#cgSaveCategoriesLoader').addClass('cg_hide');
                var test = 1;

            }).always(function() {

                var test = 1;

            });

        },1000);

    });

    // check active images count by categories

    $(document).on('click','.cg-categories-check',function () {

        var totalVisibleActivatedImagesCount = 0;

        $('.cg-categories-check').each(function () {
            if($(this).prop('checked')){
                totalVisibleActivatedImagesCount = totalVisibleActivatedImagesCount + parseInt($(this).attr('data-cg-images-in-category-count'));
            }
        });

        $('#cgCategoryTotalActiveImagesValue').text(totalVisibleActivatedImagesCount);

    });

    // init date time fields

    $(document).on('keydown','.cg_input_date_class',function(e) {

        e.preventDefault();

        if(e.which==46 || e.which==8){// back, delete
            this.value = '';
        }

    });


});