<?php
if(!defined('ABSPATH')){exit;}

global $wpdb;

$galeryNR = @$_GET['option_id'];
$GalleryID = @$_GET['option_id'];

$isEditOptions = true;

$replyMailNote = '<b>(Note for testing: mail is send to and "Reply mail" can not be the same)</b>';

$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
$tablename_options_input = $wpdb->prefix . "contest_gal1ery_options_input";
$tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
$tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";
$tablename_email_admin = $wpdb->prefix . "contest_gal1ery_mail_admin";
$tablenameemail = $wpdb->prefix . "contest_gal1ery_mail";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
//$tablename_mail_gallery = $wpdb->prefix . "contest_gal1ery_mail_gallery";
$tablename_mail_confirmation = $wpdb->prefix . "contest_gal1ery_mail_confirmation";

/*$tinymceStyle = '<style type="text/css">
				   .switch-tmce {display:inline;}
				   .wp-editor-area{height:120px;}
				   .wp-editor-tabs{float:left;}
				   body#tinymce{width:unset !important;}
				   </style>';

// TINY MCE Settings here
$settingsHTMLarea = array(
    "media_buttons"=>false,
    'editor_class' => 'cg-small-textarea',
    'default_post_edit_rows'=> 10,
    "teeny" => true,
    "dfw" => true,
    'editor_css' => $tinymceStyle
);*/

//$optionID = @@$_POST['option_id'];
$galeryID = $GalleryID;
include(__DIR__ ."/../../../check-language.php");


$selectSQL1 = $wpdb->get_results( "SELECT * FROM $tablenameOptions WHERE id = '$galeryNR'" );
$selectSQL2 = $wpdb->get_results( "SELECT * FROM $tablename_options_input WHERE GalleryID = '$galeryNR'" );
$selectSQL3 = $wpdb->get_results( "SELECT * FROM $tablename_options_visual WHERE GalleryID = '$galeryNR'" );


$selectSQL4 = $wpdb->get_results( "SELECT * FROM $tablename_pro_options WHERE GalleryID = '$galeryNR'" );

/*var_dump($galeryNR);
var_dump("SELECT * FROM $tablename_pro_options WHERE GalleryID = '$galeryNR'");
var_dump($tablenameOptions);
var_dump($tablename_pro_options);

echo "<pre>";
print_r($selectSQL4);
echo "</pre>";*/

foreach($selectSQL4 as $value4){

    $ForwardAfterRegUrl = html_entity_decode(stripslashes($value4->ForwardAfterRegUrl));
    $ForwardAfterRegText = contest_gal1ery_convert_for_html_output_without_nl2br($value4->ForwardAfterRegText);
    $ForwardAfterLoginUrlCheck = ($value4->ForwardAfterLoginUrlCheck==1) ? 'checked' : '';
    $ForwardAfterLoginUrlStyle = ($value4->ForwardAfterLoginUrlCheck==1) ? 'style="height:100px;"' : 'disabled style="background-color:#e0e0e0;height:100px;"';
    $ForwardAfterLoginUrl = contest_gal1ery_no_convert($value4->ForwardAfterLoginUrl);
    $ForwardAfterLoginTextCheck = ($value4->ForwardAfterLoginTextCheck==1) ? 'checked' : '';
    $ForwardAfterLoginTextStyle = ($value4->ForwardAfterLoginTextCheck==1) ? 'style="height:100px;"' : 'disabled style="background-color:#e0e0e0;height:100px;"';
    $ForwardAfterLoginText = contest_gal1ery_convert_for_html_output_without_nl2br($value4->ForwardAfterLoginText);
    $TextEmailConfirmation = contest_gal1ery_convert_for_html_output_without_nl2br($value4->TextEmailConfirmation);
    $TextAfterEmailConfirmation = contest_gal1ery_convert_for_html_output_without_nl2br($value4->TextAfterEmailConfirmation);
    $RegMailAddressor = $value4->RegMailAddressor;
    $RegMailReply = $value4->RegMailReply;
    $RegMailSubject = $value4->RegMailSubject;
    $UploadRequiresCookieMessage = $value4->UploadRequiresCookieMessage;
    $RegUserUploadOnlyText = contest_gal1ery_convert_for_html_output_without_nl2br($value4->RegUserUploadOnlyText);

    $RegUserGalleryOnly = ($value4->RegUserGalleryOnly==1) ? 'checked' : '';

    $CheckLoginUpload = ($value4->RegUserUploadOnly==1) ? 'checked' : '';
    $CheckCookieUpload = ($value4->RegUserUploadOnly==2) ? 'checked' : '';
    $CheckIpUpload = ($value4->RegUserUploadOnly==3) ? 'checked' : '';

    $RegUserGalleryOnlyText = contest_gal1ery_convert_for_html_output_without_nl2br($value4->RegUserGalleryOnlyText);
    $RegUserMaxUpload = (empty($value4->RegUserMaxUpload)) ? '' : $value4->RegUserMaxUpload;
    $PreselectSort = (empty($value4->PreselectSort)) ? 'date_descend' : $value4->PreselectSort;

    $FbLikeNoShare = ($value4->FbLikeNoShare==1) ? 'checked' : '';

    $Manipulate = ($value4->Manipulate==1) ? 'checked' : '';
    $MinusVote = ($value4->MinusVote==1) ? 'checked' : '';
    $SliderFullWindow = ($value4->SliderFullWindow==1) ? 'checked' : '';
    $VoteNotOwnImage = ($value4->VoteNotOwnImage==1) ? 'checked' : '';
    $RegMailOptional = ($value4->RegMailOptional==1) ? 'checked' : '';

    if(empty($value4->SlideTransition)){
        $value4->SlideTransition = 'translateX';
    }

    $checkIpCheckUpload = '';

    if(empty($RegUserMaxUpload) && empty($value4->RegUserUploadOnly)){// do this for upgrade version 10.9.8.8.1
        $checkIpCheckUpload = 'checked';
    }

    $SlideHorizontal = ($value4->SlideTransition=='translateX') ? 'checked' : '';
    $SlideVertical = ($value4->SlideTransition=='slideDown') ? 'checked' : '';
    $Search = ($value4->Search==1) ? 'checked' : '';
    $GalleryUpload = ($value4->GalleryUpload==1) ? 'checked' : '';
    $GalleryUploadOnlyUser = ($value4->GalleryUploadOnlyUser==1) ? 'checked' : '';
    $ShowNickname = ($value4->ShowNickname==1) ? 'checked' : '';
    $ShowExif = ($value4->ShowExif==1) ? 'checked' : '';
    $GalleryUploadConfirmationText = contest_gal1ery_convert_for_html_output_without_nl2br($value4->GalleryUploadConfirmationText);
    $GalleryUploadTextAfter = contest_gal1ery_convert_for_html_output_without_nl2br($value4->GalleryUploadTextAfter);
    $GalleryUploadTextBefore = contest_gal1ery_convert_for_html_output_without_nl2br($value4->GalleryUploadTextBefore);

    $VotesInTime = ($value4->VotesInTime==1) ? 'checked' : '';
    $VotesInTimeQuantity = html_entity_decode(stripslashes($value4->VotesInTimeQuantity));
    $VotesInTimeIntervalReadable = html_entity_decode(stripslashes($value4->VotesInTimeIntervalReadable));
    $VotesInTimeIntervalReadableExploded = explode(':',$VotesInTimeIntervalReadable);
    $cg_date_hours_vote_interval = $VotesInTimeIntervalReadableExploded[0];


    /*        if($cg_date_hours_vote_interval<10){
                $cg_date_hours_vote_interval = '0'.$cg_date_hours_vote_interval;
            }*/

    if(!empty($VotesInTimeIntervalReadableExploded[1])){
        $cg_date_mins_vote_interval = $VotesInTimeIntervalReadableExploded[1];
    }else{
        $cg_date_mins_vote_interval = '00';
    }

    /*        if($cg_date_mins_vote_interval<10){
                $cg_date_mins_vote_interval = '0'.$cg_date_mins_vote_interval;
            }*/

    $VotesInTimeIntervalSeconds = html_entity_decode(stripslashes($value4->VotesInTimeIntervalSeconds));
    $VotesInTimeIntervalAlertMessage = contest_gal1ery_no_convert($value4->VotesInTimeIntervalAlertMessage);

    $HideRegFormAfterLogin = ($value4->HideRegFormAfterLogin==1) ? 'checked' : '';
    $HideRegFormAfterLoginShowTextInstead = ($value4->HideRegFormAfterLoginShowTextInstead==1) ? 'checked' : '';
    $HideRegFormAfterLoginTextToShow = contest_gal1ery_convert_for_html_output_without_nl2br($value4->HideRegFormAfterLoginTextToShow);

    /*
            $VotesInTime = (!empty($_POST['VotesInTime'])) ? '1' : '0';
            $VotesInTimeQuantity = (!empty($_POST['VotesInTimeQuantity'])) ? @$_POST['VotesInTimeQuantity'] : $VotesInTimeQuantity;
            if(!empty($_POST['cg_date_hours_vote_interval']) && !empty($_POST['cg_date_mins_vote_interval'])){
                $_POST['VotesInTimeIntervalReadable'] = $_POST['cg_date_hours_vote_interval'].":".$_POST['cg_date_mins_vote_interval'];
                $_POST['VotesInTimeIntervalSeconds'] = intval($_POST['cg_date_hours_vote_interval'])*(intval($_POST['cg_date_mins_vote_interval'])*60);
            }
            $VotesInTimeIntervalReadable = (!empty($_POST['VotesInTimeIntervalReadable'])) ? @$_POST['VotesInTimeIntervalReadable'] : $VotesInTimeIntervalReadable;
            $VotesInTimeIntervalSeconds = (!empty($_POST['VotesInTimeIntervalSeconds'])) ? @$_POST['VotesInTimeIntervalSeconds'] : $VotesInTimeIntervalSeconds;
            $VotesInTimeIntervalAlertMessage = (!empty($_POST['VotesInTimeIntervalAlertMessage'])) ? @$_POST['VotesInTimeIntervalAlertMessage'] : $VotesInTimeIntervalAlertMessage;*/

}



$checkDataFormOutput = $wpdb->get_results("SELECT * FROM $tablename_form_input WHERE GalleryID = $galeryNR and (Field_Type = 'comment-f' or Field_Type = 'text-f' or Field_Type = 'email-f')");

$selectSQLemailAdmin = $wpdb->get_row( "SELECT * FROM $tablename_email_admin WHERE GalleryID = '$galeryNR'" );
$ContentAdminMail = $selectSQLemailAdmin->Content;
$ContentAdminMail = contest_gal1ery_convert_for_html_output_without_nl2br($ContentAdminMail);

$selectGalleryLookOrder = $wpdb->get_results( "SELECT SliderLookOrder, ThumbLookOrder, HeightLookOrder, RowLookOrder  FROM $tablenameOptions WHERE id = '$galeryNR'" );

// Reihenfolge der Gallerien wird ermittelt

$order = array();

foreach($selectGalleryLookOrder[0] as $key => $value){
    $order[$value]=$key;
}

ksort($order);

// Reihenfolge der Gallerien wird ermittelt --- ENDE


foreach($selectSQL1 as $value){

    $selectedCheckComments = ($value->AllowComments==1) ? 'checked' : '';
    $selectedCheckRating = ($value->AllowRating==1) ? 'checked' : '';
    $selectedCheckRating2 = ($value->AllowRating==2) ? 'checked' : '';
    $selectedCheckFbLike = ($value->FbLike==1) ? 'checked' : '';
    $selectedCheckFbLikeGallery = ($value->FbLikeGallery==1) ? 'checked' : '';
    $selectedCheckFbLikeGalleryVote = ($value->FbLikeGalleryVote==1) ? 'checked' : '';
    $selectedRatingOutGallery = ($value->RatingOutGallery==1) ? 'checked' : '';
    $selectedCommentsOutGallery = ($value->CommentsOutGallery==1) ? 'checked' : '';
    $selectedCheckIp = ($value->IpBlock==1) ? 'checked' : '';
    $selectedCheckFb = ($value->FbLike==1) ? 'checked' : '';
    $CheckLogin = ($value->CheckLogin==1) ? 'checked' : '';
    $CheckIp = ($value->CheckIp==1) ? 'checked' : '';
    $CheckCookie = ($value->CheckCookie==1) ? 'checked' : '';
    $RegistryUserRole = html_entity_decode(stripslashes($value->RegistryUserRole));

    if($CheckLogin == '' && $CheckIp == '' && $CheckCookie == ''){
        $CheckLogin = 'checked';
    }

    $CheckCookieAlertMessage = contest_gal1ery_no_convert($value->CheckCookieAlertMessage);


    if(empty($CheckCookieAlertMessage)){
        $CheckCookieAlertMessage = 'Please allow cookies to vote';
    }

    @$HideUntilVote = ($value->HideUntilVote==1) ? 'checked' : '';
    @$ShowOnlyUsersVotes = ($value->ShowOnlyUsersVotes==1) ? 'checked' : '';
    @$HideInfo = ($value->HideInfo==1) ? 'checked' : '';

    //echo "<br>HideInfo: $HideInfo<br>";

    @$ActivateUpload = ($value->ActivateUpload==1) ? 'checked' : '';
    @$ContestEnd = ($value->ContestEnd==1) ? 'checked' : '';
    @$ContestEndInstant = ($value->ContestEnd==2) ? 'checked' : '';
    @$ContestEndTime = date('Y-m-d',(!empty($value->ContestEndTime)) ? $value->ContestEndTime : 0);
    @$ContestStart = ($value->ContestStart==1) ? 'checked' : '';
    @$ContestStartTime = date('Y-m-d',(!empty($value->ContestStartTime)) ? $value->ContestStartTime : 0);

    $ContestEndTimeHours = '';
    $ContestEndTimeMins = '';
    if(!empty($ContestEndTime)){
        @$ContestEndTimeHours = date('H',($value->ContestEndTime==='') ? 0 : $value->ContestEndTime);
        @$ContestEndTimeMins = date('i',($value->ContestEndTime==='') ? 0 : $value->ContestEndTime);
    }

    $ContestStartTimeHours = '';
    $ContestStartTimeMins = '';
    if(!empty($ContestStartTime)){
        @$ContestStartTimeHours = date('H',($value->ContestStartTime==='') ? 0 : $value->ContestStartTime);
        @$ContestStartTimeMins = date('i',($value->ContestStartTime==='') ? 0 : $value->ContestStartTime);
    }

    echo "<input type='hidden' id='getContestEndTime' value='".@$ContestEndTime."'>";
    echo "<input type='hidden' id='getContestStartTime' value='".@$ContestStartTime."'>";
    $FullSize = ($value->FullSize==1) ? 'checked' : '';// full screen mode!
    $FullSizeGallery = ($value->FullSizeGallery==1) ? 'checked' : '';// full window mode!
    $FullSizeSlideOutStart = ($value->FullSizeSlideOutStart==1) ? 'checked' : '';
    $OnlyGalleryView = ($value->OnlyGalleryView==1) ? 'checked' : '';
    $SinglePicView = ($value->SinglePicView==1) ? 'checked' : '';
    $ScaleOnly = ($value->ScaleOnly==1) ? 'checked' : '';
    $ScaleAndCut = ($value->ScaleAndCut==1) ? 'checked' : '';

    $AllowGalleryScript = ($value->AllowGalleryScript==1) ? 'checked' : '';

    $InfiniteScroll = $value->InfiniteScroll;

    //echo "<br>InfiniteScroll: $InfiniteScroll<br>";


    //$InfiniteScroll = ($value->InfiniteScroll==1) ? 'checked' : '';


    $FullSizeImageOutGallery = ($value->FullSizeImageOutGallery==1) ? 'checked' : '';
    $FullSizeImageOutGalleryNewTab = ($value->FullSizeImageOutGalleryNewTab==1) ? 'checked' : '';
    $ShowAlwaysInfoSlider = ($value->ShowAlwaysInfoSlider==1) ? 'checked' : '';
    $HeightLook = ($value->HeightLook==1) ? 'checked' : '';
    $RowLook = ($value->RowLook==1) ? 'checked' : '';
    $ThumbsInRow = ($value->ThumbsInRow==1) ? 'checked' : '';
    $LastRow = ($value->LastRow==1) ? 'checked' : '';
    $AllowSort = ($value->AllowSort==1) ? 'checked' : '';
    $RandomSort = ($value->RandomSort==1) ? 'checked' : '';
    $RandomSortButton = ($value->RandomSortButton==1) ? 'checked' : '';
    $PicsInRow = $value->PicsInRow;
    $PicsPerSite = $value->PicsPerSite;
    $VotesPerUser = $value->VotesPerUser;
    if($VotesPerUser==0){$VotesPerUser='';}
    $GalleryName1 = $value->GalleryName;
    $ShowAlways = $value->ShowAlways;
    @$selectedShowAlways = ($value->ShowAlways==1) ? 'checked' : '';


    //echo "<br>GalleryName: $GalleryName<br>";

    // Forward images to URL options

    @$Use_as_URL = $wpdb->get_var( "SELECT Use_as_URL FROM $tablename_form_input WHERE GalleryID = '$galeryNR' AND Use_as_URL = '1' ");
    //echo "<br>Use_as_URL: $Use_as_URL<br>";
    @$ForwardToURL = ($value->ForwardToURL==1) ? 'checked' : '';
    @$ForwardType = ($value->ForwardType==2) ? 'checked' : '';
    //echo $ForwardType;
    //Prüfen ob Forward URL aus dem Slider oder aus der Gallerie weiterleiten soll
    @$ForwardFrom = $value->ForwardFrom;
    @$ForwardFromSlider = ($ForwardFrom==1) ? 'checked' : '';
    @$ForwardFromGallery = ($ForwardFrom==2) ? 'checked' : '';
    @$ForwardFromSinglePic = ($ForwardFrom==3) ? 'checked' : '';


    // Forward images to URL options --- ENDE


    $ThumbLook = ($value->ThumbLook==1) ? 'checked' : '';
    $SliderLook = ($value->SliderLook==1) ? 'checked' : '';
    $AdjustThumbLook = ($value->AdjustThumbLook==1) ? 'checked' : '';

    $WidthThumb = $value->WidthThumb;
    $HeightThumb = $value->HeightThumb;
    $DistancePics = $value->DistancePics;
    $DistancePicsV = $value->DistancePicsV;

    $WidthGallery = $value->WidthGallery;
    $HeightGallery = $value->HeightGallery;
    $HeightLookHeight = $value->HeightLookHeight;
    $Inform = $value->Inform;
    $InformAdmin = ($value->InformAdmin==1) ? 'checked' : '';
    $MaxResJPGwidth = $value ->MaxResJPGwidth;
    $MaxResJPGheight = $value ->MaxResJPGheight;
    //Leeren Wert kann man by MySQL nicht einfügen. Es entsteht immer eine NULL
    if($MaxResJPGwidth==0){$MaxResJPGwidth='';}
    if($MaxResJPGheight==0){$MaxResJPGheight='';}
    $MaxResPNGwidth = $value ->MaxResPNGwidth;
    $MaxResPNGheight = $value ->MaxResPNGheight;
    if($MaxResPNGwidth==0){$MaxResPNGwidth='';}
    if($MaxResPNGheight==0){$MaxResPNGheight='';}
    $MaxResGIFwidth = $value ->MaxResGIFwidth;
    $MaxResGIFheight = $value ->MaxResGIFheight;
    if($MaxResGIFwidth==0){$MaxResGIFwidth='';}
    if($MaxResGIFheight==0){$MaxResGIFheight='';}
    $MaxResJPGon = ($value->MaxResJPGon==1) ? 'checked' : '';
    $MaxResPNGon = ($value->MaxResPNGon==1) ? 'checked' : '';
    $MaxResGIFon = ($value->MaxResGIFon==1) ? 'checked' : '';
    $FbLikeGoToGalleryLink = (empty($value->FbLikeGoToGalleryLink)) ? '' : $value->FbLikeGoToGalleryLink;
    $FbLikeGoToGalleryLink = contest_gal1ery_no_convert($FbLikeGoToGalleryLink);

    $ActivatePostMaxMB = ($value->ActivatePostMaxMB==1) ? 'checked' : '';
    $PostMaxMB = $value ->PostMaxMB;
    if($PostMaxMB==0){$PostMaxMB='';}

    $ActivateBulkUpload = ($value->ActivateBulkUpload==1) ? 'checked' : '';
    $BulkUploadQuantity = $value ->BulkUploadQuantity;
    if($BulkUploadQuantity==0){$BulkUploadQuantity='';}

    $BulkUploadMinQuantity = $value->BulkUploadMinQuantity;
    if($BulkUploadMinQuantity==0){$BulkUploadMinQuantity='';}

    $GalleryName = $value->GalleryName;

}



//print_r($selectSQL2);

foreach($selectSQL2 as $value2){

    // Wenn 0 dann confirmation text, wenn 1 dann URL Weiterleitung
    $Forward = ($value2->Forward==1) ? 'checked' : '';
    $ForwardUploadConf = ($value2->Forward==0) ? 'checked' : '';
    $ForwardUploadURL = ($value2->Forward==1) ? 'checked' : '';
    $ShowFormAfterUpload = ($value2->ShowFormAfterUpload==1) ? 'checked' : '';
    //echo "$Forward";
    $forward_url_disabled = ($value2->Forward==1) ? 'style="width:500px;"' : 'disabled style="background: #e0e0e0;width:500px;"';
    $Forward_URL = $value2->Forward_URL;
    $Forward_URL = contest_gal1ery_no_convert($Forward_URL);
    $Confirmation_Text = $value2->Confirmation_Text;
    $Confirmation_Text = contest_gal1ery_convert_for_html_output_without_nl2br($Confirmation_Text);
    $Confirmation_Text_Disabled = ($value2->Forward==0) ? '' : 'disabled';

}

//	print_r($selectSQL3);

foreach($selectSQL3 as $value3){

    $Field1IdGalleryView = $value3->Field1IdGalleryView;
    $ThumbViewBorderWidth = $value3->ThumbViewBorderWidth;
    $ThumbViewBorderRadius = $value3->ThumbViewBorderRadius;
    $ThumbViewBorderColor = $value3->ThumbViewBorderColor;
    $ThumbViewBorderColorPlaceholder = (empty($ThumbViewBorderColor)) ? "placeholder='000000'" : '';
    $ThumbViewBorderOpacity = $value3->ThumbViewBorderOpacity;
    $HeightViewBorderWidth = $value3->HeightViewBorderWidth;
    $HeightViewBorderRadius = $value3->HeightViewBorderRadius;
    $HeightViewBorderColor = $value3->HeightViewBorderColor;
    $HeightViewBorderColorPlaceholder = (empty($HeightViewBorderColor)) ? "placeholder='000000'" : '';
    $HeightViewBorderOpacity = $value3->HeightViewBorderOpacity;
    $HeightViewSpaceWidth = $value3->HeightViewSpaceWidth;
    $HeightViewSpaceHeight = $value3->HeightViewSpaceHeight;
    $RowViewBorderWidth = $value3->RowViewBorderWidth;
    $RowViewBorderRadius = $value3->RowViewBorderRadius;
    $RowViewBorderColor = $value3->RowViewBorderColor;
    $RowViewBorderColorPlaceholder = (empty($RowViewBorderColor)) ? "placeholder='000000'" : '';
    $RowViewBorderOpacity = $value3->RowViewBorderOpacity;
    $RowViewSpaceWidth = $value3->RowViewSpaceWidth;
    $RowViewSpaceHeight = $value3->RowViewSpaceHeight;
    $TitlePositionGallery = $value3->TitlePositionGallery;
    $RatingPositionGallery = $value3->RatingPositionGallery;
    $CommentPositionGallery = $value3->CommentPositionGallery;
    $ActivateGalleryBackgroundColor = ($value3->ActivateGalleryBackgroundColor==1) ? 'checked' : '' ;
    $GalleryBackgroundColor = $value3->GalleryBackgroundColor;
    $GalleryBackgroundColorPlaceholder = (empty($GalleryBackgroundColor)) ? "placeholder='000000'" : '';
    $GalleryBackgroundOpacity = $value3->GalleryBackgroundOpacity;
    $OriginalSourceLinkInSlider = ($value3->OriginalSourceLinkInSlider==1) ? 'checked' : '';
    $PreviewInSlider = ($value3->PreviewInSlider==1) ? 'checked' : '';
    $FeControlsStyleWhite = ($value3->FeControlsStyle=='white' OR empty($value3->FeControlsStyle)) ? 'checked' : '';
    $FeControlsStyleBlack = ($value3->FeControlsStyle=='black') ? 'checked' : '';
    $AllowSortOptions = (!empty($value3->AllowSortOptions)) ? $value3->AllowSortOptions : 'date-desc,date-asc,rate-desc,rate-asc,rate-average-desc,rate-average-asc,comment-desc,comment-asc,random';

}

$AllowSortOptionsArray = explode(',',$AllowSortOptions);


//echo "source:".$OriginalSourceLinkInSlider;

$selectedRatingPositionGalleryLeft = ($RatingPositionGallery==1) ? "checked" : "";
$selectedRatingPositionGalleryCenter = ($RatingPositionGallery==2) ? "checked" : "";
$selectedRatingPositionGalleryRight = ($RatingPositionGallery==3) ? "checked" : "";

$selectedCommentPositionGalleryLeft = ($CommentPositionGallery==1) ? "checked" : "";
$selectedCommentPositionGalleryCenter = ($CommentPositionGallery==2) ? "checked" : "";
$selectedCommentPositionGalleryRight = ($CommentPositionGallery==3) ? "checked" : "";


$selectedTitlePositionGalleryLeft = ($TitlePositionGallery==1) ? "checked" : "";
$selectedTitlePositionGalleryCenter = ($TitlePositionGallery==2) ? "checked" : "";
$selectedTitlePositionGalleryRight = ($TitlePositionGallery==3) ? "checked" : "";

if(@$Field1IdGalleryView and @$Field1IdGalleryView!=0){$enabledTitlePositionGalleryLeft = 'enabled';}
else{$enabledTitlePositionGalleryLeft = 'disabled';}



$GalleryBackgroundColorFields = ($value3->ActivateGalleryBackgroundColor==0) ? 'disabled' : '' ;
//$ThumbLookFieldsChecked = ($value->RowLook==0) ? 'checked' : '' ;
$GalleryBackgroundColorStyle = ($value3->ActivateGalleryBackgroundColor==0) ? 'background-color:#e0e0e0;' : '' ;

//echo "<br>ThumbViewBorderOpacity: $ThumbViewBorderOpacity<br>";
//echo "<br>HeightViewBorderOpacity: $HeightViewBorderOpacity<br>";
//	echo "<br>RowViewBorderOpacity: $RowViewBorderOpacity<br>";

// Disable enable RowLook and ThumbLook Fields

$RowLookFields = ($value->RowLook==0) ? 'disabled' : '' ;
$RowLookFieldsStyle = ($value->RowLook==0) ? 'background-color:#e0e0e0;' : '' ;
$HeightLookFields = ($value->HeightLook==0) ? 'disabled' : '' ;
$HeightLookFieldsStyle = ($value->HeightLook==0) ? 'background-color:#e0e0e0;' : '' ;
$ThumbLookFields = ($value->ThumbLook==0) ? 'disabled' : '' ;
//$ThumbLookFieldsChecked = ($value->RowLook==0) ? 'checked' : '' ;
$ThumbLookFieldsStyle = ($value->ThumbLook==0) ? 'background-color:#e0e0e0;' : '' ;

// Disable enable RowLook Fields  --------- END

// Inform set or not

$checkInform = ($Inform==1) ? 'checked' : '' ;

$id = $galeryNR;


//Update 4.00: Single Pic View Prüfung

if($AllowGalleryScript!= 'checked' AND $FullSizeImageOutGallery != 'checked' AND $SinglePicView != 'checked' AND $OnlyGalleryView != 'checked'){

    $SinglePicView = "checked";

}

//Update 4.00: Single Pic View Prüfung --- ENDE


//echo $SinglePicView;


// Get email text options

$selectSQLemail = $wpdb->get_row( "SELECT * FROM $tablenameemail WHERE GalleryID = '$galeryNR'" );



$selectSQLmailConfirmation = $wpdb->get_row("SELECT * FROM $tablename_mail_confirmation WHERE GalleryID = '$galeryNR'" );

$mConfirmSendConfirm = ($selectSQLmailConfirmation->SendConfirm==1) ? 'checked' : '' ;

//$selectSQLmailGallery = $wpdb->get_row("SELECT * FROM $tablename_mail_gallery WHERE GalleryID = '$galeryNR'" );

/*$mGallerySendToImageOff = ($selectSQLmailGallery->SendToImageOff==1) ? 'checked' : '' ;
$mGallerySendToNotConfirmedUsers = ($selectSQLmailGallery->SendToNotConfirmedUsers==1) ? 'checked' : '' ;*/


//$content = (@$_POST['editpost']) ? @$_POST['editpost'] : $selectSQLemail->Content;
//$contentUserMail = $selectSQLemail->Content;
$contentUserMail = contest_gal1ery_convert_for_html_output_without_nl2br($selectSQLemail->Content);


//$content = html_entity_decode(stripslashes($content));

//nl2br($contentBr);

// Get email text options --- ENDE


require_once(dirname(__FILE__) . "/../nav-menu.php");

/*

echo <<<HEREDOC
<div class="bs-example" id="cgBootstrap">

    <div class="bs-example">

        <div class="row" style="position:relative;" id="cgScrollSpyContainer">

            <div class="col-md-4 col-lg-4">

               <nav id="navbar-example2" class="navbar navbar-default navbar-static" role="navigation">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-example-js-navbar-scrollspy"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand" href="#">Project Name</a> </div>
                  <div class="collapse navbar-collapse bs-example-js-navbar-scrollspy">
                    <ul class="nav navbar-nav">
                      <li class="active"><a href="#multiple">Multiple pics options</a></li>
                      <li class=""><a href="#single">Single pic options</a></li>
                    </ul>
                  </div>
                </div>
              </nav>

            </div>

            <div class="col-md-8 col-lg-8">

               <form>

                  <div data-spy="scroll" data-target="#navbar-example2" data-offset="0" class="scrollspy-example">
                     <div class="row" id="multiple">
                        <div class="col-md-12">
                             <div class="row" id="multiple">
                                <div class="col-md-12">
                                     <h4>Multiple pics</h4>
                                </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="PicsPerSite">
                                            Number of images per screen (Pagination):
                                        </label>
                                        <input class="form-control" type="text" name="PicsPerSite" id="PicsPerSite" maxlength="3" value="$PicsPerSite">
                                    </div>
                                 </div>
                                 <div class="col-md-12">
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-primary">
                                            <input type="checkbox" name="FullSizeGallery"  id="FullSizeGallery" $FullSizeGallery />
                                            Allow full window gallery <strong>(Full window button is not visible if gallery already full window)</strong>
                                        </label>
                                    </div>
                                 </div>
                             </div>
                        </div>
                     </div>
                     <div class="row" id="single">
                        <div class="col-md-12">
                             <h4>single pic</h4>
                             <p>Ad leggings keytar, brunch id art party dolor labore. Pitchfork yr enim lo-fi before they sold out qui. Tumblr farm-to-table bicycle rights whatever. Anim keffiyeh carles cardigan. Velit seitan mcsweeney's photo booth 3 wolf moon irure. Cosby sweater lomo jean shorts, williamsburg hoodie minim qui you probably haven't heard of them et cardigan trust fund culpa biodiesel wes anderson aesthetic. Nihil tattooed accusamus, cred irony biodiesel keffiyeh artisan ullamco consequat.</p>
                         </div>
                     </div>

                  </div>

            </form>

            </div>

        </div>

    </div>

</div>

HEREDOC;




echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<br/>";
*/



echo "<form action='?page=contest-gallery/index.php&edit_options=true&option_id=$galeryNR' method='post' class='cg_load_backend_submit cg_load_backend_submit_save_data'>";


wp_nonce_field( 'cg_admin');

//echo '<input type="hidden" name="editOptions" value="true" >';
echo '<input type="hidden" name="option_id" value="'.$galeryNR.'" >';

//echo '<input type="hidden" id="checkLoginBgColor" value="'.$checkLoginBgColor.'" >';

$i=0;

echo <<<HEREDOC
<div id="cgGoTopOptions" class='cg_hide'>
^
</div>
<div id="cgOptionsLoader" class="cg_hide cg-lds-dual-ring-div-gallery-hide cg-lds-dual-ring-div-gallery-hide-mainCGallery">
    <div class="cg-lds-dual-ring-gallery-hide cg-lds-dual-ring-gallery-hide-mainCGallery">
    </div>
</div>
HEREDOC;

if(!empty($_POST['changeSize'])){

    echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>";

}


echo <<<HEREDOC

		
    <div id="cg_main_options" class="cg_hidden">
        <div id="cg_main_options_tab">
            <ul class="tabs" data-persist="true">
                <li class='cg_view_select cg_selected' data-view="#view1"><a data-view="#view1" data-href="viewHelper1">Multiple pics options</a></li>
                <li class='cg_view_select' data-view="#view2"><a data-view="#view2" data-href="viewHelper2">Single pic options</a></li>
                <li class='cg_view_select' data-view="#view3"><a data-view="#view3" data-href="viewHelper3">Gallery options</a></li>
                <li class='cg_view_select' data-view="#view31"><a data-view="#view31" data-href="viewHelper31">Voting options</a></li>
                <li class='cg_view_select' data-view="#view4"><a data-view="#view4" data-href="viewHelper4">Upload options</a></li>
                <li class='cg_view_select' data-view="#view5"><a data-view="#view5" data-href="viewHelper5">Registration options</a></li>
HEREDOC;
    $styleTabContents="style='border-radius:none !important;'";
    echo <<<HEREDOC
                <div id="cg_main_options_tab_second_row">
                    <div id="cg_main_options_tab_second_row_inner">
                        <li class='cg_view_select' data-view="#view6"><a data-view="#view6" data-href="viewHelper6">Login options</a></li>
                        <li class='cg_view_select' data-view="#view7"><a data-view="#view7" data-href="viewHelper7">E-mail confirmation e-mail</a></li>
                        <li class='cg_view_select' data-view="#view8"><a data-view="#view8" data-href="viewHelper8">Image activation e-mail</a></li>
                        <li class='cg_view_select' data-view="#view9"><a data-view="#view9" data-href="viewHelper9">Translations</a></li>
                        <li id="cgSaveOptionsNavButton"><input type="button" class="cg_backend_button_gallery_action" value="Save all options"></li>
                    </div>
                </div>
HEREDOC;

    echo <<<HEREDOC
            </ul>
        </div>
        <div id="cg_main_options_content" class="tabcontents" $styleTabContents>
            <h4 id="view1" class="cg_view_header">Multiple pics options</h4>
            <div class="cg_view cg_selected cgMultiplePicsOptions">
HEREDOC;


/*
 * $tinymceStyle = '<style type="text/css">
				   .wp-editor-area{height:300px;}
				   </style>';*/

/*$timymceSettings = array(
    'plugins' => "preview",
    'menubar' => "view",
    'toolbar' => "preview",
    'plugin_preview_width'=> 650,
    'selector' => "textarea"
);*/

/*$settingsHTMLarea = array(
    "media_buttons"=>false,
    'editor_class' => 'html-active',
    'default_post_edit_rows'=> 10,
    "textarea_name"=>'upload[]',
    "teeny" => true,
    "dfw" => true,
    'editor_css' => $tinymceStyle
);*/



//	echo '<input type="hidden" name="order[]" value="t" >';
echo "<table>";
echo "<tr><td>";
//echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
echo '<p><b><u>General options</u></b></p>';
echo "</td>";
echo "<td>";
echo '<p></p>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Number of images per screen (Pagination):</p>';
echo "</td>";
echo "<td>";
echo '<input type="text" name="PicsPerSite" id="PicsPerSite" maxlength="3" value="'.$PicsPerSite.'"><br/>';
echo "</td>";
echo "</tr>";

/*echo "<tr>";
echo "<td style='padding-left:20px;width:340px;'>";
echo '<p>Activate gallery background color:</p>';
echo "</td>";
echo "<td style='padding-left:0px;'>";
echo '<input type="checkbox" name="ActivateGalleryBackgroundColor" id="ActivateGalleryBackgroundColor" ' . $ActivateGalleryBackgroundColor  . '><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Gallery background color:</p>';
echo "</td>";
echo "<td>";
echo '<input type="text" id="GalleryBackgroundColor" name="GalleryBackgroundColor['.$GalleryBackgroundOpacity.']" class="demo" maxlength="7"  data-opacity="'.$GalleryBackgroundOpacity.'" value="'.$GalleryBackgroundColor.'" ' . $GalleryBackgroundColorFields  . ' style="' . $GalleryBackgroundColorStyle  . ' height:27px;">';

//echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
echo "</td>";
echo "</tr>";*/

echo "<tr>";
echo "<td>";
//echo '<p>Enable full window button:<br><strong>(Full window button is not visible<br>if gallery already full window)</strong></p>';
echo '<p>Enable full window button:</p>';
echo "</td>";
echo "<td style='padding-left:0px;'>";
echo '<input type="checkbox" name="FullSizeGallery" id="FullSizeGallery" ' . $FullSizeGallery . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
//echo '<p>Enable full screen button:<br><strong>(Will appear when joining full window.<br>In gallery upload form will be always<br>opened in full window because image upload<br>is not supported in full screen by browsers.)</strong></p>';
echo '<p>Enable full screen button:<br><strong>(Will appear when joining full window)</strong></p>';
echo "</td>";
echo "<td style='padding-left:0px;'>";
echo '<input type="checkbox" name="FullSize" id="FullSize" ' . $FullSize . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Allow search for images:<br/>(Search by fields content, categories,<br>picture name or EXIF data (if available).</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="Search" id="Search" ' . $Search . '><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Allow sort:<br/><strong>(Order by rating is not available if <br>"Show only user votes" or <br>"Hide voting until user vote" is activated)</strong></p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="AllowSort" id="AllowSort" ' . $AllowSort . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Allow sort options:<br><span id="cgAllowSortDependsOnMessage" class="cg_hide">(Allow sort has to be activated)</span></p>';
echo "</td>";
echo "<td>";

$cgDateDescSortCheck = (in_array('date-desc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgDateAscSortCheck = (in_array('date-asc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgRateDescSortCheck = (in_array('rate-desc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgRateAscSortCheck = (in_array('rate-asc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgRateDescAverageSortCheck = (in_array('rate-average-desc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgRateAscAverageSortCheck = (in_array('rate-average-asc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgCommentDescSortCheck = (in_array('comment-desc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgCommentAscSortCheck = (in_array('comment-asc',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';
$cgRandomSortCheck = (in_array('random',$AllowSortOptionsArray)) ? '' : 'cg_unchecked';

echo "<input type='hidden' name='AllowSortOptionsArray[]' value='date-desc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='date-asc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='rate-desc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='rate-asc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='rate-average-desc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='rate-average-asc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='comment-desc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='comment-asc' class='cg-allow-sort-input' />";
echo "<input type='hidden' name='AllowSortOptionsArray[]' value='random' class='cg-allow-sort-input' />";

echo '<div id="cgAllowSortOptionsContainer">
<label class="cg-allow-sort-option '.$cgDateDescSortCheck.'" data-cg-target="date-desc"><span class="cg-allow-sort-option-cat">Date desc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgDateAscSortCheck.'" data-cg-target="date-asc"><span class="cg-allow-sort-option-cat">Date asc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgRateDescSortCheck.'" data-cg-target="rate-desc"><span class="cg-allow-sort-option-cat">Rating desc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgRateAscSortCheck.'" data-cg-target="rate-asc"><span class="cg-allow-sort-option-cat">Rating asc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgRateDescAverageSortCheck.'" data-cg-target="rate-average-desc"><span class="cg-allow-sort-option-cat">Rating average desc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgRateAscAverageSortCheck.'" data-cg-target="rate-average-asc"><span class="cg-allow-sort-option-cat">Rating average asc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgCommentDescSortCheck.'" data-cg-target="comment-desc"><span class="cg-allow-sort-option-cat">Comments desc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgCommentAscSortCheck.'" data-cg-target="comment-asc"><span class="cg-allow-sort-option-cat">Comments asc</span><span class="cg-allow-sort-option-icon"></span></label>
<label class="cg-allow-sort-option '.$cgRandomSortCheck.'" data-cg-target="random"><span class="cg-allow-sort-option-cat">Random</span><span class="cg-allow-sort-option-icon"></span></label>
</div>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Preselect order when page loads:<br><span id="cgPreselectSortMessage">(Random sort has to be deactivated)</span></p>';
echo "</td>";
echo "<td>";
echo "<select name='PreselectSort' id='PreselectSort'>";

$PreselectSort_date_descend_selected = ($PreselectSort=='date_descend') ? 'selected' : '';
$PreselectSort_date_ascend_selected = ($PreselectSort=='date_ascend') ? 'selected' : '';
$PreselectSort_rating_descend_selected = ($PreselectSort=='rating_descend') ? 'selected' : '';
$PreselectSort_rating_ascend_selected = ($PreselectSort=='rating_ascend') ? 'selected' : '';
$PreselectSort_rating_descend_average_selected = ($PreselectSort=='rating_descend_average') ? 'selected' : '';
$PreselectSort_rating_ascend_average_selected = ($PreselectSort=='rating_ascend_average') ? 'selected' : '';
$PreselectSort_comments_descend_selected = ($PreselectSort=='comments_descend') ? 'selected' : '';
$PreselectSort_comments_ascend_selected = ($PreselectSort=='comments_ascend') ? 'selected' : '';

echo "<option value='date_descend' $PreselectSort_date_descend_selected>Date descending</option>";
echo "<option value='date_ascend' $PreselectSort_date_ascend_selected>Date ascending</option>";
echo "<option value='rating_descend' $PreselectSort_rating_descend_selected>Rating descending</option>";
echo "<option value='rating_ascend' $PreselectSort_rating_ascend_selected>Rating ascending</option>";
echo "<option value='rating_descend_average' $PreselectSort_rating_descend_average_selected>Rating average descending</option>";
echo "<option value='rating_ascend_average' $PreselectSort_rating_ascend_average_selected>Rating average ascending</option>";
echo "<option value='comments_descend' $PreselectSort_comments_descend_selected>Comments descending</option>";
echo "<option value='comments_ascend' $PreselectSort_comments_ascend_selected>Comments ascending</option>";
echo "</select>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Random sort:<br>(Each page load)</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="RandomSort" id="RandomSort" ' . $RandomSort . '><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Random sort button:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="RandomSortButton" id="RandomSortButton" ' . $RandomSortButton . '><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>White color sites top controls style:<br>(Spinning loader color is also included)</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="FeControlsStyle" id="FeControlsStyleWhite" ' . $FeControlsStyleWhite . ' value="white"/><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Black color sites top controls style:<br>(Spinning loader color is also included)</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="FeControlsStyle" id="FeControlsStyleBlack" ' . $FeControlsStyleBlack . ' value="black"><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>In gallery upload form button</p>';
echo "</td>";
echo "<td>";
echo '<a href="#cgActivateInGalleryUploadForm"><p>Deactivate by deactivating in gallery upload form</p></a>';
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br>";
echo "<hr>";
echo "<br>";


echo "<div id='cg_options_sortable'>";

//print_r($order);

$showSliderViewOption = false;
$showSliderViewOptionSet = false;

if(!in_array("SliderLookOrder",$order)){
    $showSliderViewOption = true;
}


foreach($order as $key => $value){

    $i++;

    if($value=="SliderLookOrder" or $showSliderViewOption==true && $showSliderViewOptionSet==false){

        $showSliderViewOptionSet = true;

        // 1 = Height, 2 = Thumb, 3 = Row
        if($InfiniteScroll==2){$InfiniteScrollThumb="checked";}
        else{$InfiniteScrollThumb="";}

        echo "<div class='cg_options_sortableContainer'>";
        echo '<input type="hidden" name="order[]" value="s" >';
        echo "<table>";
        echo "<tr><td>";
        //echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
        echo '<p><strong>Slider view</strong></p>';
        echo "</td>";
        echo "<td class='cg_options_sortableDiv'>";
        if($key==1 or $key==2){ $cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';

        echo '<div class="cg_options_order"><u>'.$i.'. Order</u></div><div class="cg_options_order_change_order cg_move_view_to_bottom'.$cgHideClass.'"><i></i></div>';
        if($key==2 or $key==3){$cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';
        echo '<div class="cg_options_order_change_order cg_move_view_to_top'.$cgHideClass.'"><i></i></div>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Activate Slider View:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" name="SliderLook" id="SliderLook" ' . $SliderLook  . '><br/>';
        echo "</td>";
        echo "</tr>";


        echo "</table>";
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "</div>";

    }

    if($value=="ThumbLookOrder"){

        // 1 = Height, 2 = Thumb, 3 = Row
        if($InfiniteScroll==2){$InfiniteScrollThumb="checked";}
        else{$InfiniteScrollThumb="";}

        echo "<div class='cg_options_sortableContainer'>";
        echo '<input type="hidden" name="order[]" value="t" >';
        echo "<table>";
        echo "<tr><td>";
        //echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
        echo '<p><b>Gallery Thumb View</b></p>';
        echo "</td>";
        echo "<td class='cg_options_sortableDiv'>";
        if($key==1 or $key==2){ $cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';

        echo '<div class="cg_options_order"><u>'.$i.'. Order</u></div><div class="cg_options_order_change_order cg_move_view_to_bottom'.$cgHideClass.'"><i></i></div>';
        if($key==2 or $key==3){$cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';
        echo '<div class="cg_options_order_change_order cg_move_view_to_top'.$cgHideClass.'"><i></i></div>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Activate Thumb View:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" name="ThumbLook" id="ThumbLook" ' . $ThumbLook  . '><br/>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Width thumbs (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="WidthThumb" id="WidthThumb" maxlength="3" value="'.$WidthThumb.'"><br/>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Height thumbs (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="HeightThumb" id="HeightThumb" maxlength="3" value="'.$HeightThumb.'"><br/>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Distance between thumbs horizontal (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="DistancePics" id="DistancePics" maxlength="2" value="'.$DistancePics.'"><br/>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td >";
        echo '<p>Distance between thumbs vertical (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="DistancePicsV" id="DistancePicsV" maxlength="2"  value="'.$DistancePicsV.'"><br/>';
        echo "</td>";
        echo "</tr>";

        /*
        echo "<tr>";
        echo "<td style='padding-left:20px;width:340px;'>";
        echo '<p>Adjust view on parent tag:</p>';
        echo "</td>";
        echo "<td style='padding-left:0px;'>";
        echo '<input type="checkbox" name="AdjustThumbLook" id="AdjustThumbLook" ' . $ThumbLookFields  . ' style="' . $ThumbLookFieldsStyle  . '"><br/>';
        echo "</td>";
        echo "</tr>";*/

/*        echo "<tr>";
        echo "<td>";
        echo '<p>Border width (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="ThumbViewBorderWidth" maxlength="2" id="ThumbViewBorderWidth" value="'.$ThumbViewBorderWidth.'"><br/>';
        echo "</td>";
        echo "</tr>";*/

        /*echo "<tr>";
        echo "<td>";
        echo '<p>border radius (%):<br>';
        echo '(50% =< images getting completly round<br>';
        echo 'Effect begins with 6% and higher <br/>';
        echo 'Rating, Comment and Info on an image<br>';
        echo 'in a gallery will be centered vertically.)';
        echo '</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="ThumbViewBorderRadius" id="ThumbViewBorderRadius" maxlength="2" id="cg_thumb_look_border_radius" value="'.$ThumbViewBorderRadius.'" ' . $ThumbLookFields  . ' style="' . $ThumbLookFieldsStyle  . '"><br/>';
        echo "</td>";
        echo "</tr>";*/


/*        echo "<tr>";
        echo "<td>";
        echo '<p>Border color:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" id="ThumbViewBorderColor" name="ThumbViewBorderColor['.$ThumbViewBorderOpacity.']" class="demo"
			maxlength="7"  data-opacity="'.$ThumbViewBorderOpacity.'" value="'.$ThumbViewBorderColor.'">';

        //echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/


        /*echo "<tr>";
        echo "<td>";
        echo '<p>Infinite Scroll (Lazy Load):<br/><strong>(If activated other views<br/>and Pagination are deactivated)</strong></p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" id="InfiniteScrollThumb" name="InfiniteScrollThumb" ' . $InfiniteScrollThumb  . ' ' . $ThumbLookFields  . ' style="' . $ThumbLookFieldsStyle  . '"><br/>';

        //echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/


        echo "</table>";
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "</div>";

    }

    if($value=="HeightLookOrder"){

        // 1 = Height, 2 = Thumb, 3 = Row
        if($InfiniteScroll==1){$InfiniteScrollHeight="checked";}
        else{$InfiniteScrollHeight="";}

        echo "<div class='cg_options_sortableContainer'>";
        echo '<input type="hidden" name="order[]" value="h" >';
        echo "<table>";
        echo "<tr><td>";
        echo '<p><b>Gallery Height View:</b></p>';
        echo "</td>";
        echo "<td class='cg_options_sortableDiv'>";
        if($key==1 or $key==2){ $cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';

        echo '<div class="cg_options_order"><u>'.$i.'. Order</u></div><div class="cg_options_order_change_order cg_move_view_to_bottom'.$cgHideClass.'"><i></i></div>';
        if($key==2 or $key==3){$cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';
        echo '<div class="cg_options_order_change_order cg_move_view_to_top'.$cgHideClass.'"><i></i></div>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Activate Height View:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" id="HeightLook" name="HeightLook" ' . $HeightLook  . '><br/>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Height of pics in a row (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" maxlength="3" name="HeightLookHeight" id="HeightLookHeight" value="'.$HeightLookHeight.'" maxlength="3"><br/>';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo '<p>Horizontal distance between images (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="HeightViewSpaceWidth" id="HeightViewSpaceWidth" maxlength="2" value="'.$HeightViewSpaceWidth.'"><br/>';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo '<p>Vertical distance between images (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="HeightViewSpaceHeight"  id="HeightViewSpaceHeight" maxlength="2" value="'.$HeightViewSpaceHeight.'" ><br/>';
        echo "</td>";
        echo "</tr>";


/*        echo "<tr>";
        echo "<td>";
        echo '<p>Border width (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="HeightViewBorderWidth" id="HeightViewBorderWidth" maxlength="2" value="'.$HeightViewBorderWidth.'"><br/>';
        echo "</td>";
        echo "</tr>";*/

        /*echo "<tr>";
        echo "<td>";
        echo '<p>border radius (%):<br>';
        echo '(50% =< images getting completly round<br>';
        echo 'Effect begins with 6% and higher <br/>';
        echo 'Rating, Comment and Info on an image<br>';
        echo 'in a gallery will be centered vertically.)';
        echo '</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="HeightViewBorderRadius" id="HeightViewBorderRadius" maxlength="2" value="'.$HeightViewBorderRadius.'" ' . $HeightLookFields  . ' style="' . $HeightLookFieldsStyle  . '"><br/>';
        echo "</td>";
        echo "</tr>";*/


/*        echo "<tr>";
        echo "<td>";
        echo '<p>Border color:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" id="HeightViewBorderColor" name="HeightViewBorderColor['.$HeightViewBorderOpacity.']" class="demo" maxlength="7"
			data-opacity="'.$HeightViewBorderOpacity.'" value="'.$HeightViewBorderColor.'">';
        //echo '<input type="text" id="RowViewBorderColor" name="RowViewBorderColor['.$RowViewBorderOpacity.']"  class="demo" maxlength="7"  data-opacity="'.$RowViewBorderOpacity.'" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' style="' . $RowLookFieldsStyle  . 'height:27px;">';
        //echo '<input type="text" id="cg_thumb_look_border_color" name="ThumbViewBorderColor" class="demo" maxlength="7"  data-opacity="1" value="'.$ThumbViewBorderColor.'" ' . $ThumbLookFields  . ' style="' . $ThumbLookFieldsStyle  . ' height:27px;">';

        //echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/

        /*echo "<tr>";
        echo "<td>";
        echo '<p>Infinite Scroll (Lazy Load):<br/><strong>(If activated other views<br/>and Pagination are deactivated)</strong></p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" id="InfiniteScrollHeight" name="InfiniteScrollHeight"  ' . $InfiniteScrollHeight  . ' ' . $HeightLookFields  . ' style="' . $HeightLookFieldsStyle  . '"><br/>';

        //echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/


        echo "</table>";
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "</div>";

    }

    if($value=="RowLookOrder"){

        // 1 = Height, 2 = Thumb, 3 = Row
        if($InfiniteScroll==3){$InfiniteScrollRow="checked";}
        else{$InfiniteScrollRow="";}

        echo "<div class='cg_options_sortableContainer'>";
        echo '<input type="hidden" name="order[]" value="r" >';
        echo "<table>";
        echo "<tr><td>";
        echo '<p><b>Gallery Row View:<br/>(Same amount of images in each row)</b></p>';
        echo "</td>";
        echo "<td class='cg_options_sortableDiv'>";
        if($key==1 or $key==2){ $cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';

        echo '<div class="cg_options_order"><u>'.$i.'. Order</u></div><div class="cg_options_order_change_order cg_move_view_to_bottom'.$cgHideClass.'"><i></i></div>';
        if($key==2 or $key==3){$cgHideClass = '';}
        else{$cgHideClass = ' cg_hide';}
        $cgHideClass = '';
        echo '<div class="cg_options_order_change_order cg_move_view_to_top'.$cgHideClass.'"><i></i></div>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Activate Row View:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" id="RowLook" name="RowLook" ' . $RowLook  . '><br/>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>";
        echo '<p>Number of pics in a row</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="PicsInRow" maxlength="2" id="PicsInRow" value="'.$PicsInRow.'" maxlength="2"><br/>';
        echo "</td>";
        echo "</tr>";


        echo "<tr>";
        echo "<td>";
        echo '<p>Horizontal distance between images (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="RowViewSpaceWidth" maxlength="2" id="RowViewSpaceWidth" value="'.$RowViewSpaceWidth.'"><br/>';
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td>";
        echo '<p>Vertical distance between images (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="RowViewSpaceHeight" maxlength="2" id="RowViewSpaceHeight" value="'.$RowViewSpaceHeight.'"><br/>';
        echo "</td>";
        echo "</tr>";


/*        echo "<tr>";
        echo "<td>";
        echo '<p>Border width (px):</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="RowViewBorderWidth" maxlength="2" id="RowViewBorderWidth" value="'.$RowViewBorderWidth.'"><br/>';
        echo "</td>";
        echo "</tr>";*/

        /*echo "<tr>";
        echo "<td>";
        echo '<p>border radius (%):<br>';
        echo '(50% =< images getting completly round<br>';
        echo 'Effect begins with 6% and higher <br/>';
        echo 'Rating, Comment and Info on an image<br>';
        echo 'in a gallery will be centered vertically.)';
        echo '</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" name="RowViewBorderRadius" maxlength="2" id="RowViewBorderRadius" value="'.$RowViewBorderRadius.'" ' . $RowLookFields  . ' style="' . $RowLookFieldsStyle  . '"><br/>';
        echo "</td>";
        echo "</tr>";*/


/*        echo "<tr>";
        echo "<td>";
        echo '<p>Border color:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="text" id="RowViewBorderColor" name="RowViewBorderColor['.$RowViewBorderOpacity.']"  class="demo" maxlength="7"
			data-opacity="'.$RowViewBorderOpacity.'" value="'.$RowViewBorderColor.'">';
        //echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/


        /*echo "<tr>";
        echo "<td>";
        echo '<p>Infinite Scroll (Lazy Load):<br/><strong>(If activated other views<br/>and Pagination are deactivated)</strong></p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" id="InfiniteScrollRow" name="InfiniteScrollRow" ' . $InfiniteScrollRow  . ' ' . $RowLookFields  . ' style="' . $RowLookFieldsStyle  . '"><br/>';

        //echo '<input type="text" name="cg_row_look_border_color" maxlength="7" id="cg_row_look_border_width" value="'.$RowViewBorderColor.'" ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/


        /*echo "<tr>";
        echo "<td>";
        echo '<p>Scale pics to full size of last row:</p>';
        echo "</td>";
        echo "<td>";
        echo '<input type="checkbox" name="LastRow" id="LastRow" ' . $LastRow  . ' ' . $RowLookFields  . ' ' . $RowLookFieldsStyle  . '><br/>';
        echo "</td>";
        echo "</tr>";*/
        echo "</table>";
        echo "<br>";
        echo "<hr>";
        echo "<br>";
        echo "</div>";

    }

}

echo "</div>";
echo "</div>";

echo <<<HEREDOC

                       <h4 id="view2" class="cg_view_header">Single pic options</h4>
            <div  class="cg_view cgSinglePicOptions">

HEREDOC;

echo "<table>";

echo "<tr><td colspan='2'>";
echo '<p><b><u>Gallery slide out or slider view</u></b></p>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo 'View images as gallery slide out:<br>';
echo 'View images as full window slider:';
echo "</td>";

echo "<td>";
echo '<input type="radio" name="AllowGalleryScript" ' . $AllowGalleryScript . ' id="AllowGalleryScript"> <br/>';
echo '<input type="radio" name="SliderFullWindow" ' . $SliderFullWindow . ' id="SliderFullWindow"><br/>';
echo "</td>";
echo "</tr>";


echo "<tr>";

if(function_exists('exif_read_data')){


    echo "<td class='cg-padding-left-20'>";
    echo '<p>Show EXIF data:</p>';
    echo "</td>";

    echo "<td>";
    echo '<input type="checkbox" name="ShowExif" ' . $ShowExif . ' id="ShowExif"><br/>';
    echo "</td>";

}else{

    echo "<td colspan='2'>";
    echo "<p><b>Show EXIF data can not be activated. <br>Please contact your provider<br>to enable exif_read_data function.</b></p>";
    echo "</td>";

}






echo "</tr>";

echo "<tr>";
echo "<td class='cg-padding-left-20'>";
echo 'Slide effect horizontal:<br/>';
echo 'Slide effect vertical:<br/>';

echo "</td>";

echo "<td>";
echo '<input type="radio" name="SlideTransition" '.$SlideHorizontal.'  id="SlideHorizontal" value="translateX" /><br/>';
echo '<input type="radio" name="SlideTransition" '.$SlideVertical.' id="SlideVertical" value="slideDown" /><br/>';

echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-padding-left-20'>";
echo '<p>Start gallery full window view<br> as slide out by clicking an image:<br><strong>(Will not start automatically full window<br>
when clicking image in slider view.)</strong></p>';
echo "</td>";

echo "<td>";
//echo "source:".$OriginalSourceLinkInSlider;
echo '<input type="checkbox" name="FullSizeSlideOutStart" ' . $FullSizeSlideOutStart . ' id="FullSizeSlideOutStart"><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-padding-left-20'>";
echo '<p>Enable download button<br>of original image source:</p>';
echo "</td>";

echo "<td>";
//echo "source:".$OriginalSourceLinkInSlider;
echo '<input type="checkbox" name="OriginalSourceLinkInSlider" ' . $OriginalSourceLinkInSlider . ' id="OriginalSourceLinkInSlider"><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-padding-left-20'>";
echo '<p>Show Nickname who uploaded image:<br>(If a registered user uploaded an image)</p>';
echo "</td>";

echo "<td>";
//echo "source:".$OriginalSourceLinkInSlider;
echo '<input type="checkbox" class="'.$cgProFalse.'" name="ShowNickname" ' . $ShowNickname . ' id="ShowNickname"> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";


/*
echo "<tr>";
echo "<td style='padding-left:20px;width:240px;'>";
echo '<p>Enable gallery full size screen link:</p>';
echo "</td>";
echo "<td >";
echo '<input type="checkbox" name="FullSize" ' . $FullSize . ' id="FullSize"><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td style='padding-left:20px;width:240px;'>";
echo '<p>Arrange information:</p>';
echo "</td>";

echo "<td >";
if ($checkDataFormOutput){
    //echo "<form method='POST' action='?page=contest-gallery/index.php&option_id=$galeryNR&define_output=true'><input type='submit' value='Single pic info' style='float:right;text-align:center;width:180px;'/></form>";
    echo "<a href = '?page=contest-gallery/index.php&option_id=$galeryNR&define_output=true' >Define single pic info</a>";
}
else{echo 'Information fields in<br/>"Edit upload form"<br/>required';}
echo "</td>";
echo "</tr>";*/

/*

echo "<tr>";
echo "<td>";
echo '<p>User information appears always in slider:<br/>(If deactivated then by holding left mouse)</p>';
echo "</td>";

echo "<td>";
echo '<input type="checkbox" name="ShowAlwaysInfoSlider" ' . $ShowAlwaysInfoSlider . ' id="ShowAlwaysInfoSlider"><br/>';
echo "</td>";
echo "</tr>";*/


echo "<tr><td colspan='2'>";
echo '<p><b><u>Original source link only</u></b></p>';
echo "</td>";
echo "</tr>";

echo "<tr>";

echo "<td>";
echo '<p>Forward directly to original source<br> after clicking an image:<br><b>(Only for gallery views.<br>Slider view will work as usual.)</b></p>';
echo "</td>";

echo "<td>";
echo '<input type="radio" name="FullSizeImageOutGallery" ' . $FullSizeImageOutGallery . ' id="FullSizeImageOutGallery"><br/>';
echo "</td>";
echo "</tr>";

/*
		echo "<tr>";

		echo "<td>";
		echo '<p>Forward directly to full size image in a new tab</p>';
		echo "</td>";

		echo "<td>";
		echo '<input type="checkbox" name="FullSizeImageOutGalleryNewTab" ' . $FullSizeImageOutGalleryNewTab . ' id="FullSizeImageOutGalleryNewTab"><br/>';
		echo "</td>";
		echo "</tr>";
*/

if($ScaleOnly=='checked'){
    $displayNone = 'display:none;';
}
else{
    $displayNone = '';
}

if($ScaleAndCut=='checked'){
    $ScaleOnly = 'checked';
}


echo "<tr style='$displayNone'>";



echo "<td>";
echo '<p>Scale only:  </p>';
echo "</td>";

echo "<td>";
echo '<input type="checkbox" name="ScaleWidthGalery" ' . $ScaleOnly . ' id="ScaleWidthGalery"><br/>';
echo "</td>";



echo "</tr>";

echo "<tr style='display:none;'>";

echo "<td>";
echo '<p>Scale and cut:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="ScaleSizesGalery" ' . $ScaleAndCut . ' id="ScaleSizesGalery"><br/>';
echo "</td>";

echo "</tr>";

/*echo "<tr>";
echo "<td style='padding-left:20px;width:240px;'>";
echo '<p>Max pic width in px:</p>';
echo "</td>";
echo "<td>";
echo '<input type="text" name="WidthGallery" value="'.$WidthGallery.'" id="ScaleSizesGalery1" maxlength="4"><br/>';
echo "</td>";
echo "</tr>";*/
echo "<tr style='display:none;'>";
echo "<td>";
echo '<p>Pic height:</p>';
echo "</td>";
echo "<td>";
echo '<input type="text" name="HeightGallery" value="'.$HeightGallery.'" id="ScaleSizesGalery2" maxlength="4" ><br/>';
echo "</td>";
echo "</tr>";


/*echo "<tr>";

echo "<td style='padding-left:20px;width:240px;'>";
echo '<p>Arrange single pic information:</p>';
echo "</td>";

echo "<td >";
if ($checkDataFormOutput){
    //echo "<form method='POST' action='?page=contest-gallery/index.php&option_id=$galeryNR&define_output=true'><input type='submit' value='Single pic info' style='float:right;text-align:center;width:180px;'/></form>";
    echo "<a href = '?page=contest-gallery/index.php&option_id=$galeryNR&define_output=true' >Define single pic info</a>";
}
else{echo 'Information fields in<br/>"Edit upload form"<br/>required';}
echo "</td>";
echo "</tr>";*/

echo "<tr><td colspan='2'>";
echo '<p><br/><b><u>Only gallery view</u></b><br/>';
echo '</p>';
echo "</td>";
echo "</tr>";

echo "<tr>";

echo "<td>";
echo '<p>Make images unclickable: <br><strong>(Images can not be clicked.<br>Configuration of rating out of gallery is possible.<br>Only for gallery views.<br>Slider view will work as usual.)</strong></p>';
echo "</td>";

echo "<td>";
echo '<input type="radio" name="OnlyGalleryView" ' . $OnlyGalleryView . ' id="OnlyGalleryView"><br/>';
echo "</td>";
echo "</tr>";

echo "</table>";
echo <<<HEREDOC
            </div>
            <h4 id="view3" class="cg_view_header">Gallery options</h4>
            <div class="cg_view cgGalleryOptions">
HEREDOC;


echo "<table>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p><strong><u>Gallery name:</u></strong></p>';
echo '<input type="text" class="cg-long-input" id="GalleryName" name="GalleryName" maxlength="100" value="'.$GalleryName1.'">';
echo "</td>";
echo "</tr>";


echo "<tr><td colspan='2'>";
echo '<p><b><u>Photo contest start options</u></b></p>';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p>Activate photo contest start time:<br/>(To rate images will be not possible.<br/>Does not work for Facebook like button.<br/>If not activated then photo contest ist started.)</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="ContestStart" id="ContestStart"  ' . @$ContestStart  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Select start day and time of photo contest (server time):<br/>(<strong>You select server time here. <br> Your current server time is: '.date('Y-m-d H:i').'<br>To refresh current server time reload this window.</strong>)</p>';
echo "</td>";
echo "<td id='cg_datepicker_table'>";
echo '<input type="text" autocomplete="off" class="'.$cgProFalse.'" id="cg_datepicker_start"  name="ContestStartTime" value="'.$ContestStartTime.'" >';
echo '<input type="hidden" id="cg_datepicker_start_value_to_set" value="'.$ContestStartTime.'" >';

echo '<input type="number" id="cg_date_hours_contest_start" class="cg_date_hours '.$cgProFalse.'" name="ContestStartTimeHours" placeholder="00" 
       min="-1" max="25" value="'.$ContestStartTimeHours.'" > : ';
echo '<input type="number" id="cg_date_mins_contest_start" class="cg_date_mins '.$cgProFalse.'" name="ContestStartTimeMins" placeholder="00" 
       min="-1" max="60" value="'.$ContestStartTimeMins.'" > '.$cgProFalseText.'';
echo "</td>";
echo "</tr>";


echo "<tr><td colspan='2'>";
echo '<p><b><u>Photo contest end options</u></b></p>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>End photo contest immediately:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="ContestEndInstant" class="'.$cgProFalse.'" id="ContestEndInstant"  ' . @$ContestEndInstant  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Activate photo contest end time:<br/>(To rate images will be not possible anymore.<br/>Does not work for Facebook like button.)</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="ContestEnd" id="ContestEnd"  ' . @$ContestEnd  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Select last day and time of photo contest (server time):<br/>(<strong>You select server time here. <br> Your current server time is: '.date('Y-m-d H:i').'<br>To refresh current server time reload this window.</strong>)</p>';
echo "</td>";
echo "<td id='cg_datepicker_table'>";
echo '<input type="text" autocomplete="off" class="'.$cgProFalse.'" id="cg_datepicker" name="ContestEndTime" value="'.$ContestEndTime.'" >';
echo '<input type="hidden" id="cg_datepicker_value_to_set" value="'.$ContestEndTime.'" >';
echo '<input type="number" id="cg_date_hours_contest_end" class="cg_date_hours '.$cgProFalse.'" name="ContestEndTimeHours" placeholder="00" 
       min="-1" max="25" value="'.$ContestEndTimeHours.'" > : ';
echo '<input type="number" id="cg_date_mins_contest_end" class="cg_date_mins '.$cgProFalse.'" name="ContestEndTimeMins" placeholder="00" 
       min="-1" max="60" value="'.$ContestEndTimeMins.'" > '.$cgProFalseText.'';
echo "</td>";
echo "</tr>";


echo "<tr><td colspan='2'>";
echo '<p><b><u>Gallery view options</u></b></p>';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo "<p>Show permanent vote, comments and info in gallery view:<br/>(You see it by hovering if not activated.)</p>";
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="ShowAlways" ' . $selectedShowAlways . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Info position on gallery image:<br>(Enabled if you select "Show info in gallery"<br>in "Edit upload form" options first.)</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="TitlePositionGallery" class="TitlePositionGallery" ' . $selectedTitlePositionGalleryLeft . ' value="1"  ' . $enabledTitlePositionGalleryLeft . '>< left &nbsp;&nbsp;&nbsp;';
echo '<input type="radio" name="TitlePositionGallery" class="TitlePositionGallery" ' . $selectedTitlePositionGalleryCenter . ' value="2" ' . $enabledTitlePositionGalleryLeft . '> < center &nbsp;&nbsp;&nbsp;';
echo '<input type="radio" name="TitlePositionGallery" class="TitlePositionGallery" ' . $selectedTitlePositionGalleryRight . ' value="3" ' . $enabledTitlePositionGalleryLeft . '> < right ';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Allow only registered users to see the gallery:<br/>';
echo '(User have to be registered and<br> logged in to be able to see the gallery.)</p>';

echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'"  name="RegUserGalleryOnly" id="RegUserGalleryOnly" ' . @$RegUserGalleryOnly  . '> '.$cgProFalseText.' <br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container $cgProFalseContainer' colspan='2'>";

echo '<p>Show text instead of gallery: '.$cgProFalseText.'</p>';
//wp_editor( $RegUserGalleryOnlyText, 'RegUserGalleryOnlyText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='RegUserGalleryOnlyText'  name='RegUserGalleryOnlyText'>$RegUserGalleryOnlyText</textarea>";

echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p><b><u>Comment Options</u></b></p>';
echo "</td>";
echo "<td>";
echo '';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Allow comments:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="AllowComments"  id="AllowComments"' . $selectedCheckComments . '><br/>';
echo "</td>";
echo "</tr>";


/*echo "<tr>";
echo "<td>";
echo '<p>Allow comment out of gallery:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="CommentsOutGallery"  id="CommentsOutGallery" ' . $selectedCommentsOutGallery . '><br/>';
echo "</td>";
echo "</tr>";*/

echo "<tr>";
echo "<td>";
echo '<p>Comments icon position on gallery image:</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="CommentPositionGallery" class="CommentPositionGallery" id="CommentPositionGalleryLeft" ' . $selectedCommentPositionGalleryLeft . '  value="1"> < left &nbsp;&nbsp;&nbsp;';
echo '<input type="radio" name="CommentPositionGallery" class="CommentPositionGallery" id="CommentPositionGalleryCenter" ' . $selectedCommentPositionGalleryCenter . '  value="2"> < center &nbsp;&nbsp;&nbsp;';
echo '<input type="radio" name="CommentPositionGallery" class="CommentPositionGallery" id="CommentPositionGalleryRight" ' . $selectedCommentPositionGalleryRight . '  value="3"> < right ';
echo "</td>";
echo "</tr>";






/*
echo "<tr>";
echo "<td>";
echo '<p>Allow Fb-Like:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="FbLike" ' . $selectedCheckFb  . '><br/>';
echo "</td>";
echo "</tr>"; */








echo "</table>";

echo <<<HEREDOC
 </div>
             <h4 id="view31" class="cg_view_header">Voting options</h4>

<div class="cg_view cgVotingOptions">
HEREDOC;

echo "<table>";


echo "<tr>";
echo "<td>";
echo '<p>Allow manipulate rating by administrator (you):<br>After activating and saving this option <br> just go "Back to gallery" and you will <br> be able to change rating of each image.</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="Manipulate" id="Manipulate" ' . @$Manipulate  . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p><b><u>User recognition methods</u></b></p>';
echo "</td>";
echo "<td>";
echo '';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg_vertical-align-top'>";
echo '<p class="cg_margin-bottom-5 cg_margin-top-0">Check by IP:<br><strong>(IP will be tracked always)</strong></p>';
echo "</td>";
echo "<td class='cg_vertical-align-top'>";
//if(!$cgProVersion){
  //  $CheckIp = '';
//}
echo '<input type="radio" name="CheckMethod" class="'.$cgProFalse.' CheckMethod" id="CheckIp" value="ip" ' . @$CheckIp  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p class="cg_margin-bottom-5">Check by Cookie:<br><strong>(Cookie will be only set and tracked if this option is activated)</strong></p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="CheckMethod" class="'.$cgProFalse.' CheckMethod" id="CheckCookie" value="cookie" ' . @$CheckCookie  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p class="cg_margin-top-0">Check Cookie alert message if user browser does not allow cookies:</p>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" placeholder="Please allow cookies to vote" id="CheckCookieAlertMessage" name="CheckCookieAlertMessage" maxlength="1000" value="'.$CheckCookieAlertMessage.'"> '.$cgProFalseText.'';
echo "</td>";

echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Check if is registered user:<br/>(User have to be registered<br> and logged in to be able to vote <br>User WordPress ID based voting  – uncheatable<br><strong>User WordPress ID will be always tracked if user is logged in</strong>)</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="CheckMethod" class="'.$cgProFalse.' CheckMethod" id="CheckMethod" value="login" ' . @$CheckLogin  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p><b><u>Limit votes</u></b></p>';
echo "</td>";
echo "<td>";
echo '';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p class="cg_margin-top-0">Votes per user:<br><b>(0 or empty = no limit)</b></p>';
echo "</td>";
echo "<td>";
echo '<input type="text" class="'.$cgProFalse.'" name="VotesPerUser" id="VotesPerUser" maxlength="3" value="'.$VotesPerUser.'"> '.$cgProFalseText;
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>One vote per picture:<br><b>(Every picture can be voted<br>only one time by a user)</b></p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="IpBlock"  id="IpBlock" ' . $selectedCheckIp . '> '.$cgProFalseText;
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Voting of self-added picture is not allowed:<br><b>User can not vote own uploaded image<br>Works only for voting recognition methods:<br>- Check by IP (images added since version 10.9.3.7)<br> - Check by registration</b></p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="VoteNotOwnImage"  id="VoteNotOwnImage" '.$VoteNotOwnImage.'> '.$cgProFalseText;
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p><b><u>Voting configuration</u></b></p>';
echo "</td>";
echo "<td>";
echo '';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-vertical-align-top'>";
echo 'Allow vote via 1 star rating:';
echo "</td>";
echo "<td class='cg-info-container-reset-votes'>";
echo '<input type="checkbox" name="AllowRating2" id="AllowRating2" ' . $selectedCheckRating2 . '> &nbsp;&nbsp;&nbsp; 
<a class="cg-rating-reset" href="?page=contest-gallery/index.php&edit_options=true&option_id='.$galeryNR.'&reset_votes2=true" id="cg_reset_votes2" >
<button type="button">Reset votes completely</button></a>&nbsp;&nbsp;&nbsp; <a class="cg-rating-reset"
 href="?page=contest-gallery/index.php&edit_options=true&option_id='.$galeryNR.'&reset_users_votes2=true" id="cg_reset_users_votes2">
<button type="button">Reset users votes only</button></a><br/>';
echo '<a class="cg-rating-reset cg-rating-reset-administrator-votes"
 href="?page=contest-gallery/index.php&edit_options=true&option_id='.$galeryNR.'&reset_admin_votes2=true" id="cg_reset_admin_votes2">
<button type="button">Reset administrator votes only</button></a><br/><br/>';

echo "<span class='cg-info-container' id='cg_reset_votes2_explanation' style='display: none;'>
- Images with 1 star votes counter will be deleted (starts with 0 again)<br>- All tracked users 1 star voting data for every image will be also deleted<br>- By Administrator manually added votes will be not deleted
</span>";

echo "<span class='cg-info-container' id='cg_reset_users_votes2_explanation' style='display: none;'>
- Images with 1 star votes counter will be not deleted<br>- All tracked users 1 star voting data for every image will be deleted<br>- Users can start vote again if their used all their votes<br>- By Administrator manually added votes will be not deleted
</span>";

echo "<span class='cg-info-container' id='cg_reset_admin_votes2_explanation' style='display: none;'>
- Images with 1 star votes counter will be not deleted<br>- All tracked users 1 star voting data for every image will be not deleted<br>- By administrator through manipulation added votes will be deleted
</span>";

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-vertical-align-top'>";
echo 'Allow vote via 5 star rating:';
echo "</td>";
echo "<td class='cg-info-container-reset-votes'>";
echo '<input type="checkbox" name="AllowRating" id="AllowRating" ' . $selectedCheckRating . '> &nbsp;&nbsp;&nbsp; <a class="cg-rating-reset"
 href="?page=contest-gallery/index.php&edit_options=true&option_id='.$galeryNR.'&reset_votes=true" id="cg_reset_votes">
<button type="button">Reset votes completely</button></a>&nbsp;&nbsp;&nbsp; <a class="cg-rating-reset" 
href="?page=contest-gallery/index.php&edit_options=true&option_id='.$galeryNR.'&reset_users_votes=true" id="cg_reset_users_votes"><button type="button">Reset users votes only</button></a> <br/>';
echo '<a class="cg-rating-reset cg-rating-reset-administrator-votes"
  href="?page=contest-gallery/index.php&edit_options=true&option_id='.$galeryNR.'&reset_admin_votes=true" id="cg_reset_admin_votes">
<button type="button">Reset administrator votes only</button></a><br/><br/>';


echo "<span class='cg-info-container' id='cg_reset_votes_explanation' style='display: none;'>
- Images with 5 stars votes counter will be deleted (starts with 0 again)<br>- All tracked users 5 stars voting data for every image will be also deleted<br>- By Administrator manually added votes will be not deleted
</span>";

echo "<span class='cg-info-container' id='cg_reset_users_votes_explanation' style='display: none;'>
- Images with 5 stars votes counter will be not deleted<br>- All tracked users 5 stars voting data for every image will be deleted<br>- Users can start vote again if their used all their votes<br>- By Administrator manually added votes will be not deleted
</span>";

echo "<span class='cg-info-container' id='cg_reset_admin_votes_explanation' style='display: none;'>
- Images with 5 stars votes counter will be not deleted<br>- All tracked users 5 stars voting data for every image will be not deleted<br>- By administrator through manipulation added votes will be deleted
</span>";


echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Allow vote out of gallery:<br><strong>(It is not necessary to open image for voting,<br>just vote out of gallery.)</strong></p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="RatingOutGallery" id="RatingOutGallery" ' . $selectedRatingOutGallery . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Rating star position on gallery image:</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="RatingPositionGallery" class="RatingPositionGallery" ' . $selectedRatingPositionGalleryLeft . ' value="1"> < left &nbsp;&nbsp;&nbsp;';
echo '<input type="radio" name="RatingPositionGallery" class="RatingPositionGallery" ' . $selectedRatingPositionGalleryCenter . ' value="2"> < center &nbsp;&nbsp;&nbsp;';
echo '<input type="radio" name="RatingPositionGallery" class="RatingPositionGallery" ' . $selectedRatingPositionGalleryRight . ' value="3"> < right ';
echo "</td>";
echo "</tr>";



echo "<tr>";
echo "<td>";
echo '<p>Show only user votes:<br/>(User see only his votes not the whole rating)</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="ShowOnlyUsersVotes" id="ShowOnlyUsersVotes"' . @$ShowOnlyUsersVotes  . '> '.$cgProFalseText;
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p>Hide rating of a picture<br>until user voted for this picture:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="HideUntilVote" id="HideUntilVote"' . @$HideUntilVote  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p>Votes in time interval per user:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="VotesInTime" id="VotesInTime"' . @$VotesInTime  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Votes in time interval per user amount:<br><strong>(empty = 1)</strong></p>';
echo "</td>";
echo "<td>";
echo '<input type="text" placeholder="1" class="'.$cgProFalse.'" name="VotesInTimeQuantity" id="VotesInTimeQuantity" maxlength="3" value="'.$VotesInTimeQuantity.'"> '.$cgProFalseText;
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Votes in time interval per user interval:<br/><strong>(Hours:Minutes)</strong></p>';
echo "</td>";
echo "<td id='cg_datepicker_table'>";
echo '<input type="number" id="cg_date_hours_vote_interval" class="cg_date_hours_unlimited '.$cgProFalse.'" name="cg_date_hours_vote_interval" placeholder="0" 
       min="-1" max="1000" value="'.$cg_date_hours_vote_interval.'" maxlength="3" style="width:60px;" > : ';
echo '<input type="number" id="cg_date_mins_vote_interval" class="cg_date_mins '.$cgProFalse.'" name="cg_date_mins_vote_interval" placeholder="00" 
       min="-1" max="60" value="'.$cg_date_mins_vote_interval.'" style="width:60px;" > '.$cgProFalseText.'';
echo "</td>";
echo "</tr>";

//VotesInTimeIntervalReadable VARCHAR(40) DEFAULT '',
//VotesInTimeIntervalAlertMessage VARCHAR(200)  DEFAULT '',

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p class="cg_margin-top-0">Votes in time interval per user alert message:</p>';

echo '<input type="text" placeholder="You can vote only 1 time per day" class="'.$cgProFalse.' cg-long-input" name="VotesInTimeIntervalAlertMessage" id="VotesInTimeIntervalAlertMessage" maxlength="200" value="'.$VotesInTimeIntervalAlertMessage.'"> '.$cgProFalseText;
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td>";
echo '<p>Delete votes:<br>(Frontend users can delete their votes<br>and give them to another picture.) </p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="MinusVote" id="MinusVote"' . @$MinusVote  . '> '.$cgProFalseText;
echo "</td>";
echo "</tr>";

//Facebook Like button options

echo "<tr>";
echo "<td>";
echo '<p><br><b><u>Facebook like button options</u></b></p>';
echo "</td>";
echo "<td>";
echo '';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Vote via Facebook like buttton<br><b>(New fields will be added to images<br> backend area and also new field types<br> will be added to upload form<br> if activated.<br>Upload form field types are connected<br>to images backend area fields.)</b>:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="FbLike" id="FbLike" ' . @$selectedCheckFbLike . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Show Facebook like button out of gallery:<br>(Slower browser loading of gallery.<br> Needs more computing power.<br/>Pagination with not so many images<br/>at one step is better in that case.<br/>Will be not shown in small<br>images overview of slider.)</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="FbLikeGallery" id="FbLikeGallery" ' . @$selectedCheckFbLikeGallery . '><br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Hide Facebook share button:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="FbLikeNoShare"  id="FbLikeNoShare" ' . $FbLikeNoShare . '> '.$cgProFalseText;
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td colspan='2' class='cg-small-textarea-container'>";
echo '<p>Gallery shortcode URL for Facebook share button</p>';
$FbLikeGoToGalleryLinkPlaceholder = site_url().'/';
echo "<input type='text' class='$cgProFalse cg-long-input' name='FbLikeGoToGalleryLink' id='FbLikeGoToGalleryLink' maxlength='1000' placeholder='$FbLikeGoToGalleryLinkPlaceholder' value='$FbLikeGoToGalleryLink'> $cgProFalseText";
echo "<br>(It will be forwarded to this page when Facebook share button is used.)";
echo "<br>";
echo "<br>";
echo "</td>";
echo "</tr>";


//Facebook Like button options --- ENDE


/*
echo "<tr>";
echo "<td>";
echo '<p>Allow Fb-Like:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="FbLike" ' . $selectedCheckFb  . '><br/>';
echo "</td>";
echo "</tr>"; */

echo "</table>";

echo <<<HEREDOC
 </div>
             <h4 id="view4" class="cg_view_header">Upload options</h4>

			   <div class="cg_view cgUploadOptions">
HEREDOC;

echo "<table>";

/*echo "<tr><td>";
//echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
echo '<p><b><u>Upload options</u></b></p>';

echo "</td>";
echo "</tr>";*/
echo "<tr>";
echo "<td>";
echo '<p>Automatically activate users images after<br> frontend upload:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="ActivateUpload" ' . $ActivateUpload  . '><br/>';
echo "</td>";
echo "</tr>";
echo "</table>";
echo "<hr>";
echo "<table>";
echo "<tr>";
echo "<td colspan='2'>";
echo '<p id="cgInGalleryUploadFormConfiguration"><strong><u>In gallery upload form configuration</u></strong></p>';
echo "</td>";
echo "</tr>";
echo "<tr id=\"cgActivateInGalleryUploadForm\">";
echo "<td>";
echo '<p>Activate in gallery upload form:</p>';
echo "</td>";
echo "<td>";
echo "<input id='GalleryUpload' type='checkbox' name='GalleryUpload' $GalleryUpload >";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Activate only for user gallery:</p>';
echo "</td>";
echo "<td class='cg-small-textarea-container'>";
echo "<input id='GalleryUploadOnlyUser' type='checkbox' name='GalleryUploadOnlyUser' $GalleryUploadOnlyUser >";
echo "<span class=\"cg-info-icon\">info</span><span class=\"cg-info-container cg-info-container-text-center\" style=\"display: none;\">The in gallery upload form will be only displayed when <br>[cg_gallery_user id=\"".$galeryNR."\"] shortcode is used</span>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>Confirmation text after upload:</p>';
//wp_editor( $GalleryUploadConfirmationText, 'GalleryUploadConfirmationText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='GalleryUploadConfirmationText'  name='GalleryUploadConfirmationText'>$GalleryUploadConfirmationText</textarea>";

echo "<br>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td  class='cg-small-textarea-container' colspan='2'>";
echo '<p>Text before upload form:</p>';
//wp_editor( $GalleryUploadTextBefore, 'GalleryUploadTextBefore',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='GalleryUploadTextBefore'  name='GalleryUploadTextBefore'>$GalleryUploadTextBefore</textarea>";

echo "<br>";

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>Text after upload form:</p>';
//wp_editor( $GalleryUploadTextAfter, 'GalleryUploadTextAfter',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='GalleryUploadTextAfter'  name='GalleryUploadTextAfter'>$GalleryUploadTextAfter</textarea>";
echo "</td>";
echo "</tr>";

echo "</table>";

echo "<br>";
echo "<hr>";

echo "<table>";
echo "<tr>";
echo "<td colspan='2'>";
echo '<p><strong><u>Upload form shortcode configuration</u></strong></p>Is not for in gallery upload form.<br> It is for upload form shortcode:<br> [cg_users_upload id="'.$galeryNR.'"]</p>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td >";
echo '<p>Forward to another page after upload:</p>';
echo "</td>";
echo "<td >";
echo "<input id='forward' type='checkbox' name='forward' $ForwardUploadURL >";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2' >";
echo '<p class="cg_margin-top-0">Forward to URL:</p>';
//wp_editor( $Forward_URL, 'forward_url',  $settingsHTMLarea);
echo '<input id="forward_url" class="cg-long-input cg_margin-bottom-15" placeholder="'.get_site_url().'" type="text" name="forward_url" maxlength="999" value="'.$Forward_URL.'" />';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Confirmation text on same page after upload:</p>';
echo "</td>";
echo "<td>";
echo "<input id='cg_confirm_text' type='checkbox' name='cg_confirm_text' $ForwardUploadConf >";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Show upload form again after upload:<br>(Under the confirmation text)</p>';
echo "</td>";
echo "<td>";
echo "<input id='ShowFormAfterUpload' type='checkbox' name='ShowFormAfterUpload' $ShowFormAfterUpload >";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2' >";
echo '<p class="cg_margin-top-0">Confirmation text after upload:</p>';
//wp_editor( $Confirmation_Text, 'confirmation_text',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='confirmation_text'  name='confirmation_text'>$Confirmation_Text</textarea>";

echo "</td>";
echo "</tr>";

echo "</table>";
echo "<br>";
echo "<hr>";

echo "<table>";

echo "<tr><td>";
//echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
echo '<p style="margin:0;"><b><u>Limit uploads and user recognition methods</u></b></p>';

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p >Uploads per user<br/><strong>(0 or empty = no limit)</strong></p>';
echo "</td>";
echo "<td>";
echo '<input class="'.$cgProFalse.'" id="RegUserMaxUpload" type="text" name="RegUserMaxUpload" value="'.$RegUserMaxUpload.'" maxlength="20" > '.$cgProFalseText.' <br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg_vertical-align-top'>";
echo '<p class="cg_margin-bottom-5" style="margin-top:15px;">Check by IP:<br><strong>(IP will be tracked always)</strong></p>';
echo "</td>";
echo "<td class='cg_vertical-align-top' style='padding-top:18px;'>";
//if(!$cgProVersion){
//  $CheckIp = '';
//}
echo '<input type="radio" name="RegUserUploadOnly" class="'.$cgProFalse.' CheckMethodUpload" id="CheckIpUpload" value="3" ' . @$CheckIpUpload  . ' '.$checkIpCheckUpload.'> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p class="cg_margin-bottom-5">Check by Cookie:<br><strong>(Cookie will be only set and tracked if this option is activated. Will be not set if administrator uploads images in WordPress backend area.)</strong></p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="RegUserUploadOnly" class="'.$cgProFalse.' CheckMethodUpload" id="CheckCookieUpload" value="2" ' . @$CheckCookieUpload  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p class="cg_margin-top-0">Check Cookie alert message if user browser does not allow cookies:</p>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" placeholder="Please allow cookies to upload" id="UploadRequiresCookieMessage" name="UploadRequiresCookieMessage" maxlength="1000" value="'.$UploadRequiresCookieMessage.'"> '.$cgProFalseText.'';
echo "</td>";

echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Check if is registered user:<br/>(User have to be registered<br> and logged in to be able to upload.<br><strong>User WordPress ID will be always tracked if user is logged in.</strong>)</p>';
echo "</td>";
echo "<td>";
echo '<input type="radio" name="RegUserUploadOnly" class="'.$cgProFalse.' CheckMethodUpload" id="CheckLoginUpload" value="1" ' . @$CheckLoginUpload  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container $cgProFalseContainer' colspan='2'>";

echo '<p>Show text instead of upload form<br>if user is not logged in: '.$cgProFalseText.'</p>';
//wp_editor( $RegUserUploadOnlyText, 'RegUserUploadOnlyText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='RegUserUploadOnlyText'  name='RegUserUploadOnlyText'>$RegUserUploadOnlyText</textarea>";

echo "</td>";
echo "</tr>";
echo "</table>";

echo "<br>";
echo "<hr>";
echo "<table>";
// Restrict Upload for images

// Maximal möglich eingestellter Upload wird ermittelt
$upload_max_filesize = (int)(ini_get('upload_max_filesize'));
$post_max_size = (int)(ini_get('post_max_size'));
echo "<tr><td>";
//echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
echo '<p><b><u>Image size upload options</u></b></p>';

echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Restrict frontend upload size:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" id="ActivatePostMaxMB" name="ActivatePostMaxMB" ' . @$ActivatePostMaxMB  . '><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td id='cgMaximumUploadFileSizeInMB'>";
echo '<p>Maximum upload size in MB per image:<br/>(If empty then no restrictions)<br/>';

echo "<br><span style='position: relative;'>Maximum <b>upload_max_filesize</b><br>in your PHP configuration: <b>$upload_max_filesize MB</b> 
<span class=\"cg-info-icon\"><b><u>info</b></u></span>
 <span class=\"cg-info-container\" style=\"top: 47px;left: 180px;display: none;\">Maximum upload size per image<br><br>To increase in .htaccess file use:<br><b>php_value upload_max_filesize 10MB</b> (example, no equal to sign!)
 <br>To increase in php.ini file use:<br><b>upload_max_filesize = 10MB</b> (example, equal to sign required!)<br><br><b>Some server providers does not allow manually increase in files.<br>It has to be done in providers backend or they have to be contacted.</b></span>
 </span><br><br>";

echo "<span style='position: relative;'>Maximum <b>post_max_size</b><br>in your PHP configuration: <b>$post_max_size MB</b>
<span class=\"cg-info-icon\"><b><u>info</b></u></span>
 <span class=\"cg-info-container\" style=\"top: 47px;left: 180px;display: none;\">Describes the maximum size of a post which can be done when a form submits.<br>
 Example: you try to upload 3 images with each 3MB and post_max_size is 6MB, then it will not work.<br><br>To increase in htaccess file use:<br><b>php_value post_max_size 10MB</b> (example, no equal to sign!)
 <br>To increase in php.ini file use:<br><b>post_max_size = 10MB</b> (example, equal to sign required!)<br><br><b>Some server providers does not allow manually increase in files.<br>It has to be done in providers backend or they have to be contacted.</b></span>
 </span>";

echo "</td>";
echo "<td style=\"
    vertical-align: top;
    padding-top: 10px;
\">";
echo '<input id="PostMaxMB" type="text" name="PostMaxMB" value="'.$PostMaxMB.'" maxlength="20" style="width:width:300px;" ><br/>';
echo "</td>";
echo "</tr>";

// Restrict Upload for images --- ENDE



// Activate Bulk Upload for images

echo "<tr>";
echo "<td>";
echo '<p>Activate bulk (multiple images) upload in frontend:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" id="ActivateBulkUpload" name="ActivateBulkUpload" ' . @$ActivateBulkUpload  . '><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Maximum number of images for bulk upload<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="BulkUploadQuantity" type="text" name="BulkUploadQuantity" value="'.$BulkUploadQuantity.'" maxlength="20" ><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Minimum number of images for bulk upload (If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="BulkUploadMinQuantity" type="text" name="BulkUploadMinQuantity" value="'.$BulkUploadMinQuantity.'" maxlength="20" ><br/>';
echo "</td>";
echo "</tr>";

// Activate Bulk Upload for images --- ENDE


echo "<tr>";
echo "<td>";
echo '<p>Restrict resolution<br> for uploaded JPG pics</p>';
echo "</td>";
echo "<td>";
echo "<input id='allowRESjpg' type='checkbox' name='MaxResJPGon' $MaxResJPGon >";
echo '<div id="cg_questionJPG" style="display:inline;"><p style="font-size:18px;display:inline;">&nbsp;<a><b>?</b></a></p></div>';
echo "<div id='cg_answerJPG' style='position:absolute;margin-left:35px;width:460px;background-color:white;border:1px solid;padding:5px;display:none;'>";
echo "This allows you to restrict the resolution of the pictures which will be uploaded in frontend. It depends on your web hosting provider how big resolution ca be be for uploaded pics.";
echo " If your webhosting service is not so powerfull then you should use this restriction.</div>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Resolution width for JPGs in pixel:<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="MaxResJPGwidth" type="text" name="MaxResJPGwidth" value="'.$MaxResJPGwidth.'" maxlength="20"  ><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Resolution height for JPGs in pixel:<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="MaxResJPGheight" type="text" name="MaxResJPGheight" value="'.$MaxResJPGheight.'" maxlength="20" ><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Restrict resolution<br> for uploaded PNG pics</p>';
echo "</td>";
echo "<td>";
echo "<input id='allowRESpng' type='checkbox' name='MaxResPNGon' $MaxResPNGon >";
echo '<div id="cg_questionPNG" style="display:inline;"><p style="font-size:18px;display:inline;">&nbsp;<a><b>?</b></a></p></div>';
echo "<div id='cg_answerPNG' style='position:absolute;margin-left:35px;width:460px;background-color:white;border:1px solid;padding:5px;display:none;'>";
echo "This allows you to restrict the resolution of the pictures which will be uploaded in frontend. It depends on your web hosting provider how big resolution ca be be for uploaded pics.";
echo " If your webhosting service is not so powerfull then you should use this restriction.</div>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Resolution width for PNGs in pixel:<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="MaxResPNGwidth" type="text" name="MaxResPNGwidth" value="'.$MaxResPNGwidth.'" maxlength="20" ><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Resolution height for PNGs in pixel:<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="MaxResPNGheight" type="text" name="MaxResPNGheight" value="'.$MaxResPNGheight.'" maxlength="20"  ><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Restrict resolution<br> for uploaded GIF pics</p>';
echo "</td>";
echo "<td>";
echo "<input id='allowRESgif' type='checkbox' name='MaxResGIFon' $MaxResGIFon >";
echo '<div id="cg_questionGIF" style="display:inline;"><p style="font-size:18px;display:inline;">&nbsp;<a><b>?</b></a></p></div>';
echo "<div id='cg_answerGIF' style='position:absolute;margin-left:35px;width:460px;background-color:white;border:1px solid;padding:5px;display:none;'>";
echo "This allows you to restrict the resolution of the pictures which will be uploaded in frontend. It depends on your web hosting provider how big resolution ca be be for uploaded pics.";
echo " If your webhosting service is not so powerfull then you should use this restriction.</div>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Resolution width for GIFs in pixel:<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="MaxResGIFwidth" type="text" name="MaxResGIFwidth" value="'.$MaxResGIFwidth.'" maxlength="20"  ><br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Resolution height for GIFs in pixel:<br/>(If empty then no restrictions)</p>';
echo "</td>";
echo "<td>";
echo '<input id="MaxResGIFheight" type="text" name="MaxResGIFheight" value="'.$MaxResGIFheight.'" maxlength="20" ><br/>';
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<br>";
echo "<hr>";

echo "<table>";
echo "<tr>";
echo "<td colspan='2'>";
echo '<p><strong><u>E-mail to administator after upload</u></strong></p>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td>";
echo '<p>Inform admin after upload in frontend:</p>';
echo "</td>";
echo "<td>";
echo "<input id='InformAdmin' type='checkbox' class='$cgProFalse' name='InformAdmin' $InformAdmin > $cgProFalseText";
echo "</td>";
echo "</tr>";
echo "<tr><td colspan='2'>";
// Wenn aktiviert werden die User beim Activaten benachrichtigt
/*echo "<div>";
echo "<br/>";
echo '<input type="text" hidden name="id" value="' . @$id . '" method="post" >';
echo 'Inform users when activate pictures:';
echo '&nbsp;&nbsp;<input type="checkbox" name="inform"  value="1" '.$checkedInform.'><br/>';
echo "</div>";*/
// Absender Feld
echo "<div>";
echo 'Addressor (From):<br/>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="from" id="cgInformAdminFrom" value="'.$selectSQLemailAdmin->Admin.'"  maxlength="1000" > '.$cgProFalseText.'<br/>';
echo "</div>";

// Admin Mail
echo "<div>";
echo "<br/>";
echo 'Admin mail (To):<br/><b>(Should not be the same as "Reply mail")</b>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="AdminMail" id="cgInformAdminAdminMail" value="'.$selectSQLemailAdmin->AdminMail.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";

// Reply Feld
echo "<div>";
echo "<br/>";
echo 'Reply mail:<br/><b>(Should not be the same as "Admin mail")</b>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="reply" id="cgInformAdminReply" value="'.$selectSQLemailAdmin->Reply.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";

// CC Feld
echo "<div>";
echo "<br/>";
echo 'Cc mail:<br/><b>(Should not be the same as "Reply mail")</b><br/>';
echo '<small>Sending to multiple recipients example (mail1@example.com; mail2@example.com; mail3@example.com)</small><br>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="cc" id="cgInformAdminCc" value="'.$selectSQLemailAdmin->CC.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// BCC Feld
echo "<div>";
echo "<br/>";
echo 'Bcc mail:<br/><b>(Should not be the same as "Reply mail")</b><br/>';
echo '<small>Sending to multiple recipients example (mail1@example.com; mail2@example.com; mail3@example.com)</small><br>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="bcc"  id="cgInformAdminBcc" value="'.$selectSQLemailAdmin->BCC.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";

// Header Feld
echo "<div>";
echo "<br/>";
echo "<div id='answerUrl' style='position:absolute;margin-left:55px;width:200px;background-color:white;border:1px solid;padding:5px;display:none;'>Fill in this field the url of the ";
echo "site where you inserted the short code of this gallery.</div>";
echo 'Subject:<br/>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="header" id="cgInformAdminHeader" value="'.$selectSQLemailAdmin->Header.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// URL Feld
/*
echo "<div style='position:fix;'>";
echo "<br/>";
echo "<div id='answerLink' style='position:absolute;margin-left:315px;width:440px;background-color:white;border:1px solid;padding:5px;display:none;'>";
echo "You have to fill the url in the field abovve where you inserted the shortcode of this gallery. Then you have to put this variable in the editor. If user has an e-mail he will and inform user option is activated";
echo "then user will receive the url of their image which have been activated. Test it.</div>";
echo '<div id="questionUrl" style="display:inline;">Url: <a><b>?</b></a></div><br/>';
echo '<input type="text" name="url" value="'.$selectSQLemailAdmin->URL.'" size="112" maxlength="110" '.@$AllowGalleryScript.' ><br/>';
//echo $inputUrlLink;
echo 'Put this variable in the editor: <b>$url$</b> &nbsp; <div  id="questionLink" style="display:inline;width:15px;height:18px;" ><a><b>?</b></a></div>';
echo "</div>";
echo "<div>";
echo "<br>";
echo "</div>";		*/

// TinyMCE Editor
echo "<div style='' class='cg-small-textarea-container $cgProFalseContainer'>";
echo '<p>Mail content: '.$cgProFalseText.'</p>';
echo "(Use <strong>\$info$</strong> in the editor<br/> if you like to attach user info)</p>";

$editor_id = 'InformAdminText';

// TINY MCE Settings here
$settings = array(
    "media_buttons"=>false,
    "teeny" => true,
    'default_post_edit_rows'=> 10
);

//wp_editor( $ContentAdminMail, 'InformAdminText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='InformAdminText'  name='InformAdminText'>$ContentAdminMail</textarea>";

echo "</div>";

// Speichern Feld
echo "<div>";
echo "<br/>";
echo '</div>';
echo "</td>";
echo "</table>";
echo "</div>";


echo <<<HEREDOC
            <h4 id="view5" class="cg_view_header">Registration options</h4>
	<div class="cg_view cgRegistrationOptions">
HEREDOC;



echo "<table>";
/*echo "<tr><td>";
//echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
echo '<p><b><u>Upload options</u></b></p>';

echo "</td>";
echo "</tr>";*/

echo "<tr>";
echo "<td>";
echo '<p>Select user role group<br>for registered users over Contest Gallery:</p>';
echo "</td>";
echo "<td>";
//echo '<input type="checkbox" class="'.$cgProFalse.'" name="ActivateUpload" ' . @$ActivateUpload  . '> '.$cgProFalseText.' <br/>';
echo "<select name='RegistryUserRole'>";
$roles = get_editable_roles();

// show as last!!!!

$wordPressRolesAndContestGalleryRoleKeys = ["contest_gallery_user","subscriber", "contributor", "editor", "author", "administrator"];

$cgRegistryUserRoleSelected = ($RegistryUserRole=='contest_gallery_user') ? 'selected' : '';
echo "<option value='contest_gallery_user' $cgRegistryUserRoleSelected>Contest Gallery User</option>";

foreach($roles as $keyOfRole => $roleValues){

    if(in_array($keyOfRole,$wordPressRolesAndContestGalleryRoleKeys)){
        continue;
    }
    $otherRegistryUserRoleSelected = ($RegistryUserRole==$keyOfRole) ? 'selected' : '';
    echo "<option value='$keyOfRole' $otherRegistryUserRoleSelected>".$roleValues['name']."</option>";

    // subscriber, contributor, editor, author, administrator

}

$subscriberRegistryUserRoleSelected = ($RegistryUserRole=='subscriber') ? 'selected' : '';
echo "<option value='subscriber' $subscriberRegistryUserRoleSelected>Subscriber</option>";
$contributorRegistryUserRoleSelected = ($RegistryUserRole=='contributor') ? 'selected' : '';
echo "<option value='contributor' $contributorRegistryUserRoleSelected>Contributor</option>";
$editorRegistryUserRoleSelected = ($RegistryUserRole=='editor') ? 'selected' : '';
echo "<option value='editor' $editorRegistryUserRoleSelected>Editor</option>";
$authorRegistryUserRoleSelected = ($RegistryUserRole=='author') ? 'selected' : '';
echo "<option value='author' $authorRegistryUserRoleSelected>Author</option>";
$administratorRegistryUserRoleSelected = ($RegistryUserRole=='administrator') ? 'selected' : '';
echo "<option value='administrator' $administratorRegistryUserRoleSelected>Administrator</option>";

if(empty($cgRegistryUserRoleSelected) and
    empty($otherRegistryUserRoleSelected) and
    empty($subscriberRegistryUserRoleSelected) and
    empty($contributorRegistryUserRoleSelected) and
    empty($editorRegistryUserRoleSelected) and
    empty($authorRegistryUserRoleSelected) and
    empty($administratorRegistryUserRoleSelected)
){
    echo "<option value='' selected>No role</option>";
}

echo "</select>";

echo "</td>";
echo "</tr>";
echo "</table>";

echo "<hr>";

echo "<table>";

echo "<tr><td>";
//echo '<input type="text" hidden name="id" value="' . $id . '" method="post" >';
echo '<p><b><u>Registration options</u></b></p>';

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p><b>NEW!</b> Login user immediately after registration:<br><b>(User account will be created<br>right after registration and user will be logged in.<br>
User has not to confirm e-mail to be able to login.<br>Confirmation e-mail will be sent additionally.)</b></p>';
echo "</td>";
echo "<td>";
echo "<input id='RegMailOptional' type='checkbox' class='$cgProFalse' name='RegMailOptional' $RegMailOptional > $cgProFalseText";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container $cgProFalseContainer' colspan='2'>";
echo '<p>Confirmation text after registration: '.$cgProFalseText.' </p>';
//wp_editor( $ForwardAfterRegText, 'ForwardAfterRegText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='ForwardAfterRegText'  name='ForwardAfterRegText'>$ForwardAfterRegText</textarea>";

echo "</td>";
echo "</tr>";
echo "<tr>";

echo "<td class='cg-small-textarea-container $cgProFalseContainer' colspan='2'>";
echo '<p>Confirmation text after e-mail confirmation: '.$cgProFalseText.' </p>';
//wp_editor( $TextAfterEmailConfirmation, 'TextAfterEmailConfirmation',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='TextAfterEmailConfirmation'  name='TextAfterEmailConfirmation'>$TextAfterEmailConfirmation</textarea>";

echo "</td>";

echo "</tr>";
echo "</table>";


echo  "<br/>";
echo  "<hr/>";

echo "<table style='background-color:white;' width='884px;'>";
echo "<tr>";
echo "<td>";
echo '<p>Hide registration form if user is logged in:</p>';
echo "</td>";
echo "<td>";
echo "<input id='HideRegFormAfterLogin' type='checkbox' class='$cgProFalse' name='HideRegFormAfterLogin' $HideRegFormAfterLogin > $cgProFalseText";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Show text instead:</p>';
echo "</td>";
echo "<td>";
echo "<input id='HideRegFormAfterLoginShowTextInstead' type='checkbox' class='$cgProFalse' name='HideRegFormAfterLoginShowTextInstead' $HideRegFormAfterLoginShowTextInstead > $cgProFalseText";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='cg-small-textarea-container $cgProFalseContainer' colspan='2'>";
echo '<p class="cg_margin-top-10">Text to show:</p>';
//wp_editor( $HideRegFormAfterLoginTextToShow, 'HideRegFormAfterLoginTextToShow',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='HideRegFormAfterLoginTextToShow'  name='HideRegFormAfterLoginTextToShow'>$HideRegFormAfterLoginTextToShow</textarea>";

echo "</td>";
echo "</tr>";
echo "</table>";

echo  "<br/>";
echo  "<hr/>";
echo "<div>";
echo "<p></p>";
echo "</div>";

echo "<div>";
echo "<br/>";
echo '<strong><u>Confirmation e-mail options</u></strong><br/>';
echo "</div>";

// Absender Feld
echo "<div>";
echo "<br/>";
echo 'Addressor (From):<br/>';
echo '<input type="text" name="RegMailAddressor" class="cg-long-input" value="'.$RegMailAddressor.'"  maxlength="1000" ><br/>';
echo "</div>";

// Reply Feld
echo "<div>";
echo "<br/>";
echo 'Reply mail:<br/>'.$replyMailNote;
echo '<input type="text" name="RegMailReply" class="cg-long-input" value="'.$RegMailReply.'"  maxlength="1000"><br/>';
echo "</div>";

// Subject Feld
echo "<div>";
echo "<br/>";
echo "<div id='answerUrl' style='position:absolute;margin-left:55px;width:200px;background-color:white;border:1px solid;padding:5px;display:none;'>Fill in this field the url of the ";
echo "site where you inserted the short code of this gallery.</div>";
echo 'Subject:<br/>';
echo '<input type="text" name="RegMailSubject" class="cg-long-input" value="'.$RegMailSubject.'"  maxlength="1000"><br/>';
echo 'Put this variable in the mail content editor: <strong>$regurl$</strong><br>(Link to confirmation page will appear in the e-mail<br>It will be the same page where your registration shortcode is inserted)';
echo '<br><a href="https://www.contest-gallery.com/documentation/#cgDisplayConfirmationURL" target="_blank" class="cg-documentation-link">Documentation: How to make the link clickable in e-mail</a>';
echo "</div>";


// TinyMCE Editor
echo "<div class='cg-small-textarea-container $cgProFalseContainer'>";
echo "<p>Mail content: $cgProFalseText</p>";
//wp_editor( $TextEmailConfirmation, 'TextEmailConfirmation',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='TextEmailConfirmation'  name='TextEmailConfirmation'>$TextEmailConfirmation</textarea>";

echo "</div>";

// Speichern Feld
echo "<div>";
echo "<br/>";
echo '</div>';

echo "</div>";
echo <<<HEREDOC
            <h4 id="view6" class="cg_view_header">Login options</h4>
	<div class="cg_view cgLoginOptions">
HEREDOC;

echo "<table style='background-color:white;' width='884px;'>";

echo "<tr>";
echo "<td>";
echo '<p>Forward to another page after login:</p>';
echo "</td>";
echo "<td>";
echo "<input id='ForwardAfterLoginUrlCheck' type='checkbox' class='$cgProFalse' name='ForwardAfterLoginUrlCheck' $ForwardAfterLoginUrlCheck > $cgProFalseText";
echo "</td>";
echo "</tr>";
echo "<tr>";

echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p class="cg_margin-top-0">Forward to URL:</p>';
echo '<input id="ForwardAfterLoginUrl" class="cg-long-input '.$cgProFalse.'" placeholder="'.get_site_url().'" type="text" name="ForwardAfterLoginUrl" maxlength="999" value="'.$ForwardAfterLoginUrl.'"/> '.$cgProFalseText.'';
echo "</td>";

echo "</tr>";

echo "<tr><td style='padding-left:20px;width:300px;padding-right:65px;' colspan='2'>";
echo '<br>';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo '<p>Confirmation text on same site after login:</p>';
echo "</td>";
echo "<td>";
echo "<input id='ForwardAfterLoginTextCheck' type='checkbox' class='$cgProFalse' name='ForwardAfterLoginTextCheck' $ForwardAfterLoginTextCheck > $cgProFalseText";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='cg-small-textarea-container $cgProFalseContainer' colspan='2'>";
echo '<p class="cg_margin-top-0">Confirmation Text after login: '.$cgProFalseText.'</p>';
//wp_editor( $ForwardAfterLoginText, 'ForwardAfterLoginText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='ForwardAfterLoginText'  name='ForwardAfterLoginText'>$ForwardAfterLoginText</textarea>";

echo "</td>";
echo "</tr>";



echo "</table>";

echo "</div>";


echo <<<HEREDOC
            <h4 id="view7" class="cg_view_header">E-mail confirmation e-mail</h4>
	<div class='cg_view cgEmailConfirmationEmail'>
HEREDOC;

echo "<div>";
//echo '<input type="text" hidden name="id" value="' . @$id . '" method="post" >';
echo '<h2>Create e-mail field in "Edit upload form" to send this confirmation e-mail after an upload.
After an e-mail address is confirmed this e-mail will not be send anymore.
       </h2>';
echo "<hr/>";

echo "</div>";



echo "<table style='background-color:white;' width='884px;'>";

echo "<tr>";
echo "<td>";
echo '<p>Activate this confirmation e-mail:</p>';

echo "</td>";
echo "<td>";
echo '<input type="checkbox" class="'.$cgProFalse.'" name="mConfirmSendConfirm" id="mConfirmSendConfirm" value="1" ' . @$mConfirmSendConfirm  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "</table>";


echo "<div>";
echo "<p><strong>Use this shortcode on the confirmation page</strong>: <br><span class='cg_shortcode_parent'><span class='cg_shortcode_copy cg_shortcode_copy_mail_confirm cg_tooltip'></span><span class='cg_shortcode_copy_text'>[cg_mail_confirm id=\"$GalleryID\"]</span></span></p>";
echo "</div>";

// Absender Feld
echo "<div>";
echo 'Addressor (From):<br/>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="mConfirmAdmin" id="mConfirmAdmin" value="'.$selectSQLmailConfirmation->Admin.'"  maxlength="1000" > '.$cgProFalseText.'<br/>';
echo "</div>";

// Reply Feld
echo "<div>";
echo "<br/>";
echo 'Reply mail:<br/>'.$replyMailNote;
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="mConfirmReply" id="mConfirmReply" value="'.$selectSQLmailConfirmation->Reply.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// CC Feld
echo "<div>";
echo "<br/>";
echo 'Cc mail:<br/><b>(Should not be the same as "Reply mail")</b><br/>';
echo '<small>Sending to multiple recipients example (mail1@example.com; mail2@example.com; mail3@example.com)</small><br>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="mConfirmCC" id="mConfirmCC" value="'.$selectSQLmailConfirmation->CC.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// BCC Feld
echo "<div>";
echo "<br/>";
echo 'Bcc mail:<br/><b>(Should not be the same as "Reply mail")</b><br/>';
echo '<small>Sending to multiple recipients example (mail1@example.com; mail2@example.com; mail3@example.com)</small><br>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="mConfirmBCC" id="mConfirmBCC" value="'.$selectSQLmailConfirmation->BCC.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";

// Header Feld
echo "<div>";
echo "<br/>";
echo "<div id='answerUrl' style='position:absolute;margin-left:55px;width:200px;background-color:white;border:1px solid;padding:5px;display:none;'>Fill in this field the url of the ";
echo "site where you inserted the short code of this gallery.</div>";
echo 'Subject:<br/>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" name="mConfirmHeader" id="mConfirmHeader" value="'.contest_gal1ery_no_convert($selectSQLmailConfirmation->Header).'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// URL Feld
echo "<div>";
echo "<br/>";
echo "<div id='answerLink' style='position:absolute;margin-left:315px;width:440px;background-color:white;border:1px solid;padding:5px;display:none;'>";
echo "You have to fill the url in the field abovve where you inserted the shortcode of this gallery. Then you have to put this variable in the editor. If user has an e-mail he will and inform user option is activated";
echo "then user will receive the url of their image which have been activated. Test it.</div>";
echo '<div id="questionUrl" style="display:inline;">URL to confirmation page: URL of same page where the shortcode [cg_mail_confirm id="'.$GalleryID.'"] is inserted</div><br/>';
echo '<input type="text" class="cg-long-input '.$cgProFalse.'" id="mConfirmURL" name="mConfirmURL" placeholder="'.get_site_url().'" value="'.$selectSQLmailConfirmation->URL.'"  maxlength="1000" > '.$cgProFalseText.'<br/>';
//echo $inputUrlLink;
echo 'Put this variable in the mail content editor: <strong>$url$</strong><br>(Link to confirmation page will appear in the e-mail)';
echo '<br><a href="https://www.contest-gallery.com/documentation/#cgDisplayConfirmationURL" target="_blank" class="cg-documentation-link">Documentation: How to make the link clickable in e-mail</a>';
echo "</div>";
echo "<div>";
echo "</div>";

// TinyMCE Editor
echo "<div class='cg-small-textarea-container $cgProFalseContainer'>";

echo "<p>Mail content: $cgProFalseText</p>";
//wp_editor(contest_gal1ery_convert_for_html_output_without_nl2br($selectSQLmailConfirmation->Content), 'mConfirmContent',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='mConfirmContent'  name='mConfirmContent'>".contest_gal1ery_convert_for_html_output_without_nl2br($selectSQLmailConfirmation->Content)."</textarea>";


echo "</div>";

echo "<div class='cg-small-textarea-container $cgProFalseContainer'>";
echo '<p>Text after e-mail confirmation: '.$cgProFalseText.'</p>';
//wp_editor(contest_gal1ery_convert_for_html_output_without_nl2br($selectSQLmailConfirmation->ConfirmationText), 'mConfirmConfirmationText',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='mConfirmConfirmationText'  name='mConfirmConfirmationText'>".contest_gal1ery_convert_for_html_output_without_nl2br($selectSQLmailConfirmation->ConfirmationText)."</textarea>";

echo "</div>";

// Speichern Feld
echo "<div>";
echo "<br/>";
echo '</div>';

echo "</div>";
echo <<<HEREDOC
            <h4 id="view8" class="cg_view_header">Image activation e-mail</h4>
	<div class="cg_view ">
HEREDOC;
echo "<div>";
//echo '<input type="text" hidden name="id" value="' . @$id . '" method="post" >';
echo '<h2>Create e-mail field in "Edit upload form" to inform users when activating their image.</h2>';
echo "<hr/>";

echo "</div>";

echo "<table>";
echo "<tr>";
echo "<td>";
echo '<p>Send this activation e-mail<br> when activating user images:</p>';
echo "</td>";
echo "<td>";
echo '<input type="checkbox" name="InformUsers" class="'.$cgProFalse.'" id="InformUsers" value="1" ' . @$checkInform  . '> '.$cgProFalseText.'<br/>';
echo "</td>";
echo "</tr>";
echo "</table>";

// Absender Feld
echo "<div>";
echo 'Addressor (From):<br/>';
echo '<input type="text" name="from_user_mail" id="from_user_mail" class="cg-long-input '.$cgProFalse.'" value="'.$selectSQLemail->Admin.'"  maxlength="1000" > '.$cgProFalseText.'<br/>';
echo "</div>";

// Reply Feld
echo "<div>";
echo "<br/>";
echo 'Reply mail:<br/>'.$replyMailNote;
echo '<input type="text" name="reply_user_mail" id="reply_user_mail" class="cg-long-input '.$cgProFalse.'" value="'.$selectSQLemail->Reply.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";

// CC Feld
echo "<div>";
echo "<br/>";
echo 'Cc mail:<br/><b>(Should not be the same as "Reply mail")</b><br/>';
echo '<small>Sending to multiple recipients example (mail1@example.com; mail2@example.com; mail3@example.com)</small><br>';
echo '<input type="text" name="cc_user_mail" id="cc_user_mail" class="cg-long-input '.$cgProFalse.'" value="'.$selectSQLemail->CC.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// BCC Feld
echo "<div>";
echo "<br/>";
echo 'Bcc mail:<br/><b>(Should not be the same as "Reply mail")</b><br/>';
echo '<small>Sending to multiple recipients example (mail1@example.com; mail2@example.com; mail3@example.com)</small><br>';
echo '<input type="text" name="bcc_user_mail" id="bcc_user_mail" class="cg-long-input '.$cgProFalse.'" value="'.$selectSQLemail->BCC.'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";

// Header Feld
echo "<div>";
echo "<br/>";
echo "<div id='answerUrl' style='position:absolute;margin-left:55px;width:200px;background-color:white;border:1px solid;padding:5px;display:none;'>Fill in this field the url of the ";
echo "site where you inserted the short code of this gallery.</div>";
echo 'Subject:<br/>';
echo '<input type="text" name="header_user_mail" id="header_user_mail" class="cg-long-input '.$cgProFalse.'"  value="'.contest_gal1ery_no_convert($selectSQLemail->Header).'"  maxlength="1000"> '.$cgProFalseText.'<br/>';
echo "</div>";


// URL Feld
echo "<div>";
echo "<br/>";
echo "<div id='answerLink' style='position:absolute;margin-left:315px;width:440px;background-color:white;border:1px solid;padding:5px;display:none;'>";
echo "You have to fill the url in the field abovve where you inserted the shortcode of this gallery. Then you have to put this variable in the editor. If user has an e-mail he will and inform user option is activated";
echo "then user will receive the url of their image which have been activated. Test it.</div>";
echo '<div id="questionUrl" style="display:inline;">URL: (URL of same page where shortcode [cg_gallery id="'.$GalleryID.'"] of this gallery is inserted)</div><br/>';
echo '<input type="text" name="url_user_mail" id="url_user_mail" class="cg-long-input '.$cgProFalse.'" placeholder="'.get_site_url().'" value="'.$selectSQLemail->URL.'"  maxlength="1000" > '.$cgProFalseText.'<br/>';
//echo $inputUrlLink;
echo 'Put this variable in the mail content editor: <strong>$url$</strong><br>(Link to users image in confirmation mail will appear when the image is activated)';
echo '<br><a href="https://www.contest-gallery.com/documentation/#cgDisplayConfirmationURL" target="_blank" class="cg-documentation-link">Documentation: How to make the link clickable in e-mail</a>';
echo "</div>";

// TinyMCE Editor
echo "<div class='cg-small-textarea-container $cgProFalseContainer'>";

echo "<p>Mail content: $cgProFalseText</p>";
//wp_editor( $contentUserMail, 'cgEmailImageActivating',  $settingsHTMLarea);
echo "<textarea class='cg-wp-editor-template' id='cgEmailImageActivating'  name='cgEmailImageActivating'>$contentUserMail</textarea>";

echo "</div>";

// Speichern Feld
echo "<div>";
echo "<br/>";
echo '</div>';

echo "</div>";

/*
//echo <<<HEREDOC
//	<div id="view9" style="position:relative;">
//HEREDOC;
/*
// Wenn aktiviert werden die User beim Activaten benachrichtigt
echo "<div style='padding-left:20px;padding-right:20px;'>";
echo "<br/>";
//echo '<input type="text" hidden name="id" value="' . @$id . '" method="post" >';
echo '<h2>Send an e-mail to all users of this gallery with activated image</h2>If an e-mail has several images only one e-mail will be send. No spam :)';
echo "</div>";
// Wenn aktiviert werden die User beim Activaten benachrichtigt
echo "<div style='padding-left:20px;padding-right:20px;'>";
echo  "<br/>";echo  "<br/>";
echo 'Send also e-mail to users who\'s images is not activated: &nbsp;&nbsp;<input type="checkbox" name="mGallerySendToImageOff"  value="1" '.$mGallerySendToImageOff.'>';
echo "</div>";
// Wenn aktiviert werden die User beim Activaten benachrichtigt
echo "<div style='padding-left:20px;padding-right:20px;'>";
echo  "<br/>";
echo 'Send also e-mail to users who\'s email is not confirmed: &nbsp;&nbsp;<input type="checkbox" name="mGallerySendToNotConfirmedUsers"  value="1" '.$mGallerySendToNotConfirmedUsers.'>';
echo "</div>";
echo  "<br/>";
echo  "<hr/>";
// Absender Feld
echo "<div style='padding-left:20px;display:inline;float:left;width:450px;'>";
echo "<br/>";
echo 'Addressor (From):<br/>';
echo '<input type="text" name="mGalleryAdmin" value="'.$selectSQLmailGallery->Admin.'" size="60" maxlength="200" ><br/>';
echo "</div>";

// Reply Feld
echo "<div style='padding-left:20px;display:inline;float:left;width:450px;'>";
echo "<br/>";
echo 'Reply mail:<br/>';
echo '<input type="text" name="mGalleryReply" value="'.$selectSQLmailGallery->Reply.'" size="60" maxlength="200"><br/>';
echo "</div>";

// CC Feld
echo "<div style='padding-left:20px;display:inline;float:left;width:450px;'>";
echo "<br/>";
echo 'Cc mail:<br/>';
echo '<input type="text" name="mGalleryCC" value="'.$selectSQLmailGallery->CC.'" size="60" maxlength="200"><br/>';
echo "</div>";


// BCC Feld
echo "<div style='padding-left:20px;display:inline;float:left;width:450px;'>";
echo "<br/>";
echo 'Bcc mail:<br/>';
echo '<input type="text" name="mGalleryBCC" value="'.$selectSQLmailGallery->BCC.'" size="60" maxlength="200"><br/>';
echo "</div>";

// Blacklist
echo "<div style='padding-left:20px;display:inline;float:right;height:280px;width:400px;position:absolute;left:480px;top: 197px;'>";
echo "<br/>";
echo 'Blacklist:<br/>';
echo '<textarea name="mGalleryBlacklist" style="height:236px;width:354px;">'.$selectSQLmailGallery->Blacklist.'</textarea>';
echo "</div>";

// Header Feld
echo "<div style='padding-left:20px;clear:both;'>";
echo "<br/>";
echo "<div id='answerUrl' style='position:absolute;margin-left:55px;width:200px;background-color:white;border:1px solid;padding:5px;display:none;'>Fill in this field the url of the ";
echo "site where you inserted the short code of this gallery.</div>";
echo 'Subject:<br/>';
echo '<input type="text" name="mGalleryHeader" value="'.$selectSQLmailGallery->Header.'"  maxlength="200"><br/>';
echo "</div>";

echo "<br/>";


// TinyMCE Editor
echo "<div style='padding-left:20px;padding-right:20px;'>";

$editor_id = 'mGalleryContent';

wp_editor( $selectSQLmailGallery->Content, $editor_id,  $settings);
echo "</div>";

// TinyMCE Editor
echo "<div style='padding-left:735px;padding-right:20px;'>";

echo '<p><input type="button" value="Send e-mail" style="text-align:center;width:120px;" /></p>';

echo "</div>";
// TinyMCE Editor
echo "<div style='margin-left:20px;margin-right:18px;padding-left:20px;padding-right:20px;border:1px solid #ddd;'>";

echo '<p style="text-align:center;">No e-mails were send so far</p>';

echo "</div>";

// Speichern Feld
echo "<div>";
echo "<br/>";
echo '</div>';

echo "</div>";*/



echo <<<HEREDOC

            <h4 id="view9" class="cg_view_header">Translations</h4>
            <div class="cg_view cgTranslationOptions">
HEREDOC;

echo "<div>";
//echo '<input type="text" hidden name="id" value="' . @$id . '" method="post" >';
echo '<h2>Translations here will replace language files translations.
       </h2>';
echo "<hr/>";

echo "</div>";

echo "<table id='cgTranslationOptionsTable'>";
echo "<tr>";

echo '<td colspan="2" class="translation-options-header"><p><b><u>Gallery/Upload</u></b></p></td>';

echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_ThePhotoContestHasNotStartedYet.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_ThePhotoContestHasNotStartedYet.']" maxlength="100" value="'.$translations[$l_ThePhotoContestHasNotStartedYet].'">';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_ThePhotoContestIsOver.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_ThePhotoContestIsOver.']" maxlength="100" value="'.$translations[$l_ThePhotoContestIsOver].'">';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_Yes.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_Yes.']" maxlength="100" value="'.$translations[$l_Yes].'">';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_No.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_No.']" maxlength="100" value="'.$translations[$l_No].'">';
echo "</td>";
echo "</tr>";


echo "<tr>";

echo '<td colspan="2" class="translation-options-header"><p><b><u>Gallery</u></b></p></td>';

echo "</tr>";

include('translations-html/translations-html-gallery.php');

echo "<tr>";

echo '<td colspan="2" class="translation-options-header"><p><b><u>User Gallery</u></b></p></td>';

echo "</tr>";

include('translations-html/translations-html-gallery-user.php');

echo "<tr>";

echo '<td colspan="2" class="translation-options-header"><p><b><u>Comment area</u></b></p></td>';

echo "</tr>";

echo "<tr>";

include('translations-html/translations-html-comment-area.php');

echo "<tr>";

echo '<td colspan="2" class="translation-options-header"><p><b><u>Upload/Registry form</u></b></p></td>';

echo "</tr>";

include('translations-html/translations-html-upload-registry.php');

echo "<tr>";

echo '<td colspan="2" class="translation-options-header"><p><b><u>Login form</u></b></p></td>';

echo "</tr>";

include('translations-html/translations-html-login.php');

echo "</table>";
echo <<<HEREDOC
            </div>

<input type="hidden" name="changeSize" value="true" />
<p style="padding-left: 758px;margin-bottom: 0;margin-top: 20px;" id="cg_save_all_options" class="cg_hidden"><input  class="cg_backend_button_gallery_action" type="submit" value="Save all options" id="cgSaveOptionsButton" /></p>

 </div>
 

            </div>
HEREDOC;


echo "</form>";



?>