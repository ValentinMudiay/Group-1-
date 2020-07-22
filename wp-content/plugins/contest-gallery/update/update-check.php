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


$tablesData = $wpdb->get_results("
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_email'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_email_admin'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_options_input'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_entries'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_ip'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_options'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_options_visual'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_form_input'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_form_output'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_pro_options'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_create_user_entries'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_create_user_form'
 UNION
 SELECT TABLE_NAME, COLUMN_NAME, DATA_TYPE, COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
 WHERE TABLE_NAME = '$tablename_mail_confirmation'
  ");


$updateArray = include('update-conf.php');


/*echo "<pre>";
print_r($tablesData);
echo "</pre>";*/


foreach($tablesData as $column){

    $column = (array)$column;

    if(!empty($updateArray[$column['TABLE_NAME']])){

        if(!empty($updateArray[$column['TABLE_NAME']][$column['COLUMN_NAME']])){

            $updateArray[$column['TABLE_NAME']][$column['COLUMN_NAME']]['EXISTS'] = 1;

            $tableColumnType = strtolower(str_replace('(','',$column['COLUMN_TYPE']));
            $tableColumnType = strtolower(str_replace(')','',$tableColumnType));
            $arrayConfColumnType = strtolower(str_replace('(','',$updateArray[$column['TABLE_NAME']][$column['COLUMN_NAME']]['COLUMN_TYPE']));
            $arrayConfColumnType = strtolower(str_replace(')','',$arrayConfColumnType));

            // $test2 = strtolower(htmlspecialchars($updateArray[$column['TABLE_NAME']][$column['COLUMN_TYPE']]));

            /*            echo $updateArray[$column['TABLE_NAME']][$column['COLUMN_NAME']]['COLUMN_TYPE'];
                        echo $column['COLUMN_TYPE'];*/
            /*            echo $tableColumnType;
                        echo $arrayConfColumnType;

            echo trim(strpos($tableColumnType,'tinyint'));
            echo trim(strpos($tableColumnType,'tinyint'));
            echo trim(strpos($arrayConfColumnType,'tinyint'));*/



            if($tableColumnType!=$arrayConfColumnType){

                if($column['COLUMN_NAME']=='ActivateUpload'){
//                    echo $tableColumnType;
//                    echo $arrayConfColumnType;
//                    var_dump(strpos(trim($tableColumnType),'tinyint'));
//                    var_dump(strpos(trim($arrayConfColumnType),'tinyint'));
                }

                $doNotUpdateTinyInt = false;
                if(strpos(trim($tableColumnType),'tinyint')===0 && strpos(trim($arrayConfColumnType),'tinyint')===0){

                    $doNotUpdateTinyInt = true;
                }

                $updateVarchar = false;
                if(strpos(trim($tableColumnType),'varchar')===0 && strpos(trim($arrayConfColumnType),'int')===0){

                    $updateVarchar = true;
                }

                // TINYINT changes will be not updated!
                if($doNotUpdateTinyInt==false){

                    //  var_dump('update!!!');
                    $updateArray[$column['TABLE_NAME']][$column['COLUMN_NAME']]['UPDATE'] = 1;

                }

                // FROM VARCHAR TO INT WILL BE UPDATED
                if($updateVarchar==true){

                    $updateArray[$column['TABLE_NAME']][$column['COLUMN_NAME']]['UPDATE_VARCHAR_TO_INT'] = 1;

                }


            }

        }

    }


}

/*echo "<pre>";
print_r($updateArray);
echo "</pre>";*/

//$wpdb->show_errors();
foreach($updateArray as $table => $column){

    foreach($column as $columnName => $columnValue){

     //   $DEFAULT = '""';

        $columnName = trim($columnName);
        $tableName = trim($table);
        $columnType = trim($columnValue['COLUMN_TYPE']);


       // if(!empty($columnValue['DEFAULT']) || $DEFAULT!='""'){

            $DEFAULT = "DEFAULT ".$columnValue['DEFAULT'];
      //  }

        if(empty($columnValue['EXISTS'])){

            // ADD
            $query = "ALTER TABLE $tableName ADD COLUMN $columnName $columnType $DEFAULT";
         //   echo 'Add <br>';
           // var_dump('default');
           // var_dump($DEFAULT);
         //   echo $query;
        //    echo "<br>";
            $wpdb->query($query);


        }
        else if(!empty($columnValue['UPDATE'])){


      //      echo "ALTER TABLE $tableName MODIFY COLUMN $columnName $columnType $DEFAULT";
            $query = "ALTER TABLE $tableName MODIFY COLUMN $columnName $columnType $DEFAULT";

       //    echo 'Update <br>';
        //    echo $query;
      //     echo "<br>";

            // MODIFY
            $wpdb->query($query);


        }
        if(!empty($columnValue['UPDATE_VARCHAR_TO_INT'])){

            $wpdb->update(
                $tableName,
                array($columnName => 0),
                array($columnName => NULL),
                array('%d'),
                array('%d')
            );


        }

    }

}

//$wpdb->print_error();
//die;
//$wpdb->query("ALTER TABLE wp_contest_gal1ery MODIFY COLUMN CountS $test DEFAULT 1");
/*echo '<pre>';
print_r($updateArray);
echo '</pre>';


echo '<pre>';
print_r($tablesData);
echo '</pre>';*/




?>