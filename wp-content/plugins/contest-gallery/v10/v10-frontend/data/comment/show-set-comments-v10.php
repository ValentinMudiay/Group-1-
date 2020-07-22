<?php
if(!defined('ABSPATH')){exit;}

$galeryID = intval(sanitize_text_field($_REQUEST['gid']));
$galeryIDuser = sanitize_text_field($_REQUEST['galeryIDuser']);
$galleryHash = sanitize_text_field($_REQUEST['galleryHash']);
$galleryHashDecoded = wp_salt( 'auth').'---cngl1---'.$galeryIDuser;
$galleryHashToCompare = md5($galleryHashDecoded);

if ($galleryHash != $galleryHashToCompare){
    return;
}

$explodeHash = explode('---cngl1---',$galleryHashDecoded);
if($explodeHash[1]==$galeryID.'-u'){
    // show message will be shown in javascript when trying to comment
    return;
}

$Name = sanitize_text_field($_REQUEST['name']);
$Comment = sanitize_text_field($_REQUEST['comment']);

$Name = htmlentities($Name, ENT_QUOTES, 'UTF-8');

$Comment = stripslashes($Comment);
$Comment = nl2br(htmlspecialchars($Comment, ENT_QUOTES, 'UTF-8'));

$pictureID = intval(sanitize_text_field($_REQUEST['pid']));
$galeryID = intval(sanitize_text_field($_REQUEST['gid']));
$unix = time();
$date = date("Y-m-d H:i",$unix);

// write database
global $wpdb;
$tablename = $wpdb->prefix . "contest_gal1ery";
$tablenameComments = $wpdb->prefix . "contest_gal1ery_comments";

$wpdb->query( $wpdb->prepare(
    "
				INSERT INTO $tablenameComments
				( id, pid, GalleryID, Name, Date, Comment, Timestamp)
				VALUES ( %s,%d,%d,%s,%s,%s,%d )
			",
    '',$pictureID,$galeryID,$Name,$date,$Comment,$unix
) );

$lastCommentId = $wpdb->get_var("SELECT id FROM $tablenameComments WHERE pid = '$pictureID' ORDER BY id DESC LIMIT 0, 1");

// open and write file
$wp_upload_dir = wp_upload_dir();

// process comments File
$commentsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/image-comments/image-comments-'.$pictureID.'.json';
$fp = fopen($commentsFile, 'r');
$commentsFileData =json_decode(fread($fp,filesize($commentsFile)),true);
fclose($fp);


if(empty($commentsFileData)){
    $commentsFileData = array();
}

$commentsFileData[$lastCommentId] = array();
$commentsFileData[$lastCommentId]['date'] = $date;
$commentsFileData[$lastCommentId]['timestamp'] = $unix;
$commentsFileData[$lastCommentId]['name'] = stripslashes($Name);
$commentsFileData[$lastCommentId]['comment'] = stripslashes($Comment);


$fp = fopen($commentsFile, 'w');
fwrite($fp,json_encode($commentsFileData));
fclose($fp);

// process comments File --- ENDE

// process rating comments data file
$dataFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/image-data/image-data-'.$pictureID.'.json';
$fp = fopen($dataFile, 'r');
$ratingCommentsData =json_decode(fread($fp,filesize($dataFile)),true);
fclose($fp);

$ratingCommentsData['CountC'] = count($commentsFileData);

$fp = fopen($dataFile, 'w');
fwrite($fp,json_encode($ratingCommentsData));
fclose($fp);

// process rating comments data file --- ENDE

// update CountC in image table
$wpdb->update(
    "$tablename",
    array('CountC' => $ratingCommentsData['CountC']),
    array('id' => $pictureID),
    array('%d'),
    array('%d')
);

do_action('cg_actualize_all_images_data_sort_values_file',$galeryID);

?>

    <script data-cg-processing="true">// if this exists then everything is fine. Will check if this exits or not

    </script>

<?php

?>