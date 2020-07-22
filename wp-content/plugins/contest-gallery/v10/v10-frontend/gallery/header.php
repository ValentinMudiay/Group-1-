<?php

// View order here

//$selectGalleryLookOrder = $wpdb->get_results( "SELECT ThumbLookOrder, HeightLookOrder, RowLookOrder  FROM $tablenameOptions WHERE id = '$galeryID'" );

$ThumbLookOrder = $options['general']['ThumbLookOrder'];
$HeightLookOrder = $options['general']['HeightLookOrder'];
$RowLookOrder = $options['general']['RowLookOrder'];
$SliderLookOrder = $options['general']['SliderLookOrder'];
$ContestEnd = $options['general']['ContestEnd'];
$ContestEndTime = $options['general']['ContestEndTime'];
$AllowSort = $options['general']['AllowSort'];
$FullSizeGallery = $options['general']['FullSizeGallery'];// full window mode
$FullSize = $options['general']['FullSize'];// full window mode
$FullScreenGallery = 0;
$Search = $options['pro']['Search'];
$GalleryUpload = $options['pro']['GalleryUpload'];

if(empty($options['visual']['AllowSortOptions'])){
    $AllowSortOptionsArray = explode(',','date-desc,date-asc,rate-desc,rate-asc,rate-average-desc,rate-average-asc,comment-desc,comment-asc,random');
}else{
    if(strpos($options['visual']['AllowSortOptions'],',')!==false){
        $AllowSortOptionsArray = explode(',',$options['visual']['AllowSortOptions']);
    }else{
        $AllowSortOptionsArray = array();
        $AllowSortOptionsArray[] = $options['visual']['AllowSortOptions'];
    }
}

if(!$isUserGallery && !empty($options['pro']['GalleryUploadOnlyUser'])){
    $GalleryUpload = 0;
}

$isInGalleryUpload = false;

if(($GalleryUpload==1 && !$isUserGallery) OR ($GalleryUpload==1 && $isUserGallery && is_user_logged_in())){
    $isInGalleryUpload = true;
}


// Reihenfolge der Gallerien wird ermittelt

$orderGalleries = array($SliderLookOrder =>'SliderLookOrder', $ThumbLookOrder =>'ThumbLookOrder', $HeightLookOrder => 'HeightLookOrder', $RowLookOrder => 'RowLookOrder');

ksort($orderGalleries);

/* categorien werden aus json jetzt geprüft
// Kategorien werden erstellt
$categories = $wpdb->get_results( "SELECT * FROM $tablename_categories WHERE GalleryID = '$galeryID' ORDER BY Field_Order" );

echo "<pre>";
print_r($categories);
echo "</pre>";

$categoriesCheck = 0;

foreach($categories as $category){
    if($category->Active==1 && $CatWidget==1){
        $categoriesCheck = 1;
    }
}
*/
//var_dump($orderGalleries);

/*if(@$selectGalleryLookOrder){
    foreach($selectGalleryLookOrder[0] as $key => $value){

        @$orderGalleries[$value]=$key;

    }
}*/



?>
    <script>
        var index = <?php echo json_encode($galeryIDuser) ?>;
        cgJsData[index].vars.orderGalleries = <?php echo json_encode($orderGalleries) ?>;

    </script>


<?php
//echo 'LooksCount<br>';
//var_dump($LooksCount);
//var_dump($orderGalleries);

if($GalleryUpload==1 OR $AllowSort == 1 OR $LooksCount>1 or !empty($categories) or $Search==1 or $FullSizeGallery==1 OR $options['general']['RandomSortButton']==1){

    if($GalleryUpload==1 OR $AllowSort == 1 OR $LooksCount>1 or $FullSizeGallery==1 OR $options['general']['RandomSortButton']==1 or $Search==1 ){

        echo "<div class='cg_gallery_view_sort_control' id='cgGalleryViewSortControl$galeryIDuser' >";

        $pluginsUrl = plugins_url();

        echo "<div class='cg_sort_div'>";
        if($isInGalleryUpload){

            echo "<div class='cg-gallery-upload cg_gallery_control_element $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";

            echo "</div>";
        }

        if($AllowSort == 1 OR $options['general']['RandomSortButton']==1){

            if($AllowSort == 1){

                $selected = '';
                echo '<select id="cg_select_order'.$galeryIDuser.'" class="cg_select_order cg_gallery_control_element '.$cgFeControlsStyle.'">';

                if(in_array('date-desc',$AllowSortOptionsArray)){
                    echo '<option value="1" class="cg_date_descend" '.$selected.'>'.$language_DateDescend.'</option>';
                }

                if(in_array('date-asc',$AllowSortOptionsArray)){
                    echo '<option value="2"  class="cg_date_ascend" '.$selected.'>'.$language_DateAscend.'</option>';
                }

                // if($options['general']['RandomSortButton']==1){
             if($options['general']['HideUntilVote']!=1){
                        if($options['general']['AllowRating']==2 || ($options['pro']['IsModernFiveStar']==0 && $options['general']['AllowRating']==1)){
                            if(empty($isOnlyGalleryNoVoting)){
                                if(in_array('rate-desc',$AllowSortOptionsArray)){
                                    echo '<option value="5" class="cg_rating_descend" '.$selected.'>'.$language_RatingDescend.'</option>';
                                }
                                if(in_array('rate-asc',$AllowSortOptionsArray)){
                                    echo '<option value="6"  class="cg_rating_ascend" '.$selected.'>'.$language_RatingAscend.'</option>';
                                }
                            }
                        }
                        if((!empty($options['pro']['IsModernFiveStar']) && $options['general']['AllowRating']==1)){
                            if(empty($isOnlyGalleryNoVoting)){

                                if(in_array('rate-desc',$AllowSortOptionsArray)){
                                    echo '<option value="5" class="cg_rating_descend" '.$selected.'>'.$language_RatingDescend.'</option>';
                                }
                                if(in_array('rate-asc',$AllowSortOptionsArray)){
                                    echo '<option value="6"  class="cg_rating_ascend" >'.$language_RatingAscend.'</option>';
                                }

                                if(in_array('rate-average-desc',$AllowSortOptionsArray)){
                                    echo '<option value="8" class="cg_rating_descend_average" '.$selected.'>'.$language_RatingAverageDescend.'</option>';
                                }

                                if(in_array('rate-average-asc',$AllowSortOptionsArray)){
                                    echo '<option value="9"  class="cg_rating_ascend_average" '.$selected.'>'.$language_RatingAverageAscend.'</option>';
                                }

                            }
                        }
                    }

                // if($options['general']['RandomSortButton']==1){
                    if($options['general']['AllowComments']==1){

                        if(in_array('comment-desc',$AllowSortOptionsArray)){
                            echo '<option value="3" class="cg_comments_descend" '.$selected.'>'.$language_CommentsDescend.'</option>';
                        }

                        if(in_array('comment-asc',$AllowSortOptionsArray)){
                            echo '<option value="4"  class="cg_comments_ascend" '.$selected.'>'.$language_CommentsAscend.'</option>';
                        }

                    }
                    if(in_array('random',$AllowSortOptionsArray)){

                        if($options['general']['RandomSort']==1){
                            $selected = 'selected';
                        }

                        echo '<option value="7"  class="cg_random_sort" '.$selected.'>'.$language_RandomSortSorting.'</option>';
                    }



                echo '</select>';

            }

            if($options['general']['RandomSortButton']==1){
                echo "<div class='cg-lds-dual-ring $cgFeControlsStyle cg_gallery_control_element'></div>";
                echo "<span class='cg_random_button cg_hide cg_gallery_control_element $cgFeControlsStyle' data-cg-gid='$galeryIDuser'></span>";
            }

        }

        if($Search==1){
            echo "<div id='cgSearchInputDiv$galeryIDuser' class='cg_search_input_div cg_gallery_control_element $cgFeControlsStyle'>";
            echo "<input type='text' id='cgSearchInput$galeryIDuser' class='cg_search_input' data-cg-gid='$galeryIDuser' />";
            echo "</div>";
        }

        echo "</div>";


        echo "</div>";

    }


    echo "<div class='cg_thumbs_and_categories_control cg_gallery_control_element'>";


    include('categories-container.php');


    if(count($orderGalleries)>1){

        $showThumbsControl = false;

        foreach($orderGalleries as $key => $value){

            if($value=="SliderLookOrder" AND $options['general']['SliderLook'] == 1 AND ($options['general']['HeightLook'] == 1 or $options['general']['RowLook'] == 1 or $options['general']['ThumbLook'] == 1)){
                $showThumbsControl=true;
                break;
            }
            if($value=="ThumbLookOrder" AND $options['general']['ThumbLook'] == 1 AND ($options['general']['HeightLook'] == 1 or $options['general']['RowLook'] == 1 or $options['general']['SliderLook'] == 1)){
                $showThumbsControl=true;
                break;
            }
            if($value=="HeightLookOrder" AND $options['general']['HeightLook'] == 1 AND ($options['general']['ThumbLook'] == 1 or $options['general']['RowLook'] == 1 or $options['general']['SliderLook'] == 1)){
                $showThumbsControl=true;
                break;
            }
            if($value=="RowLookOrder" AND $options['general']['RowLook'] == 1  AND ($options['general']['ThumbLook'] == 1 or $options['general']['HeightLook'] == 1 or $options['general']['SliderLook'] == 1)){
                $showThumbsControl=true;
                break;
            }

        }

        $i = 0;

        if($showThumbsControl){

            echo "<div class='cg_gallery_thumbs_control'>";

            foreach($orderGalleries as $key => $value){

                if($i==0){$cg_hide_on='';$cg_hide_off='cg_hide';}else{$cg_hide_on='cg_hide';$cg_hide_off='';}


                if($value=="SliderLookOrder" AND $options['general']['SliderLook'] == 1 AND ($options['general']['HeightLook'] == 1 or $options['general']['RowLook'] == 1 or $options['general']['ThumbLook'] == 1)){
                    $i++;

                    //echo "<option value='1' $selected_look_thumb>View $i</option>";
                    //echo "<a href='$siteURL&1=1&2=".$getOrder."&3=".$start."'><img title='Thumb view' src='$selected_look_thumb' style='float:left;margin-left:5px;' /></a> ";
                    echo "<span title='$language_SliderView' class='$cgFeControlsStyle cg_view_switcher cg_view_slider cg_view_switcher_off $cg_hide_off' ></span>";
                    echo "<span title='$language_SliderView' class='$cgFeControlsStyle cg_view_switcher cg_view_slider cg_view_switcher_on $cg_hide_on' ></span>";
                }

                if($value=="ThumbLookOrder" AND $options['general']['ThumbLook'] == 1 AND ($options['general']['HeightLook'] == 1 or $options['general']['RowLook'] == 1 or $options['general']['SliderLook'] == 1)){
                    $i++;

                    //echo "<option value='1' $selected_look_thumb>View $i</option>";
                    //echo "<a href='$siteURL&1=1&2=".$getOrder."&3=".$start."'><img title='Thumb view' src='$selected_look_thumb' style='float:left;margin-left:5px;' /></a> ";
                    echo "<span title='$language_ThumbView' class='$cgFeControlsStyle cg_view_switcher cg_view_thumb cg_view_switcher_off $cg_hide_off' ></span>";
                    echo "<span title='$language_ThumbView' class='$cgFeControlsStyle cg_view_switcher cg_view_thumb cg_view_switcher_on $cg_hide_on' ></span>";
                }
                if($value=="HeightLookOrder" AND $options['general']['HeightLook'] == 1 AND ($options['general']['ThumbLook'] == 1 or $options['general']['RowLook'] == 1 or $options['general']['SliderLook'] == 1)){
                    $i++;

                    //echo "<option value='2' $selected_look_height>View $i</option>";
                    //echo "<a href='$siteURL&1=2&2=".$getOrder."&3=".$start."'><img title='Height view' src='$selected_look_height' style='float:left;margin-left:5px;'></a> ";
                    echo "<span title='$language_HeightView' class='$cgFeControlsStyle cg_view_switcher cg_view_height cg_view_switcher_off $cg_hide_off' ></span>";
                    echo "<span title='$language_HeightView' class='$cgFeControlsStyle cg_view_switcher cg_view_height cg_view_switcher_on $cg_hide_on' ></span>";
                }
                if($value=="RowLookOrder" AND $options['general']['RowLook'] == 1  AND ($options['general']['ThumbLook'] == 1 or $options['general']['HeightLook'] == 1 or $options['general']['SliderLook'] == 1)){
                    $i++;

                    //echo "<option value='3' $selected_look_row>View $i</option>";
                    //echo "<a href='$siteURL&1=3&2=".$getOrder."&3=".$start."'><img title='Row view' src='$selected_look_row' style='float:left;margin-left:5px;'></a> ";
                    echo "<span title='$language_RowView' class='$cgFeControlsStyle cg_view_switcher cg_view_row cg_view_switcher_off $cg_hide_off' ></span>";
                    echo "<span title='$language_RowView' class='$cgFeControlsStyle cg_view_switcher cg_view_row cg_view_switcher_on $cg_hide_on' ></span>";
                }

            }
            //echo "<span class='cg_view_switcher_stabilize' style='width:40px;height:40px;display:inline-block;margin:0;padding:0;'></span>";
            echo "</div>";

        }


    }


    if($FullScreenGallery == 1 or $FullSizeGallery==1){

        echo "<div class='cg-fullsize-div'>";

        if($FullScreenGallery==1){
            echo  "<div class='cg-center-image-fullscreen' data-cg-gid='$galeryIDuser'></div>";
        }

        if($FullSizeGallery==1){
            echo "<div class='cg-center-image-close-fullwindow cg_hide $cgFeControlsStyle' id='cgCenterImageClose$galeryIDuser' data-cg-gid='$galeryIDuser'></div>";
            echo "<div class='cg-center-image-fullwindow cg_gallery_control_element $cgFeControlsStyle' id='cgCenterImageFullwindowHeader$galeryIDuser' data-cg-gid='$galeryIDuser'></div>";
        }

        // have to be both true because full screen (full size) does not work without full window (full size gallery)
        if($FullSizeGallery==1 && $FullSize==1){
            echo "<div class='cg-fullscreen-button cg-header-controls-show-only-full-window cg_hide $cgFeControlsStyle' id='cgFullScreenButton$galeryIDuser' data-cg-gid='$galeryIDuser'></div>";
        }

        // because of float right at the end
        echo "<div class='cg-fullwindow-configuration-button cg-header-controls-show-only-full-window cg_hide $cgFeControlsStyle' id='cgCenterImageFullWindowConfiguration$galeryIDuser' data-cg-gid='$galeryIDuser'></div>";

        if($isInGalleryUpload){
            echo "<div class='cg-gallery-upload cg-header-controls-show-only-full-window cg_hide $cgFeControlsStyle' data-cg-gid='$galeryIDuser'>";

            echo "</div>";
        }

        echo "</div>";

    }

    if($GalleryUpload){
        include('gallery-upload-form.php');
    }
    echo "</div>";

}
