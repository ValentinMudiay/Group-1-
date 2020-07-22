<?php

/*error_reporting(E_ALL); 
ini_set('display_errors', 'On');*/

/*echo "<pre>";
echo print_r($_POST);
echo "</pre>";*/

	$start = 0; // Startwert setzen (0 = 1. Zeile)
	$step =10;

	if (isset($_GET["start"])) {
	  $muster = "/^[0-9]+$/"; // reg. Ausdruck f�r Zahlen
	  if (preg_match($muster, @$_GET["start"]) == 0) {
		$start = 0; // Bei Manipulation R�ckfall auf 0
	  } else {
		$start = intval(@$_GET["start"]);
	  }
	}
	
	if (isset($_GET["step"])) {
	  $muster = "/^[0-9]+$/"; // reg. Ausdruck f�r Zahlen
	  if (preg_match($muster, @$_GET["start"]) == 0) {
		$step = 10; // Bei Manipulation R�ckfall auf 0  
	  } else {
		$step = intval(@$_GET["step"]);
	  }
	}
	
	global $wpdb;

	// Set table names
	$tablename = $wpdb->prefix . "contest_gal1ery";
$table_posts = $wpdb->prefix."posts";
$table_users = $wpdb->prefix."users";
$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
$tablenameentries = $wpdb->prefix . "contest_gal1ery_entries";
$tablename_categories = $wpdb->prefix . "contest_gal1ery_categories";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
$tablename_comments = $wpdb->prefix . "contest_gal1ery_comments";
$tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";

$tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";

// check which fileds are allowed for json save because allowed gallery or single view
$uploadFormFields = $wpdb->get_results("SELECT * FROM $tablename_form_input WHERE GalleryID = $GalleryID");
$Field1IdGalleryView = $wpdb->get_var("SELECT Field1IdGalleryView FROM $tablename_options_visual WHERE GalleryID = $GalleryID");

$fieldsForFrontendArray = array();

foreach($uploadFormFields as $field){
    if($field->id==$Field1IdGalleryView or $field->Show_Slider==1){
        $fieldsForFrontendArray[]=$field->id;
    }
}

$fieldsForSaveContentArray = array();

foreach($uploadFormFields as $field){
    if(empty($fieldsForSaveContentArray[$field->id] )){
        $fieldsForSaveContentArray[$field->id] = array();
    }
    $fieldsForSaveContentArray[$field->id]['Field_Type'] = $field->Field_Type;
    $fieldsForSaveContentArray[$field->id]['Field_Order'] = $field->Field_Order;
    $fieldContent = unserialize($field->Field_Content);
    $fieldsForSaveContentArray[$field->id]['Field_Title'] = $fieldContent['titel'];
    if($field->Field_Type=='date-f'){
        $fieldsForSaveContentArray[$field->id]['Field_Format'] = $fieldContent['format'];
    }
}


$wpUsers = $wpdb->base_prefix . "users";

$imageInfoArray = array();

$wp_upload_dir = wp_upload_dir();

$jsonUpload = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json';
$jsonUploadImageData = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-data';
$jsonUploadImageInfoDir = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info';
$jsonUploadImageCommentsDir = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-comments';

$thumbSizesWp = array();
$thumbSizesWp['thumbnail_size_w'] = get_option("thumbnail_size_w");
$thumbSizesWp['medium_size_w'] = get_option("medium_size_w");
$thumbSizesWp['large_size_w'] = get_option("large_size_w");

$uploadFolder = wp_upload_dir();

$activate = '';
if(!empty($_POST['active'])){
    $activate = $_POST['active'];
}



if(!empty($_POST['row'])){
    $rowids = $_POST['row'];
}else{
    $rowids = [];
}

$chooseAction1 = 0;

if(!empty($_POST['chooseAction1'])){
    $chooseAction1 = $_POST['chooseAction1'];
}

$content = array();

if(!empty($_POST['content'])){
    $content = $_POST['content'];
}

// unset rowids if Deleted!!!!
if($chooseAction1==3){
    if(!empty($activate)){

        foreach($activate as $key => $value){
            unset($rowids[$key]);
        }

    }
    if(!empty($content)){

        foreach($activate as $key => $value){
            unset($content[$key]);
        }

    }

}

if(!is_dir($jsonUpload)){
    mkdir($jsonUpload,0755,true);
}

if(!is_dir($jsonUploadImageData)){
    mkdir($jsonUploadImageData,0755,true);
}

if(!is_dir($jsonUploadImageInfoDir)){
    mkdir($jsonUploadImageInfoDir,0755,true);
}

if(!is_dir($jsonUploadImageCommentsDir)){
    mkdir($jsonUploadImageCommentsDir,0755,true);
}

$jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images.json';
$fp = fopen($jsonFile, 'r');
$imageArray = json_decode(fread($fp, filesize($jsonFile)),true);
fclose($fp);


//print_r($_POST['imageCategory']);

if(!empty($_POST['imageCategory'])){
    //var_dump($_POST['imageCategory']);
    foreach($_POST['imageCategory'] as $imageId => $categoryId){

        if($categoryId=='off' && is_string($categoryId)) {
            continue;
        }
        else{
            //  var_dump('action');
            //  var_dump($categoryId);
            // var_dump($imageId);
            $wpdb->update(
                "$tablename",
                array('Category' => $categoryId),
                array('id' => $imageId),
                array('%s'),
                array('%s')
            );

        }
    }

}

	
// DATEN L�schen und exit

/* Siehe Datei delete-pics.php
	// 2 = delete Pics
	if (@$_POST['chooseAction1']==2) {
	
	echo "TEST DELTE";
	
		$deleteQuery = 'DELETE FROM ' . $tablename . ' WHERE';
	
		$deleteParameters = '';

		/*
		foreach($activate as $key => $value){
	
		
					$deleteQuery .= ' id = "' . $value . '"';
					$deleteQuery .= ' or';
					
					$deleteParameters .= $value.",";
	
		} */
		
		/*
		foreach($activate as $key => $value){
	
		
					$deleteQuery .= ' id = %d';
					$deleteQuery .= ' or';
					
					$deleteParameters .= $value.",";
	
		}
		
		$deleteQuery = substr($deleteQuery,0,-3);	
		$deleteParameters = substr($deleteParameters,0,-1);	

		
		$wpdb->query( $wpdb->prepare(
			"
				$deleteQuery
			", 
				$deleteParameters
		 ));
		
		echo $deleteQuery;
		echo "<br>";
		echo $deleteParameters;
	
		$imageUnlink = @$_POST['imageUnlink'];
	
		foreach($imageUnlink as $key1 => $valueunlink){
		
		@unlink("../wp-content/uploads/$valueunlink");

		}
		
	//$deleteQuery = substr($deleteQuery,0,-3);	
	//$deleteSQL = $wpdb->query($deleteQuery);
	
	
	// Path to admin
	
	$path = plugins_url();
	
	$path .= "/contest-gallery/admin/certain-gallery.php";
	

	
	}*/
	
	
	
	
// DATEN L�schen und exit ENDE	

	
	/*
	// Change Order Auswahl
	if (@$_GET['dauswahl']==true) {

$dauswahl = (@$_POST['dauswahl']=='dab') ? 0 : 1;

$updateorder = "UPDATE $tablenameOptions SET OrderPics='$dauswahl' WHERE id = '$GalleryID' ";
$updateSQLorder = $wpdb->query($updateorder);	

}*/

	// Change Order Auswahl --- ENDE
	$galeryrow = $wpdb->get_row( "SELECT * FROM $tablenameOptions WHERE id = '$GalleryID'" );
	
	$informORnot = $galeryrow->Inform;
	//$AllowGalleryScript = $galeryrow->AllowGalleryScript;  

	// START QUERIES

	// Update Rows
	$querySETrowForRowIds = 'UPDATE ' . $tablename . ' SET rowid = CASE id ';
	$querySETaddRowForRowIds = ' ELSE rowid END WHERE id IN (';
		
	// Update Inform
	
	//$updateInformIds = '(';
	
	// START QUERIES --- END
	
	$tablenameemail = $wpdb->prefix . "contest_gal1ery_mail";	
	$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
    $tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
	$contest_gal1ery_f_input = $wpdb->prefix . "contest_gal1ery_f_input";
	$selectSQLemail = $wpdb->get_row( "SELECT * FROM $tablenameemail WHERE GalleryID = '$GalleryID'" );
    $Manipulate = $wpdb->get_var( "SELECT Manipulate FROM $tablename_pro_options WHERE GalleryID = '$GalleryID'" );


    $Subject = $selectSQLemail->Header;
	$Admin = $selectSQLemail->Admin;
	$Reply = $selectSQLemail->Reply;
	$cc = $selectSQLemail->CC;
	$bcc = $selectSQLemail->BCC;
	$Msg = nl2br($selectSQLemail->Content);
	//$Msg = html_entity_decode(stripslashes($Msg1));
	
	// echo "<br>MSG:<br>";
	// echo "Msg: $Msg";
	// echo "<br>";
	//$Msg = $selectSQLemail->Content;
	
	
	$url = trim($selectSQLemail->URL);
//	$url = (strpos($url,'?')) ? $url.'&' : $url.'?';

	$contentMail = nl2br($selectSQLemail->Content);
	
	$posUrl = "\$url\$";
	
	// echo $posUrl;
	
	$urlCheck = (stripos($contentMail,$posUrl)) ? 1 : 0;


	// Rating manipulieren hier

    if($Manipulate==1){

        if($galeryrow->AllowRating==2){

            if(!empty($_POST['addCountS'])){

                foreach($_POST['addCountS'] as $key => $value){

                            $wpdb->update(
                                "$tablename",
                                array('addCountS' => $value),
                                array('id' => $key),
                                array('%d'),
                                array('%d')
                            );
                }
            }
        }

        if($galeryrow->AllowRating==1){

            if(!empty($_POST['addCountR1'])){

                foreach($_POST['addCountR1'] as $key => $value){

                            $wpdb->update(
                                "$tablename",
                                array('addCountR1' => $value),
                                array('id' => $key),
                                array('%d'),
                                array('%d')
                            );
                }
            }
            if(!empty($_POST['addCountR2'])){

                foreach($_POST['addCountR2'] as $key => $value){

                            $wpdb->update(
                                "$tablename",
                                array('addCountR2' => $value),
                                array('id' => $key),
                                array('%d'),
                                array('%d')
                            );
                }
            }
            if(!empty($_POST['addCountR3'])){

                foreach($_POST['addCountR3'] as $key => $value){

                            $wpdb->update(
                                "$tablename",
                                array('addCountR3' => $value),
                                array('id' => $key),
                                array('%d'),
                                array('%d')
                            );

                }
            }
            if(!empty($_POST['addCountR4'])){

                foreach($_POST['addCountR4'] as $key => $value){

                            $wpdb->update(
                                "$tablename",
                                array('addCountR4' => $value),
                                array('id' => $key),
                                array('%d'),
                                array('%d')
                            );
                }
            }

            if(!empty($_POST['addCountR5'])){

                foreach($_POST['addCountR5'] as $key => $value){

                            $wpdb->update(
                                "$tablename",
                                array('addCountR5' => $value),
                                array('id' => $key),
                                array('%d'),
                                array('%d')
                            );

                }
            }
        }
    }

// Insert fields content

include('1_content.php');

// Insert fields content fb like

include('1_content-fb-like.php');

// Insert fields content --- END

// 	Bilder daktivieren
include('2_deactivate.php');

// Reinfolge Bilder ändern
include('3_row-order.php');

// 	Bilder aktivieren
include('4_activate.php');

// !IMPORTANT: have to be done before 5_create-no-script-html
include('5_set-image-array.php');

include('5_create-no-script-html.php');

// Reset informierte Felder

include('6_reset-informed.php');

// Reset informierte Felder ---- END

// Inform Users if picture is activated per Mail
include('7_inform.php');


// Inform Users if picture is activated per Mail --- END	

echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>";


	// END QUERIES

		
	//echo "<br/>";
	//echo "Query Set:";
	//echo $querySET;
	//echo "<br/>";
	
	//echo "<br/>";
	//echo "Update Inform:";
	//echo $updateInform;
	//echo "<br/>";
	
	
	//	echo "<br/>";
	//echo "Change Row of pics:";
	//echo $querySETrow;
	//echo "<br/>";

	// END QUERIES ENDE
	

?>