<?php

if($options['general']['ActivateBulkUpload']==1){
    $SingleBulkUploadConfiguration = "name='data[]' multiple";
}
else{
    $SingleBulkUploadConfiguration = "name='data[]' ";
}


$jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-form-upload.json';
$fp = fopen($jsonFile, 'r');
$jsonUploadForm = json_decode(fread($fp,filesize($jsonFile)),true);
fclose($fp);

$jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-categories.json';
$fp = fopen($jsonFile, 'r');
$jsonCategories = json_decode(fread($fp,filesize($jsonFile)),true);
fclose($fp);



echo "<div id='mainCGdivUploadForm$galeryIDuser' class='mainCGdivUploadForm cg_hide $cgFeControlsStyle'>";

$jsonUploadFormSortedByFieldOrder = array();
/*echo "<pre>";
print_r($jsonUploadForm);
echo "</pre>";*/
foreach($jsonUploadForm as $fieldId => $field){

    $jsonUploadFormSortedByFieldOrder[$field['Field_Order']] = $field;
    $jsonUploadFormSortedByFieldOrder[$field['Field_Order']]['id'] = $fieldId;

}
ksort($jsonUploadFormSortedByFieldOrder);
/*echo "<pre>";
print_r($jsonUploadFormSortedByFieldOrder);
echo "</pre>";*/


echo "<div id='cgCloseUploadForm$galeryIDuser' class='cg-close-upload-form $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";
    echo "</div>";

echo "<div id='cgMinimizeUploadForm$galeryIDuser' class='cg-minimize-upload-form cg_hide $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";
    echo "</div>";

echo "<div id='cgRefreshUploadForm$galeryIDuser' class='cg-refresh-upload-form cg_hide $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";
echo "</div>";

echo "<div id='mainCGdivUploadFormLdsDualRing$galeryIDuser' class='cg-lds-dual-ring-div-gallery-hide $cgFeControlsStyle cg_hide'><div class='cg-lds-dual-ring-gallery-hide $cgFeControlsStyle'></div></div>";

echo "<div id='mainCGdivUploadProgress$galeryIDuser' class='cg_hide cg-div-upload-progress $cgFeControlsStyle'></div>";

echo "<div id='mainCGdivUploadFormResult$galeryIDuser' class='mainCGdivUploadFormResult cg_hide' data-cg-gid='$galeryIDuser'>";
    echo "<div id='cgGalleryUploadConfirmationText$galeryIDuser' class='cgGalleryUploadConfirmationText' data-cg-gid='$galeryIDuser'>";

        echo contest_gal1ery_convert_for_html_output($options['pro']['GalleryUploadConfirmationText']);

    echo "</div>";
echo "</div>";


echo "<div id='mainCGdivUploadFormResultFailed$galeryIDuser' class='mainCGdivUploadFormResultFailed cg_hide' data-cg-gid='$galeryIDuser'>";

echo "</div>";


echo "<div id='mainCGdivUploadFormContainer$galeryIDuser' class='mainCGdivUploadFormContainer $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";

if((time()>=$ContestEndTime && $ContestEnd==1) OR $ContestEnd==2){
    echo "<div class='cg_photo_contest_is_over'>";
    echo "<p>$language_ThePhotoContestIsOver</p>";
    echo "</div>";
}else{

    if($options['pro']['RegUserUploadOnly']==1 && is_user_logged_in()==false){
        echo contest_gal1ery_convert_for_html_output($options['pro']['RegUserUploadOnlyText']);
    }
    else{

        if(!empty($options['pro']['RegUserUploadOnly'])){
            if($options['pro']['RegUserUploadOnly']==1 && !empty($options['pro']['RegUserMaxUpload']) && is_user_logged_in()==true){
                $WpUserId = get_current_user_id();
                $RegUserMaxUploadCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename WHERE WpUserId = '$WpUserId' and GalleryID = '$galeryID'");
                echo "<input type='hidden' id='cgRegUserMaxUploadCountInGallery$galeryIDuser' value='$RegUserMaxUploadCount'>";
            }else if($options['pro']['RegUserUploadOnly']==2 && !empty($options['pro']['RegUserMaxUpload'])){

                if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-upload'])) {
                    $CookieId = $_COOKIE['contest-gal1ery-'.$galeryID.'-upload'];
                    $RegUserMaxUploadCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename WHERE CookieId = '$CookieId' and GalleryID = '$galeryID'");
                }else{
                    $CookieId = "up".(md5(time().uniqid('cg',true)).time());
                    $RegUserMaxUploadCount = 0;
                }

                echo "<input type='hidden' id='cgRegUserMaxUploadCountInGallery$galeryIDuser' value='$RegUserMaxUploadCount'>";
                echo "<input type='hidden' id='cgUploadCookieId$galeryIDuser' value='$CookieId'>";

            }else if($options['pro']['RegUserUploadOnly']==3 && !empty($options['pro']['RegUserMaxUpload'])){
                $userIP = cg_get_user_ip();
                $RegUserMaxUploadCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename WHERE IP = '$userIP' and GalleryID = '$galeryID'");
                echo "<input type='hidden' id='cgRegUserMaxUploadCountInGallery$galeryIDuser' value='$RegUserMaxUploadCount'>";
            }else{
                echo "<input type='hidden' id='cgRegUserMaxUploadCountInGallery$galeryIDuser' value='0'>";
            }
        }else{
            echo "<input type='hidden' id='cgRegUserMaxUploadCountInGallery$galeryIDuser' value='0'>";
        }

        echo "<div id='cgGalleryUploadFormTextBefore$galeryIDuser' class='cgGalleryUploadFormTextBefore' data-cg-gid='$galeryIDuser'>";

        echo contest_gal1ery_convert_for_html_output($options['pro']['GalleryUploadTextBefore']);

        echo "</div>";

        echo "<form action='' method='post' class='cgGalleryUploadForm' id='cgGalleryUploadForm$galeryIDuser' data-cg-gid='$galeryIDuser' enctype='multipart/form-data' name='cgGalleryUpload' novalidate >";
        echo "<input type='hidden' name='galeryIDuser' value='$galeryIDuser'>";


        // for unique ids when multiple shortcodes are inserted on same page
        $uniqueIdAddition = substr(md5(uniqid(rand().$galeryIDuser, true)),0,5);

        foreach($jsonUploadFormSortedByFieldOrder as $fieldOrder => $field){

            if ($field['Field_Type'] == 'image-f'){

                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];

                echo "<div class='cg_form_div cg_form_div_image_upload' >";
                echo "<label for='cg_input_image_upload_id_in_gallery$galeryIDuser$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." *</label>";
                echo "<input type='file' class='cg_input_image_upload_id_in_gallery' data-cg-gid='$galeryIDuser' id='cg_input_image_upload_id_in_gallery$galeryIDuser$uniqueIdAddition' $SingleBulkUploadConfiguration />";// Content Feld
                echo "<p class='cg_input_error cg_hide cg_input_error cg_hide_image_upload'></p>";// Fehlermeldung erscheint hier
                echo "<div class='cg_form_div_image_upload_preview cg_hide'></div>";
                echo "</div>";

            }

            if ($field['Field_Type']=='fbt-f' && $field['Active'] == '1'){

                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                $minLength = $Field_Content['min-char'];
                $maxLength = $Field_Content['max-char'];

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]' value='fbt'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<input type='text' placeholder='".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['content'])."'  maxlength='$maxLength' class='cg_input_text_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' value='' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='minsize' value='$minLength'>"; // Pr�fen minimale Anzahl zeichen
                echo "<input type='hidden' class='maxsize' value='$maxLength'>"; // Pr�fen maximale Anzahl zeichen
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";
            }

            if ($field['Field_Type']=='text-f' && $field['Active'] == '1'){

                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                $minLength = $Field_Content['min-char'];
                $maxLength = $Field_Content['max-char'];

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]' value='nf'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<input type='text' placeholder='".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['content'])."'  maxlength='$maxLength' class='cg_input_text_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' value='' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='minsize' value='$minLength'>"; // Pr�fen minimale Anzahl zeichen
                echo "<input type='hidden' class='maxsize' value='$maxLength'>"; // Pr�fen maximale Anzahl zeichen
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed' >";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";
            }

            if ($field['Field_Type']=='date-f' && $field['Active'] == '1'){

                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $format = $field['Field_Content']['format'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;


                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]' value='dt'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<input type='text' autocomplete='off' class='cg_upload_form_field_in_gallery cg_input_date_class' data-cg-gid='$galeryIDuser' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' value='' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='cg_date_format' value='$format'>";// Feldreihenfolge wird mitgegeben
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed' >";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";
            }

            if ($field['Field_Type']=='url-f' && $field['Active'] == '1'){

                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;


                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]' value='url'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<input type='text' placeholder='".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['content'])."' class='cg_input_url_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser'  id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' value='' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";

            }

            if ($field['Field_Type']=='email-f' && $field['Active'] == '1'){

                if(is_user_logged_in()==false){
                    $fieldId = $field['id'];
                    $Field_Order = $field['Field_Order'];
                    $Field_Content = $field['Field_Content'];
                    $checkIfNeed = $Field_Content['mandatory'];

                    $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                    $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                    echo "<div class='cg_form_div'>";
                    echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                    echo "<input type='hidden' name='form_input[]'  value='ef'><input type='hidden' name='form_input[]' value='$fieldId'>";//Formart und FormfeldID hidden
                    echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                    echo "<input type='text' placeholder='".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['content'])."' value='' class='cg_input_email_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser'  id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
                    echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                    echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                    echo "</div>";
                }

            }

            if ($field['Field_Type']=='fbd-f' && $field['Active'] == '1'){
                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]'  value='fbd'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<textarea maxlength='".$Field_Content['max-char']."' class='cg_textarea_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' placeholder='".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['content'])."' name='form_input[]'  rows='10' ></textarea>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='minsize' value='".$Field_Content['min-char']."'>"; // Pr�fen minimale Anzahl zeichen
                echo "<input type='hidden' class='maxsize' value='".$Field_Content['max-char']."'>"; // Pr�fen maximale Anzahl zeichen
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";

            }

            if ($field['Field_Type']=='comment-f' && $field['Active'] == '1'){
                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]'  value='kf'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<textarea maxlength='".$Field_Content['max-char']."' class='cg_textarea_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' placeholder='".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['content'])."' name='form_input[]'  rows='10' ></textarea>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='minsize' value='".$Field_Content['min-char']."'>"; // Pr�fen minimale Anzahl zeichen
                echo "<input type='hidden' class='maxsize' value='".$Field_Content['max-char']."'>"; // Pr�fen maximale Anzahl zeichen
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";

            }

            if ($field['Field_Type']=='check-f' && $field['Active'] == '1'){

                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $Field_Version = (!empty($field['Version'])) ? $field['Version'] : '';
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;
             //   $checkIfNeed = $Field_Content['mandatory'];

           //     $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                if(empty($Field_Version)){// then must be old form and always required
                    $necessary = '*';
                    $checkIfNeed = 'on';
                }

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])." $necessary</label>";
                echo "<input type='hidden' name='form_input[]'  value='cb'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<div class='cg-check-agreement-container'>";
                echo "<div class='cg-check-agreement-checkbox'>";
                echo "<input type='checkbox' class='cg_check_agreement_class cg_upload_form_field_in_gallery' data-cg-gid='$galeryIDuser' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' name='form_input[]' value='checked' >";
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "</div>";
                echo "<div class='cg-check-agreement-html'>".contest_gal1ery_convert_for_html_output($Field_Content['content']);
                echo "</div>";
                echo "</div>";
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";

            }

            if ($field['Field_Type']=='select-f' && $field['Active'] == '1'){
                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".$Field_Content['titel']." $necessary</label>";
                echo "<input type='hidden' name='form_input[]'  value='se'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben

                $textAr = explode("\n", $Field_Content['content']);

                echo "<select name='form_input[]' class='cg_input_select_class cg_upload_form_field_in_gallery'  id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' data-cg-gid='$galeryIDuser' >";

                echo "<option value='0'>$language_pleaseSelect</option>";

                foreach($textAr as $key => $value){

                    echo "<option value='$value'>$value</option>";

                }

                echo "</select>";

                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";

            }

            if ($field['Field_Type']=='selectc-f' && $field['Active'] == '1'){
                $fieldId = $field['id'];
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];
                $checkIfNeed = $Field_Content['mandatory'];

                $necessary = ($Field_Content['mandatory']=='on') ? '*' : '' ;
                $checkIfNeed = ($Field_Content['mandatory']=='on') ? 'on' : '' ;

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition'>".$Field_Content['titel']." $necessary</label>";
                echo "<input type='hidden' name='form_input[]'  value='sec'><input type='hidden' name='form_input[]' value='$fieldId'>";// Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben


                echo "<select name='form_input[]' class='cg_input_select_class cg_upload_form_field_in_gallery' id='cg_upload_form_field_in_gallery$fieldId$uniqueIdAddition' data-cg-gid='$galeryIDuser' >";

                echo "<option value='0'>$language_pleaseSelect</option>";

                foreach($jsonCategories as $categoryKey => $category){

                    echo "<option value='".$categoryKey."' >".$category['Name']."</option>";

                }

                echo "</select>";

                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";

            }

            if ($field['Field_Type']=='html-f' && $field['Active'] == '1'){
                $Field_Order = $field['Field_Order'];
                $Field_Content = $field['Field_Content'];

                echo "<div class='cg_form_div cg_html_field_class'>";
                echo contest_gal1ery_convert_for_html_output($Field_Content['content']);
                echo "</div>";

            }

            if ($field['Field_Type']=='caRo-f' && $field['Active'] == '1'){

                $Field_Content = $field['Field_Content'];

                echo "<div class='cg_form_div cg_captcha_not_a_robot_field_in_gallery' data-cg-gid='$galeryIDuser' >";
                echo "<label for='cg_$wp_create_nonce' >".contest_gal1ery_convert_for_html_output_without_nl2br($Field_Content['titel'])."</label>";
                echo "<p class='cg_input_error cg_hide'></p>";
                echo "</div>";

            }

            if ($field['Field_Type']=='caRoRe-f' && $field['Active'] == '1'){


                echo "<div class='cg_form_div cg_recaptcha_not_a_robot_field' >";
                echo "<div class='cg_recaptcha_in_gallery_form cg_recaptcha_form' id='cgRecaptchaForm$galeryIDuser'>";

                echo "</div>";
                echo "<p class='cg_input_error cg_hide cg_recaptcha_not_valid_in_gallery_form_error' id='cgRecaptchaNotValidInGalleryFormError$galeryIDuser'></p>";
                echo "</div>";
                ?>

                <script type="text/javascript">

                    if(typeof cgRecaptchaFormInGalleryRendered == 'undefined'){

                        cgRecaptchaFormInGalleryRendered = true;

                        var galeryID = "<?php echo $galeryIDuser; ?>";

                        cgOnloadCallbackInGallery = function() {

                            var ReCaKey = "<?php echo (!empty($field['ReCaKey'])) ? $field['ReCaKey'] : '1' ; ?>";
                            var cgRecaptchaNotValidInGalleryFormError = "<?php echo 'cgRecaptchaNotValidInGalleryFormError'.$galeryIDuser.''; ?>";
                            var cgRecaptchaInGalleryForm = "<?php echo 'cgRecaptchaForm'.$galeryIDuser.''; ?>";

                            // callback when clicking recaptcha
                            cgCaRoReCallbackInGallery = function() {

                                cgRecaptchaFormInGalleryCalled = true;

                                if(typeof cgRecaptchaFormNormalCalled != 'undefined'){
                                       return;
                                }

                                var element = document.getElementById(cgRecaptchaNotValidInGalleryFormError);
                                //element.parentNode.removeChild(element);
                                element.classList.remove("cg_recaptcha_not_valid_in_gallery_form_error");
                                element.classList.add("cg_hide");
                            };

                            grecaptcha.render(cgRecaptchaInGalleryForm, {
                                'sitekey' : ReCaKey,
                                'callback' : 'cgCaRoReCallbackInGallery'
                            });

                        };



                    }

                </script>
                <script src="https://www.google.com/recaptcha/api.js?onload=cgOnloadCallbackInGallery&render=explicit&hl=<?php echo $field['ReCaLang']; ?>"
                        async defer>
                </script>


                <?php


            }


        }

        echo "<div class='cg_form_div cg_form_upload_submit_div' >";
        echo "<input type='submit' name='cg_form_submit' class='cg_users_upload_submit' data-cg-gid='$galeryIDuser' value='$language_sendUpload'>";
        echo "<p class='cg_input_error cg_hide'></p>";

        echo "</div>";

        echo "</form>";
        echo "<div id='cgGalleryUploadFormTextBefore$galeryIDuser' class='cgGalleryUploadFormTextBefore' data-cg-gid='$galeryIDuser'>";

        echo contest_gal1ery_convert_for_html_output($options['pro']['GalleryUploadTextAfter']);

        echo "</div>";

    }
}

echo "</div>";

echo "</div>";

?>