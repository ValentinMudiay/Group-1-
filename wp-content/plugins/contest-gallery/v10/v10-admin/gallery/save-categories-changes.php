<?php


if(!empty($isBackendCall)){

    if(empty($_POST['cgGalleryHash'])){
        echo 0;die;
    }else{

        $galleryHash = $_POST['cgGalleryHash'];
        $galleryHashDecoded = wp_salt( 'auth').'---cngl1---'.$_POST['GalleryID'];
        $galleryHashToCompare = md5($galleryHashDecoded);

        if ($galleryHash != $galleryHashToCompare){
            echo 0;die;
        }

    }

}


global $wpdb;

$tablename_categories = $wpdb->prefix . "contest_gal1ery_categories";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";

$GalleryID = $_POST['GalleryID'];

$wp_upload_dir = wp_upload_dir();


$jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
$fp = fopen($jsonFile, 'r');
$options = json_decode(fread($fp, filesize($jsonFile)),true);
fclose($fp);


$CatWidget = 0;
$ShowCatsUnchecked = 1;


if(empty($_POST['ShowCatsUnchecked'])){
    $ShowCatsUnchecked = 0;
}

if(!empty($_POST['CatWidget'])){
    $CatWidget = 1;
    $wpdb->update(
        "$tablename_pro_options",
        array('CatWidget' => 1, 'ShowCatsUnchecked' => $ShowCatsUnchecked),
        array('GalleryID' => $GalleryID),
        array('%d','%d'),
        array('%d')
    );
}
else{
    $wpdb->update(
        "$tablename_pro_options",
        array('CatWidget' => 0, 'ShowCatsUnchecked' => $ShowCatsUnchecked),
        array('GalleryID' => $GalleryID),
        array('%d','%d'),
        array('%d')
    );
}




$ShowOther = 0;
if(!empty($_POST['Category'])){

    $wpdb->update(
        "$tablename_categories",
        array('Active' => 0),
        array('GalleryID' => $GalleryID),
        array('%s'),
        array('%s')
    );
    //  var_dump($_POST['Category']);
    foreach($_POST['Category'] as $key => $value){
        //   var_dump(is_string ($key));
        //    var_dump($key!=0);
        //   var_dump($value);
        //   var_dump($value);
        if($key=='Continue' && is_string($key)) {
            continue;
        }

        if($key=='ShowOther' && is_string($key)){
            // var_dump(4444444);

            $wpdb->update(
                "$tablename_pro_options",
                array('ShowOther' => 1),
                array('GalleryID' => $GalleryID),
                array('%d'),
                array('%s')
            );
            $ShowOther = 1;

        }
        else{
            $wpdb->update(
                "$tablename_categories",
                array('Active' => 1),
                array('id' => $value),
                array('%s'),
                array('%s')
            );

        }

    }

    if(empty($_POST['Category']['ShowOther'])){
        // var_dump(11111111111);
        $wpdb->update(
            "$tablename_pro_options",
            array('ShowOther' => 0),
            array('GalleryID' => $GalleryID),
            array('%d'),
            array('%s')
        );
    }

    // make json file

    $categories = $wpdb->get_results("SELECT * FROM $tablename_categories WHERE GalleryID = '$GalleryID' ORDER BY Field_Order");

    $categoriesFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-categories.json';

    $categoriesArray = array();

    foreach($categories as $category){

        $categoriesArray[$category->id] = $category;

    }

    $fp = fopen($categoriesFile, 'w');
    fwrite($fp, json_encode($categoriesArray));
    fclose($fp);

}


// Set table names --- END

$options['pro']['ShowOther'] = $ShowOther;
$options['pro']['CatWidget'] = $CatWidget;
$options['pro']['ShowCatsUnchecked'] = $ShowCatsUnchecked;
// set image data, das ganze gesammelte
$jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
$fp = fopen($jsonFile, 'w');
fwrite($fp, json_encode($options));
fclose($fp);