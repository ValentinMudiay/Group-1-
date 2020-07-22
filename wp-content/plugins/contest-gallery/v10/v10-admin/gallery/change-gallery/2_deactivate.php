<?php

if (@$_POST['chooseAction1'] == 2) {

    if (!empty($activate)) {

        foreach($activate as $key => $value){

            $wpdb->update(
                "$tablename",
                array('Active' => '0'),
                array('id' => $key),
                array('%d'),
                array('%d')
            );

            if(!empty($imageArray[$key])){
                unset($imageArray[$key]);
            }

            if(file_exists($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$key.".json")){
                @unlink($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-data/image-data-".$key.".json");
            }
            if(file_exists($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$key.".json")){
                @unlink($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-comments/image-comments-".$key.".json");
            }
            if(file_exists($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$key.".json")){
                @unlink($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/image-info/image-info-".$key.".json");
            }

        }

    }

}

