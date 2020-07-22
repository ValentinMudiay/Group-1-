<?php
if(!defined('ABSPATH')){exit;}

// Aurufen von WP-Config hier notwendig
//include("../../../../wp-config.php");


// User ID �berpr�fung ob es die selbe ist
$CheckCheck = wp_create_nonce("check");

$check = @$_POST['check'];
$sendUserMail = '';
$userMail = '';
$checkWpMail = '';

$isManipulated = false;

$Version = '10.9.8.8.1';

$CookieId='';


if(empty($_POST["cg_upload_action"]) OR empty($_FILES["data"])){
    $isManipulated = true;
}else{
    global $wpdb;

    $tablenameProOptions = $wpdb->prefix . "contest_gal1ery_pro_options";
    $tablename1 = $wpdb->prefix . "contest_gal1ery";
    $galeryID = intval($_POST['GalleryID']);
    $galeryIDuser = $galeryID;
    if(isset($_POST['galeryIDuser'])){
        $galeryIDuser = $_POST['galeryIDuser'];
    }

    $proOptions = $wpdb->get_row( "SELECT * FROM $tablenameProOptions WHERE GalleryID = '$galeryID'" );

    $RegUserUploadOnly = $proOptions->RegUserUploadOnly;
    $RegUserMaxUpload = $proOptions->RegUserMaxUpload;
    $UploadRequiresCookieMessage = $proOptions->UploadRequiresCookieMessage;
    $is_user_logged_in = is_user_logged_in();
    if(!empty($RegUserUploadOnly)){

        $isCountCheckHasToBeDone = false;

        if($RegUserUploadOnly==1 && !empty($RegUserMaxUpload) && $is_user_logged_in==true){
            $isCountCheckHasToBeDone = true;
            $WpUserId = get_current_user_id();
            $regUserUploadsCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename1 WHERE WpUserId = '$WpUserId' and GalleryID = '$galeryID'");
        }else if($RegUserUploadOnly==2 && !empty($RegUserMaxUpload)){

            if($RegUserUploadOnly==2){

                if(!isset($_COOKIE['contest-gal1ery-'.$galeryID.'-upload'])) {

                    echo $UploadRequiresCookieMessage;

                    ?>

                    <script data-cg-processing="true" data-cg-upload-cookie-requires="true">

                        cgJsClass.gallery.upload.doneUploadFailed = true;
                        cgJsClass.gallery.upload.failMessage = <?php echo json_encode($UploadRequiresCookieMessage);?>;

                    </script>

                    <?php
                    die;

                }else{
                    $CookieId = $_COOKIE['contest-gal1ery-'.$galeryID.'-upload'];
                }

            }

            $isCountCheckHasToBeDone = true;
            if(!empty($CookieId)){
                $regUserUploadsCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename1 WHERE CookieId = '$CookieId' and GalleryID = '$galeryID'");
            }else{
                $regUserUploadsCount = 0;
            }
        }else if($RegUserUploadOnly==3 && !empty($RegUserMaxUpload)){
            $isCountCheckHasToBeDone = true;
            $userIP = cg_get_user_ip();
            if(!empty($userIP)){
                $regUserUploadsCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename1 WHERE IP = '$userIP' and GalleryID = '$galeryID'");
            }else{
                $regUserUploadsCount = 0;
            }
        }

        if($isCountCheckHasToBeDone){
            $uploadedFilesCount = count($_FILES["data"]["name"]);
            $totalUserUploads = $regUserUploadsCount+$uploadedFilesCount;
            if($totalUserUploads>$RegUserMaxUpload){
                $isManipulated = true;
            }
        }
    }

}


if(!$isManipulated){

    global $wp_version;

    $sanitize_textarea_field = ($wp_version<4.7) ? 'sanitize_text_field' : 'sanitize_textarea_field';

    //echo "galeryID: $galeryID";

    $unix = time();
    $unixadd = $unix+2;

    if(!function_exists('return_bytes1')){
        function return_bytes1($val) {
            $val = intval(trim($val));
            $last = strtolower($val{strlen($val)-1});
            switch($last) {
                // The 'G' modifier is available since PHP 5.1.0
                case 'g':
                    $val *= 1024;
                case 'm':
                    $val *= 1024;
                case 'k':
                    $val *= 1024;
            }

            return $val;
        }
    }

    $GalleryID = $galeryID;

    $uploadFolder = wp_upload_dir();

    $maxigroesse = return_bytes1(ini_get('upload_max_filesize'));


    //----------------------------Prove if user tries to reload ---------------->

    $tablename_f_input = $wpdb->prefix . "contest_gal1ery_f_input";
    $tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
    $selectSQL1 = $wpdb->get_row( "SELECT * FROM $tablenameOptions WHERE id = '$galeryID'" );
    $tablenameentries = $wpdb->prefix . "contest_gal1ery_entries";
    $tablename_mail_confirmation = $wpdb->prefix . "contest_gal1ery_mail_confirmation";
    $tablename_mails_collected = $wpdb->prefix . "contest_gal1ery_mails_collected";
    $tablename_categories = $wpdb->prefix . "contest_gal1ery_categories";
    $table_posts = $wpdb->prefix."posts";
    $wpUsers = $wpdb->base_prefix . "users";

    // neue image Ids für Abfrage sammeln
    $collect = '';

    $formInputForFieldTitles = $wpdb->get_results( "SELECT id, Field_Content FROM $tablename_f_input WHERE GalleryID = '$galeryID' ORDER BY Field_Order ASC" );

    $inputFieldTitlesArray = array();
    $inputFieldContentArray = array();

    foreach($formInputForFieldTitles as $row){

        $row->Field_Content = unserialize($row->Field_Content);
        $fieldTitle = $row->Field_Content["titel"];

        $inputFieldTitlesArray[$row->id] = $fieldTitle;
        $inputFieldContentArray[$row->id] = $row->Field_Content;

    }


    $wp_upload_dir = wp_upload_dir();

    $thumbSizesWp = array();
    $thumbSizesWp['thumbnail_size_w'] = get_option("thumbnail_size_w");
    $thumbSizesWp['medium_size_w'] = get_option("medium_size_w");
    $thumbSizesWp['large_size_w'] = get_option("large_size_w");


    $mailConfSettings = $wpdb->get_row( "SELECT * FROM $tablename_mail_confirmation WHERE GalleryID='$galeryID' ");
    $InformAdmin = $wpdb->get_var( "SELECT InformAdmin FROM $tablenameOptions WHERE id = '$galeryID'" );

    $tablenameemail = $wpdb->prefix . "contest_gal1ery_mail";
    $selectSQLemail = $wpdb->get_row( "SELECT * FROM $tablenameemail WHERE GalleryID = '$galeryID'" );

    add_action('contest_gal1ery_mail_image_activation', 'contest_gal1ery_mail_image_activation',3,5);

    include(plugin_dir_path(__FILE__).'mail_image_activation_function.php');

    $collectImageIDs = array();

    $checkCgMail = '';
    $cgMailChecked = false;
    $categoryId = 0;
    $processedFilesCounter = 0;


    // These files need to be included as dependencies when on the front end.
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

    $ActivateBulkUpload = $selectSQL1->ActivateBulkUpload;
    $BulkUploadQuantity = $selectSQL1->BulkUploadQuantity;
    $InformUser = $selectSQL1->Inform;
    $ActivateUpload = $selectSQL1->ActivateUpload;
    $cgVersion = $selectSQL1->Version;
    $files = $_FILES["data"];
    $uploadQuantity = count($files["name"]);
    $fbContentArray = array();

    if(empty($BulkUploadQuantity)){
        $BulkUploadQuantity = 100;
    }


    if($ActivateBulkUpload==1 && $uploadQuantity > $BulkUploadQuantity){

        ?>

        <script data-cg-processing="true">


            cgJsClass.gallery.upload.doneUploadFailed = true;
            cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Please don't manipulate upload quantity.");?>;


        </script>

        <?php

        echo "Please don't manipulate upload quantity.";die;
    }
    if($ActivateBulkUpload==0 && $uploadQuantity > 1){

        ?>

        <script data-cg-processing="true">

            cgJsClass.gallery.upload.doneUploadFailed = true;
            cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Please don't manipulate upload quantity. Bulk upload deactivated.");?>;

        </script>

        <?php

        echo "Please don't manipulate upload quantity. Bulk upload deactivated.";die;

    }

    // validate send form first
    $form_input = @$_POST['form_input'];

    // manipulation fields check of fields

    // 4 array numbers are one input field
    // 1 = fieldType
    // 2 = fieldId
    // 3 = fieldOrder
    // 4 = content
    $i = 1;
    $inputId = 0;
    $content = '';
    $fieldType = '';


    foreach($form_input as $value){

        if($i == 1){

            $fieldType = $value;

        }

        if($i == 2){

            $inputId = $value;

        }

        if($i == 4){

            $content = $value;

            if(!empty($inputFieldContentArray[$inputId]['mandatory'])){
                if($inputFieldContentArray[$inputId]['mandatory']=='on' && empty($content)){

                    ?>

                    <script data-cg-processing="true">


                        cgJsClass.gallery.upload.doneUploadFailed = true;
                        cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Please don't manipulate the form. Field_Type: $fieldType , required manipulated");?>;


                    </script>

                    <?php

                    echo "Please don't manipulate the form. Field_Type: $fieldType , required manipulated";die;

                }
            }

            if($fieldType=='kf' OR $fieldType=='fbd'){
                $content = str_replace("\r","",$content);// then equal to html behaviour if maxlength was set in the textarea field
            }

            if(!empty($inputFieldContentArray[$inputId]['min-char'])){
                if(!empty($content) && strlen($content) < $inputFieldContentArray[$inputId]['min-char']){


                    ?>

                    <script data-cg-processing="true">


                        cgJsClass.gallery.upload.doneUploadFailed = true;
                        cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Please do not manipulate the form. Field_Type: $fieldType , minimum characters manipulated");?>;


                    </script>

                    <?php


                    echo "Please do not manipulate the form. Field_Type: $fieldType , minimum characters manipulated";die;
                }
            }

            if(!empty($inputFieldContentArray[$inputId]['max-char'])){
                if(!empty($content) && strlen($content) > $inputFieldContentArray[$inputId]['max-char']){

                    ?>

                    <script data-cg-processing="true">


                        cgJsClass.gallery.upload.doneUploadFailed = true;
                        cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Please do not manipulate the form. Field_Type: $fieldType , maximum characters manipulated");?>;


                    </script>

                    <?php


                    echo "Please do not manipulate the form. Field_Type: $fieldType , maximum characters manipulated";die;
                }
            }


        }

        // reset here
        if($i % 4 === 0){

            $i = 1;
            $inputId = 0;
            $content = '';
            $fieldType = '';

        }else{
            $i++;
        }

    }

    // manipulation fields check of fields --- END


    if(!empty($files['name']) && is_array($files["name"])){

        foreach ($files['name'] as $key => $value) {

            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );
            }

            $dateityp = GetImageSize($file["tmp_name"]);


            /*            $imageTypeArray = array
            (
                0=>'UNKNOWN',
                1=>'GIF',
                2=>'JPEG',
                3=>'PNG',
                4=>'SWF',
                5=>'PSD',
                6=>'BMP',
                7=>'TIFF_II',
                8=>'TIFF_MM',
                9=>'JPC',
                10=>'JP2',
                11=>'JPX',
                12=>'JB2',
                13=>'SWC',
                14=>'IFF',
                15=>'WBMP',
                16=>'XBM',
                17=>'ICO',
                18=>'COUNT'
            );*/


            if ($dateityp[2] != 1 && $dateityp[2] != 2 && $dateityp[2] != 3) {

                // File size wird als 0 ausgegeben wenn die hoch zu ladende Datei gr��er ist als Server erlaubt. File type und andere Infos dann auch nicht vorhanden.
                //   echo "Don't manipulate the upload: wrong file type or file size"; die;

                ?>

                <script data-cg-processing="true">


                    cgJsClass.gallery.upload.doneUploadFailed = true;
                    cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Don't manipulate the upload: wrong file type");?>;


                </script>

                <?php

                die;

            }

            if($cgVersion<7){

                if (function_exists('exif_read_data')){

                    // Nicht funktionierende Rotate Möglichkeit für Bilder im TMP Folder:
                    // https://codex.wordpress.org/Function_Reference/wp_get_image_editor

                    $tmpFilename = $files['tmp_name'][$key];

                    $exif = @exif_read_data($tmpFilename);

                    //var_dump($exif['Orientation']);
                    //   die;



                    if (!empty($exif['Orientation'])) {



                        // provided that the image is jpeg. Use relevant function otherwise
                        switch (!empty($exif['Orientation'])) {
                            case 3:
                                if($dateityp[2] == 1){$imageResource = imagecreatefromgif($tmpFilename);}
                                if($dateityp[2] == 2){$imageResource = imagecreatefromjpeg($tmpFilename);}
                                if($dateityp[2] == 3){$imageResource = imagecreatefrompng($tmpFilename);}
                                $image = imagerotate($imageResource, 180, 0);
                                if($dateityp[2] == 1){imagegif($image, $tmpFilename, 90);}
                                if($dateityp[2] == 2){imagejpeg($image, $tmpFilename, 90);}
                                if($dateityp[2] == 3){imagepng($image, $tmpFilename, 90);}
                                imagedestroy($imageResource);
                                imagedestroy($image);
                                break;
                            case 6:
                                if($dateityp[2] == 1){$imageResource = imagecreatefromgif($tmpFilename);}
                                if($dateityp[2] == 2){$imageResource = imagecreatefromjpeg($tmpFilename);}
                                if($dateityp[2] == 3){$imageResource = imagecreatefrompng($tmpFilename);}
                                $image = imagerotate($imageResource, -90, 0);
                                if($dateityp[2] == 1){imagegif($image, $tmpFilename, 90);}
                                if($dateityp[2] == 2){imagejpeg($image, $tmpFilename, 90);}
                                if($dateityp[2] == 3){imagepng($image, $tmpFilename, 90);}
                                imagedestroy($imageResource);
                                imagedestroy($image);
                                break;
                            case 8:
                                if($dateityp[2] == 1){$imageResource = imagecreatefromgif($tmpFilename);}
                                if($dateityp[2] == 2){$imageResource = imagecreatefromjpeg($tmpFilename);}
                                if($dateityp[2] == 3){$imageResource = imagecreatefrompng($tmpFilename);}
                                $image = imagerotate($imageResource, 90, 0);
                                if($dateityp[2] == 1){imagegif($image, $tmpFilename, 90);}
                                if($dateityp[2] == 2){imagejpeg($image, $tmpFilename, 90);}
                                if($dateityp[2] == 3){imagepng($image, $tmpFilename, 90);}
                                imagedestroy($imageResource);
                                imagedestroy($image);
                                break;
                            default:
                                $doNothing = '';
                        }
                    }


                }

            }
// $test->save( $files['tmp_name'][$key] );


            $_FILES = array ("data" => $file);
            //var_dump($_FILES);
            foreach ($_FILES as $file => $array) {
                // $newupload = my_handle_attachment($file,$post_id);

                // Use the wordpress function to upload
                // test_upload_pdf corresponds to the position in the $_FILES array
                // 0 means the content is not associated with any other posts



                $time = date("Y-m-d H:i:s");

                $post_data = array(
                    'post_content' => "Contest Gallery ID-$galeryID $time"
                );

                $attach_id = media_handle_upload($file,0,$post_data);
                //  var_dump($attach_id);die;



                if ( is_wp_error( $attach_id ) ) {
                    //    echo "There was an error uploading the image. Please contact site administrator."; die;


                    ?>

                    <script data-cg-processing="true">


                        cgJsClass.gallery.upload.doneUploadFailed = true;
                        cgJsClass.gallery.upload.failMessage = <?php echo json_encode("There was an error uploading the image. Please contact site administrator.");?>;


                    </script>

                    <?php
                    die;



                } else {
                    //echo "The image was uploaded successfully!";
                    //var_dump($attachment_id);
                }

            }

            //----------------------------Upload file and save in database ---------------->

            /*
            if ((isset(@$_POST['submit']) && @$_POST['submit']==true) AND $_FILES['date']['size'] <= 0) {
            echo "<strong>Sie haben kein Bild ausgew&auml;hlt zum Hochladen.</strong><br/><br/>";
            }*/

            if ($files['size'] > 0) {


                $tempname = $files['tmp_name'][$key];
                $dateiname = $files['name'][$key];
                $dateiname = strtolower($dateiname);
                $dateigroesse = $files['size'][$key];


                $wp_image_info = $wpdb->get_row("SELECT * FROM $table_posts WHERE ID = '$attach_id'");
                $image_url = $wp_image_info->guid;
                $post_title = $wp_image_info->post_title;
                $post_type = $wp_image_info->post_mime_type;
                $wp_image_id = $wp_image_info->ID;

                // Notwendig: wird in convert-several-pics so verabeitet. Darf keine Sonderzeichen enthalten!
                $search = array(" ", "!", '"', "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "/", ":", ";", "=", "?", "@", "[","]","�");
                $post_title = str_replace($search,"_",$post_title);
                // var_dump($post_title); die;
                $dateiname = $post_title;


                $doNotProcess=0;

                if($post_type=="image/jpeg"){$post_type="jpg";$imageType="jpg";}
                else if($post_type=="image/png"){$post_type="png";$imageType="png";}
                else if($post_type=="image/gif"){$post_type="gif";$imageType="gif";}
                else{
                    $doNotProcess=1;
                }
                //echo "post_type $post_type<br>";
                $uploads = wp_upload_dir();

                $check = explode($uploads['baseurl'],$image_url);

                //echo $uploads['basedir'].$check[1].$post_title.".".$post_type;

                $filename = $uploads['basedir'].$check[1];

                //  var_dump($filename); die;
                //  var_dump($dateiname); die;


                //----------------------------Create Thumbs and Galery pics ---------------->

                //echo "yes<br>";


                // destination of the uploaded original image
                //$filename = $WPdestination . $unixadd . '_' . $dateiname.".".$imageType;

                $unix = time();
                $unixadd = $unix+2;

                //require(dirname(__FILE__) . "/../convert-several-pics.php");

                // if($cgVersion>=7){
                //list($current_width, $current_height) = getimagesize($filename);

                $imageInfoArray = wp_get_attachment_image_src($wp_image_id,'full');
                $current_width = $imageInfoArray[1];
                $current_height = $imageInfoArray[2];

                // }
                //  else{
                //    include(dirname(__FILE__) . "/../../../convert-several-pics.php");
                // }



                //----------------------------Create Thumbs and Galery pics END ----------------//

                //$wpdb->insert( $tablename1, array( 'id' => '', 'rowid' => "$nextId", 'Timestamp' => $unixadd, 'NamePic' => $dateiname, 'ImgType' => $imageType, 'CountC' => 0, 'CountR' => '', 'Rating' => '', 'GalleryID' => $galeryID, 'Active' => 0, 'Informed' => 0  ) );

                if(is_user_logged_in()){
                    $WpUserId = get_current_user_id();
                }
                else{
                    $WpUserId = '';
                }

                if(empty($userIP)){
                    $userIP = cg_get_user_ip();
                }

                // updating string after all the 0 at the end does not work. That is why version is not inserted there
                // default 0 to countr1-5 was added lately on 15.05.2020
                $wpdb->query( $wpdb->prepare(
                    "
					INSERT INTO $tablename1
					( id, rowid, Timestamp, NamePic,
					ImgType, CountC, CountR, Rating,
					GalleryID, Active, Informed, WpUpload, Width, Height, WpUserId, IP,
			        CountR1,CountR2,CountR3,CountR4,CountR5)
					VALUES ( %s,%s,%d,%s,
					%s,%d,%s,%s,
					%d,%s,%s,%s,%s,%s,%s,%s,
			        %d,%d,%d,%d,%d)
				",
                    '','',$unixadd,$dateiname,
                    $post_type,0,'','',
                    $galeryID,'','',$wp_image_id,$current_width,$current_height,$WpUserId,$userIP,
                    0,0,0,0,0,0
                ) );

                // $idOfInsertedImage = $wpdb->insert_id;



                if(!get_option("p_cgal1ery_uploadscounter_reminder")){
                    add_option( "p_cgal1ery_uploadscounter_reminder", 0 );
                }

                if(get_option("p_cgal1ery_uploadscounter_reminder")){
                    $p_cgal1ery_uploadscounter_reminder = get_option("p_cgal1ery_uploadscounter_reminder");
                    $p_cgal1ery_uploadscounter_reminder++;
                    update_option( "p_cgal1ery_uploadscounter_reminder", $p_cgal1ery_uploadscounter_reminder);
                }

                if(get_option( "p_cgal1ery_reg_code" )==false || intval(get_option( "p_cgal1ery_reg_code" )) % 44 != 0 && intval(get_option( "p_cgal1ery_reg_code" )) != 0){

                    if(get_option("p_cgal1ery_count_uploads")==true){
                        $p_cgal1ery_count_uploads = get_option( "p_cgal1ery_count_uploads" );

                        $p_cgal1ery_count_uploads--;

                        update_option( "p_cgal1ery_count_uploads", $p_cgal1ery_count_uploads );

                    }
                    else{
                        add_option( "p_cgal1ery_count_uploads", 100 );
                    }

                }

                // Insert Upload Fields for pic if exists

                $nextId = $wpdb->get_var("SELECT id FROM $tablename1 WHERE Timestamp='$unixadd' AND NamePic='$dateiname'");

                if($collect==''){
                    $collect .= "$tablename1.id = $nextId";
                }else{
                    $collect .= " OR $tablename1.id = $nextId";
                }

                $CheckSet = '';

                if($RegUserUploadOnly==1){
                    $CheckSet = 'CheckLogin';
                }else if($RegUserUploadOnly==2){
                    $CheckSet = 'CheckCookie';
                }else if($RegUserUploadOnly==3){
                    $CheckSet = 'CheckIp';
                }

                // updating string after all the 0 at the end does not work at the top insert query. That is why version have to be inserted here
                $wpdb->update(
                    "$tablename1",
                    array('rowid' => $nextId,'Version' => $Version,'CookieId' => $CookieId,'CheckSet' => $CheckSet),
                    array('id' => $nextId),
                    array('%d','%s','%s','%s'),
                    array('%d')
                );

                // var_dump(9);
                // Sp�ter f�r Inform Image wichtig
                $collectImageIDs[] = $nextId;

                //      var_dump($_FILES);die;
                try{
                    if (!empty($_POST['form_input'])){

                        //	print_r($form_input);

                        //$form_input = sanitize_text_field(@$_POST['form_input']);
                        $form_input = @$_POST['form_input'];
/*
                        echo "<pre>";
                        print_r($form_input);
                        echo "</pre>";*/

                        $i=0;

                        $sendUserMail = '';


                        // 1. Feldtyp <<< Zur Bestimmung der Feldart f�r weitere Verarbeitung in der Datenbank, Admin etc.
                        // 2. Feldnummer <<<  Zur Bestimmung der Feldreihenfolge in Frontend und Admin.
                        // 3. Feldreihenfolge
                        // 4. Feldinhalt

                        foreach ($form_input as $key => $value) {
                            $i++;

                            // Short_Text Entries werden eingef�gt (Name, E-Mail)

                            if(!isset($ft)){
                                $ft = '';
                            }

                            if ($i==1 AND ($ft!='kf' or $ft!='fbd')){$ft = $value; continue;}

                            if ($i==2 AND ($ft=='nf' or $ft=='ef' or $ft=='se' or $ft=='url' or $ft=='sec' or $ft=='cb' or $ft=='fbt' or $ft=='dt')){$f_input_id = $value; continue;}

                            if ($i==3 AND ($ft=='nf' or $ft=='ef' or $ft=='se' or $ft=='url' or $ft=='sec' or $ft=='cb' or $ft=='fbt' or $ft=='dt')){
                                $field_order = $value;
                                $Checked = 0;
                                if($ft=='cb'){// check if hook was in or not!!!!
                                    $keyPlusOne = $key+1;
                                    if(!empty($form_input[$keyPlusOne])){
                                        if($form_input[$keyPlusOne]=='checked'){// then can go one time more and proccessed natural way.
                                            $Checked = 1;
                                            continue;
                                        }else{
                                            $i=4;//
                                            $value = 'not-checked';
                                        }
                                    }else{
                                        $i=4;//
                                        $value = 'not-checked';
                                    }
                                }else{
                                    continue;
                                }
                            }
                            if ($i==4 AND ($ft=='nf' or $ft=='ef' or $ft=='se' or $ft=='url' or $ft=='sec' or $ft=='cb' or $ft=='fbt' or $ft=='dt')){

                                //echo "<br>insert $ft<br>";
                                //echo "<br>f_input_id $f_input_id<br>";
                                //echo "<br>field_order $field_order<br>";

                                if(is_user_logged_in() && $ft=='ef'){
                                    global $current_user;
                                    get_currentuserinfo();
                                    $content = $current_user->user_email;
                                }
                                else{
                                    $content = $value;
                                }

                                $content = trim($content);
                                $content = stripslashes($content);
                                $content = sanitize_text_field($content);
                                $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

                                if($ft=='dt'){
                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );


                                    /* $stringTest = 'YYYY.MM.DD';
                                                                    $stringTest = str_replace('YYYY','Y',$stringTest);
                                                                    $stringTest = str_replace('MM','m',$stringTest);
                                                                    $stringTest = str_replace('DD','d',$stringTest);

                                                                    var_dump($stringTest);
                                                                    $newDateTimeObject = DateTime::createFromFormat("Y.m.d H:i:s",'2020.26.06 00:00:00');
                                                                    var_dump($newDateTimeObject);*/


                                    $newDateTimeString = '0000-00-00 00:00:00';

                                    try {

                                        $dtFieldContent = $inputFieldContentArray[$f_input_id];
                                        $dtFormat = $dtFieldContent['format'];

                                        $dtFormat = str_replace('YYYY','Y',$dtFormat);
                                        $dtFormat = str_replace('MM','m',$dtFormat);
                                        $dtFormat = str_replace('DD','d',$dtFormat);

                                        $newDateTimeObject = DateTime::createFromFormat("$dtFormat H:i:s","$content 00:00:00");
                                        if(is_object($newDateTimeObject)){
                                            $newDateTimeString = $newDateTimeObject->format("Y-m-d H:i:s");
                                        }
                                    }catch (Exception $e) {

                                        $newDateTimeString = '0000-00-00 00:00:00';

                                    }

                                   // var_dump(11111);

                                    $wpdb->query( $wpdb->prepare(
                                        "
                                    INSERT INTO $tablenameentries
                                    ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text, InputDate)
                                    VALUES ( %s,%d,%d,%d,%s,%d,%s,%s,%s )
                                ",
                                        '',$nextId,$f_input_id,$galeryID,'date-f',$field_order,'','',$newDateTimeString
                                    ) );

                                }

                                if($ft=='nf'){

                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    $wpdb->query( $wpdb->prepare(
                                        "
                                    INSERT INTO $tablenameentries
                                    ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text)
                                    VALUES ( %s,%d,%d,%d,%s,%d,%s,%s )
                                ",
                                        '',$nextId,$f_input_id,$galeryID,'text-f',$field_order,$content,''
                                    ) );

                                }

                                if($ft=='fbt'){
                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    $wpdb->query( $wpdb->prepare(
                                        "
                                    INSERT INTO $tablenameentries
                                    ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text)
                                    VALUES ( %s,%d,%d,%d,%s,%d,%s,%s )
                                ",
                                        '',$nextId,$f_input_id,$galeryID,'fbt-f',$field_order,$content,''
                                    ) );

                                }

                                if($ft=='fbt'){// for facebook page create
                                    if(empty($fbContentArray[$nextId])){$fbContentArray[$nextId] = array();}
                                    $fbContentArray[$nextId]['title'] = $content;
                                }

                                if($ft=='cb'){
                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    // insert original checked field_content to show later!
                                    $content = $wpdb->get_var("SELECT Field_Content FROM $tablename_f_input WHERE id = $f_input_id");

                                    $wpdb->query( $wpdb->prepare(
                                        "
                                    INSERT INTO $tablenameentries
                                    ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text, Checked)
                                    VALUES ( %s,%d,%d,%d,%s,%d,%s,%s,%d)
                                ",
                                        '',$nextId,$f_input_id,$galeryID,'check-f',$field_order,'',$content,$Checked
                                    ) );

                                }

                                if($ft=='url'){
                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    $wpdb->query( $wpdb->prepare(
                                        "
                                    INSERT INTO $tablenameentries
                                    ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text)
                                    VALUES ( %s,%d,%d,%d,%s,%d,%s,%s )
                                ",
                                        '',$nextId,$f_input_id,$galeryID,'url-f',$field_order,$content,''
                                    ) );

                                }

                                if($ft=='se'){

                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    $wpdb->query( $wpdb->prepare(
                                        "
                                    INSERT INTO $tablenameentries
                                    ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text)
                                    VALUES ( %s,%d,%d,%d,%s,%d,%s,%s )
                                ",
                                        '',$nextId,$f_input_id,$galeryID,'select-f',$field_order,$content,''
                                    ) );

                                }

                                if($ft=='sec'){

                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'text-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    /*$wpdb->query( $wpdb->prepare(
                                        "
                                        INSERT INTO $tablenameentries
                                        ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text)
                                        VALUES ( %s,%d,%d,%d,%s,%d,%s,%s )
                                    ",
                                        '',$nextId,$f_input_id,$galeryID,'select-f',$field_order,$content,''
                                    ) );*/

                                    //    var_dump($content);die;

                                    $categoryId = $content;

                                    $wpdb->update(
                                        "$tablename1",
                                        array('Category' => $content),
                                        array('id' => $nextId),
                                        array('%s'),
                                        array('%s')
                                    );


                                }

                                if($ft=='ef'){
                                    //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'email-f', 'Field_Order' => $field_order, 'Short_Text' => $content, 'Long_Text' => '') );

                                    $sendUserMail = strtolower($content);

                                    if($cgMailChecked==false){
                                        $ConfMailId = 0;

                                        // Update des haupttables mit WpUserId weiter unten
                                        $checkWpMail = $wpdb->get_row( "SELECT ID, user_email FROM $wpUsers WHERE user_email = '$sendUserMail'" );

                                        if(empty($checkWpMail)){
                                            $checkCgMail = $wpdb->get_row( "SELECT * FROM $tablename_mails_collected WHERE Mail = '$sendUserMail'" );

                                            if(!empty($checkCgMail)){
                                                if($checkCgMail->Confirmed==1){
                                                    $ConfMailId = $checkCgMail->id;
                                                }
                                            }
                                        }




                                        $cgMailChecked=true;
                                    }


                                    $wpdb->query( $wpdb->prepare(
                                        "
                                        INSERT INTO $tablenameentries
                                        ( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text,ConfMailId)
                                        VALUES ( %s,%d,%d,%d,%s,%d,%s,%s,%d )
                                    ",
                                        '',$nextId,$f_input_id,$galeryID,'email-f',$field_order,$content,'',$ConfMailId
                                    ) );


                                    if(!empty($checkWpMail)){

                                        $wpdb->update(
                                            "$tablename1",
                                            array('WpUserId' => $checkWpMail->ID),
                                            array('id' => $nextId),
                                            array('%d'),
                                            array('%d')
                                        );

                                    }

                                }

                                $ft=false;
                                $f_input_id=false;
                                $field_order=false;
                                $i=0;
                                continue;
                            }


                            // Short_Text Entries werden eingef�gt ---- ENDE

                            // Long Entries werden eingef�gt

                            if ($i==1 AND ($ft!='nf' or $ft!='ef' or $ft!='se' or $ft!='url' or $ft!='sec' or $ft!='cb' or $ft!='fbt' or $ft!='dt')){$ft = $value; continue;}

                            if ($i==2 AND ($ft=='kf' OR $ft == 'fbd')){$f_input_id = $value; continue;}

                            if ($i==3 AND ($ft=='kf' OR $ft == 'fbd')){$field_order = $value; continue;}

                            if ($i==4 AND ($ft=='kf' OR $ft == 'fbd')){

                                //echo "<br>insert $ft<br>";
                                //echo "<br>f_input_id $f_input_id<br>";
                                //echo "<br>field_order $field_order<br>";

                                $content = $value;

                                $content = stripslashes($content);
                                $content = $sanitize_textarea_field(htmlspecialchars($content, ENT_QUOTES, 'UTF-8'));

                                //echo "<br>content $content<br>";

                                $fieldType = 'comment-f';

                                if($ft=='kf'){
                                    $fieldType = 'comment-f';
                                }
                                if($ft=='fbd'){
                                    $fieldType = 'fbd-f';
                                }

                                //$wpdb->insert( $tablenameentries, array( 'id' => '', 'pid' => $nextId, 'f_input_id' => $f_input_id, 'GalleryID' => $galeryID, "Field_Type" => 'comment-f', 'Field_Order' => $field_order, 'Short_Text' => '', 'Long_Text' => $content) );

                                $wpdb->query( $wpdb->prepare(
                                    "
					INSERT INTO $tablenameentries
					( id, pid, f_input_id, GalleryID, Field_Type, Field_Order, Short_Text, Long_Text)
					VALUES ( %s,%d,%d,%d,%s,%d,%s,%s )
				",
                                    '',$nextId,$f_input_id,$galeryID,$fieldType,$field_order,'',$content
                                ) );


                                if($fieldType=='fbd-f'){// for facebook page create
                                    if(empty($fbContentArray[$nextId])){$fbContentArray[$nextId] = array();}
                                    $fbContentArray[$nextId]['description'] = $content;
                                }

                                $ft=false;
                                $f_input_id=false;
                                $field_order=false;
                                $i=0;
                                continue;
                            }

                            // Long Entries werden eingef�gt ---- ENDE


                        }

                    }
                }catch(Exception $e){
                    print_r('form_input upload error. Please contact administrator.');die;
                    echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
                }

                if(is_user_logged_in()==true){
                    $userData = $wpdb->get_row("SELECT user_email, display_name FROM $wpUsers WHERE ID = $WpUserId");
                    $userMail = $userData->user_email;
                    $displayName = $userData->display_name;
                }
                else{
                    $userMail = $sendUserMail;
                    $displayName = '';
                }


                // Activate and send e-mail

                //@$ActivateUpload = $wpdb->get_var( "SELECT ActivateUpload FROM $tablenameOptions WHERE ActivateUpload='1' and id = '$galeryID' " );

                if($ActivateUpload==1){

                    $wpdb->update(
                        "$tablename1",
                        array('Active' => '1'),
                        array('id' => $nextId),
                        array('%d'),
                        array('%d')
                    );


                    if(!empty($userMail) && $InformUser == 1){
                        include(plugin_dir_path(__FILE__).'mail_image_activation.php');

                    }


                }

                // create FB page

                $object = new stdClass();
                $object->id = $nextId;
                $object->Timestamp = $unixadd;
                $object->NamePic = $dateiname;
                $object->WpUpload = $wp_image_id;

                if(!empty($fbContentArray[$nextId])){
                    if(!empty($fbContentArray[$nextId]['title'])){
                        $blog_title = $fbContentArray[$nextId]['title'];
                    }
                    if(!empty($fbContentArray[$nextId]['description'])){
                        $blog_description = $fbContentArray[$nextId]['description'];
                    }
                }

                include(__DIR__.'/../../v10-admin/gallery/change-gallery/4_2_fb-creation.php');

                // create FB page --- END

                $imageInfoEntriesData = $wpdb->get_results("SELECT id, f_input_id, Field_Type, Short_Text, Long_Text, InputDate FROM $tablenameentries WHERE pid = $nextId ORDER BY f_input_id ASC");

                if(!empty($imageInfoEntriesData)){
                    $arrayInfoDataForImage = array();

                    foreach($imageInfoEntriesData as $row){

                        if(empty($arrayInfoDataForImage[$row->f_input_id])){
                            $arrayInfoDataForImage[$row->f_input_id] = array();
                        }

                        $arrayInfoDataForImage[$row->f_input_id]['field-type'] = $row->Field_Type;
                        $arrayInfoDataForImage[$row->f_input_id]['field-title'] = $inputFieldTitlesArray[$row->f_input_id];

                        if(!empty($row->Long_Text)){
                            $arrayInfoDataForImage[$row->f_input_id]['field-content'] = $row->Long_Text;
                        }else if($row->Field_Type == 'date-f'){

                            $newDateTimeString = '';

                            if(!empty($row->InputDate) && $row->InputDate!='0000-00-00 00:00:00'){

                                try {

                                    $dtFieldContent = $inputFieldContentArray[$row->f_input_id];
                                    $dtFormat = $dtFieldContent['format'];

                                    $dtFormat = str_replace('YYYY','Y',$dtFormat);
                                    $dtFormat = str_replace('MM','m',$dtFormat);
                                    $dtFormat = str_replace('DD','d',$dtFormat);

                                    $newDateTimeObject = DateTime::createFromFormat("Y-m-d H:i:s",$row->InputDate);

                                    if(is_object($newDateTimeObject)){
                                        $newDateTimeString = $newDateTimeObject->format($dtFormat);
                                    }
                                }catch (Exception $e) {

                                    $newDateTimeString = '';

                                }

                            }


                            $arrayInfoDataForImage[$row->f_input_id]['field-content'] = $newDateTimeString;
                        }else{
                            $arrayInfoDataForImage[$row->f_input_id]['field-content'] = $row->Short_Text;
                        }
                    }

                    $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/image-info/image-info-'.$nextId.'.json';
                    $fp = fopen($jsonFile, 'w');
                    fwrite($fp, json_encode($arrayInfoDataForImage));
                    fclose($fp);

                }

            }

            $processedFilesCounter++;

        }


        if($ActivateUpload==1){

            // json File kreieren wenn instant upload activation an ist!!!

            $picsSQL = $wpdb->get_results( "SELECT $table_posts.*, $tablename1.* FROM $table_posts, $tablename1 WHERE ($collect) AND $tablename1.GalleryID='$galeryID' AND $tablename1.Active='1' and $table_posts.ID = $tablename1.WpUpload ORDER BY $tablename1.id DESC");

            if(!empty($picsSQL)){

                $wpUserIdsAndDisplayNames = array();

                if(is_user_logged_in()==true){
                    foreach($picsSQL as $object){
                        //   $imageArray[$object->id]['display_name'] = $displayName;
                        $wpUserIdsAndDisplayNames[$object->id] = $displayName;

                    }
                }else{
                    foreach($picsSQL as $object){
                        //   $imageArray[$object->id]['display_name'] = '';
                        $wpUserIdsAndDisplayNames[$object->id] = '';
                    }
                }

                foreach($picsSQL as $object){

                    if(empty($imageArray)){
                        $imageArray = cg_create_json_files_when_activating($galeryID,$object,$thumbSizesWp,$uploadFolder,null,$wpUserIdsAndDisplayNames);
                        /*                        echo "<pre>";
                                                print_r($imageArray);
                                                echo "</pre>";*/
                    }else{
                        /*                        echo "<pre>";
                                                print_r($imageArray);
                                                echo "</pre>";*/
                        $imageArray = cg_create_json_files_when_activating($galeryID,$object,$thumbSizesWp,$uploadFolder,$imageArray,$wpUserIdsAndDisplayNames);
                        /*                        echo "<pre>";
                                                print_r($imageArray);
                                                echo "</pre>";*/
                    }

                }

                cg_set_data_in_images_files_with_all_data($galeryID,$imageArray);

                cg_create_no_script_html($imageArray,$galeryID);

                //   die;

            }

        }


    }


    // Create Json Files --- END

    if($InformAdmin==1){
        include(plugin_dir_path(__FILE__).'mail_admin.php');
    }

    if($mailConfSettings->SendConfirm==1 && !empty($userMail) && is_user_logged_in()==false){
        //   var_dump(2);

        if (filter_var($userMail, FILTER_VALIDATE_EMAIL)) {
            //     var_dump(3);

            include(plugin_dir_path(__FILE__).'mail_confirm.php');
        }

    }
    // var_dump(1);
    //   die;
    // Forward confirmation texte after upload


    if($_POST['cg_from_gallery_form_upload']){
        //$GalleryUploadConfirmationText = $wpdb->get_var( "SELECT GalleryUploadConfirmationText FROM $tablenameProOptions WHERE GalleryID='$galeryID'");
        // echo 1;

        if($ActivateUpload==1){

            ?>

            <script data-cg-processing="true">
                //  alert(1);
                var gid = <?php echo json_encode($galeryIDuser);?>;
                var data = <?php echo json_encode($imageArray);?>;
                var newImageIdsArray = <?php echo json_encode($collectImageIDs);?>;
                var processedFilesCounter = <?php echo json_encode($processedFilesCounter);?>;

                cgJsClass.gallery.views.close(gid,true);
                cgJsClass.gallery.getJson.imageDataPreProcess(gid,data,false,processedFilesCounter,true,newImageIdsArray);

            </script>
            <?php
        }

        exit();

    }

    $contest_gal1ery_options_input = $wpdb->prefix . "contest_gal1ery_options_input";

    $inputOptionsSQL = $wpdb->get_row( "SELECT * FROM $contest_gal1ery_options_input WHERE GalleryID='$galeryID'"); // hier aufgeh�rt. Die Gallery ID wird nicht �bertragen, muss her geholt werden aus dem Jquery Post vorher oder aus dem Wordpress-PHP
    $Forward = $inputOptionsSQL->Forward;

    if($Forward==1){

        $Forward_URL = $inputOptionsSQL->Forward_URL;
        $Forward_URL = html_entity_decode(stripslashes($Forward_URL));

        $Forward_URLcheck = substr($Forward_URL, 0, 3);
        $Forward_URLcheck = strtolower($Forward_URLcheck);

        if($Forward_URLcheck=='www'){
            if(is_ssl()){
                $Forward_URL = "https://".$Forward_URL;
            }else{
                $Forward_URL = "http://".$Forward_URL;
            }
        }


        ?>
        <script>

            // makes better redirecting visual
            var htmlElement = document.getElementsByTagName("html")[0];
            htmlElement.remove();

            // funtzt nur so als vorher bestimmte variable
            var redirectURL = <?php echo json_encode($Forward_URL);?>;

            // similar behavior as an HTTP redirect
            window.location.replace(redirectURL);


        </script>
        <?php

        exit();
        //require("forward-url.php");

        //exit;
        //echo $Forward_URL;

    }
    else{

        $permalinkURL = get_permalink();

        $checkPermalinkURL = explode('?',$permalinkURL);

        if(@$checkPermalinkURL[1]){
            $cg_upload_forward_siteURL = $checkPermalinkURL[0]."?".$checkPermalinkURL[1];

            $siteURLsort = $checkPermalinkURL[0];
        }
        else{$cg_upload_forward_siteURL = $permalinkURL."?";}
        ?>
        <script>

            // makes better redirecting visual
            var htmlElement = document.getElementsByTagName("html")[0];
            htmlElement.remove();

            // funtzt nur so als vorher bestimmte variable
            var galeryID = <?php echo json_encode($galeryID);?>;
            var cg_upload_forward_siteURL = <?php echo json_encode($cg_upload_forward_siteURL);?>;

            // funtzt nur so als vorher bestimmte variable
            var redirectURL = ""+cg_upload_forward_siteURL+"&cg_upload=success&cg_id="+galeryID+"#cg_success";
            //alert(redirectURL);
            // similar behavior as an HTTP redirect
            window.location.replace(redirectURL);


        </script>
        <?php

    }

    echo "<br/>";

}
else{

    echo "Plz don't manipulate the upload.";

    ?>


    <script data-cg-processing="true">

        cgJsClass.gallery.upload.doneUploadFailed = true;
        cgJsClass.gallery.upload.failMessage = <?php echo json_encode("Plz don't manipulate the upload count.");?>;

    </script>

    <?php
    die;

}


?>