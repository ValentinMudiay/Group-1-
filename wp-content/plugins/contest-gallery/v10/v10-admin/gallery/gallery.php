<?php
if(!defined('ABSPATH')){exit;}

if(!empty($_GET['option_id'])){
    $GalleryID = sanitize_text_field($_GET['option_id']);
}else{

    if(empty($_POST['cg_id'])){
        $isNewGallery = true;
        // dann hat er reloaded und einfach die letzte gallerie anzeigen
        $GalleryID = $wpdb->get_var("SELECT MAX(id) FROM $tablenameOptions");
    }else{
        $GalleryID = sanitize_text_field($_POST['cg_id']);
    }

}

global $wp_version;

//  CHECK FIRST!!!!
$wp_upload_dir = wp_upload_dir();
// check if sort values files exists
if(!file_exists($wp_upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json")){
    cg_actualize_all_images_data_sort_values_file($GalleryID,true);
}
// check if sort values files exists --- ENDE

// check if image-info-values-file-exists
if(!file_exists($wp_upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-info-values.json")){
    cg_actualize_all_images_data_info_file($GalleryID);
}
// check if image-info-values-file-exists
//  CHECK FIRST  ---- END !!!!



if(!empty($_POST['cgGalleryFormSubmit'])){

    $chooseAction1 = 0;

    if(!empty($_POST['chooseAction1'])){
        $chooseAction1 = $_POST['chooseAction1'];
    }

    if($chooseAction1 == 3){
        include('delete-pics.php');
    }

    include('change-gallery/0_change-gallery.php');
}

if(!isset($_POST['cg_copy'])){
    $isCopyGalleryRightNow = false;
}else{
    $isCopyGalleryRightNow = true;
}

if(empty($isNewGalleryCreated)){
    $isNewGalleryCreated = false;
}

$cg_hide_is_new_gallery = ($isNewGalleryCreated) ? 'cg_hide' : '';


if(!empty($isGalleryAjaxBackendLoad)){// when from page load then load like without without ajax call for faster processing
    $isAjaxCall = false;
}

if(empty($isAjaxCall)){
    $isAjaxCall = false;
}


include("get-data.php");
include(dirname(__FILE__) . "/../nav-gallery.php");
include("header-1.php");

if($isCopyGalleryRightNow){

    ?>

    <script>

        var gid = <?php echo json_encode($GalleryID);?>;

        var reloadUrl = window.location.href;

        if (reloadUrl.indexOf("cg_copy") >= 0){
            reloadUrl = reloadUrl.replace(/cg_copy/gi,'cg_do_nothing');
            reloadUrl = reloadUrl.replace('index.php&','index.php&option_id='+gid+'&');// <<< do not remove this!!!
        }

        history.replaceState(null,null,reloadUrl);



    </script>
    <?php
}


if($IsModernFiveStar==0 && $AllowRating==1){

    echo '<div style="width:935px;border: thin solid black;background-color:#ffffff;    
    padding-top: 17px;
    margin-top: 20px;margin-bottom: 20px;padding-bottom: 15px;">
    <div style="text-align: center;font-size: 14px; width: 100%; font-weight: bold;margin-bottom: 10px;">You are using old 5 stars gallery frontend look. You can correct it here:</div>
    <div style="margin: 0 auto;width:230px;"><a href="?page=contest-gallery/index.php&amp;corrections_and_improvements=true&amp;option_id='.$GalleryID.'" class="cg_load_backend_link"><input type="hidden" name="option_id" value="5"><input class="cg_backend_button cg_backend_button_general" type="button" value="Corrections and Improvements" style="width:230px;"></a><br></div></div>';

}



include("header-2.php");



if($isAjaxCall){


// Set variables:
    $heightOriginalImg = 1;
    $widthOriginalImg = 1;

//echo plugin_dir_path(__FILE__);

// Bestimmen ob ABSTEIGEND oder AUFSTEIGEND

// -------------------------------Ausgabe der eingetragenen Felder. Hauptdiv id=sortable. Sortierbare Felder div id=cgSortableDiv


    echo '<input type="hidden" name="option_id" value="'. $GalleryID .'">';
    //echo "<div id='sortable' style='width:935px;border: thin solid black;background-color:#fff;padding-bottom:50px;padding-left:20px;padding-right:20px;padding-top:20px;'>";


    echo "<ul id='cgSortable' style='width:895px;padding:20px;background-color:#fff;margin-bottom:0px !important;margin-bottom:0px;border: thin solid black;margin-top:0px;'>";
    if(!empty($_POST['cgGalleryFormSubmit'])){
        echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>";
    }

    echo "<div id='cgNoImagesFound' class='cg_hide'>No images found</div>";
    // Bei der ersten Abarbeitung notwendig
    //	echo "<li style='width:891px;border: thin solid black;padding-top:10px;padding-bottom:10px;display:table;' id='div' class='cgSortableDiv'>";
// Wird gebraucht um die höchste RowID am Anfang zu ermitln
    $r = 0;

    $uploadFolder = wp_upload_dir();

    foreach($selectSQL as $value){

        /*$selectedCheck = "".$value->Active."";

            if ($selectedCheck == 1){
            $checkedActive = "checked";
            }
            else {
            $checkedActive = "";
            }*/

        $id = $value->id;
        $rowid = $value->rowid;
        $Timestamp = $value->Timestamp;
        $NamePic = $value->NamePic;
        $CountC = $value->CountC;
        $rating = $value->Rating;
        $countR = $value->CountR;
        $countS = $value->CountS;
        $WpUpload = $value->WpUpload;
        $WpUserId = $value->WpUserId;
        $widthOriginalImg = $value->Width;
        $heightOriginalImg = $value->Height;
        $Active = $value->Active;
        $rThumb = $value->rThumb;
        $rSource = $value->rSource;
        $addCountS = $value->addCountS;
        $addCountR1 = $value->addCountR1;
        $addCountR2 = $value->addCountR2;
        $addCountR3 = $value->addCountR3;
        $addCountR4 = $value->addCountR4;
        $addCountR5 = $value->addCountR5;
        $imageCategory = $value->Category;
        $exifData = $value->Exif;
        $IP = $value->IP;
        $CookieId = $value->CookieId;

        $emailStatus = false;

        /*		if ($Active == 1){
                    $checkedActive = "checked";
                }
                else {
                    $checkedActive = "";
                }*/

        //echo $WpUserId;

        //$urlForFacebook=$urlSource.'/wp-content/uploads/contest-gallery/gallery-id-'.$GalleryID.'/'.$Timestamp.$NamePic.".html";
//echo $urlForFacebook;
        //echo "$id";

        if(!$rating){$rating=0;}

        // Die höchste RowID wird gebraucht und später von JavaScript verarbeitet
        /*$r++;

        if ($r==1) {

        echo '<input type="hidden" id="highestRowId" value="'. $rowid .'">';

        }*/
        // Die höchste RowID wird gebraucht und später von JavaScript verarbeitet --- END


        //	echo "<br/>";

        if($Active == 1){
            $cg_sortable_div_status = 'cg_sortable_div_active';
        }
        else{
            $cg_sortable_div_status = 'cg_sortable_div_inactive';
        }
        echo "<li id='div$id' class='cgSortableDiv cg_sortable_div $cg_sortable_div_status'>";
        echo "<div class='cg_drag_area' ><img class='cg_drag_area_icon' src='$cgDragIcon'></div>";


        // hidden inputs zur bestimmung der Reihenfolge
        echo "<input type='hidden' name='row[$id][$Active]'  class='rowId' value='$rowid'>"; // Zur Feststellung der Reihenfolge, wird vom Javascript verarbeitet
        echo "<input type='hidden' name='changeGalery' value='changeGalery'>";
        // hidden inputs zur bestimmung der Reihenfolge ENDE



        // ------ Bild wird mittig und passend zum Div angezeigt


        // destination of the uploaded original image



        // Feststellen der Quelle des Original Images
        //	echo "WpUpload: $WpUpload";


        if($WpUpload==0){
            $sourceOriginalImg = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType; // Pfad zum Bilderordner angeben
            $sourceOriginalImgShow = $uploadFolder['baseurl'].'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType; // Pfad zum Bilderordner angeben
            list($widthOriginalImg, $heightOriginalImg) = getimagesize($sourceOriginalImg); // Breite und Höhe von original Image

        }
        else{

            //	$wp_image_info = $wpdb->get_row("SELECT * FROM $table_posts WHERE ID = '$WpUpload'");
            $image_url = $allWpPostsByWpUploadIdArray[$WpUpload]['guid'];
            $post_title = $allWpPostsByWpUploadIdArray[$WpUpload]['post_title'];
            $post_name = $allWpPostsByWpUploadIdArray[$WpUpload]['post_name'];
            $post_description = $allWpPostsByWpUploadIdArray[$WpUpload]['post_content'];
            $post_excerpt = $allWpPostsByWpUploadIdArray[$WpUpload]['post_excerpt'];
            $post_type = $allWpPostsByWpUploadIdArray[$WpUpload]['post_mime_type'];
            $wp_image_id = $allWpPostsByWpUploadIdArray[$WpUpload]['ID'];


            /*						$post_title = $wp_image_info->post_title;
                                    $post_name = $wp_image_info->post_name;
                                    $post_description = $wp_image_info->post_content;
                                    $post_excerpt = $wp_image_info->post_excerpt;
                                    $post_type = $wp_image_info->post_mime_type;
                                    $wp_image_id = $wp_image_info->ID;*/

            $sourceOriginalImgShow = $image_url;


            $check = explode($uploadFolder['baseurl'],$image_url);
            $sourceOriginalImg = $image_url;


        }


        if($rThumb=='90' or $rThumb=='270'){
            $rotateRatio = $widthOriginalImg/$heightOriginalImg;
            $widthOriginalImgContainer = $widthOriginalImg;
            $widthOriginalImg = $heightOriginalImg;
            $heightOriginalImg = $widthOriginalImgContainer;
        }

        $WidthThumb = 160;
        $HeightThumb = 106;
        $WidthThumbImageShouldBe = 160+100;// eventually user settings very low, this why this check and + 100 because to go sure quality is always good

        // Ermittlung der Höhe nach Skalierung. Falls unter der eingestellten Höhe, dann nächstgrößeres Bild nehmen.
        $heightScaledThumb = $WidthThumb*$heightOriginalImg/$widthOriginalImg;


        // Falls unter der eingestellten Höhe, dann größeres Bild nehmen (normales Bild oder panorama Bild, kein Vertikalbild)

        if ($heightScaledThumb <= $HeightThumb) {

            //$widthScaledThumb = $HeightThumb*$widthOriginalImg/$heightOriginalImg;
            if($cgVersion>=7){
                // eventually user settings very low, this why this check
                if($WidthThumbImageShouldBe <= $thumbSizesWp['medium_size_w']){
                    $imageThumb = wp_get_attachment_image_src($WpUpload, 'medium');
                }else{
                    $imageThumb = wp_get_attachment_image_src($WpUpload, 'large');
                }
                $imageThumb = $imageThumb[0];
            }
            else{
                $imageThumb = $content_url.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-300width.'.$value->ImgType;
            }


            // Bestimmung von Breite des Bildes
            $WidthThumbPic = $HeightThumb*$widthOriginalImg/$heightOriginalImg;
            $WidthThumbPic = $WidthThumbPic.'px';

            // Bestimmung wie viel links und rechts abgeschnitten werden soll
            @$paddingLeftRight = ($WidthThumbPic-$WidthThumb)/2;
            @$paddingLeftRight = $paddingLeftRight.'px';

            $padding = "left: -$paddingLeftRight;right: -$paddingLeftRight";

        }

        // Falls über der eingestellten Höhe, dann kleineres Bild nehmen (kein Vertikalbild)
        if ($heightScaledThumb > $HeightThumb) {

            if($cgVersion>=7){
                // eventually user settings very low, this why this check
                if($WidthThumbImageShouldBe <= $thumbSizesWp['medium_size_w']){
                    $imageThumb = wp_get_attachment_image_src($WpUpload, 'medium');
                }else{
                    $imageThumb = wp_get_attachment_image_src($WpUpload, 'large');
                }
                $imageThumb = $imageThumb[0];
            }
            else{
                $imageThumb = $content_url.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-300width.'.$value->ImgType;
            }


            if($rThumb=='90' or $rThumb=='270'){

                $WidthThumbPic = $WidthThumb*$rotateRatio;
                $WidthThumbPic = $WidthThumbPic.'px';

            }
            else{
                // Bestimmung von Breite des Bildes
                $WidthThumbPic = $WidthThumb.'px';
            }


            // Bestimmung wie viel oben und unten abgeschnitten werden soll
            $heightImageThumb = $WidthThumb*$heightOriginalImg/$widthOriginalImg;
            $paddingTopBottom = ($heightImageThumb-$HeightThumb)/2;
            $paddingTopBottom = $paddingTopBottom.'px';

            $padding = "top: -$paddingTopBottom;bottom: -$paddingTopBottom";

        }

        // Bild wird mittig und passend zum Div angezeigt	--------  ENDE



        // ----------- Ermitteln der Sprache des Blogs, um das Upload Datum in richtiger schreibweise anzuzeigen

        $uploadTime = date('d-M-Y H:i', $value->Timestamp);


        // Ermitteln der Sprache des Blogs, um das Upload Datum in richtiger schreibweise anzuzeigen  ------------  ENDE


        //$uploads = wp_upload_dir();
//$WPdestination = $uploads['baseurl'].'/contest-gallery/gallery-id-'.$GalleryID.'/'; // Pfad zum Bilderordner angeben


        echo "<div class='cg_backend_info_container'>";
        if($WpUpload>=1){
            $checkCookieIdOrIPMarginLeft = '';
            if($pro_options->RegUserUploadOnly=='2'){
                $checkCookieIdOrIP = ", Cookie ID";
                $checkCookieIdOrIPMarginLeft = 'margin-top: -81px !important;';
            }else if($pro_options->RegUserUploadOnly=='3'){
                $checkCookieIdOrIP = ", IP";
            }

            echo '<span class="cg-info-container cg-info-container-gallery-user" style="display: none;margin-left:-31px !important;'.$checkCookieIdOrIPMarginLeft.'">Image name, exif data, picture id or user email, user nickname'.$checkCookieIdOrIP.' must contain the searched value</span>';
            echo "<input type='hidden' class='cg_wp_post_title' value='$post_title'>";
            echo "<input type='hidden' class='cg_wp_post_name' value='$post_name'>";
            echo "<input type='hidden' class='cg_wp_post_content' value='$post_description'>";
            if($WpUserId>=1){
                echo "<input type='hidden' class='cg_wp_user_login' value='".$allWpUsersByIdArray[$WpUserId]['user_login']."'>";
                echo "<input type='hidden' class='cg_wp_user_nicename' value='".$allWpUsersByIdArray[$WpUserId]['user_nicename']."'>";
                echo "<input type='hidden' class='cg_wp_user_email' value='".$allWpUsersByIdArray[$WpUserId]['user_email']."'>";
                echo "<input type='hidden' class='cg_wp_user_display_name' value='".$allWpUsersByIdArray[$WpUserId]['display_name']."'>";
            }
            echo "<input type='hidden' class='cg_image_id' value='$id'>";
        }
        echo "<div class='cg_backend_rotate_image'>";
        echo "<a class='cg_image_action_href cg_load_backend_link' href=\"?page=contest-gallery/index.php&option_id=$GalleryID&cg_image_rotate=true&cg_image_id=$id&cg_image_wp_id=$WpUpload\"><span class='cg_image_action_span'>Rotate Image</span></a>";
        echo "</div>";
        echo '<div class="cg_backend_picture_id_container" >
id: '.$id.'
</div>';
        echo '<div style="width:160px;height:106px;overflow: hidden !important;position: relative;float:left;display:inline;">';

        echo '<a href="'.$sourceOriginalImgShow.'" target="_blank" title="Show full size" alt="Show full size"><img class="cg'.$rThumb.'degree" src="'.$imageThumb.'" style="'.$padding.';position: absolute !important;max-width:none !important;" width="'.$WidthThumbPic.'"></a>';
        //echo '<a href="'.$sourceOriginalImgShow.'" target="_blank" title="Show full size" alt="Show full size"><img src="'.$WPdestination.$value->Timestamp.'_'.$value->NamePic.'-300width.'.$value->ImgType.'" style="'.$padding.';position: absolute !important;max-width:none !important;" width="'.$WidthThumbPic.'"></a>';
        echo "</div>";
        echo '<div class="cg_backend_info_upload_date_container">
<span class="cg_backend_info_details_small">Added on (server-time)<br>'.$uploadTime.'</span>';

        if($RegUserUploadOnly==3){
            echo '<span class="cg_backend_info_details_small">IP '.$IP.'</span>';
            echo "<input type='hidden' class='cg_cookie_id_or_ip' value='".$IP."'>";
        }
        if($RegUserUploadOnly==2){
            if(!empty($CookieId)){
                echo '<span class="cg_backend_info_details_small">Cookie ID '.$CookieId.'</span>';
                echo "<input type='hidden' class='cg_cookie_id_or_ip' value='".$CookieId."'>";
            }
        }
        echo '</div>';

// eventually for future versions
        if(false){
            if(function_exists('exif_read_data')){


                echo '<div class="cg-exif-container" >';
                echo '<button type="button">Exif</button>';

                echo '<div class="cg-exif-append">';

                if(empty($exifData)){
                    echo "<p> Exif data is available since plugin version 10.7.0.
                          If you want to see exif data of this image then simply resave it at the bottom of this area. </p>";
                }else{
                    foreach($exifData as $exifKey => $exifValue){

                    }
                }

                echo '</div>';


                echo '</div>';

            }
        }


        // Berechnung und Anzeige des durchschnittlichen Ratings


        if($AllowRating==1){

            echo '<div class="cg_5_star_main_rating_container">';

            if($IsModernFiveStar==1){

                $countR1 = $value->CountR1;
                $countR2 = $value->CountR2;
                $countR3 = $value->CountR3;
                $countR4 = $value->CountR4;
                $countR5 = $value->CountR5;

            }else{

                $countR1 = $wpdb->get_var( $wpdb->prepare(
                    "
								SELECT COUNT(*) AS NumberOfRows
								FROM $tablenameIP
								WHERE GalleryID = %d and Rating = %d and pid = %d
							",
                    $GalleryID,1,$id
                ) );

                $countR2 = $wpdb->get_var( $wpdb->prepare(
                    "
								SELECT COUNT(*) AS NumberOfRows
								FROM $tablenameIP
								WHERE GalleryID = %d and Rating = %d and pid = %d
							",
                    $GalleryID,2,$id
                ) );

                $countR3 = $wpdb->get_var( $wpdb->prepare(
                    "
								SELECT COUNT(*) AS NumberOfRows
								FROM $tablenameIP
								WHERE GalleryID = %d and Rating = %d and pid = %d
							",
                    $GalleryID,3,$id
                ) );

                $countR4 = $wpdb->get_var( $wpdb->prepare(
                    "
								SELECT COUNT(*) AS NumberOfRows
								FROM $tablenameIP
								WHERE GalleryID = %d and Rating = %d and pid = %d
							",
                    $GalleryID,4,$id
                ) );

                $countR5 = $wpdb->get_var( $wpdb->prepare(
                    "
								SELECT COUNT(*) AS NumberOfRows
								FROM $tablenameIP
								WHERE GalleryID = %d and Rating = %d and pid = %d
							",
                    $GalleryID,5,$id
                ) );

            }

            if(empty($countR1)){
                $countR1 = 0;
            }
            if(empty($countR2)){
                $countR2 = 0;
            }
            if(empty($countR3)){
                $countR3 = 0;
            }
            if(empty($countR4)){
                $countR4 = 0;
            }
            if(empty($countR5)){
                $countR5 = 0;
            }


            $countR1origin = $countR1;
            $countR2origin = $countR2;
            $countR3origin = $countR3;
            $countR4origin = $countR4;
            $countR5origin = $countR5;

            if($Manipulate==1){
                $countR1 = $countR1+$addCountR1;
                $countR2 = $countR2+$addCountR2;
                $countR3 = $countR3+$addCountR3;
                $countR4 = $countR4+$addCountR4;
                $countR5 = $countR5+$addCountR5;
            }

            if($Manipulate==1){
                $countRtotalCheck = $countR+$addCountR1+$addCountR2+$addCountR3+$addCountR4+$addCountR5;
            }
            else{
                $countRtotalCheck = $countR;
            }

            $countManipulateCummulated = 0;
            $countManipulateCummulatedHide = '';

            if($Manipulate==1){
                $ratingCummulated = $rating+$addCountR1*1+$addCountR2*2+$addCountR3*3+$addCountR4*4+$addCountR5*5;
                $countManipulateCummulated = $addCountR1+$addCountR2+$addCountR3+$addCountR4+$addCountR5;
            }
            else{
                $ratingCummulated = $rating;
            }

            if ($countRtotalCheck!=0){
                $averageStars = $ratingCummulated/$countRtotalCheck;
                $averageStarsRounded = round($averageStars,1);
                //echo "<br>averageStars: $averageStars<br>";
            }

            else{$countRtotalCheck=0; $averageStarsRounded = 0;}

            $starTest1 = 'cg_gallery_rating_div_one_star_off';
            $starTest2 = 'cg_gallery_rating_div_one_star_off';
            $starTest3 = 'cg_gallery_rating_div_one_star_off';
            $starTest4 = 'cg_gallery_rating_div_one_star_off';
            $starTest5 = 'cg_gallery_rating_div_one_star_off';

            if($averageStarsRounded>=1){$starTest1 = 'cg_gallery_rating_div_one_star_on';}
            if($averageStarsRounded>=1.25 AND $averageStarsRounded<1.75){$starTest2 = 'cg_gallery_rating_div_one_star_half_off';}

            if($averageStarsRounded>=1.75){$starTest2 = 'cg_gallery_rating_div_one_star_on';}
            if($averageStarsRounded>=2.25 AND $averageStarsRounded<2.75){$starTest3 = 'cg_gallery_rating_div_one_star_half_off';}

            if($averageStarsRounded>=2.75){$starTest3 = 'cg_gallery_rating_div_one_star_on';}
            if($averageStarsRounded>=3.25 AND $averageStarsRounded<3.75){$starTest4 = 'cg_gallery_rating_div_one_star_half_off';}

            if($averageStarsRounded>=3.75){$starTest4 = 'cg_gallery_rating_div_one_star_on';}
            if($averageStarsRounded>=4.25 AND $averageStarsRounded<4.75){$starTest5 = 'cg_gallery_rating_div_one_star_half_off';}

            if($averageStarsRounded>=4.75){$starTest5 = 'cg_gallery_rating_div_one_star_on';}

            echo '<div class="cg_rating_5_star_img_div_container">';

            echo "<div class='cg_rating_5_star_img_div cg_rating_5_star_img_div_one_star $starTest1' ></div>";
            echo "<div class='cg_rating_5_star_img_div cg_rating_5_star_img_div_two_star $starTest2' ></div>";
            echo "<div class='cg_rating_5_star_img_div cg_rating_5_star_img_div_three_star $starTest3' ></div>";
            echo "<div class='cg_rating_5_star_img_div cg_rating_5_star_img_div_four_star $starTest4' ></div>";
            echo "<div class='cg_rating_5_star_img_div cg_rating_5_star_img_div_five_star $starTest5' ></div>";
            echo "<div class='cg_rating_value_countR_div cg_rating_value_countR'>".$countRtotalCheck."</div>";
            if($Manipulate==1){
                if($countManipulateCummulated<1){
                    $countManipulateCummulatedHide = 'cg_hide';
                }
                echo "<div class='cg_rating_value_countR_additional_votes cg_rating_value_countR_additional_votes_total $countManipulateCummulatedHide'>".$countManipulateCummulated."</div>";
            }

            echo '</div>';

            //echo "<div style='display:inline-block;position:relative;font-size:12px;v-align: top;line-height: 12px;height: 12px;color:#fff;text-align:center;margin-top:4px;' ><b>Cumulated: (<span class='cg_rating_value_countR_cumulated'>".$ratingCummulated."</span>)</b></div>";
            //	echo "<br/>";

            echo '<div class="cg_stars_overview">';


            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";
            echo "<div class='cg_stars_overview_countR cg_rating_value_countR1' >".$countR1."</div>";

            if($Manipulate==1){
                $cg_hide = ($addCountR1>=1) ? '' : 'cg_hide';
                echo "<div class='cg_rating_value_countR_additional_votes cg_rating_value_countR_additional_votes_1 $cg_hide'>".$addCountR1."</div>";
            }

            echo "</div>";

            echo '<div class="cg_stars_overview">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";
            echo "<div class='cg_stars_overview_countR cg_rating_value_countR2' >".$countR2."</div>";

            if($Manipulate==1){
                $cg_hide = ($addCountR2>=1) ? '' : 'cg_hide';
                echo "<div class='cg_rating_value_countR_additional_votes cg_rating_value_countR_additional_votes_2 $cg_hide'>".$addCountR2."</div>";
            }

            echo "</div>";


            echo '<div class="cg_stars_overview">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";
            echo "<div class='cg_stars_overview_countR cg_rating_value_countR3' >".$countR3."</div>";

            if($Manipulate==1){
                $cg_hide = ($addCountR3>=1) ? '' : 'cg_hide';
                echo "<div class='cg_rating_value_countR_additional_votes cg_rating_value_countR_additional_votes_3 $cg_hide'>".$addCountR3."</div>";
            }

            echo "</div>";

            echo '<div class="cg_stars_overview">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";
            echo "<div class='cg_stars_overview_countR cg_rating_value_countR4' >".$countR4."</div>";

            if($Manipulate==1){
                $cg_hide = ($addCountR4>=1) ? '' : 'cg_hide';
                echo "<div class='cg_rating_value_countR_additional_votes cg_rating_value_countR_additional_votes_4 $cg_hide'>".$addCountR4."</div>";
            }

            echo "</div>";

            echo '<div class="cg_stars_overview">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='5'></div>";
            echo "<div class='cg_stars_overview_countR cg_rating_value_countR5' >".$countR5."</div>";

            if($Manipulate==1){
                $cg_hide = ($addCountR5>=1) ? '' : 'cg_hide';
                echo "<div class='cg_rating_value_countR_additional_votes cg_rating_value_countR_additional_votes_5 $cg_hide'>".$addCountR5."</div>";
            }

            echo "</div>";


            echo "<div class='cg-show-votes cg-show-votes-five-stars-area'><a class='cg_image_action_href cg_load_backend_link' href='?page=contest-gallery/index.php&image_id=$id&show_votes=true&option_id=$GalleryID'><span class='cg_image_action_span'>Show votes</span></a></div>";


            echo '</div>';




        }
        else if($AllowRating==2){

            echo '<div class="cg_allow_rating_one_star">';

            echo "<div class='cg_rating_center' >";

            if($Manipulate==1){

                $finalCountSvalue = $countS+$addCountS;

            }

            else{
                $finalCountSvalue = $countS;
            }

            if ($countS>0){
                $countS = $countS;
            }
            else{$countS=0;}

            if($finalCountSvalue>=1){$starTest6 = $iconsURL.'/star_48_reduced.png';}
            else{$starTest6 = $iconsURL.'/star_off_48_reduced_with_border.png';}

            if($finalCountSvalue=='' || $finalCountSvalue==null){
                $finalCountSvalue = 0;
            }
            echo "<div><img src='$starTest6'  style='float:left;cursor:default;' alt='1'></div>";
            echo "";
            echo "<input type='hidden' class='cg_value_origin' value='$countS' >";
            echo "<input type='hidden' class='cg_value_add_one_star' value='$addCountS' name='addCountS[$id]'>";


            if($finalCountSvalue<0){
                $finalCountSvalue = 0;
            }

            echo "<div class='cg_rating_value'>".@$finalCountSvalue."</div>";

            if($Manipulate==1){
                $cg_hide = ($addCountS>=1) ? '' : 'cg_hide';
                echo "<div class='cg_rating_value_countR_additional_votes $cg_hide'>".$addCountS."</div>";
            }

            echo '</div>';

            echo "<div class='cg-show-votes'><a class='cg_image_action_href cg_load_backend_link' href='?page=contest-gallery/index.php&image_id=$id&show_votes=true&option_id=$GalleryID'><span class='cg_image_action_span'>Show votes</span></a></div>";

            echo '</div>';

        }
        else if($FbLike==1){

            echo '<div class="cg_backend_info_show_votes_fb_like">';


            echo "<div class='cg-show-votes' ><a class='cg_image_action_href cg_load_backend_link' href='?page=contest-gallery/index.php&image_id=$id&show_votes=true&option_id=$GalleryID'><span class='cg_image_action_span'>Show votes</span></a></div>";

            echo '</div>';

        }





        /*
        if($FbLike==1){
        echo "<div style='display:inline-block;font-size:12px;line-height: 28px;height: 28px;color:#fff;position:relative;width:100px;overflow:hidden;margin-left:5px;' >";
        echo "<div style='z-index:15;border:none;margin: 0;padding 5;height:30px;position:absolute;width:45px;left:4px;top:1px;background-color: #23282D;'>";
        echo "<b>Fb Like:</b>";
        echo "</div>";
        echo "<div style='border:none;margin: 0;padding 0;height:25px;position:absolute;width:200px;top:0px;z-index:0;left:-90px;top:5px;' id='cg_fb_like_div".$realId."'>";
        echo "<iframe src='".$urlForFacebook."'  style='border: none;width:180px;height:50px;overflow:hidden;' scrolling='no' id='cg_fb_like_iframe_gallery".$realId."'  name='cg_fb_like_iframe_gallery".$realId."'></iframe>";
        echo "</div>";
        echo "</div>";
        }*/

        // Berechnung und Anzeige des durchschnittlichen Ratings --- ENDE



        if($Manipulate==1 && $AllowRating==2){
            echo "<div style='' class='cg_manipulate_container'>";


            echo "<div class='cg_manipulate'>";
            echo "<div class='cg_manipulate_adjust'>";

            echo "<span class='cg_manipulate_adjust_one_star'>Manipulation</span>";

            //echo "<select class='cg_manipulate_plus_minus'><option value='+'>+</option><option value='-'>-</option></select>";
            if($addCountS==0){
                $addCountS=0;
            }

            echo "<input type='number' max='9999999' min='-9999999' class='cg_manipulate_plus_value' value='$addCountS'>";
            echo "</div></div>";

            echo '</div>';

        }

        if($Manipulate==1 && $AllowRating==1){

            //    echo "<div style='float:left;width:160px;text-align:center;left:0px;'>";


            echo "<input type='hidden' class='cg_value_origin_5_star_count' value='$countR' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_rating' value='$rating' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_countBeforeInput' value='$countR' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_addCountR1 cg_value_origin_5_star_to_cumulate' value='$addCountR1' name='addCountR1[$id]' >";
            echo "<input type='hidden' class='cg_value_origin_5_only_value_1' value='$countR1origin' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_addCountR2 cg_value_origin_5_star_to_cumulate' value='$addCountR2' name='addCountR2[$id]' >";
            echo "<input type='hidden' class='cg_value_origin_5_only_value_2' value='$countR2origin' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_addCountR3 cg_value_origin_5_star_to_cumulate' value='$addCountR3' name='addCountR3[$id]' >";
            echo "<input type='hidden' class='cg_value_origin_5_only_value_3' value='$countR3origin' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_addCountR4 cg_value_origin_5_star_to_cumulate' value='$addCountR4' name='addCountR4[$id]' >";
            echo "<input type='hidden' class='cg_value_origin_5_only_value_4' value='$countR4origin' >";
            echo "<input type='hidden' class='cg_value_origin_5_star_addCountR5 cg_value_origin_5_star_to_cumulate' value='$addCountR5' name='addCountR5[$id]' >";
            echo "<input type='hidden' class='cg_value_origin_5_only_value_5' value='$countR5origin' >";

            echo "<div class='cg_manipulate'>";
            echo "<div class='cg_manipulate_adjust'>";

            echo "<span class='cg_manipulate_adjust_five_star'>Manipulation</span>";

            //echo "<select class='cg_manipulate_plus_minus'><option value='+'>+</option><option value='-'>-</option></select>";
            if($addCountS==0){
                $addCountS='';
            }


            // $starOn = $iconsURL.'/star_48_reduced.png';
            // $starOff = $iconsURL.'/star_off_48_reduced.png';

            echo '<div class="cg_manipulate_container_5_stars">';


            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";

            echo "<div class='cg_manipulate_5_star_input_div' ><input data-star='1' type='number' class='cg_manipulate_5_star_input cg_manipulate_1_star_number' max='9999999' min='-9999999' class='cg_manipulate_plus_value' value='$addCountR1'  ></div>";
            echo "</div>";

            echo '<div class="cg_manipulate_container_5_stars">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";


            echo "<div class='cg_manipulate_5_star_input_div' ><input data-star='2' type='number' class='cg_manipulate_5_star_input cg_manipulate_2_star_number' max='9999999' min='-9999999' class='cg_manipulate_plus_value' value='$addCountR2'  ></div>";
            echo "</div>";


            echo '<div class="cg_manipulate_container_5_stars">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";


            echo "<div class='cg_manipulate_5_star_input_div' ><input data-star='3' type='number' class='cg_manipulate_5_star_input cg_manipulate_3_star_number' max='9999999' min='-9999999' class='cg_manipulate_plus_value' value='$addCountR3'  ></div>";
            echo "</div>";

            echo '<div class="cg_manipulate_container_5_stars">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOff'  class='cg_manipulate_5_star_img' alt='5'></div>";


            echo "<div class='cg_manipulate_5_star_input_div' ><input data-star='4' type='number' class='cg_manipulate_5_star_input cg_manipulate_4_star_number' max='9999999' min='-9999999' class='cg_manipulate_plus_value' value='$addCountR4'  ></div>";
            echo "</div>";

            echo '<div class="cg_manipulate_container_5_stars">';

            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='1'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='2'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='3'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='4'></div>";
            echo "<div class='cg_manipulate_5_star'><img src='$starOn'  class='cg_manipulate_5_star_img' alt='5'></div>";

            echo "<div class='cg_manipulate_5_star_input_div' ><input data-star='5' type='number' class='cg_manipulate_5_star_input cg_manipulate_5_star_number' max='9999999' min='-9999999' class='cg_manipulate_plus_value' value='$addCountR5'  ></div>";
            echo "</div>";



            echo "</div>";
            echo "</div>";


        }



        // Link zum Wordpress User in WP Management

        if($WpUserId>0){


            if(!empty($allWpUsersByIdArray[$WpUserId])){
                echo "<div class='cg_backend_info_user_link_container'>";

                echo "<span>Added by</span><a class=\"cg_image_action_href cg_load_backend_link\" href='?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&wp_user_id=".$allWpUsersByIdArray[$WpUserId]['ID']."'><span class=\"cg_image_action_span\" >".$allWpUsersByIdArray[$WpUserId]['user_login']."</span></a>";

                if(in_array($WpUserId,$wpUsersIdsWithNotConfirmedMailArray)){
                    echo "<div style='margin-top:7px;font-weight:600;'>Mail not confirmed</div>";
                }

                echo '</div>';
            }
        }
        // Link zum Wordpress User in WP Management ---- ENDE

        echo "</div>";


        /*	echo "<div id='cg_answerJPG' style='position:absolute;margin-right:35px;width:460px;background-color:white;border:1px solid;padding:5px;display:none;'>";
    echo "This allows you to restrict the resolution of the pictures which will be uploaded in frontend. It depends on your web hosting provider how big resolution ca be be for uploaded pics.";
    echo " If your webhosting service is not so powerfull then you should use this restriction.</div>";*/

        echo "<div class='cg_fields_div'>";

        //print_r($selectUpload);

        // FELDBENENNUNGEN

        // 1 = Feldtyp
        // 2 = Feldnummer
        // 3 = Feldtitel
        // 4 = Feldinhalt
        // 5 = Feldkrieterium1
        // 6 = Feldkrieterium2
        // 7 = Felderfordernis

        $r = 0; // Notwendig zur Überprüfung ab wann das dritte Feld versteckt wird. ACHTUNG: Bild-Uploadfeld immer dabei, dasswegen r>=4 zum Schluss.

        if ($selectFormInput == true OR $optionsSQL->FbLike==1) {

            if(!empty($selectContentFieldArray)){
                foreach($selectContentFieldArray as $key => $formvalue){


                    // 1. Feld Typ
                    // 2. ID des Feldes in F_INPUT
                    // 3. Feld Reihenfolge
                    // 4. Feld Content


                    if(@$formvalue=='text-f'){$fieldtype="nf"; $i=1; continue;}
                    if(@$fieldtype=="nf" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="nf" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if (@$fieldtype=="nf" AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        /*							$getEntries = $wpdb->get_var( $wpdb->prepare(
                                                "
                                                    SELECT Short_Text
                                                    FROM $tablenameentries
                                                    WHERE pid = %d and f_input_id = %d
                                                ",
                                                $id,$formFieldId
                                                ) );*/


                        $formvalue = html_entity_decode(stripslashes($formvalue));
                        $getEntries1 = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));

                        // Prüfen ob das Feld im Slider angezeigt werden soll
                        if($AllowGalleryScript==1){
                            if(array_search($formFieldId, @$ShowSliderInputID)){$checked='checked';}
                            else{$checked='';}
                        }

                        echo "<div style='width:540px;' class='cg_image_title_container' >";
                        echo "$formvalue:<br/>";
                        //echo "$formFieldId:<br/>";
                        echo "<input type='text' value='$getEntries1' name='content[$id][$formFieldId][short-text]'  maxlength='1000' class='cg_image_title cg_short_text'>";
                        echo "<img src='$titleIcon' title='Insert original WordPress title' alt='Insert original WordPress title' class='cg_title_icon' />";
                        echo "<input type='hidden' class='post_title' value='$post_title' >";

                        //echo "$Use_as_URL_id";
                        //echo "<br>$formFieldId";

                        if(@$Use_as_URL_id==$formFieldId AND $ForwardToURL==1){

                            //echo "&nbsp;&nbsp;&nbsp;<strong>URL</strong>";

                        }
                        else{
                            /*if($AllowGalleryScript==1){
                            echo "&nbsp;&nbsp;&nbsp;<input type='checkbox' class='cg_field_$formFieldId' name='cg_f_input_id[$formFieldId]' title='This field will appear in slider if you hook it.' $checked>";
                            }*/
                        }
                        echo "</div>";

                        $fieldtype='';

                        $i=0;

                    }

                    if(@$formvalue=='date-f'){$fieldtype="dt"; $i=1; continue;}
                    if(@$fieldtype=="dt" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="dt" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if (@$fieldtype=="dt" AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        /*							$getEntries = $wpdb->get_var( $wpdb->prepare(
                                                "
                                                    SELECT Short_Text
                                                    FROM $tablenameentries
                                                    WHERE pid = %d and f_input_id = %d
                                                ",
                                                $id,$formFieldId
                                                ) );*/

                        $formvalue = html_entity_decode(stripslashes($formvalue));
                        $getEntries1 = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));

                        $newDateTimeString = '';
                        $dtFormatOriginal = $dateFieldFormatTypesArray[$formFieldId];

                        if(!empty($getEntries1) AND $getEntries1!='0000-00-00 00:00:00'){

                            try {

                                $dtFormat = $dateFieldFormatTypesArray[$formFieldId];

                                $dtFormat = str_replace('YYYY','Y',$dtFormat);
                                $dtFormat = str_replace('MM','m',$dtFormat);
                                $dtFormat = str_replace('DD','d',$dtFormat);
                                $newDateTimeObject = DateTime::createFromFormat("Y-m-d H:i:s",$getEntries1);

                                if(is_object($newDateTimeObject)){
                                    $newDateTimeString = $newDateTimeObject->format("$dtFormat");
                                }

                            }catch (Exception $e) {

                                //echo $e->getMessage();
                                $newDateTimeString = '';

                            }

                        }

                        if(!empty($getEntries1) AND $getEntries1!='0000-00-00 00:00:00' AND empty($newDateTimeObject)){// is false if not worked
                            $dtFormatOriginal = 'YYYY-MM-DD';
                        }

                        echo "<div style='width:540px;' class='cg_image_title_container' >";
                        echo "$formvalue:<br/>";
                        //echo "$formFieldId:<br/>";
                        echo "<input type='text' value='$newDateTimeString' autocomplete='off' name='content[$id][$formFieldId][date-field]'  maxlength='1000' class='cg_image_title cg_short_text cg_input_date_class'>";
                        echo "<input type='hidden' value='$dtFormatOriginal' class='cg_date_format'>";
                        //echo "$Use_as_URL_id";
                        //echo "<br>$formFieldId";

                        echo "</div>";

                        $fieldtype='';

                        $i=0;

                    }


                    // 1. Feld Typ
                    // 2. ID des Feldes in F_INPUT
                    // 3. Feld Reihenfolge
                    // 4. Feld Content


                    if(@$formvalue=='url-f'){$fieldtype="url"; $i=1; continue;}
                    if(@$fieldtype=="url" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="url" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if (@$fieldtype=="url" AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        /*                                $getEntries = $wpdb->get_var( $wpdb->prepare(
                                                    "
                                                        SELECT Short_Text
                                                        FROM $tablenameentries
                                                        WHERE pid = %d and f_input_id = %d
                                                    ",
                                                    $id,$formFieldId
                                                    ) );*/


                        $formvalue = html_entity_decode(stripslashes($formvalue));
                        $getEntries1 = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));

                        // Prüfen ob das Feld im Slider angezeigt werden soll
                        if($AllowGalleryScript==1){
                            if(array_search($formFieldId, @$ShowSliderInputID)){$checked='checked';}
                            else{$checked='';}
                        }

                        echo "<div style='width:540px;' class='cg_image_title_container' >";
                        echo "$formvalue:<br/>";
                        //echo "$formFieldId:<br/>";
                        echo "<input type='text' value='$getEntries1' name='content[$id][$formFieldId][short-text]'  style='width: 500px;' placeholder='www.example.com' maxlength='1000' class='cg_image_title cg_short_text'>";
                        //   echo "<img src='$titleIcon' title='Insert original WordPress title' alt='Insert original WordPress title' class='cg_title_icon' />";
                        //    echo "<input type='hidden' class='post_title' value='$post_title' >";

                        //echo "$Use_as_URL_id";
                        //echo "<br>$formFieldId";

                        if(@$Use_as_URL_id==$formFieldId AND $ForwardToURL==1){

                            //echo "&nbsp;&nbsp;&nbsp;<strong>URL</strong>";

                        }
                        else{
                            /*if($AllowGalleryScript==1){
                            echo "&nbsp;&nbsp;&nbsp;<input type='checkbox' class='cg_field_$formFieldId' name='cg_f_input_id[$formFieldId]' title='This field will appear in slider if you hook it.' $checked>";
                            }*/
                        }
                        echo "</div>";

                        $fieldtype='';

                        $i=0;

                    }

                    if(@$formvalue=='select-f'){$fieldtype="se"; $i=1; continue;}
                    if(@$fieldtype=="se" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="se" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if (@$fieldtype=="se" AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        /*							$getEntries = $wpdb->get_var( $wpdb->prepare(
                                                "
                                                    SELECT Short_Text
                                                    FROM $tablenameentries
                                                    WHERE pid = %d and f_input_id = %d
                                                ",
                                                $id,$formFieldId
                                                ) );*/


                        $formvalue = html_entity_decode(stripslashes($formvalue));
                        $getEntries1 = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));

                        // Prüfen ob das Feld im Slider angezeigt werden soll
                        if($AllowGalleryScript==1){
                            if(array_search($formFieldId, @$ShowSliderInputID)){$checked='checked';}
                            else{$checked='';}
                        }

                        echo "<div style='width:540px;' class='cg_image_title_container'>";
                        echo "$formvalue:<br/>";
                        //echo "$formFieldId:<br/>";
                        echo "<input type='text' value='$getEntries1' name='content[$id][$formFieldId][short-text]' style='width: 500px;' maxlength='1000' class='cg_image_title cg_short_text'>";
                        echo "<img src='$titleIcon' title='Insert original WordPress title' alt='Insert original WordPress title' class='cg_title_icon' />";
                        echo "<input type='hidden' class='post_title' value='$post_title' >";

                        //echo "$Use_as_URL_id";
                        //echo "<br>$formFieldId";

                        if(@$Use_as_URL_id==$formFieldId AND $ForwardToURL==1){

                            echo "&nbsp;&nbsp;&nbsp;<strong>URL</strong>";

                        }
                        else{
                            /*if($AllowGalleryScript==1){
                            echo "&nbsp;&nbsp;&nbsp;<input type='checkbox' class='cg_field_$formFieldId' name='cg_f_input_id[$formFieldId]' title='This field will appear in slider if you hook it.' $checked>";
                            }*/
                        }
                        echo "</div>";

                        $fieldtype='';

                        $i=0;

                    }

                    if(@$formvalue=='selectc-f'){$fieldtype="sec"; $i=1; continue;}
                    if(@$fieldtype=="sec" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="sec" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if (@$fieldtype=="sec" AND $i==3) {

                        if(!empty($categories)){
                            //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                            /*                            $getEntries = $wpdb->get_var( $wpdb->prepare(
                                                        "
                                                        SELECT Short_Text
                                                        FROM $tablenameentries
                                                        WHERE pid = %d and f_input_id = %d
                                                    ",
                                                        $id,$formFieldId
                                                    ) );*/


                            $formvalue = html_entity_decode(stripslashes($formvalue));
                            //                            $getEntries1 = html_entity_decode(stripslashes($getEntries));

                            // Prüfen ob das Feld im Slider angezeigt werden soll
                            /*                            if($AllowGalleryScript==1){
                                                        if(array_search($formFieldId, @$ShowSliderInputID)){$checked='checked';}
                                                        else{$checked='';}
                                                    }*/

                            echo "<div style='width:540px;' >";
                            echo "$formvalue:<br/>";
                            //echo "$formFieldId:<br/>";
                            //  echo "<input type='hidden' name='content[]' value='$id'>";
                            //  echo "<input type='hidden' name='content[]' value='$formFieldId'>";
                            //  echo "<input type='hidden' name='content[]' value='$fieldOrder'>";
                            echo "<select name='imageCategory[$id]' class='cg_category_select'>";
                            echo "<option value='0'>Select category</option>";

                            $selectedCat = '';

                            foreach($categories as $category){

                                if($imageCategory==$category->id){
                                    $selectedCat = 'selected';
                                    echo "<option value='".$category->id."' $selectedCat>".$category->Name."</option>";
                                }
                                else{
                                    echo "<option value='".$category->id."' >".$category->Name."</option>";
                                }
                            }

                            echo "</select>";



                            // echo "<input type='hidden' name='content[]' value='selectc-f'>";
                            //  echo "<input type='text' value='$getEntries1' name='content[]'  style='width: 500px;' maxlength='1000' class='cg_image_title'>";
                            // echo "<img src='$titleIcon' title='Insert original WordPress title' alt='Insert original WordPress title' class='cg_title_icon' />";
                            ///echo "<input type='hidden' class='post_title' value='$post_title' >";

                            //echo "$Use_as_URL_id";
                            //echo "<br>$formFieldId";

                            if(@$Use_as_URL_id==$formFieldId AND $ForwardToURL==1){

                                echo "&nbsp;&nbsp;&nbsp;<strong>URL</strong>";

                            }
                            else{
                                /*if($AllowGalleryScript==1){
                                echo "&nbsp;&nbsp;&nbsp;<input type='checkbox' class='cg_field_$formFieldId' name='cg_f_input_id[$formFieldId]' title='This field will appear in slider if you hook it.' $checked>";
                                }*/
                            }
                            echo "</div>";

                            $fieldtype='';

                            $i=0;

                        }
                    }

                    if($formvalue=='email-f'){@$fieldtype="ef";  $i=1; continue;}
                    if(@$fieldtype=="ef" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="ef" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if (@$fieldtype=='ef' AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        $emailStatus = true;
                        $emailStatusText = 'Not confirmed';

                        if(!empty($WpUserId)){
                            //$getEntries = $wpUser->user_email;

                            $getEntriesMail = $allWpUsersByIdArray[$WpUserId]['user_email'];
                            $emailStatusText = 'Confirmed (registered user)';
                            $mailReadonly = "readonly";
                            $registeredUserMail = "(registered user email)";
                        }
                        else{

                            /*								$getEntries = $wpdb->get_row( $wpdb->prepare(
                                                        "
                                                            SELECT *
                                                            FROM $tablenameentries
                                                            WHERE pid = %d and f_input_id = %d
                                                        ",
                                                        $id,$formFieldId
                                                        ) );*/
                            $getEntriesMail = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));
                            $getEntriesConfMailId = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['ConfMailId']));

                            $mailReadonly = "readonly";
                            $registeredUserMail = "";

                            if(!empty($getEntriesMail)){
                                if($getEntriesConfMailId>0){
                                    $emailStatusText = 'Confirmed (not registered user)';
                                }
                            }

                        }

                        // Prüfen ob das Feld im Slider angezeigt werden soll
                        if($AllowGalleryScript==1){
                            if(array_search($formFieldId, @$ShowSliderInputID)){$checked='checked';}
                            else{$checked='';}
                        }

                        $formvalue = html_entity_decode(stripslashes($formvalue));

                        echo "<div style='width:540px;'>";
                        echo "$formvalue $registeredUserMail:<br/>";
                        //echo "$formFieldId:<br/>";
                        echo "<input type='text' value='$getEntriesMail' name='content[$id][$formFieldId][short-text]'  style='width: 500px;' class='email cg_short_text'  maxlength='1000' $mailReadonly>";
                        echo "<input type='hidden' value='$getEntriesMail' name='email[$id]'  style='width: 500px;' class='email-clone'  maxlength='1000' $mailReadonly>";
                        /*if($AllowGalleryScript==1){
                        echo "&nbsp;&nbsp;&nbsp;<input type='checkbox' class='cg_field_$formFieldId' name='cg_f_input_id[$formFieldId]' title='This field will appear in slider if you hook it.' $checked>";
                        }*/
                        echo "</div>";

                        $fieldtype='';

                        $i=0;

                    }

                    if($formvalue=='check-f'){@$fieldtype="cb";  $i=1; continue;}// Agreement field!
                    if(@$fieldtype=="cb" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if(@$fieldtype=="cb" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if(@$fieldtype=='cb' AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Short_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        $getEntries1 = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));
                        $getEntriesChecked = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Checked']));

                        if(!empty($getEntries1)){

                            $formvalue = html_entity_decode(stripslashes($formvalue));

                            $checked = '';
                            $checkedStatus = '';
                            if($getEntriesChecked==1){
                                $checked = 'checked';
                                $checkedStatus = 'checked';
                            }else{
                                $checked = '';
                                $checkedStatus = 'not checked';
                            }

                            echo "<div style='width:540px;'>";
                            echo "$formvalue:<br/>";
                            echo "<input style='width: unset !important;' type='checkbox' $checked disabled> $checkedStatus";
                            echo "</div>";

                        }

                        $fieldtype='';

                        $i=0;


                    }

                    if($formvalue=='comment-f'){$fieldtype="kf"; $i=1; continue;}
                    if($fieldtype=="kf" AND $i==1){$formFieldId=$formvalue; $i=2; continue;}
                    if($fieldtype=="kf" AND $i==2){$fieldOrder=$formvalue; $i=3; continue;}
                    if ($fieldtype=='kf' AND $i==3) {

                        //$getEntries = $wpdb->get_var( "SELECT Long_Text FROM $tablenameentries WHERE pid='$id' AND f_input_id = '$formFieldId'");

                        /*							$getEntries = $wpdb->get_var( $wpdb->prepare(
                                                "
                                                    SELECT Long_Text
                                                    FROM $tablenameentries
                                                    WHERE pid = %d and f_input_id = %d
                                                ",
                                                $id,$formFieldId
                                                ) );*/

                        $formvalue = html_entity_decode(stripslashes($formvalue));
                        $getEntries1 = html_entity_decode(stripslashes($allEntriesByImageIdArrayWithContent[$id][$formFieldId]['Content']));

                        // Prüfen ob das Feld im Slider angezeigt werden soll
                        if($AllowGalleryScript==1){
                            if(array_search($formFieldId, @$ShowSliderInputID)){$checked='checked';}
                            else{$checked='';}
                        }

                        echo "<div style='width:540px;' class='cg_image_description_container cg_image_excerpt_container'>";
                        echo "$formvalue:<br/>";
                        //echo "$formFieldId:<br/>";
                        echo "<textarea name='content[$id][$formFieldId][long-text]' rows='4' maxlength='10000' class='cg_image_description cg_image_excerpt cg_long_text'>$getEntries1</textarea>";
                        echo "<div class='cg_comment_icons_div'>";
                        echo "<img src='$descriptionIcon' title='Insert original WordPress description if exists' alt='Insert original WordPress description' class='cg_description_icon' />";
                        echo "<img src='$excerptIcon' title='Insert original WordPress excerpt if exists' alt='Insert original WordPress excerpt if exists' class='cg_excerpt_icon' />";
                        echo "<input type='hidden' class='post_description' value='$post_description' >";
                        echo "<input type='hidden' class='post_excerpt' value='$post_excerpt' >";
                        echo "</div>";



                        /*if($AllowGalleryScript==1){
                        echo "<input type='checkbox' class='cg_field_$formFieldId' name='cg_f_input_id[$formFieldId]' title='This field will appear in slider if you hook it.' style='float:right;margin-right:11px;margin-top:6px;' $checked>";
                        }*/
                        //echo '<div id="cg_questionJPG" style="display:inline;"><p style="font-size:18px;display:inline;">&nbsp;<a><b>?</b></a></p></div>';
                        echo "</div>";

                        $fieldtype='';

                        $i=0;

                    }


                }
            }


            if($optionsSQL->FbLike==1){


                if(!empty($fbLikeContentArray)){

                    if(!empty($selectContentFieldArray)){
                        echo "<hr class='cg_fields_div_divider'>";
                    }

                    $valueTitle = '';
                    $valueDescription = '';

                    if(!empty($fbLikeContentArray[$id])){
                        if(!empty($fbLikeContentArray[$id]['title'])){

                            $valueTitle = $fbLikeContentArray[$id]['title'];

                        }
                        if(!empty($fbLikeContentArray[$id]['description'])){

                            $valueDescription = $fbLikeContentArray[$id]['description'];

                        }
                    }

                    echo "<div style='width:540px;' class='cg_image_title_container' >";

                    echo "Facebook share button title:<br/>";
                    echo "<input type='text' value='".$valueTitle."' name='fbcontent[$id][title]'  maxlength='1000' class='cg_image_title'>";
                    $baseUrlFacebook=$uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/'.$Timestamp."_".$NamePic."413.html";
                    echo "<input type='hidden' value='".$baseUrlFacebook."' name='fbcontent[$id][baseUrlForFacebook]' >";
                    echo "<img src='$titleIcon' title='Insert original WordPress title' alt='Insert original WordPress title' class='cg_title_icon' />";
                    echo "<input type='hidden' class='post_title' value='$post_title' >";
                    echo "</div>";

                    echo "<div style='width:540px;' class='cg_image_description_container cg_facebook_description' >";

                    if((float)$optionsSQL->Version<10.9825){
                        echo "Facebook share button description: <span class=\"cg-info-icon\">info</span>
                                <div class=\"cg-info-container cg-info-container-facebook-description\" style=\"top: 21px;left: 38px;display: none;\">Can be only shown for images<br>added since plugin version 10.9.8.2.3<br>In general description appears with a delay after upload</div><br/>";
                    }else{
                        echo "Facebook share button description: <span class=\"cg-info-icon\">info</span>
                                <div class=\"cg-info-container cg-info-container-facebook-description\" style=\"top: 21px;left: 38px;display: none;\">In general description appears with a delay after upload</div><br/>";
                    }

                    echo "<textarea name='fbcontent[$id][description]'  maxlength='10000' rows='4' class='cg_image_description cg_image_excerpt'>$valueDescription</textarea>";
                    echo "<div class='cg_comment_icons_div'>";
                    echo "<img src='$descriptionIcon' title='Insert original WordPress description if exists' alt='Insert original WordPress description' class='cg_description_icon' />";
                    echo "<img src='$excerptIcon' title='Insert original WordPress excerpt if exists' alt='Insert original WordPress excerpt if exists' class='cg_excerpt_icon' />";
                    echo "<input type='hidden' class='post_description' value='$post_description' >";
                    echo "<input type='hidden' class='post_excerpt' value='$post_excerpt' >";
                    echo "</div>";
                    echo "</div>";

                }

            }

            echo "<hr class='cg_fields_div_divider' style='margin-bottom: 15px;'>";

            echo "<a class=\"cg_image_action_href cg_fields_div_add_fields\" href='?page=contest-gallery/index.php&define_upload=true&option_id=$GalleryID'><span class=\"cg_image_action_span\">Add fields</span></a>";


            if ($r>=4) {
                echo "</div>"; //Bild-Uploadfeld immer dabei, dasswegen r>=4 zum Schluss.
            }

            else{

                echo "&nbsp;";

            }



        }

        else{

            echo "&nbsp;";

        }

        echo "</div>";
        echo "<div class='cg_backend_status_container'>";

        echo "<div class='informdiv' style='margin-bottom:18px;'>";

        // Überprüfe ob schon aktiviert ist oder nicht

        //echo "$Active";

        if ($Active == 1) {echo 'Select:';
            echo '<input type="checkbox" class="cg_image_checkbox" value="'. $id .'" name="active['.$id.']"  style="float:right;margin: 2px 20px 0 0;">';
            //echo '<input type="hidden" class="deactivate_'. $id .'" value="'. $id .'"  name="deactivate['.$id.']" disabled >';
            //echo "<input type='hidden' name='active[$id]' value=\"$id\" class='image-delete' >";
        } // Beim Anklicken erscheinen Felder zum Deaktivieren
        else{echo 'Select:';
            //'<input type="checkbox" class="1activate_'. $id .'" value="'. $id .'" style="float:right;margin: 2px 20px 0 0;">';
            echo '<input type="checkbox" class="cg_image_checkbox" value="'. $id .'" name="active['.$id.']" style="float:right;margin: 2px 20px 0 0;">';
            //echo '<input type="hidden" class="deactivate_'. $id .'" value="'. $id .'" name="deactivate['.$id.']" >';
            //echo "<input type='hidden' disabled name='active[$id]' value=\"$id\" class='image-delete' >";
        } // Beim Anklicken erscheinen Felder zum Aktivieren

        if($CountC>0){ echo "<br><br><a class=\"cg_image_action_href cg_load_backend_link\" href=\"?page=contest-gallery/index.php&option_id=$GalleryID&show_comments=true&id=$id\"><span class=\"cg_image_action_span\">Comments (<b>$CountC</b>)</span></a>"; }
        else{ echo ""; }

        if($countSelectSQL>1){
            echo "<br><br><span class='cg_image_action_href cg_go_to_save_button'><span class='cg_image_action_span'>Go save</span></span>";
        }

        // Überprüfe ob schon aktiviert ist oder nicht --- ENDE

        // Check if user should be informed or is informed

        $Informed = $value->Informed;
        if($Informed==1){echo "<br><br><b>Informed about activated image</b>";}
        //echo "<br>Inform: $Inform<br>";
        //echo "<br>Activate: $Activate<br>";

        if($emailStatus==true){
            echo "<br><br>E-Mail Status: <strong>$emailStatusText</strong>";
        }


        if($Active == 1){
            echo "<br><br><br><br><div class='cg_status_activated'><div>ACTIVE</div></div>";
        }
        else{
            echo "<br><br><br><br><div class='cg_status_deactivated'><div>INACTIVE</div></div>";
        }



        //echo "<br>Informed: $Informed<br>";
        //if($Informed==1){  echo "klappt";}



        echo "</div>";

        if(@$countC>0){
            echo "<div >";
            echo '<a href="?page=contest-gallery/index.php&pictureID=' . $id . '">Comments</a><br/>';
            echo "</div>";
        }
        echo "</div>";
        echo "</li>";


    }

    echo "</ul>";

    echo "<div id='cgGallerySubmit'>";
    echo "<select name='chooseAction1' id='chooseAction1'>";

    echo "<option value='1' >Activate Image(s)/Save Data &nbsp;</option>";
    echo "<option value='2' >Deactivate Image(s)/Save Data &nbsp;</option>";
    echo "<option value='3' >Delete Image(s)/Data</option>";

    /*
    if($selectSQL){
    echo "<option value='4'>Zip selected</option>";
    }*/

    if($checkInformed){
        echo "<option value='4'>Reset informed/Save Data &nbsp;</option>";
    }

    echo "</select>";

    echo '&nbsp;&nbsp; <input type="submit" class="cg_backend_button_gallery_action" name="submit" value="Save" id="cg_gallery_backend_submit" >';


    echo "</div>";


    if($isAjaxCall){

        echo "<div id='cgStepsNavigationBottom' class='cg_steps_navigation' style='margin-top:2px;'>";
        for ($i = 0; $rows > $i; $i = $i + $step) {

            $anf = $i + 1;
            $end = $i + $step;

            if ($end > $rows) {
                $end = $rows;
            }

            if ($anf == $nr1 AND ($start+$step) > $rows AND $start==0) {
                continue;
                echo "<div data-cg-start='$i' class='cg_step cg_step_selected'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&edit_gallery=true\">$anf-$end</a></div>";
            }

            elseif ($anf == $nr1 AND ($start+$step) > $rows AND $anf==$end) {

                echo "<div data-cg-start='$i' class='cg_step cg_step_selected'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&edit_gallery=true\">$end</a></div>";
            }


            elseif ($anf == $nr1 AND ($start+$step) > $rows) {

                echo "<div data-cg-start='$i' class='cg_step cg_step_selected'><a href=\?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&edit_gallery=true\">$anf-$end</a></div>";
            }

            elseif ($anf == $nr1) {
                echo "<div data-cg-start='$i' class='cg_step cg_step_selected'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&edit_gallery=true\">$anf-$end</a></div>";
            }

            elseif ($anf == $end) {
                echo "<div data-cg-start='$i' class='cg_step'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&edit_gallery=true\">$end</a></div>";
            }

            else {
                echo "<div data-cg-start='$i' class='cg_step'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&edit_gallery=true\">$anf-$end</a></div>";
            }
        }
        echo "</div>";

        echo "<br>";

    }
    echo "<br>";

}

echo '</form>';
echo '</div>';


?>