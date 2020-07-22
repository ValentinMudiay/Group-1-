<?php

if (!empty($_GET['option_id']) AND !empty($_POST['cg_delete_gallery'])) {

    $optionID = @$_GET["option_id"];

    global $wpdb;

    $tablename = $wpdb->prefix . "contest_gal1ery";
    $tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
    $tablenameEntries = $wpdb->prefix . "contest_gal1ery_entries";
    $tablenameComments = $wpdb->prefix . "contest_gal1ery_comments";
    $tablenameIp = $wpdb->prefix . "contest_gal1ery_ip";
    $tablenameMail = $wpdb->prefix . "contest_gal1ery_mail";
    $tablename_options_input = $wpdb->prefix . "contest_gal1ery_options_input";
    $tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";
    $tablename_form_output = $wpdb->prefix . "contest_gal1ery_f_output";
    $tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
    $tablename_email_admin = $wpdb->prefix . "contest_gal1ery_mail_admin";
    $tablename_mail_confirmation = $wpdb->prefix . "contest_gal1ery_mail_confirmation";
    $tablenameCategories = $wpdb->prefix . "contest_gal1ery_categories";
    $tablenameOptionsPro = $wpdb->prefix . "contest_gal1ery_pro_options";
    $tablename_create_user_form = $wpdb->prefix . "contest_gal1ery_create_user_form";
    $contest_gal1ery_create_user_entries = $wpdb->prefix . "contest_gal1ery_create_user_entries";

    $galleryVersion = $wpdb->get_var("SELECT Version FROM $tablenameOptions WHERE id = '$optionID'");

    $upload_dir = wp_upload_dir();
    do_action('cg_delete_files_and_folder', $upload_dir['basedir'] . '/contest-gallery/gallery-id-' . $optionID . '/json/image-comments');
    do_action('cg_delete_files_and_folder', $upload_dir['basedir'] . '/contest-gallery/gallery-id-' . $optionID . '/json/image-data');
    do_action('cg_delete_files_and_folder', $upload_dir['basedir'] . '/contest-gallery/gallery-id-' . $optionID . '/json/image-info');
    do_action('cg_delete_files_and_folder', $upload_dir['basedir'] . '/contest-gallery/gallery-id-' . $optionID . '/json');
    do_action('cg_delete_files_and_folder', $upload_dir['basedir'] . '/contest-gallery/gallery-id-' . $optionID . '');


    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameOptions WHERE id = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameEntries WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameComments WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameIp WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameMail WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_options_input WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_form_input WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_form_output WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_options_visual WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_email_admin WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_mail_confirmation WHERE GalleryID = %d
			",
        $optionID
    ));


    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameCategories WHERE GalleryID = %d
			",
        $optionID
    ));

    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablenameOptionsPro WHERE GalleryID = %d
			",
        $optionID
    ));


    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $tablename_create_user_form WHERE GalleryID = %d
			",
        $optionID
    ));

    // SINCE 10.9.8.8.1 Do not delete $contest_gal1ery_create_user_entries main-user
    // maybe delete some days (IREGENDWANNMAL) users who registered multiple times with same data but and then are then confirmed after multiple registrations
    // Delete only information fields first
    $wpdb->query($wpdb->prepare(
        "
				DELETE FROM $contest_gal1ery_create_user_entries WHERE GalleryID = %d AND Field_Type != %s AND Field_Type != %s AND Field_Type != %s AND Field_Type != %s
			",
        $optionID,'password','password-confirm','main-user-name','main-mail'
    ));

    /*
    $wpdb->query($sql1);
    $wpdb->query($sql2);
    $wpdb->query($sql3);
    $wpdb->query($sql4);
    $wpdb->query($sql5);
    $wpdb->query($sql6);
    $wpdb->query($sql7);
    $wpdb->query($sql8);
    $wpdb->query($sql9);*/

    //$location = admin_url()."?page=contest-gallery/index.php";

    //@header("Location: $location");

}

?>