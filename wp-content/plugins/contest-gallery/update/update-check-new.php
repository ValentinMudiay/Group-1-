<?php

global $wpdb;


$tablename = $wpdb->prefix . "$i"."contest_gal1ery";
$tablename_ip = $wpdb->prefix . "$i"."contest_gal1ery_ip";
$tablename_comments = $wpdb->prefix . "$i"."contest_gal1ery_comments";
$tablename_options = $wpdb->prefix . "$i"."contest_gal1ery_options";
$tablename_options_input = $wpdb->prefix . "$i"."contest_gal1ery_options_input";
$tablename_options_visual = $wpdb->prefix . "$i"."contest_gal1ery_options_visual";
$tablename_email = $wpdb->prefix . "$i"."contest_gal1ery_mail";
$tablename_email_admin = $wpdb->prefix . "$i"."contest_gal1ery_mail_admin";
$tablename_entries = $wpdb->prefix . "$i"."contest_gal1ery_entries";
$tablename_create_user_entries = $wpdb->prefix . "$i"."contest_gal1ery_create_user_entries";
$tablename_pro_options = $wpdb->prefix . "$i"."contest_gal1ery_pro_options";
$tablename_create_user_form = $wpdb->prefix . "$i"."contest_gal1ery_create_user_form";
$tablename_form_input = $wpdb->prefix . "$i"."contest_gal1ery_f_input";
$tablename_form_output = $wpdb->prefix . "$i"."contest_gal1ery_f_output";
//  $tablename_mail_gallery = $wpdb->prefix . "$i"."contest_gal1ery_mail_gallery";
//  $tablename_mail_gallery_users_history = $wpdb->prefix . "$i"."contest_gal1ery_mail_gallery_users_history";
$tablename_mails_collected = $wpdb->prefix . "$i"."contest_gal1ery_mails_collected";
$tablename_mail_confirmation = $wpdb->prefix . "$i"."contest_gal1ery_mail_confirmation";
$tablename_categories = $wpdb->prefix . "$i"."contest_gal1ery_categories";

$columnsToRepairArray = array();

$updateArray = include('update-conf.php');

if(!isset($errorsArray)){
    $errorsArray = array();
}

// check here required because might be done twice because of corrections-and-improvements logic

$databaseTablesAndColumnsArrayOfObjects = array();
$dtacaoo = $databaseTablesAndColumnsArrayOfObjects;

$dtacaoo[$tablename_email] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_email" );
$dtacaoo[$tablename_email_admin] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_email_admin" );
$dtacaoo[$tablename_options_input] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_options_input" );
$dtacaoo[$tablename_entries] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_entries" );
$dtacaoo[$tablename] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename" );
$dtacaoo[$tablename_ip] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_ip" );
$dtacaoo[$tablename_options] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_options" );
$dtacaoo[$tablename_options_visual] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_options_visual" );
$dtacaoo[$tablename_form_input] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_form_input" );
$dtacaoo[$tablename_form_output] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_form_output" );
$dtacaoo[$tablename_pro_options] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_pro_options" );
$dtacaoo[$tablename_create_user_entries] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_create_user_entries" );
$dtacaoo[$tablename_create_user_form] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_create_user_form" );
$dtacaoo[$tablename_mail_confirmation] = $wpdb->get_results( "SHOW COLUMNS FROM $tablename_mail_confirmation" );

/*
echo "<pre>";
print_r($dtacaoo);
echo "</pre>";*/


foreach($updateArray as $tableName => $tableData){

    foreach($tableData as $columnName => $columnData){

        $isColumnAvailable = false;
        $availableTableObjectsData = false;

        foreach($dtacaoo as $tableNameToCompare => $tableObjectsData){

            if($tableName==$tableNameToCompare){

                foreach($tableObjectsData as $tableObject){

                    if($columnName==$tableObject->Field){
                        $isColumnAvailable = true;
                        $availableTableObjectsData = $tableObject;
                    }

                }

            }

        }

        // if not avialable then alter (create) column!
        if(!$isColumnAvailable){

            if(!empty($isJustCheck)){
                if(empty($columnsToRepairArray[$tableName])){$columnsToRepairArray[$tableName] = array();}
                if(empty($columnsToRepairArray['hasColumnsToImprove'])){$columnsToRepairArray['hasColumnsToImprove'] = true;}
                $columnsToRepairArray[$tableName][] = array('ColumnName' => $columnName, 'IsNoColumn' => true);
            }else{
                $columnType = trim(strtolower($columnData['COLUMN_TYPE']));

                $DEFAULT = "DEFAULT ".$columnData['DEFAULT'];
                $query = "ALTER TABLE $tableName ADD COLUMN $columnName $columnType $DEFAULT";

                if(!$wpdb->query($query)){
                    $wpdb->show_errors();
                    ob_start();
                    $wpdb->print_error();
                    $errorsArray[$columnName] = ob_get_clean();
                }

            }

        }else{
            $columnType = trim(strtolower($columnData['COLUMN_TYPE']));
            $columnTypeToCompare = trim(strtolower($availableTableObjectsData->Type));

            $isBothTinyInt = false;

            if(strpos($columnType,'tinyint') !== false && strpos($columnTypeToCompare,'tinyint') !== false){
                $isBothTinyInt = true;
            }

            // if both tinyint then no changes needed
            if($columnType!=$columnTypeToCompare && !$isBothTinyInt){
                if(!empty($isJustCheck)){
                    if(empty($columnsToRepairArray[$tableName])){$columnsToRepairArray[$tableName] = array();}
                    if(empty($columnsToRepairArray['hasColumnsToImprove'])){$columnsToRepairArray['hasColumnsToImprove'] = true;}
                    $columnsToRepairArray[$tableName][] = array('ColumnName' => $columnName, 'IsColumnCouldNotBeModified' => true, 'ColumnTypeCurrent' => $columnTypeToCompare, 'ColumnTypeRequired' => $columnType);
                }else{
                    // check if type is same
                    // if not then modify
                    if($columnType != trim(strtolower($availableTableObjectsData->Type))){

                        $DEFAULT = "DEFAULT ".$columnData['DEFAULT'];
                        $query = "ALTER TABLE $tableName MODIFY COLUMN $columnName $columnType $DEFAULT";
                        if(!$wpdb->query($query)){
                            $wpdb->show_errors();
                            ob_start();
                            $wpdb->print_error();
                            $errorsArray[$columnName] = ob_get_clean();
                        }
                    }
                }

            }

        }

    }

}


?>