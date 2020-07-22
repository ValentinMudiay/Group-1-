<?php
if((time()>=$ContestEndTime && $ContestEnd==1) OR $ContestEnd==2){
    echo "<div class='cg_photo_contest_is_over'>";
    echo "<p>$language_ThePhotoContestIsOver</p>";
    echo "</div>";
}else{

    $RegUserUploadOnly = $proOptions->RegUserUploadOnly;
    $RegUserMaxUpload = $proOptions->RegUserMaxUpload;
    $UploadRequiresCookieMessage = $proOptions->UploadRequiresCookieMessage;

    $cgFeControlsStyle = 'cg_fe_controls_style_white';
    if($FeControlsStyle=='black'){
        $cgFeControlsStyle = 'cg_fe_controls_style_black';
    }


    $heredoc = <<<HEREDOC

<div id="cgMessagesContainer" class="cg_hide $cgFeControlsStyle">
   <div id="cgMessagesDiv">
       <span id="cgMessagesClose">
   
        </span>
       <span id="cgMessagesContent">
            Photo contest ist over
        </span>
    </div>
</div>

HEREDOC;

    echo $heredoc;

    echo "<div id='cg_upload_form_container' data-cg-gid='$galeryID' class='cg_upload_form_container cg_upload_form_container_shortcode_form' style='visibility:hidden; text-align:left;'>";

    // User ID �berpr�fung ob es die selbe ist
    $check = wp_create_nonce("check");

    echo "<input type='hidden' id='cg_upload_form_e_prevent_default' value=''>";

    $upload_max_filesize = (int)(ini_get('upload_max_filesize'));
    $post_max_size = (int)(ini_get('post_max_size'));

    //$path = $_SERVER['REQUEST_URI'];

    //	echo get_page_link(NULL,false,NULL);
    echo "<div>";
    echo '<form action="" method="post" id="cg_upload_form" enctype="multipart/form-data" data-cg-gid="'.$galeryID.'" novalidate >';

    echo "<input type='hidden' id='cg_check' value='$check'>";
    echo "<input type='hidden' name='check' value='$check'>";

    echo "<input type='hidden' id='cg_upload_max_filesize' value='$upload_max_filesize'>";
    echo "<input type='hidden' id='cg_post_max_size' value='$post_max_size'>";
    echo "<input type='hidden' id='cg_fe_controls_style_user_upload_form_shortcode' value='$cgFeControlsStyle'>";

    echo "<input type='hidden' id='cgUploadFormGalleryId' name='GalleryID' value='$galeryID'>";
    echo "<input type='hidden' id='cgRegUserUploadOnly' value='$RegUserUploadOnly'>";
    echo "<input type='hidden' id='cgRegUserMaxUpload' value='$RegUserMaxUpload'>";
    echo "<input type='hidden' id='cgUploadRequiresCookieMessage' value='$UploadRequiresCookieMessage'>";

    if($RegUserUploadOnly==1 && !empty($RegUserMaxUpload) && $is_user_logged_in==true){
        $WpUserId = get_current_user_id();
        $RegUserMaxUploadCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename WHERE WpUserId = '$WpUserId' and GalleryID = '$galeryID'");
        echo "<input type='hidden' id='cgRegUserMaxUploadCount' value='$RegUserMaxUploadCount'>";
    }else if($RegUserUploadOnly==2 && !empty($RegUserMaxUpload)){

        if(isset($_COOKIE['contest-gal1ery-'.$galeryID.'-upload'])) {
            $CookieId = $_COOKIE['contest-gal1ery-'.$galeryID.'-upload'];
            $RegUserMaxUploadCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename WHERE CookieId = '$CookieId' and GalleryID = '$galeryID'");
        }else{
            $CookieId = "up".(md5(time().uniqid('cg',true)).time());
            $RegUserMaxUploadCount = 0;
        }

        echo "<input type='hidden' id='cgRegUserMaxUploadCount' value='$RegUserMaxUploadCount'>";
        echo "<input type='hidden' id='cgUploadCookieId' value='$CookieId'>";

    }else if($RegUserUploadOnly==3 && !empty($RegUserMaxUpload)){
        $userIP = cg_get_user_ip();
        $RegUserMaxUploadCount = $wpdb->get_var("SELECT COUNT(*) FROM $tablename WHERE IP = '$userIP' and GalleryID = '$galeryID'");
        echo "<input type='hidden' id='cgRegUserMaxUploadCount' value='$RegUserMaxUploadCount'>";
    }else{
        echo "<input type='hidden' id='cgRegUserMaxUploadCount' value='0'>";
    }

    if($RegUserUploadOnly==2){

    }




        echo "<input type='hidden' name='cg_upload_action' value='true'>";


    $i=0;

    // Beim Eintrag wird gesendet:
    /*
    - Feldart
    - FeldID
    - FeldReihenfolge
    - Content
    */

    //echo "<br>getUploadform:<br>";

    foreach($getUploadForm as $value){

        if ($value->Field_Type=='image-f'){

            //@$id = $value->f_input_id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); break;}
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_input_image_upload_id'>$titel *</label>";
            echo "<input type='file' id='cg_input_image_upload_id' $SingleBulkUploadConfiguration />";// Content Feld
            //echo "<input type='submit' value='Upload' />";
            echo "<p class='cg_hide cg_input_error cg_hide_image_upload'></p>";// Fehlermeldung erscheint hier
            echo "<div class='cg_form_div_image_upload_preview cg_hide'></div>";
            echo "</div>";


        }

        if ($value->Field_Type=='text-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            $necessary = '';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='min-char'){ $minsize = ($fieldContentValue) ? "$fieldContentValue" : "" ;}
                if($key=='max-char'){ $maxsize = ($fieldContentValue) ? "$fieldContentValue" : "" ;}

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]' value='nf'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<input type='text' placeholder='$content' class='cg_input_text_class cg_upload_form_field' id='cg_upload_form_field$id' value='' name='form_input[]' maxlength='$maxsize'>";// Content Feld, l�nge wird �berpr�ft
            echo "<input type='hidden' class='minsize' value='$minsize'>"; // Pr�fen minimale Anzahl zeichen
            echo "<input type='hidden' class='maxsize' value='$maxsize'>"; // Pr�fen maximale Anzahl zeichen
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }

        if ($value->Field_Type=='date-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            $necessary = '';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='format'){ $format = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]' value='dt'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<input type='hidden' class='cg_date_format' value='$format'>";// Feldreihenfolge wird mitgegeben
            echo "<input type='text'  autocomplete='off' class='cg_input_date_class cg_upload_form_field' id='cg_upload_form_field$id' value='' name='form_input[]' >";// Content Feld, l�nge wird �berpr�ft
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }

        if ($value->Field_Type=='fbt-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            $necessary = '';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='min-char'){ $minsize = ($fieldContentValue) ? "$fieldContentValue" : "" ;}
                if($key=='max-char'){ $maxsize = ($fieldContentValue) ? "$fieldContentValue" : "" ;}

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]' value='fbt'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<input type='text' placeholder='$content' class='cg_input_text_class cg_upload_form_field' id='cg_upload_form_field$id' value='' name='form_input[]' maxlength='$maxsize'>";// Content Feld, l�nge wird �berpr�ft
            echo "<input type='hidden' class='minsize' value='$minsize'>"; // Pr�fen minimale Anzahl zeichen
            echo "<input type='hidden' class='maxsize' value='$maxsize'>"; // Pr�fen maximale Anzahl zeichen
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }


        if ($value->Field_Type=='url-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            $necessary = '';
            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]' value='url'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<input type='text' placeholder='$content' class='cg_input_url_class cg_upload_form_field' id='cg_upload_form_field$id' value='' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }

        if ($value->Field_Type=='email-f'){

            if(is_user_logged_in()==false){

                $id = $value->id;
                $Field_Order = $value->Field_Order;
                $Field_Content = $value->Field_Content;
                $Field_Content = unserialize($Field_Content);

                $necessary = '';

                foreach($Field_Content as $key => $fieldContentValue){
                    if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                    if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }
                    if($key=='mandatory'){
                        $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                        $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                    }
                }

                echo "<div class='cg_form_div'>";
                echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
                echo "<input type='hidden' name='form_input[]'  value='ef'><input type='hidden' name='form_input[]' value='$id'>";//Formart und FormfeldID hidden
                echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
                echo "<input type='text' placeholder='$content' value='' class='cg_input_email_class cg_upload_form_field' id='cg_upload_form_field$id' name='form_input[]'>";// Content Feld, l�nge wird �berpr�ft
                echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
                echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
                echo "</div>";
            }

        }

        if ($value->Field_Type=='comment-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);

            $necessary = '';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='min-char'){ $minsize = ($fieldContentValue) ? "$fieldContentValue" : "";}
                if($key=='max-char'){ $maxsize = ($fieldContentValue) ? "$fieldContentValue" : "";}

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]'  value='kf'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<textarea maxlength='$maxsize' class='cg_textarea_class cg_upload_form_field' id='cg_upload_form_field$id' placeholder='$content' name='form_input[]'  rows='10' ></textarea>";// Content Feld, l�nge wird �berpr�ft
            echo "<input type='hidden' class='minsize' value='$minsize'>"; // Pr�fen minimale Anzahl zeichen
            echo "<input type='hidden' class='maxsize' value='$maxsize'>"; // Pr�fen maximale Anzahl zeichen
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }

        if ($value->Field_Type=='fbd-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);

            $necessary = '';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='min-char'){ $minsize = ($fieldContentValue) ? "$fieldContentValue" : "";}
                if($key=='max-char'){ $maxsize = ($fieldContentValue) ? "$fieldContentValue" : "";}

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]'  value='fbd'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<textarea maxlength='$maxsize' class='cg_textarea_class cg_upload_form_field' id='cg_upload_form_field$id' placeholder='$content' name='form_input[]'  rows='10' ></textarea>";// Content Feld, l�nge wird �berpr�ft
            echo "<input type='hidden' class='minsize' value='$minsize'>"; // Pr�fen minimale Anzahl zeichen
            echo "<input type='hidden' class='maxsize' value='$maxsize'>"; // Pr�fen maximale Anzahl zeichen
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }


        if ($value->Field_Type=='check-f'){//agreement

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            $Field_Version = $value->Version;


            $necessary = '*';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = contest_gal1ery_convert_for_html_output($fieldContentValue); }
                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            if(empty($Field_Version)){// then must be old form and always required
                $necessary = '*';
                $checkIfNeed = 'on';
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<div class='cg-check-agreement-container'>";
            echo "<div class='cg-check-agreement-checkbox'>";

            echo "<input type='hidden' name='form_input[]'  value='cb'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben
            echo "<input type='checkbox' class='cg_check_agreement_class cg_upload_form_field' id='cg_upload_form_field$id' name='form_input[]' value='checked' >";
            echo "</div>";
            echo "<div class='cg-check-agreement-html'>$content";
            echo "</div>";
            echo "</div>";
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "</div>";

        }

        if ($value->Field_Type=='select-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);

            $necessary = '';

            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]'  value='se'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben

            $textAr = explode("\n", $content);

            echo "<select name='form_input[]' class='cg_input_select_class cg_upload_form_field'>";

            echo "<option value='0'>$language_pleaseSelect</option>";

            foreach($textAr as $key => $fieldContentValue){

                echo "<option value='$fieldContentValue'>$fieldContentValue</option>";

            }

            echo "</select>";

            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }


        if ($value->Field_Type=='selectc-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = html_entity_decode(stripslashes($fieldContentValue)); }

                $necessary = '';

                if($key=='mandatory'){
                    $necessary = ($fieldContentValue=='on') ? '*' : '' ;
                    $checkIfNeed = ($fieldContentValue=='on') ? 'on' : '' ;
                }
            }

            echo "<div class='cg_form_div'>";
            echo "<label for='cg_upload_form_field$id'>$titel $necessary</label>";
            echo "<input type='hidden' name='form_input[]'  value='sec'><input type='hidden' name='form_input[]' value='$id'>";// Formart und FormfeldID hidden
            echo "<input type='hidden' name='form_input[]'  value='$Field_Order'>";// Feldreihenfolge wird mitgegeben

            echo "<select name='form_input[]' class='cg_input_select_class cg_upload_form_field'>";

            echo "<option value='0'>$language_pleaseSelect</option>";


            foreach($categories as $category){

                echo "<option value='".$category->id."' >".$category->Name."</option>";

            }


            echo "</select>";

            echo "<input type='hidden' class='cg_form_required' value='$checkIfNeed'>";// Pr�fen ob Pflichteingabe
            echo "<p class='cg_input_error cg_hide'></p>";// Fehlermeldung erscheint hier
            echo "</div>";

        }


        if ($value->Field_Type=='html-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
                if($key=='content'){ $content = contest_gal1ery_convert_for_html_output($fieldContentValue); }
            }

            echo "<div class='cg_form_div cg_html_field_class'>";
            echo $content;
            echo "</div>";

        }

        if ($value->Field_Type=='caRo-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $Field_Content = unserialize($Field_Content);
            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
            }

            echo "<div class='cg_form_div' id='cg_captcha_not_a_robot_field'>";
            echo "<label for='cg_$check' >$titel</label>";
            echo "<p class='cg_input_error cg_hide'></p>";
            echo "</div>";

        }

        if ($value->Field_Type=='caRoRe-f'){

            $id = $value->id;
            $Field_Order = $value->Field_Order;
            $Field_Content = $value->Field_Content;
            $ReCaKey = $value->ReCaKey;
            $ReCaLang = $value->ReCaLang;
            $Field_Content = unserialize($Field_Content);
            foreach($Field_Content as $key => $fieldContentValue){
                if($key=='titel'){ $titel = html_entity_decode(stripslashes($fieldContentValue)); }
            }


            echo "<div class='cg_form_div' >";
            echo "<div class='cg_recaptcha_simple_form cg_recaptcha_form' id='cgRecaptchaForm$galeryID'>";

            echo "</div>";
            echo "<p class='cg_input_error cg_hide cg_recaptcha_not_valid_simple_form_error' id='cgRecaptchaNotValidSimpleFormError$galeryID'></p>";
            echo "</div>";


            ?>

            <script type="text/javascript">

                if(typeof cgRecaptchaFormNormalRendered == 'undefined'){

                    cgRecaptchaFormNormalRendered = true;

                    var galeryID = "<?php echo $galeryID; ?>";

                    cgOnloadCallback = function() {

                        var ReCaKey = "<?php echo $ReCaKey; ?>";
                        var cgRecaptchaNotValidSimpleFormError = "<?php echo 'cgRecaptchaNotValidSimpleFormError'.$galeryID.''; ?>";
                        var cgRecaptchaSimpleForm = "<?php echo 'cgRecaptchaForm'.$galeryID.''; ?>";

                        cgCaRoReCallback = function() {

                            cgRecaptchaFormNormalCalled = true;

                            if(typeof cgRecaptchaFormInGalleryCalled != 'undefined'){
                                return;
                            }

                            var element = document.getElementById(cgRecaptchaNotValidSimpleFormError);
                            //element.parentNode.removeChild(element);
                            element.classList.remove("cg_recaptcha_not_valid_simple_form_error");
                            element.classList.add("cg_hide");
                        };

                        grecaptcha.render(cgRecaptchaSimpleForm, {
                            'sitekey' : ReCaKey,
                            'callback' : 'cgCaRoReCallback'
                        });


                    };

                }


            </script>
            <script src="https://www.google.com/recaptcha/api.js?onload=cgOnloadCallback&render=explicit&hl=<?php echo $ReCaLang; ?>"
                    async defer>
            </script>


            <?php


        }

    }

    //$unix = time()+2;

    //echo '<input type="hidden" name="timestamp" value="'.$unix.'">';


    //echo "<div style='display:inline;width:100%;float:left;text-align:left;'>";
    echo "<div class='cg_form_div cg_form_upload_submit_div' id='cg_form_upload_submit_div'>";
    echo '<input type="submit" name="cg_form_submit" id="cg_users_upload_submit" class="cg_form_upload_submit" value="'.$language_sendUpload.'">';
    echo '<div class="cg_form_div_image_upload_preview_loader_container cg_hide"><div class="cg_form_div_image_upload_preview_loader cg-lds-dual-ring-gallery-hide cg-lds-dual-ring-gallery-hide-mainCGallery"></div></div>';
    echo "<p class='cg_input_error cg_hide'></p>";
    echo "</div>";
    //echo "</div>";
    echo '</form>';
    echo "</div>";
    echo "</div>";// Zum schlie�en des obersten Divs #ausgabe1, ist auf hidden wegen javascript

    echo "<br/>";


//echo "<input type='hidden' id='resPic'>";

//update_option( "p_cgal1ery_count_uploads", 100 );
}
