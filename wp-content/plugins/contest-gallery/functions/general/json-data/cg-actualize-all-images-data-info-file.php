<?php

add_action('cg_actualize_all_images_data_info_file','cg_actualize_all_images_data_info_file');

function cg_actualize_all_images_data_info_file($GalleryID){

    $wp_upload_dir = wp_upload_dir();

    if(!file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-info-json-data-file.txt')){

        // actualize timestamp here every 20 seconds!

        if(file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json')){
            $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json';
            $fp = fopen($tstampFile, 'r');
            $tstamp = json_decode(fread($fp, filesize($tstampFile)));
            fclose($fp);
        }else{
            $tstamp = time()-21;//then file has to be created or modified anyway!!!!!
        }

        $timeCheck = $tstamp + 20;

        if($timeCheck<time()){

            if(!file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-info-json-data-file.txt')){

                // go for sure that not actualized in that time
                sleep(2);

                // go for sure that not actualized in that time
                if(file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json')){
                    // go for sure that not actualized in that time
                    $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json';
                    $fp = fopen($tstampFile, 'r');
                    $tstamp = json_decode(fread($fp, filesize($tstampFile)));
                    fclose($fp);
                    $timeCheck = $tstamp + 20;
                }else{
                    $timeCheck = 0;
                }

                if($timeCheck<time()){

                    // go for sure that not actualized in the moment
                    if(!file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-info-json-data-file.txt')){

                        // actualize
                        $fp = fopen($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-info-json-data-file.txt', 'w');
                        fwrite($fp, 'cg-actualizing-all-images-info-json-data');
                        fclose($fp);

                        $imageInfoJsonFiles = glob($wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/image-info/*.json');

                        $allImagesInfoArray = array();

                        // do it by file system because it is faster that main function which do it over big query cg_actualize_all_images_data_sort_values_file
                        foreach ($imageInfoJsonFiles as $jsonFile) {

                            $fp = fopen($jsonFile, 'r');
                            $imageInfoDataArray = json_decode(fread($fp, filesize($jsonFile)),true);
                            fclose($fp);

                            // get image id
                            $stringArray= explode('/image-info-',$jsonFile);
                            $subString = end($stringArray);
                            $imageId = substr($subString,0, -5);

                            $allImagesInfoArray[$imageId] = $imageInfoDataArray;

                        }

                        $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-images-info-values.json';
                        $fp = fopen($jsonFile, 'w');
                        fwrite($fp, json_encode($allImagesInfoArray));
                        fclose($fp);

                        $tstampFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-gallery-image-info-tstamp.json';
                        $fp = fopen($tstampFile, 'w');
                        fwrite($fp, json_encode(time()));
                        fclose($fp);

                        if(file_exists($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-info-json-data-file.txt')){
                            unlink($wp_upload_dir['basedir'] . '/contest-gallery/gallery-id-'.$GalleryID.'/json/cg-actualizing-all-images-info-json-data-file.txt');
                        };

                    };

                }

            }
        }

    }

}
