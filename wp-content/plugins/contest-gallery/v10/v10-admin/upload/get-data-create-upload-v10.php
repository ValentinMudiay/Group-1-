<?php

// 1. Delete Felder in Entries, F_Input, F_Output
// 2. Swap Field_Order in Entries, F_Input, F_Output (bei post "done-upload" wird alles mitgegeben
// 3. Neue Felder hinzuf�gen in F_Input, Entries
// 4. // Auswahl zum Anzeigen gespeicherter Felder

// Empfangen von Galerie OptiOns ID


$GalleryID = intval(@$_GET['option_id']);

global $wpdb;

// Tabellennamen bestimmen

$tablename = $wpdb->prefix . "contest_gal1ery";
$tablenameoptions = $wpdb->prefix . "contest_gal1ery_options";
$tablenameentries = $wpdb->prefix . "contest_gal1ery_entries";
$tablename_form_input = $wpdb->prefix . "contest_gal1ery_f_input";
$tablename_form_output = $wpdb->prefix . "contest_gal1ery_f_output";
$tablename_options_visual = $wpdb->prefix . "contest_gal1ery_options_visual";
$tablename_categories = $wpdb->prefix . "contest_gal1ery_categories";
$tablename_pro_options = $wpdb->prefix . "contest_gal1ery_pro_options";

$optionsSql = $wpdb->get_row("SELECT GalleryName, FbLike FROM $tablenameoptions WHERE id = '$GalleryID'");
$GalleryName = $optionsSql->GalleryName;
$FbLike = $optionsSql->FbLike;

$Version = '10.9.8.8.1';

if(!empty($_POST['upload'])){

    check_admin_referer( 'cg_admin');

    $wp_upload_dir = wp_upload_dir();

    $checkDataFormOutput = $wpdb->get_results("SELECT * FROM $tablename_form_input WHERE GalleryID = $GalleryID and (Field_Type = 'comment-f' or Field_Type = 'text-f' or Field_Type = 'email-f')");
    //print_r($checkDataFormOutput);

    $rowVisualOptions = $wpdb->get_row("SELECT * FROM $tablename_options_visual WHERE GalleryID = '$GalleryID'");
    @$Field1IdGalleryView = $rowVisualOptions->Field1IdGalleryView;

    // make json file
    $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
    $fp = fopen($optionsFile, 'r');
    $optionsFileData =json_decode(fread($fp,filesize($optionsFile)),true);
    fclose($fp);


    // Pr�fen ob es ein Feld gibt welches als Images URL genutzt werden soll
    @$Use_as_URL = $wpdb->get_var("SELECT Use_as_URL FROM $tablename_form_input WHERE GalleryID = '$GalleryID' AND Use_as_URL = '1'");
    @$Use_as_URL_id = $wpdb->get_var("SELECT id FROM $tablename_form_input WHERE GalleryID = '$GalleryID' AND Use_as_URL = '1'");

    $infoInSliderId = null;
    $infoInGalleryId = null;
    $tagInGalleryId = null;
    $tagInGalleryIdIsForCategories = false;

    // Check if certain fieldnumber should be deleted

    // L�schen Ddaten in Tablename entries
    // L�schen Ddaten in Tablename f_input
    // L�schen Ddaten in Tablename f_output


    if(@$_POST['deleteFieldnumber']){

        if(is_array($_POST['deleteFieldnumber'])){

            if(!empty($_POST['deleteFieldnumber']['deleteCategoryFields'])){

                $deleteFieldnumber = intval(reset($_POST['deleteFieldnumber']));

                $wpdb->query( $wpdb->prepare(
                    "
                        DELETE FROM $tablename_categories WHERE GalleryID = %d
                    ",
                    $GalleryID
                ));

                $wpdb->update(
                    "$tablename",
                    array('Category' => 0),
                    array('GalleryID' => $GalleryID),
                    array('%d'),
                    array('%d')
                );

            }

        }
        else{
            $deleteFieldnumber = intval(@$_POST['deleteFieldnumber']);
        }



        $wpdb->query( $wpdb->prepare(
            "
                DELETE FROM $tablename_form_input WHERE GalleryID = %d AND id = %d
             ",
            $GalleryID, $deleteFieldnumber
        ));

        $wpdb->query( $wpdb->prepare(
            "
                DELETE FROM $tablename_form_output WHERE GalleryID = %d AND f_input_id = %d
             ",
            $GalleryID, $deleteFieldnumber
        ));


        $wpdb->query( $wpdb->prepare(
            "
                DELETE FROM $tablenameentries WHERE GalleryID = %d AND f_input_id = %d
             ",
            $GalleryID, $deleteFieldnumber
        ));

    }

    // Check if certain fieldnumber should be deleted --- ENDE


    // insert delete Categories


    if(!empty($_POST['deleteCategory'])){

        $deleteCategory = intval($_POST['deleteCategory']);

        $wpdb->query( $wpdb->prepare(
            "
                DELETE FROM $tablename_categories WHERE id = %d
             ",
            $deleteCategory
        ));

        // wenn es die Kategorie gibt wird diese mit 0 upgedatet, wenn nicht dann nicht
        $wpdb->update(
            "$tablename",
            array('Category' => 0),
            array('Category' => $deleteCategory),
            array('%d'),
            array('%d')
        );

    }


    if(!empty($_POST['cg_category'])){

        $order = 1;

        $categoriesCount = $wpdb->get_var("SELECT COUNT(*) AS NumberOfRows FROM $tablename_categories WHERE GalleryID = '$GalleryID' ORDER BY Field_Order");
        if(empty($categoriesCount)){ // then CatWidget option has to be set to 1 and show other also to 1 again

            $wpdb->update(
                "$tablename_pro_options",
                array('ShowOther' => 1, 'CatWidget' => 1),
                array('GalleryID' => $GalleryID),
                array('%d','%d'),
                array('%s')
            );

            $optionsFileData['pro']['ShowOther'] = 1;
            $optionsFileData['pro']['CatWidget'] = 1;

            // make json file
            $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
            $fp = fopen($optionsFile, 'w');
            fwrite($fp, json_encode($optionsFileData));
            fclose($fp);

        }


        foreach($_POST['cg_category'] as $key => $value){

            if($key=='id' && is_array($value)){

                foreach($value as $id => $name){

                    $wpdb->update(
                        "$tablename_categories",
                        array('Name' => $name,'Field_Order' => $order),
                        array('id' => $id),
                        array('%s'),
                        array('%d')
                    );
                    $order++;

                }

            }
            else{

                $wpdb->query( $wpdb->prepare(
                    "
                      INSERT INTO $tablename_categories
                      ( id, GalleryID, Name, Field_Order, Active)
                      VALUES ( %s,%s,%s,%s,%d )
                   ",
                    '',$GalleryID,$value,$order,1
                ) );

                $order++;


            }


        }

    }




    // insert delete Categories end


    if(!empty($_POST['upload'])){

        foreach($_POST['upload'] as $id => $field){

            if($field['type']=='bh'){

                $bhFieldsArray = array();
                $bhFieldsArray['titel']= sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));

                $bhFieldsArray = serialize($bhFieldsArray);
                $order = $field['order'];

                if(empty($field['new'])){

                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'image-f','Field_Order' => $order,'Field_Content' => $bhFieldsArray,'Active' => 1,'Show_Slider' => 0),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s'),
                        array('%d')
                    );

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                      INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                   ",
                        '',$GalleryID,'image-f',$order,$bhFieldsArray,0,1
                    ) );

                }

            }

            if($field['type']=='cb' && $cgProVersion){// CHECK AGREEMENT!!!!!!!

                $cbFieldsArray = array();
                $cbFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $cbFieldsArray['content'] = contest_gal1ery_htmlentities_and_preg_replace($field['content']);

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $order = $field['order'];

                $cbFieldsArray['mandatory']=sanitize_text_field($onOff);

/*                echo "<pre>";
                print_r($cbFieldsArray);
                echo "</pre>";*/

                $cbFieldsArray = serialize($cbFieldsArray);

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'check-f','Field_Order' => $order,'Field_Content' => $cbFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider, 'Version' => $Version),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{
                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider, Active, Version)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d,%s )
                            ",
                        '',$GalleryID,'check-f',$order,$cbFieldsArray,$Show_Slider, $active, $Version
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}

                }
            }

            if($field['type']=='nf' OR $field['type']=='fbt'){// TEXT FIELD!!!!!

                $nfFieldsArray = array();
                $nfFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $nfFieldsArray['content'] = sanitize_text_field(htmlentities($field['content'], ENT_QUOTES, 'UTF-8'));
                $nfFieldsArray['min-char'] = sanitize_text_field(htmlentities($field['min-char'], ENT_QUOTES, 'UTF-8'));
                $nfFieldsArray['max-char'] = sanitize_text_field(htmlentities($field['max-char'], ENT_QUOTES, 'UTF-8'));

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $nfFieldsArray['mandatory']=sanitize_text_field($onOff);


                /*
                echo "<pre>";
                print_r($nfFieldsArray);
                echo "</pre>";*/

                $nfFieldsArray = serialize($nfFieldsArray);
                $order = $field['order'];

                $fieldType = ($field['type']=='nf') ? 'text-f' : 'fbt-f';


                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => $fieldType,'Field_Order' => $order,'Field_Content' => $nfFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,$fieldType,$order,$nfFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='dt'){// TEXT FIELD!!!!!

                $dtFieldsArray = array();
                $dtFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $dtFieldsArray['format'] = sanitize_text_field(htmlentities($field['format'], ENT_QUOTES, 'UTF-8'));


                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $dtFieldsArray['mandatory']=sanitize_text_field($onOff);

                /*
                echo "<pre>";
                print_r($dtFieldsArray);
                echo "</pre>";*/

                $dtFieldsArray = serialize($dtFieldsArray);
                $order = $field['order'];

                $fieldType = 'date-f';


                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => $fieldType,'Field_Order' => $order,'Field_Content' => $dtFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,$fieldType,$order,$dtFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='url'){

                $urlFieldsArray = array();
                $urlFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $urlFieldsArray['content'] = sanitize_text_field(htmlentities($field['content'], ENT_QUOTES, 'UTF-8'));


                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $urlFieldsArray['mandatory']=sanitize_text_field($onOff);
                $urlFieldsArray = serialize($urlFieldsArray);
                $order = $field['order'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'url-f','Field_Order' => $order,'Field_Content' => $urlFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%d','%s'),
                        array('%d')
                    );


                    $test = $wpdb -> get_row('SELECT * FROM '.$tablename_form_input.' where id = '.$id.'');
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,'url-f',$order,$urlFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='ef' && $cgProVersion){

                $efFieldsArray = array();
                $efFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $efFieldsArray['content'] = sanitize_text_field(htmlentities($field['content'], ENT_QUOTES, 'UTF-8'));

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $efFieldsArray['mandatory']=sanitize_text_field($onOff);
                $efFieldsArray = serialize($efFieldsArray);
                $order = $field['order'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'email-f','Field_Order' => $order,'Field_Content' => $efFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,'email-f',$order,$efFieldsArray,$Show_Slider,$active
                    ) );


                }
            }

            if($field['type']=='kf' OR $field['type']=='fbd'){

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                $kfFieldsArray = array();
                $kfFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $kfFieldsArray['content'] = sanitize_text_field(htmlentities($field['content'], ENT_QUOTES, 'UTF-8'));
                $kfFieldsArray['min-char'] = sanitize_text_field(htmlentities($field['min-char'], ENT_QUOTES, 'UTF-8'));
                $kfFieldsArray['max-char'] = sanitize_text_field(htmlentities($field['max-char'], ENT_QUOTES, 'UTF-8'));

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $kfFieldsArray['mandatory']=sanitize_text_field($onOff);
                $kfFieldsArray = serialize($kfFieldsArray);
                $order = $field['order'];

                $fieldType = ($field['type']=='kf') ? 'comment-f' : 'fbd-f';

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => $fieldType,'Field_Order' => $order,'Field_Content' => $kfFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,$fieldType,$order,$kfFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='ht' && $cgProVersion){

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                $htFieldsArray = array();
                $htFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                //$htFieldsArray['content'] = sanitize_text_field(htmlentities($field['content'], ENT_QUOTES, 'UTF-8'));
                $htFieldsArray['content'] = contest_gal1ery_htmlentities_and_preg_replace($field['content']);

                // no need for html field
    /*            if(!empty($field['required'])){
                    $onOff = 'on';
                }else{
                    $onOff = 'off';
                }
                $htFieldsArray['mandatory']=sanitize_text_field($onOff);*/

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $htFieldsArray = serialize($htFieldsArray);
                $order = $field['order'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'html-f','Field_Order' => $order,'Field_Content' => $htFieldsArray,'Active' => $active),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallerytagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,'html-f',$order,$htFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }


            if($field['type']=='caRo'){

                $caFieldsArray = array();
                $caFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $caFieldsArray['mandatory']=sanitize_text_field($onOff);
                $caFieldsArray = serialize($caFieldsArray);
                $order = $field['order'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'caRo-f','Field_Order' => $order,'Field_Content' => $caFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,'caRo-f',$order,$caFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='caRoRe'){

                $caFieldsArray = array();
                if(!empty($field['title'])){
                    $caFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                }else{
                    $caFieldsArray['titel']='';
                }


                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $caFieldsArray['mandatory']=sanitize_text_field($onOff);
                $caFieldsArray = serialize($caFieldsArray);
                $order = $field['order'];
                $ReCaKey = $field['ReCaKey'];
                $ReCaLang = $field['ReCaLang'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'caRoRe-f','Field_Order' => $order,'Field_Content' => $caFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider,'ReCaKey' => $ReCaKey,'ReCaLang' => $ReCaLang),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active, ReCaKey, ReCaLang)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d,%s,%s )
                            ",
                        '',$GalleryID,'caRoRe-f',$order,$caFieldsArray,$Show_Slider,$active,$ReCaKey,$ReCaLang
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='se'){

                $seFieldsArray = array();
                $seFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));
                $seFieldsArray['content'] = $sanitize_textarea_field(htmlentities($field['content'], ENT_QUOTES, 'UTF-8'));

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $seFieldsArray['mandatory']=sanitize_text_field($onOff);
                $seFieldsArray = serialize($seFieldsArray);

                $order = $field['order'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'select-f','Field_Order' => $order,'Field_Content' => $seFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId=$id;}

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,'select-f',$order,$seFieldsArray,$Show_Slider,$active
                    ) );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){$tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}


                }
            }

            if($field['type']=='sec'){

                $secFieldsArray = array();
                $secFieldsArray['titel']=sanitize_text_field(htmlentities($field['title'], ENT_QUOTES, 'UTF-8'));

                if(!empty($field['infoInSlider'])){
                    $Show_Slider = 1;
                }else{
                    $Show_Slider = 0;
                }

                if(!empty($field['required'])){
                    if($field['required']=='on'){
                        $onOff = 'on';
                    }else{
                        $onOff = 'off';
                    }
                }else{
                    $onOff = 'off';
                }

                if(empty($field['hide'])){
                    $active = 1;
                }else{
                    $active = 0;
                }

                $secFieldsArray['mandatory']=sanitize_text_field($onOff);
                $secFieldsArray = serialize($secFieldsArray);

                $order = $field['order'];

                if(empty($field['new'])){
                    $wpdb->update(
                        "$tablename_form_input",
                        array('GalleryID' => $GalleryID,'Field_Type' => 'selectc-f','Field_Order' => $order,'Field_Content' => $secFieldsArray,'Active' => $active,'Show_Slider' => $Show_Slider),
                        array('id' => $id),
                        array('%d','%s','%s','%s','%s','%s'),
                        array('%d')
                    );
                    if(!empty($field['infoInGallery'])){$infoInGalleryId=$id;}
                    if(!empty($field['tagInGallery'])){
                        $tagInGalleryIdIsForCategories = true;
                        $tagInGalleryId=$id;
                    }

                }
                else{

                    $wpdb->query( $wpdb->prepare(
                        "
                                INSERT INTO $tablename_form_input
                      ( id, GalleryID, Field_Type, Field_Order, Field_Content, Show_Slider,Active)
                      VALUES ( %s,%d,%s,%d,%s,%d,%d )
                            ",
                        '',$GalleryID,'selectc-f',$order,$secFieldsArray,$Show_Slider,$active
                    ) );

                    $wpdb->update(
                        "$tablename_pro_options",
                        array('ShowOther' => 1, 'CatWidget' => 1),
                        array('GalleryID' => $GalleryID),
                        array('%d','%d'),
                        array('%s')
                    );

                    if(!empty($field['infoInGallery'])){$infoInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");}
                    if(!empty($field['tagInGallery'])){
                        $tagInGalleryIdIsForCategories = true;
                        $tagInGalleryId = $wpdb->get_var("SELECT id FROM $tablename_form_input ORDER BY id DESC LIMIT 1");
                    }

                }
            }

        }

    }

    // falls Show info in gallery gesetzt wurde dann inserten
    if(!empty($infoInGalleryId)){

        $wpdb->update(
            "$tablename_options_visual",
            array('Field1IdGalleryView' => $infoInGalleryId),
            array('GalleryID' => $GalleryID),
            array('%d'),
            array('%d')
        );

        $optionsFileData['visual']['Field1IdGalleryView'] = $infoInGalleryId;

        // make json file
        $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
        $fp = fopen($optionsFile, 'w');
        fwrite($fp, json_encode($optionsFileData));
        fclose($fp);

    }else{
        $wpdb->update(
            "$tablename_options_visual",
            array('Field1IdGalleryView' => 0),
            array('GalleryID' => $GalleryID),
            array('%d'),
            array('%d')
        );

        $optionsFileData['visual']['Field1IdGalleryView'] = 0;

        // make json file
        $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
        $fp = fopen($optionsFile, 'w');
        fwrite($fp, json_encode($optionsFileData));
        fclose($fp);

    }

    // falls Show info in gallery gesetzt wurde dann inserten
    if(!empty($tagInGalleryId)){

        $wpdb->update(
            "$tablename_options_visual",
            array('Field2IdGalleryView' => $tagInGalleryId),
            array('GalleryID' => $GalleryID),
            array('%d'),
            array('%d')
        );

        $optionsFileData['visual']['Field2IdGalleryView'] = $tagInGalleryId;

        // make json file
        $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
        $fp = fopen($optionsFile, 'w');
        fwrite($fp, json_encode($optionsFileData));
        fclose($fp);

    }else{
        $wpdb->update(
            "$tablename_options_visual",
            array('Field2IdGalleryView' => 0),
            array('GalleryID' => $GalleryID),
            array('%d'),
            array('%d')
        );

        $optionsFileData['visual']['Field2IdGalleryView'] = 0;

        // make json filetagInGallery
        $optionsFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-options.json';
        $fp = fopen($optionsFile, 'w');
        fwrite($fp, json_encode($optionsFileData));
        fclose($fp);

    }

    if(!empty($_POST['cg_category'])) {

        // make json file

        $categories = $wpdb->get_results("SELECT * FROM $tablename_categories WHERE GalleryID = '$GalleryID' ORDER BY Field_Order");

        $categoriesFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-categories.json';

        $categoriesArray = array();

        foreach($categories as $category){

            if($tagInGalleryIdIsForCategories){
                 $category->isShowTagInGallery = true;
            }

            $categoriesArray[$category->id] = $category;

        }

        $fp = fopen($categoriesFile, 'w');
        fwrite($fp, json_encode($categoriesArray));
        fclose($fp);

    }else{

        $categoriesFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$GalleryID.'/json/'.$GalleryID.'-categories.json';

        $fp = fopen($categoriesFile, 'w');
        fwrite($fp, json_encode(array()));
        fclose($fp);

    }

        do_action('cg_json_upload_form',$GalleryID);
        do_action('cg_json_upload_form_info_data_files',$GalleryID,null);
        do_action('cg_json_single_view_order',$GalleryID);

        $tstampFile = $wp_upload_dir["basedir"]."/contest-gallery/gallery-id-$GalleryID/json/$GalleryID-gallery-tstamp.json";
        $fp = fopen($tstampFile, 'w');
        fwrite($fp, json_encode(time()));
        fclose($fp);


}


// input felder holen zur ausgabe
$selectFormInput = $wpdb->get_results("SELECT * FROM $tablename_form_input WHERE GalleryID = $GalleryID ORDER BY Field_Order ASC");
$rowVisualOptions = $wpdb->get_row("SELECT * FROM $tablename_options_visual WHERE GalleryID = '$GalleryID'");
$Field1IdGalleryView = $rowVisualOptions->Field1IdGalleryView;
$Field2IdGalleryView = $rowVisualOptions->Field2IdGalleryView;

?>