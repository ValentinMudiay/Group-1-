<?php
require_once('get-data-create-registry.php');
require_once(dirname(__FILE__) . "/../../../nav-menu.php");

$iconsURL = plugins_url().'/contest-gallery/v10/v10-css';

$cgRecaptchaIconUrl = $iconsURL.'/backend/re-captcha.png';
$cgDragIcon = $iconsURL.'/backend/cg-drag-icon.png';


echo "<input type='hidden' id='cgDragIcon' value='$cgDragIcon'/>";
echo "<input type='hidden' id='cgRecaptchaIconUrl' value='$cgRecaptchaIconUrl'/>";
echo "<input type='hidden' id='cgRecaptchaKey' value='6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI'/>";


function cg_cg_set_default_editor() {
    $r = 'html';
    return $r;
}
add_filter( 'wp_default_editor', 'cg_cg_set_default_editor' );

/*$tinymceStyle = '<style type="text/css">
				   .wp-editor-area{height:200px;}
				   </style>';*/

/*$timymceSettings = array(
    'plugins' => "preview",
    'menubar' => "view",
    'toolbar' => "preview",
    'plugin_preview_width'=> 650,
    'selector' => "textarea"
);*/
/*
$settingsHTMLarea = array(
    "media_buttons"=>false,
    'editor_class' => 'tmce-active Field_Content',
    'default_post_edit_rows'=> 10,
   // "textarea_name"=>'upload[]',
    "teeny" => true,
    "dfw" => true,
    'editor_css' => $tinymceStyle
);*/

/*echo "<div id='cgTinymceCollection'>";
for($i=0;$i<=10;$i++){

    $editor_id = "htmlFieldTemplate$i";

    // TinyMCE Editor to take as copy for template
    echo "<div id='htmlEditorTemplateDiv$i' data-wp-editor-id='$editor_id' class='htmlEditorTemplateDiv' style='display:none;'>";


    $testVal = "";

    wp_editor($testVal, $editor_id, $settingsHTMLarea);

    echo "</div>";

}
echo "</div>";*/


/*echo "<div id='cgTinymceCollectionForAgreement'>";
for($i=0;$i<=10;$i++){

    $editor_id = "htmlFieldTemplateForAgreement$i";

    // TinyMCE Editor to take as copy for template
    echo "<div id='htmlEditorTemplateDivForAgreement$i' data-wp-editor-id='$editor_id' class='htmlEditorTemplateDivForAgreement' style='display:none;'>";

    $testVal = "";

    wp_editor($testVal, $editor_id, $settingsHTMLarea);

    echo "</div>";

}
echo "</div>";*/

// recaptcha-lang-options.php
$langOptions = include(__DIR__.'/../../../data/recaptcha-lang-options.php');

echo '<select name="ReCaLang" id="cgReCaLangToCopy" class="cg_hide">';

echo "<option value='' >Please select language</option>";

foreach($langOptions as $langKey => $lang){

    echo "<option value='$langKey' >$lang</option>";

}

echo '</select>';




	//<div style="display:block;padding:20px;padding-bottom:10px;background-color:white;width:897px;text-align:right;margin-top:10px;border: thin solid black;height:40px;">

echo '<div id="cgRegForm">';
/*if ($checkDataFormOutput){
echo "<form method='POST' action='?page=contest-gallery/index.php&option_id=$GalleryID&define_output=true'><input type='submit' value='Single pic info' style='float:right;text-align:center;width:180px;'/></form>";
}*/
//echo "<form name='defineUpload' enctype='multipart/form-data' action='?page=contest-gallery/index.php&optionID=$GalleryID&defineUpload=true' id='form' method='post'>";

		//<option value="ef">E-Mail</option>
		//<option value="cb">Check agreement</option>

$heredoc = <<<HEREDOC
	<select name="dauswahl" id="dauswahl" >
		<optgroup label="User fields">
			<option value="nf">Input</option>
			<option value="kf">Textarea</option>
			<option value="se">Select</option>
			<option value="cb" class="$cgProFalse">Check agreement $cgProFalseText</option>
		</optgroup>
		<optgroup label="Admin fields">
			<option class="$cgProFalse" value="ht">HTML $cgProFalseText</option>
			<option  value="caRo">Simple Captcha - I am not a robot</option>
			<option  value="caRoRe">Google reCAPTCHA - I am not a robot</option>
		 </optgroup>
	</select>
	<input id="cg_create_upload_add_field" class="cg_registry_dauswahl" type="button" name="plus" value="+" >
	<span style="font-size: 22px;margin-left:auto;">Registration form</span>
	</div>
HEREDOC;

echo $heredoc;

if (!empty($_POST['submit'])) {

    echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>";

}


echo "<form name='create_user_form' enctype='multipart/form-data' class='cg_load_backend_submit' action='?page=contest-gallery/index.php&option_id=$GalleryID&create_user_form=true' id='form' method='post'>";
wp_nonce_field( 'cg_admin');
echo "<input type='hidden' name='option_id' value='$GalleryID'>";
?>
<div style="width:935px;background-color:#fff;border: thin solid black;padding-bottom:15px;">
<div id="ausgabe1" class="cg_registry_form_container" style="display:table;width:875px;padding:20px 20px 20px 29px;background-color:#fff;">

<?php	
	

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
@$caRoReCount = 90;

// Further IDs of the div boxes
@$nfHiddenCount = 100;
@$kfHiddenCount = 200;
@$efHiddenCount = 300;
@$bhHiddenCount = 400;
@$htHiddenCount = 500;
@$cbHiddenCount = 600;
@$seHiddenCount = 700;
@$caRoHiddenCount = 800;
@$caRoReHiddenCount = 900;


// FELDBENENNUNGEN

// 1 = Feldtyp
// 2 = Feldnummer
// 3 = Feldtitel
// 4 = Feldinhalt
// 5 = Feldkrieterium1
// 6 = Feldkrieterium2
// 7 = Felderfordernis

//print_r($selectFormInput);

// Zum z�hlen von Feld Reihenfolge
$i = 1;

if ($selectFormInput) {

	foreach ($selectFormInput as $key => $value) {
	

		if(@$value->Field_Type == 'main-mail'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$fieldOrderKey = "$fieldOrder";
		$id = $value->id; // Unique ID des Form Feldes
		$idKey = "$id";
		
	
		// Anfang des Formularteils
		echo "<div id='cg_main-mail'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";


            echo "<div class='formFieldInnerDiv'>";
            echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";

            echo "<strong>WP-Email</strong><br/>";
		
		echo "<input type='hidden' class='Field_Order' value='$Field_Order'>";
		
				
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
				
		// Aktuelle Feld ID mitschicken. $i Aufz�hlung ist hier nicht notwendig. Wird f�r update entries verwendet.
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";		
					
					echo "<input type='text' class='Field_Name'  name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'> (Login user email: Wordpress-Profile-Field)<br/>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<input type='text' class='Field_Content' name='Field_Content[$i]' value='$Field_Content' placeholder='Placeholder' id='main-mail' maxlength='1000' style='width:855px;'><br/><br/>";
										
					
					echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' checked disabled >";


            echo "<br/></div>";
					echo "</div>";

		}	
					
		
		if(@$value->Field_Type == 'password'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$fieldOrderKey = "$fieldOrder";
		$id = $value->id; // Unique ID des Form Feldes
		$idKey = "$id";
		
		// Anfang des Formularteils
		echo "<div id='cg_password'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";

            echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";

            echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
        echo "<strong>WP-Password</strong><br/>";
		
		echo "<input type='hidden' class='cg_actualID' class='Field_Order' value='$Field_Order'>";
		
				
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
				
		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' name='actualID[]' value='$id' >";		
					
					echo "<input type='text' class='Field_Name'  name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'> (Login user password: Wordpress-Profile-Field)<br/>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<input type='text' class='Field_Content' name='Field_Content[$i]' value='$Field_Content' placeholder='Placeholder' id='password' maxlength='1000' style='width:855px;'><br/>";
										
					echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='Min_Char[$i]' value='$Min_Char' size='7' maxlength='4' ><br/>";
										
					echo "Max. number of characters: <input type='text' class='Max_Char' name='Max_Char[$i]' value='$Max_Char' size='7' maxlength='4' ><br/><br/>";


					
					echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' checked disabled >";



            echo "<br/></div></div>";
	
		}
		
		if(@$value->Field_Type == 'password-confirm'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$fieldOrderKey = "$fieldOrder";
		$id = $value->id; // Unique ID des Form Feldes
		$idKey = "$id";
		
		// Anfang des Formularteils
		echo "<div id='cg_password-confirm'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";

		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
        echo "<strong>WP-Password-Confirm</strong><br/>";
		echo "<input type='hidden' class='cg_actualID' class='Field_Order' value='$Field_Order' >";
		
				
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
				
		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' name='actualID[]' value='$id' >";		
					
					echo "<input type='text' name='Field_Name[$i]' class='Field_Name'  value='$Field_Name'  size='30' maxlength='100'> (Confirm login user password: Wordpress-Profile-Field)<br/>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<input type='text' class='Field_Content' name='Field_Content[$i]' value='$Field_Content' placeholder='Placeholder' id='password-confirm' maxlength='1000' style='width:855px;'><br/>";
										
					echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='Min_Char[$i]' value='$Min_Char' size='7' maxlength='4' ><br/>";
										
					echo "Max. number of characters: <input type='text' class='Max_Char' name='Max_Char[$i]' value='$Max_Char' size='7' maxlength='4' ><br/><br/>";


            echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' checked disabled >";



            echo "<br/></div></div>";


		}
		
		
		
		if(@$value->Field_Type == 'main-user-name'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis 
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$fieldOrderKey = "$fieldOrder";
		$id = $value->id; // Unique ID des Form Feldes
		$idKey = "$id";
		
		// Anfang des Formularteils
		echo "<div id='cg_main-user-name'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";
		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
        echo "<strong>WP-Nickname</strong><br/>";
				
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
		
		echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";

		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";		
					
					echo "<input type='text' class='Field_Name' name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'> (Frontend shown nickname: Wordpress-Profile-Field)<br/>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<input type='text' class='Field_Content' name='Field_Content[$i]' value='$Field_Content' placeholder='Placeholder' maxlength='1000' style='width:855px;'><br/>";
										
					echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='Min_Char[$i]' value='$Min_Char' size='7' maxlength='4' ><br/>";
										
					echo "Max. number of characters: <input type='text' class='Max_Char' name='Max_Char[$i]' value='$Max_Char' size='7' maxlength='4' ><br/><br/>";
					
					echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' checked disabled >";



            echo "<br/></div></div>";
	
	
		}
		
		
		if(@$value->Field_Type == 'user-text-field'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis 
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$cg_Necessary = $value->Required;
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
		echo "<div id='cg$nfCount'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";
		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
        echo "<strong>Input</strong><br>";
		echo "<input type='hidden' class='cg_Field_Text_Type' >"; // Zum Z�hlen von Text Feldern
		echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";
		
				
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
		
		// Feld l�schen M�glichkeit
		@$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$nfCount' titel='$id'><input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";
				
		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";		
					
					echo "<div class='cg_name_field_and_delete_button_container'><input type='text' class='Field_Name' name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<input type='text' class='Field_Content' name='Field_Content[$i]' value='$Field_Content' placeholder='Placeholder' maxlength='1000' style='width:855px;'><br/>";
										
					echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='Min_Char[$i]' value='$Min_Char' size='7' maxlength='4' ><br/>";
										
					echo "Max. number of characters: <input type='text' class='Max_Char' name='Max_Char[$i]' value='$Max_Char' size='7' maxlength='4' ><br/><br/>";
					
					if($cg_Necessary==1){$cg_Necessary_checked="checked";}
					else{$cg_Necessary_checked="";}
					
					echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' $cg_Necessary_checked >";

					echo "<span class='cg-active'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";

					
					echo "<br/></div></div>";

					$nfCount++;
					$nfHiddenCount++;			
	
		}


		if(@$value->Field_Type == 'user-comment-field'){

		// Feldtyp
		// Feldreihenfolge
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis

		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$cg_Necessary = $value->Required;
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
		echo "<div id='cg$nfCount'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";
		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
        echo "<strong>Textarea</strong><br>";

		echo "<input type='hidden' class='cg_Field_Comment_Type' >"; // Zum Z�hlen von Text Feldern
		echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";


		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";

		// Feld l�schen M�glichkeit
		@$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$nfCount' titel='$id'><input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";

		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";

					echo "<div class='cg_name_field_and_delete_button_container'><input type='text' class='Field_Name' name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<textarea class='Field_Content' name='Field_Content[$i]' placeholder='Placeholder' maxlength='10000' style='width:856px;' rows='10' >$Field_Content</textarea><br/>";

					echo "Min. number of characters:&nbsp; <input type='text' class='Min_Char' name='Min_Char[$i]' value='$Min_Char' size='7' maxlength='4' ><br/>";

					echo "Max. number of characters: <input type='text' class='Max_Char' name='Max_Char[$i]' value='$Max_Char' size='7' maxlength='4' ><br/><br/>";

					if($cg_Necessary==1){$cg_Necessary_checked="checked";}
					else{$cg_Necessary_checked="";}

					echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' $cg_Necessary_checked >";

            echo "<span class='cg-active'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";


            echo "<br/></div></div>";

					$nfCount++;
					$nfHiddenCount++;

		}
		
		
		if(@$value->Field_Type == 'user-select-field'){

		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis 
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$cg_Necessary = $value->Required;
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
		echo "<div id='cg$kfCount'  class='formField cg_se_field'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";
		echo "<strong>Select</strong><br>";
		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
		
		echo "<input type='hidden' class='cg_Field_Select_Type' >"; // Zum Z�hlen von Text Feldern
		echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";		
		
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
		
		// Feld l�schen M�glichkeit
		@$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$kfCount' titel='$id'><input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";
				
		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";		
					
					echo "<div class='cg_name_field_and_delete_button_container'><input type='text' class='Field_Name' name='Field_Name[$i]'  value='$Field_Name' placeholder='Title of your select box' size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde

					echo "<textarea class='Field_Content' name='Field_Content[$i]' placeholder='Each row one value - Example: &#10;value1&#10;value2&#10;value3&#10;value4&#10;value5&#10;value6' maxlength='10000' style='width:856px;' rows='10'>$Field_Content</textarea><br/><br/>";

					if($cg_Necessary==1){$cg_Necessary_checked="checked";}
					else{$cg_Necessary_checked="";}
					
					echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' $cg_Necessary_checked >";

            echo "<span class='cg-active'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";



            echo "<br/></div></div>";

					$seCount++;
					$seHiddenCount++;
	
		}
		
		
		if(@$value->Field_Type == 'user-check-agreement-field'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis 
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		//$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
        $Field_Content = contest_gal1ery_convert_for_html_output_without_nl2br($value->Field_Content);
        $Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$cg_Necessary = $value->Required;
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
		echo "<div id='cg$cbCount'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

        echo "<div class='formFieldInnerDiv'>";
		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
		
		echo "<input type='hidden' class='cg_Field_Check_Agreement_Type' >"; // Zum Z�hlen von Text Feldern
		echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";
		
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
		
		// Feld l�schen M�glichkeit
		@$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$cbCount' titel='$id'><input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";
				
		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";		
					
					echo "<div class='cg_name_field_and_delete_button_container'><input type='text' class='Field_Name' name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete Möglichkeit die oben bestimmt wurde
				
				//	echo "<input type='checkbox' disabled><input type='text' class='Field_Content' name='Field_Content[$i]' placeholder='HTML tags allowed' value='$Field_Content' id='user-check-agreement-field' maxlength='1000' style='width:832px;'><br/><br/>";
            $editor_id = "htmlFieldForAgreement$cbCount";

            // TinyMCE Editor
            echo "<div class='cgCheckAgreementContainer'>";
            echo "<div class='cgCheckAgreementCheckbox'>";
            echo "<input type='checkbox' disabled>";
            echo "</div>";
            echo "<div class='cgCheckAgreementHtml cg-wp-editor-container'>";


/*            $settingsHTMLarea = array(
                "media_buttons"=>false,
                'editor_class' => 'tmce-active Field_Content',
                'default_post_edit_rows'=> 10,
                "textarea_name"=>"Field_Content[$i]",
                "teeny" => true,
                "dfw" => true,
                'editor_css' => $tinymceStyle
            );*/

            echo "<textarea class='cg-wp-editor-template Field_Content' id='$editor_id' name='Field_Content[$i]'>$Field_Content</textarea>";

            //wp_editor( $Field_Content, $editor_id, $settingsHTMLarea);

            //  echo "<input type='text' name='upload[$id][content]' class='cb'  maxlength='1000' style='width:832px;' placeholder='HTML tags allowed' value='$value'><br/>";
            echo "</div>";
            echo "</div>";

            if($cg_Necessary==1){$cg_Necessary_checked="checked";}
            else{$cg_Necessary_checked="";}

            echo "<br/>";
            echo "Required <input type='checkbox' class='necessary-check' name='Necessary[$i]' $cg_Necessary_checked >";

            echo "<span class='cg-active'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";

            echo "<br/></div></div>";

					$cbCount++;
					$cbHiddenCount++;			
	
		}


        if(@$value->Field_Type == 'user-robot-field'){

            // Feldtyp
            // Feldreihenfolge
            // 1 = Feldtitel
            // 2 = Feldinhalt
            // 3 = Feldkrieterium1
            // 4 = Feldkrieterium2
            // 5 = Felderfordernis

            //ermitteln der Feldnummer
            $fieldOrder = $value->Field_Order;
            $Min_Char = $value->Min_Char;
            $Max_Char = $value->Max_Char;
            $Field_Name = html_entity_decode(stripslashes($value->Field_Name));
            $Field_Content = html_entity_decode(stripslashes($value->Field_Content));
            $Field_Order = $value->Field_Order;
            $Field_Type = $value->Field_Type;
            $cg_Necessary = $value->Required;
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
            echo "<div id='cg$caRoCount'  class='formField captchaRoField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";
		    echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";

            echo "<input type='hidden' class='cg_Field_Robot_Type' >"; // Zum Z�hlen von Text Feldern
            echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";

            echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";

            // Feld l�schen M�glichkeit
            @$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$caRoCount' titel='$id'><input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";

            // Aktuelle Feld ID mitschicken
            echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";
            echo "<strong>Simple Captcha - I am not a robot</strong><br/>";
            echo "<div class='cg_name_field_and_delete_button_container'><input type='checkbox' disabled>";
            echo "<input type='text' class='Field_Name' placeholder='I am not a robot' name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'>$deleteField<br/></div><br/>"; // Titel und Delete Möglichkeit die oben bestimmt wurde

            echo "Required <input type='checkbox' class='necessary-check' checked disabled>";
            echo "<span class='cg-active'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";


            echo "<br/></div></div>";

            $caRoCount++;
            $caRoHiddenCount++;

        }


        if(@$value->Field_Type == 'user-robot-recaptcha-field'){

            // Feldtyp
            // Feldreihenfolge
            // 1 = Feldtitel
            // 2 = Feldinhalt
            // 3 = Feldkrieterium1
            // 4 = Feldkrieterium2
            // 5 = Felderfordernis

            //ermitteln der Feldnummer
            $fieldOrder = $value->Field_Order;
            $Min_Char = $value->Min_Char;
            $Max_Char = $value->Max_Char;
            $Field_Name = html_entity_decode(stripslashes($value->Field_Name));
            $Field_Content = html_entity_decode(stripslashes($value->Field_Content));
            $Field_Order = $value->Field_Order;
            $Field_Type = $value->Field_Type;
            $ReCaKey = $value->ReCaKey;
            $ReCaLang = $value->ReCaLang;
            $cg_Necessary = $value->Required;
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
            echo "<div id='cg$caRoReCount'  class='formField captchaRoReField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

            echo "<div class='formFieldInnerDiv'>";
		    echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='user-robot-recaptcha-field'>";

            echo "<input type='hidden' class='cg_Field_Robot_Type' >"; // Zum Z�hlen von Text Feldern
            echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";

            echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";

            // Feld l�schen M�glichkeit
            @$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$caRoReCount' titel='$id'><input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";

            // Aktuelle Feld ID mitschicken
            echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";


            echo "<strong>Google reCAPTCHA - I am not a robot (can be rendered only 1 time on a page)</strong><br/>";

            $langOptions = include(__DIR__.'/../../../data/recaptcha-lang-options.php');

            echo '<div class=\'cg_name_field_and_delete_button_container\'><select id="cgReCaLang" name="ReCaLang">';

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
            echo "<input type='text' name='ReCaKey' placeholder='Example Key: 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI' class='cg_reca_key' size='30' maxlength='1000' value='$ReCaKey'/>";// Titel und Delete M�glichkeit die oben bestimmt wurde
            echo "<img src='$cgRecaptchaIconUrl' title='Insert Google reCAPTCHA test key' alt='Insert Google reCAPTCHA test key' class='cg_recaptcha_icon' />";


            echo "<br/><br/>Required <input type='checkbox' class='necessary-check' checked disabled>";
            echo "<span class='cg-active'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";


            echo "<br/></div></div>";

            $caRoReCount++;
            $caRoReHiddenCount++;

        }

		
		if(@$value->Field_Type == 'user-html-field'){
		
		// Feldtyp
		// Feldreihenfolge 
		// 1 = Feldtitel
		// 2 = Feldinhalt
		// 3 = Feldkrieterium1
		// 4 = Feldkrieterium2
		// 5 = Felderfordernis 
		
		//ermitteln der Feldnummer
		$fieldOrder = $value->Field_Order;
		$Min_Char = $value->Min_Char;
		$Max_Char = $value->Max_Char;
		$Field_Name = html_entity_decode(stripslashes($value->Field_Name));
		//$Field_Content = html_entity_decode(stripslashes($value->Field_Content));
        $Field_Content = contest_gal1ery_convert_for_html_output_without_nl2br($value->Field_Content);
		$Field_Order = $value->Field_Order;
		$Field_Type = $value->Field_Type;
		$cg_Necessary = $value->Required;
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
		echo "<div id='cg$htCount'  class='formField'>";
            echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";

        echo "<div class='formFieldInnerDiv'>";
		echo "<input type='hidden' class='Field_Type' name='Field_Type[$i]' value='$Field_Type'>";
        echo "<strong>HTML</strong><br/>";
		
		echo "<input type='hidden' class='cg_Field_HTML_Type' >"; // Zum Z�hlen von Text Feldern
		echo "<input type='hidden' class='Field_Order' value='$Field_Order' >";		
		
		echo "<input type='hidden' class='Field_Id' name='Field_Id[$i]' value='$id' >";
		
		// Feld l�schen M�glichkeit
		@$deleteField = "<input class='cg_delete_form_field' type='button' value='-' alt='$htfCount' titel='$id'> &nbsp; (HTML Field - Title is invisible)<input type='hidden' name='originalRow[$key]' value='$fieldOrder'>";
				
		// Aktuelle Feld ID mitschicken
		echo "<input type='hidden' class='cg_actualID' name='actualID[]' value='$id' >";		
		
		echo "<div class='cg_name_field_and_delete_button_container'><input type='text' class='Field_Name' name='Field_Name[$i]' value='$Field_Name'  size='30' maxlength='100'>$deleteField<br/></div>"; // Titel und Delete M�glichkeit die oben bestimmt wurde
        echo "<hr>";

            $editor_id = "htmlField$htCount";

            // TinyMCE Editor
            echo "<div class='cg-wp-editor-container'>";

/*            $settingsHTMLarea = array(
                "media_buttons"=>false,
                'editor_class' => 'tmce-active Field_Content',
                'default_post_edit_rows'=> 10,
                "textarea_name"=>"Field_Content[$i]",
                "teeny" => true,
                "dfw" => true,
                'editor_css' => $tinymceStyle
            );*/

            echo "<textarea class='cg-wp-editor-template Field_Content' id='$editor_id' name='Field_Content[$i]'>$Field_Content</textarea>";

            //wp_editor( $Field_Content, $editor_id, $settingsHTMLarea);

		echo "</div>";

            echo "<span class='cg-active cg_add_css_upload_form_html_field'>Hide <input type='checkbox' name='hide[]' $hideChecked ></span>";


            echo "</div>";
            echo "</div>";

		$htCount++;
		$htHiddenCount++;
	
		}



		// Zum z�hlen von Feld Reihenfolge
		$i++;
		
	}
}


?>
</div>

</div>

<div style="display:block;padding:20px;padding-bottom:10px;background-color:white;width:895px;text-align:right;margin-top:15px;border: thin solid black;height:40px;">
    <input type="hidden" name="submit" value="true"/>
<input id="submitForm" class="cg_backend_button_gallery_action" type="submit" value="Save form" style="text-align:center;width:180px;float:right;margin-right:10px;margin-bottom:10px;">
</div>
<br/>



<?php


// ---------------- AUSGABE des gespeicherten Formulares  --------------------------- ENDE

echo "<br/>";
?>
</form>