<?php
// 1. ID
// 2. Feldreihenfolge
// 3. Feldart
// 4. Content
/*echo "<pre>";

print_r($content);

echo "</pre>";*/

if (!empty($content)) {

    //echo "<br>content";

    // 1. Title des Feldes
    // 2. ID des Feldes in F_INPUT
    // 3. Feld Reihenfolge
    // 4. Feld Typ
    // 5. Feld Content 'short-text' oder 'long-text' oder 'date-f'


// TEST HERE

    /*
     *
    $querySETrow = 'UPDATE ' . $tablename . ' SET rowid = CASE id ';
    	$querySETaddRow = ' ELSE rowid END WHERE id IN (';


    // UPDATE ROW
    $querySETrow .= " WHEN $key THEN $value";
    $querySETaddRow .= "$key,";

    }

    $querySETaddRow = substr($querySETaddRow,0,-1);
    $querySETaddRow .= ")";

	$querySETrow .= $querySETaddRow;
    $updateSQL = $wpdb->query($querySETrow);


    */


// TEST HERE !!!!!!!!!

    $querySETrow = 'UPDATE ' . $tablenameentries . ' SET Short_Text = CASE';
    $querySETaddRow = ' ELSE Short_Text END WHERE (pid,f_input_id) IN (';

    $querySETrowLongText = 'UPDATE ' . $tablenameentries . ' SET Long_Text = CASE';
    $querySETaddRowLongText = ' ELSE Long_Text END WHERE (pid,f_input_id) IN (';

    $querySETrowInputDate = 'UPDATE ' . $tablenameentries . ' SET InputDate = CASE';
    $querySETaddRowInputDate = ' ELSE InputDate END WHERE (pid,f_input_id) IN (';

    /*
        "UPDATE wp_contest_gal1ery SET
    rowid = CASE id WHEN 26957 THEN 26957 WHEN 1387 THEN 1387 WHEN 1386 THEN 1386 WHEN 1385 THEN 1385 WHEN 74 THEN 74 WHEN 10 THEN 10 WHEN 9 THEN 9 WHEN 8 THEN 8 WHEN 7 THEN 7 WHEN 6 THEN 6
     ELSE rowid END WHERE id IN (26957,1387,1386,1385,74,10,9,8,7,6)";*/

    $isSetShortText = false;
    $isSetLongText = false;
    $isSetInputDate = false;
    $imagesInfoArray = array();
/*    echo "<pre>";

    print_r($content);

    echo "</pre>";


    echo "<br>";
    echo 'fieldsForSaveContentArray';
    echo "<br>";

    echo "<pre>";

    print_r($fieldsForSaveContentArray);

    echo "</pre>";*/

    foreach($content as $key => $arrayValue){

        //       if(@$_POST['chooseAction1']==2 or @$_POST['chooseAction1']==3){
        // wenn 2 oder 3, wurden die Activate zum deaktivieren oder löschen verwendet und können aus rows rausgenommen werden
        //  if(!empty($activate)){

        //  if(!empty($activate[$id])){
        //   continue;
        //    }

        //  }

        //   }

        //reset Array first
        $imageInfoArray = array();
        $i = 0;


        foreach($arrayValue as $arrayKey => $value){

            /*                            echo "value";
                                        echo "<pre>";
                                        print_r($value);
                                        echo "</pre>";*/

            // 2. Bild-ID und Uniuqe Form ID
            $imageId=intval($key);

            // 3. ID des Feldes in F_INPUT
            $formFieldId=$arrayKey;
            $imageInfoArray[$formFieldId] = array();

            // 4. Feldreihenfolge
            $field_order=$fieldsForSaveContentArray[$formFieldId]['Field_Order'];

            // 5. Feldart
            $field_type = $fieldsForSaveContentArray[$formFieldId]['Field_Type'];
            $imageInfoArray[$formFieldId]['field-type'] = $field_type;

            $imageInfoArray[$formFieldId]['field-title'] = $fieldsForSaveContentArray[$formFieldId]['Field_Title'];

            $imageInfoArray[$formFieldId]['field-content'] = '';

            // !IMPORTANT HERE TO RESET
            $field_content = '';

            // 6. Content
            if (($field_type=='text-f' OR $field_type=='email-f' OR $field_type=='select-f' OR $field_type=='url-f') && array_key_exists('short-text',$value)){
                $field_content = stripslashes($value['short-text']);
                $field_content = sanitize_text_field(htmlspecialchars($field_content, ENT_QUOTES, 'UTF-8'));
                $checkEntries = $wpdb->get_var("SELECT COUNT(*) as NumberOfRows FROM $tablenameentries WHERE pid = '$imageId' AND f_input_id = '$formFieldId' LIMIT 1");

                $imageInfoArray[$formFieldId]['field-content'] = $field_content;
                $imageInfoArray[$formFieldId]['to-update'] = true;

                if(!$checkEntries){

                    $wpdb->query( $wpdb->prepare(
                        "
									INSERT INTO $tablenameentries
									( id, pid, f_input_id, GalleryID, 
									Field_Type, Field_Order, Short_Text, Long_Text)
									VALUES ( %s,%d,%d,%d,
									%s,%d,%s,%s ) 
								",
                        '',$imageId,$formFieldId,$GalleryID,
                        $field_type,$field_order,$field_content,''
                    ) );

                    if(!empty($formFieldId)){
                        $isSetShortText = true;
                    }

                }


                if($checkEntries){

                    if(!empty($formFieldId)){

                        $isSetShortText = true;

                        $querySETrow .= " WHEN (pid = $imageId && f_input_id = $formFieldId ) THEN '$field_content'";
                        $querySETaddRow .= "($imageId,$formFieldId), ";
                    }


                }


            }

            // 5. Content
            if (($field_type=='comment-f') && array_key_exists('long-text',$value)) {

                $field_content = stripslashes($value['long-text']);
                $field_content = nl2br(htmlspecialchars($field_content, ENT_QUOTES, 'UTF-8'));
                $field_content = $sanitize_textarea_field($field_content);

                $imageInfoArray[$formFieldId]['field-content'] = $field_content;
                $imageInfoArray[$formFieldId]['to-update'] = true;


                $checkEntries = $wpdb->get_var("SELECT COUNT(*) as NumberOfRows FROM $tablenameentries WHERE pid = '$imageId' AND f_input_id = '$formFieldId' LIMIT 1");
                /*                                echo "<pre>";
                                                print_r('insert comment');
                                                print_r($field_content);
                                                echo "</pre>";*/
                if(!$checkEntries){

                    $wpdb->query( $wpdb->prepare(
                        "
									INSERT INTO $tablenameentries
									( id, pid, f_input_id, GalleryID, 
									Field_Type, Field_Order, Short_Text, Long_Text)
									VALUES ( %s,%d,%d,%d,
									%s,%d,%s,%s ) 
								",
                        '',$imageId,$formFieldId,$GalleryID,
                        $field_type,$field_order,'',$field_content
                    ) );

                    if(!empty($formFieldId)){
                        $isSetLongText = true;
                    }

                }

                if($checkEntries){

                    if(!empty($formFieldId)){

                        $isSetLongText = true;

                        $querySETrowLongText .= " WHEN (pid = $imageId && f_input_id = $formFieldId ) THEN '$field_content'";
                        $querySETaddRowLongText .= "($imageId,$formFieldId), ";
                    }

                    /*                    $wpdb->update(
                                            "$tablenameentries",
                                            array(
                                                'Long_Text' => "$field_content"
                                            ),
                                            array( 'f_input_id' => $formFieldId ),
                                            array( '%s'	),
                                            array( '%d' )
                                        );*/

                }


            }

            // 5. Content date-f
            if (($field_type=='date-f') && array_key_exists('date-field',$value)) {

                $field_content = stripslashes($value['date-field']);
                $field_content = nl2br(htmlspecialchars($field_content, ENT_QUOTES, 'UTF-8'));
                $field_content = $sanitize_textarea_field($field_content);

                $imageInfoArray[$formFieldId]['field-content'] = $field_content;
                $imageInfoArray[$formFieldId]['to-update'] = true;

                $checkEntries = $wpdb->get_var("SELECT COUNT(*) as NumberOfRows FROM $tablenameentries WHERE pid = '$imageId' AND f_input_id = '$formFieldId' LIMIT 1");
/*                                                echo "<pre>";
                                                print_r($fieldsForSaveContentArray);
                                                echo "</pre>";*/

                $newDateTimeString = '0000-00-00 00:00:00';

              //  var_dump($field_content);

                try {

                    $dtFormat = $fieldsForSaveContentArray[$formFieldId]['Field_Format'];

                 //   var_dump($dtFormat);


                    $dtFormat = str_replace('YYYY','Y',$dtFormat);
                    $dtFormat = str_replace('MM','m',$dtFormat);
                    $dtFormat = str_replace('DD','d',$dtFormat);

                    $newDateTimeObject = DateTime::createFromFormat("$dtFormat H:i:s","$field_content 00:00:00");
                    if(is_object($newDateTimeObject)){
                        $newDateTimeString = $newDateTimeObject->format("Y-m-d H:i:s");
                    }
                }catch (Exception $e) {

                    $newDateTimeString = '0000-00-00 00:00:00';

                }

              //  var_dump($newDateTimeString);

                if(!$checkEntries){

                    $wpdb->query( $wpdb->prepare(
                        "
									INSERT INTO $tablenameentries
									( id, pid, f_input_id, GalleryID, 
									Field_Type, Field_Order, Short_Text, Long_Text, InputDate)
									VALUES ( %s,%d,%d,%d,
									%s,%d,%s,%s,%s ) 
								",
                        '',$imageId,$formFieldId,$GalleryID,
                        $field_type,$field_order,'','',$newDateTimeString
                    ) );

                    if(!empty($formFieldId)){
                        $isSetInputDate = true;
                    }

                }

                if($checkEntries){

                    if(!empty($formFieldId)){

                        $isSetInputDate = true;

                        $querySETrowInputDate .= " WHEN (pid = $imageId && f_input_id = $formFieldId ) THEN '$newDateTimeString'";
                        $querySETaddRowInputDate .= "($imageId,$formFieldId), ";
                    }

                    /*                    $wpdb->update(
                                            "$tablenameentries",
                                            array(
                                                'Long_Text' => "$field_content"
                                            ),
                                            array( 'f_input_id' => $formFieldId ),
                                            array( '%s'	),
                                            array( '%d' )
                                        );*/

                }


            }


            if(!in_array($formFieldId,$fieldsForFrontendArray)){
                unset($imageInfoArray[$formFieldId]);
            }

            $i++;

        }


        // rowid aufbau
        // row[$id][$Active]
        // nur dann inserten, wenn active ist!!!!
        // key($rowids[$imageId])==1 bedeutet, dass es schon aktiviert war und jetzt hier nochmal geschickt wird einfach
        // beutet, dass es jetzt gerade aktiviert wird!!!! !empty($activate[$imageId])

/*        echo "<br>";
        echo 'debug here';
        echo "<br>";

        var_dump($rowids);
        var_dump($imageId);
        var_dump($isSetShortText);
        var_dump($isSetLongText);
        var_dump($isSetInputDate);
        var_dump($activate[$imageId]);
        var_dump($chooseAction1);*/


        if((key($rowids[$imageId])==1 && ($isSetShortText OR $isSetLongText OR $isSetInputDate)) or (!empty($activate[$imageId]) && $chooseAction1==1)){

            if(file_exists($jsonUploadImageInfoDir.'/image-info-'.$imageId.'.json')){

                $jsonFile = $jsonUploadImageInfoDir.'/image-info-'.$imageId.'.json';
                $fp = fopen($jsonFile, 'r');
                $imageInfoFileDataArray = json_decode(fread($fp, filesize($jsonFile)),true);
                fclose($fp);

                foreach ($imageInfoArray as $f_input_id => $imageInfoValuesArray){
                    if(array_key_exists('to-update',$imageInfoValuesArray)){
                        $imageInfoFileDataArray[$f_input_id] = $imageInfoValuesArray;
                        unset($imageInfoArray[$f_input_id]['to-update']);
                    }
                }
                $imagesInfoArray[$imageId] = $imageInfoFileDataArray;

            }else{
                foreach ($imageInfoArray as $f_input_id => $imageInfoValuesArray){
                    if(!array_key_exists('to-update',$imageInfoValuesArray)){
                        unset($imageInfoArray[$f_input_id]);
                    }else{
                        unset($imageInfoArray[$f_input_id]['to-update']);
                    }
                }
                $imageInfoFileDataArray = $imageInfoArray;
                $imagesInfoArray[$imageId] = $imageInfoFileDataArray;

            }

            $jsonUploadImageInfoFile = $jsonUploadImageInfoDir.'/image-info-'.$imageId.'.json';
            $fp = fopen($jsonUploadImageInfoFile, 'w');
            fwrite($fp, json_encode($imageInfoFileDataArray));
            fclose($fp);

        }

    }


    // for short text
    if($isSetShortText){
        $querySETaddRow = substr($querySETaddRow,0,-2);
        $querySETaddRow .= ")";

        $querySETrow .= $querySETaddRow;

        $wpdb->query($querySETrow);
    }


    // for long text
    if($isSetLongText){
        $querySETaddRowLongText = substr($querySETaddRowLongText,0,-2);
        $querySETaddRowLongText .= ")";

        $querySETrowLongText .= $querySETaddRowLongText;

        $wpdb->query($querySETrowLongText);
    }

    // for date field
    if($isSetInputDate){
        $querySETaddRowInputDate = substr($querySETaddRowInputDate,0,-2);
        $querySETaddRowInputDate .= ")";

        $querySETrowInputDate .= $querySETaddRowInputDate;

        $wpdb->query($querySETrowInputDate);
    }

    if(!empty($imagesInfoArray)){

        if(file_exists($wp_upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-info-values.json")){

            $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images-info-values.json';
            $fp = fopen($jsonFile, 'r');
            $allImagesInfoDataArray = json_decode(fread($fp, filesize($jsonFile)),true);
            fclose($fp);

        }else{
            $allImagesInfoDataArray = array();
        }


        foreach ($imagesInfoArray as $imageId => $imageInfoValues){

            if(!empty($imageInfoValues)){// do not remove this
                foreach ($imageInfoValues as $f_input_id => $imageInfoValuesArray){
                    $allImagesInfoDataArray[$imageId][$f_input_id] = $imageInfoValuesArray;
                }
            }

        }

/*        echo "all images info arra save here";



        echo "<pre>";

        print_r($allImagesInfoDataArray);

        echo "</pre>";*/

        $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images-info-values.json';
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($allImagesInfoDataArray));
        fclose($fp);

        $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json';
        $fp = fopen($tstampFile, 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);

    }

}