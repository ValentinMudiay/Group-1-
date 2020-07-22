<?php

echo "
<td>
<div class='cg_shortcode_parent'>
    <p><strong>Gallery shortcode:</strong>
    <div><div class='cg_shortcode_copy cg_shortcode_copy_gallery cg_tooltip' ></div><span class='cg_shortcode_copy_text'>[cg_gallery id=\"$galeryNR\"]</span>
    <span class=\"cg-info-icon\">info</span>
    <span class=\"cg-info-container cg-info-container-gallery-user\" style=\"display: none;top:50px;\">All images are visible<br>All configured options are active<br>Voting is possible
    <br>Can be added multiple times on a page with different id’s</span>
    </div>
    <div>
    <div class='cg_shortcode_copy cg_shortcode_copy_gallery_user_images cg_tooltip'></div><span class='cg_shortcode_copy_text'>[cg_gallery_user id=\"$galeryNR\"]</span><span class=\"cg-info-icon\">info</span>
    <span class=\"cg-info-container cg-info-container-gallery-user\" style=\"display: none;top:67px;\">Display only uploaded images of logged in user
    <br>Voting is not possible<br>Show always all votes<br>\"Hide until vote\" and \"Show only user votes\" options are disabled<br>\"Delete votes\" is not possible<br>User can delete own images if they are activated
    <br>Can be added multiple times on a page with different id’s</span>
    </div>
    <div style='width:214px;'><div class='cg_shortcode_copy cg_shortcode_copy_gallery cg_tooltip' ></div><span class='cg_shortcode_copy_text'>[cg_gallery_no_voting id=\"$galeryNR\"]</span><span class=\"cg-info-icon\">info</span>
    <span class=\"cg-info-container cg-info-container-gallery-user\" style=\"display: none;top:86px;\">All images are visible<br>Voting, sort by voting and preselect by voting is not possible and not visible<br>Can be used as normal gallery without voting
    <br>Can be added multiple times on a page with different id’s</span>
    </div>
</div>
</td>
";

echo "<td><div class='cg_shortcode_parent'>
<p><strong>Upload form shortcode:</strong></p>
<div><div class='cg_shortcode_copy cg_shortcode_copy_upload cg_tooltip'></div><span class='cg_shortcode_copy_text'>[cg_users_upload id=\"$galeryNR\"]</span>
    <span class=\"cg-info-icon\">info</span>
    <span class=\"cg-info-container cg-info-container-gallery-user\" style=\"display: none;top:50px;\">Displays upload form<br>Can only be added only once on a page</span>
</div>
</div><br><br></td>";// br br br need to show on top!

echo "<td><div class='cg_shortcode_parent'>
<p><strong>Users registration/login form:</strong></p>
<div><div class='cg_shortcode_copy cg_shortcode_copy_reg cg_tooltip'></div><span class='cg_shortcode_copy_text'>[cg_users_reg id=\"$galeryNR\"]</span>
<span class=\"cg-info-icon\">info</span>
<span class=\"cg-info-container cg-info-container-gallery-user\" style=\"display: none;top:50px;\">Displays registration form<br>Can only be added only once on a page</span>
</div>
<div><div class='cg_shortcode_copy cg_shortcode_copy_login cg_tooltip'></div><span class='cg_shortcode_copy_text'>[cg_users_login id=\"$galeryNR\"]</span>
<span class=\"cg-info-icon\">info</span>
<span class=\"cg-info-container cg-info-container-gallery-user\" style=\"display: none;top:67px;\">Displays login form<br>Can only be added only once on a page</span>
</div>
</div><br></td>";
//
?>