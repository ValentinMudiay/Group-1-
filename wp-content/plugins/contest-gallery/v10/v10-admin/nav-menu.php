<?php

	echo "<div id='cgDocumentation'>";
        echo "<a href='https://www.contest-gallery.com/documentation/' target='_blank'><span>";
        echo "Contest Gallery documentation";
        echo "</span></a>";
	echo "</div>";
	echo "<table style='border: thin solid black;background-color:#ffffff;' width='937px;' id='cg_shortcode_table' class='cg_shortcode_table'>";

	if(!empty($GalleryName)){$GalleryName=$GalleryName;}
	else {$GalleryName="Contest Gallery";}
	
	//if(strpos(floatval(get_option("p_cgal1ery_reg_code"))/44,".") == false && floatval(get_option("p_cgal1ery_reg_code"))!=0 && floatval(get_option("p_cgal1ery_reg_code"))>=986798739){
		$versionColor = "#444";		
//	}
//	else{
//		$versionColor = "#c2c2c2";		
//	}
	echo "<tr><td align='center'><div style='width:180px;' ><strong>$GalleryName</strong><br/>$cgProVersionLink</div></td>";
$galeryNR = $GalleryID;

include("nav-shortcode.php");
	echo "</tr>";
	echo "</table>";
	
	echo "<br/>";

	echo "<table style='border: thin solid black;background-color:#ffffff;padding:15px;' width='937px;'>";
	echo "<tr>";
	echo "<td align='center'><div><a href='?page=contest-gallery/index.php&option_id=$GalleryID&edit_gallery=true' class='cg_load_backend_link' ><input class='cg_backend_button cg_backend_button_back'  type='submit' value='<<< Back to gallery'  /></a><br/></div></td>";
	echo "<td align='center'><div><a href='?page=contest-gallery/index.php&edit_options=true&option_id=$GalleryID' class='cg_load_backend_link'><input type='submit' class='cg_backend_button cg_backend_button_general'  value='Edit options'  /></a><br/></div></td>";
	echo "<td align='center'><div><a href='?page=contest-gallery/index.php&option_id=$GalleryID&define_upload=true' class='cg_load_backend_link'><input type='submit' class='cg_backend_button cg_backend_button_general'  value='Edit upload form' /></form><br/></div></td>";
	echo "<td align='center'><div>";
		echo "<a href='?page=contest-gallery/index.php&create_user_form=true&option_id=$GalleryID' class='cg_load_backend_link'><input type='hidden' name='option_id' value='$GalleryID'><input class='cg_backend_button cg_backend_button_general'  type='submit' value='Edit registration form'  /></a>";

	echo "</div></td>"; 
	
	echo "</tr>";
	
	echo "</table>";
		
	echo "<br/>";

    if(!empty($isEditOptions)){
        include('nav-users-management-with-status-and-repair.php');
    }else{
        include('nav-users-management.php');
    }


?>