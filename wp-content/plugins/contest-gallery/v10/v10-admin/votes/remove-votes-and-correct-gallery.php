<?php
if(!empty($_POST['ipId'])){

    $collect = '';
    $collectIds = array();

    $collectCountS = 0;
    $collectCountR = 0;
    $collectRating = 0; // sum of five stars ratingsecho


    foreach($_POST['ipId'] as $ipId => $ratingHeight){

        if($collect==''){
            $collect .= "id = %d";
            $collectIds[] = $ipId;
        }else{
            $collect .= " OR id = %d";
            $collectIds[] = $ipId;
        }

        if(key($ratingHeight)=='RatingS'){$collectCountS = $collectCountS + 1;}
        if(key($ratingHeight)=='Rating'){
            $collectCountR = $collectCountR + 1;
            $collectRating = $collectRating + $ratingHeight['Rating'];
        }

    }

    $wpdb->query($wpdb->prepare(
        "DELETE FROM $tablename_ip WHERE $collect",$collectIds
    ));

    $newCountS = intval($imageData->CountS)-$collectCountS;
    $newCountR = intval($imageData->CountR)-$collectCountR;
    $newRating = intval($imageData->Rating)-$collectRating;

/*    $wpdb->update(
        "$tablename",
        array('CountS' => $newCountS, 'CountR' => $newCountR, 'Rating' => $newRating),
        array('id' => $imageId),
        array('%d','%d','%d'),
        array('%d')
    );*/

}


$wp_upload_dir = wp_upload_dir();
$imageDataFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-data/image-data-'.$imageId.'.json';
$imagesDataFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images.json';

// correct votes


// speichern in der Haupttabelle und im File

$CountSCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and RatingS = '1'");

$RatingCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and Rating >= '1'");
$RatingOneCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and Rating = '1'");
$RatingTwoCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and Rating = '2'");
$RatingThreeCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and Rating = '3'");
$RatingFourCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and Rating = '4'");
$RatingFiveCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId' and Rating = '5'");

$RatingCount = intval($RatingCount);

$Rating = intval($RatingOneCount)*1+intval($RatingTwoCount)*2+intval($RatingThreeCount)*3+intval($RatingFourCount)*4+intval($RatingFiveCount)*5;

// update main table
$wpdb->update(
    "$tablename",
    array('CountS' => $CountSCount,'CountR' => $RatingCount,'Rating' => $Rating),
    array('id' => $imageId),
    array('%d','%d','%d'),
    array('%d')
);
// correct votes --- END

// changes image data
$fp = fopen($imageDataFile, 'r');
$imageDataArray = json_decode(fread($fp, filesize($imageDataFile)),true);
fclose($fp);

$imageDataArray['CountS'] = intval($CountSCount);
$imageDataArray['CountR'] = intval($RatingCount);
$imageDataArray['Rating'] = intval($Rating);

$fp = fopen($imageDataFile, 'w');
fwrite($fp, json_encode($imageDataArray));
fclose($fp);
// changes image data --- END

// changes images data
$fp = fopen($imagesDataFile, 'r');
$imagesDataArray = json_decode(fread($fp, filesize($imagesDataFile)),true);
fclose($fp);

$imagesDataArray[$imageId]['CountS'] = $CountSCount;
$imagesDataArray[$imageId]['CountR'] = $RatingCount;
$imagesDataArray[$imageId]['Rating'] = $Rating;

$fp = fopen($imagesDataFile, 'w');
fwrite($fp, json_encode($imagesDataArray));
fclose($fp);
// changes images data --- END