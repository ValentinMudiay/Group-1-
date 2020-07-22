<?php

// general values

$GalleryName = '';
$PicsPerSite = 20;
$WidthThumb = 300;
$HeightThumb = 200;
$WidthGallery = 640;

$HeightGallery = 400;
$DistancePics = 3;
$DistancePicsV = 3;
$MaxResJPGon = 0;
$MaxResPNGon = 0;
$MaxResGIFon = 0;

$MaxResJPG = 25000000;
$MaxResJPGwidth = 800;
$MaxResJPGheight = 600;
$MaxResPNG = 25000000;
$MaxResPNGwidth = 800;
$MaxResPNGheight = 600;
$MaxResGIF = 25000000;
$MaxResGIFwidth = 800;
$MaxResGIFheight = 600;

$OnlyGalleryView = 0;
$SinglePicView = 0;
$ScaleOnly = 1;
$ScaleAndCut = 0;
$FullSize = 1;
$FullSizeGallery = 1;
$FullSizeSlideOutStart = 0;

$AllowSort = 1;
$RandomSort = 0;
$RandomSortButton = 1;
$AllowComments = 1;
$CommentsOutGallery = 1;
$AllowRating = 1;
$VotesPerUser = 0;
$RatingOutGallery = 1;
$ShowAlways = 1;
$ShowAlwaysInfoSlider = 0;
$IpBlock = 0;
$CheckLogin = 0;
$CheckIp = 1;
$CheckCookie = 0;
$CheckCookieAlertMessage = 'Please allow cookies to vote';

$FbLike = 0;
$FbLikeGallery = 0;
$FbLikeGalleryVote = 0;
$AllowGalleryScript = 1;
$InfiniteScroll = 0;
$FullSizeImageOutGallery = 0;
$FullSizeImageOutGalleryNewTab = 0;
$Inform = 0;
$InformAdmin = 0;
$TimestampPicDownload = 0;

$ThumbLook = 1;
$AdjustThumbLook = 1;
$HeightLook = 1;
$RowLook = 1;
$SliderLook = 1;

$ThumbLookOrder = 2;
$HeightLookOrder = 1;
$RowLookOrder = 3;
$SliderLookOrder = 4;

$HeightLookHeight = 300;
$ThumbsInRow = 1;
$PicsInRow = 3;
$LastRow = 2;
$HideUntilVote = 0;
$HideInfo = 3;
$ActivateUpload = 1;
$ContestEnd = 3;
$ContestEndTime = '';

$ForwardToURL = 1;
$ForwardFrom = 1;
$ForwardType = 0;
$ActivatePostMaxMB = 0;
$PostMaxMB = 2;
$ActivateBulkUpload = 0;
$BulkUploadQuantity = 3;
$BulkUploadMinQuantity = 2;
$ShowOnlyUsersVotes = 0;
$FbLikeGoToGalleryLink = '';
$Version = $dbVersion;

// visual

$CommentsAlignGallery = 'left';
$RatingAlignGallery = 'left';

$Field1IdGalleryView = '';
$Field1AlignGalleryView = 'left';
$Field2IdGalleryView = '';
$Field2AlignGalleryView = 'left';
$Field3IdGalleryView = '';
$Field3AlignGalleryView = 'left';

$ThumbViewBorderWidth = 0;
$ThumbViewBorderRadius = 0;
$ThumbViewBorderColor = '#000000';
$ThumbViewBorderOpacity = 1;
$HeightViewBorderWidth = 0;
$HeightViewBorderRadius = 0;
$HeightViewBorderColor = '#000000';
$HeightViewBorderOpacity = 1;
$HeightViewSpaceWidth = 0;
$HeightViewSpaceHeight = 0;

$RowViewBorderWidth = 0;
$RowViewBorderRadius = 0;
$RowViewBorderColor = '#000000';
$RowViewBorderOpacity = 1;
$RowViewSpaceWidth = 0;
$RowViewSpaceHeight = 0;
$TitlePositionGallery = 1;
$RatingPositionGallery = 1;
$CommentPositionGallery = 1;
$ActivateGalleryBackgroundColor = 0;

$GalleryBackgroundColor = '#000000';
$GalleryBackgroundOpacity = 1;
$OriginalSourceLinkInSlider = 1;
$PreviewInSlider = 1;
$FeControlsStyle = 'white';

// input
$Forward = 0;
$Forward_URL = '';

$ShowExif = 0;

if(function_exists('exif_read_data')){
    $ShowExif = 1;
}

// pro


$ForwardAfterRegUrl = '';

$ForwardAfterLoginUrlCheck = 0;
$ForwardAfterLoginUrl = '';

$ForwardAfterLoginTextCheck = 1;


$RegUserUploadOnly = 3;// IP tracking
$Manipulate = 1;
$ShowOther = 1;
$CatWidget = 1;
$Search = 1;
$GalleryUpload = 1;
$GalleryUploadOnlyUser = 0;
$GalleryUploadTextAfter = '';
$ShowNickname = 0;
$MinusVote = 0;
$SlideTransition = 'translateX';
$VotesInTime = 0;
$VotesInTimeQuantity = 1;
$VotesInTimeIntervalReadable = '24:00';
$VotesInTimeIntervalSeconds = 86400;
$VotesInTimeIntervalAlertMessage = "You can vote only 1 time per day";
$SliderFullWindow = 0;

$HideRegFormAfterLogin = 0;
$HideRegFormAfterLoginShowTextInstead = 0;
$HideRegFormAfterLoginTextToShow = '';

$RegistryUserRole = 'contest_gallery_user';

$RegUserGalleryOnly = 0;
$RegUserGalleryOnlyText = 'You have to be registered and logged in to see the gallery.';
$RegUserMaxUpload = 0;
$ContestStart = 0;
$ContestStartTime = '';

$IsModernFiveStar = 1;// all new created galleries are modern five star

$FbLikeNoShare = 0;
$VoteNotOwnImage = 0;

$PreselectSort = 'date_descend';

$UploadRequiresCookieMessage = 'Please allow cookies to upload';

$AllowSortOptions = 'date-desc,date-asc,rate-desc,rate-asc,rate-average-desc,rate-average-asc,comment-desc,comment-asc,random';
$ShowCatsUnchecked = 1;
$RegMailOptional = 0;