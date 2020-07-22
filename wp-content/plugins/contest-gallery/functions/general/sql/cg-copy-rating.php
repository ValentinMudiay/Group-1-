<?php

add_action('cg_copy_rating','cg_copy_rating');
if(!function_exists('cg_copy_rating')){
    function cg_copy_rating($cg_copy_start,$oldGalleryID,$nextGalleryID,$collectImageIdsArray){
        if(!empty($collectImageIdsArray)){

            global $wpdb;

            $tablename_ip = $wpdb->prefix . "contest_gal1ery_ip";

            // ABLAUF BEISPIEL (BEISPIELE SIND UNABHÄNGIG VONEINANDER)

            // Zuerst
            /*
            INSERT INTO wp_contest_gal1ery_ip
    SELECT NULL, pid, IP, 3001, Rating, RatingS, WpUserId, Tstamp, DateVote, VoteDate, OptionSet, CookieId
    FROM wp_contest_gal1ery_ip
    WHERE GalleryID IN (3000)*/

            // Dann
            // UPDATE wp_contest_gal1ery_ip SET pid = CASE pid WHEN 22717 THEN 30000 WHEN 22716 THEN 30001 ELSE pid END WHERE GalleryID IN (341)


            // Zuerst
            /* Muss so aussehen:
            INSERT INTO wp_contest_gal1ery_ip
    SELECT NULL, pid, IP, 3001, Rating, RatingS, WpUserId, Tstamp, DateVote, VoteDate, OptionSet, CookieId
    FROM wp_contest_gal1ery_ip
    WHERE GalleryID IN (3000)*/
            if($cg_copy_start==0){
                //Muss so aussehen:INSERT INTO wp_contest_gal1ery_ip
                //SELECT NULL, pid, IP, 3001, Rating, RatingS, WpUserId, Tstamp, DateVote, VoteDate, OptionSet, CookieId
                //FROM wp_contest_gal1ery_ip
                //WHERE GalleryID IN (3000)
                $query = "INSERT INTO $tablename_ip
SELECT NULL, pid, IP, $nextGalleryID, Rating, RatingS, WpUserId, Tstamp, VoteDate, OptionSet, CookieId
FROM $tablename_ip
WHERE GalleryID IN ($oldGalleryID)";
                $wpdb->query($query);
            }

            // Dann
            //Muss so aussehen:UPDATE wp_contest_gal1ery_ip SET pid = CASE pid WHEN 22717 THEN 30000 WHEN 22716 THEN 30001 ELSE pid END WHERE GalleryID IN (341)
            $whenThenString = '';
            foreach($collectImageIdsArray as $oldImageId => $newImageId){
                $whenThenString .= "WHEN $oldImageId THEN $newImageId ";
            }

            $whenThenString = substr_replace($whenThenString ,"", -1);

            //Muss so aussehen:UPDATE wp_contest_gal1ery_ip SET pid = CASE pid WHEN 22717 THEN 30000 WHEN 22716 THEN 30001 ELSE pid END WHERE GalleryID IN (341)
            $query = "UPDATE $tablename_ip SET pid = CASE pid $whenThenString ELSE pid END WHERE GalleryID IN ($nextGalleryID)";
            $wpdb->query($query);

        }



    }
}
