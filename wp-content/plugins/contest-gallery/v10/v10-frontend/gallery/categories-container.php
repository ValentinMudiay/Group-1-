<?php

$cg_cat_checkbox_checked = 'cg_cat_checkbox_checked';

if($ShowCatsUnchecked==1){
    $cg_cat_checkbox_checked = 'cg_cat_checkbox_unchecked';
}

$heredoc = <<<HEREDOC

<div id="cgCatSelectArea$galeryIDuser" class="cg-cat-select-area $cgFeControlsStyle">
       <label class="$cg_cat_checkbox_checked cg_select_cat_label">
            <span class="cg_select_cat" ></span>
            <span class="cg_select_cat_check_icon"></span>
       </label>
</div>

HEREDOC;

echo $heredoc;

?>