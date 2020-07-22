<?php
if(!defined('ABSPATH')){exit;}

$is_admin = is_admin();
$is_frontend = (!$is_admin) ? true : false;
$domainDefault = 'default';
$domain = ($is_admin) ? 'contest-gallery' : 'contest-gallery';
$domainBackend = 'contest-gallery';

$wp_upload_dir = wp_upload_dir();
$wp_upload_dir['basedir'];

$translationsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/'.$galeryID.'-translations.json';

$translations = [];

if(file_exists($translationsFile)){
    $fp = fopen($translationsFile, 'r');
    $translationsFromFile =json_decode(fread($fp,filesize($translationsFile)),true);
    fclose($fp);

    if(count($translationsFromFile)){
        foreach($translationsFromFile as $translationKey => $translation) {
            $translations[$translationKey] = contest_gal1ery_convert_for_html_output($translation);
        }
    }else{
        $translations = $translationsFromFile;
    }

}


// Gallery
__('Sort by');$l_SortBy = "Sort by"; $language_SortBy = (!empty($translations[$l_SortBy]) && $is_frontend) ? $translations[$l_SortBy] : ((empty(trim(__($l_SortBy,$domain)))) ? __($l_SortBy,$domainDefault) : __($l_SortBy,$domain)); if(empty($translations[$l_SortBy])){$translations[$l_SortBy]='';}

__('Comments');$l_Comments = "Comments"; $language_Comments = (!empty($translations[$l_Comments]) && $is_frontend) ? $translations[$l_Comments] : ((empty(trim(__($l_Comments,$domain)))) ? __($l_Comments,$domainDefault) : __($l_Comments,$domain)); if(empty($translations[$l_Comments])){$translations[$l_Comments]='';}

__('Vote first');$l_VoteFirst = "Vote first"; $language_VoteFirst = (!empty($translations[$l_VoteFirst]) && $is_frontend) ? $translations[$l_VoteFirst] : ((empty(trim(__($l_VoteFirst,$domain)))) ? __($l_VoteFirst,$domainDefault) : __($l_VoteFirst,$domain)); if(empty($translations[$l_VoteFirst])){$translations[$l_VoteFirst]='';}

__('Slider view');$l_SliderView = "Slider view"; $language_SliderView = (!empty($translations[$l_SliderView]) && $is_frontend) ? $translations[$l_SliderView] : ((empty(trim(__($l_SliderView,$domain)))) ? __($l_SliderView,$domainDefault) : __($l_SliderView,$domain)); if(empty($translations[$l_SliderView])){$translations[$l_SliderView]='';}

__('Height view');$l_HeightView = "Height view"; $language_HeightView = (!empty($translations[$l_HeightView]) && $is_frontend) ? $translations[$l_HeightView] : ((empty(trim(__($l_HeightView,$domain)))) ? __($l_HeightView,$domainDefault) : __($l_HeightView,$domain)); if(empty($translations[$l_HeightView])){$translations[$l_HeightView]='';}

__('Thumb view');$l_ThumbView = "Thumb view"; $language_ThumbView = (!empty($translations[$l_ThumbView]) && $is_frontend) ? $translations[$l_ThumbView] : ((empty(trim(__($l_ThumbView,$domain)))) ? __($l_ThumbView,$domainDefault) : __($l_ThumbView,$domain)); if(empty($translations[$l_ThumbView])){$translations[$l_ThumbView]='';}

__('Row view');$l_RowView = "Row view"; $language_RowView = (!empty($translations[$l_RowView]) && $is_frontend) ? $translations[$l_RowView] : ((empty(trim(__($l_RowView,$domain)))) ? __($l_RowView,$domainDefault) : __($l_RowView,$domain)); if(empty($translations[$l_RowView])){$translations[$l_RowView]='';}

__('Random');$l_RandomSortSorting = "Random"; $language_RandomSortSorting = (!empty($translations[$l_RandomSortSorting]) && $is_frontend) ? $translations[$l_RandomSortSorting] : (empty((trim(__($l_RandomSortSorting,$domain)))) ? __($l_RandomSortSorting,$domainDefault) : __($l_RandomSortSorting,$domain)); if(empty($translations[$l_RandomSortSorting])){$translations[$l_RandomSortSorting]='';}

__('Date descend');$l_DateDescend = "Date descend"; $language_DateDescend = (!empty($translations[$l_DateDescend]) && $is_frontend) ? $translations[$l_DateDescend] : ((empty(trim(__($l_DateDescend,$domain)))) ? __($l_DateDescend,$domainDefault) : __($l_DateDescend,$domain)); if(empty($translations[$l_DateDescend])){$translations[$l_DateDescend]='';}

__('Date ascend');$l_DateAscend = "Date ascend"; $language_DateAscend = (!empty($translations[$l_DateAscend]) && $is_frontend) ? $translations[$l_DateAscend] : ((empty(trim(__($l_DateAscend,$domain)))) ? __($l_DateAscend,$domainDefault) : __($l_DateAscend,$domain)); if(empty($translations[$l_DateAscend])){$translations[$l_DateAscend]='';}

__('Comments descend');$l_CommentsDescend = "Comments descend"; $language_CommentsDescend = (!empty($translations[$l_CommentsDescend]) && $is_frontend) ? $translations[$l_CommentsDescend] : ((empty(trim(__($l_CommentsDescend,$domain)))) ? __($l_CommentsDescend,$domainDefault) : __($l_CommentsDescend,$domain)); if(empty($translations[$l_CommentsDescend])){$translations[$l_CommentsDescend]='';}

__('Comments ascend');$l_CommentsAscend = "Comments ascend"; $language_CommentsAscend = (!empty($translations[$l_CommentsAscend]) && $is_frontend) ? $translations[$l_CommentsAscend] : ((empty(trim(__($l_CommentsAscend,$domain)))) ? __($l_CommentsAscend,$domainDefault) : __($l_CommentsAscend,$domain)); if(empty($translations[$l_CommentsAscend])){$translations[$l_CommentsAscend]='';}

__('Rating descend');$l_RatingDescend = "Rating descend"; $language_RatingDescend = (!empty($translations[$l_RatingDescend]) && $is_frontend) ? $translations[$l_RatingDescend] : ((empty(trim(__($l_RatingDescend,$domain)))) ? __($l_RatingDescend,$domainDefault) : __($l_RatingDescend,$domain)); if(empty($translations[$l_RatingDescend])){$translations[$l_RatingDescend]='';}

__('Rating ascend');$l_RatingAscend = "Rating ascend"; $language_RatingAscend = (!empty($translations[$l_RatingAscend]) && $is_frontend) ? $translations[$l_RatingAscend] : ((empty(trim(__($l_RatingAscend,$domain)))) ? __($l_RatingAscend,$domainDefault) : __($l_RatingAscend,$domain)); if(empty($translations[$l_RatingAscend])){$translations[$l_RatingAscend]='';}

__('Rating quantity descend');$l_RatingQuantityDescend = "Rating quantity descend"; $language_RatingQuantityDescend = (!empty($translations[$l_RatingQuantityDescend]) && $is_frontend) ? $translations[$l_RatingQuantityDescend] : ((empty(trim(__($l_RatingQuantityDescend,$domain)))) ? __($l_RatingQuantityDescend,$domainDefault) : __($l_RatingQuantityDescend,$domain)); if(empty($translations[$l_RatingQuantityDescend])){$translations[$l_RatingQuantityDescend]='';}

__('Rating quantity ascend');$l_RatingQuantityAscend = "Rating quantity ascend"; $language_RatingQuantityAscend = (!empty($translations[$l_RatingQuantityAscend]) && $is_frontend) ? $translations[$l_RatingQuantityAscend] : ((empty(trim(__($l_RatingQuantityAscend,$domain)))) ? __($l_RatingQuantityAscend,$domainDefault) : __($l_RatingQuantityAscend,$domain)); if(empty($translations[$l_RatingQuantityAscend])){$translations[$l_RatingQuantityAscend]='';}

__('Rating average descend');$l_RatingAverageDescend = "Rating average descend"; $language_RatingAverageDescend = (!empty($translations[$l_RatingAverageDescend]) && $is_frontend) ? $translations[$l_RatingAverageDescend] : ((empty(trim(__($l_RatingAverageDescend,$domain)))) ? __($l_RatingAverageDescend,$domainDefault) : __($l_RatingAverageDescend,$domain)); if(empty($translations[$l_RatingAverageDescend])){$translations[$l_RatingAverageDescend]='';}

__('Rating average ascend');$l_RatingAverageAscend = "Rating average ascend"; $language_RatingAverageAscend = (!empty($translations[$l_RatingAverageAscend]) && $is_frontend) ? $translations[$l_RatingAverageAscend] : ((empty(trim(__($l_RatingAverageAscend,$domain)))) ? __($l_RatingAverageAscend,$domainDefault) : __($l_RatingAverageAscend,$domain)); if(empty($translations[$l_RatingAverageAscend])){$translations[$l_RatingAverageAscend]='';}

__('Full size');$l_FullSize = "Full size"; $language_FullSize = (!empty($translations[$l_FullSize]) && $is_frontend) ? $translations[$l_FullSize] : ((empty(trim(__($l_FullSize,$domain)))) ? __($l_FullSize,$domainDefault) : __($l_FullSize,$domain)); if(empty($translations[$l_FullSize])){$translations[$l_FullSize]='';}

__('Picture comments');$l_PictureComments = "Picture comments"; $language_PictureComments = (!empty($translations[$l_PictureComments]) && $is_frontend) ? $translations[$l_PictureComments] : ((empty(trim(__($l_PictureComments,$domain)))) ? __($l_PictureComments,$domainDefault) : __($l_PictureComments,$domain)); if(empty($translations[$l_PictureComments])){$translations[$l_PictureComments]='';}

__('Your comment');$l_YourComment = "Your comment"; $language_YourComment = (!empty($translations[$l_YourComment]) && $is_frontend) ? $translations[$l_YourComment] : ((empty(trim(__($l_YourComment,$domain)))) ? __($l_YourComment,$domainDefault) : __($l_YourComment,$domain)); if(empty($translations[$l_YourComment])){$translations[$l_YourComment]='';}

__('Name');$l_Name = "Name"; $language_Name = (!empty($translations[$l_Name]) && $is_frontend) ? $translations[$l_Name] : ((empty(trim(__($l_Name,$domain)))) ? __($l_Name,$domainDefault) : __($l_Name,$domain)); if(empty($translations[$l_Name])){$translations[$l_Name]='';}

__('Comment');$l_Comment = "Comment"; $language_Comment = (!empty($translations[$l_Comment]) && $is_frontend) ? $translations[$l_Comment] : ((empty(trim(__($l_Comment,$domain)))) ? __($l_Comment,$domainDefault) : __($l_Comment,$domain)); if(empty($translations[$l_Comment])){$translations[$l_Comment]='';}

__('I am not a robot');$l_IamNotArobot = "I am not a robot"; $language_IamNotArobot = (!empty($translations[$l_IamNotArobot]) && $is_frontend) ? $translations[$l_IamNotArobot] : ((empty(trim(__($l_IamNotArobot,$domain)))) ? __($l_IamNotArobot,$domainDefault) : __($l_IamNotArobot,$domain)); if(empty($translations[$l_IamNotArobot])){$translations[$l_IamNotArobot]='';}

__('You can not vote in own gallery');$l_YouCanNotVoteInOwnGallery = "You can not vote in own gallery"; $language_YouCanNotVoteInOwnGallery = (!empty($translations[$l_YouCanNotVoteInOwnGallery]) && $is_frontend) ? $translations[$l_YouCanNotVoteInOwnGallery] : ((empty(trim(__($l_YouCanNotVoteInOwnGallery,$domain)))) ? __($l_YouCanNotVoteInOwnGallery,$domainDefault) : __($l_YouCanNotVoteInOwnGallery,$domain)); if(empty($translations[$l_YouCanNotVoteInOwnGallery])){$translations[$l_YouCanNotVoteInOwnGallery]='';}

__('You can not comment in own gallery');$l_YouCanNotCommentInOwnGallery = "You can not comment in own gallery"; $language_YouCanNotCommentInOwnGallery = (!empty($translations[$l_YouCanNotCommentInOwnGallery]) && $is_frontend) ? $translations[$l_YouCanNotCommentInOwnGallery] : ((empty(trim(__($l_YouCanNotCommentInOwnGallery,$domain)))) ? __($l_YouCanNotCommentInOwnGallery,$domainDefault) : __($l_YouCanNotCommentInOwnGallery,$domain)); if(empty($translations[$l_YouCanNotCommentInOwnGallery])){$translations[$l_YouCanNotCommentInOwnGallery]='';}

__('Send');$l_Send = "Send"; $language_Send = (!empty($translations[$l_Send]) && $is_frontend) ? $translations[$l_Send] : ((empty(trim(__($l_Send,$domain)))) ? __($l_Send,$domainDefault) : __($l_Send,$domain));
if(empty($translations[$l_Send])){$translations[$l_Send]='';}

__('Image was deleted');$l_ImageDeleted = "Image was deleted"; $language_ImageDeleted = (!empty($translations[$l_ImageDeleted]) && $is_frontend) ? $translations[$l_ImageDeleted] : ((empty(trim(__($l_ImageDeleted,$domain)))) ? __($l_ImageDeleted,$domainDefault) : __($l_ImageDeleted,$domain));
if(empty($translations[$l_ImageDeleted])){$translations[$l_ImageDeleted]='';}


// Gallery User
__('Delete image?');$l_DeleteImageQuestion = "Delete image?"; $language_DeleteImageQuestion = (!empty($translations[$l_DeleteImageQuestion]) && $is_frontend) ? $translations[$l_DeleteImageQuestion] : ((empty(trim(__($l_DeleteImageQuestion,$domain)))) ? __($l_DeleteImageQuestion,$domainDefault) : __($l_DeleteImageQuestion,$domain)); if(empty($translations[$l_DeleteImageQuestion])){$translations[$l_DeleteImageQuestion]='';}

__('Image successfully deleted');$l_DeleteImageConfirm = "Image successfully deleted"; $language_DeleteImageConfirm = (!empty($translations[$l_DeleteImageConfirm]) && $is_frontend) ? $translations[$l_DeleteImageConfirm] : ((empty(trim(__($l_DeleteImageConfirm,$domain)))) ? __($l_DeleteImageConfirm,$domainDefault) : __($l_DeleteImageConfirm,$domain)); if(empty($translations[$l_DeleteImageConfirm])){$translations[$l_DeleteImageConfirm]='';}

// Upload/Registry
__('The name field must contain two characters or more');$l_TheNameFieldMustContainTwoCharactersOrMore= "The name field must contain two characters or more";$language_TheNameFieldMustContainTwoCharactersOrMore = (!empty($translations[$l_TheNameFieldMustContainTwoCharactersOrMore]) && $is_frontend) ? $translations[$l_TheNameFieldMustContainTwoCharactersOrMore] : ((empty(trim(__($l_TheNameFieldMustContainTwoCharactersOrMore,$domain)))) ? __($l_TheNameFieldMustContainTwoCharactersOrMore,$domainDefault) : __($l_TheNameFieldMustContainTwoCharactersOrMore,$domain)); if(empty($translations[$l_SortBy])){$translations[$l_TheNameFieldMustContainTwoCharactersOrMore]='';}

__('The comment field must contain three characters or more');$l_TheCommentFieldMustContainThreeCharactersOrMore= "The comment field must contain three characters or more";$language_TheCommentFieldMustContainThreeCharactersOrMore = (!empty($translations[$l_TheCommentFieldMustContainThreeCharactersOrMore]) && $is_frontend) ? $translations[$l_TheCommentFieldMustContainThreeCharactersOrMore] : ((empty(trim(__($l_TheCommentFieldMustContainThreeCharactersOrMore,$domain)))) ? __($l_TheCommentFieldMustContainThreeCharactersOrMore,$domainDefault) : __($l_TheCommentFieldMustContainThreeCharactersOrMore,$domain)); if(empty($translations[$l_TheCommentFieldMustContainThreeCharactersOrMore])){$translations[$l_TheCommentFieldMustContainThreeCharactersOrMore]='';}

__('Plz check the checkbox to prove that you are not a robot');$l_PlzCheckTheCheckboxToProveThatYouAreNotArobot= "Plz check the checkbox to prove that you are not a robot";$language_PlzCheckTheCheckboxToProveThatYouAreNotArobot = (!empty($translations[$l_PlzCheckTheCheckboxToProveThatYouAreNotArobot]) && $is_frontend) ? $translations[$l_SortBy] : ((empty(trim(__($l_PlzCheckTheCheckboxToProveThatYouAreNotArobot,$domain)))) ? __($l_PlzCheckTheCheckboxToProveThatYouAreNotArobot,$domainDefault) : __($l_PlzCheckTheCheckboxToProveThatYouAreNotArobot,$domain)); if(empty($translations[$l_PlzCheckTheCheckboxToProveThatYouAreNotArobot])){$translations[$l_PlzCheckTheCheckboxToProveThatYouAreNotArobot]='';}

__('Thank you for your comment');$l_ThankYouForYourComment= "Thank you for your comment";$language_ThankYouForYourComment = (!empty($translations[$l_ThankYouForYourComment]) && $is_frontend) ? $translations[$l_ThankYouForYourComment] : ((empty(trim(__($l_ThankYouForYourComment,$domain)))) ? __($l_ThankYouForYourComment,$domainDefault) : __($l_ThankYouForYourComment,$domain)); if(empty($translations[$l_ThankYouForYourComment])){$translations[$l_ThankYouForYourComment]='';}

__('You have already voted for this picture');$l_YouHaveAlreadyVotedThisPicture= "You have already voted for this picture";$language_YouHaveAlreadyVotedThisPicture = (!empty($translations[$l_YouHaveAlreadyVotedThisPicture]) && $is_frontend) ? $translations[$l_YouHaveAlreadyVotedThisPicture] : ((empty(trim(__($l_YouHaveAlreadyVotedThisPicture,$domain)))) ? __($l_YouHaveAlreadyVotedThisPicture,$domainDefault) : __($l_YouHaveAlreadyVotedThisPicture,$domain)); if(empty($translations[$l_YouHaveAlreadyVotedThisPicture])){$translations[$l_YouHaveAlreadyVotedThisPicture]='';}

__('You have already used all your votes');$l_AllVotesUsed= "You have already used all your votes";$language_AllVotesUsed = (!empty($translations[$l_AllVotesUsed]) && $is_frontend) ? $translations[$l_AllVotesUsed] : ((empty(trim(__($l_AllVotesUsed,$domain)))) ? __($l_AllVotesUsed,$domainDefault) : __($l_AllVotesUsed,$domain)); if(empty($translations[$l_AllVotesUsed])){$translations[$l_AllVotesUsed]='';}

__('It is not allowed to vote for your own picture');$l_ItIsNotAllowedToVoteForYourOwnPicture = "It is not allowed to vote for your own picture";$language_ItIsNotAllowedToVoteForYourOwnPicture = (!empty($translations[$l_ItIsNotAllowedToVoteForYourOwnPicture]) && $is_frontend) ? $translations[$l_ItIsNotAllowedToVoteForYourOwnPicture] : ((empty(trim(__($l_ItIsNotAllowedToVoteForYourOwnPicture,$domain)))) ? __($l_ItIsNotAllowedToVoteForYourOwnPicture,$domainDefault) : __($l_ItIsNotAllowedToVoteForYourOwnPicture,$domain)); if(empty($translations[$l_ItIsNotAllowedToVoteForYourOwnPicture])){$translations[$l_ItIsNotAllowedToVoteForYourOwnPicture]='';}

__('Only registered users are allowed to vote');$l_OnlyRegisteredUsersCanVote= "Only registered users are allowed to vote";$language_OnlyRegisteredUsersCanVote = (!empty($translations[$l_OnlyRegisteredUsersCanVote]) && $is_frontend) ? $translations[$l_OnlyRegisteredUsersCanVote] : ((empty(trim(__($l_OnlyRegisteredUsersCanVote,$domain)))) ? __($l_OnlyRegisteredUsersCanVote,$domainDefault) : __($l_OnlyRegisteredUsersCanVote,$domain)); if(empty($translations[$l_OnlyRegisteredUsersCanVote])){$translations[$l_OnlyRegisteredUsersCanVote]='';}

__('Back to gallery');$l_BackToGallery= "Back to gallery";$language_BackToGallery = (!empty($translations[$l_BackToGallery]) && $is_frontend) ? $translations[$l_BackToGallery] : ((empty(trim(__($l_BackToGallery,$domain)))) ? __($l_BackToGallery,$domainDefault) : __($l_BackToGallery,$domain)); if(empty($translations[$l_BackToGallery])){$translations[$l_BackToGallery]='';}

__('This file type is not allowed');$l_ThisFileTypeIsNotAllowed= "This file type is not allowed";$language_ThisFileTypeIsNotAllowed = (!empty($translations[$l_ThisFileTypeIsNotAllowed]) && $is_frontend) ? $translations[$l_ThisFileTypeIsNotAllowed] : ((empty(trim(__($l_ThisFileTypeIsNotAllowed,$domain)))) ? __($l_ThisFileTypeIsNotAllowed,$domainDefault) : __($l_ThisFileTypeIsNotAllowed,$domain)); if(empty($translations[$l_ThisFileTypeIsNotAllowed])){$translations[$l_ThisFileTypeIsNotAllowed]='';}

__('The selected file is too large, max allowed size');$l_TheFileYouChoosedIsToBigMaxAllowedSize= "The selected file is too large, max allowed size";$language_TheFileYouChoosedIsToBigMaxAllowedSize = (!empty($translations[$l_TheFileYouChoosedIsToBigMaxAllowedSize]) && $is_frontend) ? $translations[$l_TheFileYouChoosedIsToBigMaxAllowedSize] : ((empty(trim(__($l_TheFileYouChoosedIsToBigMaxAllowedSize,$domain)))) ? __($l_TheFileYouChoosedIsToBigMaxAllowedSize,$domainDefault) : __($l_TheFileYouChoosedIsToBigMaxAllowedSize,$domain)); if(empty($translations[$l_TheFileYouChoosedIsToBigMaxAllowedSize])){$translations[$l_TheFileYouChoosedIsToBigMaxAllowedSize]='';}

__('The resolution of this image is');$l_TheResolutionOfThisPicIs= "The resolution of this image is";$language_TheResolutionOfThisPicIs = (!empty($translations[$l_TheResolutionOfThisPicIs]) && $is_frontend) ? $translations[$l_TheResolutionOfThisPicIs] : ((empty(trim(__($l_TheResolutionOfThisPicIs,$domain)))) ? __($l_TheResolutionOfThisPicIs,$domainDefault) : __($l_TheResolutionOfThisPicIs,$domain)); if(empty($translations[$l_TheResolutionOfThisPicIs])){$translations[$l_TheResolutionOfThisPicIs]='';}

__('Maximum number of images for one upload is');$l_BulkUploadQuantityIs= "Maximum number of images for one upload is";$language_BulkUploadQuantityIs = (!empty($translations[$l_BulkUploadQuantityIs]) && $is_frontend) ? $translations[$l_BulkUploadQuantityIs] : ((empty(trim(__($l_BulkUploadQuantityIs,$domain)))) ? __($l_BulkUploadQuantityIs,$domainDefault) : __($l_BulkUploadQuantityIs,$domain)); if(empty($translations[$l_BulkUploadQuantityIs])){$translations[$l_BulkUploadQuantityIs]='';}
__('Minimum number of images for one upload is');$l_BulkUploadLowQuantityIs= "Minimum number of images for one upload is";$language_BulkUploadLowQuantityIs = (!empty($translations[$l_BulkUploadLowQuantityIs]) && $is_frontend) ? $translations[$l_BulkUploadLowQuantityIs] : ((empty(trim(__($l_BulkUploadLowQuantityIs,$domain)))) ? __($l_BulkUploadLowQuantityIs,$domainDefault) : __($l_BulkUploadLowQuantityIs,$domain)); if(empty($translations[$l_BulkUploadLowQuantityIs])){$translations[$l_BulkUploadLowQuantityIs]='';}

__('Maximum allowed resolution for JPG is');$l_MaximumAllowedResolutionForJPGsIs= "Maximum allowed resolution for JPG is";$language_MaximumAllowedResolutionForJPGsIs = (!empty($translations[$l_MaximumAllowedResolutionForJPGsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedResolutionForJPGsIs] : ((empty(trim(__($l_MaximumAllowedResolutionForJPGsIs,$domain)))) ? __($l_MaximumAllowedResolutionForJPGsIs,$domainDefault) : __($l_MaximumAllowedResolutionForJPGsIs,$domain)); if(empty($translations[$l_MaximumAllowedResolutionForJPGsIs])){$translations[$l_MaximumAllowedResolutionForJPGsIs]='';}

__('Maximum allowed width for JPG is');$l_MaximumAllowedWidthForJPGsIs= "Maximum allowed width for JPG is";$language_MaximumAllowedWidthForJPGsIs = (!empty($translations[$l_MaximumAllowedWidthForJPGsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedWidthForJPGsIs] : ((empty(trim(__($l_MaximumAllowedWidthForJPGsIs,$domain)))) ? __($l_MaximumAllowedWidthForJPGsIs,$domainDefault) : __($l_MaximumAllowedWidthForJPGsIs,$domain)); if(empty($translations[$l_MaximumAllowedWidthForJPGsIs])){$translations[$l_MaximumAllowedWidthForJPGsIs]='';}

__('Maximum allowed height for JPG is');$l_MaximumAllowedHeightForJPGsIs= "Maximum allowed height for JPG is";$language_MaximumAllowedHeightForJPGsIs = (!empty($translations[$l_MaximumAllowedHeightForJPGsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedHeightForJPGsIs] : ((empty(trim(__($l_MaximumAllowedHeightForJPGsIs,$domain)))) ? __($l_MaximumAllowedHeightForJPGsIs,$domainDefault) : __($l_MaximumAllowedHeightForJPGsIs,$domain)); if(empty($translations[$l_MaximumAllowedHeightForJPGsIs])){$translations[$l_MaximumAllowedHeightForJPGsIs]='';}

__('Maximum allowed resolution for PNG is');$l_MaximumAllowedResolutionForPNGsIs= "Maximum allowed resolution for PNG is";$language_MaximumAllowedResolutionForPNGsIs = (!empty($translations[$l_MaximumAllowedResolutionForPNGsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedResolutionForPNGsIs] : ((empty(trim(__($l_MaximumAllowedResolutionForPNGsIs,$domain)))) ? __($l_MaximumAllowedResolutionForPNGsIs,$domainDefault) : __($l_MaximumAllowedResolutionForPNGsIs,$domain)); if(empty($translations[$l_MaximumAllowedResolutionForPNGsIs])){$translations[$l_MaximumAllowedResolutionForPNGsIs]='';}

__('Maximum allowed width for PNG is');$l_MaximumAllowedWidthForPNGsIs= "Maximum allowed width for PNG is";$language_MaximumAllowedWidthForPNGsIs = (!empty($translations[$l_MaximumAllowedWidthForPNGsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedWidthForPNGsIs] : ((empty(trim(__($l_MaximumAllowedWidthForPNGsIs,$domain)))) ? __($l_MaximumAllowedWidthForPNGsIs,$domainDefault) : __($l_MaximumAllowedWidthForPNGsIs,$domain)); if(empty($translations[$l_MaximumAllowedWidthForPNGsIs])){$translations[$l_MaximumAllowedWidthForPNGsIs]='';}
__('Maximum allowed height for PNG is');$l_MaximumAllowedHeightForPNGsIs= "Maximum allowed height for PNG is";$language_MaximumAllowedHeightForPNGsIs = (!empty($translations[$l_MaximumAllowedHeightForPNGsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedHeightForPNGsIs] : ((empty(trim(__($l_MaximumAllowedHeightForPNGsIs,$domain)))) ? __($l_MaximumAllowedHeightForPNGsIs,$domainDefault) : __($l_MaximumAllowedHeightForPNGsIs,$domain)); if(empty($translations[$l_MaximumAllowedHeightForPNGsIs])){$translations[$l_MaximumAllowedHeightForPNGsIs]='';}

__('Maximum allowed resolution for GIF is');$l_MaximumAllowedResolutionForGIFsIs= "Maximum allowed resolution for GIF is";$language_MaximumAllowedResolutionForGIFsIs = (!empty($translations[$l_MaximumAllowedResolutionForGIFsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedResolutionForGIFsIs] : ((empty(trim(__($l_MaximumAllowedResolutionForGIFsIs,$domain)))) ? __($l_MaximumAllowedResolutionForGIFsIs,$domainDefault) : __($l_MaximumAllowedResolutionForGIFsIs,$domain)); if(empty($translations[$l_MaximumAllowedResolutionForGIFsIs])){$translations[$l_MaximumAllowedResolutionForGIFsIs]='';}

__('Maximum allowed width for GIF is');$l_MaximumAllowedWidthForGIFsIs= "Maximum allowed width for GIF is";$language_MaximumAllowedWidthForGIFsIs = (!empty($translations[$l_MaximumAllowedWidthForGIFsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedWidthForGIFsIs] : ((empty(trim(__($l_MaximumAllowedWidthForGIFsIs,$domain)))) ? __($l_MaximumAllowedWidthForGIFsIs,$domainDefault) : __($l_MaximumAllowedWidthForGIFsIs,$domain)); if(empty($translations[$l_MaximumAllowedWidthForGIFsIs])){$translations[$l_MaximumAllowedWidthForGIFsIs]='';}

__('Maximum allowed height for GIF is');$l_MaximumAllowedHeightForGIFsIs= "Maximum allowed height for GIF is";$language_MaximumAllowedHeightForGIFsIs = (!empty($translations[$l_MaximumAllowedHeightForGIFsIs]) && $is_frontend) ? $translations[$l_MaximumAllowedHeightForGIFsIs] : ((empty(trim(__($l_MaximumAllowedHeightForGIFsIs,$domain)))) ? __($l_MaximumAllowedHeightForGIFsIs,$domainDefault) : __($l_MaximumAllowedHeightForGIFsIs,$domain)); if(empty($translations[$l_MaximumAllowedHeightForGIFsIs])){$translations[$l_MaximumAllowedHeightForGIFsIs]='';}

__('You have to check this agreement');$l_YouHaveToCheckThisAgreement= "You have to check this agreement";$language_YouHaveToCheckThisAgreement = (!empty($translations[$l_YouHaveToCheckThisAgreement]) && $is_frontend) ? $translations[$l_YouHaveToCheckThisAgreement] : ((empty(trim(__($l_YouHaveToCheckThisAgreement,$domain)))) ? __($l_YouHaveToCheckThisAgreement,$domainDefault) : __($l_YouHaveToCheckThisAgreement,$domain)); if(empty($translations[$l_YouHaveToCheckThisAgreement])){$translations[$l_YouHaveToCheckThisAgreement]='';}

__('This email is not valid');$l_EmailAdressHasToBeValid= "This email is not valid";$language_EmailAdressHasToBeValid = (!empty($translations[$l_EmailAdressHasToBeValid]) && $is_frontend) ? $translations[$l_EmailAdressHasToBeValid] : ((empty(trim(__($l_EmailAdressHasToBeValid,$domain)))) ? __($l_EmailAdressHasToBeValid,$domainDefault) : __($l_EmailAdressHasToBeValid,$domain)); if(empty($translations[$l_EmailAdressHasToBeValid])){$translations[$l_EmailAdressHasToBeValid]='';}

__('Min amount of characters');$l_MinAmountOfCharacters= "Min amount of characters";$language_MinAmountOfCharacters = (!empty($translations[$l_MinAmountOfCharacters]) && $is_frontend) ? $translations[$l_MinAmountOfCharacters] : ((empty(trim(__($l_MinAmountOfCharacters,$domain)))) ? __($l_MinAmountOfCharacters,$domainDefault) : __($l_MinAmountOfCharacters,$domain)); if(empty($translations[$l_MinAmountOfCharacters])){$translations[$l_MinAmountOfCharacters]='';}

__('Max amount of characters');$l_MaxAmountOfCharacters= "Max amount of characters";$language_MaxAmountOfCharacters = (!empty($translations[$l_MaxAmountOfCharacters]) && $is_frontend) ? $translations[$l_MaxAmountOfCharacters] : ((empty(trim(__($l_MaxAmountOfCharacters,$domain)))) ? __($l_MaxAmountOfCharacters,$domainDefault) : __($l_MaxAmountOfCharacters,$domain)); if(empty($translations[$l_MaxAmountOfCharacters])){$translations[$l_MaxAmountOfCharacters]='';}

__('Select your image');$l_ChooseYourImage= "Select your image";$language_ChooseYourImage = (!empty($translations[$l_ChooseYourImage]) && $is_frontend) ? $translations[$l_ChooseYourImage] : ((empty(trim(__($l_ChooseYourImage,$domain)))) ? __($l_ChooseYourImage,$domainDefault) : __($l_ChooseYourImage,$domain)); if(empty($translations[$l_ChooseYourImage])){$translations[$l_ChooseYourImage]='';}

__('The photo contest has not started yet');$l_ThePhotoContestHasNotStartedYet= "The photo contest has not started yet";$language_ThePhotoContestHasNotStartedYet = (!empty($translations[$l_ThePhotoContestHasNotStartedYet]) && $is_frontend) ? $translations[$l_ThePhotoContestHasNotStartedYet] : ((empty(trim(__($l_ThePhotoContestHasNotStartedYet,$domain)))) ? __($l_ThePhotoContestHasNotStartedYet,$domainDefault) : __($l_ThePhotoContestHasNotStartedYet,$domain)); if(empty($translations[$l_ThePhotoContestHasNotStartedYet])){$translations[$l_ThePhotoContestHasNotStartedYet]='';}

__('The photo contest is over');$l_ThePhotoContestIsOver= "The photo contest is over";$language_ThePhotoContestIsOver = (!empty($translations[$l_ThePhotoContestIsOver]) && $is_frontend) ? $translations[$l_ThePhotoContestIsOver] : ((empty(trim(__($l_ThePhotoContestIsOver,$domain)))) ? __($l_ThePhotoContestIsOver,$domainDefault) : __($l_ThePhotoContestIsOver,$domain)); if(empty($translations[$l_ThePhotoContestIsOver])){$translations[$l_ThePhotoContestIsOver]='';}

__('Hold left mouse to see user info');$l_ShowMeUserInfoOnLeftMouseHold= "Hold left mouse to see user info";$language_ShowMeUserInfoOnLeftMouseHold = (!empty($translations[$l_ShowMeUserInfoOnLeftMouseHold]) && $is_frontend) ? $translations[$l_ShowMeUserInfoOnLeftMouseHold] : ((empty(trim(__($l_ShowMeUserInfoOnLeftMouseHold,$domain)))) ? __($l_ShowMeUserInfoOnLeftMouseHold,$domainDefault) : __($l_ShowMeUserInfoOnLeftMouseHold,$domain)); if(empty($translations[$l_ShowMeUserInfoOnLeftMouseHold])){$translations[$l_ShowMeUserInfoOnLeftMouseHold]='';}

__('Maximum amount of uploads per user is');$l_MaximumAmountOfUploadsIs = "Maximum amount of uploads per user is";$language_MaximumAmountOfUploadsIs = (!empty($translations[$l_MaximumAmountOfUploadsIs]) && $is_frontend) ? $translations[$l_MaximumAmountOfUploadsIs] : ((empty(trim(__($l_MaximumAmountOfUploadsIs,$domain)))) ? __($l_MaximumAmountOfUploadsIs,$domainDefault) : __($l_MaximumAmountOfUploadsIs,$domain)); if(empty($translations[$l_MaximumAmountOfUploadsIs])){$translations[$l_MaximumAmountOfUploadsIs]='';}


// Login

__('This email address is already registered');$l_ThisMailAlreadyExists= "This email address is already registered";$language_ThisMailAlreadyExists = (!empty($translations[$l_ThisMailAlreadyExists]) && $is_frontend) ? $translations[$l_ThisMailAlreadyExists] : ((empty(trim(__($l_ThisMailAlreadyExists,$domain)))) ? __($l_ThisMailAlreadyExists,$domainDefault) : __($l_ThisMailAlreadyExists,$domain)); if(empty($translations[$l_ThisMailAlreadyExists])){$translations[$l_ThisMailAlreadyExists]='';}

__('This username is already taken');$l_ThisUsernameAlreadyExists= "This username is already taken";$language_ThisUsernameAlreadyExists = (!empty($translations[$l_ThisUsernameAlreadyExists]) && $is_frontend) ? $translations[$l_ThisUsernameAlreadyExists] : ((empty(trim(__($l_ThisUsernameAlreadyExists,$domain)))) ? __($l_ThisUsernameAlreadyExists,$domainDefault) : __($l_ThisUsernameAlreadyExists,$domain)); if(empty($translations[$l_ThisUsernameAlreadyExists])){$translations[$l_ThisUsernameAlreadyExists]='';}

__('Username or email');$l_UsernameOrEmail= "Username or email";$language_UsernameOrEmail = (!empty($translations[$l_UsernameOrEmail]) && $is_frontend) ? $translations[$l_UsernameOrEmail] : ((empty(trim(__($l_UsernameOrEmail,$domain)))) ? __($l_UsernameOrEmail,$domainDefault) : __($l_UsernameOrEmail,$domain)); if(empty($translations[$l_UsernameOrEmail])){$translations[$l_UsernameOrEmail]='';}

__('Username or email required');$l_UsernameOrEmailRequired= "Username or email required";$language_UsernameOrEmailRequired = (!empty($translations[$l_UsernameOrEmailRequired]) && $is_frontend) ? $translations[$l_UsernameOrEmailRequired] : ((empty(trim(__($l_UsernameOrEmailRequired,$domain)))) ? __($l_UsernameOrEmailRequired,$domainDefault) : __($l_UsernameOrEmailRequired,$domain)); if(empty($translations[$l_UsernameOrEmailRequired])){$translations[$l_UsernameOrEmailRequired]='';}

__('Username or email does not exist');$l_UsernameOrEmailDoesNotExist= "Username or email does not exist";$language_UsernameOrEmailDoesNotExist = (!empty($translations[$l_UsernameOrEmailDoesNotExist]) && $is_frontend) ? $translations[$l_UsernameOrEmailDoesNotExist] : ((empty(trim(__($l_UsernameOrEmailDoesNotExist,$domain)))) ? __($l_UsernameOrEmailDoesNotExist,$domainDefault) : __($l_UsernameOrEmailDoesNotExist,$domain)); if(empty($translations[$l_UsernameOrEmailDoesNotExist])){$translations[$l_UsernameOrEmailDoesNotExist]='';}

__('This nickname is already taken');$l_ThisNicknameAlreadyExists= "This nickname is already taken";$language_ThisNicknameAlreadyExists = (!empty($translations[$l_ThisNicknameAlreadyExists]) && $is_frontend) ? $translations[$l_ThisNicknameAlreadyExists] : ((empty(trim(__($l_ThisNicknameAlreadyExists,$domain)))) ? __($l_ThisNicknameAlreadyExists,$domainDefault) : __($l_ThisNicknameAlreadyExists,$domain)); if(empty($translations[$l_ThisNicknameAlreadyExists])){$translations[$l_ThisNicknameAlreadyExists]='';}

__('Email');$l_Email= "Email";$language_Email = (!empty($translations[$l_Email]) && $is_frontend) ? $translations[$l_Email] : ((empty(trim(__($l_Email,$domain)))) ? __($l_Email,$domainDefault) : __($l_Email,$domain)); if(empty($translations[$l_Email])){$translations[$l_Email]='';}

__('Email required');$l_EmailRequired= "Email required";$language_EmailRequired = (!empty($translations[$l_EmailRequired]) && $is_frontend) ? $translations[$l_EmailRequired] : ((empty(trim(__($l_EmailRequired,$domain)))) ? __($l_EmailRequired,$domainDefault) : __($l_EmailRequired,$domain)); if(empty($translations[$l_EmailRequired])){$translations[$l_EmailRequired]='';}

__('Email does not exist');$l_EmailDoesNotExist= "Email does not exist";$language_EmailDoesNotExist = (!empty($translations[$l_EmailDoesNotExist]) && $is_frontend) ? $translations[$l_EmailDoesNotExist] : ((empty(trim(__($l_EmailDoesNotExist,$domain)))) ? __($l_EmailDoesNotExist,$domainDefault) : __($l_EmailDoesNotExist,$domain)); if(empty($translations[$l_EmailDoesNotExist])){$translations[$l_EmailDoesNotExist]='';}

__('Password');$l_Password= "Password";$language_Password = (!empty($translations[$l_Password]) && $is_frontend) ? $translations[$l_Password] : ((empty(trim(__($l_Password,$domain)))) ? __($l_Password,$domainDefault) : __($l_Password,$domain)); if(empty($translations[$l_Password])){$translations[$l_Password]='';}

__('Password required');$l_PasswordRequired= "Password required";$language_PasswordRequired = (!empty($translations[$l_PasswordRequired]) && $is_frontend) ? $translations[$l_PasswordRequired] : ((empty(trim(__($l_PasswordRequired,$domain)))) ? __($l_PasswordRequired,$domainDefault) : __($l_PasswordRequired,$domain)); if(empty($translations[$l_PasswordRequired])){$translations[$l_PasswordRequired]='';}

__('Password is wrong');$l_PasswordIsWrong= "Password is wrong";$language_PasswordIsWrong = (!empty($translations[$l_PasswordIsWrong]) && $is_frontend) ? $translations[$l_PasswordIsWrong] : ((empty(trim(__($l_PasswordIsWrong,$domain)))) ? __($l_PasswordIsWrong,$domainDefault) : __($l_PasswordIsWrong,$domain)); if(empty($translations[$l_PasswordIsWrong])){$translations[$l_PasswordIsWrong]='';}

__('You are already logged in');$l_YouAreAlreadyLoggedIn= "You are already logged in";$language_YouAreAlreadyLoggedIn = (!empty($translations[$l_YouAreAlreadyLoggedIn]) && $is_frontend) ? $translations[$l_YouAreAlreadyLoggedIn] : ((empty(trim(__($l_YouAreAlreadyLoggedIn,$domain)))) ? __($l_YouAreAlreadyLoggedIn,$domainDefault) : __($l_YouAreAlreadyLoggedIn,$domain)); if(empty($translations[$l_YouAreAlreadyLoggedIn])){$translations[$l_YouAreAlreadyLoggedIn]='';}

__('Please fill out');$l_PleaseFillOut= "Please fill out";$language_PleaseFillOut = (!empty($translations[$l_PleaseFillOut]) && $is_frontend) ? $translations[$l_PleaseFillOut] : ((empty(trim(__($l_PleaseFillOut,$domain)))) ? __($l_PleaseFillOut,$domainDefault) : __($l_PleaseFillOut,$domain)); if(empty($translations[$l_PleaseFillOut])){$translations[$l_PleaseFillOut]='';}

__('Passwords do not match');$l_PasswordsDoNotMatch= "Passwords do not match";$language_PasswordsDoNotMatch = (!empty($translations[$l_PasswordsDoNotMatch]) && $is_frontend) ? $translations[$l_PasswordsDoNotMatch] : ((empty(trim(__($l_PasswordsDoNotMatch,$domain)))) ? __($l_PasswordsDoNotMatch,$domainDefault) : __($l_PasswordsDoNotMatch,$domain)); if(empty($translations[$l_PasswordsDoNotMatch])){$translations[$l_PasswordsDoNotMatch]='';}

__('Upload');$l_sendUpload= "Upload";$language_sendUpload = (!empty($translations[$l_sendUpload]) && $is_frontend) ? $translations[$l_sendUpload] : ((empty(trim(__($l_sendUpload,$domain)))) ? __($l_sendUpload,$domainDefault) : __($l_sendUpload,$domain)); if(empty($translations[$l_sendUpload])){$translations[$l_sendUpload]='';}

__('Register');$l_sendRegistry= "Register";$language_sendRegistry = (!empty($translations[$l_sendRegistry]) && $is_frontend) ? $translations[$l_sendRegistry] : ((empty(trim(__($l_sendRegistry,$domain)))) ? __($l_sendRegistry,$domainDefault) : __($l_sendRegistry,$domain)); if(empty($translations[$l_sendRegistry])){$translations[$l_sendRegistry]='';}

__('Login');$l_sendLogin= "Login";$language_sendLogin = (!empty($translations[$l_sendLogin]) && $is_frontend) ? $translations[$l_sendLogin] : ((empty(trim(__($l_sendLogin,$domain)))) ? __($l_sendLogin,$domainDefault) : __($l_sendLogin,$domain)); if(empty($translations[$l_sendLogin])){$translations[$l_sendLogin]='';}
__('Please select');$l_pleaseSelect= "Please select";$language_pleaseSelect = (!empty($translations[$l_pleaseSelect]) && $is_frontend) ? $translations[$l_pleaseSelect] : ((empty(trim(__($l_pleaseSelect,$domain)))) ? __($l_pleaseSelect,$domainDefault) : __($l_pleaseSelect,$domain)); if(empty($translations[$l_pleaseSelect])){$translations[$l_pleaseSelect]='';}

__('You have not selected');$l_youHaveNotSelected= "You have not selected";$language_youHaveNotSelected = (!empty($translations[$l_youHaveNotSelected]) && $is_frontend) ? $translations[$l_youHaveNotSelected] : ((empty(trim(__($l_youHaveNotSelected,$domain)))) ? __($l_youHaveNotSelected,$domainDefault) : __($l_youHaveNotSelected,$domain)); if(empty($translations[$l_youHaveNotSelected])){$translations[$l_youHaveNotSelected]='';}

__('Please confirm');$l_pleaseConfirm= "Please confirm";$language_pleaseConfirm = (!empty($translations[$l_pleaseConfirm]) && $is_frontend) ? $translations[$l_pleaseConfirm] : ((empty(trim(__($l_pleaseConfirm,$domain)))) ? __($l_pleaseConfirm,$domainDefault) : __($l_pleaseConfirm,$domain)); if(empty($translations[$l_pleaseConfirm])){$translations[$l_pleaseConfirm]='';}

__('Image is not activated');$l_imageIsNotActivated= "Image is not activated";$language_imageIsNotActivated = (!empty($translations[$l_imageIsNotActivated]) && $is_frontend) ? $translations[$l_imageIsNotActivated] : ((empty(trim(__($l_imageIsNotActivated,$domain)))) ? __($l_imageIsNotActivated,$domainDefault) : __($l_imageIsNotActivated,$domain)); if(empty($translations[$l_imageIsNotActivated])){$translations[$l_imageIsNotActivated]='';}

__('Your email could not be confirmed.');$l_ConfirmationWentWrong= "Your email could not be confirmed.";$language_ConfirmationWentWrong = (!empty($translations[$l_ConfirmationWentWrong]) && $is_frontend) ? $translations[$l_ConfirmationWentWrong] : ((empty(trim(__($l_ConfirmationWentWrong,$domain)))) ? __($l_ConfirmationWentWrong,$domainDefault) : __($l_ConfirmationWentWrong,$domain)); if(empty($translations[$l_ConfirmationWentWrong])){$translations[$l_ConfirmationWentWrong]='';}

__('Please enter a valid URL');$l_URLnotValid= "Please enter a valid URL";$language_URLnotValid = (!empty($translations[$l_URLnotValid]) && $is_frontend) ? $translations[$l_URLnotValid] : ((empty(trim(__($l_URLnotValid,$domain)))) ? __($l_URLnotValid,$domainDefault) : __($l_URLnotValid,$domain)); if(empty($translations[$l_URLnotValid])){$translations[$l_URLnotValid]='';}

__('Other');$l_Other= "Other";$language_Other = (!empty($translations[$l_Other]) && $is_frontend) ? $translations[$l_Other] : ((empty(trim(__($l_Other,$domain)))) ? __($l_Other,$domainDefault) : __($l_Other,$domain)); if(empty($translations[$l_Other])){$translations[$l_Other]='';}

// General
__('Yes');$l_Yes = "Yes"; $language_Yes = (!empty($translations[$l_Yes]) && $is_frontend) ? $translations[$l_Yes] : ((empty(trim(__($l_Yes,$domain)))) ? __($l_Yes,$domainDefault) : __($l_Yes,$domain)); if(empty($translations[$l_Yes])){$translations[$l_Yes]='';}
__('No');$l_No = "No"; $language_No = (!empty($translations[$l_No]) && $is_frontend) ? $translations[$l_No] : ((empty(trim(__($l_No,$domain)))) ? __($l_No,$domainDefault) : __($l_No,$domain)); if(empty($translations[$l_No])){$translations[$l_No]='';}


//$language_sendSubmitError= "Form data incomplete, see above.";


?>