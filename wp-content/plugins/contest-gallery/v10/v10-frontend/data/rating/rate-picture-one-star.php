<?php
if(!defined('ABSPATH')){exit;}

$galeryID = intval(sanitize_text_field($_REQUEST['gid']));
$pictureID = intval(sanitize_text_field($_REQUEST['pid']));
$rateValue = intval(sanitize_text_field($_REQUEST['value']));
$minusVoteNow = intval(sanitize_text_field($_REQUEST['minusVoteNow']));
$galeryIDuser = sanitize_text_field($_REQUEST['galeryIDuser']);
$galleryHash = sanitize_text_field($_REQUEST['galleryHash']);
$galleryHashDecoded = wp_salt( 'auth').'---cngl1---'.$galeryIDuser;
$galleryHashToCompare = md5($galleryHashDecoded);

/*error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);*/
//$testLala = $_POST['lala'];

//------------------------------------------------------------
// ----------------------------------------------------------- Bilder bewerten ----------------------------------------------------------
//------------------------------------------------------------


$tablename = $wpdb->prefix ."contest_gal1ery";
$tablenameIP = $wpdb->prefix ."contest_gal1ery_ip";
$tablenameOptions = $wpdb->prefix ."contest_gal1ery_options";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";


$wp_upload_dir = wp_upload_dir();
$options = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-options.json';
$fp = fopen($options, 'r');
$options =json_decode(fread($fp,filesize($options)),true);
fclose($fp);

$jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/image-data/image-data-'.$pictureID.'.json';
$fp = fopen($jsonFile, 'r');
$ratingFileData =json_decode(fread($fp,filesize($jsonFile)),true);
fclose($fp);


if (($rateValue>5 or $rateValue<1) or ($galleryHash != $galleryHashToCompare)){
    ?>
    <script data-cg-processing="true">

        var message = <?php echo json_encode('Please do not manipulate!');?>;
        var galeryIDuser = <?php echo json_encode($galeryIDuser);?>;
        var pictureID = <?php echo json_encode($pictureID);?>;
        var ratingFileData = <?php echo json_encode($ratingFileData);?>;

        cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,galeryIDuser,false,false,ratingFileData);
        cgJsClass.gallery.function.message.show(message);

    </script>
    <?php

    return;
}
else {

    $explodeHash = explode('---cngl1---',$galleryHashDecoded);
    if($explodeHash[1]==$galeryID.'-u'){
        ?>
        <script data-cg-processing="true">
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;
            var galeryIDuser = <?php echo json_encode($galeryIDuser);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,galeryIDuser,false,false,ratingFileData);
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.YouCanNotVoteInOwnGallery);

        </script>
        <?php

        return;
    }


   // $getOptions = $wpdb->get_row( "SELECT AllowGalleryScript, CheckLogin, AllowRating, ShowOnlyUsersVotes, IpBlock, VotesPerUser, HideUntilVote, RatingOutGallery, ContestEnd, ContestEndTime FROM $tablenameOptions WHERE id = '$galeryID'" );
    $ShowOnlyUsersVotes = $options['general']['ShowOnlyUsersVotes'];
    $CheckLogin = $options['general']['CheckLogin'];
    $CheckIp= (!empty($options['general']['CheckIp'])) ? 1 : 0;
    $CheckCookie = (!empty($options['general']['CheckCookie'])) ? 1 : 0;
    $CheckCookieAlertMessage = (!empty($options['general']['CheckCookieAlertMessage'])) ? $options['general']['CheckCookieAlertMessage'] : 'Please allow cookies and reload the page to be able to vote.';
    $AllowRating = $options['general']['AllowRating'];
    $IpBlock = $options['general']['IpBlock'];// ATTENTION! IpBlock means show only vote per Picture Configuration
    $VotesPerUser = intval($options['general']['VotesPerUser']);
    $HideUntilVote = $options['general']['HideUntilVote'];
    $RatingOutGallery = $options['general']['RatingOutGallery'];
    $ContestStart = (!empty($options['general']['ContestStart'])) ? $options['general']['ContestStart'] : 0;
    $ContestStartTime = (!empty($options['general']['ContestStartTime'])) ? $options['general']['ContestStartTime'] : 0;
    $ContestEnd = $options['general']['ContestEnd'];
    $ContestEndTime = $options['general']['ContestEndTime'];
    $MinusVote = $options['pro']['MinusVote'];
    $VotesInTime = $options['pro']['VotesInTime'];
    $VotesInTimeQuantity = $options['pro']['VotesInTimeQuantity'];
    $VotesInTimeIntervalSeconds = $options['pro']['VotesInTimeIntervalSeconds'];
    $VoteNotOwnImage = (!empty($options['pro']['VoteNotOwnImage'])) ? $options['pro']['VoteNotOwnImage'] : 0;
    $countVotesOfUserPerGallery = 0;

    $cookieVotingJustActivated = false;
    $OptionSet = '';

    if($CheckLogin==1){
        $OptionSet = 'CheckLogin';
    }else if($CheckCookie==1){
        $OptionSet = 'CheckCookie';
    }else if($CheckIp==1){
        $OptionSet = 'CheckIp';
    }else{
        $OptionSet = 'CheckIp';
    }

    $time = time();

    if($time < $ContestStartTime && $ContestStart==1){
        ?>
        <script data-cg-processing="true">

            var ActualTimeSecondsFromPhp = <?php echo json_encode($time);?>;
            var ContestStartTimeFromPhp = <?php echo json_encode($ContestStartTime);?>;
            var ContestStart = <?php echo json_encode($ContestStart);?>;
            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;


            cgJsClass.gallery.function.general.time.photoContestStartTimeCheck(gid,ActualTimeSecondsFromPhp,ContestStartTimeFromPhp,ContestStart);
            cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,false,false,ratingFileData);

        </script>
        <?php

        return;
    }


    if(($time>=$ContestEndTime && $ContestEnd==1) OR $ContestEnd==2){
        $ContestEnd = 2;// photo contest will be ended this way
        ?>
        <script data-cg-processing="true">

            var ActualTimeSecondsFromPhp = <?php echo json_encode($time);?>;
            var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
            var ContestEnd = <?php echo json_encode($ContestEnd);?>;
            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;

            cgJsClass.gallery.function.general.time.photoContestEndTimeCheck(gid,ActualTimeSecondsFromPhp,ContestEndTimeFromPhp,ContestEnd);
            cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,false,false,ratingFileData);

        </script>
        <?php

        return;
    }


    if((time()>=$ContestEndTime && $ContestEnd==1) OR $ContestEnd==2){
        $ContestEnd = 2;// photo contest will be ended this way
        ?>
        <script data-cg-processing="true">

            var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
            var ContestEnd = <?php echo json_encode($ContestEnd);?>;
            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;

            cgJsClass.gallery.function.general.time.photoContestEndTimeCheck(gid,ContestEndTimeFromPhp,ContestEnd);
            cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,false,false,ratingFileData);

        </script>
        <?php

        return;
    }


    if(is_user_logged_in()){
        $wpUserId = get_current_user_id();
    }
    else{
        $wpUserId=0;
    }

    $userIP = cg_get_user_ip();


    if($VoteNotOwnImage==1 && empty($minusVoteNow) && $CheckCookie!=1){//does not need to work for check cookie in the moment

        // Get IP of uploaded image. Get WpUserId of uploaded image to go sure.
        $uploadedImageIPandWpUserId = $wpdb->get_row( "SELECT IP, WpUserId FROM $tablename WHERE id = $pictureID ORDER BY id DESC LIMIT 1" );

        $isOwnImage = false;

        if($CheckLogin==1 && ($uploadedImageIPandWpUserId->WpUserId==$wpUserId && !empty($wpUserId))){
            $isOwnImage = true;
        }else if($CheckIp==1 && ($uploadedImageIPandWpUserId->IP==$userIP && !empty($userIP))){
            $isOwnImage = true;
        }

        if($isOwnImage){

            ?>
            <script data-cg-processing="true">

                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;

                cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,true);
                cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.ItIsNotAllowedToVoteForYourOwnPicture);

            </script>

            <?php

            return;

        }

    }


    if($CheckCookie==1) {
        if(!isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {

            ?>
            <script data-cg-processing="true">

                var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
                var ContestEnd = <?php echo json_encode($ContestEnd);?>;
                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var CheckCookieAlertMessage = <?php echo json_encode($CheckCookieAlertMessage);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;


                cgJsData[gid].vars.cookieVotingId = <?php echo json_encode(md5(uniqid('cg',true)).time()); ?>;

                var cookieName = <?php echo json_encode('contest-gal1ery-'.$galeryID.'-voting');?>;
                cgJsClass.gallery.dynamicOptions.setCookie(gid,cookieName);
                var cookie = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

                if(!cookie){
                    cgJsClass.gallery.function.message.show(CheckCookieAlertMessage);
                    cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,false,false,ratingFileData);
                    cgJsClass.gallery.vars.cookiesNotAllowed = true;
                }

            </script>

            <?php

        }
    }


    $getRatingPicture = 0;
    $countVotesOfUserPerGallery = 0;
    $CookieId = '';
    if(!empty($_COOKIE['contest-gal1ery-'.$galeryID.'-voting']) && $options['general']['CheckCookie'] == 1) {
        $CookieId = $_COOKIE['contest-gal1ery-'.$galeryID.'-voting'];
    }

    // Prüfen ob ein bestimmtes Bild von dem User bewertet wurde
    if ($CheckLogin == 1)
    {

        if(is_user_logged_in()){
            $getRatingPicture = $wpdb->get_var( $wpdb->prepare(
                "
			SELECT COUNT(*) AS NumberOfRows
			FROM $tablenameIP 
			WHERE pid = %d and GalleryID = %d and WpUserId = %s and RatingS = %s
		",
                $pictureID,$galeryID,$wpUserId,1
            ) );
        }



    }
    else if ($CheckCookie == 1)
    {
        if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {

            $getRatingPicture = $wpdb->get_var( $wpdb->prepare(
                "
        SELECT COUNT(*) AS NumberOfRows
        FROM $tablenameIP 
        WHERE pid = %d and GalleryID = %d and CookieId = %s and RatingS = %s
    ",
                $pictureID,$galeryID,$CookieId,1
            ) );
        }

    }
    else
    {
        $getRatingPicture = $wpdb->get_var( $wpdb->prepare(
            "
            SELECT COUNT(*) AS NumberOfRows
            FROM $tablenameIP 
            WHERE pid = %d and GalleryID = %d and IP = %s and RatingS = %s
        ",
            $pictureID,$galeryID,$userIP,1
        ) );
    }


    // Prüfen wieviele Bewertungen der user insgesamt abgegeben hat
    if($VotesPerUser!=0 AND $VotesPerUser!=''){

        if ($CheckLogin == 1)
        {
            if(is_user_logged_in()){
                $countVotesOfUserPerGallery = $wpdb->get_var( $wpdb->prepare(
                    "
                    SELECT COUNT(*) AS NumberOfRows
                    FROM $tablenameIP 
                    WHERE GalleryID = %d and WpUserId = %s and RatingS > %d
                ",
                    $galeryID,$wpUserId,0
                ) );
            }

        }
        else if ($CheckCookie == 1)
        {
            if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {
                $countVotesOfUserPerGallery = $wpdb->get_var( $wpdb->prepare(
                    "
                    SELECT COUNT(*) AS NumberOfRows
                    FROM $tablenameIP 
                    WHERE GalleryID = %d and CookieId = %s and RatingS > %d
                ",
                    $galeryID,$CookieId,0
                ) );
            }
        }
        else
        {
            $countVotesOfUserPerGallery = $wpdb->get_var( $wpdb->prepare(
                "
						SELECT COUNT(*) AS NumberOfRows
						FROM $tablenameIP 
						WHERE GalleryID = %d and IP = %s and RatingS = %d
					",
                $galeryID,$userIP,1
            ) );
        }

    }

    $allVotesUsed = 0;
    if(($countVotesOfUserPerGallery >= $VotesPerUser) && ($VotesPerUser!=0)){
        $allVotesUsed = 1;
    }

    $Tstamp = time();

    $VotesUserInTstamp = 0;


    if($MinusVote == 1 && !empty($minusVoteNow)){

        $lastVotedIpId = 0;

        if ($CheckLogin == 1){
            if(is_user_logged_in()){
                $lastVotedIpId = $wpdb->get_var( "SELECT id FROM $tablenameIP WHERE RatingS = '1' && WpUserId = '$wpUserId' && GalleryID = '$galeryID' && pid = '$pictureID' ORDER BY id DESC LIMIT 1" );
                $countUserVotesForImage = $wpdb->get_var( "SELECT COUNT(*) AS NumberOfRows FROM $tablenameIP WHERE RatingS = '1' && WpUserId = '$wpUserId' && GalleryID = '$galeryID' && pid = '$pictureID'" );
            }
        }
        else if ($CheckCookie == 1){
            if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {
                $lastVotedIpId = $wpdb->get_var( "SELECT id FROM $tablenameIP WHERE RatingS = '1' && CookieId = '$CookieId' && GalleryID = '$galeryID' && pid = '$pictureID' ORDER BY id DESC LIMIT 1" );
                $countUserVotesForImage = $wpdb->get_var( "SELECT COUNT(*) AS NumberOfRows FROM $tablenameIP WHERE RatingS = '1' && CookieId = '$CookieId' && GalleryID = '$galeryID' && pid = '$pictureID'" );

            }
        }else{
            $lastVotedIpId = $wpdb->get_var( "SELECT id FROM $tablenameIP WHERE RatingS = '1' && IP = '$userIP' && GalleryID = '$galeryID' && pid = '$pictureID' ORDER BY id DESC LIMIT 1" );
            $countUserVotesForImage = $wpdb->get_var( "SELECT COUNT(*) AS NumberOfRows FROM $tablenameIP WHERE RatingS = '1' && IP = '$userIP' && GalleryID = '$galeryID' && pid = '$pictureID'" );
        }

        if(!empty($lastVotedIpId)){

            $wpdb->delete( $tablenameIP, array( 'id' => $lastVotedIpId ), array( '%d' ) );

            $countS = intval($ratingFileData['CountS'])-1;
            $ratingFileData['CountS'] = $countS;

            $fp = fopen($jsonFile, 'w');
            fwrite($fp,json_encode($ratingFileData));
            fclose($fp);

            // update main table
            $wpdb->update(
                "$tablename",
                array('CountS' => $countS),
                array('id' => $pictureID),
                array('%d'),
                array('%d')
            );

            $isSetUserVoteToNull = false;
            if(empty($countUserVotesForImage)){
                $isSetUserVoteToNull = true;
            }

            ?>
            <script data-cg-processing="true">

                var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
                var ContestEnd = <?php echo json_encode($ContestEnd);?>;
                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;
                var isSetUserVoteToNull = <?php echo json_encode($isSetUserVoteToNull);?>;

                if(typeof cgJsData[gid].cgJsCountSuser[pictureID] != 'undefined'){
                    if(cgJsData[gid].cgJsCountSuser[pictureID] > 0){
                        var countS = parseInt(cgJsData[gid].cgJsCountSuser[pictureID])-1;
                        cgJsData[gid].cgJsCountSuser[pictureID] = countS;
                    }
                }

                cgJsClass.gallery.rating.setRatingOneStar(pictureID,-1,false,gid,false,false,ratingFileData,isSetUserVoteToNull);


            </script>
            <?php

            cg_actualize_all_images_data_sort_values_file($galeryID);

            return;


        }else{


            ?>
            <script data-cg-processing="true">

                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;
                var isSetUserVoteToNull = <?php echo json_encode(true);?>;

                if(typeof cgJsData[gid].cgJsCountSuser[pictureID] != 'undefined'){
                    if(cgJsData[gid].cgJsCountSuser[pictureID] > 0){
                        var countS = parseInt(cgJsData[gid].cgJsCountSuser[pictureID])-1;
                        cgJsData[gid].cgJsCountSuser[pictureID] = countS;
                    }
                }

                cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,false,false,ratingFileData,isSetUserVoteToNull);


            </script>
            <?php

            cg_actualize_all_images_data_sort_values_file($galeryID);

            return;


        }





    }

    if($VotesInTime == 1){

        $TstampToCompare = $Tstamp-$VotesInTimeIntervalSeconds;

        if($CheckLogin){
            if(is_user_logged_in()){
                $VotesUserInTstamp = $wpdb->get_var( "SELECT COUNT(*) FROM $tablenameIP WHERE Tstamp > '$TstampToCompare' && WpUserId='$wpUserId' && GalleryID = '$galeryID' && RatingS='1'");
            }
        }
        else if($CheckCookie){
            if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {
                $VotesUserInTstamp = $wpdb->get_var( "SELECT COUNT(*) FROM $tablenameIP WHERE Tstamp > '$TstampToCompare' && CookieId='$CookieId' && GalleryID = '$galeryID' && RatingS='1'");
            }
        }else{
            $VotesUserInTstamp = $wpdb->get_var( "SELECT COUNT(*) FROM $tablenameIP WHERE Tstamp > '$TstampToCompare' && IP='$userIP' && GalleryID = '$galeryID' && RatingS='1'");
        }

        if($VotesInTime == 1 && ($VotesUserInTstamp>=$VotesInTimeQuantity)){

            ?>
            <script data-cg-processing="true">

                var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
                var ContestEnd = <?php echo json_encode($ContestEnd);?>;
                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;

                cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,false,true,ratingFileData);

            </script>
            <?php
            return;

        }

    }



    // THREE CASES HERE:
    // 1. One vote per picture
    // 2. All votes used
    // 3. No restrictions. Vote always.

    // ATTENTION!!! IpBlock means show only vote per Picture Configuration
    if (!empty($getRatingPicture) and $IpBlock==1){

        // One vote per picture case
        // Picture already rated!!!!

        ?>
        <script data-cg-processing="true">

            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;


             cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid);
             cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.YouHaveAlreadyVotedThisPicture);


        </script>
        <?php

    }
    else if (($countVotesOfUserPerGallery >= $VotesPerUser) && ($VotesPerUser!=0)){

        // All votes used case

        ?>
        <script data-cg-processing="true">

            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;

            cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid,true);
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.AllVotesUsed);
        //    cgJsData[gid].vars.allVotesUsed = 1;

        </script>
        <?php

    }
    else{

        // KANN NUR EINTRETEN WENN DIE OPTIONS GERADE GEÄNDERT WURDEN UND KEIN SEITENRELOAD STATTFAND
        // ES SOLL NICHT VERARBEITET WERDEN WEIL ES SEIN KÖNNTE DAS COOKIES BEIM NUTZER GAR NICHT ERLAUBT WAREN,
        if($CheckCookie==1) {
            if(!isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {
              //  return;
                $cookieVotingJustActivated = true;
            }
        }

        if($cookieVotingJustActivated == false){

            // vote done!!! Save and forward
            //if(!($MinusVote == 1 && $minusVoteNow)){
                $countS = intval($ratingFileData['CountS'])+1;
           // }

            $VoteDate = date('d-M-Y H:i:s', $Tstamp);

            // insert in tableIP
            $wpdb->query( $wpdb->prepare(
                "
					INSERT INTO $tablenameIP
					( id, IP, GalleryID, pid, Rating, RatingS,WpUserId,VoteDate,Tstamp,OptionSet,CookieId)
					VALUES ( %s,%s,%d,%d,%d,%d,%d,%s,%d,%s,%s)
				",
                '',$userIP,$galeryID,$pictureID,0,1,$wpUserId,$VoteDate,$Tstamp,$OptionSet,$CookieId
            ) );


            // update main table
            $wpdb->update(
                "$tablename",
                array('CountS' => $countS),
                array('id' => $pictureID),
                array('%d'),
                array('%d')
            );

            $fp = fopen($jsonFile, 'w');
            $ratingFileData['CountS'] = intval($countS);
            fwrite($fp,json_encode($ratingFileData));
            fclose($fp);


        }

        ?>
            <script data-cg-processing="true">

                var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
                var gid = <?php echo json_encode($galeryID);?>;
                var ContestEnd = <?php echo json_encode($ContestEnd);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var cookieVotingJustActivated = <?php echo json_encode($cookieVotingJustActivated);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;


                if(!cookieVotingJustActivated){

                    var allVotesUsed = <?php echo json_encode($allVotesUsed);?>;

                    if(typeof cgJsData[gid].cgJsCountSuser[pictureID] == 'undefined'){
                        cgJsData[gid].cgJsCountSuser[pictureID] = 1;
                    }else{
                        cgJsData[gid].cgJsCountSuser[pictureID] = parseInt(cgJsData[gid].cgJsCountSuser[pictureID])+1;
                    }

                    cgJsData[gid].lastVotedUserImageId = pictureID;
                    cgJsClass.gallery.rating.setRatingOneStar(pictureID,1,false,gid,false,false,ratingFileData);


                }else{
                    cgJsClass.gallery.rating.setRatingOneStar(pictureID,0,false,gid);
                    cgJsClass.gallery.function.message.show('Check Cookie voting activated');
                }


            </script>
            <?php


        if($cookieVotingJustActivated == false){
            cg_actualize_all_images_data_sort_values_file($galeryID);
        }


    }

}


?>