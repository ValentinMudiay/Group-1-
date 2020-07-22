<?php

add_action('cg_actualize_all_images_data_sort_values_file','cg_actualize_all_images_data_sort_values_file');

function cg_actualize_all_images_data_sort_values_file($GalleryID,$isActualizeInstant = false,$IsModernFiveStar=false){
    // actualize timestamp here every 20 seconds!
    $wp_upload_dir = wp_upload_dir();

    if(!file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt')){

        if(file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-sort-values-tstamp.json')){
            $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-sort-values-tstamp.json';
            $fp = fopen($tstampFile, 'r');
            $tstamp = json_decode(fread($fp, filesize($tstampFile)));
            fclose($fp);
        }else{
            $tstamp = time()-21;//then file has to be created or modified anyway!!!!!
        }

        $timeCheck = $tstamp + 20;

        if($timeCheck<time()){

            if(!file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt')){

                // go for sure that not actualized in that time
                if(!$isActualizeInstant){
                    sleep(1);
                }

                if(file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-sort-values-tstamp.json')){
                    // go for sure that not actualized in that time
                    $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-sort-values-tstamp.json';
                    $fp = fopen($tstampFile, 'r');
                    $tstamp = json_decode(fread($fp, filesize($tstampFile)));
                    fclose($fp);
                    $timeCheck = $tstamp + 20;
                }else{
                    $timeCheck = 0;
                }


                if($timeCheck<time()){

                    // go for sure that not actualized in the moment
                    if(!file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt')){

                        // actualize
                        $fp = fopen($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt', 'w');
                        fwrite($fp, 'cg-actualizing-all-images-sort-values-json-data');
                        fclose($fp);

                        $imageDataJsonFiles = glob($wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-data/*.json');

                        if(file_exists($wp_upload_dir['basedir'] . "/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json")){
                            $jsonFile = $wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json";
                            $fp = fopen($jsonFile, 'r');
                            $allImagesArray = json_decode(fread($fp, filesize($jsonFile)),true);
                            fclose($fp);
                        }else{
                            $allImagesArray = array();
                        }

                        $collectExistingImageIDsArray = array();
                        foreach ($imageDataJsonFiles as $jsonFile) {

                            $fp = fopen($jsonFile, 'r');
                            $imageDataArray = json_decode(fread($fp, filesize($jsonFile)),true);
                            fclose($fp);

                            // get image id
                            $stringArray= explode('/image-data-',$jsonFile);
                            $subString = end($stringArray);
                            $imageId = substr($subString,0, -5);

                            $allImagesArray = cg_actualize_all_images_data_sort_values_file_set_array($allImagesArray,$imageDataArray,$imageId,$IsModernFiveStar);
                            $collectExistingImageIDsArray[] = $imageId;

                        }

                        //remove not existing image ids
                        foreach($allImagesArray as $key => $imageDataArray){
                            if(!in_array($key,$collectExistingImageIDsArray)){
                                unset($allImagesArray[$key]);
                            }
                        }

                        $fp = fopen($wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$GalleryID."/json/".$GalleryID."-images-sort-values.json", 'w');
                        fwrite($fp, json_encode($allImagesArray));
                        fclose($fp);

                        $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-sort-values-tstamp.json';
                        $fp = fopen($tstampFile, 'w');
                        fwrite($fp, json_encode(time()));
                        fclose($fp);

                        if(file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt')){
                            unlink($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-sort-values-json-data-file.txt');
                        };

                    };

                }

            }
        }

    }

}
