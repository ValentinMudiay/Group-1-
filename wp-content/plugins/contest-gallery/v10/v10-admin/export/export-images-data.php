<?php
if(!function_exists('cg_images_data_csv_export')){

    function cg_images_data_csv_export(){

        global $wpdb;

        $tablename = $wpdb->prefix . "contest_gal1ery";
        $tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
        $tablename_f_input = $wpdb->prefix . "contest_gal1ery_f_input";
        $table_posts = $wpdb->prefix."posts";
        $wpUsers = $wpdb->base_prefix . "users";
        $tablenameentries = $wpdb->prefix . "contest_gal1ery_entries";
        $contest_gal1ery_categories = $wpdb->prefix . "contest_gal1ery_categories";

        $GalleryID = $_GET['option_id'];

        $content_url = wp_upload_dir();
        $content_url = $content_url['baseurl']; // Pfad zum Bilderordner angeben

        $getFormFieldNames = 0;
        $emailFieldCsvNumber = '';
        $emailFieldId = '';
        $categoryFieldCsvNumber = '';
        $categoryTitle = '';

        $categories = $wpdb->get_results( "SELECT * FROM $contest_gal1ery_categories WHERE GalleryID = '$GalleryID' ORDER BY Field_Order DESC");
        $IsModernFiveStar = $wpdb->get_var( "SELECT IsModernFiveStar FROM $tablename_pro_options WHERE GalleryID = '$GalleryID'");
        $selectSQLall = $wpdb->get_results( "SELECT * FROM $tablename WHERE GalleryID = '$GalleryID' ORDER BY rowid DESC");
        $selectFormInput = $wpdb->get_results( "SELECT id, Field_Type, Field_Order, Field_Content FROM $tablename_f_input WHERE GalleryID = '$GalleryID' AND (Field_Type = 'fbt-f' OR Field_Type = 'fbd-f' OR Field_Type = 'url-f' OR Field_Type = 'check-f' OR Field_Type = 'text-f' OR Field_Type = 'comment-f' OR Field_Type ='email-f' OR Field_Type ='select-f' OR Field_Type ='selectc-f' OR Field_Type ='url-f' OR Field_Type ='date-f') ORDER BY Field_Order ASC" );

        if(count($categories)){

            $categoriesUidsNames = array();
            $categoriesUidsNames[0] = '';
            foreach ($categories as $category) {

                $categoriesUidsNames[$category->id] = $category->Name;

            }

        }

        $selectContentFieldArray = array();
        $selectFormIdArrayAndRow = array();
        $inputDateFieldIdsAndFormatArray = array();

     //   echo "<pre>";
    //        print_r($GalleryID);
    //    echo "</pre>";

     //   echo "<pre>";
     //       print_r($selectFormInput);
    //    echo "</pre>";

        foreach ($selectFormInput as $value) {

            // 1. Feld Typ
            // 2. ID des Feldes in F_INPUT
            // 3. Feld Reihenfolge
            // 4. Feld Content

            $selectFieldType = 	$value->Field_Type;
            $id = $value->id;// prim�re unique id der form wird auch gespeichert und sp�ter in entries inserted zur erkennung des verwendeten formular feldes
            $fieldOrder = $value->Field_Order;// Die originale Field order in f_input Tabelle. Zwecks Vereinheitlichung.
            if($selectFieldType!='selectc-f'){
                $selectContentFieldArray[] = $selectFieldType;
                $selectContentFieldArray[] = $id;
                $selectContentFieldArray[] = $fieldOrder;
                $selectContentField = unserialize($value->Field_Content);
                $selectContentFieldArray[] = $selectContentField["titel"];

                if($value->Field_Type=='date-f'){
                    $inputDateFieldIdsAndFormatArray[$id] = $selectContentField["format"];
                }

            }else{
                $selectContentField = unserialize($value->Field_Content);
                $categoryTitle = $selectContentField["titel"];
            }


        }

/*        echo "<pre>";

        print_r($selectContentFieldArray);

        echo "</pre>";

        die;*/
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
        $RecognitionMethod="RecognitionMethod";
        $UserIp="UserIp";
        $CookieId="CookieId";
        $WordPressUserId="WpUserId";
        $WordPressUserName="WpUserName";
        $WordPressUserEmail="WpUserEmail";
        $CountComments1="CountComments";
        $CountRatingOneStar ="CountRatingOneStar";
        $OneStarAddedByAdmin ="OneStarAddedByAdmin ";
        $CountRatingFiveStars="CountRatingFiveStars";
        $CumulatedRatingFiveStars="CumulatedRatingFiveStars";
        $FiveStarRatingCountOneStars = "FiveStarRatingCountOneStars";
        $FiveStarRatingCountTwoStars = "FiveStarRatingCountTwoStars";
        $FiveStarRatingCountThreeStars = "FiveStarRatingCountThreeStars";
        $FiveStarRatingCountFourStars = "FiveStarRatingCountFourStars";
        $FiveStarRatingCountFiveStars = "FiveStarRatingCountFiveStars";
        $FiveStarRatingCountOneStarsAddedByAdmin = "FiveStarRatingCountOneStarsAddedByAdmin";
        $FiveStarRatingCountTwoStarsAddedByAdmin = "FiveStarRatingCountTwoStarsAddedByAdmin";
        $FiveStarRatingCountThreeStarsAddedByAdmin = "FiveStarRatingCountThreeStarsAddedByAdmin";
        $FiveStarRatingCountFourStarsAddedByAdmin = "FiveStarRatingCountFourStarsAddedByAdmin";
        $FiveStarRatingCountFiveStarsAddedByAdmin = "FiveStarRatingCountFiveStarsAddedByAdmin";
        $AvarageRating1="AverageRatingFiveStars";
        $Active1="Active";
        $Informed1="Informed";

        $csvData[$i][$r]='note: manually added rating by administrator will be exported now';
        $i++;

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
        $csvData[$i][$r]=$RecognitionMethod;
        $r++;
        $csvData[$i][$r]=$UserIp;
        $r++;
        $csvData[$i][$r]=$CookieId;
        $r++;
        $csvData[$i][$r]=$WordPressUserId;
        $r++;
        $csvData[$i][$r]=$WordPressUserName;
        $r++;
        $csvData[$i][$r]=$WordPressUserEmail;
        $r++;
        $csvData[$i][$r]=$CountComments1;
        $r++;
        $csvData[$i][$r]=$CountRatingOneStar;
        $r++;
        $csvData[$i][$r]=$OneStarAddedByAdmin;
        $r++;
        $csvData[$i][$r]=$CountRatingFiveStars;
        $r++;
        $csvData[$i][$r]=$CumulatedRatingFiveStars;
        $r++;
        $csvData[$i][$r]=$AvarageRating1;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountOneStars;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountTwoStars;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountThreeStars;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountFourStars;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountFiveStars;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountOneStarsAddedByAdmin;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountTwoStarsAddedByAdmin;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountThreeStarsAddedByAdmin;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountFourStarsAddedByAdmin;
        $r++;
        $csvData[$i][$r]=$FiveStarRatingCountFiveStarsAddedByAdmin;
        $r++;
        $csvData[$i][$r]=$Active1;
        $r++;
        $csvData[$i][$r]=$Informed1;
        $r++;



        //Bestimmung der Spalten Namen


        if($n==0){

            foreach($selectContentFieldArray as $key => $formvalue){

                //	echo "<br>$i<br>";

                // 1. Feld Typ
                // 2. ID des Feldes in F_INPUT
                // 3. Feld Reihenfolge
                // 4. Feld Content


                if(@$formvalue=='check-f'){$fieldtype="cb"; $n=1; continue;}// Check Agreement
                if(@$fieldtype=="cb" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="cb" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=="cb" AND $n==3) {
                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;
                    $n=0;
                }

                if(@$formvalue=='date-f'){$fieldtype="dt"; $n=1; continue;}
                if(@$fieldtype=="dt" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="dt" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=="dt" AND $n==3) {
                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;

                }

                if(@$formvalue=='text-f'){$fieldtype="nf"; $n=1; continue;}
                if(@$fieldtype=="nf" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="nf" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=="nf" AND $n==3) {
                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;

                }

                if(@$formvalue=='email-f'){$fieldtype="ef";  $n=1; continue;}
                if(@$fieldtype=="ef" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="ef" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='ef' AND $n==3) {
                    $emailFieldId = $formFieldId;
                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $emailFieldCsvNumber = $r;

                    $r++;

                    $n=0;
                }

                if(@$formvalue=='comment-f'){$fieldtype="kf"; $n=1; continue;}
                if(@$fieldtype=="kf" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="kf" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='kf' AND $n==3) {

                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;
                }

                if(@$formvalue=='select-f'){$fieldtype="se"; $n=1; continue;}
                if(@$fieldtype=="se" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="se" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='se' AND $n==3) {

                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;
                }


                if(@$formvalue=='url-f'){$fieldtype="url"; $n=1; continue;}
                if(@$fieldtype=="url" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="url" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='url' AND $n==3) {

                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;
                }

                if(@$formvalue=='fbt-f'){$fieldtype="fbt"; $n=1; continue;}
                if(@$fieldtype=="fbt" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="fbt" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='fbt' AND $n==3) {

                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;
                }


                if(@$formvalue=='fbd-f'){$fieldtype="fbd"; $n=1; continue;}
                if(@$fieldtype=="fbd" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="fbd" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='fbd' AND $n==3) {

                    $csvData[$i][$r]="$formvalue";
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $r++;

                    $n=0;
                }


/*                if(@$formvalue=='selectc-f'){$fieldtype="sec"; $n=1; continue;}
                if(@$fieldtype=="sec" AND $n==1){$formFieldId=$formvalue; $n=2; continue;}
                if(@$fieldtype=="sec" AND $n==2){$fieldOrder=$formvalue; $n=3; continue;}
                if (@$fieldtype=='sec' AND $n==3) {
                    $selectFormIdArrayAndRow[$formFieldId] = $r;
                    $categoryTitle ="$formvalue";
                    $r++;
                    $n=0;
                }*/


            }

        }

        // Category Select always as last!!!!!!

        if(count($categories)){

            $csvData[$i][$r] = $categoryTitle;
            $categoryFieldCsvNumber = $r;// Keine Ahnung warum -1 :)
        }


        // Setting titles ended now starting setting values


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
            }
            else{
                $csvData[$i][$r]=''.$content_url.'/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType.'';
            }
            $r++;
            $CheckSetElse = (intval(str_replace('.','',$value->Version)) < 109830) ? '' : 'Admin backend upload';
            $csvData[$i][$r]= (!empty($value->CheckSet)) ? $value->CheckSet : $CheckSetElse;//plugin version 10.9.8.8.1 will be compared, CheckSet mightn ot be set before this version if RegUserUploadOnly==0.
            $r++;
            $csvData[$i][$r]= (!empty($value->IP)) ? $value->IP : 'will be tracked since plugin version 10.9.3.7';
            $r++;
            $csvData[$i][$r]= (!empty($value->CookieId)) ? $value->CookieId : '';
            $r++;
            if($value->WpUserId!=NULL && $value->WpUserId>0){
                $wpUserData=$wpdb->get_row("SELECT * FROM $wpUsers WHERE ID = '".$value->WpUserId."'");
                $csvData[$i][$r]=$wpUserData->ID;
            }
            else{
                $csvData[$i][$r]='';
            }
            $r++;
            if($value->WpUserId!=NULL && $value->WpUserId>0){
                $csvData[$i][$r]=$wpUserData->user_nicename;
            }
            else{
                $csvData[$i][$r]='';
            }
            $r++;
            if($value->WpUserId!=NULL && $value->WpUserId>0){
                $csvData[$i][$r]=$wpUserData->user_email;
            }
            else{
                $csvData[$i][$r]='';
            }
            $r++;
            $csvData[$i][$r]=$value->CountC;
            $r++;
            $csvData[$i][$r]=$value->CountS;
            $r++;
            $csvData[$i][$r]=$value->addCountS;
            $r++;
            $csvData[$i][$r]=$value->CountR;
            $r++;
            $csvData[$i][$r]=$value->Rating;
            $r++;

            if($value->Rating=='0' && $value->CountR=='0'){
                $averageStarsRounded = '0';
            }else{
                $averageStars = $value->Rating/$value->CountR;
                $averageStarsRounded = round($averageStars,2);
                //$averageStarsRounded = number_format($averageStarsRounded,2,',');
                $averageStarsRounded = (str_replace('.',',',strval($averageStarsRounded)));
                //$averageStarsRounded = sprintf("%.2f", $averageStarsRounded);
            }


            $csvData[$i][$r]=$averageStarsRounded;
            $r++;

            $csvData[$i][$r]=($IsModernFiveStar==1) ? $value->CountR1 : 'Convert to modern five star rating in "Edit options" >>> "Corrections and Improvements" to see this count';
            $r++;
            $csvData[$i][$r]=($IsModernFiveStar==1) ? $value->CountR2 : 'Convert to modern five star rating in "Edit options" >>> "Corrections and Improvements" to see this count' ;
            $r++;
            $csvData[$i][$r]=($IsModernFiveStar==1) ? $value->CountR3 : 'Convert to modern five star rating in "Edit options" >>> "Corrections and Improvements" to see this count';
            $r++;
            $csvData[$i][$r]=($IsModernFiveStar==1) ? $value->CountR4 : 'Convert to modern five star rating in "Edit options" >>> "Corrections and Improvements" to see this count';
            $r++;
            $csvData[$i][$r]=($IsModernFiveStar==1) ? $value->CountR5 : 'Convert to modern five star rating in "Edit options" >>> "Corrections and Improvements" to see this count';
            $r++;

            $csvData[$i][$r]=$value->addCountR1;
            $r++;
            $csvData[$i][$r]=$value->addCountR2;
            $r++;
            $csvData[$i][$r]=$value->addCountR3;
            $r++;
            $csvData[$i][$r]=$value->addCountR4;
            $r++;
            $csvData[$i][$r]=$value->addCountR5;
            $r++;

            $csvData[$i][$r]=$value->Active;
            $r++;
            $csvData[$i][$r]=$value->Informed;
            $r++;
            //       var_dump($r);

            $selectSQLentries = $wpdb->get_results( "SELECT * FROM $tablenameentries WHERE pid = '$pidCSV' ORDER BY Field_Order ASC");

            // ACHTUNG!!!! Leere Felder müssen gefüllt werden ansonsten erscheint der inhalt einfacher in der nächsten spalte und nicht in der richtigen
            // Schon ma vorab füllen!!!!
            foreach ($selectFormInput as $container) {

                //    var_dump($r);
                $csvData[$i][$r] = '';
                $r++;

            }

            if(!empty($selectSQLentries)){
                $mailInserted = false;
                foreach($selectSQLentries as $value_entries){

                    $fieldType = $value_entries->Field_Type;
                    //	echo $value_entries->Short_Text;

                    // $emailField = false;

                    if($fieldType=="email-f" && empty($WpUserId)){

                        //  $emailField = true;
                        //  var_dump('mailInsertedBefore');

                        //    var_dump($WpUserId);
                        $mailInserted= true;
                     //   var_dump('emailFieldCsvNumber');
                      //  var_dump($emailFieldCsvNumber);
                    //    var_dump($value_entries);
                        $csvData[$i][$emailFieldCsvNumber]=$value_entries->Short_Text;
                    }
                    else if($fieldType=="comment-f"){$csvData[$i][$selectFormIdArrayAndRow[$value_entries->f_input_id]]=$value_entries->Long_Text;}
                    else if($fieldType=="check-f"){$csvData[$i][$selectFormIdArrayAndRow[$value_entries->f_input_id]]=($value_entries->Checked==1) ? 'checked' : 'not checked';}
                    else if($fieldType=="date-f"){

                        $newDateTimeString = '';

                        if(!empty($value_entries->InputDate) && $value_entries->InputDate!='0000-00-00 00:00:00'){
                            $dtFormat = $inputDateFieldIdsAndFormatArray[$value_entries->f_input_id];
                            $dtFormat = str_replace('YYYY','Y',$dtFormat);
                            $dtFormat = str_replace('MM','m',$dtFormat);
                            $dtFormat = str_replace('DD','d',$dtFormat);

                            $newDateTimeObject = DateTime::createFromFormat("Y-m-d H:i:s",$value_entries->InputDate);

                            if(is_object($newDateTimeObject)){
                                $newDateTimeString = $newDateTimeObject->format($dtFormat);
                            }
                        }


/*                        echo "<br>";
                        echo "$dtFormat";
                        echo "<br>";
                        echo "$value_entries->InputDate";*/
                      //  echo "<br>";
                      //  echo $newDateTimeString;


                        $csvData[$i][$selectFormIdArrayAndRow[$value_entries->f_input_id]] = " $newDateTimeString";



                    }
                    else{
                      //  var_dump(3333);
                    //   var_dump($selectFormIdArrayAndRow[$value_entries->f_input_id]);
                        if($fieldType!="email-f"){
                            $csvData[$i][$selectFormIdArrayAndRow[$value_entries->f_input_id]]=$value_entries->Short_Text;
                        }

                    }


                }

            }

/*            if(!empty($emailFieldCsvNumber) && !empty($WpUserId)){
                var_dump('11111');

                $csvData[$i][$emailFieldCsvNumber]=$wpdb->get_var("SELECT user_email FROM $wpUsers WHERE ID = $WpUserId");

            }*/


            if(count($categories)){

               // $r++;
               $csvData[$i][$categoryFieldCsvNumber] = $categoriesUidsNames[$value->Category];

            }
            ksort($csvData[$i]);
         //   var_dump($csvData);
      //      die;
            $i++;
            $r=0;
        }

        //	print_r($csvData);

        /*	$list = array (
        array('aaa', 'bbb', 'ccc'),
        array('123', '456', '789')

    );*/

        // old logic as example. Do not remove
/*        $admin_email = get_option('admin_email');
        $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");

        $code = $wpdb->base_prefix; // database prefix
        $code = md5($code.$adminHashedPass);

        $filename = $code."_userdata.csv";*/


        $filename = "cg-images-data-gallery-id-$GalleryID.csv";

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");

        ob_start();

        $fp = fopen("php://output", 'w');
        fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        foreach ($csvData as $fields) {
            fputcsv($fp, $fields, ";");

        }
        fclose($fp);
        $masterReturn = ob_get_clean();
        echo $masterReturn;
        die();
    }
}

?>