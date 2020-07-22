<noscript>
    <div style="border: 1px solid purple; padding: 10px">
        <span style="color:red">Enable JavaScript to use the form</span>
    </div>
</noscript>
<?php
if(!defined('ABSPATH')){exit;}

if(!empty($_GET["cg_upload"])){

    global $wpdb;

    $galeryID = @$_GET["cg_id"];
    $contest_gal1ery_options_input = $wpdb->prefix . "contest_gal1ery_options_input";
    $inputOptionsSQL = $wpdb->get_row( "SELECT * FROM $contest_gal1ery_options_input WHERE GalleryID='$galeryID'");

    $Confirmation_Text = $inputOptionsSQL->Confirmation_Text;
    $Confirmation_Text = html_entity_decode(stripslashes(nl2br($Confirmation_Text)));
    echo "<div id='cg_success'>";
    echo $Confirmation_Text;
    echo "</div>";

    ?>

    <script>
        cgJsFrontendArea = true;

        location.href = "#cg_success";

        window.history.replaceState({}, document.title, location.protocol + '//' + location.host + location.pathname);

    </script>

    <?php


    if($inputOptionsSQL->ShowFormAfterUpload){
        unset($_GET["cg_upload"]);//!Important, otherwise recursion.
        include('users-upload.php');
    }


}
else if(isset($_POST['cg_form_submit'])){

    include('users-upload-check.php');

}
else{


    ?>

    <script>

        cgJsFrontendArea = true;

    </script>

    <?php

    include(__DIR__ ."/../../../check-language.php");



// Ermitteln der maximalen UploadSize
//$get_max_post = (int)(ini_get('post_max_size'));
    $get_max_post = (int)(ini_get('upload_max_filesize'));

    $post_max_sizeMB = $get_max_post.'MB';

    $max_post = $get_max_post.'m';

    //$upload_mb = min(@$max_upload, @$max_post, @$memory_limit);

    $memory_limit = (int)(ini_get('memory_limit'));


    extract( shortcode_atts( array(
        'id' => ''
    ), $atts ) );
    $galeryID = trim($atts['id']);


//echo "$galeryID";

//echo "GaleryID: $galeryID<br/>";


    global $wpdb;

    $tablename = $wpdb->prefix . "contest_gal1ery";
    $tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
    $tablenameFormInput = $wpdb->prefix . "contest_gal1ery_f_input";
    $tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
    $tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";

    $tablename_categories = $wpdb->prefix . "contest_gal1ery_categories";

    $categories = $wpdb->get_results( "SELECT * FROM $tablename_categories WHERE GalleryID = '$galeryID' ORDER BY Field_Order ASC");
    $FeControlsStyle = $wpdb->get_var( "SELECT FeControlsStyle FROM $tablename_options_visual WHERE GalleryID = '$galeryID'");

    //echo "tablenameOptions: $tablenameOptions<br/>";
    //echo "tablenameFormInput: $tablenameFormInput<br/>";
    //echo "GaleryID: $galeryID<br/>";

    $picsSQL1 = $wpdb->get_row( "SELECT * FROM $tablenameOptions WHERE id='$galeryID'");

    if($picsSQL1==NULL){
        echo "Please check your shortcode. The id does not exists.<br>";
    }
    else{

        $getUploadForm = $wpdb->get_results("SELECT * FROM $tablenameFormInput WHERE GalleryID='$galeryID'  && Active='1' ORDER BY Field_Order ASC");

        $proOptions = $wpdb->get_row("SELECT * FROM $tablename_pro_options WHERE GalleryID='$galeryID'");

        //print_r($getUploadForm);

        //$MemoryLimit = intval($picsSQL1->MemoryLimit);

        if(!function_exists('formatBytes2')){function formatBytes2($bytes, $precision = 2) {
            $units = array('B', 'KB', 'MB', 'GB', 'TB');

            $bytes = max($bytes, 0);
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);

            $bytes /= pow(1024, $pow);

            return round($bytes, $precision) . ' ' . $units[$pow];
        }

        }

        if(!function_exists('return_bytes1')){
            function return_bytes1($val) {
                $val = intval(trim($val));
                $last = strtolower($val[strlen($val)-1]);
                switch($last) {
                    // The 'G' modifier is available since PHP 5.1.0
                    case 'g':
                        $val *= 1024;
                        break;
                    case 'm':
                        $val *= 1024;
                        break;
                    case 'k':
                        $val *= 1024;
                        break;
                }

                return $val;
            }
        }

        //echo "Return Bytes: <br>";
        //echo return_bytes1($max_post);
        //echo "<br>";



        $max_post = return_bytes1($max_post);

        //echo "<br>max_post: $max_post<br>";

        //echo "<br/>Post Max Size: $post_max_size<br/>";

        $memoryPeak = intval(formatBytes2(memory_get_peak_usage(),2));

        //echo "<br/>";
        //echo formatBytes2(memory_get_peak_usage(),2);
        //echo "<br/>";

        //$maxMemory = $MemoryLimit-$MemoryLimit/100*16-$memoryPeak;

       // $maxMemory = $MemoryLimit-$MemoryLimit/100*16-$memoryPeak;

        // Ermitteln der maximalen Aufl�sung der einzelnen Formate


        //print_r($MaxRes);

        /* aktuelle MaxRes Options

        $maxRes = array();
        $maxRes[] = '';//JPG
        $maxRes[] = 'JPG';
        $maxRes[] = '';
        $maxRes[] = 1;//PNG
        $maxRes[] = 'PNG';
        $maxRes[] = '';
        $maxRes[] = 1;//GIF
        $maxRes[] = 'GIF';
        $maxRes[] = '';

        */

        $ContestEnd = intval($picsSQL1->ContestEnd);
        $ContestEndTime = intval($picsSQL1->ContestEndTime);

        @$MaxResJPGon = intval($picsSQL1->MaxResJPGon);
        @$MaxResPNGon = intval($picsSQL1->MaxResPNGon);
        @$MaxResGIFon = intval($picsSQL1->MaxResGIFon);

        @$MaxResJPGwidth = intval($picsSQL1->MaxResJPGwidth);
        @$MaxResJPGheight = intval($picsSQL1->MaxResJPGheight);
        @$MaxResPNGwidth = intval($picsSQL1->MaxResPNGwidth);
        @$MaxResPNGheight = intval($picsSQL1->MaxResPNGheight);
        @$MaxResGIFwidth = intval($picsSQL1->MaxResGIFwidth);
        @$MaxResGIFheight = intval($picsSQL1->MaxResGIFheight);

        @$ContestEnd = $picsSQL1->ContestEnd;
        @$ContestEndTime = $picsSQL1->ContestEndTime;
        @$cgVersion = $picsSQL1->Version;


        //echo "<br>ContestEnd: $ContestEnd<br>";
        //echo "<br>ContestEndTime: $ContestEndTime<br>";


        $ActivatePostMaxMB = $wpdb->get_var("SELECT ActivatePostMaxMB FROM $tablenameOptions WHERE id = '$galeryID'");
        //echo "ActivatePostMaxMB: $ActivatePostMaxMB <br>";
        if($ActivatePostMaxMB==1){
            $PostMaxMB = $wpdb->get_var("SELECT PostMaxMB FROM $tablenameOptions WHERE id = '$galeryID'");
        }
        else{
            $PostMaxMB=$get_max_post;
        }
        //echo "PostMaxMB: $PostMaxMB <br>";


        $ActivateBulkUpload = $wpdb->get_var("SELECT ActivateBulkUpload FROM $tablenameOptions WHERE id = '$galeryID'");

        if($ActivateBulkUpload==1){
            $SingleBulkUploadConfiguration = "name='data[]' multiple";
        }
        else{
            $SingleBulkUploadConfiguration = "name='data[]' ";
        }


        $BulkUploadQuantity = $wpdb->get_var("SELECT BulkUploadQuantity FROM $tablenameOptions WHERE id = '$galeryID'");
        $BulkUploadMinQuantity = $wpdb->get_var("SELECT BulkUploadMinQuantity FROM $tablenameOptions WHERE id = '$galeryID'");

        echo "<input type='hidden' value='$MaxResJPGon' id='restrictJpg' />";
        echo "<input type='hidden' value='$MaxResJPGwidth' id='MaxResJPGwidth' />";
        echo "<input type='hidden' value='$MaxResJPGheight' id='MaxResJPGheight' />";
        echo "<input type='hidden' value='$MaxResPNGon' id='restrictPng' />";
        echo "<input type='hidden' value='$MaxResPNGwidth' id='MaxResPNGwidth' />";
        echo "<input type='hidden' value='$MaxResPNGheight' id='MaxResPNGheight' />";
        echo "<input type='hidden' value='$MaxResGIFon' id='restrictGif' />";
        echo "<input type='hidden' value='$MaxResGIFwidth' id='MaxResGIFwidth' />";
        echo "<input type='hidden' value='$MaxResGIFheight' id='MaxResGIFheight' />";
        echo "<input type='hidden' value='$get_max_post' id='cg_shortcode_upload_form_upload_max_filesize' />";
        echo "<input type='hidden' value='$PostMaxMB' id='cg_shortcode_upload_form_upload_max_filesize_user_config' />";


        echo "<input type='hidden' value='$ActivateBulkUpload' id='ActivateBulkUpload' />";


        echo "<input type='hidden' id='cg_ContestEndTime' value='".@$ContestEndTime."'>";
        echo "<input type='hidden' id='cg_ContestEnd' value='".@$ContestEnd."'>";
        echo "<input type='hidden' id='cg_photo_contest_over' value='$language_ThePhotoContestIsOver.'>";



        //echo "$ContestEndTime";


        echo "<input type='hidden' value='$BulkUploadQuantity' id='BulkUploadQuantity' />";
        echo "<input type='hidden' value='$BulkUploadMinQuantity' id='BulkUploadMinQuantity' />";


        //echo "<br/>MaxResolutionJPG: $maxResJpg<br/>";
        //echo "<br/>MaxResolutionPNG: $maxResPng<br/>";
        //echo "<br/>MaxResolutionGIF: $maxResGif<br/>";


        /*

        // Maximaler m�gliche Aufl�sung f�r JPG Bilder

        if ($maxMemory < 34) {$maxResJPG = 1000000; }
        elseif ($maxMemory < 38) {$maxResJPG = 2000000; }
        elseif ($maxMemory < 43) {$maxResJPG = 3000000; }
        elseif ($maxMemory < 48) {$maxResJPG = 4000000; }
        elseif ($maxMemory < 53) {$maxResJPG = 5000000; }
        elseif ($maxMemory < 57) {$maxResJPG = 6000000; }
        elseif ($maxMemory < 59) {$maxResJPG = 6250000; }
        elseif ($maxMemory < 62) {$maxResJPG = 7000000; }

        // Maximaler m�gliche Aufl�sung f�r PNG Bilder

        if ($maxMemory < 37) {$maxResPNG = 1000000; }
        elseif ($maxMemory < 44) {$maxResPNG = 2000000; }
        elseif ($maxMemory < 52) {$maxResPNG = 3000000; }
        elseif ($maxMemory < 59) {$maxResPNG = 4000000; }
        elseif ($maxMemory < 72) {$maxResPNG = 5000000; }
        elseif ($maxMemory < 75) {$maxResPNG = 6000000; }
        elseif ($maxMemory < 77) {$maxResPNG = 6250000; } */


        /*
        <noscript>
        <div style="border: 1px solid purple; padding: 10px">
        <span style="color:red">You have to activate JavaScript to use the form</span>
        </div>
        </noscript>	*/

        $is_user_logged_in = is_user_logged_in();

        if(!isset($_POST['cg_form_submit'])){

/*            ob_start();

            $formOutput = ob_get_clean();*/

            if(@$proOptions->RegUserUploadOnly==1 && $is_user_logged_in==false){
                echo "<div>".contest_gal1ery_convert_for_html_output(@$proOptions->RegUserUploadOnlyText)."</div>";
            }
            else{

                include('users-upload-form.php');

            }
        }
        //echo "$language_MaximumAllowedWidthForJPGsIs";
        echo "<input type='hidden' id='cg_show_upload' value='1'>";

        echo "<input type='hidden' id='contest_gal1ery_upload_version' value='$cgVersion'/>";


        //echo "language_ThisFileTypeIsNotAllowed: $language_ThisFileTypeIsNotAllowed";
        echo "<input type='hidden' id='cg_file_not_allowed' value='$language_ThisFileTypeIsNotAllowed'>";
        echo "<input type='hidden' id='cg_file_size_to_big' value='$language_TheFileYouChoosedIsToBigMaxAllowedSize'>";
        echo "<input type='hidden' id='cg_post_size' value='$post_max_sizeMB'>";

        echo "<input type='hidden' id='cg_to_high_resolution' value='$language_TheResolutionOfThisPicIs'>";

        echo "<input type='hidden' id='cg_max_allowed_resolution_jpg' value='$language_MaximumAllowedResolutionForJPGsIs'>";
        echo "<input type='hidden' id='cg_max_allowed_width_jpg' value='$language_MaximumAllowedWidthForJPGsIs'>";
        echo "<input type='hidden' id='cg_max_allowed_height_jpg' value='$language_MaximumAllowedHeightForJPGsIs'>";

        echo "<input type='hidden' id='cg_max_allowed_resolution_png' value='$language_MaximumAllowedResolutionForPNGsIs'>";
        echo "<input type='hidden' id='cg_max_allowed_width_png' value='$language_MaximumAllowedWidthForPNGsIs'>";
        echo "<input type='hidden' id='cg_max_allowed_height_png' value='$language_MaximumAllowedHeightForPNGsIs'>";

        echo "<input type='hidden' id='cg_max_allowed_resolution_gif' value='$language_MaximumAllowedResolutionForGIFsIs'>";
        echo "<input type='hidden' id='cg_max_allowed_width_gif' value='$language_MaximumAllowedWidthForGIFsIs'>";
        echo "<input type='hidden' id='cg_max_allowed_height_gif' value='$language_MaximumAllowedHeightForGIFsIs'>";


        echo "<input type='hidden' id='cg_check_agreement' value='$language_YouHaveToCheckThisAgreement '>";
        echo "<input type='hidden' id='cg_check_email_upload' value='$language_EmailAdressHasToBeValid'>";
        echo "<input type='hidden' id='cg_min_characters_text' value='$language_MinAmountOfCharacters'>";
        echo "<input type='hidden' id='cg_max_characters_text' value='$language_MaxAmountOfCharacters'>";
        echo "<input type='hidden' id='cg_no_picture_is_choosed' value='$language_ChooseYourImage'>";

        echo "<input type='hidden' id='cg_language_BulkUploadQuantityIs' value='$language_BulkUploadQuantityIs'>";
        echo "<input type='hidden' id='cg_language_BulkUploadLowQuantityIs' value='$language_BulkUploadLowQuantityIs'>";

        echo "<input type='hidden' id='cg_language_PleaseFillOut' value='$language_PleaseFillOut'>";
        echo "<input type='hidden' id='cg_language_youHaveNotSelected' value='$language_youHaveNotSelected'>";

        echo "<input type='hidden' id='cg_language_pleaseConfirm' value='$language_pleaseConfirm'>";
        echo "<input type='hidden' id='cg_language_URLnotValid' value='$language_URLnotValid'>";
        echo "<input type='hidden' id='cg_ThePhotoContestIsOver_dialog' value='$language_ThePhotoContestIsOver'>";
        echo "<input type='hidden' id='cg_language_MaximumAmountOfUploadsIs' value='$language_MaximumAmountOfUploadsIs'>";


    }



}



?>