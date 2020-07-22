// !!! Nicht löschen Basis klasse für cgJsClassAdmin.createUpload.tinymce
var cgJsClassAdmin = cgJsClassAdmin || {};
cgJsClassAdmin.createUpload = {};

jQuery(document).ready(function ($) {

    $(document).on('click', '#ausgabe1.cg_create_upload .cg_recaptcha_icon', function () {

        $(this).closest('.formField').find('.cg_reca_key').val($('#cgRecaptchaKey').val());

    });

    // Allow only to press numbers as keys in input boxes

    //called when key is pressed in textbox
    $(document).on('keypress', "#ausgabe1.cg_create_upload .Max_Char, .Min_Char", function (e) {
            //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //$("#cg_options_errmsg").html("Only numbers are allowed").show().fadeOut("slow");
            return false;
        }
    });

// Allow only to press numbers as keys in input boxes --- END

    // Use as url for images

    $(document).on('click', '#ausgabe1.cg_create_upload .Use_as_URL', function (e) {
        //	$(".cg_info_show_gallery").click(function(){

        if ($(this).is(":checked") && cgJsClassAdmin.createUpload.vars.isChecked == 1) {
            cgJsClassAdmin.createUpload.vars.isChecked = 0;
        }


        if (cgJsClassAdmin.createUpload.vars.isChecked == 1) {
            $(this).prop("checked", false);
            cgJsClassAdmin.createUpload.vars.isChecked = 0;
        } else {
            
            $(".Use_as_URL").each(function () {

                $(".Use_as_URL").prop("checked", false);

            });

            $(this).prop("checked", true);

            cgJsClassAdmin.createUpload.vars.isChecked = 1;

        }


    });


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_info_show_gallery', function (e) {

        if ($(this).is(":checked") && cgJsClassAdmin.createUpload.vars.isChecked == 1) {
            cgJsClassAdmin.createUpload.vars.isChecked = 0;
        }


        if (cgJsClassAdmin.createUpload.vars.isChecked == 1) {


            $(this).prop("checked", false);
            cgJsClassAdmin.createUpload.vars.isChecked = 0;
        }

        else {
            $(".cg_info_show_gallery").each(function () {

                $(".cg_info_show_gallery").prop("checked", false);

            });

            $(this).prop("checked", true);


            cgJsClassAdmin.createUpload.vars.isChecked = 1;

        }

    });


    // Show info in gallery -- ENDE


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_tag_show_gallery', function (e) {

        if ($(this).is(":checked") && cgJsClassAdmin.createUpload.vars.isChecked == 1) {
            cgJsClassAdmin.createUpload.vars.isChecked = 0;
        }

        if (cgJsClassAdmin.createUpload.vars.isChecked == 1) {

            $(this).prop("checked", false);
            cgJsClassAdmin.createUpload.vars.isChecked = 0;
        }


        else {
            $(".cg_tag_show_gallery").each(function () {

                $(".cg_tag_show_gallery").prop("checked", false);

            });

            $(this).prop("checked", true);


            cgJsClassAdmin.createUpload.vars.isChecked = 1;

        }

    });


    // Show tag in gallery -- ENDE

    $(document).on('click', "#ausgabe1.cg_create_upload .cg-active input[type=\"checkbox\"] ", function () {
        if ($(this).prop('checked') == true) {
            $(this).closest('.formField').addClass('cg_disable');
        }
        else {
            $(this).closest('.formField').removeClass('cg_disable');
        }
    });


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_delete_form_field', function (e) {

//var del = arg;
//var del1 = arg1;

        var del = $(this).attr("alt");
        var del1 = $(this).attr("titel");

        var categoryField = false;

        if ($(this).closest('.formField').hasClass('selectCategoriesField')) {
            categoryField = true;
        }

        var infoDeleteText = "";

        if ($(this).closest('.htmlField').length >= 1 || $(this).closest('.captchaRoField').length >= 1 || $(this).closest('.captchaRoReField').length >= 1) {
            infoDeleteText = "";
        }
        else {
            if ($(this).attr('data-field-type')) {

                if ($(this).attr('data-field-type') == 'fbt') {
                    infoDeleteText = "All Contest Gallery user information connected to this field will be deleted. Facebook share button image titles will be not deleted.";
                } else if ($(this).attr('data-field-type') == 'fbd') {
                    infoDeleteText = "All Contest Gallery user information connected to this field will be deleted. Facebook share button image descriptions will be not deleted.";
                } else {
                    infoDeleteText = "All Contest Gallery user information connected to this field will be deleted.";
                }

            } else {
                infoDeleteText = "All Contest Gallery user information connected to this field will be deleted.";
            }
        }


        if (confirm("Delete field? " + infoDeleteText + "")) {
            // alert("Clicked Ok");
            //confirmForm();
            cgJsClassAdmin.createUpload.functions.fDeleteFieldAndData($,del, del1, categoryField);
            return true;
        } else {
            var test = $("#" + del).find('.fieldValue').val();

            return false;
        }


    });


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_delete_form_field_new', function (e) {

        var arg = $(this).attr("alt");

        if ($(this).hasClass('deleteHTMLfield')) {
            $(this).closest('.formField').css('display', 'none').appendTo('#cgTinymceCollection');
        }
        else {
            $("#" + arg).remove();
        }


    });


// Delete field only --- ENDE


    // Bestimmung der Anzahl der existierenden Div Felder in #ausgabe1.cg_create_upload zur Bestiummung der Feldnummer in der Datenbank  ---- ENDE

// Check Box

// 1 = Feldtyp
// 2 = Feldreihenfolge
// 3 = Feldname
// 4 = Feldinhalt
// 5 = Felderfordernis


    $(document).on('change', "#dauswahl.cg_upload_dauswahl", function () {

        if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
            $(this).css('background-color', '#95ff79');
            $(this).find('option').not('cg-pro-false').css('background-color', '#fff');
            $(this).find('optgroup').css('background-color', '#fff');
        } else {
            $(this).css('background-color', '#fff');

        }

    });

    $(document).on('click', "#cg_create_upload_add_field.cg_upload_dauswahl", function () {

        var cg_info_show_slider_title = 'Show as info in single view';
        var cg_info_show_gallery_title = 'Show as title in gallery (only 1 allowed)';
        var cg_tag_show_gallery_title = 'Show as HTML title attribute in gallery (only 1 allowed)';

        // User Fields here

        if ($('#dauswahl').val() == "cb") {// CHECK AGREEMENT!!!!!!!

            if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
                alert('Only available in PRO version');
                return;
            }

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var cbCount = 60 + $('.checkAgreementField').length;
            var cbHiddenCount = 600 + $('.checkAgreementField').length;

            //alert(nfCount);

            if ($('.checkAgreementField').length == 10) {
                alert("This field can be produced maximum 10 times");
            }
            else {

                var editor_id = 'htmlFieldTemplateForAgreement'+cbCount;

                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + cbCount + "' class='formField checkAgreementField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +
                    "<input type='hidden' name='upload[-" + cbCount + "][type]' value='cb'>" +
                    "<input type='hidden' name='upload[-" + cbCount + "][new]' value='cb'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + cbCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='nf' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder' >"+// Feldreihenfolge
                    "<strong>Check agreement </strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + cbCount + "][title]' value='Check agreement' maxlength='100' size='30'>" +
                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + cbCount + "' ><br></div>" +


                    "<div class='cgCheckAgreementContainer'><div class='cgCheckAgreementCheckbox'><input type='checkbox' disabled ></div>" +
                    //"<input type='text' name='upload[-"+cbCount+"][content]' placeholder='HTML tags allowed'  maxlength='1000' style='width:832px;'>"+
                    "<div class='cgCheckAgreementHtml cg-wp-editor-container' data-wp-editor-id='" + editor_id + "'></div></div>" +

                    "<br><br>Required <input type='checkbox' class='necessary-check' name='upload[-" + cbCount + "][required]' checked >" +
                    /*	"<input type='hidden' name='upload[-"+cbCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<br><span class='cg-active'>Hide <input type='checkbox' name='upload[-" + cbCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                //var idToAppend = $htmlEditorTemplateDivToAppend.attr('id');

                var $element = $("#" + cbCount);

                $element.find('.cg-wp-editor-container').append($('<textarea class="cg-wp-editor-template" name="upload[-'+cbCount+'][content]" id="'+editor_id+'" ></textarea>'));

                cgJsClassAdmin.index.functions.initializeEditor(editor_id);

                // location.href = "#"+cbCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);

            }

        }

        // TEXT FIELD!!!!!
        if ($('#dauswahl').val() == "nf") {

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var nfCount = 10 + $('.inputField').length;
            var nfHiddenCount = 100 + $('.inputField').length;

            //alert(nfCount);

            if ($('.inputField').length == 20) {
                alert("This field can be produced maximum 20 times");
            }
            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + nfCount + "' class='formField inputField' >" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +

                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + nfCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + nfCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + nfCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +


                    "<input type='hidden' name='upload[-" + nfCount + "][type]' value='nf'>" +
                    "<input type='hidden' name='upload[-" + nfCount + "][new]' value='nf'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + nfCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='nf' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Input</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + nfCount + "][title]' value='Title' maxlength='100' size='30'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + nfCount + "'><br/></div>" +
                    "<input type='text' name='upload[-" + nfCount + "][content]' placeholder='Placeholder'  maxlength='1000' value='' style='width:855px;'><br/>" +
                    "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[-" + nfCount + "][min-char]' value='3' size='7' maxlength='4' value=' '><br/>" +
                    "Max. number of characters: <input type='text' class='Max_Char' name='upload[-" + nfCount + "][max-char]' value='100' size='7' maxlength='4' value=' '><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + nfCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+nfCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + nfCount + "][hide]'></span>" +
                    "<br/></div></div></div>").addClass('cg_blink'));

                //location.href = "#"+nfCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);


            }

            //alert(nfCount);
            /*
            $('html, body').animate({
            scrollTop: $("#'"+nfCount+"'").offset().top
            }, 400);
            $("html, body").animate({ scrollTop: $("#12").scrollTop() }, 1000);*/

        }
        // TEXT FIELD!!!!!
        if ($('#dauswahl').val() == "dt") {

            if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
                alert('Only available in PRO version');
                return;
            }

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var dtCount = 10 + $('.inputField').length;
            var dtHiddenCount = 100 + $('.inputField').length;

            //alert(nfCount);

            if ($('.dateTimeField').length == 10) {
                alert("This field can be produced maximum 10 times");
            }
            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + dtCount + "' class='formField dateTimeField' >" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +

                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + dtCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + dtCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + dtCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +


                    "<input type='hidden' name='upload[-" + dtCount + "][type]' value='dt'>" +
                    "<input type='hidden' name='upload[-" + dtCount + "][new]' value='dt'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + dtCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='dt' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+dtCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+dtCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Date</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + dtCount + "][title]' value='Picture date' maxlength='100' size='30'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + dtCount + "'><br/></div>" +
                    "Format:&nbsp; <select name='upload[-" + dtCount + "][format]'>" +
                    "<option value='YYYY-MM-DD'>YYYY-MM-DD</option>" +
                    "<option value='DD-MM-YYYY'>DD-MM-YYYY</option>" +
                    "<option value='MM-DD-YYYY'>MM-DD-YYYY</option>" +
                    "<option value='YYYY/MM/DD'>YYYY/MM/DD</option>" +
                    "<option value='DD/MM/YYYY'>DD/MM/YYYY</option>" +
                    "<option value='MM/DD/YYYY'>MM/DD/YYYY</option>" +
                    "<option value='YYYY.MM.DD'>YYYY.MM.DD</option>" +
                    "<option value='DD.MM.YYYY'>DD.MM.YYYY</option>" +
                    "<option value='MM.DD.YYYY'>MM.DD.YYYY</option>" +
                    "</select><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + dtCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+dtCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + dtCount + "][hide]'></span>" +
                    "<br/></div></div></div>").addClass('cg_blink'));

                //location.href = "#"+dtCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);

            }

            //alert(nfCount);
            /*
            $('html, body').animate({
            scrollTop: $("#'"+nfCount+"'").offset().top
            }, 400);
            $("html, body").animate({ scrollTop: $("#12").scrollTop() }, 1000);*/

        }

        // TEXT FIELD!!!!!
        if ($('#dauswahl').val() == "fbt") {

            if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
                alert('Only available in PRO version');
                return;
            }

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var fbtCount = 10 + $('.inputField').length;
            var fbtHiddenCount = 100 + $('.inputField').length;

            //alert(nfCount);

            if ($('.inputField').length == 20) {
                alert("This field can be produced maximum 20 times");
            }
            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + fbtCount + "' class='formField inputField' >" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +

                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + fbtCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + fbtCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + fbtCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +


                    "<input type='hidden' name='upload[-" + fbtCount + "][type]' value='fbt'>" +
                    "<input type='hidden' name='upload[-" + fbtCount + "][new]' value='fbt'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + fbtCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='fbt' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Facebook share button title</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + fbtCount + "][title]' value='Title' maxlength='100' size='30'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + fbtCount + "'><br/></div>" +
                    "<input type='text' name='upload[-" + fbtCount + "][content]' placeholder='Placeholder'  maxlength='1000' value='' style='width:855px;'><br/>" +
                    "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[-" + fbtCount + "][min-char]' value='3' size='7' maxlength='4' value=' '><br/>" +
                    "Max. number of characters: <input type='text' class='Max_Char' name='upload[-" + fbtCount + "][max-char]' value='100' size='7' maxlength='4' value=' '><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + fbtCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+nfCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + fbtCount + "][hide]'></span>" +
                    "<br/></div></div></div>").addClass('cg_blink'));

                //location.href = "#"+nfCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);


            }

            //alert(nfCount);
            /*
            $('html, body').animate({
            scrollTop: $("#'"+nfCount+"'").offset().top
            }, 400);
            $("html, body").animate({ scrollTop: $("#12").scrollTop() }, 1000);*/

        }


        if ($('#dauswahl').val() == "url") {

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var urlCount = 100 + $('.inputField').length;
            var urlHiddenCount = 1000 + $('.inputField').length;

            //alert(nfCount);

            if ($('.inputField').length == 20) {
                alert("This field can be produced maximum 10 times");
            }
            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + urlCount + "' class='formField inputField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +

                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + urlCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + urlCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + urlCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +

                    "<input type='hidden' name='upload[-" + urlCount + "][type]' value='url'>" +
                    "<input type='hidden' name='upload[-" + urlCount + "][new]' value='url'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + urlCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='url' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+urlCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+urlCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>URL</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + urlCount + "][title]' value='Homepage' maxlength='100' size='30'>" +


                    // Das Feld soll als URL agieren
                    /*	"<div style='width:210px;float:right;text-align:right;margin-right:10px;'>Use this field as images url: &nbsp;"+
                        "<input type='checkbox' class='Use_as_URL' style='margin-top:0px;' name='Use_as_URL["+urlCount+"]'>"+
                        "</div>"+*/
                    // Das Feld soll als URL agieren --- ENDE


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + urlCount + "'><br/></div>" +
                    "<input type='text' name='upload[-" + urlCount + "][content]' placeholder='www.example.com'  maxlength='1000' value='' style='width:855px;'><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + urlCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+urlCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + urlCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                //     location.href = "#"+urlCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);


            }

            //alert(nfCount);
            /*
            $('html, body').animate({
            scrollTop: $("#'"+nfCount+"'").offset().top
            }, 400);
            $("html, body").animate({ scrollTop: $("#12").scrollTop() }, 1000);*/


        }


        if ($('#dauswahl').val() == "kf") {

            cgJsClassAdmin.createUpload.vars.countChildren++;

            var kfCount = 20 + $('.textareaField').length;
            var kfHiddenCount = 200 + $('.textareaField').length;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);


            if ($('.textareaField').length == 10) {
                alert("This field can be produced maximum 10 times");
            }


            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + kfCount + "' class='formField textareaField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +

                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + kfCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + kfCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + kfCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +

                    "<input type='hidden' name='upload[-" + kfCount + "][type]' value='kf'>" +
                    "<input type='hidden' name='upload[-" + kfCount + "][new]' value='kf'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + kfCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='kf' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+kfCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+kfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Textarea</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + kfCount + "][title]' size='30' maxlength='100' value='Description'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + kfCount + "'><br/></div>" +
                    "<textarea name='upload[-" + kfCount + "][content]' maxlength='10000' rows='10' value='' style='width:857px;' placeholder='Placeholder' ></textarea><br/>" +
                    "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[-" + kfCount + "][min-char]' value='3' size='7' maxlength='4' value=' '><br/>" +
                    "Max. number of characters: <input type='text' class='Max_Char' name='upload[-" + kfCount + "][max-char]' value='1000' size='7' maxlength='4' value=' '><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + kfCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+kfCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + kfCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                //location.href = "#"+kfCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);

            }


        }


        if ($('#dauswahl').val() == "fbd") {

            if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
                alert('Only available in PRO version');
                return;
            }

            cgJsClassAdmin.createUpload.vars.countChildren++;

            var fbdCount = 20 + $('.textareaField').length;
            var fbdHiddenCount = 200 + $('.textareaField').length;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);


            if ($('.textareaField').length == 10) {
                alert("This field can be produced maximum 10 times");
            }


            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + fbdCount + "' class='formField textareaField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +

                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + fbdCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + fbdCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + fbdCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +

                    "<input type='hidden' name='upload[-" + fbdCount + "][type]' value='fbd'>" +
                    "<input type='hidden' name='upload[-" + fbdCount + "][new]' value='fbd'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + fbdCount + "][order]' value=''>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='fbd' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+fbdCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+fbdCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Facebook share button description</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + fbdCount + "][title]' size='30' maxlength='100' value='Description'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + fbdCount + "'><br/></div>" +
                    "<textarea name='upload[-" + fbdCount + "][content]' maxlength='10000' rows='10' value='' style='width:857px;' placeholder='Placeholder' ></textarea><br/>" +
                    "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[-" + fbdCount + "][min-char]' value='3' size='7' maxlength='4' value=' '><br/>" +
                    "Max. number of characters: <input type='text' class='Max_Char' name='upload[-" + fbdCount + "][max-char]' value='1000' size='7' maxlength='4' value=' '><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + fbdCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+fbdCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + fbdCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                //location.href = "#"+fbdCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);


            }


        }


        var seCount = 70 + $('.selectField').length;
        var seHiddenCount = 700 + $('.selectField').length;

        if ($('#dauswahl').val() == "se") {

            cgJsClassAdmin.createUpload.vars.countChildren++;

            if ($('.selectField').length == 10) {
                alert("This field can be produced maximum 10 times");
            }

            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + seCount + "' class='formField selectField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + seCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + seCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + seCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +

                    "<input type='hidden' name='upload[-" + seCount + "][type]' value='se'>" +
                    "<input type='hidden' name='upload[-" + seCount + "][new]' value='se'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + seCount + "][order]' value=''>" +

                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='se' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Select</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + seCount + "][title]' size='30' maxlength='100' value='Select' placeholder='Title of your select box'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + seCount + "'><br/></div>" +
                    "<textarea name='upload[-" + seCount + "][content]' maxlength='10000' rows='10' value='' style='width:857px;' placeholder='Each row one value - Example: &#10;value1&#10;value2&#10;value3&#10;value4&#10;value5&#10;value6' ></textarea><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + seCount + "][required]' >" +
                    /*	"<input type='hidden' name='upload[-"+seCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + seCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                //  location.href = "#"+seCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);

            }


        }

        var secCount = 90 + $('.selectField').length;
        var secHiddenCount = 900 + $('.selectField').length;

        if ($('#dauswahl').val() == "sec") {

            cgJsClassAdmin.createUpload.vars.countChildren++;

            if ($('.selectCategoriesField').length == 1) {
                alert("This field can be produced maximum 1 time");
            }

            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + secCount + "' class='formField selectCategoriesField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +

                    "<div class='cg_info_show_slider_container'>" + cg_info_show_slider_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[-" + secCount + "][infoInSlider]' $checked>" +
                    "</div>" +

                    "<div class='cg_info_show_gallery_container'>" + cg_info_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[-" + secCount + "][infoInGallery]'>" +
                    "</div>" +

                    "<div class='cg_tag_show_gallery_container'>" + cg_tag_show_gallery_title + ": &nbsp;" +
                    "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[-" + secCount + "][tagInGallery]'>" +
                    "</div>" +
                    "<br>" +
                    "<hr>" +
                    '<div style="padding-top: 7px;text-align: center;padding-bottom: 6px;">Note: you can control which categories should be displayed in backend images area of this gallery</div>' +
                    "<input type='hidden' name='upload[-" + secCount + "][type]' value='sec'>" +
                    "<input type='hidden' name='upload[-" + secCount + "][new]' value='sec'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + secCount + "][order]' value=''>" +

                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='sec' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Select Categories</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input class='cg_add_category cg_backend_button_gallery_action' type='button' value='Add Category' ><input type='text' name='upload[-" + secCount + "][title]' size='30' maxlength='100' value='Category' placeholder='Title of your select category box'>" +


                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + secCount + "'><br/></div>" +
                    //"<textarea name='upload[-"+nfCount+"][type]' maxlength='10000' rows='10' value='' style='width:857px;' placeholder='Each row one value - Example: &#10;value1&#10;value2&#10;value3&#10;value4&#10;value5&#10;value6' ></textarea><br/>"+
                    "<br/><div class='cg_categories_arena'></div>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + secCount + "][required]' >" +
                    /*              "<input type='hidden' name='upload[-"+secCount+"][required]' class='necessary-hidden' value='on' >" +*/
                    "<input type='hidden' name='createNewCategories' value='true'>" +
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + secCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                // location.href = "#"+secCount+"";
                cgJsClassAdmin.createUpload.functions.goToField($);

            }


        }

        if ($('#dauswahl').val() == "ef") {

            if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
                alert('Only available in PRO version');
                return;
            }

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var efCount = 30 + $('.emailField').length;
            var efHiddenCount = 300 + $('.emailField').length;

            //alert(nfCount);

            if ($('.emailField').length == 1) {
                alert("This field can be produced only 1 time");
            }
            else {
                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + efCount + "' class='formField emailField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +
                    "<input type='hidden' name='upload[-" + efCount + "][type]' value='ef'>" +
                    "<input type='hidden' name='upload[-" + efCount + "][new]' value='ef'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + efCount + "][order]' value=''>" +

                    "<div style='margin-bottom:5px;'><b>Note:</b> Do not appear if user is registered and logged in<br><br><strong>E-Mail </strong></div>" +
                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='ef' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+efCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' class='changeUploadFieldOrder'>"+
                    //"<input type='hidden' name='upload[-"+nfCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30'>"+// Feldreihenfolge
                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + efCount + "][title]' value='E-Mail' maxlength='100' size='30'>" +


                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + efCount + "'><br/></div>" +
                    "<input type='text' name='upload[-" + efCount + "][content]' value='' maxlength='100' placeholder='Placeholder'  style='width:855px;'><br/>" +
                    "<br>Required <input type='checkbox' class='necessary-check' name='upload[-" + efCount + "][required]' >" +
                    "<input type='hidden' name='upload[-" + efCount + "][required]' class='necessary-hidden' >" +
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + efCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                // location.href = "#" + efCount + "";
                cgJsClassAdmin.createUpload.functions.goToField($);

            }


        }

        if ($('#dauswahl').val() == "ht") {

            if ($('select[name="dauswahl"] :selected').hasClass('cg-pro-false')) {
                alert('Only available in PRO version');
                return;
            }

            // 1 = Feldtyp
            // 2 = Feldtitel
            // 3 = Feldinhalt

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var htCount = 50 + $('.htmlField').length;
            var htHiddenCount = 500 + $('.htmlField').length;

            //alert(nfCount);

            if ($('.htmlField').length >= 10) {
                alert("This field can be produced maximum 10 times");
            }
            else {

                var editor_id = 'htmlFieldTemplate'+htCount;

                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + htCount + "' class='formField cg_ht_field htmlField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +
                    "<input type='hidden' name='upload[-" + htCount + "][type]' value='ht'>" +
                    "<input type='hidden' name='upload[-" + htCount + "][new]' value='ht'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + htCount + "][order]' value=''>" +

                    "<strong>HTML</strong><br/>" +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + htCount + "][title]' value='Title' maxlength='100' size='30'>" +
                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new deleteHTMLfield' type='button' value='-' alt='" + htCount + "'> &nbsp; (HTML Field - Title is invisible)<br/></div><hr>" +
                    "<div class='cg-wp-editor-container' data-wp-editor-id='" + editor_id + "'></div>" +
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + htCount + "][hide]'></span>" +
                    "<br></div></div>").addClass('cg_blink'));

                var $element = $("#" + htCount);

                $element.find('.cg-wp-editor-container').append($('<textarea class="cg-wp-editor-template" name="upload[-'+htCount+'][content]" id="'+editor_id+'" ></textarea>'));

                cgJsClassAdmin.index.functions.initializeEditor(editor_id);

                cgJsClassAdmin.createUpload.functions.goToField($);

            }


        }

        if ($('#dauswahl').val() == "caRo") {

            // 1 = Feldtyp
            // 2 = Feldtitel
            // 3 = Feldinhalt

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var caRoCount = 80 + $('.captchaRoField').length;
            var caRoHiddenCount = 800 + $('.captchaRoField').length;

            //alert(nfCount);

            if ($('.captchaRoField').length >= 1) {
                alert("This field can be produced maximum 1 time");
            }
            else {

                $("#ausgabe1.cg_create_upload").prepend($("<div id='" + caRoCount + "' class='formField captchaRoField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +
                    "<input type='hidden' name='upload[-" + caRoCount + "][type]' value='caRo'>" +
                    "<input type='hidden' name='upload[-" + caRoCount + "][new]' value='caRo'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + caRoCount + "][order]' value=''>" +

                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='caRo' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+caRoCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+caRoCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Simple Captcha - I am not a robot</strong><br/>" +
                    "<input type='checkbox' disabled> " +
                    "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[-" + caRoCount + "][title]' value='I am not a robot' maxlength='100' size='30'>" +
                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<input class='cg_delete_form_field_new' type='button' value='-' alt='" + caRoCount + "'>" +
                    "<br/></div><br>Required <input type='checkbox' class='necessary-check' disabled checked >" +
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + caRoCount + "][hide]'></span>" +
                    "<br/></div></div>").addClass('cg_blink'));

                // location.href = "#"+caRoCount+"";

                cgJsClassAdmin.createUpload.functions.goToField($);


            }

            //alert(nfCount);
            /*
            $('html, body').animate({
            scrollTop: $("#'"+nfCount+"'").offset().top
            }, 400);
            $("html, body").animate({ scrollTop: $("#12").scrollTop() }, 1000);*/


        }

        if ($('#dauswahl').val() == "caRoRe") {

            // 1 = Feldtyp
            // 2 = Feldtitel
            // 3 = Feldinhalt

            cgJsClassAdmin.createUpload.vars.countChildren++;

            // alert(cgJsClassAdmin.createUpload.vars.countChildren);

            var caRoReCount = 110 + $('.captchaRoReField').length;
            var caRoReHiddenCount = 1100 + $('.captchaRoReField').length;

            //alert(nfCount);

            if ($('.captchaRoReField').length >= 1) {
                alert("This field can be produced maximum 1 time");
            }
            else {

                var reCaptchaSelect = $('#cgReCaLangToCopy').clone();
                var toAppend = $("<div id='" + caRoReCount + "' class='formField captchaRoReField'>" +
                    "<div class='cg_drag_area'><img class='cg_drag_area_icon' src='" + cgJsClassAdmin.createUpload.vars.cgDragIcon + "'></div>" +
                    "<div class='formFieldInnerDiv'>" +
                    "<input type='hidden' name='upload[-" + caRoReCount + "][type]' value='caRoRe'>" +
                    "<input type='hidden' name='upload[-" + caRoReCount + "][new]' value='caRoRe'>" +
                    "<input type='hidden' class='fieldOrder' name='upload[-" + caRoReCount + "][order]' value=''>" +

                    "<input type='hidden' value='" + cgJsClassAdmin.createUpload.vars.countChildren + "' name='addField[]' class='fieldValue'>" + // Nummer des neuen Feldes wird extra versendet
                    "<input type='hidden' value='caRo' name='addField[]'>" +
                    //"<input type='hidden' name='upload[-"+caRoReCount+"][type]' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+// Feldnummer wird vergeben zur Orientierung in der Datenbank
                    //"<input type='hidden' class='fieldnumber' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"'>"+
                    //"<input type='hidden' name='upload[-"+caRoReCount+"][type]' value='"+ cgJsClassAdmin.createUpload.vars.countChildren +"' size='30' class='changeUploadFieldOrder'>"+// Feldreihenfolge
                    "<strong>Google reCAPTCHA - I am not a robot (can be rendered only 1 time on a page)</strong><br/>" +
                    "<input type='hidden' name='actualID[]' value='placeholder' >" +// Platzhalter statt aktueller Feld ID
                    "<div class='cg_name_field_and_delete_button_container'><span id=\"cgReCaLangToInsert\" ></span><input class='cg_delete_form_field_new' type='button' value='-' alt='" + caRoReCount + "'><br/></div>" +
                    "<strong>Website Key</strong><br/>" +
                    "<div style='display:flex;align-items:center;'><input type='text' name='upload[-" + caRoReCount + "][ReCaKey]' class='cg_reca_key' placeholder='Example Key: 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI' size='30' maxlength='1000' />" +
                    "<img src='" + cgJsClassAdmin.createUpload.vars.cgRecaptchaIconUrl + "' title='Insert Google reCAPTCHA test key' alt='Insert Google reCAPTCHA test key' class='cg_recaptcha_icon' /></div>" +
                    "<br/><br>Required <input type='checkbox' class='necessary-check' disabled checked >" +
                    "<span class='cg-active'>Hide <input type='checkbox' name='upload[-" + caRoReCount + "][hide]'></span>" +
                    "<br/></div></div>");

                $("#ausgabe1.cg_create_upload").prepend(toAppend.addClass('cg_blink'));
                $("#ausgabe1.cg_create_upload").find('#cgReCaLangToInsert').prepend(reCaptchaSelect.removeClass('cg_hide').attr('name', "upload[-" + caRoReCount + "][ReCaLang]"));

                // location.href = "#"+caRoReCount+"";

                cgJsClassAdmin.createUpload.functions.goToField($);


            }

            //alert(nfCount);
            /*
            $('html, body').animate({
            scrollTop: $("#'"+nfCount+"'").offset().top
            }, 400);
            $("html, body").animate({ scrollTop: $("#12").scrollTop() }, 1000);*/


        }

        cgJsClassAdmin.createUpload.functions.addRightFieldOrder($);

        setTimeout(function () {
            $('.cg_blink').removeClass('cg_blink');
        }, 2000);


    });


    /*$("#cg_create_upload_add_field").click(function(){
    
  alert("This option is not available in the Lite Version.");
      
   });*/


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_add_category', function () {

        var length = $('.cg_category_field_div').length;
        if (length < 1) {
            length = 1;
            var placeholder = 'Category' + length;
        }
        else if (length == 1) {
            length = 2;
            var placeholder = 'Category' + length;
        }
        else {
            length = length + 1;
            var placeholder = 'Category' + length;
        }

        var cg_categories_arena = $(this).closest('.selectCategoriesField').find('.cg_categories_arena');

        var $cg_category_field_div = $('<div class="cg_category_field_div">' +
            '<div class="cg_category_change_order cg_move_view_to_top"><i></i></div>' +
            '<div class="cg_category_change_order cg_move_view_to_bottom"><i></i></div>' +
            '<div class="cg_name_field_and_delete_button_container">' +
            '<input class="cg_category_field" placeholder="' + placeholder + '" name="cg_category[]" type="text" />' +
            '<input class="cg_delete_category_field" type="button" value="-" style="width:20px;">' +
            '</div>' +
            '</div>');

        if ($('#cgCategoryFieldDivOther').length) {
            $cg_category_field_div.prependTo($('#cgCategoryFieldDivOther'));
        } else {
            cg_categories_arena.append($cg_category_field_div);
        }

        cg_categories_arena.find('.cg_category_field_div').find('.cg_category_change_order').removeClass('cg_hide');

        cg_categories_arena.find('.cg_category_field_div').first().find('.cg_move_view_to_top').addClass('cg_hide');


        if (cg_categories_arena.find('.cg_category_field_div').length >= 2) {
            cg_categories_arena.find('.cg_category_field_div').last().find('.cg_move_view_to_bottom').addClass('cg_hide');
        }

    });


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_delete_category_field', function (e) {

        e.preventDefault();


        var attr = $(this).attr('data-delete');

        // For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
        if (typeof attr !== typeof undefined && attr !== false) {
            if (confirm("Delete category field? All Contest Gallery user information connected to this field will be deleted.")) {

                var categoryIDtoRemove = $(this).attr('data-delete');

                $(this).closest('.cg_category_field_div').remove();

                if (document.readyState === "complete") {
                    $('#ausgabe1.cg_create_upload').append("<input type='input' name='deleteCategory' value='" + categoryIDtoRemove + "'>");
                    $('#submitForm').click();
                }


                return true;

            } else {

                return false;

            }
        }
        else {

            $(this).closest('.cg_category_field_div').remove();

        }


    });

    $(document).on('click', '#ausgabe1.cg_create_upload .cg_move_view_to_top', function (e) {

        var cg_categories_arena = $(this).closest('.selectCategoriesField').find('.cg_categories_arena');


        if (cg_categories_arena.find('.cg_category_field_div').length == 1) {
            return false;
        }

        var fieldToDetach = $(this).closest('.cg_category_field_div');
        var insertBeforeField = fieldToDetach.prev();
        fieldToDetach.detach().insertBefore(insertBeforeField);


        cg_categories_arena.find('.cg_category_field_div').find('.cg_category_change_order').removeClass('cg_hide');
        cg_categories_arena.find('.cg_category_field_div').first().find('.cg_move_view_to_top').addClass('cg_hide');
        if (cg_categories_arena.find('.cg_category_field_div').length >= 2) {
            cg_categories_arena.find('.cg_category_field_div').last().find('.cg_move_view_to_bottom').addClass('cg_hide');
        }

    });


    $(document).on('click', '#ausgabe1.cg_create_upload .cg_move_view_to_bottom', function (e) {

        var cg_categories_arena = $(this).closest('.selectCategoriesField').find('.cg_categories_arena');

        if (cg_categories_arena.find('.cg_category_field_div').length == 1) {
            return false;
        }


        var fieldToDetach = $(this).closest('.cg_category_field_div');
        var insertAfterField = fieldToDetach.next();
        fieldToDetach.detach().insertAfter(insertAfterField);


        cg_categories_arena.find('.cg_category_field_div').find('.cg_category_change_order').removeClass('cg_hide');
        cg_categories_arena.find('.cg_category_field_div').first().find('.cg_move_view_to_top').addClass('cg_hide');
        if (cg_categories_arena.find('.cg_category_field_div').length >= 2) {
            cg_categories_arena.find('.cg_category_field_div').last().find('.cg_move_view_to_bottom').addClass('cg_hide');
        }

    });




});