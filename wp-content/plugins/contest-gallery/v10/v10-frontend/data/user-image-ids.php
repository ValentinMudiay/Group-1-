<?php

if($is_user_logged_in){
    $wpUserImageIds = $wpdb->get_results( $wpdb->prepare(
        "
							SELECT id
							FROM $tablename
							WHERE GalleryID = %d and WpUserId = %d ORDER BY id DESC
						",
        $galeryID,$wpUserId
    ) );
}


?>
    <script>

        var index = <?php echo json_encode($galeryIDuser) ?>;
        cgJsData[index].onlyLoggedInUserImages = true;
        cgJsData[index].wpUserImageIds = [];

    </script>
<?php

if(!empty($wpUserImageIds)){
    if(count($wpUserImageIds)){
        foreach($wpUserImageIds as $row){
            ?>
            <script>

                var index = <?php echo json_encode($galeryIDuser) ?>;
                cgJsData[index].wpUserImageIds.push(<?php echo json_encode($row->id) ?>);

            </script>
            <?php
        }
    }
}

