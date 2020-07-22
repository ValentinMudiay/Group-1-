<?php

global $wpdb;

$tablename_create_user_entries = $wpdb->prefix . "contest_gal1ery_create_user_entries";
$tablename_contest_gal1ery_options = $wpdb->prefix . "contest_gal1ery_options";
$tablename_contest_gal1ery_create_user_form = $wpdb->prefix . "contest_gal1ery_create_user_form";
$userFormShort = $tablename_contest_gal1ery_create_user_form;
$tablename_contest_gal1ery_create_user_entries = $wpdb->prefix . "contest_gal1ery_create_user_entries";
$entriesShort = $tablename_contest_gal1ery_create_user_entries;
$wpUsers = $wpdb->base_prefix . "users";

$GalleryName = $wpdb->get_var("SELECT GalleryName FROM $tablename_contest_gal1ery_options WHERE id = '$GalleryID'");
$allGalleryNamesAndIds = $wpdb->get_results("SELECT GalleryName, id FROM $tablename_contest_gal1ery_options WHERE id >= '0'");


// will be inserted if create csv
echo "<div  id='cg_create_user_data_csv_container'>";
echo "<input type='hidden' name='cg_create_user_data_csv' id='cg_create_user_data_csv' value='true' />";
echo "</div>";


    $start = 0; // Startwert setzen (0 = 1. Zeile)
    $step = 50;

    if (isset($_GET["start"])) {
        $muster = "/^[0-9]+$/"; // reg. Ausdruck für Zahlen
        if (preg_match($muster, @$_GET["start"]) == 0) {
            $start = 0; // Bei Manipulation Rückfall auf 0
        } else {
            $start = @$_GET["start"];
        }
    }

    if (isset($_GET["step"])) {
        $muster = "/^[0-9]+$/"; // reg. Ausdruck für Zahlen
        if (preg_match($muster, @$_GET["start"]) == 0) {
            $step = 50; // Bei Manipulation Rückfall auf 0
        } else {
            $step = @$_GET["step"];
        }
    }



$cgSearchGalleryId = '';
$cgSearchGalleryIdParam = '';

if(!empty($_POST['cg-search-gallery-id']) OR !empty($_GET['cg-search-gallery-id'])){
    $cgSearchGalleryId = (!empty($_POST['cg-search-gallery-id'])) ? intval($_POST['cg-search-gallery-id']) : intval($_GET['cg-search-gallery-id']);
    $cgSearchGalleryIdParam = '&cg-search-gallery-id='.$cgSearchGalleryId;
}


    $cgUserName = '';
    $cgUserNameGetParam = '';


$toSelect = "$wpUsers.ID, $wpUsers.user_login, $wpUsers.user_email";

if(!empty($_GET['wp_user_id'])){

    $selectWPusers = $wpdb->get_results("SELECT * FROM $wpUsers WHERE ID = '".$_GET['wp_user_id']."'");

    $rows = $wpdb->get_var(
        "
		SELECT COUNT(*) AS NumberOfRows
		FROM $wpUsers"
    );

}else if(!empty($_POST['cg-search-user-name']) OR !empty($_GET['cg-search-user-name'])){

        $cgUserName = (!empty($_POST['cg-search-user-name'])) ? sanitize_text_field(htmlentities(html_entity_decode($_POST['cg-search-user-name']))) : sanitize_text_field(htmlentities(html_entity_decode($_GET['cg-search-user-name'])));
        $cgUserNameGetParam = '&cg-search-user-name='.$cgUserName;

        if(!empty($cgSearchGalleryId)){

            $selectWPusers = $wpdb->get_results("SELECT DISTINCT $toSelect FROM $wpUsers, $entriesShort WHERE ($wpUsers.user_login LIKE '%$cgUserName%' OR $wpUsers.user_email LIKE '%$cgUserName%') AND ($wpUsers.ID = $entriesShort.wp_user_id AND $entriesShort.GalleryID = '$cgSearchGalleryId') ORDER BY $wpUsers.ID ASC LIMIT $start, $step");

            $rows = count($wpdb->get_results(
                "
		SELECT DISTINCT $wpUsers.ID  
		FROM $wpUsers, $entriesShort WHERE ($wpUsers.user_login LIKE '%$cgUserName%' OR $wpUsers.user_email LIKE '%$cgUserName%') AND ($wpUsers.ID = $entriesShort.wp_user_id AND $entriesShort.GalleryID = '$cgSearchGalleryId')"
            ));

        }else{

            $selectWPusers = $wpdb->get_results("SELECT $toSelect FROM $wpUsers WHERE user_login LIKE '%$cgUserName%' OR user_email LIKE '%$cgUserName%' ORDER BY $wpUsers.ID ASC LIMIT $start, $step");

            $rows = $wpdb->get_var(
                "
		SELECT COUNT(*) AS NumberOfRows
		FROM $wpUsers WHERE user_login LIKE '%$cgUserName%' OR user_email LIKE '%$cgUserName%'"
            );


        }

    }else if(!empty($cgSearchGalleryId)){

        $selectWPusers = $wpdb->get_results("SELECT DISTINCT $toSelect FROM $wpUsers, $entriesShort WHERE $wpUsers.ID = $entriesShort.wp_user_id AND $entriesShort.GalleryID = '$cgSearchGalleryId' ORDER BY $wpUsers.ID ASC LIMIT $start, $step");

        $rows = count($wpdb->get_results(
            "
            SELECT DISTINCT $wpUsers.ID  
            FROM $wpUsers,$entriesShort WHERE $wpUsers.ID = $entriesShort.wp_user_id AND $entriesShort.GalleryID = '$cgSearchGalleryId'"
        ));

    }else{

        $selectWPusers = $wpdb->get_results("SELECT $toSelect FROM $wpUsers ORDER BY $wpUsers.ID ASC LIMIT $start, $step");

        $rows = count($selectWPusers);

        $rows = $wpdb->get_var(
            "
		SELECT COUNT(*) AS NumberOfRows
		FROM $wpUsers"
        );

    }


if(isset($_GET['delete_data_csv'])){
    $admin_email = get_option('admin_email');
    $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");
    $code = $wpdb->base_prefix; // database prefix
    $code = md5($code.$adminHashedPass);
    @$dir = plugin_dir_path( __FILE__ );
    @$dir = $dir.$code."_userregdata.csv";
    @unlink($dir);
    ?><script>alert('CSV data file deleted.');</script><?php
}

//if(strpos(floatval(get_option("p_cgal1ery_reg_code"))/44,".") == false && floatval(get_option("p_cgal1ery_reg_code"))!=0 && floatval(get_option("p_cgal1ery_reg_code"))>=986798739){
$versionColor = "#444";
//}
//else{
//	$versionColor = "#c2c2c2";
//	}



echo "<div id='cgRegistrationSearch'>";/*
echo"&nbsp;&nbsp;Show users per Site:";

echo"&nbsp;<a href=\"?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&step=10&start=0\">10</a>&nbsp;";
echo"&nbsp;<a href=\"?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&step=20&start=0\">20</a>&nbsp;";
echo"&nbsp;<a href=\"?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&step=50&start=0\">30</a>&nbsp;";*/

$iconUrl = plugins_url('icon.png', __FILE__ )."";

echo "<form id='cgUsersManagementForm' style='font-size: 16px;display:inline;' method='POST' action='?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID#cg-search-results-container' class='cg_load_backend_submit'>";


if(!empty($_GET['wp_user_id'])){

    if(!empty($selectWPusers)){// in this case when uid is send must be only one
        foreach($selectWPusers as $wpUser){
            $cgUserName = $wpUser->user_email;
        }
    }

}
echo '<input type="text" placeholder="Username/Email" style="width:342px;" name="cg-search-user-name" value="'.$cgUserName.'" /> &nbsp; AND &nbsp;';


echo '<input type="hidden" name="cg-search-user-name-original" value="'.$cgUserName.'" />';

echo "<input type='hidden' name='cg_create_user_data_csv_new_export' id='cg_create_user_data_csv_new_export' value='true' />";
echo '<input type="hidden" name="cg-search-gallery-id-original" value="'.$cgSearchGalleryId.'" />';


//echo '<input type="submit" value="" style="border:none;cursor:pointer;display: inline-block; width: 20px; height: 24px;';
//echo 'position: relative; left: -27px;  top: 8px; background: url('.$iconUrl.');background-size: 22px 22px;"/>';

echo '<select name="cg-search-gallery-id" style="margin-bottom: 6px;
    width: 342px;">';
echo '<option value="">';
echo 'Select users registered about a certain gallery';
echo '</option>';

$selected = '';



foreach($allGalleryNamesAndIds as $keyValue){

    if($keyValue->id==$cgSearchGalleryId){
        $selected = 'selected';
    }

    echo '<option value="'.$keyValue->id.'" '.$selected.'>';
    if(empty($keyValue->GalleryName)){
        echo 'gallery id: '.$keyValue->id;
    }
    else{
        $gid = $keyValue->id;
        echo  $keyValue->GalleryName." (gallery id: $gid)";
    }
    echo '</option>';

    $selected = '';
}
echo '</select>';

echo '<button type="submit" id="cgRegistrationSearchSubmit" class="cg_backend_button_gallery_action">Search</button>';

echo '</form>';

echo '<div id="cgRegistrationSearchReset"></div>';

echo "</div>";

echo "<div id='cgCreateDataCSVdiv' >";
echo "<input type='button' class='cg_backend_button_gallery_action' id='cg_create_user_data_csv_submit' value='Create data CSV of results' style='text-align:center;width:210px;margin-bottom:10px;' />";
echo "</div>";

$nr1 = $start + 1;
echo "<div class='cg_pics_per_site' style='margin-top:2px;width: 937px;'>";
for ($i = 0; $rows > $i; $i = $i + $step) {

    $anf = $i + 1;
    $end = $i + $step;

    if ($end > $rows) {
        $end = $rows;
    }
   // ?page=contest-gallery/index.php&users_management=true&option_id=14
    if ($anf == $nr1 AND ($start+$step) > $rows AND $start==0) {
        continue;
        echo "<div class='cg_step cg_step_selected'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&users_management=true$cgUserNameGetParam$cgSearchGalleryIdParam\">$anf-$end</a></div>";
    }

    elseif ($anf == $nr1 AND ($start+$step) > $rows AND $anf==$end) {

        echo "<div class='cg_step cg_step_selected'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&users_management=true$cgUserNameGetParam$cgSearchGalleryIdParam\">$end</a></div>";
    }


    elseif ($anf == $nr1 AND ($start+$step) > $rows) {

        echo "<div class='cg_step cg_step_selected'><a href=\?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&users_management=true$cgUserNameGetParam$cgSearchGalleryIdParam\">$anf-$end</a></div>";
    }

    elseif ($anf == $nr1) {
        echo "<div class='cg_step cg_step_selected'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&users_management=true$cgUserNameGetParam$cgSearchGalleryIdParam\">$anf-$end</a></div>";
    }

    elseif ($anf == $end) {
        echo "<div class='cg_step'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&users_management=true$cgUserNameGetParam$cgSearchGalleryIdParam\">$end</a></div>";
    }

    else {
        echo "<div class='cg_step'><a href=\"?page=contest-gallery/index.php&option_id=$GalleryID&step=$step&start=$i&users_management=true$cgUserNameGetParam$cgSearchGalleryIdParam\">$anf-$end</a></div>";
    }
}
echo "</div>";








if(!empty($_GET['edit_registration_entries']) AND !empty($_GET['wp_user_id'])){

    include("management-show-user.php");

}else{

    $usersTableHtmlStart = <<<HEREDOC

                <div id="cgUsersManagementList" class="wrap">

                    <form method="get">
                        <table class="wp-list-table widefat fixed striped users">
                            <thead>
                            <tr>
                                <th scope="col" id="username"
                                    class="manage-column column-username">Username</th>
                                <th scope="col" id="email" class="manage-column column-email">Email</th>
                                <th scope="col" id="role" class="manage-column column-role">Role</th>
                            </tr>
                            </thead>

                            <tbody id="the-list" data-wp-lists="list:user">
                            




HEREDOC;

    $usersTableHtmlEnd = <<<HEREDOC

                            </tbody>


                        </table>

                    </form>

                    <br class="clear">
                </div>


HEREDOC;


    $wp_roles = wp_roles();

    echo $usersTableHtmlStart;

    if(!empty($selectWPusers)){

        $wpUsersIdsWithNotConfirmedMailArray = array();

        // select not confirmed users
        $selectWpUsersNotConfirmedQuery = "SELECT DISTINCT wp_user_id FROM $tablename_create_user_entries WHERE";

        foreach ($selectWPusers as $user){
            $userId = $user->ID;
            $selectWpUsersNotConfirmedQuery .= " (wp_user_id = $userId AND activation_key != '') OR ";
        }

        $selectWpUsersNotConfirmedQuery = substr($selectWpUsersNotConfirmedQuery,0,-3);
        $allWpUsersNotConfirmed = $wpdb->get_results($selectWpUsersNotConfirmedQuery);

        foreach ($allWpUsersNotConfirmed as $notConfirmedUser){
            $wpUsersIdsWithNotConfirmedMailArray[] = $notConfirmedUser->wp_user_id;
        }


        foreach($selectWPusers as $user){

            $avatarImage = get_avatar( $user->ID,null,null,null,array('width'=>32,'height'=>32));
            $userId = $user->ID;
            $editUserWPprofileLink = get_edit_user_link($userId);
            $user_login = $user->user_login;

            $user_meta=get_userdata($userId);

            $user_roles=$user_meta->roles; //array of roles the user is part of.

            if(!empty(($user_roles[0]))){
                $firstRoleKey = $user_roles[0];
                $firstRoleName = $wp_roles->roles[$firstRoleKey]['name'];
            }else{
                $firstRoleName = '';
            }


            $user_email = $user->user_email;

            //$contestGalleryEntriesEditLink = "<span><a href=\"http://localhost:8080/author/test/\">(No Contest Gallery registration form entries to edit)</a></span></div>";

            $cgEntriesCheck = $wpdb->get_var( "SELECT COUNT(*) FROM $entriesShort WHERE (wp_user_id  = $userId) AND (Field_Type = 'user-select-field' OR Field_Type = 'user-comment-field' OR Field_Type = 'user-text-field' OR Field_Type = 'user-check-agreement-field') ");

            if(!empty($cgEntriesCheck)){

                $contestGalleryEntriesEditLink =  "<span><a href='?page=contest-gallery/index.php&users_management=true&option_id=$GalleryID&wp_user_id=$userId&edit_registration_entries=true' class='cg_load_backend_link' >Edit Contest Gallery registration form entries</a></span>";

            }else{
                $contestGalleryEntriesEditLink = "<span>(No Contest Gallery registration form entries to edit)</span>";
            }


            // var_dump(get_avatar( 1));

            echo " <tr id=\"user-$userId\">
                                <td class=\"username column-username has-row-actions column-primary\"
                                    data-colname=\"Username\"><!--<img alt=\"\"
                                                                 src=\"http://0.gravatar.com/avatar/f84d37ce99493155ee296c2b746191d0?s=32&amp;d=mm&amp;r=g\"
                                                                 srcset=\"http://0.gravatar.com/avatar/f84d37ce99493155ee296c2b746191d0?s=64&amp;d=mm&amp;r=g 2x\"
                                                                 class=\"avatar avatar-32 photo\" height=\"32\" width=\"32\">-->
                                                     $avatarImage            
                                                                 
                                    <strong><a
                                            href=\"$editUserWPprofileLink\">$user_login</a></strong>";
            if(in_array($userId,$wpUsersIdsWithNotConfirmedMailArray)){
                echo "<span style='margin-left:5px;font-weight:600;'>Mail not confirmed</span>";
            }
                echo "<br>
                                    <div class=\"row-actions\"><span><a
                                            href=\"$editUserWPprofileLink\">Edit WordPress profile</a> | </span>
                                            $contestGalleryEntriesEditLink
                                            </div>
                                </td>
                                <td class=\"email column-email\" data-colname=\"Email\">$user_email
                                </td>
                                <td class=\"role column-role\" data-colname=\"Role\">$firstRoleName</td>
                            </tr>";

        }

    }else{
        echo '<tr><td colspan="3"><p style="
    text-align: center;
    margin-top: 15px;
    font-size: 20px;
">No results for this search</p></td></tr>';
    }



    echo $usersTableHtmlEnd;

}


