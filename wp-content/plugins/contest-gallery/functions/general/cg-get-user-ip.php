<?php
add_action('cg_get_user_ip','cg_get_user_ip');
if(!function_exists('cg_get_user_ip')){
    function cg_get_user_ip(){

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $userIP = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['REMOTE_ADDR'])) {
            $userIP = $_SERVER['REMOTE_ADDR'];
        }
        else{
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $userIP;

    }
}
