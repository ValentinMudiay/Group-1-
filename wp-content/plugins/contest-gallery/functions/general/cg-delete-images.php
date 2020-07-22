<?php

add_action('cg_delete_images','cg_delete_images');
if(!function_exists('cg_delete_images')){
    function cg_delete_images($GalleryID,$deleteValuesArray){

        global $wpdb;

// Set table names
        $tablename = $wpdb->prefix . "contest_gal1ery";
        $tablenameEntries = $wpdb->prefix . "contest_gal1ery_entries";
        $tablenameComments = $wpdb->prefix . "contest_gal1ery_comments";

// Set table names --- END

        /*	$imageUnlinkOrigin = @$_POST['imageUnlinkOrigin'];
            $imageUnlink300 = @$_POST['imageUnlink300'];
            $imageUnlink624 = @$_POST['imageUnlink624'];
            $imageUnlink1024 = @$_POST['imageUnlink1024'];
            $imageUnlink1600 = @$_POST['imageUnlink1600'];
            $imageUnlink1920 = @$_POST['imageUnlink1920'];
            $imageFbHTMLUnlink = @$_POST['imageFbHTMLUnlink'];*/

// Pics vom Server l�schen

// Wordpress Uploadordner bestimmen. Array wird zur�ck gegeben.
        $upload_dir = wp_upload_dir();

        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images.json";
        $fp = fopen($jsonFile, 'r');
        $imageArray = json_decode(fread($fp, filesize($jsonFile)),true);
        fclose($fp);

        if(file_exists($upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-info-values.json")){

            $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-info-values.json";
            $fp = fopen($jsonFile, 'r');
            $imagesInfoValuesArray = json_decode(fread($fp, filesize($jsonFile)),true);
            fclose($fp);

        }

        if(file_exists($upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json")){

            $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json";
            $fp = fopen($jsonFile, 'r');
            $imagesSortValuesArray = json_decode(fread($fp, filesize($jsonFile)),true);
            fclose($fp);

        }



        foreach($deleteValuesArray as $key => $value){

            /*echo '<input type="hidden" disabled name="imageUnlinkOrigin[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.'.$value->ImgType.'" class="image-delete">';
            echo '<input type="hidden" disabled name="imageUnlink300[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-300width.'.$value->ImgType.'" class="image-delete">';
            echo '<input type="hidden" disabled name="imageUnlink624[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-624width.'.$value->ImgType.'" class="image-delete">';
            echo '<input type="hidden" disabled name="imageUnlink1024[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-1024width.'.$value->ImgType.'" class="image-delete">';
            echo '<input type="hidden" disabled name="imageUnlink1600[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-1600width.'.$value->ImgType.'" class="image-delete">';
            echo '<input type="hidden" disabled name="imageUnlink1920[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'-1920width.'.$value->ImgType.'" class="image-delete">';
            echo '<input type="hidden" disabled name="imageFbHTMLUnlink[]" value="/contest-gallery/gallery-id-'.$GalleryID.'/'.$value->Timestamp.'_'.$value->NamePic.'.html" class="image-delete">';*/

            $imageData = $wpdb->get_row( "SELECT * FROM $tablename WHERE id = '$value' ");

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic.".".$imageData->ImgType."")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic.".".$imageData->ImgType."");
            }

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-300width.".$imageData->ImgType."")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-300width.".$imageData->ImgType."");
            }

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-624width.".$imageData->ImgType."")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-624width.".$imageData->ImgType."");
            }

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-1024width.".$imageData->ImgType."")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-1024width.".$imageData->ImgType."");
            }

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-1600width.".$imageData->ImgType."")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-1600width.".$imageData->ImgType."");
            }

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-1920width.".$imageData->ImgType."")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."-1920width.".$imageData->ImgType."");
            }

            /*			if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic.".html")){
                            @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic.".html");
                        }*/

            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."413.html")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/".$imageData->Timestamp."_".$imageData->NamePic."413.html");
            }


            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$value.".json")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$value.".json");
            }
            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$value.".json")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$value.".json");
            }
            if(file_exists($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$value.".json")){
                @unlink($upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$value.".json");
            }


            if(!empty($imageArray[$value])){
                unset($imageArray[$value]);
            }

            if(!empty($imagesInfoValuesArray)){
                if(!empty($imagesInfoValuesArray[$value])){
                    unset($imagesInfoValuesArray[$value]);
                }
            }

            if(!empty($imagesSortValuesArray)){
                if(!empty($imagesSortValuesArray[$value])){
                    unset($imagesSortValuesArray[$value]);
                }
            }


            $deleteQuery = 'DELETE FROM ' . $tablename . ' WHERE';
            $deleteQuery .= ' id = %d';

            $deleteEntries = 'DELETE FROM ' . $tablenameEntries . ' WHERE';
            $deleteEntries .= ' pid = %d';

            $deleteComments = 'DELETE FROM ' . $tablenameComments . ' WHERE';
            $deleteComments .= ' pid = %d';

            $deleteParameters = '';
            $deleteParameters .= $value;

            $wpdb->query( $wpdb->prepare(
                "
                    $deleteQuery
                ",
                $deleteParameters
            ));

            $wpdb->query( $wpdb->prepare(
                "
                    $deleteEntries
                ",
                $deleteParameters
            ));

            $wpdb->query( $wpdb->prepare(
                "
                    $deleteComments
                ",
                $deleteParameters
            ));

        }

        // korrekturskript wegen update 10.9.5.0.0 wo galery id nicht mitgechickt wurde und deswegen images nicht gelöscht worden sind


        // korrekturskript ENDE


        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images.json";
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($imageArray));
        fclose($fp);

        // !IMPORTANT otherwise indexed db will be not reloaded
        $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-gallery-tstamp.json";
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);


        if(file_exists($upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-info-values.json")){

            $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-info-values.json";
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($imagesInfoValuesArray));
            fclose($fp);

        }

        if(file_exists($upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json")){

            $jsonFile = $upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json";
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($imagesSortValuesArray));
            fclose($fp);

        }



    }
}



?>