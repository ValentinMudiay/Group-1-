cgJsClassAdmin.createUpload.vars = {
    isChecked: 0,
    cgRecaptchaIconUrl: null,
    cgDragIcon: null,
    countChildren: 0
};
cgJsClassAdmin.createUpload.functions = {
    load: function ($, $formLinkObject, $response) {

        cgJsClassAdmin.createUpload.vars.cgRecaptchaIconUrl = $("#cgRecaptchaIconUrl").val();

        cgJsClassAdmin.createUpload.vars.cgDragIcon = $("#cgDragIcon").val();

        cgJsClassAdmin.index.functions.setEditors($, $response.find('#ausgabe1.cg_create_upload .cg-wp-editor-template'));

        $('#ausgabe1.cg_create_upload .switch-tmce:visible').click();// !IMPORTANT: click only unvisible otherwise breaks functionality of further elements

     //  $("#cg_changes_saved").fadeOut(4000);

        $("#ausgabe1.cg_create_upload").sortable({
            placeholder: "ui-state-highlight",
            handle: ".cg_drag_area",
            cursor: "move",
            htmlClone: null,
            start: function (event, ui) {

                var $element = $(ui.item);

                // condition for html fields. Deactivate by start first and reinitinalize by stop again later
                var $cgWpEditorContainer = $element.find('.cg-wp-editor-container');
                if ($cgWpEditorContainer.length) {

                    if(cgJsClassAdmin.index.vars.wpVersion>=cgJsClassAdmin.index.vars.wpVersionForTinyMCE){
                        tinymce.EditorManager.execCommand('mceRemoveEditor', true, $cgWpEditorContainer.attr('data-wp-editor-id'));
                    }

                }
                // condition for html fields. Deactivate by start first and reinitinalize by stop again later --- END

                $element.closest('#ausgabe1.cg_create_upload').find('.ui-state-highlight').addClass($element.get(0).classList.value).html($element.html());

                //    $('#60').find('#cgCheckAgreementHtml').addClass('cg_hide');
                //  tinymce.execCommand('mceRemoveEditor', true, '#htmlField50');
                // tinymce.EditorManager.execCommand('mceRemoveControl',true, 'htmlField50');

            },
            stop: function (event, ui) {

                var $element = $(ui.item);

                //  if(ui.item.hasClass('htmlField')){
                //console.log('stop html');
                //cgJsClassAdmin.createUpload.tinymce.copyPasteTinymceIframeContent();
                //}
                //  $('#60').find('#cgCheckAgreementHtml').removeClass('cg_hide');

                //    tinymce.get('htmlField55').setContent('...content here...');

                //  tinymce.execCommand('mceAddEditor', true, '#htmlField50');

                // condition for html fields. Reinitialize after deactivating when start
                var $cgWpEditorContainer = $element.find('.cg-wp-editor-container');
                if ($cgWpEditorContainer.length) {
                    if(cgJsClassAdmin.index.vars.wpVersion>=cgJsClassAdmin.index.vars.wpVersionForTinyMCE){
                        tinymce.EditorManager.execCommand('mceAddEditor', true, $cgWpEditorContainer.attr('data-wp-editor-id'));
                    }
                }
                // condition for html fields. Reinitialize after deactivating when start--- END

                setTimeout(function () {
                    cgJsClassAdmin.createUpload.functions.addRightFieldOrder($);
                },10);

            }


        });


        cgJsClassAdmin.createUpload.vars.isChecked = 0;

        $("#ausgabe1.cg_create_upload .Use_as_URL").each(function () {

            if ($(this).is(":checked")) {
                cgJsClassAdmin.createUpload.vars.isChecked = 1;
            }

        });


        // Use as url for images --- ENDE


        // Show info in gallery

        cgJsClassAdmin.createUpload.vars.isChecked = 0;

        $("#ausgabe1.cg_create_upload .cg_info_show_gallery").each(function () {

            if ($(this).is(":checked")) {
                cgJsClassAdmin.createUpload.vars.isChecked = 1;
            }

        });

        // Show tag in gallery

        cgJsClassAdmin.createUpload.vars.isChecked = 0;

        $("#ausgabe1.cg_create_upload .cg_tag_show_gallery").each(function () {

            if ($(this).is(":checked")) {
                cgJsClassAdmin.createUpload.vars.isChecked = 1;
            }

        });


        $("#ausgabe1.cg_create_upload .cg-active input[type=\"checkbox\"]").each(function () {
            if ($(this).prop('checked') == true) {
                $(this).closest('.formField').addClass('cg_disable');
            }
            else {
                $(this).closest('.formField').removeClass('cg_disable');
            }
        });

        // Bestimmung der Anzahl der existierenden Div Felder in #ausgabe1.cg_create_upload zur Bestiummung der Feldnummer in der Datenbank


        cgJsClassAdmin.createUpload.vars.countChildren = $('#ausgabe1.cg_create_upload').find('.formField').length;

        if ($('#ausgabe1.cg_create_upload .cg_categories_arena').length >= 1) {
            var cg_categories_arena = $('#ausgabe1.cg_create_upload .cg_categories_arena');
            cg_categories_arena.find('.cg_category_field_div').find('.cg_category_change_order').removeClass('cg_hide');
            cg_categories_arena.find('.cg_category_field_div').first().find('.cg_move_view_to_top').addClass('cg_hide');
            if (cg_categories_arena.find('.cg_category_field_div').length >= 2) {
                cg_categories_arena.find('.cg_category_field_div').last().find('.cg_move_view_to_bottom').addClass('cg_hide');
            }
        }

    },
    addRightFieldOrder: function ($) {

        var v = 1;
//var total = $('.formField').length;

        $("#ausgabe1.cg_create_upload .formField").each(function (i) {


            //$(this).find('.fieldnumber').val(v);
            $(this).find('.fieldOrder').val(v);
            //$(this).find('.changeFieldOrderUsersEntries').val(v);

            // alert(v);

            v++;

        });

        v = 0;


    },
    fDeleteFieldAndData: function ($,arg, arg1, categoryField) {

        $("#" + arg).remove();
        if (categoryField) {
            $("#ausgabe1.cg_create_upload").append("<input type='hidden' name='deleteFieldnumber[deleteCategoryFields]' value=" + arg1 + ">");
        }
        else {
            $("#ausgabe1.cg_create_upload").append("<input type='hidden' name='deleteFieldnumber' value=" + arg1 + ">");
        }

        this.addRightFieldOrder($);

        $('#submitForm').click();

    },
    goToField: function ($) {
        $("html, body").animate({ scrollTop: $('#dauswahl').offset().top }, 0);
    }
};