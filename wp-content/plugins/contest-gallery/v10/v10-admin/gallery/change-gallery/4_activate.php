<?php

if (@$_POST['chooseAction1']==1 or @$_POST['chooseAction1']==2 or @$_POST['chooseAction1']==3){

    $collect = "";

        $imageRatingArray = array();


        // erst mal alle aktivieren, die aktiviert gehören!!!
        if (@$_POST['chooseAction1']==1){
            if(!empty($_POST['active'])){
                foreach($activate as $key => $value){

                    $wpdb->update(
                        "$tablename",
                        array('Active' => '1'),
                        array('id' => $value),
                        array('%d'),
                        array('%d')
                    );
                }
            }
        }

        // Dann die bearbeiten, die geschickt wurden und nicht DEAKTIVIERT wurden!!!
        if(!empty($_POST['row'])){

            $ids = $_POST['row'];

            foreach($ids as $id => $rowid){

                if(@$_POST['chooseAction1']==2 or @$_POST['chooseAction1']==3){
                    // wenn 2 oder 3, wurden die Activate zum deaktivieren oder löschen verwendet und können aus rows rausgenommen werden
                    if(!empty($activate)){

                        if(!empty($activate[$id])){
                            unset($ids[$id]);
                            continue;
                        }

                    }

                }

                if($collect==''){
                    $collect .= "$tablename.id = $id";
                }else{
                    $collect .= " OR $tablename.id = $id";
                }

            }

        }

        if(!empty($collect)){

            $picsSQL = $wpdb->get_results( "SELECT $table_posts.*, $tablename.* FROM $table_posts, $tablename WHERE ($collect) AND $tablename.GalleryID='$GalleryID' AND $tablename.Active='1' and $table_posts.ID = $tablename.WpUpload ORDER BY $tablename.id DESC");

            // Gr��e der Bilder bei ThumbAnsicht (gew�hnliche Ansicht mit Bewertung)
            $uploadFolder = wp_upload_dir();
            $urlSource = site_url();

            $blog_title = get_bloginfo('name');
            $blog_description = get_bloginfo('description');

            // first get user ids in this array $imageId
            $wpUserIdsAndDisplayNames = array();
            $collect = "";
            foreach($picsSQL as $object){
                if(!empty($object->WpUserId)){
                    $wpUserIdsAndDisplayNames[$object->id] = $object->WpUserId;
                    if($collect==''){
                        $collect .= "ID = $object->WpUserId";
                    }else{
                        $collect .= " OR ID = $object->WpUserId";
                    }
                }
                else{
                    $wpUserIdsAndDisplayNames[$object->id] = '';
                }
            }

            if(!empty($collect)){
                $displayNames = $wpdb->get_results( "SELECT ID, display_name FROM $table_users WHERE ($collect) ORDER BY ID DESC");
            }

            // now get user names in this array
            if(!empty($displayNames)){
                foreach($displayNames as $wpUser){

                    if(in_array($wpUser->ID,$wpUserIdsAndDisplayNames)){
                        foreach($wpUserIdsAndDisplayNames as $imageId => $wpUserId){

                            if($wpUserId==$wpUser->ID){
                                //$imageArray[$rowObject->id]['display_name'] = '' wurde pauschal in cg_create_json_files_when_activating
                                $imageArray[$imageId]['display_name'] = $wpUser->display_name;
                                $wpUserIdsAndDisplayNames[$imageId] = $wpUser->display_name;

                            }

                        }
                    }
                }
            }

            // get wpUser display_name --- END

            // add all json files and generate images array
            foreach($picsSQL as $object){

                $imageArray = cg_create_json_files_when_activating($GalleryID,$object,$thumbSizesWp,$uploadFolder,$imageArray,$wpUserIdsAndDisplayNames);

                include('4_2_fb-creation.php');

            }


        }

}
















