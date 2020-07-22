<?php
if(!function_exists('contest_gal1ery_db_check')){
function contest_gal1ery_db_check(){

    global $p_cgal1ery_db_new_version;
    $p_cgal1ery_db_new_version = '10.9880';

    if(!get_option("p_cgal1ery_install_date")){
        add_option("p_cgal1ery_install_date",date('Y-m-d'));
    }

    $p_cgal1ery_db_installed_ver = get_option( "p_cgal1ery_db_version" );

    if ( $p_cgal1ery_db_installed_ver != $p_cgal1ery_db_new_version ) {
        if(function_exists('contest_gal1ery_create_table')){
            // Achtung! Bei einer Multisite kann Wordpress sowohl von einem Hauptbereich (network), wie auch von einem einzelnen Blog aus aktiviert werden
            if (is_multisite()) {

                global $wpdb;

                $wpBlogs = $wpdb->prefix . "blogs";

                $getBlogIDs = $wpdb->get_results( "SELECT blog_id FROM $wpBlogs ORDER BY blog_id ASC" );

                if(strpos(@$_SERVER['REQUEST_URI'],"wp-admin/network")){

                    foreach($getBlogIDs as $key => $value){
                        foreach($value as $key1 => $value1){
                            if($value1==1){
                                $i='';
                            }
                            else{
                                $i=$value1."_";
                            }
                            contest_gal1ery_create_table($i);
                        }
                    }
                }
                else{
                    // Richtiger Prefix wird von Wordpress auotmatisch weitergegeben
                    $i="";
                    contest_gal1ery_create_table($i);
                }

            }
            // Wenn single Site dann ganz normalen Drop contest gallery Tables
            else{
                // Richtiger Prefix wird von Wordpress auotmatisch weitergegeben
                $i='';
                contest_gal1ery_create_table($i);
            }


            // Löschen von Tabellen --- ENDE

            // do update check!
            include(__DIR__."/../../update/update-check-new.php");

        }

        if($p_cgal1ery_db_installed_ver){update_option( "p_cgal1ery_db_version", $p_cgal1ery_db_new_version );}

        else{add_option( "p_cgal1ery_db_version", $p_cgal1ery_db_new_version );}

    }

}
}

if(!function_exists('contest_gal1ery_key_check')){
    function contest_gal1ery_key_check(){

        // Check start von hier:
        $p_cgal1ery_reg_code = get_option("p_cgal1ery_reg_code");
        $p_c1_k_g_r_8 = get_option("p_c1_k_g_r_9");

        $arrayNew = array(
            '824f6b8e4d606614588aa97eb8860b7e',
            'add4012c56f21126ba5a58c9d3cffcd7',
            'bfc5247f508f427b8099d17281ecd0f6',
            'a29de784fb7699c11bf21e901be66f4e',
            'e5a8cb2f536861778aaa2f5064579e29',
            '36d317c7fef770852b4ccf420855b07b'
        );

        $p_c1_k_g_r_8 = md5($p_c1_k_g_r_8);

        if((strpos(floatval($p_cgal1ery_reg_code)/44,".") == false
                && floatval($p_cgal1ery_reg_code)!=0
                && floatval($p_cgal1ery_reg_code)>=986798739)
            or in_array($p_c1_k_g_r_8, $arrayNew)
        ){
            return true;
        }else{
            return false;
        }

    }

}

// PRO Version 2019 02 23

/*
 *      if(!$cgProVersion){

        unset($_POST['ContestEndInstant']);
        unset($_POST['ContestEnd']);
        unset($_POST['checkLogin']);
        unset($_POST['HideUntilVote']);
        unset($_POST['VotesPerUser']);
        unset($_POST['ShowOnlyUsersVotes']);
        unset($_POST['ActivateUpload']);
        unset($_POST['RegUserUploadOnly']);
        unset($_POST['InformAdmin']);
        unset($_POST['mConfirmSendConfirm']);
        unset($_POST['InformUsers']);
        unset($_POST['ShowNickname']);
        unset($_POST['IpBlock']);
        unset($_POST['ForwardAfterLoginUrlCheck']);
        unset($_POST['ForwardAfterLoginTextCheck']);

    }

*/




