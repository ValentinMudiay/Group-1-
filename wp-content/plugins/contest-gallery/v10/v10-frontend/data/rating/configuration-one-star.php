<?php

?>
    <script>

        var index = <?php echo json_encode($galeryIDuser) ?>;
        cgJsData[index].cgJsCountSuser = {};
        cgJsData[index].lastVotedUserImageId = 0;

    </script>
<?php

if(empty($onlyLoggedInUserImages)) {
    // registered users check
    if(($options['general']['ShowOnlyUsersVotes']==1 or $options['general']['HideUntilVote']==1 or $options['pro']['MinusVote']==1) and $options['general']['CheckLogin']==1){
        if(is_user_logged_in()){

            $countSuserId = $wpdb->get_results( $wpdb->prepare(
                "
                            SELECT pid
                            FROM $tablenameIP
                            WHERE GalleryID = %d and WpUserId = %s and RatingS = %d
                        ",
                $galeryID,$wpUserId,1
            ) );

            if(!empty($countSuserId)){
                if(count($countSuserId)){

                    $i = 1;

                    foreach($countSuserId as $object){
                        ?>

                        <script>

                            var index = <?php echo json_encode($galeryIDuser) ?>;

                            var pid = <?php echo json_encode($object->pid);?>;
                            // wenn es bishierher gekommen ist, dann hat der user bereits das bild bewertet
                            // sollte es wieder eine id sein die der user schon mal bewertet hat, ann wir dieser eine 1 hinzugefügt
                            // cgJsData[index].cgJsCountSuser[pid] die der user nicht bewertet hat sind undefined
                            if(typeof cgJsData[index].cgJsCountSuser[pid] != 'undefined'){
                                var countS = parseInt(cgJsData[index].cgJsCountSuser[pid]);
                                countS = countS+1;
                                cgJsData[index].cgJsCountSuser[pid] = countS;
                            }
                            else{
                                cgJsData[index].cgJsCountSuser[pid] = 1;
                            }

                            cgJsData[index].lastVotedUserImageId = pid;

                        </script>

                        <?php

                        $i++;

                    }

                }
            }

        }

    }
    // cookie users check
    else if (($options['general']['ShowOnlyUsersVotes']==1 or $options['general']['HideUntilVote']==1 or $options['pro']['MinusVote']==1) and $options['general']['CheckCookie']==1){

        if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {

            $countSuserCookie = $wpdb->get_results( $wpdb->prepare(
                "
                        SELECT pid
                        FROM $tablenameIP
                        WHERE GalleryID = %d and CookieId = %s and RatingS = %d
                    ",
                $galeryID,$_COOKIE['contest-gal1ery-'.$galeryID.'-voting'],1
            ) );

            if(!empty($countSuserCookie)){
                if(count($countSuserCookie)){

                    foreach($countSuserCookie as $object){
                        ?>

                        <script>
                            var index = <?php echo json_encode($galeryIDuser) ?>;
                            var pid = <?php echo json_encode($object->pid);?>;

                            // wenn es bishierher gekommen ist, dann hat der user bereits das bild bewertet
                            // sollte es wieder eine id sein die der user schon mal bewertet hat, ann wir dieser eine 1 hinzugefügt
                            // cgJsCountSuser[pid] die der user nicht bewertet hat sind undefined
                            if(typeof cgJsData[index].cgJsCountSuser[pid] != 'undefined'){
                                var countS = parseInt(cgJsData[index].cgJsCountSuser[pid]);
                                countS = countS+1;
                                cgJsData[index].cgJsCountSuser[pid] = countS;
                            }
                            else{
                                cgJsData[index].cgJsCountSuser[pid] = 1;
                            }

                            cgJsData[index].lastVotedUserImageId = pid;

                        </script>

                        <?php

                    }

                }
            }

        }

    }
    //IP check
    else{

        if($options['general']['ShowOnlyUsersVotes']==1 or $options['general']['HideUntilVote']==1 or $options['pro']['MinusVote']==1){

            $countSuserIp = $wpdb->get_results( $wpdb->prepare(
                "
                        SELECT pid
                        FROM $tablenameIP
                        WHERE GalleryID = %d and IP = %s and RatingS = %d
                    ",
                $galeryID,$userIP,1
            ) );


            if(!empty($countSuserIp)){
                if(count($countSuserIp)){

                    foreach($countSuserIp as $object){
                        ?>

                        <script>

                            var index = <?php echo json_encode($galeryID) ?>;
                            var pid = <?php echo json_encode($object->pid);?>;

                            // wenn es bishierher gekommen ist, dann hat der user bereits das bild bewertet
                            // sollte es wieder eine id sein die der user schon mal bewertet hat, ann wir dieser eine 1 hinzugefügt
                            // cgJsCountSuser[pid] die der user nicht bewertet hat sind undefined
                            if(typeof cgJsData[index].cgJsCountSuser[pid] != 'undefined'){
                                var countS = parseInt(cgJsData[index].cgJsCountSuser[pid]);
                                countS = countS+1;
                                cgJsData[index].cgJsCountSuser[pid] = countS;
                            }
                            else{
                                cgJsData[index].cgJsCountSuser[pid] = 1;
                            }

                            cgJsData[index].lastVotedUserImageId = pid;

                        </script>

                        <?php

                    }

                }
            }

        }

    }
}
