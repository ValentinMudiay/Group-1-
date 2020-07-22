<?php

add_action('cg_actualize_all_images_data_sort_values_file_set_array','cg_actualize_all_images_data_sort_values_file_set_array');

function cg_actualize_all_images_data_sort_values_file_set_array($allImagesArray,$imageDataArray,$imageId,$IsModernFiveStar = false){
    $allImagesArray[$imageId]['id'] = $imageId;
    $allImagesArray[$imageId]['Rating'] = $imageDataArray['Rating'];
    $allImagesArray[$imageId]['CountC'] = $imageDataArray['CountC'];
    $allImagesArray[$imageId]['CountR'] = $imageDataArray['CountR'];
    $allImagesArray[$imageId]['CountS'] = $imageDataArray['CountS'];
    $allImagesArray[$imageId]['addCountS'] = $imageDataArray['addCountS'];
    $allImagesArray[$imageId]['addCountR1'] = $imageDataArray['addCountR1'];
    $allImagesArray[$imageId]['addCountR2'] = $imageDataArray['addCountR2'];
    $allImagesArray[$imageId]['addCountR3'] = $imageDataArray['addCountR3'];
    $allImagesArray[$imageId]['addCountR4'] = $imageDataArray['addCountR4'];
    $allImagesArray[$imageId]['addCountR5'] = $imageDataArray['addCountR5'];
    if($IsModernFiveStar){
        $allImagesArray[$imageId]['CountR1'] = $imageDataArray['CountR1'];
        $allImagesArray[$imageId]['CountR2'] = $imageDataArray['CountR2'];
        $allImagesArray[$imageId]['CountR3'] = $imageDataArray['CountR3'];
        $allImagesArray[$imageId]['CountR4'] = $imageDataArray['CountR4'];
        $allImagesArray[$imageId]['CountR5'] = $imageDataArray['CountR5'];
    }

    return $allImagesArray;


}
