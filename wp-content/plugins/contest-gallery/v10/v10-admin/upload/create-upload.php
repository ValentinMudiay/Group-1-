<?php
if(!defined('ABSPATH')){exit;}
require_once('get-data-create-upload-v10.php');

$iconsURL = plugins_url().'/contest-gallery/v10/v10-css';

$cgRecaptchaIconUrl = $iconsURL.'/backend/re-captcha.png';
$cgDragIcon = $iconsURL.'/backend/cg-drag-icon.png';

echo "<input type='hidden' id='cgDragIcon' value='$cgDragIcon'/>";
echo "<input type='hidden' id='cgRecaptchaIconUrl' value='$cgRecaptchaIconUrl'/>";
echo "<input type='hidden' id='cgRecaptchaKey' value='6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'/>";

// Path to jquery Lightbox Script

// $pathJquery = plugins_url().'/contest-gallery/js/jquery.js';
//$pathPlugin1 = plugins_url().'/contest-gallery/js/lightbox-2.6.min.js';
//$pathPlugin2 = plugins_url().'/contest-gallery/css/lightbox.css';
//$pathPlugin3 = plugins_url().'/contest-gallery/css/star_off_48.png';
//$pathPlugin4 = plugins_url().'/contest-gallery/css/star_48.png';
//$pathCss = plugins_url().'/contest-gallery/css/style.css';
// $pathJqueryUI = plugins_url().'/contest-gallery/js/jquery-ui.js';
// $pathJqueryUIcss = plugins_url().'/contest-gallery/js/jquery-ui.css';
//$cssPng = content_url().'/plugins/contest-gallery/css/lupe.png';// URL for zoom pic


//add_action('wp_enqueue_scripts','my_scripts');


/*

echo <<<HEREDOC

<link href="$pathPlugin2" rel="stylesheet" />
<link href="$pathCss" rel="stylesheet" />
<link href="$pathPlugin6" rel="stylesheet" />


HEREDOC;

//echo $pathCss;


echo <<<HEREDOC

	<script src='$pathJquery'></script>
	<script src='$pathJqueryUI'></script>
	<script src='$pathJqueryUIcss'></script>

HEREDOC;*/



require_once(dirname(__FILE__) . "/../nav-menu.php");

function cg_cg_set_default_editor() {
    $r = 'html';
    return $r;
}
add_filter( 'wp_default_editor', 'cg_cg_set_default_editor' );

//$tinymceStyle = '<style type="text/css">
/*body#tinymce{
	margin: 8px 5px 8px 5px;
	max-width: unset;
	padding: 0;
	width: unset;
}*/
			//	   .wp-editor-area{height:200px;}
		//		   </style>';

/*$timymceSettings = array(
    'plugins' => "preview",
    'menubar' => "view",
    'toolbar' => "preview",
    'plugin_preview_width'=> 650,
    'selector' => "textarea"
);*/

/*$settingsHTMLarea = array(
    "media_buttons"=>false,
    'editor_class' => 'tmce-active',
    'default_post_edit_rows'=> 10,
    "textarea_name"=>"",
    "teeny" => true,
    "dfw" => true,
    'editor_css' => $tinymceStyle
);*/


/*echo "<div id='cgTinymceCollectionForAgreement'>";
for($i=0;$i<=10;$i++){

    $editor_id = "htmlFieldTemplateForAgreement$i";

    // TinyMCE Editor to take as copy for template
    echo "<div id='htmlEditorTemplateDivForAgreement$i' data-wp-editor-id='$editor_id' class='htmlEditorTemplateDivForAgreement' style='display:none;'>";

    $testVal = "";

    echo "<textarea class='cg-wp-editor-template' id='$editor_id' ></textarea>";

    //wp_editor($testVal, $editor_id, $settingsHTMLarea);

    echo "</div>";

}
echo "</div>";*/


// recaptcha-lang-options.php
$langOptions = include(__DIR__.'/../data/recaptcha-lang-options.php');

echo '<select name="ReCaLang" id="cgReCaLangToCopy" class="cg_hide">';

echo "<option value='' >Please select language</option>";

foreach($langOptions as $langKey => $lang){

    echo "<option value='$langKey' >$lang</option>";

}

echo '</select>';


echo '<div id="cgUploadForm">';

//echo "<form name='defineUpload' enctype='multipart/form-data' action='?page=contest-gallery/index.php&optionID=$GalleryID&defineUpload=true' id='form' method='post'>";

$fbLikeTitleAndDesc = '';

if($FbLike==1){
    $fbLikeTitleAndDesc = "<option class=\"$cgProFalse\" value=\"fbt\">Facebook share button title $cgProFalseText</option>
			<option class=\"$cgProFalse\" value=\"fbd\">Facebook share button description $cgProFalseText</option>";
}

$heredoc = <<<HEREDOC
	<select name="dauswahl" id="dauswahl" >
		<optgroup label="User fields">
			<option  value="nf">Input</option>
			<option value="kf">Textarea</option>
			<option value="se">Select</option>
			<option value="sec">Select Categories</option>
			<option class="$cgProFalse" value="dt">Date $cgProFalseText</option>
			<option class="$cgProFalse" value="ef">Email $cgProFalseText</option>
			<option value="url">URL</option>
			<option class="$cgProFalse" value="cb">Check agreement $cgProFalseText</option>
			$fbLikeTitleAndDesc
		 </optgroup>
		<optgroup label="Admin fields">
			<option class="$cgProFalse" value="ht">HTML $cgProFalseText</option>
			<option  value="caRo">Simple Captcha - I am not a robot</option>
			<option  value="caRoRe">Google reCAPTCHA - I am not a robot</option>
		 </optgroup>
	</select>
	<input id="cg_create_upload_add_field" class="cg_upload_dauswahl" type="button" name="plus" value="+" >
	<span style="font-size: 22px;margin-left:auto;">Upload form</span>
	<div style="flex-basis:100%;height:0;"></div>
	<div id="cgUploadFormDescription" style="margin: 0 auto;padding-top: 15px;">Note: added fields will be available as content fields for all images in the gallery</div>
	</div>
HEREDOC;

echo $heredoc;

if(!empty($_POST['upload'])){
    echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>";
}

echo "<form class='cg_load_backend_submit' name='defineUpload' enctype='multipart/form-data' action='?page=contest-gallery/index.php&option_id=$GalleryID&define_upload=true' id='form' method='post'>";
wp_nonce_field( 'cg_admin');

echo "<input type='hidden' name='option_id' value='$GalleryID'>";
?>



<div style="width:935px;background-color:#fff;border: thin solid black;">
    <div id="ausgabe1" class="cg_create_upload" style="display:table;width:875px;padding:10px;background-color:#ffffff;padding-left:29px;padding-right:20px;padding-top:20px;">

        <?php

        //echo "<div id='cgTinymceCollection' class='cg_hide'>";
       // for($i=0;$i<=10;$i++){

           // $editor_id = "htmlFieldTemplate$i";

            // TinyMCE Editor to take as copy for template
           // echo "<div id='htmlEditorTemplateDiv$i' class='htmlEditorTemplateDiv' style='display:none;'>";
       //     $testVal = "";
            //wp_editor($testVal, $editor_id, $settingsHTMLarea);
   // echo "<textarea class='cg-wp-editor-template' id='$editor_id' ></textarea>";
        //    echo "</div>";

      //  }
     //   echo "</div>";


        // ---------------- AUSGABE des gespeicherten Formulares

        /*

            $deleteFieldnumber = @$_POST['deleteFieldnumber'];
            $changeFieldRow = @$_POST['changeFieldRow'];
            $addField = @$_POST['addField'];


            //echo 'deleteFieldnumber:<br/>';
            //print_r($deleteFieldnumber);echo '<br/>';
            //echo 'changeFieldRow:<br/>';
            //print_r($changeFieldRow);echo '<br/>';
            //echo 'addField:<br/>';
            //print_r($addField);
            //echo '<br/>';


        // Jeder sechste wird ausgewertet, um festzustellen, um welche Feldart sich handelt
        $i3 = 7;
        $key = 0;

        // Field type
        $ft ='';*/

        // IDs of the div boxes
        @$nfCount = 10;
        @$kfCount = 20;
        @$efCount = 30;
        @$bhCount = 40;
        @$htCount = 50;
        @$cbCount = 60;
        @$seCount = 70;
        @$caRoCount = 80;
        @$secCount = 90;
        @$urlCount = 100;
        @$caRoReCount = 110;
        @$fbtCount = 120;
        @$fbdCount = 130;
        @$dtCount = 140;


        // Further IDs of the div boxes
        @$nfHiddenCount = 100;
        @$kfHiddenCount = 200;
        @$efHiddenCount = 300;
        @$bhHiddenCount = 400;
        @$htHiddenCount = 500;
        @$cbHiddenCount = 600;
        @$seHiddenCount = 700;
        @$caRoHiddenCount = 800;
        @$urlHiddenCount = 1000;
        @$caRoReHiddenCount = 1100;
        @$fbtHiddenCount = 1200;
        @$fbdHiddenCount = 1300;
        @$dtHiddenCount = 1400;

        // FELDBENENNUNGEN

        // 1 = Feldtyp
        // 2 = Feldnummer
        // 3 = Feldtitel
        // 4 = Feldinhalt
        // 5 = Feldkrieterium1
        // 6 = Feldkrieterium2
        // 7 = Felderfordernis


        //print_r($selectFormInput);

        $cg_info_show_slider_title = 'Show as info in single view';
        $cg_info_show_gallery_title = 'Show as title in gallery (only 1 allowed)';
        $cg_tag_show_gallery_title = 'Show as HTML title attribute in gallery (only 1 allowed)';


        if ($selectFormInput) {

            foreach ($selectFormInput as $value) {


                if($value->Field_Type == 'image-f'){

                    // Feldtyp
                    // 1 = Feldtitel

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";

                    // Anfang des Formularteils
                    echo "<div id='$bhCount' class='formField imageUploadField'><input type='hidden' name='upload[$id][type]' value='bh'>";
                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";


                    echo "<div class='formFieldInnerDiv'>";

                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mitschicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        // 1 = Feldtitel
                        if($key=='titel'){
                            echo "<strong>Image upload </strong><br/>";
                            echo "<input type='text' name='upload[$id][title]' value='$value' size='30'><br/>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

                            echo "<input type='file' id='bh' disabled /><br/>";
                            echo "<br>Required <input type='checkbox' checked disabled /><br/>"; // Bildupload ist so oder so immer notwendig
                            echo "<span class='cg-active' style='visibility: hidden;height:0;'>Hide <input type='checkbox' name='upload[$id][hide]' ></span>";
                            echo "</div>";
                            echo "</div>";

                        }

                    }

                }


                if(@$value->Field_Type == 'check-f'){// AGREEMENT FIELD

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldinhalt
                    // 2 = Felderfordernis

                    //ermitteln der Feldnummer
                    @$fieldOrder = $value->Field_Order;
                    @$fieldVersion = $value->Version;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$cbCount'  class='formField checkAgreementField'><input type='hidden' name='upload[$id][type]' value='cb'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";

                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$cbCount' titel='$id'>";



                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mitschicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        // 2. Feldtitel
                        if($key=='titel'){
                            $value = html_entity_decode(stripslashes($value));
                            echo "<strong>Check agreement</strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'>";

                            echo "<input type='text' name='upload[$id][title]' value='$value' maxlength='100' size='30'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

                        }

                        // 2. Feldinhalt
                        if($key=='content'){

                            $editor_id = "htmlFieldForAgreement$cbCount";


                            // TinyMCE Editor
                            echo "<div class='cgCheckAgreementContainer'>";
                            echo "<div class='cgCheckAgreementCheckbox'>";
                            echo "<input type='checkbox' disabled>";
                            echo "</div>";
                            echo "<div class='cgCheckAgreementHtml cg-wp-editor-container' data-wp-editor-id='$editor_id'>";

/*                            $settingsHTMLarea = array(
                                "media_buttons"=>false,
                                'editor_class' => 'tmce-active',
                                'default_post_edit_rows'=> 10,
                                "textarea_name"=>"upload[$id][content]",
                                "teeny" => true,
                                "dfw" => true,
                                'editor_css' => $tinymceStyle
                            );*/
                            $value = contest_gal1ery_convert_for_html_output_without_nl2br($value);
                            echo "<textarea class='cg-wp-editor-template' id='$editor_id' name='upload[$id][content]'>$value</textarea>";
                            //wp_editor( $value, $editor_id, $settingsHTMLarea);

                            //  echo "<input type='text' name='upload[$id][content]' class='cb'  maxlength='1000' style='width:832px;' placeholder='HTML tags allowed' value='$value'><br/>";
                            echo "</div>";
                            echo "</div>";
                        }

                        // 3. Felderfordernis
                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";
                            if(empty($fieldVersion)){// then must be old field and not saved before
                                $checked = 'checked';
                            }

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked />";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $cbCount++;
                            @$cbHiddenCount++;


                        }

                    }


                }



                if(@$value->Field_Type == 'date-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Feldkrieterium1
                    // 4 = Feldkrieterium2
                    // 5 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$dtCount'  class='formField dateTimeField'><input type='hidden' name='upload[$id][type]' value='dt'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";
                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    @$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$ftCount' titel='$id'>";

                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}



                    //echo "<br>id: $id<br>";
                    //echo "<br>Use_as_URL_id: $Use_as_URL_id<br>";
                    if(@$Use_as_URL==1 and $id==@$Use_as_URL_id){$checkedURL='checked';}
                    else{$checkedURL='';}

                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}


                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";


                    // Das Feld soll als URL agieren
                    /*		echo "<div style='width:210px;float:right;text-align:right;margin-right:10px;'>Use this field as images url: &nbsp;";
                            echo "<input type='checkbox' class='Use_as_URL' style='margin-top:0px;' name='Use_as_URL[$id]' $checkedURL>";
                            echo "</div>";*/
                    // Das Feld soll als URL agieren --- ENDE


                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mitschicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        if($key=='titel'){
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<strong>Date </strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='format'){

                            $selected1 = ($value == 'YYYY-MM-DD') ? 'selected' : '';
                            $selected2 = ($value == 'DD-MM-YYYY') ? 'selected' : '';
                            $selected3 = ($value == 'MM-DD-YYYY') ? 'selected' : '';
                            $selected4 = ($value == 'YYYY/MM/DD') ? 'selected' : '';
                            $selected5 = ($value == 'DD/MM/YYYY') ? 'selected' : '';
                            $selected6 = ($value == 'MM/DD/YYYY') ? 'selected' : '';
                            $selected7 = ($value == 'YYYY.MM.DD') ? 'selected' : '';
                            $selected8 = ($value == 'DD.MM.YYYY') ? 'selected' : '';
                            $selected9 = ($value == 'MM.DD.YYYY') ? 'selected' : '';

                            echo "Format:&nbsp; <select name='upload[$id][format]'>
                            <option value='YYYY-MM-DD' $selected1>YYYY-MM-DD</option>
                            <option value='DD-MM-YYYY' $selected2>DD-MM-YYYY</option>
                            <option value='MM-DD-YYYY' $selected3>MM-DD-YYYY</option>
                            <option value='YYYY/MM/DD' $selected4>YYYY/MM/DD</option>
                            <option value='DD/MM/YYYY' $selected5>DD/MM/YYYY</option>
                            <option value='MM/DD/YYYY' $selected6>MM/DD/YYYY</option>
                            <option value='YYYY.MM.DD' $selected7>YYYY.MM.DD</option>
                            <option value='DD.MM.YYYY' $selected8>DD.MM.YYYY</option>
                            <option value='MM.DD.YYYY' $selected9>MM.DD.YYYY</option>
                            </select><br/>";

                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $dtCount++;
                            $dtHiddenCount++;

                        }

                    }

                }


                if(@$value->Field_Type == 'text-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Feldkrieterium1
                    // 4 = Feldkrieterium2
                    // 5 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$nfCount'  class='formField inputField'><input type='hidden' name='upload[$id][type]' value='nf'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";
                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    @$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$nfCount' titel='$id'>";

                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}



                    //echo "<br>id: $id<br>";
                    //echo "<br>Use_as_URL_id: $Use_as_URL_id<br>";
                    if(@$Use_as_URL==1 and $id==@$Use_as_URL_id){$checkedURL='checked';}
                    else{$checkedURL='';}

                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}


                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";


                    // Das Feld soll als URL agieren
                    /*		echo "<div style='width:210px;float:right;text-align:right;margin-right:10px;'>Use this field as images url: &nbsp;";
                            echo "<input type='checkbox' class='Use_as_URL' style='margin-top:0px;' name='Use_as_URL[$id]' $checkedURL>";
                            echo "</div>";*/
                    // Das Feld soll als URL agieren --- ENDE


                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mitschicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        if($key=='titel'){
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<strong>Input </strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='content'){

                            echo "<input type='text' name='upload[$id][content]' value='$value' maxlength='1000' placeholder='Placeholder'  style='width:855px;'><br/>";
                        }

                        if($key=='min-char'){
                            echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[$id][min-char]' value='$value' size='7' maxlength='3' ><br/>";
                        }

                        if($key=='max-char'){
                            echo "Max. number of characters: <input type='text' name='upload[$id][max-char]' class='Max_Char' value='$value' size='7' maxlength='3' ><br/>";
                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $nfCount++;
                            $nfHiddenCount++;


                        }

                    }

                }

                if(@$value->Field_Type == 'fbt-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Feldkrieterium1
                    // 4 = Feldkrieterium2
                    // 5 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$fbtCount'  class='formField inputField'><input type='hidden' name='upload[$id][type]' value='fbt'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";
                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    @$deleteField = "<input class='cg_delete_form_field' type='button' value='-' data-field-type='fbt' alt='$fbtCount' titel='$id'>";

                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}



                    //echo "<br>id: $id<br>";
                    //echo "<br>Use_as_URL_id: $Use_as_URL_id<br>";
                    if(@$Use_as_URL==1 and $id==@$Use_as_URL_id){$checkedURL='checked';}
                    else{$checkedURL='';}

                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}


                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";


                    // Das Feld soll als URL agieren
                    /*		echo "<div style='width:210px;float:right;text-align:right;margin-right:10px;'>Use this field as images url: &nbsp;";
                            echo "<input type='checkbox' class='Use_as_URL' style='margin-top:0px;' name='Use_as_URL[$id]' $checkedURL>";
                            echo "</div>";*/
                    // Das Feld soll als URL agieren --- ENDE


                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mitschicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        if($key=='titel'){
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<strong>Facebook share button title </strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='content'){

                            echo "<input type='text' name='upload[$id][content]' value='$value' maxlength='1000' placeholder='Placeholder'  style='width:855px;'><br/>";
                        }

                        if($key=='min-char'){
                            echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[$id][min-char]' value='$value' size='7' maxlength='3' ><br/>";
                        }

                        if($key=='max-char'){
                            echo "Max. number of characters: <input type='text' name='upload[$id][max-char]' class='Max_Char' value='$value' size='7' maxlength='3' ><br/>";
                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $fbtCount++;
                            $fbtHiddenCount++;


                        }

                    }

                }

                if(@$value->Field_Type == 'url-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Feldkrieterium1
                    // 4 = Feldkrieterium2
                    // 5 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$urlCount'  class='formField inputField'><input type='hidden' name='upload[$id][type]' value='url'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";


                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";


                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    @$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$urlCount' titel='$id'>";


                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}

                    //echo "<br>id: $id<br>";
                    //echo "<br>Use_as_URL_id: $Use_as_URL_id<br>";
                    if(@$Use_as_URL==1 and $id==@$Use_as_URL_id){$checkedURL='checked';}
                    else{$checkedURL='';}

                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}


                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";

                    // Das Feld soll als URL agieren
                    /*		echo "<div style='width:210px;float:right;text-align:right;margin-right:10px;'>Use this field as images url: &nbsp;";
                            echo "<input type='checkbox' class='Use_as_URL' style='margin-top:0px;' name='Use_as_URL[$id]' $checkedURL>";
                            echo "</div>";*/
                    // Das Feld soll als URL agieren --- ENDE


                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mitschicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        if($key=='titel'){
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<strong>URL</strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='content'){

                            echo "<input type='text' name='upload[$id][content]' value='$value' id='url' maxlength='1000' placeholder='www.example.com'  style='width:855px;'><br/>";
                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $urlCount++;
                            $urlHiddenCount++;


                        }

                    }

                }


                if(@$value->Field_Type == 'email-f'){

                    // Feldtyp
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$efCount'  class='formField emailField'><input type='hidden' name='upload[$id][type]' value='ef'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";


                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";


                    echo "<div style='margin-bottom:5px;'>";
                    echo "<b>Note:</b> Do not appear if user is registered and logged in<br/><br><strong>E-Mail </strong>";
                    echo "</div>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$efCount' titel='$id'>";

                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}

                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}

                    echo "<div style='width:260px;float:right;text-align:right;display:none;'>";

                    echo "Show as title in gallery (only 1 allowed): &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' >";
                    echo "</div>";

                    echo "<div style='width:200px;float:right;text-align:right;margin-right:9px;display:none;'>";

                    echo "Show info in single view: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' >";
                    echo "</div>";




                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        // 1 = Feldtitel
                        if($key=='titel'){
                            echo "<input  type='hidden'/>";
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value' size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        // 2 = Feldinhalt
                        if($key=='content'){

                            echo "<input type='text' name='upload[$id][content]' value='$value' id='ef' style='width:858px;' placeholder='Placeholder'  maxlength='100'><br/>";
                        }

                        // 3. Felderfordernis
                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $efCount++;
                            $efHiddenCount++;


                        }

                    }

                }


                if(@$value->Field_Type == 'comment-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Feldkrieterium1
                    // 4 = Feldkrieterium2
                    // 5 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$kfCount'  class='formField textareaField'><input type='hidden' name='upload[$id][type]' value='kf'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";


                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";// Neuer Wert in der Datebank

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$kfCount' titel='$id'>";


                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}


                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}

                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    //echo "<br>";
                    //print_r($fieldContent);
                    //echo "<br>";

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));


                        if($key=='titel'){
                            echo "<strong>Textarea </strong><br/>";
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value' size='30' maxlength='1000'/>$deleteField<br/></div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='content'){
                            echo "<textarea name='upload[$id][content]' maxlength='10000' style='width:858px;' placeholder='Placeholder'  rows='10'>$value</textarea><br/>";
                        }

                        if($key=='min-char'){
                            echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[$id][min-char]' value='$value' size='7' maxlength='3' ><br/>";
                        }

                        if($key=='max-char'){
                            echo "Max. number of characters: <input type='text' class='Max_Char' name='upload[$id][max-char]' value='$value' size='7' maxlength='4' ><br/>";
                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $kfCount++;
                            $kfHiddenCount++;

                        }

                    }

                }


                if(@$value->Field_Type == 'fbd-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtitel
                    // 2 = Feldinhalt
                    // 3 = Feldkrieterium1
                    // 4 = Feldkrieterium2
                    // 5 = Felderfordernis

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$fbdCount'  class='formField textareaField'><input type='hidden' name='upload[$id][type]' value='fbd'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";


                    echo "<div class='formFieldInnerDiv'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";// Neuer Wert in der Datebank

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' data-field-type='fbd' alt='$fbdCount' titel='$id'>";


                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}


                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}

                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    //echo "<br>";
                    //print_r($fieldContent);
                    //echo "<br>";

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));

                        if($key=='titel'){
                            echo "<strong>Facebook share button description </strong><br/>";
                            //ID wird dazu mitgegeben als compareID f�r sp�ter
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value' size='30' maxlength='1000'/>$deleteField<br/></div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='content'){
                            echo "<textarea name='upload[$id][content]' maxlength='10000' style='width:858px;' placeholder='Placeholder'  rows='10'>$value</textarea><br/>";
                        }

                        if($key=='min-char'){
                            echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='upload[$id][min-char]' value='$value' size='7' maxlength='3' ><br/>";
                        }

                        if($key=='max-char'){
                            echo "Max. number of characters: <input type='text' class='Max_Char' name='upload[$id][max-char]' value='$value' size='7' maxlength='4' ><br/>";
                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";
                            echo "</div>";
                            echo "</div>";

                            $fbdCount++;
                            $fbdHiddenCount++;

                        }

                    }

                }

                // Admin fields here

                if(@$value->Field_Type == 'html-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtyp
                    // 2 = Feldtitel
                    // 3 = Feldinhalt


                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$htCount'  class='formField cg_ht_field htmlField'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";

                    echo "<div class='formFieldInnerDiv'>";
                    echo "<br/><input type='hidden' name='upload[$id][type]' value='ht'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";// Neuer Wert in der Datebank

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$htCount' titel='$id'> &nbsp; (HTML Field - Title is invisible)";


                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){
                        if($key=='titel'){
                            $value = html_entity_decode(stripslashes($value));
                            echo "<strong>HTML </strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' value='$value' size='30' maxlength='1000'/>$deleteField<br/></div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                            echo "<hr>";
                        }
                        if($key=='content'){

                            $editor_id = "htmlField$htCount";

                            // TinyMCE Editor
                            echo "<div class='cg-wp-editor-container' data-wp-editor-id='$editor_id'>";

/*                            $settingsHTMLarea = array(
                                "media_buttons"=>false,
                                'editor_class' => 'tmce-active',
                                'default_post_edit_rows'=> 10,
                                "textarea_name"=>"upload[$id][content]",
                                "teeny" => true,
                                "dfw" => true,
                                'editor_css' => $tinymceStyle
                            );*/
                            $value = contest_gal1ery_convert_for_html_output_without_nl2br($value);
                            echo "<textarea class='cg-wp-editor-template' id='$editor_id'  name='upload[$id][content]'>$value</textarea>";

                            //wp_editor( $value, $editor_id, $settingsHTMLarea);
                            echo "</div>";
                        }

                    }


                    echo "</div>";
                    echo "<span class='cg-active cg_add_css_upload_form_html_field'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";

                    echo "</div>";

                    $htCount++;
                    $htHiddenCount++;

                }


                if(@$value->Field_Type == 'caRo-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtyp
                    // 2 = Feldtitel
                    // 3 = Feldinhalt


                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$caRoCount'  class='formField captchaRoField'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";

                    echo "<div class='formFieldInnerDiv'>";
                    echo "<input type='hidden' name='upload[$id][type]' value='caRo'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$caRoCount' titel='$id'>";

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";


                    foreach($fieldContent as $key => $value){
                        $value = html_entity_decode(stripslashes($value));
                        if($key=='titel'){
                            echo "<strong>Simple Captcha - I am not a robot</strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='checkbox' disabled> <input type='text' name='upload[$id][title]' value='$value' size='30' maxlength='1000'/>$deleteField</div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                    }

                    echo "<br/><br/>Required <input type='checkbox' class='necessary-check' disabled checked >";
                    echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                    echo "<br/>";



                    echo "</div>";
                    echo "</div>";


                    $caRoCount++;
                    $caRoHiddenCount++;

                }

                if(@$value->Field_Type == 'caRoRe-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtyp
                    // 2 = Feldtitel
                    // 3 = Feldinhalt


                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $ReCaKey = $value->ReCaKey;
                    $ReCaLang = $value->ReCaLang;
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$caRoReCount'  class='formField captchaRoReField'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";

                    echo "<div class='formFieldInnerDiv'>";
                    echo "<input type='hidden' name='upload[$id][type]' value='caRoRe'>";

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$caRoReCount' titel='$id' >";

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";


                    foreach($fieldContent as $key => $value){
                        $value = html_entity_decode(stripslashes($value));
                        if($key=='titel'){

                            /*                    if (($handle = fopen(__DIR__."/recaptcha-lang-options.csv", "r")) !== FALSE) {

                                                    $newLangCodesArray = array();

                                                    while(($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                                                        $newLangCodesArray[$data[1]] = $data[0];
                                                    }
                                                    fclose($handle);
                                                }


                                                $fp = fopen(__DIR__."/recaptcha-lang-options.php", 'w');
                                                fwrite($fp, $masterReturn);
                                                fclose($fp);*/
                            echo "<strong>Google reCAPTCHA - I am not a robot (can be rendered only 1 time on a page)</strong><br/>";

                            $langOptions = include(__DIR__.'/../data/recaptcha-lang-options.php');

                            echo '<div class=\'cg_name_field_and_delete_button_container\'><select id="cgReCaLang" name="upload['.$id.'][ReCaLang]">';

                            echo "<option value='' >Please select language</option>";

                            foreach($langOptions as $langKey => $lang){

                                if($ReCaLang==$langKey){
                                    echo "<option value='$langKey' selected>$lang</option>";
                                }else{
                                    echo "<option value='$langKey' >$lang</option>";
                                }
                            }

                            echo '</select>';

                            echo "$deleteField<br/></div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                            echo "<strong>Website Key</strong><br/>";
                            echo "<div style='display:flex;align-items:center;'><input type='text' name='upload[$id][ReCaKey]' class='cg_reca_key' placeholder='Example Key: 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI' size='30' maxlength='1000' value='$ReCaKey'/>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                            echo "<img src='$cgRecaptchaIconUrl' title='Insert Google reCAPTCHA test key' alt='Insert Google reCAPTCHA test key' class='cg_recaptcha_icon' /></div>";


                        }

                    }

                    echo "<br/><br/>Required <input type='checkbox' class='necessary-check' disabled checked >";
                    echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                    echo "<br/>";



                    echo "</div>";
                    echo "</div>";


                    $caRoReCount++;

                }

                // Admin fields here

                if(@$value->Field_Type == 'select-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtyp
                    // 2 = Feldtitel
                    // 3 = Feldinhalt


                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    // Anfang des Formularteils
                    echo "<div id='$seCount'  class='formField cg_se_field selectField'>";
                    echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";

                    echo "<div class='formFieldInnerDiv'>";
                    echo "<input type='hidden' name='upload[$id][type]' value='se'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";// Neuer Wert in der Datebank

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$seCount' titel='$id'>";

                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}


                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}


                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));
                        if($key=='titel'){
                            echo "<strong>Select </strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input type='text' name='upload[$id][title]' placeholder='Title of your select box' value='$value' size='30' maxlength='1000'/>$deleteField<br/></div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($key=='content'){

                            //$value = nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
                            echo "<textarea name='upload[$id][content]' maxlength='10000' style='width:856px;' placeholder='Each row one value - Example: &#10;value1&#10;value2&#10;value3&#10;value4&#10;value5&#10;value6'  rows='10'>$value</textarea><br/>";

                        }

                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";

                            $seCount++;
                            $seHiddenCount++;

                        }

                    }

                    echo "</div>";
                    echo "</div>";

                }

                if(@$value->Field_Type == 'selectc-f'){

                    // Feldtyp
                    // Feldreihenfolge
                    // 1 = Feldtyp
                    // 2 = Feldtitel

                    //ermitteln der Feldnummer
                    $fieldOrder = $value->Field_Order;
                    $fieldOrderKey = "$fieldOrder";
                    $id = $value->id; // Unique ID des Form Feldes
                    $idKey = "$id";
                    if($value->Active==0){
                        $hideChecked = "checked='checked'";
                    }
                    else{
                        $hideChecked = "";
                    }

                    $categories = $wpdb->get_results("SELECT * FROM $tablename_categories WHERE GalleryID = '$GalleryID' ORDER BY Field_Order ASC");
                    // Anfang des Formularteils
                    echo "<div id='$secCount'  class='formField cg_sec_field selectCategoriesField' >";
                    echo "<div class='cg_drag_area' id='cgSelectCategoriesField'><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

                    echo "<input type='hidden' class='fieldOrder' name='upload[$id][order]' value='$fieldOrder'>";

                    echo "<div class='formFieldInnerDiv'>";
                    echo "<input type='hidden' name='upload[$id][type]' value='sec'>";
                    // Prim�re ID in der Datenbank
                    //echo "<input type='hidden' name='upload[$id]' value='$fieldOrder' class='changeUploadFieldOrder'>";
                    //SWAP Values
                    //echo "<input type='hidden' name='changeFieldRow[$fieldOrder]' value='$fieldOrder' class='changeFieldOrderUsersEntries'>";// Neuer Wert in der Datebank

                    echo "<input type='hidden' value='$fieldOrder' class='fieldnumber'>";

                    // Feld l�schen M�glichkeit
                    $deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$secCount' titel='$id'>";

                    if($id==@$Field1IdGalleryView){$checked='checked';}
                    else{$checked='';}


                    @$Show_Slider = $wpdb->get_var("SELECT Show_Slider FROM $tablename_form_input WHERE id = '$id'");

                    if(@$Show_Slider==1){$checkedShow_Slider='checked';}
                    else{$checkedShow_Slider='';}


                    if($id==$Field2IdGalleryView){$checkedShowTag='checked';}
                    else{$checkedShowTag='';}


                    echo "<div class='cg_info_show_slider_container'>";

                    echo "$cg_info_show_slider_title: &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_slider' style='margin-top:0px;' name='upload[$id][infoInSlider]' $checkedShow_Slider>";
                    echo "</div>";

                    echo "<div class='cg_info_show_gallery_container'>";

                    echo "$cg_info_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_info_show_gallery' style='margin-top:0px;' name='upload[$id][infoInGallery]' $checked>";
                    echo "</div>";

                    echo "<div class='cg_tag_show_gallery_container'>";
                    echo "$cg_tag_show_gallery_title:  &nbsp;";
                    echo "<input type='checkbox' class='cg_tag_show_gallery' style='margin-top:0px;' name='upload[$id][tagInGallery]' $checkedShowTag>";
                    echo "</div>";

                    echo "<br>";
                    echo "<hr>";

                    echo '<div style="padding-top: 7px;text-align: center;padding-bottom: 6px;">Note: you can control which categories should be displayed in backend images area of this gallery</div>';

                    // Formularfelder unserializen
                    $fieldContent = unserialize($value->Field_Content);

                    // Aktuelle Feld ID mit schicken
                    echo "<input type='hidden' name='actualID[]' value='$id' >";

                    $checkCategory = false;

                    foreach($fieldContent as $key => $value){

                        $value = html_entity_decode(stripslashes($value));
                        if($key=='titel'){
                            echo "<strong>Select Categories</strong><br/>";
                            echo "<div class='cg_name_field_and_delete_button_container'><input class='cg_add_category cg_backend_button_gallery_action' type='button' value='Add Category'>";
                            echo "<input type='text' name='upload[$id][title]' value='$value' placeholder='Title of your select category box' size='30' maxlength='1000'/>$deleteField<br/></div>";// Titel und Delete M�glichkeit die oben bestimmt wurde
                        }

                        if($checkCategory==false){
                            echo "<br><div class='cg_categories_arena'>";

                            $cOrder = 1;

                            foreach($categories as $category){

                                echo '<div class="cg_category_field_div">
                        <div class="cg_category_change_order cg_move_view_to_top"></div>
                        <div class="cg_category_change_order cg_move_view_to_bottom"></div>
                        <div class="cg_name_field_and_delete_button_container">
                            <input class="cg_category_field" placeholder="Category'.$cOrder.'" value="'.$category->Name.'" name="cg_category[id]['.$category->id.']" type="text" />
                            <input class="cg_delete_category_field" type="button" value="-" data-delete="'.$category->id.'">
                        </div>
                        </div>';

                                $cOrder++;
                            }

                         echo '<div id="cgCategoryFieldDivOther">
                        <input class="cg_category_field cg_disabled" value="Other" type="text" />
                         &nbsp;All uncategorized images has category Other. Frontend translation for Other in  can be found <a class="cg_load_backend_link"
                          data-cg-go-to="cgTranslationOtherHashLink" href="?page=contest-gallery/index.php&edit_options=true&option_id='.$GalleryID.'" target="_blank">here...</a>
                        </div>';


                            echo "</div>";
                            // echo '<div class="cg_delete_category_field_div"><input class="cg_category_field" type="text" /><input class="cg_delete_category_field" type="button" value="-" style="width:20px;" alt="90"></div>';
                            $checkCategory = true;
                        }


                        if($key=='mandatory'){

                            $checked = ($value=='on') ? "checked" : "";

                            echo "<br/>Required <input type='checkbox' class='necessary-check' name='upload[$id][required]' $checked >";
                            echo "<span class='cg-active'>Hide <input type='checkbox' name='upload[$id][hide]' $hideChecked ></span>";
                            echo "<br/>";


                            $secCount++;
                            //     $secHiddenCount++;

                        }

                    }

                    echo "</div>";
                    echo "</div>";

                }



            }





        }


        ?>
    </div>

</div>

<div style="display:block;padding:20px;padding-bottom:10px;background-color:white;width:895px;text-align:right;margin-top:15px;border: thin solid black;height:40px;">
    <input id="submitForm" type="submit" name="submit" class="cg_backend_button_gallery_action" value="Save form" style="text-align:center;width:180px;float:right;margin-right:10px;margin-bottom:10px;">
</div>
<br/>



<?php


// ---------------- AUSGABE des gespeicherten Formulares  --------------------------- ENDE

echo "<br/>";
?>
</form>