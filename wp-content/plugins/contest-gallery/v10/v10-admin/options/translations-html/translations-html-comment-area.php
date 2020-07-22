<?php


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_ThankYouForYourComment.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_ThankYouForYourComment.']" maxlength="100" value="'.$translations[$l_ThankYouForYourComment].'">';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_TheNameFieldMustContainTwoCharactersOrMore.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_TheNameFieldMustContainTwoCharactersOrMore.']" maxlength="100" value="'.$translations[$l_TheNameFieldMustContainTwoCharactersOrMore].'">';
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td class='cg-small-textarea-container' colspan='2'>";
echo '<p>'.$language_TheCommentFieldMustContainThreeCharactersOrMore.'</p>';
echo '<input type="text" class="cg-long-input" name="translations['.$l_TheCommentFieldMustContainThreeCharactersOrMore.']" maxlength="100" value="'.$translations[$l_TheCommentFieldMustContainThreeCharactersOrMore].'">';
echo "</td>";
echo "</tr>";


?>