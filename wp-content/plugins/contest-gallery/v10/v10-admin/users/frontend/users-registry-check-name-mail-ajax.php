<?php
if(!defined('ABSPATH')){exit;}

		// 1 = Mail
		// 2 = Name
		// 3 = Check

        $galeryID = $_REQUEST['gid'];
		$cg_check = $_REQUEST['action3'];
        $galleryHashToCompare = md5(wp_salt( 'auth').'---cgreg---'.$galeryID);

if($cg_check==$galleryHashToCompare){
		global $wpdb;
		$tablenameWpUsers = $wpdb->prefix . "users";

		$cg_main_mail = sanitize_text_field($_REQUEST['action1']);
		$cg_main_user_name = sanitize_text_field($_REQUEST['action2']);


		$checkWpIdViaMail = $wpdb->get_var("SELECT ID FROM $tablenameWpUsers WHERE user_email = '".$cg_main_mail."'");
		$checkWpIdViaName = $wpdb->get_var("SELECT ID FROM $tablenameWpUsers WHERE user_login = '".$cg_main_user_name."' OR 
				user_nicename = '".$cg_main_user_name."' OR display_name = '".$cg_main_user_name."'");


		//	var_dump($checkWpIdViaMail);
	//		var_dump($checkWpIdViaName);
		if($checkWpIdViaMail==true){


?>
<script>
var cg_language_ThisMailAlreadyExists = document.getElementById("cg_language_ThisMailAlreadyExists").value;

var cg_check_mail_name_value = document.getElementById('cg_check_mail_name_value');
cg_check_mail_name_value.value = 1;

//var div = document.getElementById('divID');
var cg_mail_check_alert = document.getElementById('cg_mail_check_alert');
cg_mail_check_alert.innerHTML = cg_mail_check_alert.innerHTML + cg_language_ThisMailAlreadyExists;
cg_mail_check_alert.classList.remove("cg_hide");



location.href = "#cg_user_registry_anchor";

//alert(cg_language_ThisMailAlreadyExists);
</script>
<?php
		}

		if($checkWpIdViaName==true){



?>
<script>
var cg_language_ThisNicknameAlreadyExists = document.getElementById("cg_language_ThisNicknameAlreadyExists").value;

var cg_check_mail_name_value = document.getElementById('cg_check_mail_name_value');
cg_check_mail_name_value.value = 1;


var cg_user_name_check_alert = document.getElementById('cg_user_name_check_alert');
cg_user_name_check_alert.innerHTML = cg_user_name_check_alert.innerHTML + cg_language_ThisNicknameAlreadyExists;
cg_user_name_check_alert.classList.remove("cg_hide");
location.href = "#cg_user_registry_anchor";


//alert(cg_language_ThisUsernameAlreadyExists);
</script>
<?php
		}


		}

		else{

            ?>
            <script>
                console.log("Registration manipulation prevention code 331. Please contact Administrator if you have questions.");
            </script>
            <?php
            die();


		}


?>