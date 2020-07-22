<?php

?>
    <script>

     //   console.log('here');
      //  console.log(typeof cgJsClass.gallery.language);

        var addLanguage = true;

        if(typeof cgJsClass.gallery.language != 'undefined'){
            if(typeof cgJsClass.gallery.language == 'object'){
                if(Object.keys(cgJsClass.gallery.language).length > 0){
                    addLanguage = false;
                }
            }
        }

        if(addLanguage){
            cgJsClass.gallery.language = cgJsClass.gallery.language ||  {};
            cgJsClass.gallery.language.SortBy = <?php echo json_encode($language_SortBy); ?>;
            cgJsClass.gallery.language.Comments = <?php echo json_encode($language_Comments); ?>;
            cgJsClass.gallery.language.VoteFirst = <?php echo json_encode($language_VoteFirst); ?>;
            cgJsClass.gallery.language.ThumbView = <?php echo json_encode($language_SortBy); ?>;
            cgJsClass.gallery.language.HeightView = <?php echo json_encode($language_SortBy); ?>;
            cgJsClass.gallery.language.RowView = <?php echo json_encode($language_RowView); ?>;
            cgJsClass.gallery.language.RandomSortSorting = <?php echo json_encode($language_RandomSortSorting); ?>;
            cgJsClass.gallery.language.DateDescend = <?php echo json_encode($language_DateDescend); ?>;
            cgJsClass.gallery.language.DateAscend = <?php echo json_encode($language_DateAscend); ?>;
            cgJsClass.gallery.language.CommentsDescend = <?php echo json_encode($language_CommentsDescend); ?>;
            cgJsClass.gallery.language.CommentsAscend = <?php echo json_encode($language_CommentsAscend); ?>;
            cgJsClass.gallery.language.RatingDescend = <?php echo json_encode($language_RatingDescend); ?>;
            cgJsClass.gallery.language.RatingAscend = <?php echo json_encode($language_RatingAscend); ?>;
            cgJsClass.gallery.language.FullSize = <?php echo json_encode($language_FullSize); ?>;
            cgJsClass.gallery.language.PictureComments = <?php echo json_encode($language_PictureComments); ?>;
            cgJsClass.gallery.language.YourComment = <?php echo json_encode($language_YourComment); ?>;
            cgJsClass.gallery.language.Name = <?php echo json_encode($language_Name); ?>;
            cgJsClass.gallery.language.Comment = <?php echo json_encode($language_Comment); ?>;
            cgJsClass.gallery.language.IamNotArobot = <?php echo json_encode($language_IamNotArobot); ?>;
            cgJsClass.gallery.language.Send = <?php echo json_encode($language_Send); ?>;
            cgJsClass.gallery.language.TheNameFieldMustContainTwoCharactersOrMore = <?php echo json_encode($language_TheNameFieldMustContainTwoCharactersOrMore); ?>;
            cgJsClass.gallery.language.TheCommentFieldMustContainThreeCharactersOrMore = <?php echo json_encode($language_TheCommentFieldMustContainThreeCharactersOrMore); ?>;
            cgJsClass.gallery.language.PlzCheckTheCheckboxToProveThatYouAreNotArobot = <?php echo json_encode($language_PlzCheckTheCheckboxToProveThatYouAreNotArobot); ?>;
            cgJsClass.gallery.language.ThankYouForYourComment = <?php echo json_encode($language_ThankYouForYourComment); ?>;
            cgJsClass.gallery.language.YouHaveAlreadyVotedThisPicture = <?php echo json_encode($language_YouHaveAlreadyVotedThisPicture); ?>;
            cgJsClass.gallery.language.AllVotesUsed = <?php echo json_encode($language_AllVotesUsed); ?>;
            cgJsClass.gallery.language.ItIsNotAllowedToVoteForYourOwnPicture = <?php echo json_encode($language_ItIsNotAllowedToVoteForYourOwnPicture); ?>;
            cgJsClass.gallery.language.OnlyRegisteredUsersCanVote = <?php echo json_encode($language_OnlyRegisteredUsersCanVote); ?>;
            cgJsClass.gallery.language.BackToGallery = <?php echo json_encode($language_BackToGallery); ?>;
            cgJsClass.gallery.language.ThisFileTypeIsNotAllowed = <?php echo json_encode($language_ThisFileTypeIsNotAllowed); ?>;
            cgJsClass.gallery.language.TheFileYouChoosedIsToBigMaxAllowedSize = <?php echo json_encode($language_TheFileYouChoosedIsToBigMaxAllowedSize); ?>;
            cgJsClass.gallery.language.TheResolutionOfThisPicIs = <?php echo json_encode($language_TheResolutionOfThisPicIs); ?>;

            cgJsClass.gallery.language.BulkUploadQuantityIs = <?php echo json_encode($language_BulkUploadQuantityIs); ?>;
            cgJsClass.gallery.language.BulkUploadLowQuantityIs = <?php echo json_encode($language_BulkUploadLowQuantityIs); ?>;

            cgJsClass.gallery.language.MaximumAllowedResolutionForJPGsIs = <?php echo json_encode($language_MaximumAllowedResolutionForJPGsIs); ?>;
            cgJsClass.gallery.language.MaximumAllowedWidthForJPGsIs = <?php echo json_encode($language_MaximumAllowedWidthForJPGsIs); ?>;
            cgJsClass.gallery.language.MaximumAllowedHeightForJPGsIs = <?php echo json_encode($language_MaximumAllowedHeightForJPGsIs); ?>;

            cgJsClass.gallery.language.MaximumAllowedResolutionForPNGsIs = <?php echo json_encode($language_MaximumAllowedResolutionForPNGsIs); ?>;
            cgJsClass.gallery.language.MaximumAllowedWidthForPNGsIs = <?php echo json_encode($language_MaximumAllowedWidthForPNGsIs); ?>;
            cgJsClass.gallery.language.MaximumAllowedHeightForPNGsIs = <?php echo json_encode($language_MaximumAllowedHeightForPNGsIs); ?>;

            cgJsClass.gallery.language.MaximumAllowedResolutionForGIFsIs = <?php echo json_encode($language_MaximumAllowedResolutionForGIFsIs); ?>;
            cgJsClass.gallery.language.MaximumAllowedWidthForGIFsIs = <?php echo json_encode($language_MaximumAllowedWidthForGIFsIs); ?>;
            cgJsClass.gallery.language.MaximumAllowedHeightForGIFsIs = <?php echo json_encode($language_MaximumAllowedHeightForGIFsIs); ?>;

            cgJsClass.gallery.language.YouHaveToCheckThisAgreement = <?php echo json_encode($language_YouHaveToCheckThisAgreement); ?>;
            cgJsClass.gallery.language.EmailAdressHasToBeValid = <?php echo json_encode($language_EmailAdressHasToBeValid); ?>;
            cgJsClass.gallery.language.MinAmountOfCharacters = <?php echo json_encode($language_MinAmountOfCharacters); ?>;
            cgJsClass.gallery.language.MaxAmountOfCharacters = <?php echo json_encode($language_MaxAmountOfCharacters); ?>;
            cgJsClass.gallery.language.ChooseYourImage = <?php echo json_encode($language_ChooseYourImage); ?>;

            cgJsClass.gallery.language.ThePhotoContestHasNotStartedYet = <?php echo json_encode($language_ThePhotoContestHasNotStartedYet); ?>;

            cgJsClass.gallery.language.ThePhotoContestIsOver = <?php echo json_encode($language_ThePhotoContestIsOver); ?>;

            cgJsClass.gallery.language.ShowMeUserInfoOnLeftMouseHold = <?php echo json_encode($language_ShowMeUserInfoOnLeftMouseHold); ?>;

            cgJsClass.gallery.language.ThisMailAlreadyExists = <?php echo json_encode($language_ThisMailAlreadyExists); ?>;
            cgJsClass.gallery.language.ThisUsernameAlreadyExists = <?php echo json_encode($language_ThisUsernameAlreadyExists); ?>;

            cgJsClass.gallery.language.UsernameOrEmail = <?php echo json_encode($language_UsernameOrEmail); ?>;
            cgJsClass.gallery.language.UsernameOrEmailRequired = <?php echo json_encode($language_UsernameOrEmailRequired); ?>;

            cgJsClass.gallery.language.UsernameOrEmailDoesNotExist = <?php echo json_encode($language_UsernameOrEmailDoesNotExist); ?>;

            cgJsClass.gallery.language.ThisNicknameAlreadyExists = <?php echo json_encode($language_ThisNicknameAlreadyExists); ?>;

            cgJsClass.gallery.language.Email = <?php echo json_encode($language_Email); ?>;
            cgJsClass.gallery.language.EmailRequired = <?php echo json_encode($language_EmailRequired); ?>;
            cgJsClass.gallery.language.EmailDoesNotExist = <?php echo json_encode($language_EmailDoesNotExist); ?>;

            cgJsClass.gallery.language.Password = <?php echo json_encode($language_Password); ?>;
            cgJsClass.gallery.language.PasswordRequired = <?php echo json_encode($language_PasswordRequired); ?>;

            cgJsClass.gallery.language.PasswordIsWrong = <?php echo json_encode($language_PasswordIsWrong); ?>;

            cgJsClass.gallery.language.YouAreAlreadyLoggedIn = <?php echo json_encode($language_YouAreAlreadyLoggedIn); ?>;

            cgJsClass.gallery.language.PleaseFillOut = <?php echo json_encode($language_PleaseFillOut); ?>;

            cgJsClass.gallery.language.PasswordsDoNotMatch = <?php echo json_encode($language_PasswordsDoNotMatch); ?>;

            cgJsClass.gallery.language.sendUpload = <?php echo json_encode($language_sendUpload); ?>;
            cgJsClass.gallery.language.sendRegistry = <?php echo json_encode($language_sendRegistry); ?>;
            cgJsClass.gallery.language.sendLogin = <?php echo json_encode($language_sendLogin); ?>;

            cgJsClass.gallery.language.pleaseSelect = <?php echo json_encode($language_pleaseSelect); ?>;
            cgJsClass.gallery.language.youHaveNotSelected = <?php echo json_encode($language_youHaveNotSelected); ?>;

            cgJsClass.gallery.language.pleaseConfirm = <?php echo json_encode($language_pleaseConfirm); ?>;
            cgJsClass.gallery.language.imageIsNotActivated = <?php echo json_encode($language_imageIsNotActivated); ?>;

            cgJsClass.gallery.language.ConfirmationWentWrong = <?php echo json_encode($language_ConfirmationWentWrong); ?>;

            cgJsClass.gallery.language.URLnotValid = <?php echo json_encode($language_URLnotValid); ?>;

            cgJsClass.gallery.language.Other = <?php echo json_encode($language_Other); ?>;

            cgJsClass.gallery.language.YouCanNotVoteInOwnGallery = <?php echo json_encode($language_YouCanNotVoteInOwnGallery); ?>;
            cgJsClass.gallery.language.YouCanNotCommentInOwnGallery = <?php echo json_encode($language_YouCanNotCommentInOwnGallery); ?>;

            cgJsClass.gallery.language.MaximumAmountOfUploadsIs = <?php echo json_encode($language_MaximumAmountOfUploadsIs); ?>;

            cgJsClass.gallery.language.DeleteImageQuestion = <?php echo json_encode($language_DeleteImageQuestion); ?>;

            cgJsClass.gallery.language.DeleteImageConfirm = <?php echo json_encode($language_DeleteImageConfirm); ?>;
            cgJsClass.gallery.language.ImageDeleted = <?php echo json_encode($language_ImageDeleted); ?>;

            cgJsClass.gallery.language.Yes = <?php echo json_encode($language_Yes); ?>;
            cgJsClass.gallery.language.No = <?php echo json_encode($language_No); ?>;

        }


    </script>


<?php


?>