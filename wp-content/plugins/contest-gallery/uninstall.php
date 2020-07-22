<?php
if(!defined('ABSPATH')){exit;}
// If uninstall not called from WordPress exit
if( !defined( 'WP_UNINSTALL_PLUGIN' ) )
exit ();

function contest_gal1ery_rm_uploads_content($dir){

    $dirContent = glob($dir.'/*');

    foreach($dirContent as $item){
        // 1. Ebene
        if(is_dir($item)){
            contest_gal1ery_rm_uploads_content($item);
        }
        else{
            if(is_file($item)){
                unlink($item);
            }
        }

    }

    if(is_dir($dir)){
        rmdir($dir);
    }

}


// Achtung! Löschen eines Plugins wird bei Multisite immer der Hauptinstanz 'network/admin' ausgeführt.
function cgRemoveFiles($r){
	
	// Multisite Pfad Beispiel:
	// /var/www.../.../htdocs/wp-content/uploads/sites/5/contest-gallery/
	
	$upload_dir = wp_upload_dir();
	
	// '' entspricht 1
	if($r==1){
		$dir = $upload_dir['basedir']."/contest-gallery";
	}
	else{
		$dir = $upload_dir['basedir']."/sites/$r/contest-gallery";
	}

    contest_gal1ery_rm_uploads_content($dir);
	
}

// Löschen aller Dateien von Contest Gallery --- ENDE
	
	// Löschen von Tabellen	und Files von Contest Gallery
	
	if (is_multisite()) {
			
			global $wpdb;

			$wpBlogs = $wpdb->prefix . "blogs";

			$getBlogIDs = $wpdb->get_results( "SELECT blog_id FROM $wpBlogs ORDER BY blog_id ASC" );
			foreach($getBlogIDs as $key => $value){
				foreach($value as $key1 => $value1){
					if($value1==1){
						$i='';
						$r=1;
					}
					else{
						$i=$value1."_";
						$r=$value1;
					}
					cgDropTables($i);
					cgRemoveFiles($r);
				}
			}
	}
	else{
		$i='';
		$r=1;
		cgDropTables($i);
		cgRemoveFiles($r);		
	}
	// Löschen von Tabellen und Files von Contest Gallery --- ENDE	





function cgDropTables($i){

global $wpdb;


	$tablename = $wpdb->prefix . "$i"."contest_gal1ery";
	$tablename_ip = $wpdb->prefix . "$i"."contest_gal1ery_ip";
	$tablename_comments = $wpdb->prefix . "$i"."contest_gal1ery_comments";
	$tablename_options = $wpdb->prefix . "$i"."contest_gal1ery_options";
	$tablename_options_input = $wpdb->prefix . "$i"."contest_gal1ery_options_input";
	$tablename_email = $wpdb->prefix . "$i"."contest_gal1ery_mail";
	$tablename_entries = $wpdb->prefix . "$i"."contest_gal1ery_entries";
	$tablename_form_input = $wpdb->prefix . "$i"."contest_gal1ery_f_input";
	$tablename_form_output = $wpdb->prefix . "$i"."contest_gal1ery_f_output";
	$tablename_options_visual = $wpdb->prefix . "$i"."contest_gal1ery_options_visual";
	$tablename_email_admin = $wpdb->prefix . "$i"."contest_gal1ery_mail_admin";
	$wpOptions = $wpdb->prefix . "$i"."options";
	$tablename_contest_gal1ery_create_user_entries = $wpdb->prefix . "$i"."contest_gal1ery_create_user_entries";
	$tablename_contest_gal1ery_create_user_form = $wpdb->prefix . "$i"."contest_gal1ery_create_user_form";
	$tablename_contest_gal1ery_pro_options = $wpdb->prefix . "$i"."contest_gal1ery_pro_options";
    $tablename_mail_gallery = $wpdb->prefix . "$i"."contest_gal1ery_mail_gallery";
    $tablename_mail_confirmation = $wpdb->prefix . "$i"."contest_gal1ery_mail_confirmation";
    $tablename_mails_collected = $wpdb->prefix . "$i"."contest_gal1ery_mails_collected";
    $tablename_categories = $wpdb->prefix . "$i"."contest_gal1ery_categories";


    $sqlWpOptionsDelete = 'DELETE FROM ' . $wpOptions . ' WHERE';
	$sqlWpOptionsDelete .= ' option_name = %s';

	$wpdb->query( $wpdb->prepare(
		"
			$sqlWpOptionsDelete
		", 
			"p_cgal1ery_db_version"
	));

$sql = "DROP TABLE $tablename";
$sql1 = "DROP TABLE $tablename_ip";
$sql2 = "DROP TABLE $tablename_comments";
$sql4 = "DROP TABLE $tablename_options";
$sql5 = "DROP TABLE $tablename_options_input";
$sql6 = "DROP TABLE $tablename_email";
$sql7 = "DROP TABLE $tablename_entries";
$sql8 = "DROP TABLE $tablename_form_input";
$sql9 = "DROP TABLE $tablename_form_output";
$sql10 = "DROP TABLE $tablename_options_visual";
$sql11 = "DROP TABLE $tablename_email_admin";
$sql12 = "DROP TABLE $tablename_contest_gal1ery_create_user_entries";
$sql13 = "DROP TABLE $tablename_contest_gal1ery_create_user_form";
$sql14 = "DROP TABLE $tablename_contest_gal1ery_pro_options";
$sql15 = "DROP TABLE $tablename_mail_gallery";
$sql16 = "DROP TABLE $tablename_mail_confirmation";
$sql17 = "DROP TABLE $tablename_mails_collected";
$sql18 = "DROP TABLE $tablename_categories";

$wpdb->query($sql);
$wpdb->query($sql1);
$wpdb->query($sql2);
$wpdb->query($sql4);
$wpdb->query($sql5);
$wpdb->query($sql6);
$wpdb->query($sql7);
$wpdb->query($sql8);
$wpdb->query($sql9);
$wpdb->query($sql10);
$wpdb->query($sql11);
$wpdb->query($sql12);
$wpdb->query($sql13);
$wpdb->query($sql14);
$wpdb->query($sql15);
$wpdb->query($sql16);
$wpdb->query($sql17);
$wpdb->query($sql18);

delete_option("p_cgal1ery_reg_code");
delete_option("p_c1_k_g_r_9");
delete_option( "p_cgal1ery_db_version");
delete_option("p_cgal1ery_install_date");
delete_option( "p_cgal1ery_count_users");
delete_option( "p_cgal1ery_uploadscounter_reminder");
delete_option( "p_cgal1ery_count_uploads");
delete_option( "p_cgal1ery_uploadscounter_reminder");
delete_option( "p_cgal1ery_count_users");
delete_option( "p_cgal1ery_reminder_time");
delete_option( "p_cgal1ery_count_users");
delete_option( "p_cgal1ery_reg_code");

}


	  
?>