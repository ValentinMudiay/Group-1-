<?php


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_DeleteImageQuestion.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_DeleteImageQuestion.']" maxlength="100" value="'.$translations[$l_DeleteImageQuestion].'">';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_DeleteImageConfirm.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_DeleteImageConfirm.']" maxlength="100" value="'.$translations[$l_DeleteImageConfirm].'">';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_YouCanNotVoteInOwnGallery.'</p>';
echo '<span class="cg-info-icon">info</span><span class="cg-info-container">This message will appear if <b>cg_gallery_user</b> shortcode is used and user try to vote own images</span>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_YouCanNotVoteInOwnGallery.']" maxlength="100" value="'.$translations[$l_YouCanNotVoteInOwnGallery].'">';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_YouCanNotCommentInOwnGallery.'</p>';
echo '<span class="cg-info-icon">info</span><span class="cg-info-container">This message will appear if <b>cg_gallery_user</b> shortcode is used and user try to comment own images</span>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_YouCanNotCommentInOwnGallery.']" maxlength="100" value="'.$translations[$l_YouCanNotCommentInOwnGallery].'">';
echo "</td>";
echo "</tr>";

?>