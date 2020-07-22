cgJsClassAdmin.gallery.functions = cgJsClassAdmin.gallery.functions || {};
cgJsClassAdmin.gallery.functions = {
    requests: [],
    abortRequest: function(){

        for(var index in cgJsClassAdmin.gallery.functions.requests){
            cgJsClassAdmin.gallery.functions.requests[index].abort();
            delete cgJsClassAdmin.gallery.functions.requests[index];
        }

    },
    load: function($,isAddImages,$formLinkObject,isAddImages){

        if(isAddImages){
            $('#cg_uploading_gif').hide();
            $('#cg_uploading_div').hide();
            $('#cgSortable').remove();
            $('#cgStepsNavigationTop').remove();
        }


       if(!document.getElementById('cgGalleryForm')){
            return;
        }


//    $('#cgViewControl').removeClass('cg_hide');
        $('.cg_steps_navigation').removeClass('cg_hide');
        $('#cgSortable').removeClass('cg_hide');


        cgJsClassAdmin.gallery.vars.setStarOnStarOffSrc();

// Add icon

        $( "#cg_server_power_info" ).hover(function() {
            //alert(3);
            $('#cg_answerPNG').toggle();
            $(this).css('cursor','pointer');
        });

        $( "#cg_adding_images_info" ).hover(function() {
            //alert(3);
            $('#cg_adding_images_answer').toggle();
            $(this).css('cursor','pointer');
        });

//Check if the current URL contains '#'

        // Verstecken weiterer Boxen

        $('.mehr').hide();
        $('.clickBack').hide();

        // moved from gallery_admin --- ENDE


        $('#chooseAll').prop('checked',false);

        if($formLinkObject){

            if($formLinkObject.hasClass('cg_load_backend_create_gallery')){

                $('#cgGalleryLoader').addClass('cg_hide');
                $('#cgSortable').addClass('cg_hide');
                $('#cgGallerySubmit').addClass('cg_hide');
                $(".cg-created-new-gallery").fadeOut(8000);
                return;
            }
        }

        $('#cgGalleryLoader').removeClass('cg_hide');
        $('#cgViewControl').removeClass('cg_hide');


        $('#cgSortable').remove();// can be removed here on load
        $('#cgGallerySubmit').remove();// can be removed here on load
        $('#cgStepsNavigationBottom').remove();// can be removed here on load

        var gid = $('#cgBackendGalleryId').val();

        // BG is for backend gallery
        var cgStart_BG = localStorage.getItem('cgStart_BG_'+gid);
        // check types also here because can be 0
        if(cgStart_BG || cgStart_BG===0 || cgStart_BG==='0'){$('#cgStartValue').val(cgStart_BG)}
        var cgStep_BG = localStorage.getItem('cgStep_BG_'+gid);
        if(cgStep_BG){$('#cgStepValue').val(cgStep_BG)}
        var cgOrder_BG = localStorage.getItem('cgOrder_BG_'+gid);
        if(cgOrder_BG){$('#cgOrderValue').val(cgOrder_BG)}
        var cgSearch_BG = localStorage.getItem('cgSearch_BG_'+gid);
        if(cgSearch_BG){$('#cgSearchInput').val(cgSearch_BG)}

        var form = document.getElementById('cgGalleryForm');
        var formPostData = new FormData(form);

        // !IMPORTANT!!!! Do not remove otherwise recursion error! Needs to check first time new backend ajax version 10.9.9 null null is instaled
        formPostData.append('cgBackendHash',$('#cgBackendHash').val());

        // AJAX Call - Submit Form
        cgJsClassAdmin.gallery.functions.requests.push($.ajax({
            url: 'admin-ajax.php',
            method: 'post',
            data: formPostData,
            dataType: null,
            contentType: false,
            processData: false
        }).done(function(response) {

            if(cgJsClassAdmin.gallery.functions.missingRights($,response)){return;}


            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').removeClass('cg_active');
            cgJsClassAdmin.gallery.vars.selectChanged = false;
            cgJsClassAdmin.gallery.vars.inputsChanged = false;

            $('#cgGalleryLoader').addClass('cg_hide');


            var htmlDom = new DOMParser().parseFromString(response, 'text/html');
            var $cgSortable = $(htmlDom.getElementById('cgSortable'));
            var $cgGallerySubmit = $(htmlDom.getElementById('cgGallerySubmit'));
            $('#cgStepsNavigationTop').remove(); // remove existing cgStepsNavigationTop first
            var $cgStepsNavigationTop = $(htmlDom.getElementById('cgStepsNavigationTop'));
            $cgStepsNavigationTop.removeClass('cg_hide');
            var $cgStepsNavigationBottom = $(htmlDom.getElementById('cgStepsNavigationBottom'));

            $cgStepsNavigationTop.insertAfter($('#cgGalleryLoader'));
            $cgSortable.insertAfter($cgStepsNavigationTop);

            var isNoImagesFound = false;

            if($cgSortable.find('.cg_backend_info_container').length>=1){
                $cgGallerySubmit.insertAfter($cgSortable);
                $('#cgViewControl').removeClass('cg_hide');
                $cgSortable.find('#cgNoImagesFound').addClass('cg_hide');
            }else{
                isNoImagesFound = true;
                $cgSortable.find('#cgNoImagesFound').removeClass('cg_hide');
                //$cgSortable.addClass('cg_hide');
                $('#cgGallerySubmit').addClass('cg_hide');
            }

            $cgStepsNavigationBottom.insertAfter($cgGallerySubmit);

            cgJsClassAdmin.gallery.functions.markSearchedValueFields($);

            $('#cgStepsChanged').prop('disabled',true);

            cgJsClassAdmin.gallery.functions.sortableInit($);
            cgJsClassAdmin.gallery.functions.initDateTimePicker($);

            if(isNoImagesFound){
                cgJsClassAdmin.gallery.functions.checkIfFurtherImagesAvailable($);
            }

            if(isAddImages){
                var $changesSaved = $('#cgSortable').find('#cg_changes_saved');
                if($changesSaved.length){
                    $changesSaved.remove();
                }
                $("<p id='cg_changes_saved' style='font-size:18px;'><strong>Images added</strong></p>").prependTo('#cgSortable');
                $("#cg_changes_saved").fadeOut(4000);
            }else{
                if($formLinkObject){
                    if($formLinkObject.hasClass('cg_load_backend_submit_form_submit')){
                        if(!$('#cgSortable').find('#cg_changes_saved').length){
                             $("<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>").prependTo('#cgSortable');
                        }
                        $("#cg_changes_saved").fadeOut(4000);
                    }
                }
            }

        }).fail(function(xhr, status, error) {


        }).always(function() {

        }));

    },
    changeViewByControl: function ($,$cgStep,$cgStart,isFormSubmit,isInput) {

        $('#chooseAll').prop('checked',false);

        if($cgStep){
            $('#cgStepValue').val($cgStep.attr('data-cg-step-value'));
        }
        //console.log($('#cgStepsNavigationTop .cg_step.cg_step_selected').first().attr('data-cg-start'));
        //console.log($('#cgStepsNavigationTop .cg_step.cg_step_selected'));
        //debugger

        if($cgStart){
            $('#cgStartValue').val($cgStart.attr('data-cg-start'));
        }else{
            if(!isInput){
                $('#cgStartValue').val($('#cgStepsNavigationTop .cg_step.cg_step_selected').first().attr('data-cg-start'));
            }
        }

        var $cgGallerySubmit = $('#cgGallerySubmit').addClass('cg_hide');
        var $cgSortable = $('#cgSortable').addClass('cg_hide');
        var $cgGalleryLoader = $('#cgGalleryLoader').removeClass('cg_hide');
        var $cgStepsNavigationTop = $('#cgStepsNavigationTop').addClass('cg_hide');
        var $cgStepsNavigationBottom = $('#cgStepsNavigationBottom').addClass('cg_hide');

        if(isFormSubmit){
            $('#cgGalleryFormSubmit').prop('disabled',false);
        }

        var form = document.getElementById('cgGalleryForm');
        var formPostData = new FormData(form);

        // !IMPORTANT!!!! Do not remove otherwise recursion error! needs to check first time new backend ajax version 10.9.9 null null is instaled
        formPostData.append('cgBackendHash',$('#cgBackendHash').val());

        var gid = $('#cgBackendGalleryId').val();

        // BG is for backend gallery
        localStorage.setItem('cgStart_BG_'+gid, $('#cgStartValue').val());
        localStorage.setItem('cgStep_BG_'+gid, $('#cgStepValue').val());
        localStorage.setItem('cgOrder_BG_'+gid, $('#cgOrderSelect').val());
        localStorage.setItem('cgSearch_BG_'+gid, $('#cgSearchInput').val());

        if(isFormSubmit){
            var scrollTop = $('#cgGalleryForm').offset().top-50;
            $(window).scrollTop(scrollTop);
        }

        // AJAX Call - Submit Form
        cgJsClassAdmin.gallery.functions.requests.push($.ajax({
            url: 'admin-ajax.php',
            method: 'post',
            data: formPostData,
            dataType: null,
            contentType: false,
            processData: false
        }).done(function(response) {

            if(cgJsClassAdmin.gallery.functions.missingRights($,response)){return;}
            $('#cgAddFieldsPressedAfterContentModification, #cgAddFieldsPressedAfterContentModificationContent').removeClass('cg_active');
            cgJsClassAdmin.gallery.vars.selectChanged = false;
            cgJsClassAdmin.gallery.vars.inputsChanged = false;

            var htmlDom = new DOMParser().parseFromString(response, 'text/html');

            var DOM_cgSortable = htmlDom.getElementById('cgSortable');
            var DOM_cgGallerySubmit = htmlDom.getElementById('cgGallerySubmit');
            var DOM_cgStepsNavigationTop = htmlDom.getElementById('cgStepsNavigationTop');
            var DOM_cgStepsNavigationBottom = htmlDom.getElementById('cgStepsNavigationBottom');
            var $cgCatWidgetTable = $(htmlDom.getElementById('cgCatWidgetTable'));
            $('#cgCatWidgetTable').replaceWith($cgCatWidgetTable);

            $cgGalleryLoader.addClass('cg_hide');

            $cgStepsNavigationTop.get(0).replaceWith(DOM_cgStepsNavigationTop);
            $(DOM_cgStepsNavigationTop).removeClass('cg_hide');
            $cgSortable.get(0).replaceWith(DOM_cgSortable);
            $(DOM_cgSortable).removeClass('cg_hide');

            var isNoImagesFound = false;

            // new cg sortable has to taken for search!!!
            if($(DOM_cgSortable).find('.cg_backend_info_container').length>=1){
                $cgGallerySubmit.replaceWith(DOM_cgGallerySubmit);
                $(DOM_cgGallerySubmit).removeClass('cg_hide');
                $('#cgViewControl').removeClass('cg_hide');
                $cgSortable.find('#cgNoImagesFound').addClass('cg_hide');
            }else{
                isNoImagesFound = true;
                $(DOM_cgSortable).find('#cgNoImagesFound').removeClass('cg_hide');
                //$(DOM_cgSortable).addClass('cg_hide');
                $('#cgGallerySubmit').addClass('cg_hide');
            }

            if($cgStepsNavigationBottom.length){
                $cgStepsNavigationBottom.get(0).replaceWith(DOM_cgStepsNavigationBottom);
                $(DOM_cgStepsNavigationBottom).removeClass('cg_hide');
            }

            cgJsClassAdmin.gallery.functions.markSearchedValueFields($);

            if(isFormSubmit){
                $("#cg_changes_saved").fadeOut(4000);
            }else{
                $("#cg_changes_saved").remove();
            }

            $('#cgStepsChanged').prop('disabled',true);

            cgJsClassAdmin.gallery.functions.sortableInit($);
            cgJsClassAdmin.gallery.functions.initDateTimePicker($);

            if(isNoImagesFound){
                cgJsClassAdmin.gallery.functions.checkIfFurtherImagesAvailable($);
            }

        }).fail(function(xhr, status, error) {

        }).always(function() {

        }));


    },
    markSearchedValueFields: function ($) {

        var $cgSearchInput = $('#cgSearchInput');
        var cgSearchInputValue = $cgSearchInput.val();
        if(cgSearchInputValue.length>=1){
            $('#cgSearchInputClose').removeClass('cg_hide');
            var cgSearchedValueHiddenFieldsSelector = '#cgSortable .cg_wp_user_display_name,#cgSortable .cg_wp_user_email,#cgSortable .cg_wp_user_nicename,#cgSortable .cg_wp_user_login,' +
                '#cgSortable .cg_wp_post_content, #cgSortable .cg_wp_post_name, #cgSortable .cg_wp_post_title, #cgSortable .cg_image_id,#cgSortable .cg_cookie_id_or_ip';
            var $inputFieldsWithValue = $(cgJsClassAdmin.gallery.vars.cgChangedAndSearchedValueSelector).filter(function () {return $(this).val().toLowerCase().indexOf(cgSearchInputValue.toLowerCase()) != -1; });
            var $inputHiddenFieldsWithValue = $(cgSearchedValueHiddenFieldsSelector).filter(function () {return $(this).val().toLowerCase().indexOf(cgSearchInputValue.toLowerCase()) != -1; });
            $cgSearchInput.addClass('cg_searched_value');
            $inputHiddenFieldsWithValue.closest('.cg_backend_info_container').addClass('cg_searched_value');
            $inputFieldsWithValue.addClass('cg_searched_value');

            var $cgCategorySelects = $('#cgSortable .cg_category_select option').filter(function () { return $(this).html().toLowerCase() === cgSearchInputValue.toLowerCase(); }).closest('.cg_category_select');
            $cgCategorySelects.addClass('cg_searched_value');

            $('#cgStepsNavigationTop .cg_step, #cgStepsNavigationBottom .cg_step').not('.cg_step_selected').addClass('cg_searched_value');
        }

        var $cgOrderSelect = $('#cgOrderSelect');
        var cgOrderSelectValue = $cgOrderSelect.val();
        if(cgOrderSelectValue!='date_desc'){
            $cgOrderSelect.addClass('cg_searched_value');
        }else{
            $cgOrderSelect.removeClass('cg_searched_value');
        }

    },
    missingRights: function($,response){
        if(response.indexOf('MISSINGRIGHTS')>=0){
            response = response.split('MISSINGRIGHTS')[1];
            var htmlDom = $.parseHTML(response);
            $(htmlDom).insertAfter(jQuery('#cgViewControl'));
            $('#cgGalleryLoader').addClass('cg_hide');
            return true;
        }else{
            return false;
        }
    },
   checkIfFurtherImagesAvailable: function($){

        $('#chooseAction1').val(1); //!Important to do it here, otherwise will try to delete pics again!!!
        if($('#cgStepsNavigationTop .cg_step').length){// happens when images in last step were deleted!!!
            $('#cgStepsNavigationTop .cg_step:last-child').click();
        }

    },
    initDateTimePicker: function($) {

        $(".cg_input_date_class").datepicker({
            beforeShow: function(input, inst) {
                $('#ui-datepicker-div').addClass('cg_admin_images_area_form');
                //$('#ui-datepicker-div').addClass($('#cg_fe_controls_style_user_upload_form_shortcode').val()); no style check in the moment
                $('#ui-datepicker-div.cg_upload_form_container .ui-datepicker-next').attr('title','');
            },
            changeMonth: true,
            changeYear: true,
            monthNames: ["01","02","03","04","05","06","07","08","09","10","11","12"],
            monthNamesShort: ["01","02","03","04","05","06","07","08","09","10","11","12"],
            yearRange: "-100:+100",
            //   option: {dateFormat:"dd.mm.yy"}
        });

        $( ".cg_input_date_class" ).each(function () {

            var cgDateFormat =  $(this).closest('.cg_image_title_container').find('.cg_date_format').val().toLowerCase().replace('yyyy','yy');
            var value = $( this ).val();
            // have to be done in extra row here
            $( this ).datepicker("option", "dateFormat", cgDateFormat);
            $( this ).val(value);// value has to be set again after format is set!

        });

        $( "#ui-datepicker-div" ).hide();

    },
    sortableInit: function($) {

        //Sortieren der Galerie

        var $i = 0;

        var rowid = [];

        if($i==0){

            $( ".cgSortableDiv" ).each(function( i ) {

                var rowidValue =  $(this).find('.rowId').val();


                rowid.push(rowidValue);

            });

            $i++;

        }
        $(function() {
            $( "#cgSortable" ).sortable({cursor: "move",handle:'.cg_drag_area',placeholder: "ui-state-highlight",
                stop: function( event, ui ) {

                    if(document.readyState === "complete"){

                        var v = 0;

                        $( ".cgSortableDiv" ).each(function( i ) {


                            $(this).find('.rowId').val(rowid[v]).addClass('cg_value_changed');


                            v++;


                        });

                        v = 0;

                    }

                },
                start: function( event, ui){

                    var $element = $(ui.item);

                    $element.closest('#cgSortable').find('.ui-state-highlight').addClass($element.get(0).classList.value).html($element.html());

                }
            });
        });

    }
};
