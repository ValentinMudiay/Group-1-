<?php

/* UPDATE/INSERT VALUES */

if(isset($_POST['Entry_Field_Content'])){
	
	foreach($_POST['Entry_Field_Content'] as $id => $value){

        $wpdb->update(
            "$tablename_contest_gal1ery_create_user_entries",
            array('Field_Content' => sanitize_text_field(htmlentities($value, ENT_QUOTES, 'UTF-8'))),
            array('id' => $id),
            array('%s'),
            array('%d')
        );

	}
}


/* UPDATE/INSERT VALUES --- END */


?>