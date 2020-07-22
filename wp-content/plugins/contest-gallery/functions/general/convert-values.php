<?php

if(!function_exists('contest_gal1ery_htmlentities_and_preg_replace')){
    function contest_gal1ery_htmlentities_and_preg_replace ($content){

        $content = htmlentities($content, ENT_QUOTES, 'UTF-8');
        //$content = nl2br($content);

        //Ganz wichtig, ansonsten werden bei vielen Servern immer / (Backslashes bei Anf�hrungszeichen und aneren speziellen Sonderzeichen) hinzugef�gt
        $content = preg_replace('/\\\\/', '', $content);

        return $content;

    }
}
if(!function_exists('contest_gal1ery_no_convert')){
    function contest_gal1ery_no_convert ($content){
        return $content;
    }
}
if(!function_exists('contest_gal1ery_convert_for_html_output')){
    function contest_gal1ery_convert_for_html_output ($content){

        $content = nl2br(html_entity_decode(stripslashes($content)));

        return $content;
    }
}

if(!function_exists('contest_gal1ery_convert_for_html_output_without_nl2br')){
    function contest_gal1ery_convert_for_html_output_without_nl2br ($content){

        $content = html_entity_decode(stripslashes($content));

        return $content;
    }
}