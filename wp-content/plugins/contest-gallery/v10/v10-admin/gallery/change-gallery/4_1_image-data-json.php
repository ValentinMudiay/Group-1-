<?php

//!!!!IMPORTANT. WILL BE NOT USED IN THE MOMENT.

    $imageArray[$object->id] = array();

    // posts fields
    $imgSrcThumb=wp_get_attachment_image_src($object->WpUpload, 'thumbnail');
    $imgSrcThumb=$imgSrcThumb[0];
    $imgSrcMedium=wp_get_attachment_image_src($object->WpUpload, 'medium');
    $imgSrcMedium=$imgSrcMedium[0];
    $imgSrcLarge=wp_get_attachment_image_src($object->WpUpload, 'large');
    $imgSrcLarge=$imgSrcLarge[0];
    $imgSrcFull=wp_get_attachment_image_src($object->WpUpload, 'full');
    $imgSrcFull=$imgSrcFull[0];

    $imageArray[$object->id]['thumbnail_size_w'] = $thumbnail_size_w;
    $imageArray[$object->id]['medium_size_w'] = $medium_size_w;
    $imageArray[$object->id]['large_size_w'] = $large_size_w;

    $imageArray[$object->id]['thumbnail'] = $imgSrcThumb;
    $imageArray[$object->id]['medium'] = $imgSrcMedium;
    $imageArray[$object->id]['large'] = $imgSrcLarge;
    $imageArray[$object->id]['full'] = $imgSrcFull;

    $imageArray[$object->id]['post_date'] = $object->post_date;
    $imageArray[$object->id]['post_content'] = $object->post_content;
    $imageArray[$object->id]['post_title'] = $object->post_title;
    $imageArray[$object->id]['post_name'] = $object->post_name;
    $imageArray[$object->id]['post_caption'] = $object->post_excerpt;
    $imageArray[$object->id]['post_alt'] = get_post_meta($object->WpUpload,'_wp_attachment_image_alt',true);
    $imageArray[$object->id]['guid'] = $object->guid;

    $imageRatingArray['thumbnail_size_w'] = $thumbnail_size_w;
    $imageRatingArray['medium_size_w'] = $medium_size_w;
    $imageRatingArray['large_size_w'] = $large_size_w;

    $imageRatingArray['thumbnail'] = $imgSrcThumb;
    $imageRatingArray['medium'] = $imgSrcMedium;
    $imageRatingArray['large'] = $imgSrcLarge;
    $imageRatingArray['full'] = $imgSrcFull;

    $imageRatingArray['post_date'] = $object->post_date;
    $imageRatingArray['post_content'] = $object->post_content;
    $imageRatingArray['post_title'] = $object->post_title;
    $imageRatingArray['post_name'] = $object->post_name;
    $imageRatingArray['post_caption'] = $object->post_excerpt;
    $imageRatingArray['post_alt'] = get_post_meta($object->WpUpload,'_wp_attachment_image_alt',true);
    $imageRatingArray['guid'] = $object->guid;

    // tablename fields

    $imageArray[$object->id]['rowid'] = intval($object->rowid);
    $imageArray[$object->id]['Timestamp'] = intval($object->Timestamp);
    $imageArray[$object->id]['NamePic'] = $object->NamePic;
    $imageArray[$object->id]['ImgType'] = $object->ImgType;
    $imageArray[$object->id]['Rating'] = intval($object->Rating);
    $imageArray[$object->id]['GalleryID'] = intval($object->GalleryID);
    $imageArray[$object->id]['Active'] = intval($object->Active);
    $imageArray[$object->id]['Informed'] = intval($object->Informed);
    $imageArray[$object->id]['WpUpload'] = intval($object->WpUpload);
    $imageArray[$object->id]['Width'] = intval($object->Width);
    $imageArray[$object->id]['Height'] = intval($object->Height);
    $imageArray[$object->id]['rSource'] = intval($object->rSource);
    $imageArray[$object->id]['rThumb'] = intval($object->rThumb);
    $imageArray[$object->id]['Category'] = intval($object->Category);

    $imageRatingArray['rowid'] = intval($object->rowid);
    $imageRatingArray['Timestamp'] = intval($object->Timestamp);
    $imageRatingArray['NamePic'] = $object->NamePic;
    $imageRatingArray['ImgType'] = $object->ImgType;
    $imageRatingArray['Rating'] = intval($object->Rating);
    $imageRatingArray['GalleryID'] = intval($object->GalleryID);
    $imageRatingArray['Active'] = intval($object->Active);
    $imageRatingArray['Informed'] = intval($object->Informed);
    $imageRatingArray['WpUpload'] = intval($object->WpUpload);
    $imageRatingArray['Width'] = intval($object->Width);
    $imageRatingArray['Height'] = intval($object->Height);
    $imageRatingArray['rSource'] = intval($object->rSource);
    $imageRatingArray['rThumb'] = intval($object->rThumb);
    $imageRatingArray['Category'] = intval($object->Category);

    // rating comment save here

    $imageRatingArray['CountC'] =intval($object->CountC);
    $imageRatingArray['CountR'] = intval($object->CountR);
    $imageRatingArray['CountS'] = intval($object->CountS);
    $imageRatingArray['Rating'] = intval($object->Rating);
    $imageRatingArray['addCountS'] = intval($object->addCountS);
    $imageRatingArray['addCountR1'] = intval($object->addCountR1);
    $imageRatingArray['addCountR2'] = intval($object->addCountR2);
    $imageRatingArray['addCountR3'] = intval($object->addCountR3);
    $imageRatingArray['addCountR4'] = intval($object->addCountR4);
    $imageRatingArray['addCountR5'] = intval($object->addCountR5);

    // set rating data
    $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-data/image-data-'.$object->id.'.json';
    $fp = fopen($jsonFile, 'w');
    fwrite($fp, json_encode($imageRatingArray));
    fclose($fp);


    // das bedeutet as bild wurde vorher aktiviert und wieder deaktiviert
    if(!is_file($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$object->id.".json")){

        $imageCommentsArray = array();
        $imageComments = $wpdb->get_results("SELECT * FROM $tablename_comments WHERE pid = $object->id ORDER BY id ASC");

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

        $jsonFile = $wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$object->id.".json";
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($imageCommentsArray));
        fclose($fp);

    }

