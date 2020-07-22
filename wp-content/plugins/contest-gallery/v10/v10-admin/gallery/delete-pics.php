<?php


$start = 0; // Startwert setzen (0 = 1. Zeile)
$step = 10;

if (isset($_GET["start"])) {
    $muster = "/^[0-9]+$/"; // reg. Ausdruck f�r Zahlen
    if (preg_match($muster, @$_GET["start"]) == 0) {
        $start = 0; // Bei R�ckfall auf 0
    } else {
        $start = intval(@$_GET["start"]);
    }
}

if (isset($_GET["step"])) {
    $muster = "/^[0-9]+$/"; // reg. Ausdruck f�r Zahlen
    if (preg_match($muster, @$_GET["start"]) == 0) {
        $step = 10; // Bei Manipulation R�ckfall auf 0
    } else {
        $step = intval(@$_GET["step"]);
    }
}

if(!empty($_GET['option_id'])){
    $GalleryIDtoDelete = sanitize_text_field($_GET['option_id']);
}
else if(!empty($_POST['cg_id'])){
    $GalleryIDtoDelete = sanitize_text_field($_POST['cg_id']);
}
else if(!empty($GalleryID)){
    $GalleryIDtoDelete = $GalleryID;
}

if(!empty($GalleryIDtoDelete)){
    cg_delete_images($GalleryIDtoDelete,$_POST['active']);
}

?>