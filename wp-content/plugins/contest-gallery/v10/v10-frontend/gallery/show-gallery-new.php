<?php

if(!defined('ABSPATH')){exit;}

if($idDoesNotExists==1){
    return false;
}

//echo "Allow Gallery Skript:".$AllowGalleryScript;

// Zur Feststellung ob Switching aktiviert wurde. Ob mehrere Looks an sind.
$LooksCount = 0;
if($ThumbLook == 1){$LooksCount++;}
if($HeightLook == 1){$LooksCount++;}
if($RowLook == 1){$LooksCount++;}


if($AllowSort == 1 OR $LooksCount>1 or !empty($categories)){

    echo "<div class='cg_gallery_view_sort_control' >";

    if(count($orderGalleries)>1){

        echo "<div class='cg_gallery_thumbs_control'>";

        //echo "<form method='GET' action='$siteURLsort'>";
        //echo "<input type='hidden' name='".$pageIDname[0]."' value='".$pageIDvalue[0]."'>";
        //echo "<select name='1' id='select-look'>";

        $i = 0;


        foreach($orderGalleries as $key => $value){



            if($value=="ThumbLookOrder" AND $ThumbLook == 1 AND ($HeightLook == 1 or $RowLook == 1)){
                $i++;
                //echo "<option value='1' $selected_look_thumb>View $i</option>";
                //echo "<a href='$siteURL&1=1&2=".$getOrder."&3=".$start."'><img title='Thumb view' src='$selected_look_thumb' style='float:left;margin-left:5px;' /></a> ";
                echo "<img title='Thumb view' src='$look_thumb_off' data-view-cg='off' class='cg_gallery_view cg_hide' />";
                echo "<img title='Thumb view' src='$look_thumb_on' data-view-cg='on' class='cg_gallery_view' />";
            }
            if($value=="HeightLookOrder" AND $HeightLook == 1 AND ($ThumbLook == 1 or $RowLook == 1)){
                $i++;
                //echo "<option value='2' $selected_look_height>View $i</option>";
                //echo "<a href='$siteURL&1=2&2=".$getOrder."&3=".$start."'><img title='Height view' src='$selected_look_height' style='float:left;margin-left:5px;'></a> ";
                echo "<img title='Height view' src='$look_height_off' data-view-cg='off' class='cg_gallery_view cg_hide' />";
                echo "<img title='Height view' src='$look_height_on' data-view-cg='on' class='cg_gallery_view' />";
            }
            if($value=="RowLookOrder" AND $RowLook == 1  AND ($ThumbLook == 1 or $HeightLook == 1)){
                $i++;
                //echo "<option value='3' $selected_look_row>View $i</option>";
                //echo "<a href='$siteURL&1=3&2=".$getOrder."&3=".$start."'><img title='Row view' src='$selected_look_row' style='float:left;margin-left:5px;'></a> ";
                echo "<img title='Row view' src='$look_row_off' data-view-cg='off' class='cg_gallery_view cg_hide' />";
                echo "<img title='Row view' src='$look_row_on' data-view-cg='on' class='cg_gallery_view' />";
            }

        }

        //echo "<input type='hidden' name='2' value='$getOrder'>";

        //echo "<input type='hidden' name='3' value='$getStart'>";

        //echo "<input type='submit' id='change-look' style='visibility:hidden;' >";
        //echo "</form>";
        echo "&nbsp;";
        echo "</div>";

    }
    if(!empty($categories)){

        $countCategories = count($categories);
        $count = 1;

        //

        if($CatWidget==0){
            $style = "style='visibility:hidden;height:0px;'";
            $visibilityClass = " cgCatSelectAreaHidden";
        }
        else{
            $style = "";
            $visibilityClass = "";
        }

        echo "<div id='cgCatSelectArea' class='cgCatSelectArea$visibilityClass' $style >";

        foreach($categories as $category){

            $checked = '';
            if($category->Active==1){
                $checked = "checked='checked'";
                $visibility = "";
            }
            else{
                $visibility = "display:none";
            }

            $catName = $category->Name;
            $catNameClass = $catName;

            if(strpos($catName, ' ') !== false){

                $catNameClass = str_replace(" ", "_", $catName);

            }


            echo "<label class='cg_cat_checkbox_checked cg_select_cat_label' style='$visibility'>
            <span class='cg_select_cat' data-cat='cg_cat_$catNameClass'  name='Category[]' $checked data-value='".$category->id."' style='visibility:hidden;'>$catName</span>
            <span class='cg_select_cat_check_icon'></span>
            </label>";

            if($count==$countCategories){

                $checked = '';
                if($ShowOther==1){
                    $checked = "checked='checked'";
                    $visibility = "";
                }
                else{
                    $visibility = "display:none";
                }

                echo "<label class='cg_cat_checkbox_checked cg_select_cat_label' style='$visibility'> 
                <span class='cg_select_cat' name='Category[ShowOther]' data-cat='cg_cat_other_cg_gal' data-value='0' $checked style='visibility:hidden;'>$catName</span>
                <span>$language_Other</span>
                <span class='cg_select_cat_check_icon'></span>
                </label> ";
            }

            $count++;

        }

        echo "</div>";

    }




    if($AllowSort == 1){

//echo "<br>siteURL: $siteURL<br>";
//echo "<br>siteURLsort: $siteURLsort<br>";
//echo "<br>getLook: $getLook<br>";
        echo "<div class='cg_sort_div'>";

        ?>
        <form style='' class="cg_sort_form" method="GET" action="<?php echo $siteURLsort; ?>">
        <input type="hidden" name="<?php echo @$pageIDname[0]; ?>" value="<?php echo @$pageIDvalue[0]; ?>">
        <input type="hidden" name="1" value="<?php echo @$getLook; ?>" id="cg_sort_images_look">
        <input type="hidden" name="1" value="<?php echo @$getLook; ?>" id="cg_sort_images_look">
        <select name="2" id="cg_select_order">
            <?php  if(@$RandomSort==1){ ?>
                <option value="7" <?php echo $selected_random_sort; ?> id="cg_random_sort"><?php echo $language_RandomSortSorting; ?></option>
                <?php
            }
            ?>
            <option <?php echo $selected_date_desc; ?> value="1" id="cg_date_descend" ><?php echo $language_DateDescend; ?></option>
            <option value="2" <?php echo $selected_date_asc; ?> id="cg_date_ascend" ><?php echo $language_DateAscend; ?></option>
            <option value="3" <?php echo $selected_comment_desc; ?> id="cg_comments_descend"><?php echo $language_CommentsDescend; ?></option>
            <option value="4" <?php echo $selected_comment_asc; ?> id="cg_comments_ascend" ><?php echo $language_CommentsAscend; ?></option>
            <?php  if(@$HideUntilVote!=1 AND $ShowOnlyUsersVotes!=1){ ?>
                <option value="5" <?php echo $selected_rating_desc; ?> id="cg_rating_descend"><?php echo $language_RatingDescend; ?></option>
                <option value="6" <?php echo $selected_rating_asc; ?> id="cg_rating_ascend"><?php echo $language_RatingAscend; ?></option>
                <?php
            }
            ?>
        </select>
        <?php

//echo <<<HEREDOC

        echo "<input type='hidden' name='3' value='$getStart'/>";

        echo "<input type='submit' id='cg_change_order' style='display:none;'/>";
        echo "</form>";

        echo "</div>";
    }

    $nr1 = $start + 1;

    // Nur dann anzeigen wenn wenn Anzahl der Bilder gr��er ist als die eignestellte Anzahl pro Seite
    if($count_pics>$PicsPerSite){

        echo "<div class='cg_further_images_container $cgFeControlsStyle' >";


        //echo "<br>siteURL: $siteURL<br>";
        //echo "<br>Start: $startOld<br>";
        //  echo "<br>step: $step<br>";
        //echo "<br>rows: $rows<br>";




        for ($i = 0; $rows > $i; $i = $i + $step) {
            $anf = $i + 1;
            $end = $i + $step;

            if ($end > $rows) {
                $end = $rows;
            }

            if ($anf == $nr1 AND ($start+$step) > $rows AND $start==0) {$start = $i;
                continue;
                //       echo "<div class='cg_further_images'>[ <strong><u><a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></u></strong> ]</div>";
            }

            elseif ($anf == $nr1 AND ($start+$step) > $rows AND $anf==$end) {$start = $i;

                echo "<div class='cg_further_images cg_further_images_selected'> <a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></div>";
            }


            elseif ($anf == $nr1 AND ($start+$step) > $rows) {$start = $i;

                echo "<div class='cg_further_images cg_further_images_selected'> <a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></div>";
            }

            elseif ($anf == $nr1) {$start = $i;
                echo "<div class='cg_further_images cg_further_images_selected'> <a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></div>";
            }

            elseif ($anf == $end) {$start = $i;

                $startCum = $startOld+$step+1;
                $startOldPlusOne = $startOld+1;
                $startCumPlusOne = $startCum+1;

                if($startCum==$anf){
                    $queue = 44;

                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($startCumPlusOne==$anf){
                    $queue = 4;

                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($stepPlusOne==$anf && $startOld!=0){
                    $queue = 0;
                    $id = $firstObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($stepPlusOne==$anf){
                    $queue = 1;
                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($startOld==$end){
                    $queue = 2;

                    $id = $firstObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($startCum==$end){
                    $queue = 3;

                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }

                echo "<div class='cg_further_images'><a data-hash='$idHashed' href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin'>$anf-$end</a> </div>";
            }

            else {$start = $i;

                $startCum = $startOld+$step+1;
                $startOldPlusOne = $startOld+1;
                $startCumPlusOne = $startCum+1;

                if($startCum==$anf){
                    $queue = 44;

                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($startCumPlusOne==$anf){
                    $queue = 4;

                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($stepPlusOne==$anf && $startOld!=0){
                    $queue = 0;
                    $id = $firstObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($stepPlusOne==$anf){
                    $queue = 1;
                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($startOld==$end){
                    $queue = 2;

                    $id = $firstObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }
                elseif($startCum==$end){
                    $queue = 3;

                    $id = $lastObjectPicsSQL->id;
                    $idHashed = ($id+8)*2+100000;
                }

                // echo "<div  class='cg_further_images'>[startOldPlusOne: $startOldPlusOne startCumPlusOne: $startCumPlusOne Anf: $anf End: $end  Step:$step StartOld:$startOld   startCum:$startCum  StepOne: $stepPlusOne Queue: $queue <a data-hash='$idHashed' href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin'>$anf-$end</a> ]</div>";
                echo "<div  class='cg_further_images'><a data-hash='$idHashed' href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin'>$anf-$end</a> </div>";
            }

        }


// Formular zum �bertragen von Hidden Werten





        echo "</div>";

    }



    echo "</div>";

}




echo "<br/>";

$cg_unix_time = time();

// Check back button click
echo "<input type='hidden' id='cg_check_load_time' value=''/>";

// Pr�fen ob rechter Pfeil gerade geklickt wurde
echo "<input type='hidden' id='cg_check_arrow_right_click' value='0'/>";

// Pr�fen ob linker Pfeil gerade geklickt wurde
echo "<input type='hidden' id='cg_check_arrow_left_click' value='0'/>";

// Sobald Ende erreicht wurde wird hier eine 1 eingetragen
echo "<input type='hidden' id='cg_all_images_loaded' value='0'/>";

// Eintragen wieviel Bilder schon geladen wurden, wenn pagination aktiviert ist
echo "<input type='hidden' id='cg_pagination_position_count' value='0'/>";

// Wenn pagination an ist, dann muss der erste Width Wert hier eingetragen werden
echo "<input type='hidden' id='cg_widthMainCGallery' value='0'/>";

// Den Abstand von links des erschienen Divs bei Thumb View pr�fen
echo "<input type='hidden' id='cg_offset_div_thumb_view' value='0'/>";

echo "<input type='hidden' id='cg_DistancePicsX_Live' value='0'/>";
echo "<input type='hidden' id='cg_DistancePicsV_Live' value='0'/>";
echo "<input type='hidden' id='cg_WidthThumb_Live' value='0'/>";

// Pr�fen ob die gallery gerade resized wird
echo "<input type='hidden' id='cg_gallery_resize' value='0'/>";

// Zum Pr�fen ob gecachte Seite geladen wurde
echo "<input type='hidden' id='cg_timestamp_php' value='$cg_unix_time'/>";

// Felder f�r Slider

// Pr�fen ob der gesamte DOM im Slider geladen ist oder nicht
echo '<img id="cg_sliderClickIfFacebook" src="#" style="display: none;" />';

// Pr�fen ob der gesamte DOM im Slider geladen ist oder nicht
echo "<input type='hidden' id='cg_sliderDOMloaded' value=''/>";

// Eintragen der Left position des div#imgContainer sobald der ganze DOM geladen ist
echo "<input type='hidden' id='cg_leftPositionImgContainer' value=''/>";

// Pr�fen welche Fenster Breite bei der letzten Berechnung war
echo "<input type='hidden' id='widthCGoverlay_old' value=''/>";

// Eintragen der aktuellen Breite des Sliders ImgContainers
echo "<input type='hidden' id='widthCGimgContainerAggregated' value='0'/>";

// Pr�fen ob Fenster gerade resized wird
echo "<input type='hidden' id='cg_slider_resize' value=''/>";

// Feld zum Speichern der Nummer des aktuellen Bildes im Slider
echo "<input type='hidden' id='cg_actual_slider_class_value' value=''/>";

// Feld zum Speichern der Nummer des gerade vergangenen Bildes im Slider
echo "<input type='hidden' id='cg_slider_class_value_before' value=''/>";

// Feld zum speichern der id des aktuellen Bildes im Slider
echo "<input type='hidden' id='cg_actual_slider_img_id' value=''/>";

// Pr�fen ob Slider Frame reloaded wurde
echo "<input type='hidden' id='cg_slider_frame_reloaded' value='0'/>";

// Pr�fen ob Gallery Frame reloaded wurde
echo "<input type='hidden' id='cg_gallery_frame_reloaded' value='1'/>";

// Offset des ersten Bildes welches an der Reihe ist zu landen
echo "<input type='hidden' id='firstImageOffset' value='0'/>";

// Felder zur Pr�fung obs mousedown oder mouseup ist
echo "<input type='hidden' id='cg_slider_mousedown' value=''/>";
echo "<input type='hidden' id='cg_slider_mouseup' value=''/>";
echo "<input type='hidden' id='cg_slider_check_mouse' value=''/>";

// Felder zum Speichern dex X Wertes beim Slider Mousedown und Mouseup
echo "<input type='hidden' id='cg_x_value_mousedown_e_page' value=''/>";
echo "<input type='hidden' id='cg_x_value_mousedown_left_margin' value=''/>";
echo "<input type='hidden' id='cg_x_value_mousedown_mousemove' value=''/>";
echo "<input type='hidden' id='cg_x_value_mouseup' value=''/>";
echo "<input type='hidden' id='cg_x_value_mouseup_e_page' value=''/>";

// Pr�fen ob nur Klick event war oder Maus auch gehalten wurde
echo "<input type='hidden' id='cg_allow_mouse_release' value='0'/>";


// Pr�fen ob Rating geklickt wurde und AJAX call l�dt
echo "<input type='hidden' id='cg_rating_ajax_call' value='0'/>";

// Pr�fen touchstart beim touch slider event. Zur Pr�fung der Distanz.
echo "<input type='hidden' id='cg_slider_touchstart' value=''/>";
echo "<input type='hidden' id='cg_slider_touchend' value=''/>";

// Zur Pr�fung ob losgelassen wurde
echo "<input type='hidden' id='cg_slider_release_toch' value=''/>";

// Pr�fen ob ein hide until vote Feld gerade geklickt wurde
echo "<input type='hidden' id='cg_hide_until_vote_actual' value='0'/>";


echo '<input type="hidden" value="193" id="cg_slider_comment_picture_id">'; // Aktuelle picture ID des Comments
echo '<input type="submit" value="" id="cg_open_slider_comment" style="display:none;">'; // Aktuelle picture ID des Comments

echo '<input type="submit" value="" id="check_mobile" style="display:none;">'; // Pr�fen ob mobile oder nicht
echo '<input type="submit" value="" id="cg_slider_comments_elemens_width" style="display:none;">'; // Breite der Comments area f�r mobile Ger�te

echo "<input type='hidden' id='cg_slider_comment_check' value='".@$check."'>";

// Selbes Feld wie in show-image.php
echo "<input type='hidden' id='cg_ThankYouComment' value='Thank you for your comment'>";

echo "<input type='hidden' id='cg_comment_name_characters' value='$language_TheNameFieldMustContainTwoCharactersOrMore.'>";
echo "<input type='hidden' id='cg_comment_comment_characters' value='$language_TheCommentFieldMustContainThreeCharactersOrMore.'>";
echo "<input type='hidden' id='cg_comment_not_a_robot' value=' $language_PlzCheckTheCheckboxToProveThatYouAreNotArobot.'>";


// Feld zum Speichern des maxmimal m�glichen X wert beim. Wenn ganz nach links gedraggt wird (zum Anfang).
echo "<input type='hidden' id='cg_first_left_slider' value=''/>";

// Feld zum Speichern des minmal m�glichen X wert beim. Wenn ganz nach rechts gedraggt wird (zum letzten Bild).
echo "<input type='hidden' id='cg_last_left_slider' value=''/>";


echo "<div id='cg_ThePhotoContestIsOver_dialog' style='display:none;' class='cg_show_dialog'><p>$language_ThePhotoContestIsOver</p></div>";
echo "<div id='cg_AlreadyRated_dialog' style='display:none;' class='cg_show_dialog'><p>$language_YouHaveAlreadyVotedThisPicture</p></div>";
echo "<div id='cg_AllVotesUsed_dialog' style='display:none;' class='cg_show_dialog'><p>$language_AllVotesUsed</p></div>";

echo "<input type='hidden' id='cg_photo_contest_is_over_ajax_request' value='0'>";



echo '<div id="cg_slider_main_div">';


// NEW Slider development here

//$AllowGalleryScript = 2;

$thumbnail_size_w = get_option("thumbnail_size_w");
$medium_size_w = get_option("medium_size_w");
$large_size_w = get_option("large_size_w");


if($thumbnail_size_w>=400){
    $wpCgSize = 'thumbnail';
}
else if($medium_size_w>=400){
    $wpCgSize = 'medium';
}
else if($large_size_w>=400){
    $wpCgSize = 'large';
}
else{
    $wpCgSize = 'full';
}


if($AllowGalleryScript==1){

    echo <<<HEREDOC

    <div id='cg-carrousel-slider'>
        <div id='cg-carrousel-slider-content'>
HEREDOC;

    $r = 0;
    foreach($picsSQL as $value) {

        $r++;

        $id = $value->id;
        $rowid = $value->rowid;
        $Timestamp = $value->Timestamp . '_';
        $NamePic = $value->NamePic;
        $ImgType = $value->ImgType;
        $rating = $value->Rating;
        $countR = $value->CountR;
        $countC = $value->CountC;
        $countS = $value->CountS;
        $widthOriginalImg = $value->Width;
        $heightOriginalImg = $value->Height;
        $WpUpload = $value->WpUpload;
        $rThumb = $value->rThumb;
        $imageCategory = $value->Category;

        $imgSrc=wp_get_attachment_image_src($WpUpload, $wpCgSize);
        $imgSrc=$imgSrc[0];

        $cgImageThumbRotation = "cg".$rThumb."degree";


        if(!empty($categories)){
            $categoryClass = 'cg_cat_other_cg_gal';
            foreach($categories as $category){
                if($imageCategory==$category->id){

                    $categoryClass = 'cg_cat_'.$category->Name;

                    if(strpos($categoryClass, ' ') !== false){

                        $categoryClass = str_replace(" ", "_", $categoryClass);

                    }

                }
            }
        }


// cg_hide Klasse ist die Div Box zum Hovern
        echo <<<HEREDOC
            <div class='cg_image$r cg-carrousel-img cg_visible $categoryClass' data-cg_image_id="$id" id="cg-carrousel-container-id-$id">
                <input type="hidden" class="widthOriginalImg" value="$widthOriginalImg">
                <input type="hidden"" class="heightOriginalImg" value="$heightOriginalImg">
                <input type="hidden" value="$rThumb" class="cg_carrousel_image_thumb_rotation">
                <img src="$imgSrc" class="cg_image$r $cgImageThumbRotation" data-cg_image_id="$id" id="cg-carrousel-image-$id">
            </div>
HEREDOC;



    }


    echo <<<HEREDOC
        </div>
     </div>

HEREDOC;

// NEW Slider development here --- ENDE

}

$AllowGalleryScript = 1;


echo '<div id="cg_slider_arrow_left"><img id="cg_slider_arrow_left_img" src="'.$cg_slider_arrow_left.'?800" style="display:none;"></div>';
echo '<div id="cg_slider_arrow_right"><img id="cg_slider_arrow_right_img" src="'.$cg_slider_arrow_right.'?800" style="display:none;"></div>';
echo '<div id="cg_slider_arrow_left_next_page"><img id="cg_slider_arrow_left_img_next_page" src="'.$cg_slider_arrow_left_next_page.'?800" style="display:none;"></div>';
echo '<div id="cg_slider_arrow_right_next_page"><img id="cg_slider_arrow_right_img_next_page" src="'.$cg_slider_arrow_right_next_page.'?800" style="display:none;"></div>';
echo '<div id="cg_slider_arrow_fade_in_user_input"><img class="cg_slider_arrow_fade_in_user_input_img" src="'.$cg_slider_arrow_fade_in_user_input.'?800" style="width:100% ;height:100% ; display:none;"></div>';
echo '<div id="cg_slider_arrow_fade_out_user_input"><img class="cg_slider_arrow_fade_out_user_input_img" src="'.$cg_slider_arrow_fade_out_user_input.'?800" style="width:100% ;height:100% ;display:none;"></div>';
echo '<div id="close_slider_button"><img id="close_slider_button_img" src="'.$cg_slider_button.'?800" style="width:100% ;height:100% ;display:none;"></div>';
echo '<div id="cg_slider_full_size_view_icon_div"><img id="cg_slider_full_size_view_icon_img" src="'.$cg_slider_full_size_view_icon.'?800" style="width:100% ;height:100% ;"></div>';
echo '<div id="cg_slider_exit_full_size_view_icon_div"><img class="cg_slider_exit_full_size_view_icon_img" src="'.$cg_slider_exit_full_size_view_icon.'?800" style="width:100% ;height:100% ;"></div>';
echo '<div id="cg_slider_download_full_size_icon_div"><a href="" target="_blank" ><img id="cg_slider_download_full_size_icon_img" src="'.$cg_slider_download_full_size_icon.'?800"  style="width:100% ;height:100% ;"></a></div>';
echo '<div id="cg_slider_full_screen_icon_div"><img class="cg_slider_enter_full_screen"  id="cg_slider_full_screen_icon_img" src="'.$cg_slider_full_screen_icon.'?800"  style="width:100% ;height:100% ;"></div>';
echo '<div id="cg_slider_exit_full_screen_icon_div"><img id="cg_slider_exit_full_screen_icon_img"  src="'.$cg_slider_exit_full_screen_icon.'?800"  style="width:100% ;height:100% ;"></div>';




echo '<div id="cg_overlay"></div>';
echo '<div id="imgContainer" class="imgContainer"></div>';

// Felder f�r Slider --- ENDE

// Comments Div f�r Slider

echo '<div id="cg_comments_slider_div" style="display:none;">';



echo '<div id="cg_comments_slider_inner_div" style="width:90%;margin: 0px auto;">';

echo '<div id="close_slider_comments_button"><img id="close_slider_comments_button_img" src="'.$cg_slider_button.'" style="width:100% ;height:100% ;display:none;"></div>';
echo "<p style='text-align:center;font-size:22px;padding-top:30px;color:#fff;font-weight:bold;opacity: 1;' id='cg_picture_comments_single_view'>$language_PictureComments</p>";
echo "<div id='cg_slider_top_hr_div'>";
echo "<hr  style='margin-left:0px;' id='cg_picture_comments_single_view_hr' />";
echo '</div>';
// Response div f�r AJAX call
echo "<div id='show_comments_slider' >";

echo '</div>';

$unix = time();


echo "<div id='cg_slider_comment_hint_msg' style='color:#fff;font-weight:normal;font-size:18px;'>";
echo "</div>";

echo "<p style='padding-top:30px;color:#fff;font-weight:bold;font-size:22px;line-height:22px;padding-bottom:0px;margin-bottom:0px;' id='cg_your_comment_single_view'><strong>$language_YourComment:</strong></p>";
echo '<input type="hidden" name="Timestamp" value="'.@$unix.'" id="cg_slider_comment_timestamp">';
echo "<p style='line-height:18px;margin:0px;padding:0px;'>&nbsp;</p>";
echo "<div id='cg_your_comment_name_single_view' style='font-size:18px;font-weight:bold;color:#fff;'><label for='cg_slider_comment_name'>$language_Name:</label></div>";
echo '<p style="line-height:18px;margin:0px;padding:0px;"><input type="text" name="Name" style="width:100%;" id="cg_slider_comment_name"></p>';
echo "<p style='line-height:18px;margin:0px;padding:0px;'>&nbsp;</p>";
echo "<div id='cg_your_comment_comment_single_view'  style='font-size:18px;font-weight:bold;color:#fff;'><label for='cg_slider_comment'>$language_Comment:</label></div>";
echo '<p style="margin:0px;padding:0px;"><textarea style="width:100%;" rows="5" name="Comment" id="cg_slider_comment">';
echo "</textarea></p>";
echo "<p style='line-height:18px;margin:0px;padding:0px;'>&nbsp;</p>";
echo '<p id="cg_i_am_not_a_robot" style="font-weight:bold;font-size:18px;width:300px;color:#fff;line-height:18px;"></p>';
echo "<p style='line-height:18px;margin:0px;padding:0px;'>&nbsp;</p>";
echo "<p style='line-height:18px;margin:0px;padding:0px;color: white;'>";
echo '<input type="submit" value="'.$language_Send.'" name="Submit" id="cg_slider_comment_submit" style="font-size:18px;line-height:18px;">';
echo "</p>";
echo "<p style='line-height:18px;margin:0px;padding:0px;'>&nbsp;</p>";
echo "</div>";
echo "</div>";

echo "<div style='visibility:hidden;margin:0;padding:0;height:0px !important;'>";
echo '<label for="Email">Don\'t fill this field, your email will not be asked.</label>';
echo '<input id="cg_slider_comment_email" name="Email" size="60" value="" />';
echo '</div>';

echo '</div>';


?>
    <noscript>
        <div style="border: 1px solid purple; padding: 10px">
            <span style="color:red">Enable Javascript to see the gallery</span>
        </div>
    </noscript>
<?php


//Bestimmung des dir upload folders zur sp�teren Erkennung


$cg_uploadFolder_dir = wp_upload_dir();

$cg_upload_dir = $cg_uploadFolder_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'';


//Bestimmung des dir upload folders zur sp�teren Erkennung --- ENDE

$checkSumOfElementsWidth = 0;//wurd gebraucht f�r Thumb Look
$checkFirstTimeWholeWidth = 0;
$aggregateWidth = 0;// wird gebrauht f�r Thumb Look
echo "<input type='hidden' class='aggregateWidth' value='$aggregateWidth'>";// Hidden Feld zum sammeln und abrufen von aggregateWidth �ber Jquery, wird gebrauht f�r Thumb Look
echo "<input type='hidden' class='checkFirstTimeWholeWidth' value='$checkFirstTimeWholeWidth'>";// �berpr�fen ob die erste Zeile der Bilder schon verarbeitetet wurde


//echo "<br>height:$look<br>";
// Sicherheitshalber falls js falsch �bergeben wurde und falsche werte gespeichert wurden
if($look=="height" or $look=="thumb" or $look=="row"){
    $look=$look;
}
else{
    $look='height';
}

$Version = 10;

if ($look=='thumb' and $Version <10){
    include('thumb-logic.php');
}
// Thumb Ansicht anzeigen ---- ENDE

$SameHeightLook=1;

// ROW Ansicht anzeigen

if($look=='row' and $Version <10){
    include('row-logic.php');
}

// Same Height Look

if($look=='height' and $Version <10){
    include('height-logic.php');
}

if($Version >=10){
    echo "<div id='mainCGallery' class='mainCGallery' >";



        //  include('height-logic.php');

      //  include('height-logic.php');
    echo "</div>";
}




// Zeige Galerie. Abfrage Bildertabelle. ---END---

/*
// Gesammelte IDs die durch RandomSort generiert wurden in eine Session speichern
if($RandomSort==1){

    $cgRandomOrderAllIdsResult = substr($cgRandomOrderAllIdsResult,0,-1);
    print_r($cgRandomOrderAllIdsResult);
    setcookie("cg_random_sort_cookie", $cgRandomOrderAllIdsResult, time() + (86400 * 30), COOKIEPATH ); // 86400 = 1 day

}
// Gesammelte IDs die durch RandomSort generiert wurden in eine Session speichern --- ENDE */






echo "<br/>";

// Nur dann anzeigen wenn wenn Anzahl der Bilder gr��er ist als die eignestellte Anzahl pro Seite
if($count_pics>$PicsPerSite){

    echo "<div class='cg_further_images_container $cgFeControlsStyle' >";

    //echo "<br>siteURL: $siteURL<br>";
    //echo "<br>Start: $startOld<br>";
    //  echo "<br>step: $step<br>";
    //echo "<br>rows: $rows<br>";

    for ($i = 0; $rows > $i; $i = $i + $step) {
        $anf = $i + 1;
        $end = $i + $step;

        if ($end > $rows) {
            $end = $rows;
        }

        if ($anf == $nr1 AND ($start+$step) > $rows AND $start==0) {$start = $i;
            continue;
            //       echo "<div class='cg_further_images'>[ <strong><u><a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></u></strong> ]</div>";
        }

        elseif ($anf == $nr1 AND ($start+$step) > $rows AND $anf==$end) {$start = $i;

            echo "<div class='cg_further_images cg_further_images_selected'> <a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></div>";
        }


        elseif ($anf == $nr1 AND ($start+$step) > $rows) {$start = $i;

            echo "<div class='cg_further_images cg_further_images_selected'> <a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></div>";
        }

        elseif ($anf == $nr1) {$start = $i;
            echo "<div class='cg_further_images cg_further_images_selected'> <a href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin' id='cg_further_images_active'>$anf-$end</a></div>";
        }

        elseif ($anf == $end) {$start = $i;

            $startCum = $startOld+$step+1;
            $startOldPlusOne = $startOld+1;
            $startCumPlusOne = $startCum+1;

            if($startCum==$anf){
                $queue = 44;

                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($startCumPlusOne==$anf){
                $queue = 4;

                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($stepPlusOne==$anf && $startOld!=0){
                $queue = 0;
                $id = $firstObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($stepPlusOne==$anf){
                $queue = 1;
                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($startOld==$end){
                $queue = 2;

                $id = $firstObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($startCum==$end){
                $queue = 3;

                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }

            echo "<div class='cg_further_images'><a data-hash='$idHashed' href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin'>$anf-$end</a> </div>";
        }

        else {$start = $i;

            $startCum = $startOld+$step+1;
            $startOldPlusOne = $startOld+1;
            $startCumPlusOne = $startCum+1;

            if($startCum==$anf){
                $queue = 44;

                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($startCumPlusOne==$anf){
                $queue = 4;

                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($stepPlusOne==$anf && $startOld!=0){
                $queue = 0;
                $id = $firstObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($stepPlusOne==$anf){
                $queue = 1;
                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($startOld==$end){
                $queue = 2;

                $id = $firstObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }
            elseif($startCum==$end){
                $queue = 3;

                $id = $lastObjectPicsSQL->id;
                $idHashed = ($id+8)*2+100000;
            }

            // echo "<div  class='cg_further_images'>[startOldPlusOne: $startOldPlusOne startCumPlusOne: $startCumPlusOne Anf: $anf End: $end  Step:$step StartOld:$startOld   startCum:$startCum  StepOne: $stepPlusOne Queue: $queue <a data-hash='$idHashed' href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin'>$anf-$end</a> ]</div>";
            echo "<div  class='cg_further_images'><a data-hash='$idHashed' href='$siteURL&1=".$getLook."&2=".$getOrder."&3=".$start."#cg-begin'>$anf-$end</a> </div>";
        }

    }


// Formular zum �bertragen von Hidden Werten





    echo "</div>";

}
// Muss sein, mit clear both und float left innen drin, damit man upload formular oder weitere div boxen drunter setzen kann
echo "<div class='cg_clear_both' style='clear:both;>";
echo "<div style='display:inline;float:left;margin:0;height:0;padding:0;'></div>";
echo "</div>";




/*


	for ($i = 0; $rows > $i; $i = $i + $step) {
	  $anf = $i + 1;
	  $end = $i + $step;

	  if ($end > $rows) {
		$end = $rows;
	  }

		if ($anf == $nr1 AND ($start+$step) > $rows AND $start==0) {
	    continue;
		echo "<div style='display:inline;float:left;'>[ <strong><a href='$siteURL"."start=$i"."&choose=$rowImages&look=$look'>$anf-$end</a></strong> ]</div>";
	  }

	  	 elseif ($anf == $nr1 AND ($start+$step) > $rows AND $anf==$end) {

		echo "<div style='display:inline;float:left;'>[ <strong><a href='$siteURL"."start=$i"."&choose=$rowImages&look=$look'>$end</a></strong> ]</div>";
	  }


	    elseif ($anf == $nr1 AND ($start+$step) > $rows) {

		echo "<div style='display:inline;float:left;'>[ <strong><a href='$siteURL"."start=$i"."&choose=$rowImages&look=$look'>$anf-$end</a></strong> ]</div>";
	  }

		elseif ($anf == $nr1) {
			echo "<div style='display:inline;float:left;'>[ <strong> <a href='$siteURL"."start=$i"."&choose=$rowImages&look=$look'>$anf-$end</a></strong> ]</div>";
	  }

	  	elseif ($anf == $end) {
		echo "<div style='display:inline;float:left;'>[ <a href='$siteURL"."start=$i"."&choose=$rowImages&look=$look'>$end</a>  ]</div>";
	  }

	  else {
		echo "<div style='display:inline;float:left;'>[ <a href='$siteURL"."start=$i"."&choose=$rowImages&look=$look'>$anf-$end</a>  ]</div>";
	  }
	 }



*/

?>