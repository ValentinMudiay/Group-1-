cgJsClassAdmin.createRegistry.vars = {
    isChecked: 0,
    cgRecaptchaIconUrl: null,
    cgDragIcon: null,
    countChildren: 0
};

cgJsClassAdmin.createRegistry.functions = {
    load: function ($, $formLinkObject, $response) {

        cgJsClassAdmin.index.functions.setEditors($, $response.find('#ausgabe1.cg_registry_form_container .cg-wp-editor-template'));

        cgJsClassAdmin.createRegistry.functions.cgCheckHideField($);

        cgJsClassAdmin.createRegistry.vars.cgDragIcon = $("#cgDragIcon").val();

        cgJsClassAdmin.createRegistry.vars.cgRecaptchaIconUrl = $("#cgRecaptchaIconUrl").val();

        $("#ausgabe1.cg_registry_form_container .cg-active input[type=\"checkbox\"]").each(function () {
            if ($(this).prop('checked') == true) {
                $(this).closest('.formField').addClass('cg_disable');
            }
            else {
                $(this).closest('.formField').removeClass('cg_disable');
            }
        });

        $("#cg_changes_saved").fadeOut(3000);


        $(function () {

            $("#ausgabe1.cg_registry_form_container").sortable({
                handle: ".cg_drag_area",
                cursor: "move", placeholder: "ui-state-highlight",
                start: function (event, ui) {

                    var $element = $(ui.item);

                    // condition for html fields. Deactivate by start first and reinitinalize by stop again later
                    var $cgWpEditorContainer = $element.find('.cg-wp-editor-template');
                    if ($cgWpEditorContainer.length) {
                        if(cgJsClassAdmin.index.vars.wpVersion>=cgJsClassAdmin.index.vars.wpVersionForTinyMCE){
                            tinymce.EditorManager.execCommand('mceRemoveEditor', true, $cgWpEditorContainer.attr('id'));
                        }
                    }
                    // condition for html fields. Deactivate by start first and reinitinalize by stop again later --- END

                    $element.closest('#ausgabe1').find('.ui-state-highlight').addClass($element.get(0).classList.value).html($element.html());

                },
                stop: function (event, ui) {

                    var $element = $(ui.item);

                    // condition for html fields. Reinitialize after deactivating when start
                    var $cgWpEditorTemplate = $element.find('.cg-wp-editor-template');
                    if ($cgWpEditorTemplate.length) {
                        if(cgJsClassAdmin.index.vars.wpVersion>=cgJsClassAdmin.index.vars.wpVersionForTinyMCE){
                            tinymce.EditorManager.execCommand('mceAddEditor', true, $cgWpEditorTemplate.attr('id'));
                        }
                    }
                    // condition for html fields. Reinitialize after deactivating when start--- END

                   // if (document.readyState === "complete") {
                    setTimeout(function () {
                        cgJsClassAdmin.createRegistry.functions.cgSortOrder($);
                        cgJsClassAdmin.createRegistry.functions.cgCheckHideField($);
                    },10);

                   // }

                }
            });


        });



        // Use as url for images

        cgJsClassAdmin.createRegistry.vars.isChecked = 0;

        $("#ausgabe1.cg_registry_form_container .Use_as_URL").each(function () {

            if ($(this).is(":checked")) {
                isChecked = 1;
            }

        });

        // Show info in gallery

        cgJsClassAdmin.createRegistry.vars.isChecked = 0;

        $("#ausgabe1.cg_registry_form_container .cg_info_show_gallery").each(function () {

            if ($(this).is(":checked")) {
                isChecked = 1;
            }

        });

        setTimeout(function () {
            // !IMPORTANT: Do it here when document ready!
            $('#ausgabe1.cg_registry_form_container .switch-tmce:visible').click();// !IMPORTANT: click only unvisible otherwise breaks functionality of further elements
        },10);

    },
    cgSortOrder: function ($) {

        var v = 0;

        $("#ausgabe1.cg_registry_form_container .formField").each(function (i) {

            v++;

            //$(this).find('.fieldnumber').val(v);
            $(this).find('.Field_Type').attr("name", "Field_Type[" + v + "]");
            $(this).find('.Field_Order').attr("name", "Field_Order[" + v + "]");
            $(this).find('.Field_Name').attr("name", "Field_Name[" + v + "]");
            $(this).find('.Field_Id').attr("name", "Field_Id[" + v + "]");
            $(this).find('.cg_actualID').attr("name", "actualID[" + v + "]");
            $(this).find('.Field_Content').attr("name", "Field_Content[" + v + "]");
            $(this).find('.Min_Char').attr("name", "Min_Char[" + v + "]");
            $(this).find('.Max_Char').attr("name", "Max_Char[" + v + "]");
            $(this).find('.necessary-check').attr("name", "Necessary[" + v + "]");
            $(this).find('.necessary-hidden').attr("name", "Necessary[" + v + "]");


            //$(this).find('.changeFieldOrderUsersEntries').val(v);

            // alert(v);

        });

        v = 0;

    },
    fDeleteFieldAndData: function ($, arg, arg1) {

        $("#" + arg + "").remove();
        $("#ausgabe1.cg_registry_form_container").append("<input type='hidden' name='deleteFieldnumber' value=" + arg1 + ">");

        this.cgSortOrder($);

        $('#submitForm').click();

    },
    cgCheckHideField: function ($) {

        if ($('#ausgabe1.cg_registry_form_container .cg-active input[type="checkbox"]').length >= 1) {
            $('#ausgabe1.cg_registry_form_container .cg-active input[type="checkbox"]').each(function (index) {

                var order = index + 1;
                $(this).attr('name', 'hide[' + order + ']');

            });
        }

    },
    goToField: function ($) {
        $("html, body").animate({ scrollTop: $('#dauswahl').offset().top }, 0);
    }
};