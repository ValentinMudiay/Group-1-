<?php
add_action('cg_copy_comments','cg_copy_comments');
if(!function_exists('cg_copy_comments')){
    function cg_copy_comments($cg_copy_start,$oldGalleryID,$nextGalleryID,$collectImageIdsArray){
        if(!empty($collectImageIdsArray)){

            global $wpdb;

            $tablename = $wpdb->prefix . "contest_gal1ery";
            $tablename_comments = $wpdb->prefix . "contest_gal1ery_comments";

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
                $query = "INSERT INTO $tablename_comments
    SELECT NULL, pid, $nextGalleryID, Name, Date, Comment, Timestamp
    FROM $tablename_comments
    WHERE GalleryID IN ($oldGalleryID)";
                $wpdb->query($query);
            }
          //  var_dump($query);
            // Dann
            //Muss so aussehen:UPDATE wp_contest_gal1ery_ip SET pid = CASE pid WHEN 22717 THEN 30000 WHEN 22716 THEN 30001 ELSE pid END WHERE GalleryID IN (341)
            $whenThenString = '';
            foreach($collectImageIdsArray as $oldImageId => $newImageId){
                $whenThenString .= "WHEN $oldImageId THEN $newImageId ";
            }

            $whenThenString = substr_replace($whenThenString ,"", -1);

            //Muss so aussehen:UPDATE wp_contest_gal1ery_ip SET pid = CASE pid WHEN 22717 THEN 30000 WHEN 22716 THEN 30001 ELSE pid END WHERE GalleryID IN (341)
            $query = "UPDATE $tablename_comments SET pid = CASE pid $whenThenString ELSE pid END WHERE GalleryID IN ($nextGalleryID)";
           // var_dump($query);

            $wpdb->query($query);



            $imageComments = $wpdb->get_results("SELECT $tablename_comments.* FROM $tablename, $tablename_comments WHERE 
                                                         $tablename.id = $tablename_comments.pid AND 
                                                         $tablename.Active = 1 AND 
                                                         $tablename_comments.GalleryID = $nextGalleryID 
                                                         ORDER BY pid DESC");


            if(count($imageComments)){

                $wp_upload_dir = wp_upload_dir();

                $imageCommentsArray = array();

                $pid = '';

                foreach($imageComments as $comment){
                //    var_dump($comment->pid);
                    // Then save data. Data was collected for the image
                    if($pid!='' AND $pid != $comment->pid){
                   //     var_dump('write');
                   //     var_dump($comment->pid);
                    //    echo "<br>";
                  //      var_dump($imageCommentsArray);

                        $jsonFile = $wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$nextGalleryID."/json/image-comments/image-comments-".$pid.".json";
                        $fp = fopen($jsonFile, 'w');
                        fwrite($fp, json_encode($imageCommentsArray));
                        fclose($fp);

                        $imageCommentsArray = array();
                    }

                    $pid = $comment->pid;

                    $imageCommentsArray[$comment->id] = array();
                    $imageCommentsArray[$comment->id]['date'] = date("Y/m/d, G:i",$comment->Timestamp);
                    $imageCommentsArray[$comment->id]['timestamp'] = $comment->Timestamp;
                    $imageCommentsArray[$comment->id]['name'] = $comment->Name;
                    $imageCommentsArray[$comment->id]['comment'] = $comment->Comment;

                }
            //    echo "<br>";

             //   var_dump($imageCommentsArray);
            //    var_dump($nextGalleryID);
              //  var_dump($pid);

                // have to be done here again for last image
                $jsonFile = $wp_upload_dir['basedir']."/contest-gallery/gallery-id-".$nextGalleryID."/json/image-comments/image-comments-".$pid.".json";
                $fp = fopen($jsonFile, 'w');
                fwrite($fp, json_encode($imageCommentsArray));
                fclose($fp);


            }


        }



    }
}
