<?php

if(@$_POST['chooseAction1']==4){

    //echo "<b>TREEWRSDFSDETWERSDF</b>";

    if (@$_POST['active']==true) {

        //echo "resetInformId:";
        $resetInformId = @$_POST['active'];

        //print_r($querySETresetInformId);
        //    var_dump($value);
        //var_dump($resetInformId);
        // Reset informierte Felder Query
        $querySETresetInformId = 'UPDATE ' . $tablename . ' SET Informed="0" WHERE';


        foreach($resetInformId as $key => $value){

            $querySETresetInformId .= ' id = "' . $value . '"';
            $querySETresetInformId .= ' or';

        }

        $querySETresetInformId = substr($querySETresetInformId,0,-3);
        $updateSQL = $wpdb->query($querySETresetInformId);

    }

}
