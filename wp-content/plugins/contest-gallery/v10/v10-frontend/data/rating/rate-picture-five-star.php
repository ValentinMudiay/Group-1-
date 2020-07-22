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
$isFromSingleView = sanitize_text_field(sanitize_text_field($_REQUEST['isFromSingleView']));


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
        var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
        var ratingFileData = <?php echo json_encode($ratingFileData);?>;

        cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,galeryIDuser,false,false,ratingFileData,isFromSingleView);
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

            var galeryIDuser = <?php echo json_encode($galeryIDuser);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;

            cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,galeryIDuser,false,false,ratingFileData,isFromSingleView);
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
    $VotesPerUser = $options['general']['VotesPerUser'];
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
    $IsModernFiveStar = $options['pro']['IsModernFiveStar'];
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

            var ContestStartTimeFromPhp = <?php echo json_encode($ContestStartTime);?>;
            var ActualTimeSecondsFromPhp = <?php echo json_encode($time);?>;
            var ContestStart = <?php echo json_encode($ContestStart);?>;
            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;


            cgJsClass.gallery.function.general.time.photoContestStartTimeCheck(gid,ActualTimeSecondsFromPhp,ContestStartTimeFromPhp,ContestStart);
            cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView);

        </script>
        <?php

        return;
    }

    if(($time>=$ContestEndTime && $ContestEnd==1) OR $ContestEnd==2){
        $ContestEnd = 2;// photo contest will be ended this way
        ?>
        <script data-cg-processing="true">

            var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
            var ActualTimeSecondsFromPhp = <?php echo json_encode($time);?>;
            var ContestEnd = <?php echo json_encode($ContestEnd);?>;
            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;


            cgJsClass.gallery.function.general.time.photoContestEndTimeCheck(gid,ActualTimeSecondsFromPhp,ContestEndTimeFromPhp,ContestEnd);
            cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView);

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
                var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;

                cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,true,false,ratingFileData,isFromSingleView);
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

                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var CheckCookieAlertMessage = <?php echo json_encode($CheckCookieAlertMessage);?>;
                var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;

                cgJsData[gid].vars.cookieVotingId = <?php echo json_encode(md5(uniqid('cg',true)).time()); ?>;

                var cookieName = <?php echo json_encode('contest-gal1ery-'.$galeryID.'-voting');?>;
                cgJsClass.gallery.dynamicOptions.setCookie(gid,cookieName);
                var cookie = cgJsClass.gallery.dynamicOptions.getCookie(cookieName);

                if(!cookie){
                    cgJsClass.gallery.function.message.show(CheckCookieAlertMessage);
                    cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView);
                    cgJsClass.gallery.vars.cookiesNotAllowed = true;
                }

            </script>

            <?php

            // no return here!!! Upper script tag might be processed with another script tag

        }
    }


    $getRatingPicture = 0;
    $countVotesOfUserPerGallery = 0;
    $CookieId = '';
    if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting']) && $options['general']['CheckCookie'] == 1) {
        $CookieId = $_COOKIE['contest-gal1ery-'.$galeryID.'-voting'];
    }

    // Sowohl Rating mit 5 Sternen wie auch Rating mit 1 Stern sollen von einander getrennt behandelt werden.
    // Deswegen die Abfragen mit if AllowRating ....
    if ($CheckLogin == 1)
    {
        if(is_user_logged_in()){
            $getRatingPicture = $wpdb->get_var( $wpdb->prepare(
                "
			SELECT COUNT(*) AS NumberOfRows
			FROM $tablenameIP
			WHERE pid = %d and GalleryID = %d and WpUserId = %s and Rating > %s
		",
                $pictureID,$galeryID,$wpUserId,0
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
                WHERE pid = %d and GalleryID = %d and CookieId = %s and Rating > %s
            ",
                $pictureID,$galeryID,$CookieId,0
            ) );

        }
    }
    else
    {
        $getRatingPicture = $wpdb->get_var( $wpdb->prepare(
            "
            SELECT COUNT(*) AS NumberOfRows
            FROM $tablenameIP 
            WHERE pid = %d and GalleryID = %d and IP = %s and Rating > %s
        ",
            $pictureID,$galeryID,$userIP,0
        ) );
    }

    if($VotesPerUser!=0 AND $VotesPerUser!=''){

        if ($CheckLogin == 1)
        {
            if(is_user_logged_in()){
                $countVotesOfUserPerGallery = $wpdb->get_var( $wpdb->prepare(
                    "
						SELECT COUNT(*) AS NumberOfRows
						FROM $tablenameIP 
						WHERE GalleryID = %d and WpUserId = %s and Rating > %d
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
						WHERE GalleryID = %d and CookieId = %s and Rating > %d
					",
                    $galeryID,$CookieId,0
                ) );
            }
        }else{
            $countVotesOfUserPerGallery = $wpdb->get_var( $wpdb->prepare(
                "
						SELECT COUNT(*) AS NumberOfRows
						FROM $tablenameIP 
						WHERE GalleryID = %d and IP = %s and Rating > %d
					",
                $galeryID,$userIP,0
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

        $lastVotedIpRow = 0;
    if($CheckLogin){
        if(is_user_logged_in()){
            $lastVotedIpRow = $wpdb->get_row( "SELECT id, Rating FROM $tablenameIP WHERE Rating >= '1' && WpUserId = '$wpUserId' && GalleryID = '$galeryID' && pid = '$pictureID' ORDER BY id DESC LIMIT 1" );
            $countUserVotesForImage = $wpdb->get_var( "SELECT COUNT(*) AS NumberOfRows FROM $tablenameIP WHERE Rating >= '1' && WpUserId = '$wpUserId' && GalleryID = '$galeryID' && pid = '$pictureID'" );
        }
    }else if($CheckCookie){
        if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {
            $lastVotedIpRow = $wpdb->get_row( "SELECT id, Rating FROM $tablenameIP WHERE Rating >= '1' && CookieId = '$CookieId' && GalleryID = '$galeryID' && pid = '$pictureID' ORDER BY id DESC LIMIT 1" );
            $countUserVotesForImage = $wpdb->get_var( "SELECT COUNT(*) AS NumberOfRows FROM $tablenameIP WHERE Rating >= '1' && CookieId = '$CookieId' && GalleryID = '$galeryID' && pid = '$pictureID'" );

        }
    }
    else{
        $lastVotedIpRow = $wpdb->get_row( "SELECT id, Rating FROM $tablenameIP WHERE Rating >= '1' && IP = '$userIP' && GalleryID = '$galeryID' && pid = '$pictureID' ORDER BY id DESC LIMIT 1" );
        $countUserVotesForImage = $wpdb->get_var( "SELECT COUNT(*) AS NumberOfRows FROM $tablenameIP WHERE Rating >= '1' && IP = '$userIP' && GalleryID = '$galeryID' && pid = '$pictureID'" );
    }

    // maybe vote was done without reloading after changing configuration and user votes were reseted! Thats why this check has to be done!
        if(!empty($lastVotedIpRow)){


            $wpdb->delete( $tablenameIP, array( 'id' => $lastVotedIpRow->id ), array( '%d' ) );

            $countR = intval($ratingFileData['CountR'])-1;
            $rating = intval($ratingFileData['Rating'])-intval($lastVotedIpRow->Rating);
            $ratingFileData['CountR'] = $countR;


            if($IsModernFiveStar==1){
                $countRtype = 'CountR'.$lastVotedIpRow->Rating;
                $countRtoAdd = intval($ratingFileData['CountR'.$lastVotedIpRow->Rating])-1;
                // update main table
                $wpdb->update(
                    "$tablename",
                    array('CountR' => $countR,'Rating' => $rating,$countRtype => $countRtoAdd),
                    array('id' => $pictureID),
                    array('%d','%d','%d'),
                    array('%d')
                );
            }else{
                $wpdb->update(
                    "$tablename",
                    array('CountR' => $countR,'Rating' => $rating),
                    array('id' => $pictureID),
                    array('%d','%d'),
                    array('%d')
                );
            }


            $fp = fopen($jsonFile, 'w');
            $ratingFileData['CountR'] = intval($countR);
            $ratingFileData['Rating'] = intval($rating);

            if($IsModernFiveStar==1){
                $ratingFileData['CountR'.$lastVotedIpRow->Rating] = $countRtoAdd;
            }


            fwrite($fp,json_encode($ratingFileData));
            fclose($fp);

            $isSetUserVoteToNull = false;
            if(empty($countUserVotesForImage)){
                $isSetUserVoteToNull = true;
            }

            ?>
            <script data-cg-processing="true">

                var ContestEndTimeFromPhp = <?php echo json_encode($ContestEndTime);?>;
                var ContestEnd = <?php echo json_encode($ContestEnd);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;
                var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
                var isSetUserVoteToNull = <?php echo json_encode($isSetUserVoteToNull);?>;


                if(cgJsClass.gallery.function.general.time.photoContestEndTimeCheck(gid,ContestEndTimeFromPhp,ContestEnd)==true){
                    var Rating = <?php echo json_encode($lastVotedIpRow->Rating);?>;
                    Rating = parseInt(Rating);

                    cgJsClass.gallery.rating.setRatingFiveStar(pictureID,-1,-Rating,false,gid,false,false,ratingFileData,isFromSingleView,isSetUserVoteToNull);

                }else{
                    cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView,isSetUserVoteToNull);
                }


            </script>
            <?php

            cg_actualize_all_images_data_sort_values_file($galeryID,false,$IsModernFiveStar);

            return;


        }else{
            ?>
            <script data-cg-processing="true">

                var gid = <?php echo json_encode($galeryID);?>;
                var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;
                var isSetUserVoteToNull = <?php echo json_encode(true);?>;
                cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView,isSetUserVoteToNull);

            </script>
            <?php

            cg_actualize_all_images_data_sort_values_file($galeryID,false,$IsModernFiveStar);

            return;

        }



    }
    if($VotesInTime == 1){

        $TstampToCompare = $Tstamp-$VotesInTimeIntervalSeconds;

        if($CheckLogin) {

            if (is_user_logged_in()) {
                $VotesUserInTstamp = $wpdb->get_var("SELECT COUNT(*) FROM $tablenameIP WHERE Tstamp > '$TstampToCompare' && WpUserId='$wpUserId' && GalleryID = '$galeryID' && Rating>='1'");
            }

        }else if($CheckCookie){
            if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])) {
                $VotesUserInTstamp = $wpdb->get_var( "SELECT COUNT(*) FROM $tablenameIP WHERE Tstamp > '$TstampToCompare' && CookieId='$CookieId' && GalleryID = '$galeryID' && Rating>='1'");
            }
        }else{
            $VotesUserInTstamp = $wpdb->get_var( "SELECT COUNT(*) FROM $tablenameIP WHERE Tstamp > '$TstampToCompare' && IP='$userIP' && GalleryID = '$galeryID' && Rating>='1'");
        }

        if(empty($VotesUserInTstamp)){
            $VotesUserInTstamp = 0;
        }

        if($VotesInTime == 1 && ($VotesUserInTstamp>=$VotesInTimeQuantity)){

            ?>
            <script data-cg-processing="true">

                var gid = <?php echo json_encode($galeryID);?>;
                var pictureID = <?php echo json_encode($pictureID);?>;
                var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
                var ratingFileData = <?php echo json_encode($ratingFileData);?>;

                cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,true,ratingFileData,isFromSingleView);


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
            var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;


            cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView);
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
            var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;

            cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,true,false,ratingFileData,isFromSingleView);
            cgJsClass.gallery.function.message.show(cgJsClass.gallery.language.AllVotesUsed);
           // cgJsData[gid].vars.allVotesUsed = 1;

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
            $VoteDate = date('d-M-Y H:i:s', $Tstamp);

            // speichern in der IP Tabelle
            $wpdb->query( $wpdb->prepare(
                "
                        INSERT INTO $tablenameIP
                        ( id, IP, GalleryID, pid, Rating, RatingS,WpUserId,VoteDate,Tstamp,OptionSet,CookieId)
                        VALUES ( %s,%s,%d,%d,%d,%d,%d,%s,%d,%s,%s )
                    ",
                '',$userIP,$galeryID,$pictureID,$rateValue,0,$wpUserId,$VoteDate,$Tstamp,$OptionSet,$CookieId
            ) );


            // speichern in der Haupttabelle und im File

            $countR = intval($ratingFileData['CountR'])+1;
            $rating = intval($ratingFileData['Rating'])+intval($rateValue);

            if($IsModernFiveStar==1){
                $countRtype = 'CountR'.$rateValue;
                $countRtoAdd = intval($ratingFileData['CountR'.$rateValue])+1;
                // update main table
                $wpdb->update(
                    "$tablename",
                    array('CountR' => $countR,'Rating' => $rating,$countRtype => $countRtoAdd),
                    array('id' => $pictureID),
                    array('%d','%d','%d'),
                    array('%d')
                );
            }else{
                $wpdb->update(
                    "$tablename",
                    array('CountR' => $countR,'Rating' => $rating),
                    array('id' => $pictureID),
                    array('%d','%d'),
                    array('%d')
                );
            }


            $fp = fopen($jsonFile, 'w');
            $ratingFileData['CountR'] = intval($countR);
            $ratingFileData['Rating'] = intval($rating);

            if($IsModernFiveStar==1){
                $ratingFileData['CountR'.$rateValue] = $countRtoAdd;
            }

            fwrite($fp,json_encode($ratingFileData));
            fclose($fp);

        }


        ?>
        <script data-cg-processing="true">

            var gid = <?php echo json_encode($galeryID);?>;
            var pictureID = <?php echo json_encode($pictureID);?>;
            var ratingFileData = <?php echo json_encode($ratingFileData);?>;
            var cookieVotingJustActivated = <?php echo json_encode($cookieVotingJustActivated);?>;
            var isFromSingleView = <?php echo json_encode($isFromSingleView);?>;

            if(!cookieVotingJustActivated){
                var rateValue = <?php echo json_encode($rateValue);?>;

                cgJsData[gid].lastVotedUserImageId = pictureID;
                cgJsClass.gallery.rating.setRatingFiveStar(pictureID,1,parseInt(rateValue),false,gid,false,false,ratingFileData,isFromSingleView);

            }else{
                cgJsClass.gallery.rating.setRatingFiveStar(pictureID,0,0,false,gid,false,false,ratingFileData,isFromSingleView);
                cgJsClass.gallery.function.message.show('Check Cookie voting activated');
            }



        </script>
        <?php
        if($cookieVotingJustActivated == false){
            cg_actualize_all_images_data_sort_values_file($galeryID,false,$IsModernFiveStar);
        }

    }

}


?>