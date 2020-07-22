<?php

$cg_copy_start = $_POST['cg_copy_start'];
$cg_processed_images = $cg_copy_start + 200;

// otherwise is already defined
if(!empty($_POST['option_id_next_gallery'])){
    $nextIDgallery = $_POST['option_id_next_gallery'];
}

$galleryUpload = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $nextIDgallery . '';
$galleryJsonFolder = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $nextIDgallery . '/json';
$galleryJsonImagesFolder = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $nextIDgallery . '/json/image-data';
$galleryJsonInfoDir = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $nextIDgallery . '/json/image-info';
$galleryJsonCommentsDir = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $nextIDgallery . '/json/image-comments';


$imagesToProcess = $wpdb->get_var( $wpdb->prepare(
    "
						SELECT COUNT(*) AS NumberOfRows
						FROM $tablename 
						WHERE GalleryID = %d
					",
    $idToCopy
));

// var_dump('$idToCopy');
// var_dump($idToCopy);
//  var_dump($cg_copy_start);

if($cg_processed_images<$imagesToProcess){

    $processPercent = round($cg_processed_images/$imagesToProcess*100);
    echo "<h2>In progress $processPercent%...</h2>";
    echo "<p><strong>Do not cancel</strong></p>";

}else{

    if($cg_copy_start > 0 && $cg_processed_images >= $imagesToProcess){
        echo "<h2 class='cg_in_process'>In progress 99%...</h2>";
        echo "<p class='cg_in_process'><strong>Do not cancel</strong></p>";
    }else{
        echo "<h2 class='cg_in_process'>In progress ...</h2>";
        echo "<p class='cg_in_process'><strong>Do not cancel</strong></p>";
    }

}

$galleryToCopy = $wpdb->get_results("SELECT * FROM $tablename WHERE GalleryID = '$idToCopy' ORDER BY rowid DESC LIMIT $cg_copy_start, 200");
// var_dump($galleryToCopy);
//die;

// get $collectInputIdsArray
$fp = fopen($galleryUpload . '/json/' . $nextIDgallery . '-collect-cat-ids-array.json', 'r');
$collectCatIdsArray =json_decode(fread($fp,filesize($galleryUpload . '/json/' . $nextIDgallery . '-collect-cat-ids-array.json')),true);
fclose($fp);

if($cgVersion<7 && !empty($_POST['copy_v7'])){
    // gallerie bilder in offizielle wordpress library platzieren
    $galleryToCopy = cg_copy_pre7_gallery_images($galleryToCopy);
}

$valueCollect = array();
$collectImageIdsArray = array();
$collectActiveImageIdsArray = array();
$collectImageActiveIdsArray = array();
$imageRatingArray = array();
$imagesDataArray = array();

$oldIdsToCopyStringCollect = '';
$newIdsToCopyStringCollect = '';

$Version = '10.9.8.8.1';

foreach($galleryToCopy as $key => $value){

    $imageRatingArray = array();

    $WpUpload = $value->WpUpload;
    $Active = $value->Active;
    $lastImageIdOld = $value->id;

    if(empty($oldIdsToCopyStringCollect)){
        $oldIdsToCopyStringCollect = "$tablename_entries.pid = $lastImageIdOld";
    }else{
        $oldIdsToCopyStringCollect .= " OR $tablename_entries.pid = $lastImageIdOld";
    }


    foreach($value as $key1 => $value1){

        if ($key1 == 'id') {
            $value1 = '';
        }
        if ($key1 == 'GalleryID') {
            $value1 = $nextIDgallery;
        }

        // if only options and images then set to 0
        if($cgCopyType=='cg_copy_type_options_and_images'){
            if ($key1 == 'CountC') {
                $value1 = 0;
            }
            if ($key1 == 'CountR') {
                $value1 = 0;
            }
            if ($key1 == 'CountS') {
                $value1 = 0;
            }
            if ($key1 == 'Rating') {
                $value1 = 0;
            }
        }


        if ($key1 == 'Category') {
            if(empty($collectCatIdsArray[$value1])){
                $value1 = 0;
            }else{
                $value1 = $collectCatIdsArray[$value1];
            }
        }

        if ($key1 == 'Version') {
            if(empty($value1)){// put in the current version then
                $value1 = $Version;
            }
        }

        $valueCollect[$key1] = $value1;

    }

    $wpdb->insert(
        $tablename,
        $valueCollect,
        array(
            '%s', '%d', '%d',
            '%s', '%s',
            '%d', '%d', '%d', '%d',
            '%d', '%d', '%d',
            '%d', '%d', '%d', '%d', '%d', '%d',
            '%d', '%d', '%d', '%d', '%d', '%d', '%d', '%s', '%s',
            '%d', '%d', '%d', '%d', '%d', // CountR1-5 added since modern five star rating
            '%s', // Added version
            '%s', '%s' // Added CheckSet and CookieId
        )
    );


    if($Active==1){

        $rowObject = $wpdb->get_row( "SELECT $table_posts.*, $tablename.* FROM $table_posts, $tablename WHERE $tablename.GalleryID='$nextIDgallery' AND $tablename.Active='1' and $table_posts.ID = $tablename.WpUpload ORDER BY $tablename.id DESC LIMIT 0, 1");

        $imagesDataArray = cg_create_json_files_when_activating($nextIDgallery,$rowObject,$thumbSizesWp,$uploadFolder,$imagesDataArray);

        $collectImageIdsArray[$lastImageIdOld] = $rowObject->id;
        $collectActiveImageIdsArray[$lastImageIdOld] = $rowObject->id;

    }else{

        $lastImageId = $wpdb->get_var("SELECT id FROM $tablename ORDER BY id DESC LIMIT 0, 1");
        $collectImageIdsArray[$lastImageIdOld] = $lastImageId;

    }

    $valueCollect = array();

}

cg_set_data_in_images_files_with_all_data($nextIDgallery,$imagesDataArray);

cg_create_fb_sites($idToCopy,$nextIDgallery);// IMAGE ID Will be considered in this case. Thats why it is done so!

if($cgVersion<10){

    $backToGalleryFile = $uploadFolder["basedir"]."/contest-gallery/gallery-id-$nextIDgallery/backtogalleryurl.js";
    $FbLikeGoToGalleryLink = 'backToGalleryUrl="";';
    $fp = fopen($backToGalleryFile, 'w');
    fwrite($fp, $FbLikeGoToGalleryLink);
    fclose($fp);

}else{

    $backToGalleryFile = $uploadFolder["basedir"]."/contest-gallery/gallery-id-$nextIDgallery/backtogalleryurl.js";
    $FbLikeGoToGalleryLink = 'backToGalleryUrl="'.$FbLikeGoToGalleryLink.'";';
    $fp = fopen($backToGalleryFile, 'w');
    fwrite($fp, $FbLikeGoToGalleryLink);
    fclose($fp);

}


// create user entries

// get $collectInputIdsArray
$fp = fopen($galleryUpload . '/json/' . $nextIDgallery . '-collect-input-ids-array.json', 'r');
$collectInputIdsArray =json_decode(fread($fp,filesize($galleryUpload . '/json/' . $nextIDgallery . '-collect-input-ids-array.json')),true);
fclose($fp);

// check which fileds are allowed for json save because allowed gallery or single view
$uploadFormFields = $wpdb->get_results("SELECT * FROM $tablename_form_input WHERE GalleryID = $nextIDgallery");
$Field1IdGalleryView = $wpdb->get_var("SELECT Field1IdGalleryView FROM $tablename_options_visual WHERE GalleryID = $nextIDgallery");

$fieldsForFrontendArray = array();
$inputTitles = array();

foreach ($uploadFormFields as $field) {
    $Field_Content = unserialize($field->Field_Content);

    $inputTitles[$field->id] = $Field_Content['titel'];


    if ($field->id == $Field1IdGalleryView or $field->Show_Slider == 1) {
        $fieldsForFrontendArray[] = $field->id;
    }
}

if(!empty($oldIdsToCopyStringCollect)){
    $oldIdsToCopyStringCollect = "AND ($oldIdsToCopyStringCollect)";
}

$galleryToCopy = $wpdb->get_results("SELECT * FROM $tablename_entries WHERE GalleryID = '$idToCopy' $oldIdsToCopyStringCollect ORDER BY pid DESC");

$valueCollect = array();

$pidBefore = '';

if(!empty($galleryToCopy)){

    foreach ($galleryToCopy as $key => $value) {

        if(!empty($value->InputDate) AND $value->InputDate!='0000-00-00 00:00:00'){
            // simply continue processing then
        } else if ($value->Short_Text == '' && $value->Long_Text == '') {// to reduce amount of copy
            continue;
        }

        foreach ($value as $key1 => $value1) {

            if ($key1 == 'id') {
                $value1 = '';
            }
            if ($key1 == 'GalleryID') {
                $value1 = $nextIDgallery;
            }
            if ($key1 == 'pid') {
                $value1 = $collectImageIdsArray[$value1];
            }
            if ($key1 == 'f_input_id') {
                $lastInputIdOld = $value1;
                $value1 = $collectInputIdsArray[$lastInputIdOld];
                $fInputId = $value1;
            }

            $valueCollect[$key1] = $value1;

        }

        $wpdb->insert(
            $tablename_entries,
            $valueCollect,
            array(
                '%s', '%d', '%d', '%d',
                '%s', '%d', '%s', '%s', '%d', '%d', '%s'// InputDate was last
            )
        ); // the last two are


        if ($value->pid != $pidBefore) {

            if ($pidBefore == '') {
                $pidBefore = $value->pid;
                continue;
            }

        }

        $pidBefore = $value->pid;

        $valueCollect = array();

    }

}



// insert entries json

foreach ($collectActiveImageIdsArray as $oldImageId => $newImageId){

    if(empty($newIdsToCopyStringCollect)){
        $newIdsToCopyStringCollect = "$tablename_entries.pid = $newImageId";
    }else{
        $newIdsToCopyStringCollect .= " OR $tablename_entries.pid = $newImageId";
    }

}
/*echo "<br>";
var_dump ($newIdsToCopyStringCollect);
echo "<br>";

die;*/
do_action('cg_json_upload_form_info_data_files',$nextIDgallery,$newIdsToCopyStringCollect);

if($cgCopyType=='cg_copy_type_all'){

    // copy rating here
    cg_copy_rating($cg_copy_start,$idToCopy,$nextIDgallery,$collectImageIdsArray);

    // copy comments here
    cg_copy_comments($cg_copy_start,$idToCopy,$nextIDgallery,$collectImageIdsArray);
}

// forward

if($cg_processed_images<$imagesToProcess){

    //   ?page=contest-gallery/index.php&option_id=137
    //    &edit_gallery=true&copy=true
    $cg_copy_start = $cg_processed_images;

    echo "<input type='hidden' id='cgProcessedImages' value='$cg_copy_start' />";
    echo "<input type='hidden' id='cgNextIdGallery' value='$nextIDgallery' />";


    die;


    //require("forward-url.php");

    //exit;
    //echo $Forward_URL;

}

?>