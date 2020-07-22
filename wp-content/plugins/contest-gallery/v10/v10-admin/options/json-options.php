<?php

/*$jsonOptions = array();
$jsonOptions['general'] = array();
$jsonOptions['visual'] = array();
$jsonOptions['input'] = array();*/


if(!empty($nextIDgallery)){
    $GalleryID = $nextIDgallery;
    $id = $nextIDgallery;
    $jsonOptions = array();
    $jsonOptions['visual'] = array();
    $jsonOptions['general'] = array();
    $jsonOptions['input'] = array();
    $jsonOptions['pro'] = array();
}
else{
    $wp_upload_dir = wp_upload_dir();
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
    $fp = fopen($optionsFile, 'r');
    $jsonOptions =json_decode(fread($fp,filesize($optionsFile)),true);
    fclose($fp);
}



$ForwardAfterRegText = $ForwardAfterRegText;

$ForwardAfterLoginUrlCheck = 0;
$ForwardAfterLoginUrl = '';

$ForwardAfterLoginTextCheck = 1;
$ForwardAfterLoginText = $ForwardAfterLoginText;

$TextEmailConfirmation = $TextEmailConfirmation;
$TextAfterEmailConfirmation = $TextAfterEmailConfirmation;

$RegMailAddressor = $RegMailAddressor;
$RegMailReply = $RegMailReply;
$RegMailSubject = $RegMailSubject;
$RegUserUploadOnlyText = $RegUserUploadOnlyText;

$jsonOptions['visual']['ThumbViewBorderWidth'] = $ThumbViewBorderWidth;
$jsonOptions['visual']['ThumbViewBorderRadius'] = $ThumbViewBorderRadius;
$jsonOptions['visual']['ThumbViewBorderOpacity'] = $ThumbViewBorderOpacity;
$jsonOptions['visual']['ThumbViewBorderColor'] = $ThumbViewBorderColor;
$jsonOptions['visual']['HeightViewBorderWidth'] = $HeightViewBorderWidth;
$jsonOptions['visual']['HeightViewBorderRadius'] = $HeightViewBorderRadius;
$jsonOptions['visual']['HeightViewBorderColor'] = $HeightViewBorderColor;
$jsonOptions['visual']['HeightViewBorderOpacity'] = $HeightViewBorderOpacity;
$jsonOptions['visual']['HeightViewSpaceWidth'] = $HeightViewSpaceWidth;
$jsonOptions['visual']['HeightViewSpaceHeight'] = $HeightViewSpaceHeight;
$jsonOptions['visual']['RowViewBorderWidth'] = $RowViewBorderWidth;
$jsonOptions['visual']['RowViewBorderRadius'] = $RowViewBorderRadius;
$jsonOptions['visual']['RowViewBorderColor'] = $RowViewBorderColor;
$jsonOptions['visual']['RowViewBorderOpacity'] = $RowViewBorderOpacity;
$jsonOptions['visual']['RowViewSpaceWidth'] = $RowViewSpaceWidth;
$jsonOptions['visual']['RowViewSpaceHeight'] = $RowViewSpaceHeight;
$jsonOptions['visual']['TitlePositionGallery'] = $TitlePositionGallery;
$jsonOptions['visual']['RatingPositionGallery'] = $RatingPositionGallery;
$jsonOptions['visual']['CommentPositionGallery'] = $CommentPositionGallery;
$jsonOptions['visual']['ActivateGalleryBackgroundColor'] = $ActivateGalleryBackgroundColor;
$jsonOptions['visual']['GalleryBackgroundColor'] = $GalleryBackgroundColor;
$jsonOptions['visual']['OriginalSourceLinkInSlider'] = $OriginalSourceLinkInSlider;
$jsonOptions['visual']['PreviewInSlider'] = $PreviewInSlider;
$jsonOptions['visual']['FeControlsStyle'] = $FeControlsStyle;
$jsonOptions['visual']['AllowSortOptions'] = $AllowSortOptions;

$jsonOptions['general']['WidthThumb'] = $WidthThumb;
$jsonOptions['general']['HeightThumb'] = $HeightThumb;
$jsonOptions['general']['WidthGallery'] = $WidthGallery;
$jsonOptions['general']['HeightGallery'] = $HeightGallery;
$jsonOptions['general']['DistancePics'] = $DistancePics;
$jsonOptions['general']['DistancePicsV'] = $DistancePicsV;
$jsonOptions['general']['ContestEndTime'] = $ContestEndTime;

$jsonOptions['general']['gid'] = $id;
$jsonOptions['general']['plugins_url'] = plugins_url();

$jsonOptions['general']['PicsPerSite'] = $PicsPerSite;
$jsonOptions['general']['GalleryName'] = $GalleryName;
$jsonOptions['general']['MaxResJPGon'] = $MaxResJPGon;
$jsonOptions['general']['MaxResPNGon'] = $MaxResPNGon;
$jsonOptions['general']['MaxResGIFon'] = $MaxResGIFon;

$jsonOptions['general']['MaxResJPGwidth'] = $MaxResJPGwidth;
$jsonOptions['general']['MaxResJPGheight'] = $MaxResJPGheight;
$jsonOptions['general']['MaxResPNGwidth'] = $MaxResPNGwidth;
$jsonOptions['general']['MaxResPNGheight'] = $MaxResPNGheight;
$jsonOptions['general']['MaxResGIFwidth'] = $MaxResGIFwidth;
$jsonOptions['general']['MaxResGIFheight'] = $MaxResGIFheight;

$jsonOptions['general']['OnlyGalleryView'] = $OnlyGalleryView;
$jsonOptions['general']['SinglePicView'] = $SinglePicView;
$jsonOptions['general']['ScaleOnly'] = $ScaleOnly;
$jsonOptions['general']['ScaleAndCut'] = $ScaleAndCut;
$jsonOptions['general']['FullSize'] = $FullSize;
$jsonOptions['general']['FullSizeGallery'] = $FullSizeGallery;
$jsonOptions['general']['FullSizeSlideOutStart'] = $FullSizeSlideOutStart;
$jsonOptions['general']['AllowSort'] = $AllowSort;
$jsonOptions['general']['RandomSort'] = $RandomSort;
$jsonOptions['general']['RandomSortButton'] = $RandomSortButton;
$jsonOptions['general']['ShowAlways'] = $ShowAlways;

$jsonOptions['general']['AllowComments'] = $AllowComments;
$jsonOptions['general']['CommentsOutGallery'] = $CommentsOutGallery;
$jsonOptions['general']['AllowRating'] = $AllowRating;
$jsonOptions['general']['VotesPerUser'] = $VotesPerUser;
$jsonOptions['general']['RatingOutGallery'] = $RatingOutGallery;
$jsonOptions['general']['IpBlock'] = $IpBlock;

$jsonOptions['general']['ThumbLookOrder'] = $ThumbLookOrder;
$jsonOptions['general']['HeightLookOrder'] = $HeightLookOrder;
$jsonOptions['general']['RowLookOrder'] = $RowLookOrder;

$jsonOptions['general']['CheckLogin'] = $CheckLogin;
$jsonOptions['general']['CheckIp'] = $CheckIp;
$jsonOptions['general']['CheckCookie'] = $CheckCookie;
$jsonOptions['general']['CheckCookieAlertMessage'] = $CheckCookieAlertMessage;
$jsonOptions['general']['FbLike'] = $FbLike;
$jsonOptions['general']['FbLikeGallery'] = $FbLikeGallery;
$jsonOptions['general']['FbLikeGalleryVote'] = $FbLikeGalleryVote;
$jsonOptions['general']['AllowGalleryScript'] = $AllowGalleryScript;
$jsonOptions['general']['InfiniteScroll'] = $InfiniteScroll;
$jsonOptions['general']['FullSizeImageOutGallery'] = $FullSizeImageOutGallery;
$jsonOptions['general']['FullSizeImageOutGalleryNewTab'] = $FullSizeImageOutGalleryNewTab;

$jsonOptions['general']['Inform'] = $Inform;
$jsonOptions['general']['ShowAlwaysInfoSlider'] = $ShowAlwaysInfoSlider;
$jsonOptions['general']['ThumbLook'] = $ThumbLook;
$jsonOptions['general']['AdjustThumbLook'] = $AdjustThumbLook;
$jsonOptions['general']['HeightLook'] = $HeightLook;
$jsonOptions['general']['RowLook'] = $RowLook;

$jsonOptions['general']['HeightLookHeight'] = $HeightLookHeight;
$jsonOptions['general']['ThumbsInRow'] = $ThumbsInRow;
$jsonOptions['general']['PicsInRow'] = $PicsInRow;
$jsonOptions['general']['LastRow'] = $LastRow;
$jsonOptions['general']['HideUntilVote'] = $HideUntilVote;
$jsonOptions['general']['ShowOnlyUsersVotes'] = $ShowOnlyUsersVotes;
$jsonOptions['general']['HideInfo'] = $HideInfo;
$jsonOptions['general']['ActivateBulkUpload'] = $ActivateBulkUpload;
$jsonOptions['general']['ContestEnd'] = $ContestEnd;

$jsonOptions['general']['ForwardToURL'] = $ForwardToURL;
$jsonOptions['general']['ForwardFrom'] = $ForwardFrom;
$jsonOptions['general']['ForwardType'] = $ForwardType;

$jsonOptions['general']['ActivatePostMaxMB'] = $ActivatePostMaxMB;
$jsonOptions['general']['PostMaxMB'] = $PostMaxMB;

$jsonOptions['general']['BulkUploadQuantity'] = $BulkUploadQuantity;
$jsonOptions['general']['BulkUploadMinQuantity'] = $BulkUploadMinQuantity;
$jsonOptions['general']['Version'] = $dbVersion;
$jsonOptions['general']['SliderLook'] = $SliderLook;
$jsonOptions['general']['SliderLookOrder'] = $SliderLookOrder;
$jsonOptions['general']['ContestStart'] = $ContestStart;
$jsonOptions['general']['ContestStartTime'] = $ContestStartTime;

$jsonOptions['general']['InformAdmin'] = $InformAdmin;

$jsonOptions['input']['Forward'] = $Forward;
$jsonOptions['input']['Forward_URL'] = $Forward_URL;
$jsonOptions['input']['Confirmation_Text'] = $confirmation_text;

$jsonOptions['pro']['ForwardAfterRegUrl'] = $ForwardAfterRegUrl;
$jsonOptions['pro']['ForwardAfterRegText'] = $ForwardAfterRegText;
$jsonOptions['pro']['ForwardAfterLoginUrlCheck'] = $ForwardAfterLoginUrlCheck;
$jsonOptions['pro']['ForwardAfterLoginUrl'] = $ForwardAfterLoginUrl;
$jsonOptions['pro']['ForwardAfterLoginTextCheck'] = $ForwardAfterLoginTextCheck;
$jsonOptions['pro']['ForwardAfterLoginText'] = $ForwardAfterLoginText;
$jsonOptions['pro']['TextEmailConfirmation'] = $TextEmailConfirmation;
$jsonOptions['pro']['TextAfterEmailConfirmation'] = $TextAfterEmailConfirmation;
$jsonOptions['pro']['RegMailAddressor'] = $RegMailAddressor;
$jsonOptions['pro']['RegMailReply'] = $RegMailReply;
$jsonOptions['pro']['RegMailSubject'] = $RegMailSubject;
$jsonOptions['pro']['RegUserUploadOnly'] = $RegUserUploadOnly;
$jsonOptions['pro']['RegUserUploadOnlyText'] = $RegUserUploadOnlyText;
$jsonOptions['pro']['Manipulate'] = $Manipulate;
$jsonOptions['pro']['Search'] = $Search;
$jsonOptions['pro']['GalleryUpload'] = $GalleryUpload;
$jsonOptions['pro']['GalleryUploadOnlyUser'] = $GalleryUploadOnlyUser;
$jsonOptions['pro']['GalleryUploadConfirmationText'] = $GalleryUploadConfirmationText;
$jsonOptions['pro']['GalleryUploadTextBefore'] = $GalleryUploadTextBefore;
$jsonOptions['pro']['GalleryUploadTextAfter'] = $GalleryUploadTextAfter;
$jsonOptions['pro']['ShowNickname'] = $ShowNickname;
$jsonOptions['pro']['MinusVote'] = $MinusVote;
$jsonOptions['pro']['SlideTransition'] = $SlideTransition;
$jsonOptions['pro']['VotesInTime'] = $VotesInTime;
$jsonOptions['pro']['VotesInTimeQuantity'] = $VotesInTimeQuantity;
$jsonOptions['pro']['VotesInTimeIntervalReadable'] = $VotesInTimeIntervalReadable;
$jsonOptions['pro']['VotesInTimeIntervalSeconds'] = $VotesInTimeIntervalSeconds;
$jsonOptions['pro']['VotesInTimeIntervalAlertMessage'] = $VotesInTimeIntervalAlertMessage;
$jsonOptions['pro']['ShowExif'] = $ShowExif;
$jsonOptions['pro']['SliderFullWindow'] = $SliderFullWindow;
$jsonOptions['pro']['CatWidget'] = $CatWidget;
$jsonOptions['pro']['ShowOther'] = $ShowOther;
$jsonOptions['pro']['ShowCatsUnchecked'] = $ShowCatsUnchecked;

$jsonOptions['pro']['HideRegFormAfterLogin'] = $HideRegFormAfterLogin;
$jsonOptions['pro']['HideRegFormAfterLoginShowTextInstead'] = $HideRegFormAfterLoginShowTextInstead;
$jsonOptions['pro']['HideRegFormAfterLoginTextToShow'] = $HideRegFormAfterLoginTextToShow;

$jsonOptions['pro']['RegUserGalleryOnly'] = $RegUserGalleryOnly;
$jsonOptions['pro']['RegUserGalleryOnlyText'] = $RegUserGalleryOnlyText;
$jsonOptions['pro']['RegUserMaxUpload'] = $RegUserMaxUpload;
$jsonOptions['pro']['IsModernFiveStar'] = $IsModernFiveStar;
$jsonOptions['pro']['VoteNotOwnImage'] = $VoteNotOwnImage;
$jsonOptions['pro']['PreselectSort'] = $PreselectSort;
$jsonOptions['pro']['UploadRequiresCookieMessage'] = $UploadRequiresCookieMessage;
$jsonOptions['pro']['RegMailOptional'] = $RegMailOptional;
