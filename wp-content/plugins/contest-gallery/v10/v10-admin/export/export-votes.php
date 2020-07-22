<?php
if(!function_exists('cg_votes_csv_export')){

    function cg_votes_csv_export(){

        global $wpdb;

        $tablename = $wpdb->prefix . "contest_gal1ery";
        $tablename_ip = $wpdb->prefix . "contest_gal1ery_ip";
        $wpPosts = $wpdb->base_prefix . "posts";
        $wpUsers = $wpdb->base_prefix . "users";

        $imageId = $_POST['cg_picture_id'];
        $GalleryID = $_POST['cg_option_id'];

        $imageObject = $wpdb->get_row( "SELECT * FROM $tablename WHERE id = '$imageId'");
        $votingData = $wpdb->get_results( "SELECT id, VoteDate, IP, Rating, RatingS, WpUserId, OptionSet, CookieId FROM $tablename_ip WHERE pid = '$imageId' ORDER BY id DESC");
        $wpPostsId = $imageObject->WpUpload;

        $imageWpObject = $wpdb->get_row( "SELECT * FROM $wpPosts WHERE ID = '$wpPostsId'");

        $wpUserIdsArray = array();

        if(count($votingData)){
            foreach($votingData as $row){

                if(!empty($row->WpUserId)){
                    $wpUserIdsArray[$row->WpUserId] = true;
                }
            }
        }

        $userIdsSelectString = '';

        if(count($wpUserIdsArray)){

            foreach($wpUserIdsArray as $id => $bool){
                if(empty($userIdsSelectString)){
                    $userIdsSelectString .= "ID = $id";
                }else{
                    $userIdsSelectString .= " OR ID = $id";
                }
            }

            $wpUsersData = $wpdb->get_results("SELECT ID, user_login, user_email FROM $wpUsers WHERE $userIdsSelectString ORDER BY ID ASC");

            foreach($wpUsersData as $row){
                $wpUserIdsArray[$row->ID] = array();
                $wpUserIdsArray[$row->ID]['user_login'] = $row->user_login;
                $wpUserIdsArray[$row->ID]['user_email'] = $row->user_email;
            }

        }


        $csvData = array();

        $csvData[0][0] = 'gallery id: '.$GalleryID;
        $csvData[1][0] = 'image id: '.$imageId;
        $csvData[2][0] = 'image name: '.$imageWpObject->post_title;
        $csvData[4][0] = 'image url: '.$imageWpObject->guid;

        $csvData[5][0] = 'VoteId';
        $csvData[5][1] = 'Vote date (server time)';
        $csvData[5][2] = 'User recognition';
        $csvData[5][3] = 'IP';
        $csvData[5][4] = 'WordPress user id';
        $csvData[5][5] = 'WordPress user name';
        $csvData[5][6] = 'WordPress user email';
        $csvData[5][7] = 'Cookie';
        $csvData[5][8] = 'Rating five stars';
        $csvData[5][9] = 'Rating one star';

        $i=6;
        $r=0;

        foreach($votingData as $value) {

            $csvData[$i][$r] = $value->id;
            $r++;
            $csvData[$i][$r] = $value->VoteDate;
            $r++;
            $csvData[$i][$r] = $value->OptionSet;
            $r++;
            $csvData[$i][$r] = $value->IP;
            $r++;
            $csvData[$i][$r] = $value->WpUserId;
            $r++;

            $username = (!empty($value->WpUserId)) ? $wpUserIdsArray[$value->WpUserId]['user_login'] : "";
            $useremail = (!empty($value->WpUserId)) ? $wpUserIdsArray[$value->WpUserId]['user_email'] : "";

            $csvData[$i][$r] = $username;
            $r++;
            $csvData[$i][$r] = $useremail;
            $r++;
            $csvData[$i][$r] = $value->CookieId;
            $r++;
            $csvData[$i][$r] = $value->Rating;
            $r++;
            $csvData[$i][$r] = $value->RatingS;
            $r++;
            $i++;

        }

        $filename = "cg-votes-gallery-id-$GalleryID-image-id-$imageId.csv";

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