<?php

if(!function_exists('cg_create_json_files_when_activating')){
    function cg_create_json_files_when_activating($GalleryID,$rowObject,$thumbSizesWp,$uploadFolder,$imagesDataArray=null,$wpUserIdsAndDisplayNames=null){

        if($imagesDataArray!=null){
            $imagesDataArray[$rowObject->id] = array();
        }else{

            $jsonFile = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images.json';

            if(file_exists($jsonFile)){
                $fp = fopen($jsonFile, 'r');
                $imagesDataArray = json_decode(fread($fp, filesize($jsonFile)),true);
                $imagesDataArray[$rowObject->id] = array();
                fclose($fp);
            }else{
                $imagesDataArray = array();
                $imagesDataArray[$rowObject->id] = array();
            }

        }

        // posts fields
        $imgSrcThumb=wp_get_attachment_image_src($rowObject->WpUpload, 'thumbnail');
        $imgSrcThumb=$imgSrcThumb[0];
        $imgSrcMedium=wp_get_attachment_image_src($rowObject->WpUpload, 'medium');
        $imgSrcMedium=$imgSrcMedium[0];
        $imgSrcLarge=wp_get_attachment_image_src($rowObject->WpUpload, 'large');
        $imgSrcLarge=$imgSrcLarge[0];
        $imgSrcFull=wp_get_attachment_image_src($rowObject->WpUpload, 'full');
        $imgSrcFull=$imgSrcFull[0];

        if(!empty($rowObject->Width)){
            $imageWidth = $rowObject->Width;
            $imageHeight = $rowObject->Height;
        }else{
            $imageWidth = $imgSrcFull[1];
            $imageHeight = $imgSrcFull[2];
        }

        $imagesDataArray[$rowObject->id]['thumbnail_size_w'] = $thumbSizesWp['thumbnail_size_w'];
        $imagesDataArray[$rowObject->id]['medium_size_w'] = $thumbSizesWp['medium_size_w'];
        $imagesDataArray[$rowObject->id]['large_size_w'] = $thumbSizesWp['large_size_w'];

        $imagesDataArray[$rowObject->id]['thumbnail'] = $imgSrcThumb;
        $imagesDataArray[$rowObject->id]['medium'] = $imgSrcMedium;
        $imagesDataArray[$rowObject->id]['large'] = $imgSrcLarge;
        $imagesDataArray[$rowObject->id]['full'] = $imgSrcFull;

        $imagesDataArray[$rowObject->id]['post_date'] = $rowObject->post_date;
        $imagesDataArray[$rowObject->id]['post_content'] = $rowObject->post_content;
        $imagesDataArray[$rowObject->id]['post_title'] = $rowObject->post_title;
        $imagesDataArray[$rowObject->id]['post_name'] = $rowObject->post_name;
        $imagesDataArray[$rowObject->id]['post_caption'] = $rowObject->post_excerpt;
        $imagesDataArray[$rowObject->id]['post_alt'] = get_post_meta($rowObject->WpUpload,'_wp_attachment_image_alt',true);
        $imagesDataArray[$rowObject->id]['guid'] = $imgSrcFull;

        // hier pauschal setzen
        $imagesDataArray[$rowObject->id]['display_name'] = '';

        $imageRatingArray = array();

        $imageRatingArray['thumbnail_size_w'] = $thumbSizesWp['thumbnail_size_w'];
        $imageRatingArray['medium_size_w'] = $thumbSizesWp['medium_size_w'];
        $imageRatingArray['large_size_w'] = $thumbSizesWp['large_size_w'];

        $imageRatingArray['thumbnail'] = $imgSrcThumb;
        $imageRatingArray['medium'] = $imgSrcMedium;
        $imageRatingArray['large'] = $imgSrcLarge;
        $imageRatingArray['full'] = $imgSrcFull;

        $imageRatingArray['post_date'] = $rowObject->post_date;
        $imageRatingArray['post_content'] = $rowObject->post_content;
        $imageRatingArray['post_title'] = $rowObject->post_title;
        $imageRatingArray['post_name'] = $rowObject->post_name;
        $imageRatingArray['post_caption'] = $rowObject->post_excerpt;
        $imageRatingArray['post_alt'] = get_post_meta($rowObject->WpUpload,'_wp_attachment_image_alt',true);
        $imageRatingArray['guid'] = $imgSrcFull;

        // tablename fields
        $imagesDataArray[$rowObject->id]['rowid'] = intval($rowObject->rowid);
        $imagesDataArray[$rowObject->id]['Timestamp'] = intval($rowObject->Timestamp);
        $imagesDataArray[$rowObject->id]['NamePic'] = $rowObject->NamePic;
        $imagesDataArray[$rowObject->id]['ImgType'] = $rowObject->ImgType;
        $imagesDataArray[$rowObject->id]['GalleryID'] = intval($rowObject->GalleryID);
        $imagesDataArray[$rowObject->id]['Active'] = intval($rowObject->Active);
        $imagesDataArray[$rowObject->id]['Informed'] = intval($rowObject->Informed);
        $imagesDataArray[$rowObject->id]['WpUpload'] = intval($rowObject->WpUpload);
        $imagesDataArray[$rowObject->id]['Width'] = intval($imageWidth);
        $imagesDataArray[$rowObject->id]['Height'] = intval($imageHeight);
        $imagesDataArray[$rowObject->id]['rSource'] = intval($rowObject->rSource);
        $imagesDataArray[$rowObject->id]['rThumb'] = intval($rowObject->rThumb);
        $imagesDataArray[$rowObject->id]['Category'] = intval($rowObject->Category);
        if(!empty($wpUserIdsAndDisplayNames)){
            $imagesDataArray[$rowObject->id]['display_name'] = $wpUserIdsAndDisplayNames[$rowObject->id];
        }


        $imageRatingArray['rowid'] = intval($rowObject->rowid);
        $imageRatingArray['Timestamp'] = intval($rowObject->Timestamp);
        $imageRatingArray['NamePic'] = $rowObject->NamePic;
        $imageRatingArray['ImgType'] = $rowObject->ImgType;
        $imageRatingArray['Rating'] = intval($rowObject->Rating);
        $imageRatingArray['GalleryID'] = intval($rowObject->GalleryID);
        $imageRatingArray['Active'] = intval($rowObject->Active);
        $imageRatingArray['Informed'] = intval($rowObject->Informed);
        $imageRatingArray['WpUpload'] = intval($rowObject->WpUpload);
        $imageRatingArray['Width'] = intval($imageWidth);
        $imageRatingArray['Height'] = intval($imageHeight);
        $imageRatingArray['rSource'] = intval($rowObject->rSource);
        $imageRatingArray['rThumb'] = intval($rowObject->rThumb);
        $imageRatingArray['Category'] = intval($rowObject->Category);
        $imageRatingArray['display_name'] = $wpUserIdsAndDisplayNames[$rowObject->id];


        // rating comment save here

        $imageRatingArray['CountC'] =intval($rowObject->CountC);
        $imageRatingArray['CountR'] = intval($rowObject->CountR);
        $imageRatingArray['CountS'] = intval($rowObject->CountS);
        $imageRatingArray['Rating'] = intval($rowObject->Rating);
        $imageRatingArray['addCountS'] = intval($rowObject->addCountS);
        $imageRatingArray['addCountR1'] = intval($rowObject->addCountR1);
        $imageRatingArray['addCountR2'] = intval($rowObject->addCountR2);
        $imageRatingArray['addCountR3'] = intval($rowObject->addCountR3);
        $imageRatingArray['addCountR4'] = intval($rowObject->addCountR4);
        $imageRatingArray['addCountR5'] = intval($rowObject->addCountR5);
        $imageRatingArray['CountR1'] = intval($rowObject->CountR1);
        $imageRatingArray['CountR2'] = intval($rowObject->CountR2);
        $imageRatingArray['CountR3'] = intval($rowObject->CountR3);
        $imageRatingArray['CountR4'] = intval($rowObject->CountR4);
        $imageRatingArray['CountR5'] = intval($rowObject->CountR5);

        // images rating data array will be build here!!!
        if(empty($imagesDataArray['imagesDataSortValuesArray'])){

            $imagesDataArray['imagesDataSortValuesArray'] = array();

        }
        $imagesDataArray['imagesDataSortValuesArray'][$rowObject->id] = array();

        $imagesDataArray['imagesDataSortValuesArray'] = cg_actualize_all_images_data_sort_values_file_set_array($imagesDataArray['imagesDataSortValuesArray'],$imageRatingArray,$rowObject->id,true);


        $hasExif = true;
        $exifDataArray = array();

        if($rowObject->Exif == '' or $rowObject->Exif == NULL){
            $hasExif = false;
        }
        else if($rowObject->Exif != '' && $rowObject->Exif != '0'){
            $exifDataArray = @unserialize($rowObject->Exif);
        }

        // set exif data
        if($hasExif==false && empty($exifDataArray)){

            $imageRatingArray['Exif'] = cg_create_exif_data($rowObject->WpUpload);

            if(empty($imageRatingArray['Exif'])){
                $imageDataExifSerialized = 0;
                $imageRatingArray['Exif'] = 0;
            }else{
                $imageDataExifSerialized = serialize($imageRatingArray['Exif']);
            }

            global $wpdb;

            // Set table names
            $tablename = $wpdb->prefix . "contest_gal1ery";
            $wpdb->update(
                "$tablename",
                array('Exif' => $imageDataExifSerialized),
                array('id' => $rowObject->id),
                array('%s'),
                array('%d')
            );

        }else{
            $imageRatingArray['Exif'] = $exifDataArray;
        }

        // set rating data
        $jsonFile = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-data/image-data-'.$rowObject->id.'.json';
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($imageRatingArray));
        fclose($fp);


        // das bedeutet as bild wurde vorher aktiviert und wieder deaktiviert
        if(!is_file($uploadFolder['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$rowObject->id.".json")){

            global $wpdb;
            $tablename_comments = $wpdb->prefix . "contest_gal1ery_comments";

            $imageCommentsArray = array();
            $imageComments = $wpdb->get_results("SELECT * FROM $tablename_comments WHERE pid = $rowObject->id ORDER BY id ASC");

            if(count($imageComments)){

                $imageCommentsArray = array();

                $count = 1;

                foreach($imageComments as $comment){

                    $imageCommentsArray[$count] = array();
                    $imageCommentsArray[$count]['date'] = date("Y/m/d, G:i",$comment->Timestamp);
                    $imageCommentsArray[$count]['timestamp'] = $comment->Timestamp;
                    $imageCommentsArray[$count]['name'] = $comment->Name;
                    $imageCommentsArray[$count]['comment'] = $comment->Comment;

                    $count++;

                }


            }

            $jsonFile = $uploadFolder['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$rowObject->id.".json";
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($imageCommentsArray));
            fclose($fp);

        }

        // das bedeutet as bild wurde vorher aktiviert und wieder deaktiviert
        if(!is_file($uploadFolder['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$rowObject->id.".json")){

            global $wpdb;
            $tablename_comments = $wpdb->prefix . "contest_gal1ery_comments";

            $imageCommentsArray = array();
            $imageComments = $wpdb->get_results("SELECT * FROM $tablename_comments WHERE pid = $rowObject->id ORDER BY id ASC");

            if(count($imageComments)){

                $imageCommentsArray = array();

                $count = 1;

                foreach($imageComments as $comment){

                    $imageCommentsArray[$count] = array();
                    $imageCommentsArray[$count]['date'] = date("Y/m/d, G:i",$comment->Timestamp);
                    $imageCommentsArray[$count]['timestamp'] = $comment->Timestamp;
                    $imageCommentsArray[$count]['name'] = $comment->Name;
                    $imageCommentsArray[$count]['comment'] = $comment->Comment;

                    $count++;

                }


            }

            $jsonFile = $uploadFolder['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$rowObject->id.".json";
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($imageCommentsArray));
            fclose($fp);

        }
        // leeres Info file wird kreiert falls noch nicht existiert
        if(!is_file($uploadFolder['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$rowObject->id.".json")){

            $jsonFile = $uploadFolder['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$rowObject->id.".json";
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode(array()));
            fclose($fp);

        }

        return $imagesDataArray;


    }
}