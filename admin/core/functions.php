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

//Get gravatar image based on users email value
function getGravatar($email, $size) {
    $default = "https://cdn2.iconfinder.com/data/icons/basic-4/512/user-32.png";
    return "https://www.gravatar.com/avatar/".md5(strtolower(trim($email)))."?d=".urlencode($default)."&s=".$size;
}

//Cleans strings - removes html characters, trims spaces, converts to html entities.
function safeCleanStr($cleanStr) {
    return htmlspecialchars(strip_tags(trim($cleanStr)), ENT_QUOTES);
}

//Location list for level 1 admins only
function getLocList() {
    global $locList;
    global $db_conn;

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name, active FROM locations WHERE active='true'");

    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch)) {
        $locList = $locList . "<option data-icon='fa fa-fw fa-university' value='".$rowLocationSearch['id']."' >".$rowLocationSearch['name']."</option>";
    }
    return $locList;
}

//if not user level = 1 then keep the user on their own location. if loc_id is changed in querystring, redirect user back to their own loc_id.
if ($_SESSION['user_level'] != 1 AND $_GET['loc_id'] != $_SESSION['user_loc_id']){
    header("Location: ?loc_id=".$_SESSION['user_loc_id']."");
    echo "<script>window.location.href='?loc_id=".$_SESSION['user_loc_id']."';</script>";
} else if ($_SESSION['user_level'] == 1 AND $_GET['loc_id'] == "") {
    header("Location: ?loc_id=1");
    echo "<script>window.location.href='?loc_id=1';</script>";
}

//html5 pattern property for input type=email
$emailValidatePattern = "(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}";

?>
