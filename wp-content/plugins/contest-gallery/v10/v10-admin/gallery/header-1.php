<?php

//$GalleryID = @$_GET['option_id'];

echo "<div id='cgGalleryBackendContainer'>";
echo "<table style='border: thin solid black;background-color:#ffffff;margin-bottom:12px;' width='937px;' id='cgGalleryBackendDataManagement'>";
echo "<tr>";
echo "<td style='padding-left:20px;width:353px;position:relative;' colspan='2'>";
echo "<br/>Allowed file types: <b>Jpg, Png, Gif</b><br/>";

echo "<span style='position: relative;'>Maximum <b>upload_max_filesize</b> in your PHP configuration: <b>$upload_max_filesize MB</b> 
<span class=\"cg-info-icon\"><b><u>info</b></u></span>
 <span class=\"cg-info-container\" style=\"top: 22px;left: 365px;display: none;\">Maximum upload size per image<br><br>To increase in .htaccess file use:<br><b>php_value upload_max_filesize 10MB</b> (example, no equal to sign!)
 <br>To increase in php.ini file use:<br><b>upload_max_filesize = 10MB</b> (example, equal to sign required!)<br><br><b>Some server providers does not allow manually increase in files.<br>It has to be done in providers backend or they have to be contacted.</b></span>
 </span>";

echo "<span style='position: relative;'>Maximum <b>post_max_size</b> in your PHP configuration: <b>$post_max_size MB</b> 
<span class=\"cg-info-icon\"><b><u>info</b></u></span>
 <span class=\"cg-info-container\" style=\"top: 22px;left: 350px;display: none;\"><br>Describes the maximum size of a post which can be done when form submits.<br>
 Example: you try to upload 3 images with each 3MB and post_max_size is 6MB, then it will not work.<br><br>To increase in htaccess file use:<br><b>php_value post_max_size 10MB</b> (example, no equal to sign!)
 <br>To increase in php.ini file use:<br><b>post_max_size = 10MB</b> (example, equal to sign required!)<br><br><b>Some server providers does not allow manually increase in files.<br>It has to be done in providers backend or they have to be contacted.</b></span>
 </span>";


echo "<br/>Memory limit provided from your server provider: ";
if($memory_limit>=250){echo "<span style='color:green;font-weight:bold;'>$memory_limit MB</span>";}
if($memory_limit<250 && $memory_limit>=120){echo "<span style='color:orange;font-weight:bold;'>$memory_limit MB</span>";}
if($memory_limit<120 && $memory_limit!='-1'){echo "<span style='color:red;font-weight:bold;'>$memory_limit MB</span>";}
if($memory_limit=='-1'){echo "<span style='font-weight:bold;'>No memory limit set from server. Real memory limit unrecognizable.</span>";}
echo "<br>";

echo "<span style='position: relative;'>Maximum <b>max_input_vars</b> in your PHP configuration: ";
if($max_input_vars>=3000){echo "<span style='color:green;font-weight:bold;'>$max_input_vars</span>";}
if($max_input_vars<3000 && $max_input_vars>=1000){echo "<span style='color:orange;font-weight:bold;'>$max_input_vars</span>";}
if($max_input_vars<1000){echo "<span style='color:red;font-weight:bold;'>$max_input_vars</span>";}
echo " <span class=\"cg-info-icon\"><b><u>info</b></u></span>
 <span class=\"cg-info-container\" style=\"top: 22px;left: 350px;display: none;\">Important for how many information can be processed in backend<br><b>If 2000 and higher 50 pics per site can be shown in backend</b><br><br>To increase in htaccess file use:<br><b>php_value max_input_vars 2000</b> (example, no equal to sign!)
 <br>To increase in php.ini file use:<br><b>max_input_vars = 2000</b> (example, equal to sign required!)<br><br><b>Some server providers does not allow manually increase in files.<br>It has to be done in providers backend or they have to be contacted.</b></span>
 </span>";


if($cgVersion<7){
    echo "&nbsp;&nbsp;<a id='cg_server_power_info'><b><u>INFO</u></b></a></b>";
    ?>
    <div id="cg_answerPNG" style="position: absolute; margin-left: 135px; margin-top: 10px;width: 460px; background-color: white; border: 1px solid; padding: 5px; display: none;">
        Higher memory allows you to upload bigger images with higher resolution.<br>
        If you receive an error during upload like "Allowed memory size of ... exhausted",
        then try to upload same image in minor resolution.<br>
        ≈256 MB: good <br>
        ≈128 MB: average <br>
        ≈64 MB: poor <br></div>

    <?php
}

/*echo <<<HEREDOC
<form action="?page=contest-gallery/index.php&option_id=$GalleryID&edit_gallery=true" method="POST" enctype="multipart/form-data">
<input type="hidden" name="upload_pics" value="true" />
<input type="file" name="files[]" multiple />
<input type="submit" value="Upload" style='text-align:center;width:95px;'/><br/><br/>
</form>
HEREDOC;
*/

//add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );
$admin_url = admin_url();

echo '<input type="hidden" id="cg_gallery_id" value="'. $GalleryID .'">';
echo '<input type="hidden" id="cg_admin_url" value="'. $admin_url .'">';
echo "<div style='margin-top: 7px; height:35px;'>";

?>

    <!--<input type="number" value="" class="regular-text process_custom_images" id="process_custom_images" name="" max="10" min="1" step="10">-->
    <div style="display:inline;float:left;width:100px;"><button class="cg_upload_wp_images_button button cg_backend_button_gallery_action">Add Images</button><br/><br/></div>

<?php

$plugins_url = plugins_url();
echo "&nbsp;&nbsp;&nbsp;&nbsp;<img src='".$plugins_url."/contest-gallery/v10/v10-css/loading.gif' width='25px' style='display:none;margin-left: 261px !important;margin-top: -17px;' id='cg_uploading_gif'/>
      <div style='position:absolute;display:none;vertical-align:middle;height:28px !important;line-height:28px !important;margin-left: 190px !important;margin-bottom: 5px;' id='cg_uploading_div'>
      &nbsp;&nbsp;(adding images please wait)</div>";


echo "</div>";

echo "<div style='display:none;' id='cg_wp_upload_ids'></div>";
echo "<div id='cg_wp_upload_div'></div>";

if($cgVersion<7){
    echo "<div style='margin-bottom:15px;margin-top:15px;clear:both;'>What happens when adding images?&nbsp;<a id='cg_adding_images_info'><u>Read here...</u></a></b>";
    ?>
    <div id="cg_adding_images_answer" style="position: absolute; margin-left: 40px; margin-top: 10px;width: 510px; background-color: white; border: 1px solid; padding: 5px; display: none;z-index:500;">
        Every image will be converted to five different resolutions. From 300pixel to 1920pixel width.
        <br>Depending on screen width a suitable image will be selected by algorithm.
        <br>It brings faster loading performance for frontend users viewing your gallery.
        <br><br>Converting images can take some time, especially for images higher then 3MB.
        <br>In general it is recommended not to add more then 10 images at one go. </div>

    <?php
}

echo "</div>";


echo "</td>";

echo "<td align='center'><div>";




if(@$_POST['contest_gal1ery_post_create_data_csv']  or (@$_POST['chooseAction1'] == 4 and (@$_POST['informId']==true or @$_POST['resetInformId']==true))){
    //echo "works";

    die('please contact site administrator if you see this, code 273');

//print_r($selectContentFieldArray);

    $getFormFieldNames = 0;
    $emailFieldCsvNumber = '';
    $emailField = false;

    $selectSQLall = $wpdb->get_results( "SELECT * FROM $tablename WHERE GalleryID = '$GalleryID' ORDER BY rowid DESC");

    $csvData = array();

    $i=0;
    $r=0;
    $n=0;

    $GalleryID1="GalleryID";
    $id1="id";//ACHTUNG! Darf nicht Anfangen mit ID(Großgeschrieben I oder D am Anfang) in einer csv Datei, ansonsten ungültige SYLK Datei!
    $rowid1="rowid";
    $UploadDate1="UploadDate";
    $NamePic1="NamePic";
    $DownloadURL1="DownloadURL";
    $CountComments1="CountComments";
    $CountRatingOneStar ="CountRatingOneStar";
    $CountRatingFiveStars="CountRatingFiveStars";
    $CumulatedRatingFiveStars="CumulatedRatingFiveStars";
    $AvarageRating1="AverageRatingFiveStars";
    $Active1="Active";
    $Informed1="Informed";


    $csvData[$i][$r]=$GalleryID1;
    $r++;
    $csvData[$i][$r]=$id1;
    $r++;
    $csvData[$i][$r]=$rowid1;
    $r++;
    $csvData[$i][$r]=$UploadDate1;
    $r++;
    $csvData[$i][$r]=$NamePic1;
    $r++;
    $csvData[$i][$r]=$DownloadURL1;
    $r++;
    $csvData[$i][$r]=$CountComments1;
    $r++;
    $csvData[$i][$r]=$CountRatingOneStar;
    $r++;
    $csvData[$i][$r]=$CountRatingFiveStars;
    $r++;
    $csvData[$i][$r]=$CumulatedRatingFiveStars;
    $r++;
    $csvData[$i][$r]=$AvarageRating1;
    $r++;
    $csvData[$i][$r]=$Active1;
    $r++;
    $csvData[$i][$r]=$Informed1;
    $r++;




    //Bestimmung der Spalten Namen



    if($n==0){

        foreach($selectContentFieldArray as $key => $formvalue){

            // echo "<br>$i<br>";

            // 1. Feld Typ
            // 2. ID des Feldes in F_INPUT
            // 3. Feld Reihenfolge
            // 4. Feld Content



            if(@$formvalue=='text-f'){$fieldtype="nf"; $n=1; continue;}
            if(@$fieldtype=="nf" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
            if(@$fieldtype=="nf" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
            if (@$fieldtype=="nf" AND $n==3) {

                $csvData[$i][$r]="$formvalue";
                $r++;

                /* $getEntries = $wpdb->get_var( $wpdb->prepare(
       "
          SELECT Short_Text
          FROM $tablenameentries
          WHERE pid = %d and f_input_id = %d
       ",
       $id,$formFieldId
       ) );*/

                $n=0;

            }

            if(@$formvalue=='email-f'){$fieldtype="ef";  $n=1; continue;}
            if(@$fieldtype=="ef" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
            if(@$fieldtype=="ef" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
            if (@$fieldtype=='ef' AND $n==3) {

                $csvData[$i][$r]="$formvalue";
                $emailFieldCsvNumber = $r;
                $r++;
                $n=0;
            }

            if(@$formvalue=='comment-f'){$fieldtype="kf"; $n=1; continue;}
            if(@$fieldtype=="kf" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
            if(@$fieldtype=="kf" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
            if (@$fieldtype=='kf' AND $n==3) {

                $csvData[$i][$r]="$formvalue";
                $r++;
                $n=0;
            }


        }

    }

    $getFormFieldNames++;
    // Bestimmung der Feld-Inhalte
    $r = 0;
    $i++;
    foreach($selectSQLall as $value){

        $csvData[$i][$r]=$value->GalleryID;
        $r++;
        $csvData[$i][$r]=$value->id;
        $pidCSV=$value->id;
        $r++;
        $csvData[$i][$r]=$value->rowid;
        $r++;
        $uploadTime = date('m.d.Y H:i', $value->Timestamp);
        $csvData[$i][$r]=$uploadTime;
        $r++;
        $csvData[$i][$r]=$value->NamePic;
        $r++;
        $WpUserId = $value->WpUserId;
        if($value->WpUpload!=NULL && $value->WpUpload>0){
            $csvData[$i][$r]=$wpdb->get_var("SELECT guid FROM $table_posts WHERE ID = '".$value->WpUpload."'");
            $pictureUrl  = $csvData[$i][$r];
        }
        else{
            $csvData[$i][$r]=''.$content_url.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType.'';
        }
        $r++;
        $csvData[$i][$r]=$value->CountC;
        $r++;
        $csvData[$i][$r]=$value->CountS;
        $r++;
        $csvData[$i][$r]=$value->CountR;
        $r++;
        $csvData[$i][$r]=$value->Rating;
        $r++;
        @$averageStars = $value->Rating/$value->CountR;
        @$averageStarsRounded = round($averageStars,0);
        $csvData[$i][$r]=@$averageStars;
        $r++;

        $csvData[$i][$r]=$value->Active;
        $r++;
        $csvData[$i][$r]=$value->Informed;
        $r++;
        //       var_dump($r);

        $selectSQLentries = $wpdb->get_results( "SELECT * FROM $tablenameentries WHERE pid = '$pidCSV' ORDER BY Field_Order ASC");

        if(!empty($selectSQLentries)){
            $mailInserted = false;
            foreach($selectSQLentries as $value_entries){

                $fieldType = $value_entries->Field_Type;
                // echo $value_entries->Short_Text;


                // $emailField = false;


                if($fieldType=="email-f" && !empty($WpUserId)){

                    //  $emailField = true;
                    //  var_dump('mailInsertedBefore');

                    //    var_dump($mailInserted);

                    $mailInserted= true;

                    $csvData[$i][$r]=$wpdb->get_var("SELECT user_email FROM $wpUsers WHERE ID = $WpUserId");}
                else if($fieldType=="comment-f"){$csvData[$i][$r]=$value_entries->Long_Text;}
                else{$csvData[$i][$r]=$value_entries->Short_Text;}
                $r++;


            }

            if(!empty($emailFieldCsvNumber) && !empty($WpUserId) && $mailInserted==false){
                //     var_dump($i);
                //   var_dump($emailFieldCsvNumber);
                $csvData[$i][$emailFieldCsvNumber]=$wpdb->get_var("SELECT user_email FROM $wpUsers WHERE ID = $WpUserId");
            }
        }
        else{


            // ACHTUNG!!!! Leere Felder müssen gefüllt werden ansonsten erscheint der inhalt einfacher in der nächsten spalte und nicht in der richtigen
            //    var_dump($i);

            foreach ($selectFormInput as $container) {
                $r++;
                //    var_dump($r);
                $csvData[$i][$r] = '';

            }

            if(!empty($emailFieldCsvNumber) && !empty($WpUserId)){
                // Keine Ahnung warum :)
                $fieldNumber = $emailFieldCsvNumber+1;
                $csvData[$i][$fieldNumber]=$wpdb->get_var("SELECT user_email FROM $wpUsers WHERE ID = $WpUserId");

            }


        }



        $i++;
        $r=0;
    }

    // print_r($csvData);

    /* $list = array (
     array('aaa', 'bbb', 'ccc'),
     array('123', '456', '789')

 );*/

//print chr(255) . chr(254) . mb_convert_encoding($list, 'UTF-16LE', 'UTF-8');

    $admin_email = get_option('admin_email');
    $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");

    $code = $wpdb->base_prefix; // database prefix
    $code = md5($code.$adminHashedPass);

    $dir = plugin_dir_path( __FILE__ );
    $dir = $dir.$code."_userdata.csv";
    $filename = $code."_userdata.csv";
    //echo "$dir";
    //chmod($dir,0644);
    $fp = fopen($dir, 'w');
    fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
    foreach ($csvData as $fields) {
        fputcsv($fp, $fields, ";");
    }

    fclose($fp);
//$bloginfo = bloginfo("language");

    //$code = $wpdb->prefix; // database prefix
    // $code = md5($code);
    /*
       if (file_exists($dir)) {
       unlink($dir);
       }*/

    $userDataCSVsource = plugins_url( '/'.$code.'_userdata.csv', __FILE__ );



    //cg_action_create_zip($allPics,''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip');
    echo '<p style="text-align:center;width:180px;"><a href="'.$userDataCSVsource.'">Download csv file</a></p>';
    echo '<p style="text-align:center;width:180px;"><a href="?page=contest-gallery/index.php&option_id='.$GalleryID.'&delete_data_csv=true&edit_gallery=true">Delete csv file</a></p>';


}

else if (@$_POST['contest_gal1ery_create_zip']==true or (@$_POST['chooseAction1'] == 4 and (@$_POST['informId']==true or @$_POST['resetInformId']==true))) {


    $allPics=array();
    //$pfad = $_SERVER['DOCUMENT_ROOT'];
    $uploadFolder = wp_upload_dir();

    $pfad = $uploadFolder['basedir'];
    $pfad1 = $uploadFolder['url'];
    $baseurl = $uploadFolder['baseurl'];// Achtung! Unterschied zum pfad1 oben

    $is_ssl = false;
    if(is_ssl()){
        $is_ssl = true;
    }

    if($is_ssl){
        if(strpos($baseurl,'http://')===0){
            $baseurl = str_replace( 'http://', 'https://', $baseurl );
        }
    }else{
        if(strpos($baseurl,'https://')===0){
            $baseurl = str_replace( 'https://', 'http://', $baseurl );
        }
    }


    if(@$_POST['contest_gal1ery_create_zip']==true){

        $selectSQLall = $wpdb->get_results( "SELECT * FROM $tablename WHERE GalleryID = '$GalleryID'");
        //print_r($selectSQLall);
        foreach($selectSQLall as $value){

            if($value->WpUpload!=NULL && $value->WpUpload>0){
                $image_url = $wpdb->get_var("SELECT guid FROM $table_posts WHERE ID = '".$value->WpUpload."'");

                if($is_ssl){
                    if(strpos($image_url,'http://')===0){
                        $image_url = str_replace( 'http://', 'https://', $image_url );
                    }
                }else{
                    if(strpos($image_url,'https://')===0){
                        $image_url = str_replace( 'https://', 'http://', $image_url );
                    }
                }

                $check = explode($baseurl,$image_url);
                $dl_image_original = $pfad.$check[1];
            }
            else{
                $dl_image_original = $pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType.'';
            }

            //$imageGalery = $pfad.'/wp-content/uploads/contest-gallery/'.$value->ImageGalery;
            //$imageThumb = $pfad.'/wp-content/uploads/contest-gallery/'.$value->ImageThumb;
            $allPics[] = $dl_image_original;
            //$allPics[] = $imageGalery;
            //$allPics[] = $imageThumb;

        }
        //print_r($allPics);
    }


    if(@$_POST['chooseAction1'] == 4 and (@$_POST['informId']==true or @$_POST['resetInformId'])){

        //echo "2131242131243";

        $informId = @$_POST['informId'];
        $resetInformId = @$_POST['resetInformId'];

        $selectPICS = "SELECT * FROM $tablename WHERE ";

        //$wpdb->get_results( );

        foreach(@$informId as $key => $value){

            $selectPICS .= "id=$value or ";

        }

        foreach(@$resetInformId as $key => $value){

            $selectPICS .= "id=$value or ";

        }

        $selectPICS = substr($selectPICS,0,-4);

        //print_r($selectPICS);

        $selectPICSzip = $wpdb->get_results("$selectPICS");

        foreach($selectPICSzip as $value){
            $dl_image_original = $pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType.'';
            //$imageGalery = $pfad.'/wp-content/uploads/contest-gallery/'.$value->ImageGalery;
            //$imageThumb = $pfad.'/wp-content/uploads/contest-gallery/'.$value->ImageThumb;
            $allPics[] = $dl_image_original;
            //$allPics[] = $imageGalery;
            //$allPics[] = $imageThumb;
        }

    }


    $admin_email = get_option('admin_email');
    $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");

    $code = $wpdb->base_prefix; // database prefix
    $code = md5($code.$adminHashedPass);


    if (file_exists(''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip')) {
        unlink(''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip');
    }
    if(cg_action_create_zip($allPics,''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip')==false){
        die;
    }
    else{
        cg_action_create_zip($allPics,''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip');
    }

    $downloadZipFileLink = $pfad1.'/../../contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip';
    echo '<div class="cg_shortcode_parent" id="cgDeleteZipFileHintContainer">
<div class="cg_shortcode_copy cg_shortcode_copy_gallery cg_tooltip"></div>
<input type="hidden" class="cg_shortcode_copy_text" value="'.$downloadZipFileLink.'">

<p style="text-align:center;width:180px;" id="cgDeleteZipFileHint">
<span class="cg-info-icon">info</span>
    <span class="cg-info-container cg-info-container-gallery-user" style="display: none;"><strong>The generated zip file link is unique coded for your page</strong><br>
    You can use the zip file link for sharing<br>or<br>You can delete the zip file from server space</span>
<a href="'.$downloadZipFileLink.'">
<input type="submit" class="cg_backend_button cg_backend_button_general" value="Download zip file">
</a></p>';
    echo '<p style="text-align:center;width:180px;" ><form action="?page=contest-gallery/index.php&option_id='.$GalleryID.'&edit_gallery=true" style="text-align: left;" method="POST" class="cg_load_backend_submit" >
<input type="hidden" name="cg_delete_zip" value="true">
<input class="cg_backend_button cg_backend_button_back" type="submit" value="Delete zip file">
</form>
</p></div>';

}
else {

    if(!empty($_POST['cg_delete_zip'])){
        $admin_email = get_option('admin_email');
        $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");

        $code = $wpdb->base_prefix; // database prefix
        $code = md5($code.$adminHashedPass);
        $uploadFolder = wp_upload_dir();
        $pfad = $uploadFolder['basedir'];
        if(file_exists(''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip')){
            unlink(''.$pfad.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$code.'_images_download.zip');
        ?><script>alert('Zip file deleted');</script><?php
        }
    }

    if(!empty(['delete_data_csv'])){
        $admin_email = get_option('admin_email');
        $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");
        $code = $wpdb->base_prefix; // database prefix
        $code = md5($code.$adminHashedPass);
        $dir = plugin_dir_path( __FILE__ );
        $dir = $dir.$code."_userdata.csv";
        if(file_exists($dir)){
            unlink($dir);
            ?><script>alert('CSV data file deleted.');</script><?php
        }
    }

    echo "<form method='POST' action='?page=contest-gallery/index.php&option_id=$GalleryID&edit_gallery=true' class='cg_load_backend_submit'><input type='hidden' name='contest_gal1ery_create_zip' value='true' /><input class='cg_backend_button_gallery_action' type='submit' value='Zip all pictures' /></form></a>";
    echo "<br/>";
    echo "<form method='POST' action='?page=contest-gallery/index.php&option_id=$GalleryID&edit_gallery=true'><input type='hidden' name='contest_gal1ery_post_create_data_csv' value='true' /><input class='cg_backend_button_gallery_action' type='submit' value='Create data CSV' /></form></a>";
}
echo "</div></td>";

echo "<td align='center'><div>";

echo "<form method='POST' action='?page=contest-gallery/index.php&option_id=$GalleryID&edit_gallery=true' class='cg_load_backend_submit cg_load_backend_submit_form_submit'>
<input type='submit' class='cg_backend_button_gallery_action' value='Reset all informed' />";
echo "<input type='hidden'  name='reset_all' value='true'>";
echo "</form></a>";

echo "</div></td>";


echo "</tr>";

echo "</table>";

///////////// SHOW Pictures of certain galery





?>