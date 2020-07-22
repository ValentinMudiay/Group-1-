<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
<?php

// Path to jquery Lightbox Script 

global $wpdb;

if(isset($_GET['option_id'])){
    $GalleryID = $_GET['option_id'];
}else if(isset($_POST['option_id'])){
    $GalleryID = $_POST['option_id'];
}

$tablename = $wpdb->prefix . "contest_gal1ery";
$tablename_ip = $wpdb->prefix . "contest_gal1ery_ip";
$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
$tablename_options_input = $wpdb->prefix . "contest_gal1ery_options_input";
$tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
$tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";
$tablename_email_admin = $wpdb->prefix . "contest_gal1ery_mail_admin";
$tablenameemail = $wpdb->prefix . "contest_gal1ery_mail";
$tablename_options = $wpdb->prefix . "contest_gal1ery_options";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
//$tablename_mail_gallery = $wpdb->prefix . "contest_gal1ery_mail_gallery";
$tablename_mail_confirmation = $wpdb->prefix . "contest_gal1ery_mail_confirmation";
$table_posts = $wpdb->prefix."posts";
$table_users = $wpdb->prefix."users";

require_once(dirname(__FILE__) . "/../nav-menu.php");

$upload_dir = wp_upload_dir();
$uploadFolder = wp_upload_dir();


//$options = $wpdb->get_results( "SELECT * FROM $tablename WHERE GalleryID = '$GalleryID'" );
$proOptions = $wpdb->get_row( "SELECT * FROM $tablename_pro_options WHERE GalleryID = '$GalleryID'" );
$options = $wpdb->get_row( "SELECT * FROM $tablename_options WHERE id = '$GalleryID'" );

// Correct 1 from HERE

$correctStatusText1 = 'Correct';
$correctStatusClass1 = '';

$thumbSizesWp = array();
$thumbSizesWp['thumbnail_size_w'] = get_option("thumbnail_size_w");
$thumbSizesWp['medium_size_w'] = get_option("medium_size_w");
$thumbSizesWp['large_size_w'] = get_option("large_size_w");

if(isset($_POST['action_correct_deleted_for_frontend'])){

    $selectSQL = $wpdb->get_results( "SELECT id FROM $tablename WHERE GalleryID = '$GalleryID' AND Active = '1'" );

    if(!empty($selectSQL)){

        $idsArray = array();

        foreach ($selectSQL as $rowObject){

            $idsArray[] = $rowObject->id;

        }

        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images.json";
        $fp = fopen($jsonFile, 'r');
        $imageArray = json_decode(fread($fp, filesize($jsonFile)),true);
        fclose($fp);

        foreach ($imageArray as $imageId => $imageDataArray){

            if(!in_array($imageId,$idsArray)){

                if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageDataArray['Timestamp']."_".$imageDataArray['NamePic']."413.html")){
                    @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageDataArray['Timestamp']."_".$imageDataArray['NamePic']."413.html");
                }

                if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$imageId.".json")){
                    @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$imageId.".json");
                }
                if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$imageId.".json")){
                    @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$imageId.".json");
                }
                if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$imageId.".json")){
                    @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$imageId.".json");
                }

                if(!empty($imageArray[$imageId])){
                    unset($imageArray[$imageId]);
                }

            }

        }

        // set image data, das ganze gesammelte
        $jsonFile = $upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images.json';
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($imageArray));
        fclose($fp);


        $tstampFile = $upload_dir["basedir"]."/contest-gallery/gallery-id-$GalleryID/json/$GalleryID-gallery-tstamp.json";

        $fp = fopen($tstampFile, 'w');
        fwrite($fp, time());
        fclose($fp);

        $correctStatusText1 = 'Corrected';
        $correctStatusClass1 = 'cg_corrected';

    }

}

$correctStatusText2 = 'Correct';
$correctStatusClass2 = '';

if(isset($_POST['action_correct_information_for_frontend'])){

    do_action('cg_json_upload_form_info_data_files',$GalleryID,null);
    $correctStatusText2 = 'Corrected';
    $correctStatusClass2 = 'cg_corrected';

}
$correctStatusText3 = 'Correct';
$correctStatusClass3 = '';

if(isset($_POST['action_correct_not_shown_for_frontend'])){

    $picsSQL = $wpdb->get_results( "SELECT $table_posts.*, $tablename.* FROM $table_posts, $tablename WHERE $tablename.GalleryID='$GalleryID' AND $tablename.Active='1' and $table_posts.ID = $tablename.WpUpload ORDER BY $tablename.id DESC");
    $imageArray = array();



    // add all json files and generate images array
    foreach($picsSQL as $object){

        $imageArray = cg_create_json_files_when_activating($GalleryID,$object,$thumbSizesWp,$upload_dir,$imageArray,null);

    }

    cg_set_data_in_images_files_with_all_data($GalleryID,$imageArray);

    $correctStatusText3 = 'Corrected';
    $correctStatusClass3 = 'cg_corrected';

}//>>> SEEE DIV FOR IT HERE!!!!!
// $correctStatusText3 DIV FOR IT HERE
// $correctStatusClass3 DIV FOR IT HERE
/*    <div class="cg_corrections_container">
        <div class="cg_corrections_explanation">
            <div class="cg_corrections_title">Seeing not all images in frontend?</div>
            <div class="cg_corrections_description">If you missing images in frontend you can correct it here.</div>
        </div>
        <div class="cg_corrections_action $correctStatusClass3">
            <form method="POST" action="?page=contest-gallery/index.php&amp;corrections_and_improvements=true&amp;option_id=$GalleryID">
                <input type="hidden" name="action_correct_not_shown_for_frontend" value="true">
                <input type="hidden" name="option_id" value="$GalleryID">
                <span class="cg_corrections_action_submit">$correctStatusText3</span>
            </form>
        </div>
    </div>    */

// Correct 4 from HERE


$correctStatusText4 = 'Nothing to repair';
$correctStatusClass4 = '';
$correctStatusTextFull4 = 'All required columns available!';


try {
    if(isset($_POST['action_check_and_correct_database'])){
        $i="";

        // try all updates here!
        include(__DIR__."/../../../update/update-check-new.php");
        $isJustCheck = true;
        include(__DIR__."/../../../update/update-check-new.php");

        if(!empty($columnsToRepairArray['hasColumnsToImprove'])){

            // unset here so processing does not stop
            unset($columnsToRepairArray['hasColumnsToImprove']);

            $correctStatusTextFull4 = '<span class="cg_database_improve_title">Please contact <a href="mailto:support@contest-gallery.com">support@contest-gallery.com</a><br>Copy and send following data with MySQL version:</span>';

            if ( function_exists( 'mysqli_connect' ) ) {
                $server_info = mysqli_get_server_info( $wpdb->dbh );
            }else{
                $server_info = mysql_get_server_info( $wpdb->dbh );
            }

            $correctStatusTextFull4 .= '<span class="cg_database_improve_mysql_version">MySQL version '.$wpdb->db_version().' - '.$server_info.'</span>';

            foreach($columnsToRepairArray as $tableName => $tableData){
                $correctStatusTextFull4 .= "<span class=\"cg_database_improve_table_name\">Table: $tableName</span><br>";
                $correctStatusTextFull4 .= "<table><tbody>";
                $correctStatusTextFull4 .= "<tr><th>Column</th><th>Status</th></tr>";
                foreach($tableData as $columnData){
                    $statusText = '';
                    if(isset($columnData['IsNoColumn'])){
                        $statusText = $errorsArray[$columnData['ColumnName']];
                    }
                    if(isset($columnData['IsColumnCouldNotBeModified'])){
                        $statusText = $errorsArray[$columnData['ColumnName']];
                    }
                    $correctStatusTextFull4 .= "<tr><td>".$columnData['ColumnName']."</td><td>$statusText</td></tr>";
                }
                $correctStatusTextFull4 .= "</table></tbody>";
            }

            $correctStatusText4 = 'Repair';
            $correctStatusClass4 = '';

        }else{
            $correctStatusText4 = 'Repaired';
            $correctStatusClass4 = 'cg_corrected';
        }

    }else{
        $i="";

        $isJustCheck = true;
        include(__DIR__."/../../../update/update-check-new.php");

        if(!empty($columnsToRepairArray['hasColumnsToImprove'])){

            // unset here so processing does not stop
            unset($columnsToRepairArray['hasColumnsToImprove']);

            $correctStatusTextFull4 = '<span class="cg_database_improve_title">Table data needs to be repaired</span>';

            foreach($columnsToRepairArray as $tableName => $tableData){
                $correctStatusTextFull4 .= "<span class=\"cg_database_improve_table_name\">Table: $tableName</span><br>";
                $correctStatusTextFull4 .= "<table><tbody>";
                $correctStatusTextFull4 .= "<tr><th>Column</th><th>Status</th></tr>";
                foreach($tableData as $columnData){
                    $statusText = '';
                    if(isset($columnData['IsNoColumn'])){
                        $statusText = 'Not created';
                    }
                    if(isset($columnData['IsColumnCouldNotBeModified'])){
                        $statusText = 'Modify: from '.$columnData['ColumnTypeCurrent'].' to '.$columnData['ColumnTypeRequired'].'';
                    }
                    $correctStatusTextFull4 .= "<tr><td>".$columnData['ColumnName']."</td><td>$statusText</td></tr>";
                }
                $correctStatusTextFull4 .= "</table></tbody>";
            }

            $correctStatusText4 = 'Repair';
            $correctStatusClass4 = '';

        }else{

            $correctStatusText4 = 'Nothing to repair';
            $correctStatusClass4 = 'cg_corrected';

        }

    }

}catch (Exception $e) {
    $correctStatusTextFull4 = '<span class="cg_database_improve_title">Please contact <a href="mailto:support@contest-gallery.com">support@contest-gallery.com</a><br>Copy and send following data:</span>';
    $correctStatusTextFull4 .= '<span class="cg_database_error_message">'.$e->getMessage().'</span>';

    $correctStatusText4 = 'Repair';
    $correctStatusClass4 = '';
}

// Correct 5 from HERE
$correctStatusText5 = 'Correct';
$correctStatusClass5 = '';
$correctContent5 = '';

if($proOptions->IsModernFiveStar == 0 AND $options->AllowRating == 1){

    if(isset($_POST['action_correct_to_modern_five_star'])){

        $allRatingsPerPid = $wpdb->get_results( "SELECT pid, SUM(CASE 
             WHEN $tablename_ip.Rating = '1' THEN 1
             ELSE 0
           END) AS CountR1,
       SUM(CASE 
             WHEN $tablename_ip.Rating='2' THEN 1
             ELSE 0
           END) AS CountR2,
       SUM(CASE 
             WHEN $tablename_ip.Rating='3' THEN 1
             ELSE 0
           END) AS CountR3,
       SUM(CASE 
             WHEN $tablename_ip.Rating='4' THEN 1
             ELSE 0
           END) AS CountR4,
       SUM(CASE 
             WHEN $tablename_ip.Rating='5' THEN 1
             ELSE 0
           END) AS CountR5
            FROM $tablename_ip WHERE GalleryID = '$GalleryID' AND Rating > 0 GROUP BY pid ORDER BY pid DESC, rating DESC" );

        if(!empty($allRatingsPerPid)){

            $querySETrowCountR1 = 'UPDATE ' . $tablename . ' SET CountR1 = CASE';
            $querySETaddRowCountR1 = ' ELSE CountR1 END WHERE (id) IN (';

            $querySETrowCountR2 = 'UPDATE ' . $tablename . ' SET CountR2 = CASE';
            $querySETaddRowCountR2 = ' ELSE CountR1 END WHERE (id) IN (';

            $querySETrowCountR3 = 'UPDATE ' . $tablename . ' SET CountR3 = CASE';
            $querySETaddRowCountR3 = ' ELSE CountR1 END WHERE (id) IN (';

            $querySETrowCountR4 = 'UPDATE ' . $tablename . ' SET CountR4 = CASE';
            $querySETaddRowCountR4 = ' ELSE CountR1 END WHERE (id) IN (';

            $querySETrowCountR5 = 'UPDATE ' . $tablename . ' SET CountR5 = CASE';
            $querySETaddRowCountR5 = ' ELSE CountR1 END WHERE (id) IN (';

            $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json";
            $fp = fopen($jsonFile, 'r');
            $sortValuesArray = json_decode(fread($fp, filesize($jsonFile)),true);
            fclose($fp);

            foreach($allRatingsPerPid as $object){

                $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$object->pid.".json";

                // check only active!!!!
                if(file_exists($jsonFile)){
                    $fp = fopen($jsonFile, 'r');
                    $imageArray = json_decode(fread($fp, filesize($jsonFile)),true);
                    fclose($fp);

                    $imageArray['CountR1'] = intval($object->CountR1);
                    $sortValuesArray[$object->pid]['CountR1'] = intval($object->CountR1);
                    $querySETrowCountR1 .= " WHEN (id = $object->pid) THEN '".$object->CountR1."'";
                    $querySETaddRowCountR1 .= "($object->pid), ";

                    $imageArray['CountR2'] = intval($object->CountR2);
                    $sortValuesArray[$object->pid]['CountR2'] = intval($object->CountR2);
                    $querySETrowCountR2 .= " WHEN (id = $object->pid) THEN '".$object->CountR2."'";
                    $querySETaddRowCountR2 .= "($object->pid), ";

                    $imageArray['CountR3'] = intval($object->CountR3);
                    $sortValuesArray[$object->pid]['CountR3'] = intval($object->CountR3);
                    $querySETrowCountR3 .= " WHEN (id = $object->pid) THEN '".$object->CountR3."'";
                    $querySETaddRowCountR3 .= "($object->pid), ";

                    $imageArray['CountR4'] = intval($object->CountR4);
                    $sortValuesArray[$object->pid]['CountR4'] = intval($object->CountR4);
                    $querySETrowCountR4 .= " WHEN (id = $object->pid) THEN '".$object->CountR4."'";
                    $querySETaddRowCountR4 .= "($object->pid), ";

                    $imageArray['CountR5'] = intval($object->CountR5);
                    $sortValuesArray[$object->pid]['CountR5'] = intval($object->CountR5);
                    $querySETrowCountR5 .= " WHEN (id = $object->pid) THEN '".$object->CountR5."'";
                    $querySETaddRowCountR5 .= "($object->pid), ";

                    $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$object->pid.".json";
                    $fp = fopen($jsonFile, 'w');
                    fwrite($fp, json_encode($imageArray));
                    fclose($fp);
                }

            }

            // add 0 to all which had no rating
            foreach($sortValuesArray as $id => $sortValues){
                if(empty($sortValues['CountR1'])){$sortValuesArray[$id]['CountR1'] = 0;}
                if(empty($sortValues['CountR2'])){$sortValuesArray[$id]['CountR2'] = 0;}
                if(empty($sortValues['CountR3'])){$sortValuesArray[$id]['CountR3'] = 0;}
                if(empty($sortValues['CountR4'])){$sortValuesArray[$id]['CountR4'] = 0;}
                if(empty($sortValues['CountR5'])){$sortValuesArray[$id]['CountR5'] = 0;}
            }

            $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json";
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($sortValuesArray));
            fclose($fp);

            $querySETaddRowCountR1 = substr($querySETaddRowCountR1,0,-2);
            $querySETaddRowCountR1 .= ")";
            $querySETrowCountR1 .= $querySETaddRowCountR1;
            $wpdb->query($querySETrowCountR1);

            $querySETaddRowCountR2 = substr($querySETaddRowCountR2,0,-2);
            $querySETaddRowCountR2 .= ")";
            $querySETrowCountR2 .= $querySETaddRowCountR2;
            $wpdb->query($querySETrowCountR2);

            $querySETaddRowCountR3 = substr($querySETaddRowCountR3,0,-2);
            $querySETaddRowCountR3 .= ")";
            $querySETrowCountR3 .= $querySETaddRowCountR3;
            $wpdb->query($querySETrowCountR3);

            $querySETaddRowCountR4 = substr($querySETaddRowCountR4,0,-2);
            $querySETaddRowCountR4 .= ")";
            $querySETrowCountR4 .= $querySETaddRowCountR4;
            $wpdb->query($querySETrowCountR4);

            $querySETaddRowCountR5 = substr($querySETaddRowCountR5,0,-2);
            $querySETaddRowCountR5 .= ")";
            $querySETrowCountR5 .= $querySETaddRowCountR5;
            $wpdb->query($querySETrowCountR5);

        }

        $wpdb->update(
            "$tablename_pro_options",
            array('IsModernFiveStar' => '1'),
            array('GalleryID' => $GalleryID),
            array('%d'),
            array('%d')
        );

        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-options.json";
        $fp = fopen($jsonFile, 'r');
        $optionsArray = json_decode(fread($fp, filesize($jsonFile)),true);
        fclose($fp);

        $optionsArray['pro']['IsModernFiveStar'] = 1;

        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-options.json";
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($optionsArray));
        fclose($fp);

        // !IMPORTANT otherwise indexed db will be not reloaded
        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-gallery-tstamp.json";
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);

        $correctStatusText5 = 'Corrected<br>You need to reload the gallery in frontend<br>Check translation files or options for average sorting translation';
        $correctStatusClass5 = 'cg_corrected';
    }

    $correctContent5 = '<div class="cg_corrections_container">
        <div class="cg_corrections_explanation">
            <div class="cg_corrections_title">Your gallery uses old 5 stars look</div>
            <div class="cg_corrections_description">Correct it to see percentage for each star by hovering rating and to be able to sort by average rating in frontend.</div>
        </div>
        <div class="cg_corrections_action '.$correctStatusClass5.'">                
            <form method="POST" action="?page=contest-gallery/index.php&amp;corrections_and_improvements=true&amp;option_id='.$GalleryID.'" class="cg_load_backend_submit">
                <input type="hidden" name="action_correct_to_modern_five_star" value="true">
                <input type="hidden" name="option_id" value="'.$GalleryID.'">
                <span class="cg_corrections_action_submit">'.$correctStatusText5.'</span>
            </form>
        </div>
        </div>';

}


$correctStatusText6 = 'Repair';
$correctStatusClass6 = '';

if(isset($_POST['action_correct_not_visible_for_frontend'])){

    $picsSQL = $wpdb->get_results( "SELECT $table_posts.*, $tablename.* FROM $table_posts, $tablename WHERE $tablename.GalleryID='$GalleryID' AND $tablename.Active='1' and $table_posts.ID = $tablename.WpUpload ORDER BY $tablename.id DESC");

    // first get user ids in this array $imageId
    $wpUserIdsAndDisplayNames = array();
    $collect = "";
    foreach($picsSQL as $object){
        if(!empty($object->WpUserId)){
            $wpUserIdsAndDisplayNames[$object->id] = $object->WpUserId;
            if($collect==''){
                $collect .= "ID = $object->WpUserId";
            }else{
                $collect .= " OR ID = $object->WpUserId";
            }
        }
        else{
            $wpUserIdsAndDisplayNames[$object->id] = '';
        }
    }

    if(!empty($collect)){
        $displayNames = $wpdb->get_results( "SELECT ID, display_name FROM $table_users WHERE ($collect) ORDER BY ID DESC");
    }

    // now get user names in this array
    if(!empty($displayNames)){
        foreach($displayNames as $wpUser){

            if(in_array($wpUser->ID,$wpUserIdsAndDisplayNames)){
                foreach($wpUserIdsAndDisplayNames as $imageId => $wpUserId){

                    if($wpUserId==$wpUser->ID){
                        //$imageArray[$rowObject->id]['display_name'] = '' wurde pauschal in cg_create_json_files_when_activating
                        $imageArray[$imageId]['display_name'] = $wpUser->display_name;
                        $wpUserIdsAndDisplayNames[$imageId] = $wpUser->display_name;

                    }

                }
            }
        }
    }

    $imageArray = [];

    $jsonUploadImageData = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-data';
    $jsonUploadImageInfoDir = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info';
    $jsonUploadImageCommentsDir = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-comments';

    if(!is_dir($jsonUploadImageData)){
        mkdir($jsonUploadImageData,0755,true);
    }

    if(!is_dir($jsonUploadImageInfoDir)){
        mkdir($jsonUploadImageInfoDir,0755,true);
    }

    if(!is_dir($jsonUploadImageCommentsDir)){
        mkdir($jsonUploadImageCommentsDir,0755,true);
    }

    // add all json files and generate images array
    foreach($picsSQL as $object){

        $imageArray = cg_create_json_files_when_activating($GalleryID,$object,$thumbSizesWp,$uploadFolder,$imageArray,$wpUserIdsAndDisplayNames);
        include(__DIR__.'/../../../v10/v10-admin/gallery/change-gallery/4_2_fb-creation.php');

    }

    // take care of order!
    cg_set_data_in_images_files_with_all_data($GalleryID,$imageArray);
    cg_json_upload_form_info_data_files($GalleryID,null);

    $correctStatusText6 = 'Repaired';
    $correctStatusClass6 = 'cg_corrected';

}

$correctStatusTextFull7 = 'No mail exceptions so far';
$correctStatusText7 = 'Everything correct';
$correctStatusClass7 = 'cg_corrected';
$correctStatusDownloadClass7 = 'cg_corrected';
$correctStatusExceptions7 = '';
$correctStatusExceptionsReturn7 = '';
$cg_file_name_mail_log = '';

$fileName = md5(wp_salt( 'auth').'---cnglog---'.$GalleryID);
$file = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/logs/errors/mail-'.$fileName.'.log';

if(file_exists($file)){
    $cg_file_name_mail_log = $fileName;
    $correctStatusTextFull7 = 'Some mail exceptions happend';
    $correctStatusText7 = 'Show exceptions';
    $correctStatusClass7 = 'cg_corrections_container_exception';
    $correctStatusDownloadClass7 = '';
    $fp = fopen($file, 'r');
    $correctStatusExceptions7 = fread($fp, 30000);
    fclose($fp);

    ob_start();
    echo "<pre>";
    print_r($correctStatusExceptions7);
    echo "</pre>";
    $correctStatusExceptionsReturn7 = ob_get_clean();
}

echo <<<HEREDOC
<div id="cgCorrections">
    <div class="cg_corrections_container">
        <div class="cg_corrections_explanation">
            <div class="cg_corrections_title">Repair frontend?</div>
            <div class="cg_corrections_description">For big data it might happen that a server was not able to finish processing.<br>Then not all images might be visible in frontend or some data in frontend is missing. You can correct such here.</div>
        </div>
        <div class="cg_corrections_action $correctStatusClass6">                
            <form method="POST" action="?page=contest-gallery/index.php&amp;corrections_and_improvements=true&amp;option_id=$GalleryID" class="cg_load_backend_submit">
                <input type="hidden" name="action_correct_not_visible_for_frontend" value="true">
                <input type="hidden" name="option_id" value="$GalleryID">
                <span class="cg_corrections_action_submit">$correctStatusText6</span>
            </form>
        </div>
    </div>
    <div class="cg_corrections_container">
        <div class="cg_corrections_explanation">
            <div class="cg_corrections_title">Database status</div>
            <div class="cg_corrections_description">$correctStatusTextFull4</div>
        </div>
        <div class="cg_corrections_action $correctStatusClass4">                
            <form method="POST" action="?page=contest-gallery/index.php&amp;corrections_and_improvements=true&amp;option_id=$GalleryID" class="cg_load_backend_submit">
                <input type="hidden" name="action_check_and_correct_database" value="true">
                <input type="hidden" name="option_id" value="$GalleryID">
                <span class="cg_corrections_action_submit">$correctStatusText4</span>
            </form>
        </div>
    </div>
    $correctContent5
    <div class="cg_corrections_container">
        <div class="cg_corrections_explanation">
            <div class="cg_corrections_title">Mailing status</div>
            <div class="cg_corrections_description">$correctStatusTextFull7</div>
        </div>
        <div class="cg_corrections_action $correctStatusClass7" id="cgCorrect7showExceptionsButton" style="width:40%;text-align:center;">
            $correctStatusText7         
        </div>
        <div id="cgCorrect7exceptions" class="cg_hide" style="width:100%;">
            <div>$correctStatusExceptionsReturn7</div>
            <div class="cg_corrections_action $correctStatusDownloadClass7" style="width:40%;text-align:center;">
                 <form method="POST" action="?page=contest-gallery/index.php&amp;corrections_and_improvements=true&amp;option_id=$GalleryID">
                    <input type="hidden" name="cg_action_check_and_download_mail_log_for_gallery" value="true">
                    <input type="hidden" name="cg_file_name_mail_log" value="$cg_file_name_mail_log">
                    <input type="hidden" name="option_id" value="$GalleryID">
                    <span class="cg_corrections_action_submit">Download full log</span>
                </form>
            </div>
        </div>
    </div>
</div>
HEREDOC;




?>