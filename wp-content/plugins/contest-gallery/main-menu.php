<?php
if(!defined('ABSPATH')){exit;}

$siteURL = get_site_url()."/wp-admin/admin.php";

$uploadFolder = wp_upload_dir();
if(file_exists($uploadFolder['basedir'] . '/contest-gallery/cg-copying-gallery.txt')){
    unlink($uploadFolder['basedir'] . '/contest-gallery/cg-copying-gallery.txt');
};

$permalinkURL = get_site_url()."/wp-admin/admin.php";

//echo "$permalinkURL 2323242";

global $wpdb;

$tablename = $wpdb->prefix . "contest_gal1ery";
$tablename_options = $wpdb->prefix . "contest_gal1ery_options";

$selectSQL = $wpdb->get_results( "SELECT * FROM $tablename_options ORDER BY id ASC" );
/*	$selectSQL = $wpdb->get_results(
	        "
SELECT $tablename_options.*,(SELECT COUNT(*) FROM $tablename.*) as total FROM $tablename_options, $tablename WHERE $tablename_options.id = $tablename.GalleryID ORDER BY id DESC LIMIT 20
"
    );  */

$imagesTotal = $wpdb->get_results(
    "SELECT GalleryID,COUNT(*) as count FROM $tablename GROUP BY GalleryID ORDER BY count DESC;"
);

$imagesActive = $wpdb->get_results(
    "SELECT GalleryID,COUNT(*) as count FROM $tablename WHERE Active = 1 GROUP BY GalleryID ORDER BY count DESC;"
);

$imagesActiveAndTotalSortedByGallery = array();

foreach ($imagesTotal as $image){

    if(empty($imagesActiveAndTotalSortedByGallery[$image->GalleryID])){
        $imagesActiveAndTotalSortedByGallery[$image->GalleryID] = array();
    }
    $imagesActiveAndTotalSortedByGallery[$image->GalleryID]['total'] = $image->count;

}

foreach ($imagesActive as $image){

    if(empty($imagesActiveAndTotalSortedByGallery[$image->GalleryID])){
        $imagesActiveAndTotalSortedByGallery[$image->GalleryID] = array();
    }
    $imagesActiveAndTotalSortedByGallery[$image->GalleryID]['active'] = $image->count;

}

$arrayNew = array(
    '824f6b8e4d606614588aa97eb8860b7e',
    'add4012c56f21126ba5a58c9d3cffcd7',
    'bfc5247f508f427b8099d17281ecd0f6',
    'a29de784fb7699c11bf21e901be66f4e',
    'e5a8cb2f536861778aaa2f5064579e29',
    '36d317c7fef770852b4ccf420855b07b'
);

if(isset($_POST['cgKey'])){

    $newKey = trim($_POST["cgKey"]);
    $newKeyMd5 = md5($newKey);

    // Verarbeitung alter Key!!!
    if(strpos(floatval($newKey)/44,".") == false
        && strpos($newKey,"pro") == false
        && floatval($newKey)!=0
        && floatval($newKey)>=986798789
    ){

        if(get_option( "p_cgal1ery_reg_code" )){
            update_option( "p_cgal1ery_reg_code", $_POST['cgKey'] );
        }
        else{
            delete_option( "p_cgal1ery_reg_code" );
            add_option( "p_cgal1ery_reg_code", $_POST['cgKey'] );
        }


    }
    // Ganz wichtig! Prüfen ob pro im key mitgeschickt wird. Wenn nicht dann endet die Condition. Wenn ja geht der Verarbeitungstest weiter
    else if(in_array($newKeyMd5, $arrayNew)){

        if(get_option( "p_c1_k_g_r_9" )){
            update_option( "p_c1_k_g_r_9", $_POST['cgKey'] );
        }
        else{

            delete_option( "p_c1_k_g_r_9" );
            add_option("p_c1_k_g_r_9", $newKey );


        }

    }
    else{
        echo "<p id='cg_changes_saved' style='font-size:18px;color: black;'><strong>Wrong Key</strong></p>";
    }


}

$cgPro = false;
$cgProStyle = '';
// Check start von hier:
$p_cgal1ery_reg_code = get_option("p_cgal1ery_reg_code");
$p_c1_k_g_r_8 = get_option("p_c1_k_g_r_9");
$p_c1_k_g_r_8 = md5($p_c1_k_g_r_8);
if((strpos(floatval($p_cgal1ery_reg_code)/44,".") == false
        && floatval($p_cgal1ery_reg_code)!=0
        && floatval($p_cgal1ery_reg_code)>=986798739)
    or in_array($p_c1_k_g_r_8, $arrayNew)
){
    $cgPro = true;
    $cgProStyle = 'width: 169px;';
}


echo '<div class="main-table" id="mainTable">';

echo "<div id='cgDocumentation'>";
echo "<a href='https://www.contest-gallery.com/documentation/' target='_blank'><span>";
echo "Contest Gallery documentation";
echo "</span></a>";
echo "</div>";
echo "<table style='border: thin solid black;background-color:#ffffff;' width='937px'>";
echo "<tr>";
$cgLink = '';
if($cgPro){
    $cgPro = '<br><a href="https://www.contest-gallery.com" target="_blank">www.contest-gallery.com</a>';
}
echo "<td style='padding:5px 0 5px 20px;overflow:hidden;$cgProStyle'><p style='display:inline;font-size: 13px;font-weight: bold;'>Contest Gallery$cgPro</p></td>";


if($cgPro){
    echo "<td style='padding-left:23px;overflow:hidden;'><p style='display:inline;font-size: 13px;font-weight: bold;'>You are using PRO version. For any issues on PRO version please contact <a href='mailto:support-pro@contest-gallery.com' target='_blank'>support-pro@contest-gallery.com</a></p></td>";
}
else{
    echo "<td style='padding-left:80px;overflow:hidden;text-align: right; padding-right: 33px;'><p style='display:inline;font-size: 13px;font-weight: bold;'>PRO Version Key: </p><form action='?page=contest-gallery/index.php' method='POST' style='display:inline;'  class='cg_load_backend_submit'>";
    echo "<input type='text' name='cgKey' id='cgKey' value='' /><input type='submit' value='Enter' id='cgSubmitProKey' class='cg_backend_button_gallery_action' /></form></td>";
}
echo "</tr>";
echo "</table>";
echo "<br/>";

if (!empty($_GET['option_id']) AND !empty($_POST['cg_delete_gallery'])) {

    echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Gallery deleted</strong></p>";

}

// Die nexte ID des Option Tables ermitteln
$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '$tablename_options'");
$nextID = $last->Auto_increment;

$unix = time();

foreach($selectSQL as $value){

    $option_id = $value -> id;
    $GalleryName = $value -> GalleryName;
    $ContestEnd = $value->ContestEnd;
    $ContestEndTime = $value->ContestEndTime;
    $Version = $value->Version;
    $FbLike = $value->FbLike;

    if ($option_id % 2 != 0) {
        $backgroundColor = "#DFDFDF";
    } else {
        $backgroundColor = "#ECECEC";
    }

    echo "<table class='table_gallery_info'>";

    $phpDateOffset = date('Z');
    echo "<input type='hidden' id='cgPhpDateOffset' value='$phpDateOffset'>";

    echo "<tr style='background-color:#ffffff;'>";

    echo "<td style='padding-left:15px;width:55px;' ><p>ID: $option_id</p></td>";

    if($GalleryName){$GalleryName="<div><strong>$GalleryName</strong></div>";}
    else {$GalleryName="";}

    echo "<td align='center' class='td_gallery_info'>$GalleryName";
    echo "<div class='cg_shortcode_parent tg_gallery_info_shortcode'>Shortcode: <span class='cg_main_menu_shortcode cg_shortcode_copy_text'>[cg_gallery id=\"".$option_id."\"]</span><div class=\"cg_shortcode_copy cg_shortcode_copy_gallery cg_tooltip\"></div></div>";

    $imagesTotal = 0;
    $imagesActive = 0;

    if(!empty($imagesActiveAndTotalSortedByGallery[$option_id])){
        $imagesTotal = $imagesActiveAndTotalSortedByGallery[$option_id]['total'];
        if(!empty($imagesActiveAndTotalSortedByGallery[$option_id]['active'])){
            $imagesActive = $imagesActiveAndTotalSortedByGallery[$option_id]['active'];
        }
    }

    echo "<div>Total images: <span class='cg_main_menu_shortcode'>".$imagesTotal."</span></div>";
    echo "<div>Activated images: <span class='cg_main_menu_shortcode'>".$imagesActive."</span></div>";

    if((($unix > $ContestEndTime && $ContestEnd == 1) or $ContestEnd == 2) && $Version<10){
        echo "<div><i>contest ended</i></div>";
    }

    if((($unix>=$ContestEndTime && $ContestEnd==1) OR $ContestEnd==2) && $Version>=10){
        echo "<div id='cgContestEnded$option_id' class='cg-contest-ended'>";
        echo "<input type='hidden' class='cg-contest-end-time' value='$ContestEndTime'>";
        echo "<i>contest ended</i>";
        echo "</div>";
    }

    echo "</td>";


    // EDIT GALLERY

    echo '<td align="center" class="cg_button_edit"><p><a href="?page=contest-gallery/index.php&option_id='.$option_id.'
			&edit_gallery=true" class="cg_load_backend_link" ><input class=\'cg_backend_button\' name="" value="Edit" type="button" ></a></p></td>';


    // COPY GALLERY

    // NO cg_load_backend_submit class here for form!!!!
    echo '<td align="center" class="cg_button_copy"><p><form action="?page=contest-gallery/index.php&edit_gallery=true" method="POST" class="cg_load_backend_copy_gallery" >';
    echo '<input type="hidden" name="cg_copy" value="true" >';
    echo '<input type="hidden" name="cg_copy_id" value="'.$option_id.'" >';
    echo '<input type="hidden" name="cg_copy_start" class="cg_copy_start" value="0" >';
    echo '<input type="hidden" name="option_id_next_gallery" class="option_id_next_gallery" value="0" >';
    echo '<input type="hidden" name="id_to_copy" value="'.$option_id.'" >';
    echo '<input type="hidden" name="edit_gallery_hidden_post" >';
    echo '<input type="hidden" name="copy_v7" value="true" >';

    if($Version<7){
        $cgCheckCopy = 'cgCheckCopyPrevV7';
        $cg_copy_submit = 'cg_backend_button cg_copy_submit';
    }else{
        $cgCheckCopy = 'cgCheckCopy';
        $cg_copy_submit = 'cg_backend_button cg_copy_submit';
    }

    $prevV7text = '';

    if($Version<7){
        $prevV7text = '<div class="cg-copy-prev-7-text cg_hide"><br><a href="https://www.contest-gallery.com/copy-galleries-created-before-version-7-with-images-new/" target="_blank">Copying galleries created before version 7 might need some server configuration</a><br><br></div>';
    }

    echo $prevV7text;

    echo '<input type="hidden" name="page" value="contest-gallery/index.php"><input name="" value="Copy" type="Submit" id="cgCopySubmit'.$option_id.'" class="'.$cg_copy_submit.'" data-cg-version-to-copy="'.$Version.'"
    data-cg-copy-fb-on="'.$FbLike.'" data-cg-copy-id="'.$option_id.'"></form></p></td>';

    // DELETE GALLERY

    echo '<td align="center" class="cg_button_delete"><p><form action="?page=contest-gallery/index.php" method="GET"  class="cg_load_backend_submit" >
            <input type="hidden" name="option_id" value="'.$option_id.'">';
    echo '<input  type="hidden" name="cg_delete_gallery" value="true"><input class=\'cg_backend_button\' type="button" value="Delete" onClick="return cgJsClassAdmin.mainMenu.functions.cgCheckDelete('.$option_id.','.$Version.',this)"></form></p></td>';
    //echo '<td style="padding-left:100px;padding-right:20px;"><p><form action="?page=contest-gallery/index.php&option_id=' . $option_id . '&delete=true" method="GET" ><input value="L&ouml;schen" type="Submit"></form></p></td>';

    echo "</tr>";

    echo "</table>";

    @$option_id++;
}



echo "<br/>";


echo "<table style='border: thin solid black;background-color:#ffffff;' width='937px'>";
echo '<tr><td style="padding-left:20px;overflow:hidden;" colspan="4"><p><form action="?page=contest-gallery/index.php&option_id='.$nextID.'&edit_gallery=true" method="POST" class="cg_load_backend_submit cg_load_backend_create_gallery" >';
echo '<input type="hidden" name="cg_create" value="true">';
echo '<input type="hidden" name="option_id" value="'.$nextID.'">';
echo '<input type="hidden" name="create" value="true"><input type="hidden" name="page" value="contest-gallery/index.php">
    <input class=\'cg_backend_button cg_button_new_gallery\' name="" value="New gallery" type="Submit"></form></p></td></tr>';
//echo '<tr><td style="padding-left:20px;overflow:hidden;" colspan="4"><p><a href="?page=contest-gallery/index.php&option_id=' . $option_id . '&create=true" class="classname">Neue Galerie</a></p></td></tr>';
//echo '<tr><td style="padding-left:20px;overflow:hidden;" colspan="4"><p><a href="?page=contest-gallery/index.php&option_id=' . $option_id . '&create=true" class="classname">Neue Galerie</a></p></td></tr>';

echo "</table>";

echo '</div>';

echo "<div id='cgCopyMessageContainer' class='cg_hide'>";

echo "<div id='cgCopyMessageDiv'>";

echo "<div id='cgCopyMessageClose'>";


echo "</div>";



echo "<div id='cgCopyMessageContent'>";

echo "<p id='cgCopyMessageContentHeader'>";
echo "Copy Gallery ID 88 ?";
echo "</p>";
echo "<p class='cg_copy_type_options_container'>";
echo "<input type='radio' class='cg_copy_type' id='cg_copy_type_options' name='cg_copy_type' checked value='cg_copy_type_options' />";
echo "<label for='cg_copy_type_options'>Copy options and forms only</label>";
echo "</p>";
echo "<p class='cg_copy_type_options_and_images_container'>";
echo "<input type='radio' class='cg_copy_type' id='cg_copy_type_options_and_images' name='cg_copy_type' value='cg_copy_type_options_and_images' />";
echo "<label for='cg_copy_type_options_and_images'>Copy images, options and forms</label>";
echo "</p>";
echo "<p class='cg_copy_type_all_container'>";
echo "<input type='radio' class='cg_copy_type' id='cg_copy_type_all' name='cg_copy_type' value='cg_copy_type_all' />";
echo "<label for='cg_copy_type_all' class='cg_copy_type_all_label'>Copy everything (options, forms, images, votes and comments)<span id='cg_copy_type_all_fb_hint' class='cg_hide'><br><strong> Facebook likes and shares will be not copied</strong></span></label>";
echo "</p>";
echo "<p  id=\"cgCopyMessageSubmitContainer\" >";
echo '<input class=\'cg_backend_button cg_backend_button_gallery_action\' value="Copy" type="button" id="cgCopyMessageSubmit" data-cg-copy-id="" style="text-align:center;width:70px;background:linear-gradient(0deg, #f1f1f1 50%, #f1f1f1 50%);">';
echo "</p>";


echo "</div>";


echo "</div>";
echo "</div>";

echo "<div id='cgCopyInProgressOnSubmit' class='cg_hide'>";
echo "<h2>In progress ...</h2>";
echo "<p><strong>Do not cancel</strong></p>";
echo "</div>";

?>