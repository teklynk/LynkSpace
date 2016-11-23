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
    $default = "https://cdn2.iconfinder.com/data/icons/basic-4/512/user-32.png";
    return "https://www.gravatar.com/avatar/".md5(strtolower(trim($email)))."?d=".urlencode($default)."&s=".$size;
}

//if not user level = 1 then keep the user in their own location. if loc_id is changed in querystring, redirect user back to their own loc_id.
if ($_SESSION['user_level'] != 1 AND $_GET['loc_id'] != $_SESSION['user_loc_id']){
    //echo "<script>window.location.href='?loc_id=".$_SESSION['user_loc_id']."';</script>";
    header("Location: ?loc_id=".$_SESSION['user_loc_id']."");
} else if ($_SESSION['user_level'] == 1 AND $_GET['loc_id'] == "") {
    //echo "<script>window.location.href='?loc_id=".$_SESSION['user_loc_id']."';</script>";
    header("Location: ?loc_id=1");
}

?>
