<?php

global $wpdb;
$tablename_comments = $wpdb->prefix . "contest_gal1ery_comments";
$tablename = $wpdb->prefix . "contest_gal1ery";
$tablenameOptions = $wpdb->prefix . "contest_gal1ery_options";

$galeryNR=@$_GET['option_id'];
$pid=0;

if(!empty($_GET['id'])){
    $pid=$_GET['id'];
}

$GalleryName = $wpdb->get_var("SELECT GalleryName FROM $tablenameOptions WHERE id = '$galeryNR'");

if(empty($GalleryName)){
    $GalleryName = 'Contest Gallery';
}
$GalleryID = $galeryNR;
include(__DIR__."/../nav-menu.php");




// SQL zum Ermitteln von allen Komments mit gesendeter picture id


		/*echo "<br>tablenameComments: $tablenameComments<br>";
		echo "<br>galeryID: $galeryID<br>";
		echo "<br>pictureID: $pictureID<br>";
		echo "<br>start: $start<br>";
		echo "<br>order: $order<br>";
		echo "<br>step: $step<br>"; */
		
// DATEN Löschen und exit	


				
						//		$updateCountC = "UPDATE $tablename SET CountC='0' WHERE id = '$pid'";
				//$wpdb->query($updateCountC);

	if (!empty($_POST['delete-comment'])) {
	
			//$deleteQuery = 'DELETE FROM ' . $tablename_comments . ' WHERE';
            $wp_upload_dir = wp_upload_dir();

            $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryNR.'/json/image-comments/image-comments-'.$pid.'.json';
            $fp = fopen($jsonFile, 'r');
            $commentsArray = json_decode(fread($fp, filesize($jsonFile)),true);
            fclose($fp);

			foreach($_POST['delete-comment'] as $key => $value){

                    $deleteQuery = 'DELETE FROM ' . $tablename_comments . ' WHERE';
                    $deleteQuery .= ' id = %d';

                    $deleteParameters = '';
                    $deleteParameters .= $value;

                    $wpdb->query( $wpdb->prepare(
                        "
                            $deleteQuery
                        ",
                            $deleteParameters
                    ));

                    unset($commentsArray[$value]);
		
			}

            // set image data, das ganze gesammelte
            $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryNR.'/json/image-comments/image-comments-'.$pid.'.json';
            $fp = fopen($jsonFile, 'w');
            fwrite($fp, json_encode($commentsArray));
            fclose($fp);
			

            $countCommentsSQL = $wpdb->get_var( $wpdb->prepare(
            "
                SELECT COUNT(1)
                FROM $tablename_comments 
                WHERE pid = %d
            ",
            $pid
            ) );


            $wpdb->update(
            "$tablename",
            array('CountC' => $countCommentsSQL),
            array('id' => $pid),
            array('%d'),
            array('%d')
            );

        // process rating comments data file

        $dataFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryNR.'/json/image-data/image-data-'.$pid.'.json';
        $fp = fopen($dataFile, 'r');
        $ratingCommentsData =json_decode(fread($fp,filesize($dataFile)),true);
        fclose($fp);

        $ratingCommentsData['CountC'] = $countCommentsSQL;

        $fp = fopen($dataFile, 'w');
        fwrite($fp,json_encode($ratingCommentsData));
        fclose($fp);

        // process rating comments data file --- ENDE


        echo "<p id='cg_changes_saved' style='font-size:18px;'><strong>Changes saved</strong></p>";


    }
		
		
	
// DATEN Löschen und exit ENDE	

		$select_comments = $wpdb->get_results( "SELECT * FROM $tablename_comments WHERE pid='$pid' ORDER BY Timestamp DESC" );


		
		if($select_comments){
            echo "<form action='?page=contest-gallery/index.php&option_id=$galeryNR&show_comments=true&id=$pid' method='POST' class='cg_load_backend_submit'>";


            echo "<div id='cgShowComments' >";
		
		

		//print_r($select_comments);
		
		
		foreach($select_comments as $value){
		
		$id = $value->id;
		$pid = $value->pid;
		$name = htmlspecialchars($value->Name);
		$date = htmlspecialchars($value->Date);
		$timestamp = $value->Timestamp;
		$comment = nl2br(htmlspecialchars($value->Comment));
		$comment1 = $value->Comment;
		
		

		echo "<div style='margin-bottom:20px;margin-top:20px;'>";
		echo "<hr style='margin-left:0;'>";
		echo "<div style='display:inline;'><b>".html_entity_decode(stripslashes($name))."</b> ";
		echo "(<div id='cg-comment-$id' style='display:inline;'></div>):</div><div style='display:inline;float:right;'>Delete: &nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='delete-comment[]' value='$id'></div>";
		echo "<br/>";
		
		
?>
<script>



var getTimestamp = <?php echo json_encode($timestamp);?>;
var id = <?php echo json_encode($id);?>;

var commentDate = new Date(getTimestamp*1000);

var month = parseInt(commentDate.getMonth());
	month = month+1;

var monthUS = month;

//alert(commentDate.getMinutes());

	var hours = commentDate.getHours();
	var minutes = commentDate.getMinutes();

	if(commentDate.getMinutes()<10){
		
	var minutes = "0"+commentDate.getMinutes();
		
	}
	
	if(commentDate.getHours()<10){
		
	var hours = "0"+commentDate.getHours();
		
	}
	
	commentDate = commentDate.getFullYear()+"/"+monthUS+"/"+commentDate.getDate()+" "+hours+":"+minutes;
	
	
//$("#cg-comment-"+id ).append( commentDate );	

var tagID = 'cg-comment-'+id;
//alert(tagID);
var elem = document.getElementById(tagID);
elem.innerHTML  = commentDate;


//alert(id);
//alert(commentDate);

</script>



<?php
		

		
		echo "<p>".html_entity_decode(stripslashes($comment1))."</p>";
				echo "<br/>";

		echo "</div>";
		
			}





echo "</div>";

								echo "<div id='cgShowCommentsDeleteSubmit'>";
		echo '&nbsp;&nbsp; <input class="cg_backend_button_gallery_action" type="submit" value="Delete selected comments" id="submit" style="text-align:center;">';
		//echo '<input type="hidden" value="delete-comment" name="delete-comment">';

		echo "</div>";
            echo '</form>';

        }

		else{
		echo "<div style='width:895px;padding:20px;background-color:#fff;margin-bottom:0px !important;margin-bottom:0px;border: thin solid black;text-align:center;'>";
		echo "<p style=\"font-size: 16px;\"><b>All picture comments are deleted</b></p>";
		echo "</div>";
			
		}

?>