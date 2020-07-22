<?php
if (!defined('ABSPATH')) {
    exit;
}
if (isset($_POST['cg_Fields'])) {

    global $wpdb;

    $tablenameCreateUserForm = $wpdb->prefix . "contest_gal1ery_create_user_form";
    $tablenameCreateUserEntries = $wpdb->prefix . "contest_gal1ery_create_user_entries";
    $tablenameProOptions = $wpdb->prefix . "contest_gal1ery_pro_options";
    $tablenameWpUsers = $wpdb->prefix . "users";
    $tablenameWpUserMeta = $wpdb->prefix . "usermeta";

    $proOptions = $wpdb->get_row("SELECT * FROM $tablenameProOptions WHERE GalleryID = '" . $GalleryID . "'");

    $cg_check = $_POST['cg_Fields'];

    // Validierung und Erstellung von Activation Key
    foreach ($cg_check as $key => $value) {

        if ($value["Field_Type"] == "password") {
            $password = sanitize_text_field($value["Field_Content"]);
            $activation_key = md5(time() . $password);
        }

        if ($value["Field_Type"] == "password-confirm") {
            $passwordConfirm = sanitize_text_field($value["Field_Content"]);
        }

        if ($value["Field_Type"] == "main-mail") {
            $cg_main_mail = sanitize_text_field($value["Field_Content"]);
            $checkWpIdViaMail = $wpdb->get_var("SELECT ID FROM $tablenameWpUsers WHERE user_email = '" . $cg_main_mail . "'");
        }

        if ($value["Field_Type"] == "main-user-name") {
            $cg_main_user_name = sanitize_text_field($value["Field_Content"]);
            $checkWpIdViaName = $wpdb->get_var("SELECT ID FROM $tablenameWpUsers WHERE user_login = '" . $cg_main_user_name . "' OR 
				user_nicename = '" . $cg_main_user_name . "' OR display_name = '" . $cg_main_user_name . "'");
        }

    }

    if ($password != $passwordConfirm) {
        echo "Please don't manipulate the registry Code:221";
        return false;
    }

    if ($checkWpIdViaMail) {
        echo "Please don't manipulate the registry Code:222";
        return false;
    }
    if ($checkWpIdViaName) {
        echo "Please don't manipulate the registry Code:223";
        return false;
    }
    if ($cg_main_mail == false) {
        echo "Please don't manipulate the registry Code:224";
        return false;
    }
    if (is_email($cg_main_mail) == false) {
        echo "Please don't manipulate the registry Code:225";
        return false;
    }

    $passwordUnhashed = $password;
    $password = wp_hash_password($password);

    // Validierung und Erstellung von Activation Key --- ENDE

    // Einf�gen von Werten mit Kennzeichnung durch Activation Key zur sp�teren Wiederfindung

    foreach ($cg_check as $key => $value) {

        //	var_dump($value);echo "<br>";

        $Form_Input_ID = sanitize_text_field($value["Form_Input_ID"]);
        $Field_Type = sanitize_text_field($value["Field_Type"]);

        $Field_Order = sanitize_text_field($value["Field_Order"]);
        $Field_Content = sanitize_text_field((isset($value["Field_Content"]) ? $value["Field_Content"] : ''));
        //$Field_Name = sanitize_text_field($value["Field_Name"]);

        if ($value["Field_Type"] == "password") {
            $Field_Content = $password;
        }
        if ($value["Field_Type"] == "password-confirm") {
            $Field_Content = $password;
        }

        //var_dump($password);die;

        $Checked = 0;
        if ($Field_Type == 'user-check-agreement-field') {
            if ($Field_Content == 'checked') {
                $Checked = 1;
            } else {
                $Checked = 0;
            }
            // insert original checked field_content to show later!
            $Field_Content = $wpdb->get_row("SELECT Field_Name, Field_Content, Required FROM $tablenameCreateUserForm WHERE id = $Form_Input_ID");
            $Field_Content = $Field_Content->Field_Name . ' --- required:' . $Field_Content->Required . ' --- ' . $Field_Content->Field_Content;// get both in this case name and content for better documentation
        }

        $Version = '10.9.8.7.0';

        $wpdb->query($wpdb->prepare(
            "
                INSERT INTO $tablenameCreateUserEntries
                (id, GalleryID, wp_user_id, f_input_id, Field_Type,
                Field_Content, activation_key, Checked, Version)
                VALUES (%s,%d,%d,%d,%s,
                %s,%s,%d,%s)
            ",
            '', $GalleryID, 0, $Form_Input_ID, $Field_Type,
            $Field_Content, $activation_key, $Checked, $Version
        ));

    }

    // Einf�gen von Werten mit Kennzeichnung durch Activation Key zur sp�teren Wiederfindung --- ENDE

    // Versand E-Mail mit confirmation Link

    /*
    require_once(dirname(__FILE__)."/class-inform-user.php");
    $headers[] .= "Reply-To: ". strip_tags(@$Reply) . "\r\n";
    $headers .= "Reply-To: ". strip_tags(@$Reply) . "\r\n";
    $headers .= "CC: $cc\r\n";
    $headers .= "BCC: $bcc\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";*/

    // Check if valid mail. Wenn nicht dann admin Mail nehmen.
    if (is_email($proOptions->RegMailReply)) {
        $cgReply = $proOptions->RegMailReply;
    } else {
        $cgReply = get_option('admin_email');
    }

    $headers = array();
    $headers[] = "From: " . strip_tags($proOptions->RegMailAddressor) . " <" . strip_tags($cgReply) . ">";
    $headers[] = "Reply-To: " . strip_tags($cgReply) . "";
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-Type: text/html; charset=utf-8";

    $TextEmailConfirmation = contest_gal1ery_convert_for_html_output($proOptions->TextEmailConfirmation);
    $ForwardAfterRegText = nl2br(html_entity_decode(stripslashes($proOptions->ForwardAfterRegText)));

    $posUrl = '$regurl$';

    if (stripos(@$TextEmailConfirmation, $posUrl) !== false) {
        $currentPageUrl = get_permalink();
        $currentPageUrl = (strpos($currentPageUrl, '?')) ? $currentPageUrl . '&' : $currentPageUrl . '?';
        $TextEmailConfirmation = str_ireplace($posUrl, $currentPageUrl . "cgkey=$activation_key#cg_activation", $TextEmailConfirmation);
    } else {
        echo "Confirmation URL can't be provided. Please contact Administrator";
        die();
    }
    //  var_dump($cg_main_mail);
    //    var_dump($proOptions->RegMailSubject);
    //  var_dump($TextEmailConfirmation);
    //    var_dump($headers);

    global $cgMailAction;
    global $cgMailGalleryId;
    $cgMailAction = "User registration e-mail";
    $cgMailGalleryId = $GalleryID;
    add_action('wp_mail_failed', 'cg_on_wp_mail_error', 10, 1);

    if (!wp_mail($cg_main_mail, contest_gal1ery_convert_for_html_output($proOptions->RegMailSubject), $TextEmailConfirmation, @$headers)) {
        if (empty($proOptions->RegMailOptional)) {
            echo "Failed sending mail, please contact administrator";
            die;
        }
    }

    // $activation_key has definetely to be set to run it here!!!
    if($proOptions->RegMailOptional==1  && !empty($activation_key)){
        $user_registered = date("Y-m-d H:i:s");
        $user_nicename=$cg_main_user_name;
        $display_name=$cg_main_user_name;
        $user_login=$cg_main_user_name;
        $user_email=$cg_main_mail;

        $wpdb->query( $wpdb->prepare(
            "
									INSERT INTO $tablenameWpUsers
									( id, user_login, user_pass, user_nicename, user_email, user_url,
									user_registered, user_activation_key, user_status, display_name)
									VALUES (%s,%s,%s,%s,%s,%s,
									%s,%s,%d,%s)
								",
            '',$user_login,$password,$user_nicename,$user_email,'',
            $user_registered,$activation_key,'',$display_name
        ) );

        $newWpId = $wpdb->get_var("SELECT ID FROM $tablenameWpUsers WHERE user_activation_key='$activation_key'");

        if(!empty($newWpId)){
            // set role here
            wp_update_user( array( 'ID' => $newWpId, 'role' => $RegistryUserRole ) );
        }

        // set user id here by activation key, because created!!!
        $wpdb->update(
            "$tablenameCreateUserEntries",
            array('wp_user_id' => $newWpId),
            array('activation_key' => $activation_key),
            array('%d'),
            array('%s')
        );

        // HASHED PASSWORDS CAN BE DELETED THEN!!!!
        $wpdb->query( $wpdb->prepare(
            "
										DELETE FROM $tablenameCreateUserEntries WHERE GalleryID = %d AND (Field_Type = %s OR Field_Type = %s) AND wp_user_id = %s
									",
            $GalleryID, "password", "password-confirm",$newWpId
        ));

        $_POST['cg_gallery_registry_user_login'] = $user_login;
        $_POST['cg_gallery_registry_user_pass'] = $passwordUnhashed;

        global $wp;
        $currentURL = home_url($wp->request);

        // headers already sent, this why it does not work!
      //  wp_redirect($currentURL.'?cg_gallery_id_registry='.$GalleryID.'&cg_login_user_after_registration=true&cg_activation_key='.$activation_key);

        $url = $currentURL.'?cg_gallery_id_registry='.$GalleryID.'&cg_login_user_after_registration=true&cg_activation_key='.$activation_key;

       // var_dump($url);die;

        $string = '<script type="text/javascript">';
        $string .= 'window.location = "' . $url . '"';
        $string .= '</script>';

        echo $string;

        return;

    }else{

        echo "<div id='cg_reg_confirm'>";
        echo "<p>";
        echo "$ForwardAfterRegText";
        echo "</p>";
        echo "</div>";

        ?>

        <script>

            location.href = "#cg_reg_confirm";

            window.history.replaceState({}, document.title, location.protocol + '//' + location.host + location.pathname);

        </script>

        <?php

        // Versand E-Mail mit confirmation Link --- ENDE

    }

}
?>