<?php
if(!defined('ABSPATH')){exit;}

		// 1 = Mail or Username
		// 2 = Password
		// 3 = Check
		// 4 = GalleryID

		if(session_id() == '') {
			session_start();
		}

		/*if(@$_SESSION["cg_login_count"]==false){
			echo "Plz don't manipulate the registry Code:117";return false;
		}*/

		if(@$_SESSION["cg_login_count"]==false){
			//Achtung! Mit 1 anfangen ansonsten wird als false gezählt wenn es mit 0 anfängt.
			$_SESSION["cg_login_count"]=1;
		}
		else{
			$_SESSION["cg_login_count"]++;
		}

		if(@$_SESSION["cg_login_count"]>15){
			echo "To many invalid atempts. Please try few minutes later again";return false;
		}

        $GalleryID = sanitize_text_field($_REQUEST['action4']);

        $cg_check = $_REQUEST['action3'];
        $galleryHashToCompare = md5(wp_salt( 'auth').'---cglogin---'.$GalleryID);

// Hier geht die Validierung los
		if($cg_check==$galleryHashToCompare){

		global $wpdb;
		$tablenameWpUsers = $wpdb->prefix . "users";


		$cg_login_name_mail = sanitize_text_field($_REQUEST['action1']);

		$cg_user_email = false;
		$cg_user_login = false;
            $cgPwHash = false;

		//Check name or email
			if(is_email($cg_login_name_mail)){
                $cgWpData = $wpdb->get_row("SELECT user_login, user_pass FROM $tablenameWpUsers WHERE user_email = '".$cg_login_name_mail."'");
			}

		if(empty($cgWpData)){


?>
<script>
var cg_language_EmailDoesNotExist = document.getElementById("cg_language_EmailDoesNotExist").value;

var cg_check_mail_name_value = document.getElementById('cg_check_mail_name_value');
cg_check_mail_name_value.value = 1;

var cg_append_login_name_mail_fail = document.getElementById('cg_append_login_name_mail_fail');
cg_append_login_name_mail_fail.innerHTML = cg_append_login_name_mail_fail.innerHTML + cg_language_EmailDoesNotExist;
cg_append_login_name_mail_fail.classList.remove('cg_hide');

// Password Feld leer machen
var cg_login_password = document.getElementById('cg_login_password');
cg_login_password.value = '';

location.href = "#cg_user_registry_anchor";

</script>
<?php
		return false;

		}

		else{

			$cg_login_password = sanitize_text_field($_REQUEST['action2']);

			require_once(ABSPATH ."wp-load.php");
			$cgCheckPw = (wp_check_password($cg_login_password, $cgWpData->user_pass));

			if($cgCheckPw==false){

?>
<script>
var cg_language_PasswordIsWrong = document.getElementById("cg_language_PasswordIsWrong").value;

var cg_check_mail_name_value = document.getElementById('cg_check_mail_name_value');
cg_check_mail_name_value.value = 1;

var cg_append_login_password_fail = document.getElementById('cg_append_login_password_fail');
cg_append_login_password_fail.innerHTML = cg_append_login_password_fail.innerHTML + cg_language_PasswordIsWrong;
cg_append_login_password_fail.classList.remove('cg_hide');

// Password Feld leer machen
var cg_login_password = document.getElementById('cg_login_password');
cg_login_password.value = '';

location.href = "#cg_user_registry_anchor";

</script>
<?php
			}
			else{
					// Anzahl Login Versuche beginnt von Vorne
					$_SESSION["cg_login_count"]=1;
					$creds = array();
					$creds['user_login'] = $cgWpData->user_login;
					$creds['user_password'] = $cg_login_password;
					$creds['remember'] = true;
					$user = wp_signon( $creds, true );
			}



		}

		}

		else{

            ?>
            <script>
                console.log("Login manipulation prevention code 341. Please contact Administrator if you have questions.");
            </script>
            <?php
            die();

		}


?>