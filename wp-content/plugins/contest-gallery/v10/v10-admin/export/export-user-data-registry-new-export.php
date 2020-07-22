<?php
if(!function_exists('cg_user_data_registry_csv_new_export')){

    function cg_user_data_registry_csv_new_export(){

        global $wpdb;

        $tablename_contest_gal1ery_options = $wpdb->prefix . "contest_gal1ery_options";
        $tablename_contest_gal1ery_create_user_form = $wpdb->prefix . "contest_gal1ery_create_user_form";
        $userFormShort = $tablename_contest_gal1ery_create_user_form;
        $tablename_contest_gal1ery_create_user_entries = $wpdb->prefix . "contest_gal1ery_create_user_entries";
        $entriesShort = $tablename_contest_gal1ery_create_user_entries;
        $wpUsers = $wpdb->base_prefix . "users";


        $cgSearchGalleryId = '';
        $cgSearchGalleryIdParam = '';

        if(!empty($_POST['cg-search-gallery-id-original']) OR !empty($_GET['cg-search-gallery-id-original'])){
            $cgSearchGalleryId = (!empty($_POST['cg-search-gallery-id-original'])) ? intval($_POST['cg-search-gallery-id-original']) : intval($_GET['cg-search-gallery-id-original']);
            $cgSearchGalleryIdParam = '&cg-search-gallery-id='.$cgSearchGalleryId;
        }

        $cgUserName = '';
        $cgUserNameGetParam = '';

        $toSelect = "$wpUsers.ID, $wpUsers.user_login, $wpUsers.user_email";

        if(!empty($_POST['cg-search-user-name-original']) OR !empty($_GET['cg-search-user-name-original'])){

            $cgUserName = (!empty($_POST['cg-search-user-name-original'])) ? sanitize_text_field(htmlentities(html_entity_decode($_POST['cg-search-user-name-original']))) : sanitize_text_field(htmlentities(html_entity_decode($_GET['cg-search-user-name'])));
            $cgUserNameGetParam = '&cg-search-user-name='.$cgUserName;

            if(!empty($cgSearchGalleryId)){

                $selectWPusers = $wpdb->get_results("SELECT DISTINCT $toSelect FROM $wpUsers, $entriesShort WHERE ($wpUsers.user_login LIKE '%$cgUserName%' OR $wpUsers.user_email LIKE '%$cgUserName%') AND ($wpUsers.ID = $entriesShort.wp_user_id AND $entriesShort.GalleryID = '$cgSearchGalleryId') ORDER BY $wpUsers.ID ASC");

                $selectWPusersFormFields = $wpdb->get_results("SELECT DISTINCT $userFormShort.* FROM $wpUsers,  $userFormShort, $entriesShort, $tablename_contest_gal1ery_options WHERE
                (
                    $userFormShort.Field_Type != 'main-user-name' AND 
                    $userFormShort.Field_Type != 'main-mail' AND 
                    $userFormShort.Field_Type != 'password' AND 
                    $userFormShort.Field_Type != 'password-confirm' AND 
                    $userFormShort.Field_Type != 'user-robot-field' AND 
                    $userFormShort.GalleryID = $tablename_contest_gal1ery_options.id AND
                    $userFormShort.id = $entriesShort.f_input_id AND
                    $entriesShort.wp_user_id >= 1 AND
                    $wpUsers.ID = $entriesShort.wp_user_id AND
                    $entriesShort.GalleryID = '$cgSearchGalleryId' AND
                    ($wpUsers.user_login LIKE '%$cgUserName%' OR $wpUsers.user_email LIKE '%$cgUserName%')
                )
                ORDER BY GalleryID ASC, Field_Order DESC");

            }else{

                $selectWPusers = $wpdb->get_results("SELECT $toSelect FROM $wpUsers WHERE user_login LIKE '%$cgUserName%' OR user_email LIKE '%$cgUserName%' ORDER BY id ASC");

                $selectWPusersFormFields = $wpdb->get_results("SELECT DISTINCT $userFormShort.* FROM $wpUsers,  $userFormShort, $entriesShort, $tablename_contest_gal1ery_options WHERE
                (
                    $userFormShort.Field_Type != 'main-user-name' AND 
                    $userFormShort.Field_Type != 'main-mail' AND 
                    $userFormShort.Field_Type != 'password' AND 
                    $userFormShort.Field_Type != 'password-confirm' AND 
                    $userFormShort.Field_Type != 'user-robot-field' AND 
                    $userFormShort.GalleryID = $tablename_contest_gal1ery_options.id AND
                    $userFormShort.id = $entriesShort.f_input_id AND
                    $entriesShort.wp_user_id >= 1 AND
                    $wpUsers.ID = $entriesShort.wp_user_id AND
                    ($wpUsers.user_login LIKE '%$cgUserName%' OR $wpUsers.user_email LIKE '%$cgUserName%')
                )
                ORDER BY GalleryID ASC, Field_Order DESC");

            }

        }else if(!empty($cgSearchGalleryId)){

            $selectWPusers = $wpdb->get_results("SELECT DISTINCT $toSelect FROM $wpUsers, $entriesShort WHERE $wpUsers.ID = $entriesShort.wp_user_id AND $entriesShort.GalleryID = '$cgSearchGalleryId' ORDER BY $wpUsers.ID ASC");

            $selectWPusersFormFields = $wpdb->get_results("SELECT DISTINCT $userFormShort.* FROM $wpUsers,  $userFormShort, $entriesShort, $tablename_contest_gal1ery_options WHERE
                (
                    $userFormShort.Field_Type != 'main-user-name' AND 
                    $userFormShort.Field_Type != 'main-mail' AND 
                    $userFormShort.Field_Type != 'password' AND 
                    $userFormShort.Field_Type != 'password-confirm' AND 
                    $userFormShort.Field_Type != 'user-robot-field' AND 
                    $userFormShort.GalleryID = $tablename_contest_gal1ery_options.id AND
                    $userFormShort.id = $entriesShort.f_input_id AND
                    $entriesShort.wp_user_id >= 1 AND
                    $wpUsers.ID = $entriesShort.wp_user_id AND
                    $entriesShort.GalleryID = '$cgSearchGalleryId'
                )
                ORDER BY GalleryID ASC, Field_Order DESC");



        }else{

            $selectWPusers = $wpdb->get_results("SELECT $toSelect FROM $wpUsers ORDER BY id ASC");

            $selectWPusersFormFields = $wpdb->get_results("SELECT DISTINCT $userFormShort.* FROM $wpUsers,  $userFormShort, $entriesShort, $tablename_contest_gal1ery_options WHERE
                (
                    $userFormShort.Field_Type != 'main-user-name' AND 
                    $userFormShort.Field_Type != 'main-mail' AND 
                    $userFormShort.Field_Type != 'password' AND 
                    $userFormShort.Field_Type != 'password-confirm' AND 
                    $userFormShort.Field_Type != 'user-robot-field' AND 
                    $userFormShort.GalleryID = $tablename_contest_gal1ery_options.id AND
                    $userFormShort.id = $entriesShort.f_input_id AND
                    $entriesShort.wp_user_id >= 1 AND
                    $wpUsers.ID = $entriesShort.wp_user_id
                )
                ORDER BY GalleryID ASC, Field_Order DESC");

        }


        // $selectCGentries array sorted
        // main-user-name wird gewählt zur bestimmung von Gallery ID wo der user herkame. Ansonsten nicht vorhanden.
        $selectCGentries = $wpdb->get_results("SELECT DISTINCT * FROM $entriesShort WHERE
                (
                    $entriesShort.Field_Type != 'main-mail' AND 
                    $entriesShort.Field_Type != 'password' AND 
                    $entriesShort.Field_Type != 'password-confirm' AND 
                    $entriesShort.Field_Type != 'user-robot-field' AND 
                    $entriesShort.wp_user_id >= 1
                )
                ORDER BY wp_user_id ASC");


        // sorted by wp user id
        $selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId = array();

        foreach($selectCGentries as $entry){

            if(empty($selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$entry->wp_user_id])){
                $selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$entry->wp_user_id] = array();
            }

            $selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$entry->wp_user_id][$entry->f_input_id] = $entry;

        }

        // sorted by form field id
        // sicherheitscheck falls alte Gallerie gelöscht wurde

        $selectWPusersFormFieldsSortedById = array();

        foreach($selectWPusersFormFields as $formField){

            $selectWPusersFormFieldsSortedById[$formField->id] = $formField;

        }

/*        echo "<pre>";

        print_r($selectWPusers);

        echo "</pre>";*/


        // $selectCGentries array sorted -- ENDE

        //   $rows = count($selectWPusers);
/*

        echo "<pre>";
        print_r($selectWPusersFormFields);
        echo "</pre>";


        die;*/

        $csvData = array();

        $i=0;
        $r=0;

        //Bestimmung der Spalten Namen

        $wpUserId="WpUserId";
        $wpLoginName="Username";
        $wpUserMail="Usermail";
        $fromGalleryId="Registered over gallery id";

        $csvData[$i][$r]=$wpUserId;
        $r++;
        $csvData[$i][$r]=$wpLoginName;
        $r++;
        $csvData[$i][$r]=$wpUserMail;
        $r++;
        $csvData[$i][$r]=$fromGalleryId;

        // Vorab Variablen setzen damit bei späteren php versionen keine Fehler angezeigt werden.
        $userId = '';
        $user_login = '';
        $user_email = '';

        $headerColumnsArray = array();

/*        echo "<pre>";

        print_r($selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId);

        echo "</pre>";*/

        // ACHTUNG!!!! ZWEI Varianten hier. Einmal wenn es keine zusätzlichen UserDaten gibt und einmal wenn es welche gibt
        if(!empty($selectWPusersFormFields)) {

            // add further column header names, but only from existing and selected entries fields
            foreach($selectWPusersFormFields as $formField){
                $r++;
                $GalleryIDtoWrite = $formField->GalleryID;
                $csvData[$i][$r] = $formField->Field_Name." (gallery id = $GalleryIDtoWrite)";
                $headerColumnsArray[$formField->id] = $r;

            }

/*            echo "<pre>";

            print_r($headerColumnsArray);

            echo "</pre>";*/


            foreach($selectWPusers as $user){

                $i++;
//var_dump($user->ID);
                $csvData[$i][0] = $user->ID;
                $csvData[$i][1] = $user->user_login;
                $csvData[$i][2] = $user->user_email;

                if(!empty($selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$user->ID])){

                    // einfach erstes array element nehmen und dann die GalleryId
                    $csvData[$i][3] = $selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$user->ID][key($selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$user->ID])]->GalleryID;

                    // CSV Array muss bei spalten fortgesetzt werden, wenn 8,9,10 nicht vorhanden sind dann wird immer bei 7 geendet
                    foreach($headerColumnsArray as $formFieldId => $count){

                        $csvData[$i][$count] = '';

                    };

                    foreach($selectWPusersEntriesArraySortedByWpUserIdAndFormFieldId[$user->ID] as $formFieldId => $entry){
                        if($entry->Field_Type=='main-user-name'){
                            continue;
                        }

                        // sicherheitscheck falls alte Gallerie gelöscht wurde
                        if(empty($selectWPusersFormFieldsSortedById[$formFieldId])){
                            continue;
                        }

                        if($entry->Field_Type=='user-check-agreement-field'){
                            if($entry->Checked==1 OR empty($entry->Version)){// For old versions Version was always empty
                                $csvData[$i][$headerColumnsArray[$formFieldId]] = 'checked';
                            }else{
                                $csvData[$i][$headerColumnsArray[$formFieldId]] = 'not checked';
                            }
                        }else{
                            $csvData[$i][$headerColumnsArray[$formFieldId]] = $entry->Field_Content;
                        }
                    };

                }

                // hier gehts weiter

            }


        }

/*        echo "<pre>";

        print_r($csvData);

        echo "</pre>";*/


        // ACHTUNG!!!! ZWEI Varianten hier. Einmal wenn es keine zusätzlichen UserDaten gibt und einmal wenn es welche gibt
        if(empty($selectWPusersFormFields)){

            foreach($selectWPusers as $user){
                $i++;

                $csvData[$i][0] = $user->ID;
                $csvData[$i][1] = $user->user_login;
                $csvData[$i][2] = $user->user_email;

            }

        }

        // old logic do not remove
/*        $admin_email = get_option('admin_email');
        $adminHashedPass = $wpdb->get_var("SELECT user_pass FROM $wpUsers WHERE user_email = '$admin_email'");

        $code = $wpdb->base_prefix; // database prefix
        $code = md5($code.$adminHashedPass);

        $filename = $code."_userregdata.csv";*/

        $filename = "wordpress-users-export-from-contest-gallery.csv";


        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");

        ob_start();

        $fp = fopen("php://output", 'w');
        fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        foreach ($csvData as $fields) {
            fputcsv($fp, $fields, ";");

        }
        fclose($fp);
        $masterReturn = ob_get_clean();
        echo $masterReturn;
        die();


    }
}

?>