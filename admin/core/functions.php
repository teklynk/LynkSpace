<?php

//Random password generator
function generateRandomString($length = 10) {
    global $randomString;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Get gravatar image based on email value
function getGravatar($email, $size) {
    $default = "https://cdn2.iconfinder.com/data/icons/basic-4/512/user-28.png";
    return "https://www.gravatar.com/avatar/".md5(strtolower(trim($email)))."?d=".urlencode($default)."&s=".$size;
}

?>
