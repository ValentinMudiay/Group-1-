<?php

add_action('cg_json_upload_form_info_data_files','cg_json_upload_form_info_data_files');

function cg_json_upload_form_info_data_files($GalleryID,$idsToCopyStringCollect = null){

    global $wpdb;

    $tablename = $wpdb->prefix . "contest_gal1ery";
    $tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";
    $tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
    $tablename_entries = $wpdb->prefix . "contest_gal1ery_entries";

    $wp_upload_dir = wp_upload_dir();
    $jsonUpload = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json';

    if(!is_dir($jsonUpload)){
        mkdir($jsonUpload,0755,true);
    }

    $f_InputForGallery = $wpdb->get_var("SELECT Field1IdGalleryView FROM $tablename_options_visual WHERE GalleryID = $GalleryID ORDER BY id DESC LIMIT 1");
    $f_TagInGallery = $wpdb->get_var("SELECT Field2IdGalleryView FROM $tablename_options_visual WHERE GalleryID = $GalleryID ORDER BY id DESC LIMIT 1");

    $singleViewOrderDataJson = $wpdb->get_results("SELECT id, Field_Type, Field_Order, Field_Content FROM $tablename_form_input WHERE GalleryID = $GalleryID AND Show_Slider = 1 AND Active = 1 ORDER BY Field_Order DESC");

    $selectEntriesQuery = '';
    $fieldTitlesArray = array();
    $fieldIdsArray = array();
    $fieldInputIdsArray = array();
    $dateFieldsIdsAndFormatArray = array();

    foreach($singleViewOrderDataJson as $row){

        $row->Field_Content = unserialize($row->Field_Content);
        $fieldTitlesArray[$row->id] = $row->Field_Content["titel"];
        $fieldIdsArray[] = $row->id;
        $fieldInputIdsArray[$row->id] = array();
        $fieldInputIdsArray[$row->id]['Show_Slider'] = true;
        $fieldInputIdsArray[$row->id]['Show_Gallery'] = false;

        $selectEntriesQuery .= $tablename_entries.'.f_input_id = '.$row->id.' OR ';

        if($row->Field_Type=='date-f'){
            $dateFieldsIdsAndFormatArray[$row->id] = $row->Field_Content["format"];
        }

    }

    if(!empty($f_TagInGallery)){
        if(!in_array($f_TagInGallery,$fieldIdsArray)){
            $selectEntriesQuery .= $tablename_entries.'.f_input_id = '.$f_TagInGallery.' OR ';
            $fieldInputIdsArray[$f_TagInGallery] = array();
            $fieldInputIdsArray[$f_TagInGallery]['Show_Tag'] = true;
        }
    }

    if(!empty($f_InputForGallery)){
        if(!in_array($f_InputForGallery,$fieldIdsArray)){
            $selectEntriesQuery .= $tablename_entries.'.f_input_id = '.$f_InputForGallery;

            $fieldInputIdsArray[$f_InputForGallery] = array();
            $fieldInputIdsArray[$f_InputForGallery]['Show_Slider'] = false;
            $fieldInputIdsArray[$f_InputForGallery]['Show_Gallery'] = true;

        }else{
            $selectEntriesQuery = substr($selectEntriesQuery,0,strlen($selectEntriesQuery)-4);
            $fieldInputIdsArray[$f_InputForGallery]['Show_Gallery'] = true;
        }
    }else{
        $selectEntriesQuery = substr($selectEntriesQuery,0,strlen($selectEntriesQuery)-4);
    }

    if(!empty($selectEntriesQuery)){
        $selectEntriesQuery = "AND ($selectEntriesQuery)";
    }

    if(!empty($idsToCopyStringCollect)){
        $query = "SELECT  $tablename_entries.f_input_id, $tablename_entries.pid, $tablename_entries.Short_Text, $tablename_entries.Long_Text, $tablename_entries.Field_Type, $tablename_entries.InputDate FROM $tablename_entries, $tablename_form_input WHERE $tablename_entries.f_input_id = $tablename_form_input.id $selectEntriesQuery AND $tablename_entries.GalleryID = $GalleryID AND ($idsToCopyStringCollect) ORDER BY $tablename_entries.pid DESC";
    }else{
        $query = "SELECT  $tablename_entries.f_input_id, $tablename_entries.pid, $tablename_entries.Short_Text, $tablename_entries.Long_Text, $tablename_entries.Field_Type, $tablename_entries.InputDate FROM $tablename_entries, $tablename_form_input WHERE $tablename_entries.f_input_id = $tablename_form_input.id $selectEntriesQuery AND $tablename_entries.GalleryID = $GalleryID ORDER BY $tablename_entries.pid DESC";
    }

/*    echo "<pre>";
    print_r($selectEntriesQuery);
    echo "</pre>";
    echo "<br>";
    echo "<pre>";
    print_r($query);
    echo "</pre>";
    echo "<br>";*/

    $allEntriesForJson = $wpdb->get_results($query);

//    echo "<pre>";
  //  print_r($allEntriesForJson);
  //  echo "</pre>";

    $lastPid = '';
    $count = count($allEntriesForJson);
    $i = 0;
/*
    echo "<pre>";
    print_r($fieldInputIdsArray);
    echo "</pre>";

    echo "<pre>";
    print_r($allEntriesForJson);
    echo "</pre>";*/


    if(!empty($allEntriesForJson)){

        $collectAllArrayDataForImage = array();

        foreach($allEntriesForJson as $row){

            // array kreieren falls noch nicht existiert damit keine unterdrücten fehler entstehen
            if(empty($arrayDataForImage)){
              $arrayDataForImage = array();
            }
            if(empty($arrayDataForImage[$row->pid])){
                $arrayDataForImage[$row->pid] = array();
            }

            // Dann muss nächste ID angefangen sein und es kann gespeichert werden
            if($lastPid!=$row->pid && $lastPid != ''){

                if(!empty($arrayDataForImage[$lastPid])){

/*                    var_dump($lastPid);

                    echo "<pre>";
                    print_r($arrayDataForImage[$lastPid]);
                    echo "</pre>";*/

                    $collectAllArrayDataForImage[$lastPid] = $arrayDataForImage[$lastPid];
                    // gesammelten Array für eine PID schon mal speichern
                    $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info/image-info-'.$lastPid.'.json';
                    $fp = fopen($jsonFile, 'w');
                    fwrite($fp, json_encode($arrayDataForImage[$lastPid]));
                    fclose($fp);

                }else{// set empty array then, so no data is available for frontend
                    $collectAllArrayDataForImage[$lastPid] = array();// will be saved later in -images-info-values
                    $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info/image-info-'.$lastPid.'.json';
                    $fp = fopen($jsonFile, 'w');
                    fwrite($fp, json_encode(array()));
                    fclose($fp);
                }

                unset($arrayDataForImage);
                $arrayDataForImage = array();
                $arrayDataForImage[$row->pid] = array();

            }

            if(!empty($fieldInputIdsArray[$row->f_input_id])){

                $arrayDataForImage[$row->pid][$row->f_input_id] = array();
                $arrayDataForImage[$row->pid][$row->f_input_id]['field-type'] = $row->Field_Type;
                $arrayDataForImage[$row->pid][$row->f_input_id]['field-title'] = (!empty($fieldTitlesArray[$row->f_input_id])) ? $fieldTitlesArray[$row->f_input_id] : '';
                if(!empty($row->Long_Text)){
                    $arrayDataForImage[$row->pid][$row->f_input_id]['field-content'] = $row->Long_Text;
                }
                if(!empty($row->InputDate) && $row->InputDate!='0000-00-00 00:00:00'){

                    $newDateTimeString = '';

                    try {

                        if(!empty($dateFieldsIdsAndFormatArray[$row->f_input_id])){// might be hidden or deactivated this why check here

                            $dtFormat = $dateFieldsIdsAndFormatArray[$row->f_input_id];

                            $dtFormat = str_replace('YYYY','Y',$dtFormat);
                            $dtFormat = str_replace('MM','m',$dtFormat);
                            $dtFormat = str_replace('DD','d',$dtFormat);

                            $newDateTimeObject = DateTime::createFromFormat("Y-m-d H:i:s",$row->InputDate);

                            if(is_object($newDateTimeObject)){
                                $newDateTimeString = $newDateTimeObject->format($dtFormat);
                            }

                        }

                    }catch (Exception $e) {

                        $newDateTimeString = '';

                    }

                    $arrayDataForImage[$row->pid][$row->f_input_id]['field-content'] = $newDateTimeString;

                }else{
                    $arrayDataForImage[$row->pid][$row->f_input_id]['field-content'] = $row->Short_Text;
                }

            }

            $lastPid = $row->pid;
            $i++;


            // wenn der letzte Eintrag ist dann muss nochmal gebildet werden weil noch nicht existiert weil am ende des loops gemacht wird
            if($count==$i){

                    if(!empty($arrayDataForImage[$lastPid])){
/*                        var_dump($lastPid);

                        echo "<pre>";
                        print_r($arrayDataForImage[$lastPid]);
                        echo "</pre>";*/
                        $collectAllArrayDataForImage[$lastPid] = $arrayDataForImage[$lastPid];

                        // gesammelten Array für eine PID schon mal speichern
                        $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info/image-info-'.$lastPid.'.json';
                        $fp = fopen($jsonFile, 'w');
                        fwrite($fp, json_encode($arrayDataForImage[$lastPid]));
                        fclose($fp);

                    }else{// set empty array then, so no data is available for frontend
                        $collectAllArrayDataForImage[$lastPid] = array();// will be saved later in -images-info-values
                        $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info/image-info-'.$lastPid.'.json';
                        $fp = fopen($jsonFile, 'w');
                        fwrite($fp, json_encode(array()));
                        fclose($fp);
                    }

            }


        }

        if(!empty($collectAllArrayDataForImage)){

            if(file_exists($wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images-info-values.json')){

                $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images-info-values.json';
                $fp = fopen($jsonFile, 'r');
                $allImagesInfoDataArray = json_decode(fread($fp, filesize($jsonFile)),true);
                fclose($fp);

            }

            if(!empty($allImagesInfoDataArray)){

                foreach ($collectAllArrayDataForImage as $imageId => $imageInfoValues){

                    $allImagesInfoDataArray[$imageId] = $imageInfoValues;

                }

            }else{

                $allImagesInfoDataArray = $collectAllArrayDataForImage;

            }

            $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images-info-values.json';
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($allImagesInfoDataArray));
            fclose($fp);

            $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json';
            $fp = fopen($tstampFile, 'w');
            fwrite($fp, json_encode(time()));
            fclose($fp);

        }


    }else{

        // hier gehts weiter, leere files anlegen!!!!!!!!

        $allImageIDs = $wpdb->get_results("SELECT id FROM $tablename WHERE GalleryID = '$GalleryID' AND Active = '1'");

        if(!empty($allImageIDs)){

            $imageInfoJsonFolder = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info';

            foreach ($allImageIDs as $row) {
                $fp = fopen($imageInfoJsonFolder.'/image-info-'.$row->id.'.json', 'w');
                fwrite($fp, json_encode(array()));
                fclose($fp);

            }
        }

    }
 //   die;

}
