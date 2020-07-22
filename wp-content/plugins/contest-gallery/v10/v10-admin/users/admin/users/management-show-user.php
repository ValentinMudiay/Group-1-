<?php

//include('get-data-management.php');

global $wpdb;

$tablename_contest_gal1ery_options = $wpdb->prefix . "contest_gal1ery_options";
$tablename_contest_gal1ery_create_user_entries = $wpdb->prefix . "contest_gal1ery_create_user_entries";
$tablename_contest_gal1ery_create_user_form = $wpdb->prefix . "contest_gal1ery_create_user_form";
$wpUsers = $wpdb->base_prefix . "users";

$wpUserId = $_GET['wp_user_id'];

/*Save user data here*/
if(isset($_POST['get-data-management'])){
    include("get-data-management.php");
    echo "<div id='cg_changes_saved' style='font-size:18px;'>Data saved<br><br></div>";
}

$userEntries = $wpdb->get_results("SELECT * FROM $tablename_contest_gal1ery_create_user_entries WHERE wp_user_id = '$wpUserId' ORDER BY id ASC");
/*echo "<pre>";

print_r($userEntries);

echo "</pre>";*/
$wpUserEntry = $wpdb->get_row("SELECT * FROM $wpUsers WHERE ID = '$wpUserId'");

$wpUserLogin = $wpUserEntry->user_login;
$wpUserEmail = $wpUserEntry->user_email;

$GalleryName = '';
$GalleryName = $wpdb->get_var("SELECT GalleryName FROM $tablename_contest_gal1ery_options WHERE id = '$GalleryID'");
$GalleryNameOrId = '';
if($GalleryName){$GalleryNameOrId="$GalleryName";}
else {$GalleryNameOrId = "id $GalleryID";}


echo "<div style='width:935px;background-color:#fff;border: thin solid black;padding-bottom:15px;' id='cg-search-results-container'>";
echo "<div  id='cgManagementShowUsers' style='clear:both;padding:20px;margin:20px;padding-top:20px;border:thin solid black;padding-right: 20px;'>";

echo "<form method='POST' action='?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&wp_user_id=$wpUserId&edit_registration_entries=true' class='cg_load_backend_submit'>";
echo "<input type='hidden' name='get-data-management' value='true' >";


echo "<div style='margin-bottom:10px;' id='cg-user-$wpUserId'>";
echo "<div style='float:left;display:inline;width:50%;border-bottom: 1px dotted #DFDFDF;'><strong>Username</strong></div>";
echo "<div style='float:right;display:inline;width:50%;text-align:right;border-bottom: 1px dotted #DFDFDF;'><a href=".get_edit_user_link($wpUserId)."><button type=\"button\" class='cg-show-fields'>Edit Wordpress Profile</button></a></div>";
echo "<div>$wpUserLogin</div>";
echo "</div>";

echo "<div style='margin-bottom:10px;'>";
echo "<div style='float:left;display:block;width:100%;border-bottom: 1px dotted #DFDFDF;'><strong>User e-mail</strong></div>";
echo "<div>$wpUserEmail</div>";
echo "</div>";

foreach($userEntries as $entry){

    $id = $entry->id;
    $formFieldId = $entry->f_input_id;
    $formFieldIdGalleryID = $entry->GalleryID;
    $formFieldType = $entry->Field_Type;
    $formFieldRow = $wpdb->get_row("SELECT * FROM $tablename_contest_gal1ery_create_user_form WHERE id = '$formFieldId'");
    $formFieldName = $formFieldRow->Field_Name;
    $formFieldRowContent = $formFieldRow->Field_Content;
    $formFieldChecked = $entry->Checked;
    $formFieldVersion = $entry->Version;
    $formFieldContent = html_entity_decode(stripslashes($entry->Field_Content));

    $checkAgreementBorder = ($formFieldType=='user-check-agreement-field') ? "border-bottom: 1px dotted #DFDFDF;" : "";

    echo "<div style='margin-bottom:10px;'>";
    if($formFieldType!="user-html-field" && $formFieldType!="user-robot-field" && $formFieldType!="main-user-name" && $formFieldType!="main-mail"){

        echo "<div style='float:left;display:inline;width:50%;$checkAgreementBorder'>";
        echo "<strong>$formFieldName:</strong>";
        echo "</div>";
        echo "<div style='float:right;display:inline;width:50%;text-align:right;$checkAgreementBorder'>";
        echo "<a href='?page=contest-gallery/index.php&create_user_form=true&option_id=$formFieldIdGalleryID' ><button type=\"button\" class='cg-show-fields'>Gallery - $formFieldIdGalleryID</button></a>";

        echo "</div>";

    }


    echo "<div>";

    $userFieldContent = ($formFieldType=='user-check-agreement-field') ? $formFieldRowContent : $formFieldContent;
    $userFieldDisabled = ($formFieldType=='user-check-agreement-field') ? 'disabled' : '';

    if($formFieldType=="user-text-field"){
        $userFieldContent = html_entity_decode(stripslashes($userFieldContent));
        echo "<input type='text' name='Entry_Field_Content[$id]' value='$userFieldContent' style='width:100%;' />";
    }

    if($formFieldType=="user-select-field"){
        $userFieldContent = html_entity_decode(stripslashes($userFieldContent));
        echo "<input type='text' name='Entry_Field_Content[$id]' value='$userFieldContent' style='width:100%;' />";
    }

    if($formFieldType=="user-comment-field"){
        $userFieldContent = html_entity_decode(stripslashes($userFieldContent));
        echo "<textarea type='comment' name='Entry_Field_Content[$id]' style='width:100%;height:100px;'>$userFieldContent</textarea>";
    }
    if($formFieldType=="user-check-agreement-field"){
        $userFieldContent = html_entity_decode(stripslashes($userFieldContent));
        $checked = '';
        $checkedText = '';
        if($formFieldChecked==1 OR empty($formFieldVersion)){
            $checked = 'checked';
            $checkedText = 'checked';
        }else{
            $checked = '';
            $checkedText = 'not checked';
        }
        echo "<input type='checkbox' $checked disabled /> $checkedText<br>";
    }


    echo "</div>";
    echo "</div>";

}


echo "<div style='height:30px;' id='cg_go_to_save_button'>";
echo "<input type='submit' value='Save data' class='cg_backend_button_gallery_action' style='float:right;text-align:center;width:80px;'>";
echo "</div>";


echo "</form>";



    echo "</div>";
echo "</div>";
