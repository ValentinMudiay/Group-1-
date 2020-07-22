<?php

$imageId = $_GET['image_id'];
$GalleryID = $_GET['option_id'];
$gid = $_GET['option_id'];


// Tabellennamen ermitteln, GalleryID wurde als Shortcode bereits �bermittelt.
global $wpdb;

require_once(dirname(__FILE__) . "/../nav-menu.php");

echo "<br/>";

$start = sanitize_text_field(!empty($_GET["start"]) ? $_GET["start"] : 0);
$start = intval($start) ? $start : 0;

$end = sanitize_text_field(!empty($_GET["end"]) ? $_GET["end"] : 50);
$end = intval($end) ? $end : 50;

$tablename = $wpdb->prefix . "contest_gal1ery";
$tablename_options = $wpdb->prefix . "contest_gal1ery_options";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
$tablename_ip = $wpdb->prefix . "contest_gal1ery_ip";
$table_posts = $wpdb->prefix."posts";
$table_wp_users = $wpdb->prefix."users";

$imageData = $wpdb->get_row("SELECT * FROM $tablename WHERE id = '$imageId'");
$WpUserId = $imageData->WpUserId;
$user_login = $wpdb->get_var("SELECT user_login  FROM $table_wp_users WHERE ID = $WpUserId ORDER BY ID ASC");


$generalOptions = $wpdb->get_row("SELECT * FROM $tablename_options WHERE id = '$GalleryID'");
$proOptions = $wpdb->get_row("SELECT * FROM $tablename_pro_options WHERE GalleryID = '$GalleryID'");

if(!empty($_GET['remove_votes'])){
    include('remove-votes-and-correct-gallery.php');
    $imageData = $wpdb->get_row("SELECT * FROM $tablename WHERE id = '$imageId'"); // weil sich erneuert hat hier nochmal einfügen
}

$votingData = $wpdb->get_results("SELECT * FROM $tablename_ip WHERE pid = '$imageId' ORDER BY id DESC LIMIT $start, 50");
$votingDataLength = $wpdb->get_var("SELECT COUNT(*) FROM $tablename_ip WHERE pid = '$imageId'");

$upload_folder = wp_upload_dir();
$upload_folder_url = $upload_folder['baseurl']; // Pfad zum Bilderordner angeben

$wpUserIdsArray = array();

if(count($votingData)){
    foreach($votingData as $row){

        if(!empty($row->WpUserId)){
            $wpUserIdsArray[$row->WpUserId] = true;
        }
    }
}

$userIdsSelectString = '';

if(count($wpUserIdsArray)){

    foreach($wpUserIdsArray as $id => $bool){
        if(empty($userIdsSelectString)){
            $userIdsSelectString .= "ID = $id";
        }else{
            $userIdsSelectString .= " OR ID = $id";
        }
    }

    $wpUsersData = $wpdb->get_results("SELECT ID, user_login, user_email FROM $table_wp_users WHERE $userIdsSelectString ORDER BY ID ASC");

    foreach($wpUsersData as $row){
        $wpUserIdsArray[$row->ID] = array();
        $wpUserIdsArray[$row->ID]['user_login'] = $row->user_login;
        $wpUserIdsArray[$row->ID]['user_email'] = $row->user_email;
    }

}

/*echo "<pre>";
print_r($wpUserIdsArray);
echo "</pre>";*/

$widthOriginalImg = $imageData->Width;
$heightOriginalImg = $imageData->Height;
$rThumb = $imageData->rThumb;
$WpUpload = $imageData->WpUpload;
$status = ($imageData->Active>0) ? 'activated' : 'deactivated';

$wp_image_info = $wpdb->get_row("SELECT * FROM $table_posts WHERE ID = '$imageData->WpUpload'");
$image_url = $wp_image_info->guid;
$post_title = $wp_image_info->post_title;
$post_description = $wp_image_info->post_content;
$post_excerpt = $wp_image_info->post_excerpt;
$post_type = $wp_image_info->post_mime_type;
$wp_image_id = $wp_image_info->ID;

$imageThumb = wp_get_attachment_image_src($WpUpload, 'large');
$imageThumb = $imageThumb[0];

$sourceOriginalImgShow = $image_url;

$WidthThumb = 300;
$HeightThumb = 200;

// Ermittlung der Höhe nach Skalierung. Falls unter der eingestellten Höhe, dann nächstgrößeres Bild nehmen.
$heightScaledThumb = $WidthThumb*$heightOriginalImg/$widthOriginalImg;


// Falls unter der eingestellten Höhe, dann größeres Bild nehmen (normales Bild oder panorama Bild, kein Vertikalbild)
if ($heightScaledThumb <= $HeightThumb) {

    $imageThumb = wp_get_attachment_image_src($WpUpload, 'large');
    $imageThumb = $imageThumb[0];

    // Bestimmung von Breite des Bildes
    $WidthThumbPic = $HeightThumb*$widthOriginalImg/$heightOriginalImg;

    // Bestimmung wie viel links und rechts abgeschnitten werden soll
    $paddingLeftRight = ($WidthThumbPic-$WidthThumb)/2;
    $paddingLeftRight = $paddingLeftRight.'px';

    $padding = "left: -$paddingLeftRight;right: -$paddingLeftRight";

    $WidthThumbPic = $WidthThumbPic.'px';


}

// Falls über der eingestellten Höhe, dann kleineres Bild nehmen (kein Vertikalbild)

if ($heightScaledThumb > $HeightThumb) {

    $imageThumb = wp_get_attachment_image_src($WpUpload, 'large');
    $imageThumb = $imageThumb[0];

    // Bestimmung von Breite des Bildes
    $WidthThumbPic = $WidthThumb.'px';

    // Bestimmung wie viel oben und unten abgeschnitten werden soll
    $heightImageThumb = $WidthThumb*$heightOriginalImg/$widthOriginalImg;
    $paddingTopBottom = ($heightImageThumb-$HeightThumb)/2;
    $paddingTopBottom = $paddingTopBottom.'px';

    $padding = "top: -$paddingTopBottom;bottom: -$paddingTopBottom";

}

// Bild wird mittig und passend zum Div angezeigt	--------  ENDE

// Notwendig um sp�ter die star Icons anzuzeigen
$iconsURL = plugins_url().'/contest-gallery/v10/v10-css';

$starOn = $iconsURL.'/star_48_reduced.png';
$starOff = $iconsURL.'/star_off_48_reduced.png';

$starCountS = ($imageData->CountS>0) ? $starOn : $starOff;

$uploadTime = date('d-M-Y H:i', $imageData->Timestamp);

if ($imageData->CountR!=0){
    $averageStars = $imageData->Rating/$imageData->CountR;
    $averageStarsRounded = round($averageStars,0);
}
else{$countRtotalCheck=0; $averageStarsRounded = 0;}


if($averageStarsRounded>=1){$star1 = $starOn;}
else{$star1 = $starOff;}
if($averageStarsRounded>=2){$star2 = $starOn;}
else{$star2 = $starOff;}
if($averageStarsRounded>=3){$star3 = $starOn;}
else{$star3 = $starOff;}
if($averageStarsRounded>=4){$star4 = $starOn;}
else{$star4 = $starOff;}
if($averageStarsRounded>=5){$star5 = $starOn;}
else{$star5 = $starOff;}

if(empty($imageData->CountS)){$imageData->CountS = 0;}
if(empty($imageData->CountR)){$imageData->CountR = 0;}


if(!empty($imageData->IP)){
    $userIP = $imageData->IP;
}else{
    $userIP = 'User IP when uploading will be tracked since plugin version 10.9.3.7';
}

if(!empty($imageData->CookieId)){
    $CookieId = $imageData->CookieId;
}else{
    $CookieId = '';
}


echo "<div id='cgVotes'>";

echo '<div id=\'cgVotesExport\'>
<form method="POST" action="?page=contest-gallery/index.php&cg_picture_id='.$imageId.'&cg_export_votes">
<input type="hidden" name="cg_export_votes" value="true">
<input type="hidden" name="cg_picture_id" value="'.$imageId.'">
<input type="hidden" name="cg_option_id" value="'.$GalleryID.'">
<input class="cg_backend_button_gallery_action" type="submit" value="Export votes"></form>
</div>';

echo "<form action='?page=contest-gallery/index.php&show_votes=true&remove_votes=true&image_id=$imageId&option_id=$GalleryID' method=\"post\">";

echo "<div id='cgVotesImage'>";

    echo "<div id='cgVotesImageVisual'>";
        echo '<div id="cgVotesImageVisualContent">';

        echo '<a href="'.$sourceOriginalImgShow.'" target="_blank" title="Show full size"><img class="cg'.$rThumb.'degree" src="'.$imageThumb.'" style="'.$padding.';position: absolute !important;max-width:none !important;" width="'.$WidthThumbPic.'"></a>';
        //echo '<a href="'.$sourceOriginalImgShow.'" target="_blank" title="Show full size" alt="Show full size"><img src="'.$WPdestination.$value->Timestamp.'_'.$value->NamePic.'-300width.'.$value->ImgType.'" style="'.$padding.';position: absolute !important;max-width:none !important;" width="'.$WidthThumbPic.'"></a>';
        echo "</div>";
        echo '<div id="cgVotesImageVisualId">';

        echo "<strong>picture id:</strong> $imageData->id";
        echo "<strong>status:</strong> $status";
        echo "<br>";
        echo "<strong>IP:</strong><br><span style='font-size:12px;'>$userIP</span>";
        if($proOptions->RegUserUploadOnly==2){
            echo "<br>";
            echo "<strong>Cookie ID:</strong><br><span style='font-size:12px;'>$CookieId</span>";
        }

        if($WpUserId>0){

            echo "<br>";
            echo "<div class='cg_backend_info_user_link_container'>";
            echo "<span style='display:table;'><strong>Added by:</strong></span><a style=\"display:flex;margin-top:5px;\"class=\"cg_image_action_href cg_load_backend_link\" href='?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&wp_user_id=".$WpUserId."'><span class=\"cg_image_action_span\" >".$user_login."</span></a>";
            echo '</div>';

        }

        echo '</div>';
    echo "</div>";

    echo "<div id='cgVotesImageInfo'>";
        echo "<div class='cg-votes-image-info-header'>Image name (original WordPress title):</div>";
        echo "<div class='cg-votes-image-info-content'>$post_title</div>";
        echo "<div class='cg-votes-image-info-header'>Upload time (your server time) / (your browser time):</div>";
        echo "<div class='cg-votes-image-info-content'><span id='cgVotesUploadTimeTimestamp'>$imageData->Timestamp</span>$uploadTime / <span id='cgVotesBrowserTime'></span></div>";
        echo "<div class='cg-votes-image-info-header'>Count one star:</div>";
        echo "<div class='cg-votes-image-info-content'>";
            echo "<div class='cg-votes-image-info-content-rating-average-stars'>";
                echo "<img src='$starCountS' />";
            echo "</div>";
            echo "<div class='cg-votes-image-info-content-rating-count'>";
                echo $imageData->CountS;
            echo "</div>";
        echo "</div>";

        echo "<div class='cg-votes-image-info-five-star'>";

            echo "<div class='cg-votes-image-info-five-star-content'>";
                echo "<div class='cg-votes-image-info-header'>Average five star:</div>";
                echo "<div class='cg-votes-image-info-content'>";
                    echo "<div class='cg-votes-image-info-content-rating-average-stars (rounded)'>";
                        echo "<img src='$star1' />";
                        echo "<img src='$star2' />";
                        echo "<img src='$star3' />";
                        echo "<img src='$star4' />";
                        echo "<img src='$star5' />";
                    echo "</div>";
                    echo "<div class='cg-votes-image-info-content-rating-count'>";
                        echo $averageStarsRounded." <span class='cg-votes-image-info-content-rating-count-rounded'>($imageData->Rating/$imageData->CountR)</span>";
                    echo "</div>";
                echo "</div>";
            echo "</div>";

            echo "<div class='cg-votes-image-info-five-star-content'>";
                echo "<div class='cg-votes-image-info-header'>Cummulated five star:</div>";
                echo "<div class='cg-votes-image-info-content'>$imageData->Rating</div>";
            echo "</div>";

            echo "<div class='cg-votes-image-info-five-star-content'>";
                echo "<div class='cg-votes-image-info-header'>Count five star:</div>";
                echo "<div class='cg-votes-image-info-content'>$imageData->CountR</div>";
            echo "</div>";

        echo "</div>";
        if($generalOptions->FbLike==1){
            echo "<div class='cg-votes-image-info-fblike'>";
                echo "<div class='cg-votes-image-info-header'>Facebook Like voting:</div>";
                echo "<div class='cg-votes-image-info-content'>";

                echo "Facebook Like Button can be only shown in frontend because of WordPress security features";

/*                if(file_exists($upload_folder["basedir"]."/contest-gallery/gallery-id-".$gid."/".$imageData->Timestamp."_".$imageData->NamePic."413.html")){
                    $fbSiteUrl = $upload_folder_url."/contest-gallery/gallery-id-".$gid."/".$imageData->Timestamp."_".$imageData->NamePic."413.html";
                    echo "<div id='cgFacebookGalleryDiv".$gid."' class='cg_gallery_facebook_div' >";
                    echo "<iframe src='".$fbSiteUrl."'  scrolling='no' class='cg_fb_like_iframe_slider_order' id='cg_fb_like_iframe_slider".$imageId."'  name='cg_fb_like_iframe_slider".$imageId."'></iframe>";
                    echo "</div>";
                }else{
                    echo "This image has to be activated at least one time to see Facebook Like voting";
                }*/

            echo "</div>";
            echo "</div>";
        }


        echo "<div id='cgVotesNote'>";
        echo "<p>Note: Vote date will be tracked only since plugin version 10.3.0</p>";
        echo "</div>";
    echo "</div>";

echo "</div>";

if($votingDataLength>50){
    echo "<div class='cg-votes-steps-container'>";
    $i = -1;
    for($stepStart=0;$stepStart<$votingDataLength;$stepStart = $stepStart+50){

            $check = $stepStart+50;
            if($votingDataLength<$check){// then last step
                $stepEnd = $votingDataLength;
                $stepStartToStart = $stepStart+1;
            }else{
                $stepEnd = $stepStart+($votingDataLength-50*$i-($votingDataLength-($stepStart)));
                $stepStartToStart = $stepStart+1;
            }

            if($start==$stepStart){
                $checked = 'cg-votes-step-checked';
            }else{
                $checked = '';
            }

            echo "<div class='cg-votes-step $checked'>";
            echo "[ <a class='cg-votes-step-link' href='?page=contest-gallery/index.php&image_id=$imageId&show_votes=true&option_id=$GalleryID&start=$stepStart&end=$stepEnd'>$stepStartToStart-$stepEnd</a> ]";
            echo "</div>";

        $i++;


    }
    echo "</div>";
}

    if($votingDataLength>=1){
        echo "<div id='cgVotesContent'>";

        // Header
        echo "<div class='cg-votes-header'>vote id</div>";
        echo "<div class='cg-votes-header'>IP</div>";
        echo "<div class='cg-votes-header'>Cookie id</div>";
        echo "<div class='cg-votes-header'>Rating<br>one star</div>";
        echo "<div class='cg-votes-header'>Rating<br>five star</div>";
        echo "<div class='cg-votes-header'>WordPress<br>user id</div>";
        echo "<div class='cg-votes-header'>WordPress<br>username</div>";
        echo "<div class='cg-votes-header'>WordPress<br>email</div>";
        echo "<div class='cg-votes-header'>Vote date <br>(server time)</div>";
        echo "<div class='cg-votes-header'>Select all <br/><input type='checkbox' id='cgVotesSelectAll'><br/><br/>Remove vote</div>";

        // Rows
        foreach ($votingData as $row) {
            echo "<div class='cg-votes-row-container'>";
                echo "<div class='cg-votes-row'>$row->id</div>";
                echo "<div class='cg-votes-row'>$row->IP</div>";
                echo "<div class='cg-votes-row cg-votes-row-cookie-id-parent' data-title='$row->CookieId'><div class='cg-votes-row-cookie-id'>$row->CookieId</div></div>";
                $row->RatingS = (empty($row->RatingS)) ? '&nbsp;' : $row->RatingS;
                echo "<div class='cg-votes-row'>$row->RatingS</div>";
                $row->Rating = (empty($row->Rating)) ? '&nbsp;' : $row->Rating;
                echo "<div class='cg-votes-row'>$row->Rating</div>";
                echo "<div class='cg-votes-row'>$row->WpUserId</div>";
                $username = (!empty($row->WpUserId)) ? $wpUserIdsArray[$row->WpUserId]['user_login'] : "";
                $useremail = (!empty($row->WpUserId)) ? $wpUserIdsArray[$row->WpUserId]['user_email'] : "";
                echo "<div class='cg-votes-row'>$username</div>";
                echo "<div class='cg-votes-row'>$useremail</div>";
                if(empty($row->VoteDate)){$row->VoteDate="&nbsp";};
                echo "<div class='cg-votes-row'>$row->VoteDate</div>";
                $ratingVariant = ($row->RatingS>0) ? 'RatingS' : 'Rating';
                $ratingHeight = ($row->RatingS>0) ? $row->RatingS : $row->Rating;
                echo "<div class='cg-votes-row'><input type='checkbox' class='cg-votes-remove-vote-checkbox' name='ipId[$row->id][$ratingVariant]' value='$ratingHeight'></div>";
            echo "</div>";
        }
        echo "</div>";
    }else{

        echo "<div id='cgVotesContent'>";
            echo "<br>";
            echo "<p>This image has no votes</p>";
        echo "</div>";

    }

if($votingDataLength>=1) {
    echo "<div id='cgOptionsSaveButtonContainer'><input class='cg_backend_button_gallery_action' type=\"submit\" value=\"Remove and correct votes\" id='cgOptionsSaveButton'></div>";
    echo "</form>";
}


echo "</div>";


