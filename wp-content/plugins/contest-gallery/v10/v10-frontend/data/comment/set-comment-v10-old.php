<?php
if(!defined('ABSPATH')){exit;}



$Name = sanitize_text_field($_REQUEST['name']);
$Comment = sanitize_text_field($_REQUEST['comment']);
$Check = sanitize_text_field($_REQUEST['cg_wp_create_nonce']);
$Email = sanitize_text_field($_REQUEST['emailTrap']);
$Timestamp = intval($_REQUEST['timestamp']);
$pictureID = intval($_REQUEST['cg_picture_id']);
$galeryID = intval($_REQUEST['cg_galery_id']);

		// User ID �berpr�fung ob es die selbe ist
		$CheckCheck = wp_create_nonce("check");

		$unix = time();


  $Name = nl2br(htmlspecialchars($Name));
  $Comment = nl2br(htmlspecialchars($Comment));
  $Check = nl2br(htmlspecialchars($Check));
  $Email = nl2br(htmlspecialchars($Email));
  $Timestamp = nl2br(htmlspecialchars($Timestamp));


  $Name = sanitize_text_field($Name);
  $Comment = sanitize_text_field($Comment);
  $Check = sanitize_text_field($Check);
  $Email = sanitize_text_field($Email);
  $Timestamp = sanitize_text_field($Timestamp);
    $galeryID = sanitize_text_field($galeryID);
    $pictureID = sanitize_text_field($pictureID);

  $error = false;
  $errortext = "<p>";
  // Eingaben pr�fen und errortext zusammensetzen
  if (empty($Name)) {
    $error = true;
    $errortext .= "<br/<br/><b>Plz fill out the name field. It must contain two characters or more.</b><br>";
  }
  
    if (strlen($Name)<2 and !empty($Name)) {
    $error = true;
    $errortext .= "<br/<br/><b>The name field must contain two characters or more.</b><br>";
  }
  
  if (empty($Comment)) {
    $error = true;
    $errortext .= "<br/<br/><b>Plz fill out the comment field. It must contain three characters or more.</b><br>";
  }
  
   if (strlen($Comment)<3 and !empty($Comment)) {
    $error = true;
    $errortext .= "<br/<br/><b>The comment field must contain three characters or more.</b><br>";
  }
  
       if (!empty($Email)){
    $error = true;
    $errortext .= "<br/<br/><b>Don't fill the email field.</b><br>";
  }
  
    if (!isset($Check)){
    $error = true;
    $errortext .= "<br/<br/><b>You have to check that you are not a robot</b><br>";
  }


  
   if ($unix-5 < $Timestamp){
    $error = true;
    $errortext .= "<br/<br/><b>You filled out the form to fast. Plz wait longer then 10 seconds.</b><br>";
  }
  
  
  // errortext ausgeben und Skriptabbruch   
  if ($error) {
    echo "<p>$errortext</p>";  
	
?>

<script>

    console.log('comment action here')


</script>

<?php
    
  } else {

   
global $wpdb;   
$tablename = $wpdb->prefix . "contest_gal1ery";    
$tablenameComments = $wpdb->prefix . "contest_gal1ery_comments";    


$date = date("Y/m/d, G:i");


		$wpdb->query( $wpdb->prepare(
			"
				INSERT INTO $tablenameComments
				( id, pid, GalleryID, Name, Date, Comment, Timestamp)
				VALUES ( %s,%d,%d,%s,%d,%s,%d )
			", 
				'',$pictureID,$galeryID,$Name,$date,$Comment,$unix
		 ) );

      $wp_upload_dir = wp_upload_dir();
      $jsonFile = $wp_upload_dir['basedir'].'/contest-gallery/gallery-id-'.$galeryID.'/json/image-data/'.$pictureID.'.json';
      $fp = fopen($jsonFile, 'r');
      $ratingFileData =json_decode(fread($fp,filesize($jsonFile)),true);
      fclose($fp);

      $newCountC = intval($ratingFileData['CountC']) +1;

      $fp = fopen($jsonFile, 'w');
      $ratingFileData['CountC'] = intval($newCountC);
      fwrite($fp,json_encode($ratingFileData));
      fclose($fp);

        $wpdb->update(
        "$tablename",
        array('CountC' => $newCountC),
        array('id' => $pictureID),
        array('%d'),
        array('%d')
        );

	$setCommentSlider = 1;
	
	require_once("show-comments-v10.php");

	
?>

<script>


var pictureID = <?php echo json_encode($pictureID);?>;
cgJsClass.gallery.comment.setComment(pictureID,1);

</script>

<?php	

    
  }
    

?>
