<?php
if(!defined('ABSPATH')){exit;}

global $wpdb;

$tablename = $wpdb->prefix . "contest_gal1ery";
$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
$tablenameComments = $wpdb->prefix . "contest_gal1ery_comments";
$tablename_f_input = $wpdb->prefix . "contest_gal1ery_f_input";
$tablename_f_output = $wpdb->prefix . "contest_gal1ery_f_output";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
$tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
$tablenameEntries = $wpdb->prefix . "contest_gal1ery_entries";
$tablenameIP = $wpdb->prefix ."contest_gal1ery_ip";
$table_posts = $wpdb->prefix ."posts";
$tablename_categories = $wpdb->prefix . "contest_gal1ery_categories";

$galeryIDuser = $galeryID;
$isUserGallery = false;
if(!empty($onlyLoggedInUserImages)){
    $galeryIDuser = $galeryID.'-u';
    $isUserGallery = true;
}
if(!empty($isOnlyGalleryNoVoting)){
    $isOnlyGalleryNoVoting = true;
    $galeryIDuser = $galeryID.'-nv';
}else{
    $isOnlyGalleryNoVoting = false;
}

$WpUserId = '';

if(is_user_logged_in()){
    $WpUserId = get_current_user_id();
}


//var_dump(md5(wp_salt( 'auth').'---cngl1---'.$galeryIDuser));

$wp_upload_dir = wp_upload_dir();
$jsonImagesFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-images.json';
$fp = fopen($jsonImagesFile, 'r');
$jsonImages = json_decode(fread($fp,filesize($jsonImagesFile)),true);
fclose($fp);

$is_user_logged_in = is_user_logged_in();
$isShowGallery = true;

if($options['pro']['RegUserGalleryOnly']==1 && $is_user_logged_in == false){
    $isShowGallery = false;
}

if($isShowGallery == true){

    // check if sort values files exists
    if(!file_exists($wp_upload_dir['basedir'] . "/contest-gallery/gallery-id-".$galeryID."/json/".$galeryID."-images-sort-values.json")){
        cg_actualize_all_images_data_sort_values_file($galeryID,true);
    }else{
        cg_actualize_all_images_data_sort_values_file($galeryID);
    }
    // check if sort values files exists --- ENDE

    // check if image-info-values-file-exists
    if(!file_exists($wp_upload_dir['basedir'] . "/contest-gallery/gallery-id-".$galeryID."/json/".$galeryID."-images-info-values.json")){
        cg_actualize_all_images_data_info_file($galeryID);
    }
    // check if image-info-values-file-exists

    $jsonImagesCount = count($jsonImages);

    $jsonGalleryTstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-gallery-tstamp.json';

    if(!file_exists($jsonGalleryTstampFile)){
        $fp = fopen($jsonGalleryTstampFile, 'w');
        fwrite($fp,json_encode(time()));
        fclose($fp);
    }

    $userIP = cg_get_user_ip();

    if($is_user_logged_in){
        $wpUserId = get_current_user_id();
    }
    else{
        $wpUserId=0;
    }

    $wp_create_nonce = wp_create_nonce("check");

    $LooksCount = 0;
    if($options['general']['ThumbLook'] == 1){$LooksCount++;}
    if($options['general']['HeightLook'] == 1){$LooksCount++;}
    if($options['general']['RowLook'] == 1){$LooksCount++;}

    if(empty($options['pro']['SlideTransition'])){
        $options['pro']['SlideTransition']='translateX';
    }

    $ShowCatsUnchecked = 0;
    if(!empty($options['pro']['ShowCatsUnchecked'])){
        $ShowCatsUnchecked = 1;
    }

    $check = wp_create_nonce("check");
    $p_cgal1ery_db_version = get_option( "p_cgal1ery_db_version" );
    $upload_folder = wp_upload_dir();
    $upload_folder_url = $upload_folder['baseurl']; // Pfad zum Bilderordner angeben

    $wpNickname = '';

    if($is_user_logged_in){$current_user = wp_get_current_user();$wpNickname = $current_user->display_name;}

    if(is_ssl()){
        if(strpos($upload_folder_url,'http://')===0){
            $upload_folder_url = str_replace( 'http://', 'https://', $upload_folder_url );
        }
    }
    else{
        if(strpos($upload_folder_url,'https://')===0){
            $upload_folder_url = str_replace( 'https://', 'http://', $upload_folder_url );
        }
    }


    if($options['general']['CheckLogin']==1 and ($options['general']['AllowRating']==1 or $options['general']['AllowRating']==2)){
        if($is_user_logged_in){$UserLoginCheck = 1;$current_user = wp_get_current_user();$wpNickname = $current_user->display_name;} // Allow only registered users to vote (Wordpress profile) wird dadurch aktiviert
        else{$UserLoginCheck=0;}//Allow only registered users to vote (Wordpress profile): wird dadurch deaktiviert
    }
    else{$UserLoginCheck=0;}

    include('data/variables-javascript.php');
    $galeryID = $galeryID;
    include(__DIR__ ."/../../check-language.php");
    include('data/check-language-javascript.php');

    if(empty($options['general']['CheckIp']) && empty($options['general']['CheckLogin']) && empty($options['general']['CheckCookie'])){
        $options['general']['CheckIp']=1;
    }

    if($options['general']['AllowRating']==1) {
        if(empty($isOnlyGalleryNoVoting)){
            include ('data/rating/configuration-five-star.php');
        }
    }

    if($options['general']['AllowRating']==2) {
        if(empty($isOnlyGalleryNoVoting)){
            include('data/rating/configuration-one-star.php');
        }
    }

    if(!empty($onlyLoggedInUserImages)) {

        include('data/user-image-ids.php');

    }

    $cgFeControlsStyle = 'cg_fe_controls_style_white';
    $cgFeControlsStyleHideBlackSites ='';
    $cgFeControlsStyleHideWhiteSites ='cg_hide';

    if(!empty($options['visual']['FeControlsStyle'])){
        if($options['visual']['FeControlsStyle']=='black'){
            $cgFeControlsStyle='cg_fe_controls_style_black';
            $cgFeControlsStyleHideBlackSites ='cg_hide';
            $cgFeControlsStyleHideWhiteSites ='';
        }
    }


    echo "<div id='mainCGdivContainer$galeryIDuser' class='mainCGdivContainer' data-cg-gid='$galeryIDuser'>";
    echo "<div id='mainCGdivHelperParent$galeryIDuser' class='mainCGdivHelperParent $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";
    echo "<div id='cgLdsDualRingDivGalleryHide$galeryIDuser' class='cg-lds-dual-ring-div-gallery-hide cg-lds-dual-ring-div-gallery-hide-parent cg_hide $cgFeControlsStyle'><div class='cg-lds-dual-ring-gallery-hide $cgFeControlsStyle'></div></div>";
    echo "<div id='mainCGdiv$galeryIDuser' class='mainCGdiv cg_hide' style='display:none;' data-cg-gid='$galeryIDuser'>";


    if(is_user_logged_in()){
        if(current_user_can('manage_options')){

            $galleryJsonCommentsDir = $wp_upload_dir['basedir'].'/contest-gallery/changes-messages-frontend';

            if (!is_dir($galleryJsonCommentsDir)) {
                mkdir($galleryJsonCommentsDir, 0755, true);
            }

            // general recognized file
            if(!file_exists($galleryJsonCommentsDir.'/cg-change-top-controls-style-option-recognized.txt')){
                if(!file_exists($wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/cg-change-top-controls-style-option-recognized.txt')){
                    echo "<div id='cgChangeTopControlsStyleOption$galeryIDuser' class='cgChangeTopControlsStyleOption $cgFeControlsStyle' data-cg-gid='$galeryIDuser' >";
                    echo "<input type='hidden' class='cgChangeTopControlsStyleOptionStartingStyle' value='$cgFeControlsStyle' />";
                    echo "<div class='cgChangeTopControlsStyleOptionClose' data-cg-gid='$galeryIDuser'></div>";
                    echo "<div class='cgChangeTopControlsStyleOptionMessage' data-cg-gid='$galeryIDuser'>";
                    echo "<div class='cgChangeTopControlsStyleText' ><strong>Only visible for administrators</strong></div>";
                    echo "<div class='cgChangeTopControlsStyleText'>You can now switch between top controls styles</div>";
                    echo "<div class='cgChangeTopControlsStyleText'>Switch option can be found in \"Multiple pics options\"</div>";
                    echo "<div class='cgChangeTopControlsStyleOptionTest cgChangeTopControlsStyleOptionTestBlackSites $cgFeControlsStyleHideBlackSites' data-cg-gid='$galeryIDuser'>Test black sites style</div>";
                    echo "<div class='cgChangeTopControlsStyleOptionTest cgChangeTopControlsStyleOptionTestWhiteSites $cgFeControlsStyleHideWhiteSites' data-cg-gid='$galeryIDuser'>Test white sites style</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }

        }
    }

    echo "<div id='mainCGdivHelperChild$galeryIDuser' class='mainCGdivHelperChild' data-cg-gid='$galeryIDuser'>";

    echo "<div id='mainCGdivFullWindowConfigurationArea$galeryIDuser' class='mainCGdivFullWindowConfigurationArea cg-header-controls-show-only-full-window cg_hide $cgFeControlsStyle' data-cg-gid='$galeryIDuser'></div>";

    echo "<span id='cgViewHelper$galeryIDuser' class='cg_view_helper'></span>";

    echo "<input type='hidden' id='cg_language_i_am_not_a_robot' value='$language_IamNotArobot' >";

    echo "<input type='hidden' id='cg_all_images_loaded' value='0'/>";
    echo "<input type='hidden' id='cg_gallery_resize' value='0'/>";
    echo "<input type='hidden' id='cg_pagination_position_count' value='0'/>";
    echo "<input type='hidden' id='cg_widthMainCGallery' value='0'/>"; // Wenn pagination an ist, dann muss der erste Width Wert hier eingetragen werden
    echo "<input type='hidden' class='aggregateWidth' value='0'>";// Hidden Feld zum sammeln und abrufen von aggregateWidth �ber Jquery, wird gebrauht f�r Thumb Look


    echo "<div id='cg_ThePhotoContestIsOver_dialog' style='display:none;' class='cg_show_dialog'><p>$language_ThePhotoContestIsOver</p></div>";
    echo "<div id='cg_AlreadyRated_dialog' style='display:none;' class='cg_show_dialog'><p>$language_YouHaveAlreadyVotedThisPicture</p></div>";
    echo "<div id='cg_AllVotesUsed_dialog' style='display:none;' class='cg_show_dialog'><p>$language_AllVotesUsed</p></div>";

    //include('gallery/comment-div.php');
    //include('gallery/slider-div.php');

    echo "<div class='cg_header'>";

    include('gallery/header.php');

    echo "</div>";
    echo "</div>";// Closing mainCGdivHelperChild

    include('gallery/further-images-steps-container.php');

    echo '<div class="cg-lds-dual-ring-div '.$cgFeControlsStyle.' cg_hide"><div class="cg-lds-dual-ring"></div></div>';
    echo "<div id='cgLdsDualRingMainCGdivHide$galeryIDuser' class='cg-lds-dual-ring-div-gallery-hide cg-lds-dual-ring-div-gallery-hide-mainCGallery $cgFeControlsStyle cg_hide'><div class='cg-lds-dual-ring-gallery-hide $cgFeControlsStyle cg-lds-dual-ring-gallery-hide-mainCGallery'></div></div>";

    include('gallery/cg-messages.php');

    echo "<div id='mainCGallery$galeryIDuser' data-cg-gid='$galeryIDuser' class='mainCGallery' >";
        echo "<div id='mainCGslider$galeryIDuser' data-cg-gid='$galeryIDuser' class='mainCGslider cg_hide cgCenterDivBackgroundColor' >";
        echo "</div>";
        include('gallery/inside-gallery-single-image-view.php');
        echo "<div id='cgLdsDualRingCGcenterDivHide$galeryIDuser' class='cg-lds-dual-ring-div-gallery-hide $cgFeControlsStyle cg-lds-dual-ring-div-gallery-hide-cgCenterDiv cg_hide'><div class='cg-lds-dual-ring-gallery-hide $cgFeControlsStyle cg-lds-dual-ring-gallery-hide-cgCenterDiv'></div></div>";
    echo "</div>";

    echo "</div>";
    echo "<div id='cgCenterDivAppearenceHelper$galeryIDuser' class='cgCenterDivAppearenceHelper'>
    </div>";
    echo "</div>";


    echo "<noscript>";

    echo "<div id='mainCGdivNoScriptContainer$galeryIDuser' class='mainCGdivNoScriptContainer' data-cg-gid='$galeryIDuser'>";

    if(file_exists($upload_folder["basedir"].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-noscript.html')){
        include($upload_folder["basedir"].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-noscript.html');
    }

    echo "</div>";

    echo "</noscript>";


    echo "</div>";

//include('gallery/further-images-steps-container.html');

}else{

    echo "<div id='cgRegUserGalleryOnly$galeryIDuser' class='cgRegUserGalleryOnly' data-cg-gid='$galeryIDuser'>";

        echo contest_gal1ery_convert_for_html_output($options['pro']['RegUserGalleryOnlyText']);

    echo "</div>";

}



?>