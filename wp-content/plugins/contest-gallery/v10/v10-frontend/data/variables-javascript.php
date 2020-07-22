<?php
?>
    <script>

           cgJsFrontendArea = true;

            if(typeof cgJsClass == 'undefined' ){

                cgJsClass = {};

                cgJsClass.gallery = {};
                cgJsClass.gallery.vars = {};
                cgJsClass.gallery.vars.isLoggedIn = <?php echo json_encode(is_user_logged_in()); ?>;
                cgJsClass.gallery.vars.timezoneOffset = <?php echo date('Z'); ?>;
                cgJsClass.gallery.vars.wp_create_nonce = <?php echo json_encode($check); ?>;
                cgJsClass.gallery.vars.pluginsUrl = <?php echo json_encode(plugins_url()); ?>;
                cgJsClass.gallery.vars.localeLang = <?php echo json_encode(get_locale()); ?>;
                cgJsClass.gallery.vars.isSsl = <?php echo json_encode(is_ssl()); ?>;
                cgJsClass.gallery.vars.php_upload_max_filesize = <?php echo json_encode((int)(ini_get('upload_max_filesize'))); ?>;
                cgJsClass.gallery.vars.php_post_max_size = <?php echo json_encode((int)(ini_get('post_max_size'))); ?>;
                cgJsClass.gallery.vars.adminUrl = <?php echo json_encode( admin_url('admin-ajax.php')); ?>;
                cgJsClass.gallery.vars.wpNickname = <?php echo json_encode($wpNickname); ?>;
                cgJsClass.gallery.vars.wpUserId = <?php echo json_encode($WpUserId); ?>;
                cgJsClass.gallery.vars.pluginVersion = <?php echo json_encode('10.9.8.8.1'); ?>;
                cgJsClass.gallery.vars.fullWindowConfigurationAreaIsOpened = false;

            }

            if(typeof cgJsData == 'undefined' ){

                cgJsData =  {};

            }

            // general stuff
           // var index = Object.keys(cgJsData).length;
            var index = <?php echo json_encode($galeryIDuser); ?>;

            // data gallery stuff
            cgJsData[index] = {};
            cgJsData[index].vars = {};
            cgJsData[index].vars.gidReal = <?php echo json_encode($galeryID); ?>;
            cgJsData[index].vars.versionGallery = <?php echo json_encode($options['general']['Version']); ?>;
            cgJsData[index].vars.versionDatabase = <?php echo json_encode($p_cgal1ery_db_version); ?>;
            cgJsData[index].vars.uploadFolderUrl = <?php echo json_encode($upload_folder_url); ?>;
            cgJsData[index].vars.cg_check_login = <?php echo json_encode($options['general']['CheckLogin']); ?>;
            cgJsData[index].vars.cg_user_login_check = <?php echo json_encode($UserLoginCheck); ?>;
            cgJsData[index].vars.cg_ContestEndTime = <?php echo json_encode($options['general']['ContestEndTime']); ?>;
            cgJsData[index].vars.cg_ContestEnd = <?php echo json_encode($options['general']['ContestEnd']); ?>;
            cgJsData[index].vars.formHasUrlField = 0;
            cgJsData[index].vars.cg_hide_hide_width = 0;
            cgJsData[index].vars.openedGalleryImageOrder = null;
            cgJsData[index].vars.categories = {};
            cgJsData[index].vars.categoriesUploadFormId = null;
            cgJsData[index].vars.categoriesUploadFormTitle = null;
            cgJsData[index].vars.showCategories = false;
            cgJsData[index].vars.info = {};
            cgJsData[index].vars.thumbViewWidth = null;
            cgJsData[index].vars.openedRealId = 0;
            cgJsData[index].vars.galleryLoaded = false;
            cgJsData[index].vars.getJson = [];
            cgJsData[index].vars.jsonGetInfo = [];
            cgJsData[index].vars.jsonGetComment = [];
            cgJsData[index].vars.jsonGetImageCheck = [];
            cgJsData[index].vars.searchInput = null;
            cgJsData[index].vars.categoriesLength = 0;
            cgJsData[index].vars.galleryAlreadyFullWindow = false;
            cgJsData[index].vars.lastRealIdInFullImageDataObject = 0;
            cgJsData[index].vars.thumbViewWidthFromLastImageInRow = false;
            cgJsData[index].vars.allVotesUsed = 0;
            cgJsData[index].vars.sorting = 0;
            cgJsData[index].vars.widthmain = 0;
            cgJsData[index].vars.translateX = <?php echo json_encode($options['pro']['SlideTransition']); ?>;
            cgJsData[index].vars.maximumVisibleImagesInSlider = 0;
            cgJsData[index].vars.currentStep = 1;
            cgJsData[index].vars.sortedRandomFullData = null;
            cgJsData[index].vars.sortedDateDescFullData = null;
            cgJsData[index].vars.sortedDateAscFullData = null;
            cgJsData[index].vars.sortedRatingDescFullData = null;
            cgJsData[index].vars.sortedRatingAscFullData = null;
            cgJsData[index].vars.sortedCommentsDescFullData = null;
            cgJsData[index].vars.sortedCommentsAscFullData = null;
            cgJsData[index].vars.sortedSearchFullData = null;
            cgJsData[index].vars.imageDataLength = <?php echo json_encode($jsonImagesCount); ?>;
            cgJsData[index].vars.isUserGallery = <?php echo json_encode($isUserGallery); ?>;
            cgJsData[index].vars.isOnlyGalleryNoVoting = <?php echo json_encode($isOnlyGalleryNoVoting); ?>;
            cgJsData[index].vars.galleryHash = <?php echo json_encode(md5(wp_salt( 'auth').'---cngl1---'.$galeryIDuser)); ?>;
            cgJsData[index].vars.UploadedFilesAmountTotal = 0;

    </script>


<?php

if($options['general']['CheckCookie'] == 1 && !isset($_COOKIE['contest-gal1ery-'.$galeryID.'-voting'])){

?>

    <script>

        var index = <?php echo json_encode($galeryIDuser); ?>;
        cgJsData[index].vars.cookieVotingId = <?php echo json_encode(md5(uniqid('cg',true)).time()); ?>;

    </script>

    <?php

}


?>