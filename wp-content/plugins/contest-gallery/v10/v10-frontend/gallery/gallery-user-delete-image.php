<?php
if(!defined('ABSPATH')){exit;}

$galeryID = intval(sanitize_text_field($_REQUEST['gid']));
$pictureID = intval(sanitize_text_field($_REQUEST['pid']));
$userId = intval(sanitize_text_field($_REQUEST['uid']));
$galeryIDuser = sanitize_text_field($_REQUEST['galeryIDuser']);
$galleryHash = sanitize_text_field($_REQUEST['galleryHash']);
$galleryHashDecoded = wp_salt( 'auth').'---cngl1---'.$galeryIDuser;
$galleryHashToCompare = md5($galleryHashDecoded);

if (!is_numeric($pictureID) or !is_numeric($galeryID) or !is_numeric($userId) or ($galleryHash != $galleryHashToCompare)){
    ?>
    <script data-cg-processing="true">

        var message = <?php echo json_encode('Please do not manipulate!');?>;
        cgJsClass.gallery.function.message.show(message);

    </script>
    <?php

    return;
}
else {

    $tablename = $wpdb->prefix ."contest_gal1ery";

    $isUserImage = $wpdb->get_var( $wpdb->prepare(
        "
        SELECT COUNT(*) AS UserImages
        FROM $tablename 
        WHERE id = %d and GalleryID = %d and WpUserId = %d
    ",
        $pictureID,$galeryID,$userId
    ) );

    if(empty($isUserImage)){

        ?>
        <script data-cg-processing="true">

            var message = <?php echo json_encode('Please do not manipulate!');?>;
            cgJsClass.gallery.function.message.show(message);

        </script>
        <?php

        return;

    }else{

        $valuesToDeleteArray = array($pictureID);
        cg_delete_images($galeryID,$valuesToDeleteArray);

        ?>
        <script data-cg-processing="true">
            //  alert(1);
            var gid = <?php echo json_encode($galeryIDuser);?>;
            var realIdToDelete = <?php echo json_encode($pictureID);?>;

            cgJsClass.gallery.getJson.removeImageFromImageData(gid,realIdToDelete,true);

            cgJsClass.gallery.views.close(gid,true);

            var message = <?php echo json_encode('Image successfully deleted');?>;
            cgJsClass.gallery.function.message.show(message);

        </script>
        <?php

    }

}

?>



