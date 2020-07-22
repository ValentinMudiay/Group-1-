<?php

//$count = @$_POST['count'];


// Reihenfolge der Bilder wechseln
// rowid aufbau
// row[$id][$Active]


if(!empty($rowids)){

    $order = 1;
    foreach($rowids as $key => $value){

        // UPDATE ROW
        $querySETrowForRowIds .= " WHEN $key THEN ".$value[key($value)]."";
        $querySETaddRowForRowIds .= "$key,";

    }

    $querySETaddRowForRowIds = substr($querySETaddRowForRowIds,0,-1);
    $querySETaddRowForRowIds .= ")";

    $querySETrowForRowIds .= $querySETaddRowForRowIds;
    $updateSQL = $wpdb->query($querySETrowForRowIds);

}

