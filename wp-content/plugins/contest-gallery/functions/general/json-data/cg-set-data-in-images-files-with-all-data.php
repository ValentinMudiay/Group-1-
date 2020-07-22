<?php

add_action('cg_set_data_in_images_files_with_all_data','cg_set_data_in_images_files_with_all_data');

function cg_set_data_in_images_files_with_all_data($galleryID,&$imagesDataArray){

    $uploadFolder = wp_upload_dir();

    if(!empty($imagesDataArray['imagesDataSortValuesArray'])){

        if(file_exists($uploadFolder['basedir'] . '/contest-gallery/gallery-id-'.$galleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt')){
            sleep(2);
        };

        if(file_exists($uploadFolder['basedir'] . '/contest-gallery/gallery-id-'.$galleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt')){
            sleep(3);
        };

        if(file_exists($uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $galleryID . '/json/' . $galleryID . '-images-sort-values.json')){
            $jsonFile = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $galleryID . '/json/' . $galleryID . '-images-sort-values.json';
            $fp = fopen($jsonFile, 'r');
            $allImagesDataSortValuesArray = json_decode(fread($fp, filesize($jsonFile)),true);
            fclose($fp);

            foreach($imagesDataArray['imagesDataSortValuesArray'] as $imageId => $imageSortValuesArray){

                $allImagesDataSortValuesArray[$imageId] = $imageSortValuesArray;

            }

        }else{
            $allImagesDataSortValuesArray = $imagesDataArray['imagesDataSortValuesArray'];
        }

        $jsonFile = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $galleryID . '/json/' . $galleryID . '-images-sort-values.json';
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, json_encode($allImagesDataSortValuesArray));
        fclose($fp);

        $jsonFile = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$galleryID.'/json/'.$galleryID.'-gallery-sort-values-tstamp.json';
        $fp = fopen($jsonFile, 'w');
        fwrite($fp, time());
        fclose($fp);

        // !IMPORTANT otherwise all values will be saved in one file
        unset($imagesDataArray['imagesDataSortValuesArray']);

    }

    $jsonFile = $uploadFolder['basedir'] . '/contest-gallery/gallery-id-' . $galleryID . '/json/' . $galleryID . '-images.json';
    $fp = fopen($jsonFile, 'w');
    fwrite($fp, json_encode($imagesDataArray));
    fclose($fp);

    $tstampFile = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$galleryID.'/json/'.$galleryID.'-gallery-tstamp.json';
    $fp = fopen($tstampFile, 'w');
    fwrite($fp, time());
    fclose($fp);

}
