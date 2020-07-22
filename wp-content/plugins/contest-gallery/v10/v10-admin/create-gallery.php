<?php


global $wpdb;

$tablename = $wpdb->prefix . "contest_gal1ery";
$tablenameCategories = $wpdb->prefix . "contest_gal1ery_categories";
$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";
$tablename_options_input = $wpdb->prefix . "contest_gal1ery_options_input";
$tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
$tablenameMail = $wpdb->prefix . "contest_gal1ery_mail";
$tablename_email_admin = $wpdb->prefix . "contest_gal1ery_mail_admin";
$tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";
$tablename_form_output = $wpdb->prefix . "contest_gal1ery_f_output";
$tablename_create_user_form = $wpdb->prefix . "contest_gal1ery_create_user_form";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";
// $tablename_mail_gallery = $wpdb->prefix . "contest_gal1ery_mail_gallery";
$tablename_mail_confirmation = $wpdb->prefix . "contest_gal1ery_mail_confirmation";
$tablename_entries = $wpdb->prefix . "contest_gal1ery_entries";
$table_posts = $wpdb->prefix . "posts";

$thumbSizesWp = array();
$thumbSizesWp['thumbnail_size_w'] = get_option("thumbnail_size_w");
$thumbSizesWp['medium_size_w'] = get_option("medium_size_w");
$thumbSizesWp['large_size_w'] = get_option("large_size_w");

$dbVersion = intval(get_option( "p_cgal1ery_db_version" ));
if(empty($dbVersion)){
    $dbVersion = 10;
}

/* $wpdb->insert( $tablenameOptions, array( 'id' => '', 'GalleryName' => '', 'PicsPerSite' => 20, 'WidthThumb' => 200, 'HeightThumb' => 150, 'WidthGallery' => 600,
 'HeightGallery' => 400, 'DistancePics' => 100, 'DistancePicsV' => 50, 'MaxResJPGon' => 0, 'MaxResPNGon' => 0, 'MaxResGIFon' => 0,
 'MaxResJPG' => 25000000, 'MaxResPNG' => 25000000, 'MaxResGIF' => 25000000, 'ScaleOnly' => 1, 'ScaleAndCut' => 0, 'FullSize' => 1,
 'AllowSort' => 1, 'AllowComments' => 1, 'AllowRating' => 1, 'IpBlock' => 1, 'FbLike' => 1, 'AllowGalleryScript' => 0, 'Inform' => 0,
 'ThumbLook'=> 1, 'HeightLook'=> 1, 'RowLook'=> 1,
 'ThumbLookOrder'=> 1, 'HeightLookOrder'=> 2, 'RowLookOrder'=> 3,
 'HeightLookHeight'=> 300, 'ThumbsInRow'=> 4, 'PicsInRow'=> 4, 'LastRow'=> 0 ));*/

if(!empty($_POST['cg_create'])){

    $dbVersion = get_option( "p_cgal1ery_db_version" );

    // input options
    $GalleryUploadTextBefore = "<h2>Welcome to the photo contest</h2><p>Upload your image to be a part of the photo contest</p>";
    $GalleryUploadTextBefore = htmlentities($GalleryUploadTextBefore, ENT_QUOTES, 'UTF-8');

    // input options
    $confirmation_text = '<p>Your picture upload was successful<br><br><br><b>Note for first time Contest Gallery user:</b>
<br/>This text can be configurated in "Edit options" > "Upload options" > "Upload form shortcode configuration"<br>
"Automatically activate users images after frontend upload" can be activated/deactivated in "Edit options" >>> "Upload options"
</p>';
    $confirmation_text = htmlentities($confirmation_text, ENT_QUOTES, 'UTF-8');


    // NICHT LÖSCHEN!!!! $GalleryUploadConfirmationText wird in create-options nicht neu kreiert
    $GalleryUploadConfirmationText = '<p>Your picture upload was successful<br><br><br><b>Note for first time Contest Gallery user:</b>
<br/>This text can be configurated in "Edit options" > "Upload options" > "In gallery upload form configuration"<br>
"Automatically activate users images after frontend upload" can be activated/deactivated in "Edit options" >>> "Upload options"
</p>';
    $GalleryUploadConfirmationText = htmlentities($GalleryUploadConfirmationText, ENT_QUOTES, 'UTF-8');

    // pro options

    $ForwardAfterRegText = 'Thank you for your registration<br/>Check your email account to confirm your email and complete the registration. If you don\'t see any message then plz check also the spam folder.';
    $ForwardAfterLoginText = 'You are now logged in. Have fun with photo contest.';
    $TextEmailConfirmation = 'Thank you for your registration by clicking on the link below: <br/><br/> $regurl$';
    $TextAfterEmailConfirmation = 'Thank you for your registration. You are now able to login and to take part on the photo contest.';
    $RegUserUploadOnlyText = 'You have to be registered and logged in to upload your images.';
    // Determine email of blog admin and variables for email table
    $RegMailAddressor = get_option('blogname');
    $RegMailReply = get_option('admin_email');
    $RegMailSubject = 'Please confirm your registration';

    include('json-values.php');

    include('create-options.php');

    $nextIDgallery = $wpdb->get_var("SELECT MAX(id) FROM $tablenameOptions");

    // Erschaffen eines Galerieordners

    $uploadFolder = wp_upload_dir();
    $galleryUpload = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$nextIDgallery.'';
    $galleryJsonFolder = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$nextIDgallery.'/json';
    $galleryJsonImagesFolder = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$nextIDgallery.'/json/image-data';
    $galleryJsonInfoDir = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$nextIDgallery.'/json/image-info';
    $galleryJsonCommentsDir = $uploadFolder['basedir'].'/contest-gallery/gallery-id-'.$nextIDgallery.'/json/image-comments';

    if(!is_dir($galleryUpload)){
        mkdir($galleryUpload,0755,true);
    }

    if(!is_dir($galleryJsonFolder)){
        mkdir($galleryJsonFolder,0755,true);
    }

    if(!is_dir($galleryJsonImagesFolder)){
        mkdir($galleryJsonImagesFolder,0755);
    }

    if(!is_dir($galleryJsonInfoDir)){
        mkdir($galleryJsonInfoDir,0755);
    }

    if(!is_dir($galleryJsonCommentsDir)){
        mkdir($galleryJsonCommentsDir,0755);
    }

    $galleryJsonFolderReadMeFile = $galleryJsonFolder.'/do not remove json files manually.txt';

    $fp = fopen($galleryJsonFolderReadMeFile,'w');
    fwrite($fp,'Removing json files manually will break functionality of your gallery');
    fclose($fp);

    $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-categories.json', 'w');
    fwrite($fp, json_encode(array()));
    fclose($fp);

    $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-form-upload.json', 'w');
    fwrite($fp, json_encode(array()));
    fclose($fp);

    $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-images.json', 'w');
    fwrite($fp, json_encode(array()));
    fclose($fp);

    $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-single-view-order.json', 'w');
    fwrite($fp, json_encode(array()));
    fclose($fp);

    $createdGallery = "true";

    $wpdb->query( $wpdb->prepare(
        "
				INSERT INTO $tablename_options_visual
					( id, GalleryID, CommentsAlignGallery, RatingAlignGallery,
					Field1IdGalleryView,Field1AlignGalleryView,Field2IdGalleryView,Field2AlignGalleryView,Field3IdGalleryView,Field3AlignGalleryView,
					ThumbViewBorderWidth,ThumbViewBorderRadius,ThumbViewBorderColor,ThumbViewBorderOpacity,HeightViewBorderWidth,HeightViewBorderRadius,HeightViewBorderColor,HeightViewBorderOpacity,HeightViewSpaceWidth,HeightViewSpaceHeight,
					RowViewBorderWidth,RowViewBorderRadius,RowViewBorderColor,RowViewBorderOpacity,RowViewSpaceWidth,RowViewSpaceHeight,TitlePositionGallery,RatingPositionGallery,CommentPositionGallery,
					ActivateGalleryBackgroundColor,GalleryBackgroundColor,GalleryBackgroundOpacity,OriginalSourceLinkInSlider,PreviewInSlider,
					FeControlsStyle,AllowSortOptions)
					VALUES ( %s,%d,%s,%s,
					%s,%s,%s,%s,%s,%s,
					%d,%d,%s,%d,%d,%d,%s,%d,%d,%d,
					%d,%d,%s,%d,%d,%d,%d,%d,%d,%d,%s,%d,%d,%d,
					%s,%s)
				",
        '',$nextIDgallery,$CommentsAlignGallery,$RatingAlignGallery,
        $Field1IdGalleryView,$Field1AlignGalleryView,$Field2IdGalleryView,$Field2AlignGalleryView,$Field3IdGalleryView,$Field3AlignGalleryView,
        $ThumbViewBorderWidth,$ThumbViewBorderRadius,$ThumbViewBorderColor,$ThumbViewBorderOpacity,$HeightViewBorderWidth,$HeightViewBorderRadius,'#000000',$HeightViewBorderOpacity,$HeightViewSpaceWidth,$HeightViewSpaceHeight,
        $RowViewBorderWidth,$RowViewBorderRadius,$RowViewBorderColor,$RowViewBorderOpacity,$RowViewSpaceWidth,$RowViewSpaceHeight,$TitlePositionGallery,$RatingPositionGallery,$CommentPositionGallery,$ActivateGalleryBackgroundColor,$GalleryBackgroundColor,$GalleryBackgroundOpacity,$OriginalSourceLinkInSlider,$PreviewInSlider,
        $FeControlsStyle,$AllowSortOptions
    ) );




    // $wpdb->insert( $tablename_options_input, array( 'id' => '', 'Forward' => 0, 'Forward_URL' => '', 'Confirmation_Text' => "$confirmationText" ));

    $wpdb->query( $wpdb->prepare(
        "
				INSERT INTO $tablename_options_input
				( id, GalleryID, Forward, Forward_URL, Confirmation_Text)
				VALUES ( %s,%d,%d,
				%s,%s )
			",
        '',$nextIDgallery,$Forward,
        $Forward_URL,$confirmation_text
    ) );



    // Determine email of blog admin and variables for email table
    $from = get_option('blogname');
    $reply = get_option('admin_email');
    $AdminMail = get_option('admin_email');
    $Header = 'Your picture was published';
    $HeaderActivationMail = 'Your picture was published';
    $HeaderAdminMail = 'A picture was published';
    $Content = 'Dear Sir or Madam<br/>Your picture was published<br/><br/><b>$url$</b>';
    $ContentAdminMail = 'Dear Admin<br/><br/>A new picture was published<br/><br/><br/>$info$';


    /*$wpdb->insert( $tablenameMail, array( 'id' => '', 'GalleryID' => $nextIDgallery, 'Admin' => "$from",
        'Header' => "$Header", 'Reply' => "$reply", 'cc' => "$reply",
        'bcc' => "$reply", 'Url' => '', 'Content' => "$Content"));*/


    $wpdb->query($wpdb->prepare(
        "
				INSERT INTO $tablenameMail
				( id, GalleryID, Admin,
				Header,Reply,cc,
				bcc,Url,Content)
				VALUES ( %s,%d,%s,
				%s,%s,%s,
				%s,%s,%s)
			",
        '',$nextIDgallery,$from,
        $HeaderActivationMail,$reply,'',
        '','',$Content
    ));


    $wpdb->query($wpdb->prepare(
        "
				INSERT INTO $tablename_email_admin
				( id, GalleryID, Admin, AdminMail,
				Header,Reply,cc,
				bcc,Url,Content)
				VALUES ( %s,%d,%s,%s,
				%s,%s,%s,
				%s,%s,%s)
			",
        '',$nextIDgallery,$from,$AdminMail,
        $HeaderAdminMail,'','',
        '','',$ContentAdminMail
    ));

    /*
            $wpdb->query($wpdb->prepare(
                "
                    INSERT INTO $tablename_mail_gallery
                    ( id, GalleryID, Admin,
                    Header,Reply,CC,
                    BCC,Content,
                    Blacklist,SendToImageOff,
                    SendToNotConfirmedUsers)
                    VALUES ( %s,%d,%s,
                    %s,%s,%s,
                    %s,%s,
                    %s,%d,
                    %d)
                ",
                '',$nextIDgallery,$from,
                '',$reply,$reply,
                $reply,'',
                '',0,
                1
            ));*/

    $HeaderConfirmationMail = 'Please confirm your e-mail address';
    $ContentConfirmationMail = 'Dear Sir or Madam<br/>Please confirm your e-mail address to take part on photo contest<br/><br/><b>$url$</b>';
    $ConfirmationTextConfirmationMail = 'Thank you for confirming your e-mail address.';

    $wpdb->query($wpdb->prepare(
        "
				INSERT INTO $tablename_mail_confirmation
				( id, GalleryID, Admin,
				Header,Reply,CC,
				BCC,Content,SendConfirm,
				ConfirmationText,URL)
				VALUES ( %s,%d,%s,
				%s,%s,%s,
				%s,%s,%d,
				%s,%s)
			",
        '',$nextIDgallery,$from,
        $HeaderConfirmationMail,$reply,'',
        '',$ContentConfirmationMail,0,
        $ConfirmationTextConfirmationMail,''
    ));




    // Erschaffen von Form_Input


    // Create input comment for lite version


    // Feldtyp
    // Feldreihenfolge
    // 1 = Feldtitel
    // 2 = Feldinhalt
    // 3 = Feldkrieterium1
    // 4 = Feldkrieterium2
    // 5 = Felderfordernis


    /*				// 1. Feldtitel
                    $kfFieldsArray['titel']= "Comment";
                    // 2. Feldinhalt
                    $kfFieldsArray['content'] = "Comment";
                    $commentFieldTitel = "Comment";
                    // 3. Feldkriterium 1
                    $kfFieldsArray['min-char']= "3";
                    // 4. Feldkriterium 2
                    $kfFieldsArray['max-char']= "1000";
                    // 5. Felderfordernis + Eingabe in die Datenbank
                    $kfFieldsArray['mandatory']="";

                    $kfFieldsArray = serialize($kfFieldsArray);

                    $commentF = 'comment-f';*/

    //$wpdb->insert( $tablename_form_input, array( 'id' => '', 'GalleryID' => $nextIDgallery,'Field_Type' => 'comment-f',
    //"Field_Order" => 1, "Field_Content" => $kfFieldsArray ) );

    /*$wpdb->query($wpdb->prepare(
    "
        INSERT INTO $tablename_form_input
        (id, GalleryID, Field_Type,
        Field_Order,Field_Content)
        VALUES ( %s,%d,%s,
        %s,%s)
    ",
    '',$nextIDgallery,$commentF,
    1,$kfFieldsArray
    ));*/



    // Create input comment for lite version ---- ENDE


    // Erschaffen von Form Input Image und Text-F und einstellen show in gallery und slider, Form_Output will be also created later bottom

    $fieldContent['titel']="Picture upload";

    $fieldContent = serialize($fieldContent);

    $imageF = 'image-f';

    //$wpdb->insert( $tablename_form_input, array( 'id' => '', 'GalleryID' => $nextIDgallery, 'Field_Type' => 'image-f', "Field_Order" => 2, "Field_Content" => $fieldContent ) );

    $wpdb->query($wpdb->prepare(
        "
						INSERT INTO $tablename_form_input
						(id, GalleryID, Field_Type,
						Field_Order,Field_Content,Show_Slider,Use_as_URL,Active,ReCaKey,ReCaLang)
						VALUES ( %s,%d,%s,
						%d,%s,%d,%d,%d,%s,%s)
					",
        '',$nextIDgallery,$imageF,
        4,$fieldContent,0,0,1,'',''
    ));


    $imageIdFormInput = $wpdb->get_var( "SELECT id FROM $tablename_form_input WHERE GalleryID='$nextIDgallery' AND Field_Type='image-f' ");


    // comment field first, Form_Output will be also created later bottom

    $kfFieldsArray = array();
    // 1. Feldtitel
    $kfFieldsArray['titel']="Description";
    // 2. Feldinhalt
    $kfFieldsArray['content']='';
    // 3. Feldkriterium 1
    $kfFieldsArray['min-char']=3;
    // 4. Feldkriterium 2
    $kfFieldsArray['max-char']=1000;
    // 5. Felderfordernis + Eingabe in die Datenbank
    $kfFieldsArray['mandatory']="off";

    $kfFieldsArray = serialize($kfFieldsArray);

    // Zuerst Form Input kreiren
    $wpdb->query( $wpdb->prepare(
        "
							INSERT INTO $tablename_form_input
							( id, GalleryID, Field_Type, Field_Order, Field_Content,Show_Slider,Use_as_URL,Active)
							VALUES ( %s,%d,%s,%d,%s,%d,%d,%d )
						",
        '',$nextIDgallery,'comment-f',3,$kfFieldsArray,1,0,1
    ) );

    $commentIdFormInput = $wpdb->get_var( "SELECT id FROM $tablename_form_input WHERE GalleryID='$nextIDgallery' AND Field_Type='comment-f' ");


    // add input comment field then, Form_Output will be also created later bottom

    $nfFieldsArray = array();
    // 1. Feldtitel
    $nfFieldsArray['titel']="Title";
    // 2. Feldinhalt
    $nfFieldsArray['content']='';
    // 3. Feldkriterium 1
    $nfFieldsArray['min-char']=3;
    // 4. Feldkriterium 2
    $nfFieldsArray['max-char']=100;
    // 5. Felderfordernis + Eingabe in die Datenbank
    $nfFieldsArray['mandatory']="off";

    $nfFieldsArray = serialize($nfFieldsArray);

    // Zuerst Form Input kreiren
    $wpdb->query( $wpdb->prepare(
        "
							INSERT INTO $tablename_form_input
							( id, GalleryID, Field_Type, Field_Order, Field_Content,Show_Slider,Use_as_URL,Active)
							VALUES ( %s,%d,%s,%d,%s,%d,%d,%d )
						",
        '',$nextIDgallery,'text-f',2,$nfFieldsArray,1,0,1
    ) );

    $textIdFormInput = $wpdb->get_var( "SELECT id FROM $tablename_form_input WHERE GalleryID='$nextIDgallery' AND Field_Type='text-f' ");

    // Dann next ID hier einfügen zum anezgein in der Gallerie das Feld!!!!
    $wpdb->update(
        "$tablename_options_visual",
        array('Field1IdGalleryView' => $textIdFormInput),
        array('GalleryID' => $nextIDgallery),
        array('%d'),
        array('%d')
    );

    // Dann next ID hier einfügen zum anezgein in der Gallerie das Feld!!!!
    $wpdb->update(
        "$tablename_options_visual",
        array('Field2IdGalleryView' => $textIdFormInput),
        array('GalleryID' => $nextIDgallery),
        array('%d'),
        array('%d')
    );

    include('create-gallery-create-categories.php');

    do_action('cg_json_upload_form',$nextIDgallery);
    do_action('cg_json_single_view_order',$nextIDgallery);

    // Erschaffen von Form_Input --- ENDE


    // Erschaffen von Form_Output single pic


    $wpdb->query($wpdb->prepare(
        "
						INSERT INTO $tablename_form_output
						(id, f_input_id, GalleryID,
						Field_Type,Field_Order,Field_Content)
						VALUES ( %s,%d,%d,
						%s,%d,%s)
					",
        '',$textIdFormInput,$nextIDgallery,
        'text-f',1,'Title'
    ));

    $wpdb->query($wpdb->prepare(
        "
						INSERT INTO $tablename_form_output
						(id, f_input_id, GalleryID,
						Field_Type,Field_Order,Field_Content)
						VALUES ( %s,%d,%d,
						%s,%d,%s)
					",
        '',$commentIdFormInput,$nextIDgallery,
        'text-f',2,'Comment'
    ));

    $wpdb->query($wpdb->prepare(
        "
						INSERT INTO $tablename_form_output
						(id, f_input_id, GalleryID,
						Field_Type,Field_Order,Field_Content)
						VALUES ( %s,%d,%d,
						%s,%d,%s)
					",
        '',$imageIdFormInput,$nextIDgallery,
        'image-f',3,'Picture upload'
    ));


    // Erschaffen von Form_Output single pic --- ENDE


    $backToGalleryFile = $uploadFolder["basedir"]."/contest-gallery/gallery-id-$nextIDgallery/backtogalleryurl.js";
    $FbLikeGoToGalleryLink = 'backToGalleryUrl="";';
    $fp = fopen($backToGalleryFile, 'w');
    fwrite($fp, $FbLikeGoToGalleryLink);
    fclose($fp);

        // Kreieren der notwendigen formular Felder

        $wpdb->query( $wpdb->prepare(
            "
						INSERT INTO $tablename_create_user_form
						( id, GalleryID, Field_Type, Field_Order,
						Field_Name,Field_Content,Min_Char,Max_Char,
						Required,Active)
						VALUES ( %s,%d,%s,%s,
						%s,%s,%d,%d,
						%d,%d)
					",
            '',$nextIDgallery,'main-user-name',1,
            'Username','',6,100,
            1,1
        ) );

        $wpdb->query( $wpdb->prepare(
            "
						INSERT INTO $tablename_create_user_form
						( id, GalleryID, Field_Type, Field_Order,
						Field_Name,Field_Content,Min_Char,Max_Char,
						Required,Active)
						VALUES ( %s,%d,%s,%s,
						%s,%s,%d,%d,
						%d,%d)
					",
            '',$nextIDgallery,'main-mail',2,
            'E-mail','',0,0,
            1,1
        ) );

        $wpdb->query( $wpdb->prepare(
            "
						INSERT INTO $tablename_create_user_form
						( id, GalleryID, Field_Type, Field_Order,
						Field_Name,Field_Content,Min_Char,Max_Char,
						Required,Active)
						VALUES ( %s,%d,%s,%s,
						%s,%s,%d,%d,
						%d,%d)
					",
            '',$nextIDgallery,'password',3,
            'Password','',6,100,
            1,1
        ) );

        $wpdb->query( $wpdb->prepare(
            "
						INSERT INTO $tablename_create_user_form
						( id, GalleryID, Field_Type, Field_Order,
						Field_Name,Field_Content,Min_Char,Max_Char,
						Required,Active)
						VALUES ( %s,%d,%s,%s,
						%s,%s,%d,%d,
						%d,%d)
					",
            '',$nextIDgallery,'password-confirm',4,
            'Password confirm','',6,100,
            1,1
        ) );


        // Kreieren der notwendigen formular Felder --- ENDE

        // Kreieren PRO options

        $wpdb->query( $wpdb->prepare(
            "
					INSERT INTO $tablename_pro_options
					( id, GalleryID, ForwardAfterRegUrl, ForwardAfterRegText,
					ForwardAfterLoginUrlCheck,ForwardAfterLoginUrl,
					ForwardAfterLoginTextCheck,ForwardAfterLoginText,
					TextEmailConfirmation,TextAfterEmailConfirmation,
					RegMailAddressor,RegMailReply,RegMailSubject,RegUserUploadOnly,RegUserUploadOnlyText,
					Manipulate,ShowOther,CatWidget,Search,
					GalleryUpload,GalleryUploadTextBefore,GalleryUploadTextAfter,GalleryUploadConfirmationText,ShowNickname,MinusVote,SlideTransition,
                    VotesInTime,VotesInTimeQuantity,VotesInTimeIntervalReadable,VotesInTimeIntervalSeconds,VotesInTimeIntervalAlertMessage,ShowExif,SliderFullWindow,
                    HideRegFormAfterLogin,HideRegFormAfterLoginShowTextInstead,HideRegFormAfterLoginTextToShow,
					RegUserGalleryOnly,RegUserGalleryOnlyText,RegUserMaxUpload,IsModernFiveStar,
					GalleryUploadOnlyUser,FbLikeNoShare,VoteNotOwnImage,PreselectSort,
					UploadRequiresCookieMessage,ShowCatsUnchecked,RegMailOptional
					)
					VALUES (%s,%d,%s,%s,
					%d,%s,
					%d,%s,
					%s,%s,
					%s,%s,%s,%d,%s,
					%d,%d,%d,%d,
					%d,%s,%s,%s,%d,%d,%s,
                    %d,%d,%s,%d,%s,%d,%d,
                    %d,%d,%s,
                    %d,%s,%d,%d,
                    %d,%d,%d,%s,
                    %s,%d,%d
					)
				",
            '',$nextIDgallery,$ForwardAfterRegUrl,$ForwardAfterRegText,
            $ForwardAfterLoginUrlCheck,$ForwardAfterLoginUrl,
            $ForwardAfterLoginTextCheck,$ForwardAfterLoginText,
            $TextEmailConfirmation,$TextAfterEmailConfirmation,
            $RegMailAddressor,$RegMailReply,$RegMailSubject,$RegUserUploadOnly,$RegUserUploadOnlyText,
            $Manipulate,$ShowOther,$CatWidget,$Search,
            $GalleryUpload,$GalleryUploadTextBefore,$GalleryUploadTextAfter,$GalleryUploadConfirmationText,$ShowNickname,$MinusVote,$SlideTransition,
            $VotesInTime,$VotesInTimeQuantity,$VotesInTimeIntervalReadable,$VotesInTimeIntervalSeconds,$VotesInTimeIntervalAlertMessage,$ShowExif,$SliderFullWindow,
            $HideRegFormAfterLogin,$HideRegFormAfterLoginShowTextInstead,$HideRegFormAfterLoginTextToShow,
            $RegUserGalleryOnly,$RegUserGalleryOnlyText,$RegUserMaxUpload,$IsModernFiveStar,
            $GalleryUploadOnlyUser,$FbLikeNoShare,$VoteNotOwnImage,$PreselectSort,
            $UploadRequiresCookieMessage,$ShowCatsUnchecked,$RegMailOptional
        ) );

        include('options/json-options.php');

        $jsonOptions['visual']['Field1IdGalleryView'] = $textIdFormInput;
        $jsonOptions['visual']['Field2IdGalleryView'] = $textIdFormInput;

        $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-options.json', 'w');
        fwrite($fp, json_encode($jsonOptions));
        fclose($fp);

        $tstampJson = array();
        $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-gallery-tstamp.json', 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);


        $tstampJson = array();
        $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-gallery-sort-values-tstamp.json', 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);

        $tstampJson = array();
        $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-gallery-image-info-tstamp.json', 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);


        // empty translations file
        $translations = array();
        $fp = fopen($galleryUpload.'/json/'.$nextIDgallery.'-translations.json', 'w');
        fwrite($fp, json_encode($translations));
        fclose($fp);

        // Kreieren PRO options --- ENDE

    $isNewGalleryCreated = true;

    echo "<br class='cg-created-new-gallery'>";
    echo "<div id='cgCreatedNewGallery' class='cg-created-new-gallery' style='width:937px;background-color:#fff;margin-bottom:0;border: thin solid black;text-align:center;'>";
    echo "<h2>You created a new gallery</h2>";
    echo "</div>";
    echo "<br class='cg-created-new-gallery'>";

}

if(isset($_POST['cg_copy'])){

    include('copy-gallery.php');

}

?>