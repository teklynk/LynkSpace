<?php
//Back-end Admin Panel functions
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

//Random password generator for password reset
function generateRandomString($length = 10){
    global $randomString;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//Random Blowfish Salt
function blowfishSaltRandomString($hashThisString){
    return password_hash($hashThisString, PASSWORD_DEFAULT);
}

function getImageDropdownList($image_dir, $image_selected) {
    if ($handle = opendir($image_dir)) {
        while (false !== ($file = readdir($handle))) {
            if ('.' === $file) continue;
            if ('..' === $file) continue;
            if ($file==="Thumbs.db") continue;
            if ($file===".DS_Store") continue;
            if ($file==="index.html") continue;
            $allfiles[] = strtolower($file);
        }
        closedir($handle);
    }
    sort($allfiles);

    foreach($allfiles as $file) {
        if ($file === $image_selected) {
            $imageCheck = "SELECTED";
        } else {
            $imageCheck = "";
        }
        echo "<option value='".$file."' $imageCheck>".$file."</option>";
    }
}

//Get gravatar image based on users email value
function getGravatar($email, $size){
    $default = "https://cdn2.iconfinder.com/data/icons/basic-4/512/user-32.png";
    return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
}

//Cleans strings - removes html characters, trims spaces, converts to html entities.
function safeCleanStr($cleanStr){
    return htmlspecialchars(strip_tags(trim($cleanStr)), ENT_QUOTES);
}

//escape Quotes in textareas and string values
function sqlEscapeStr($cleanStr){
    global $db_conn;
    return mysqli_real_escape_string($db_conn, trim($cleanStr));
}

//Gets clients real IP address
function getRealIpAddr(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $clientip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $clientip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $clientip = $_SERVER['REMOTE_ADDR'];
    }
    return $clientip;
}

//Location list for level 1 admins only
function getLocList(){
    global $locList;
    global $db_conn;

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name FROM locations ORDER BY name ASC");

    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch)) {
        if ($rowLocationSearch['id'] == 1) {
            $isDefault = " (Default)";
        } else {
            $isDefault = "";
        }
        $locList .= "<option data-icon='fa fa-fw fa-university' value='" . $rowLocationSearch['id'] . "' >" . $rowLocationSearch['name'] . $isDefault ."</option>";
    }
    return $locList;
}

//Copy folder contents to another
function recurse_copy($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while (false !== ( $file = readdir($dir)) ) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurse_copy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

//Remove Directory
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir"){
                    rrmdir($dir."/".$object);
                }else{
                    unlink($dir."/".$object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

//Variable to hide elements from non-admin users
if ($_SESSION['user_level'] == 1 && $multiBranch == 'true' && $_GET['loc_id'] == 1 ){
    $adminOnlyShow = "";
    $adminIsCheck = "true";
} else {
    $adminOnlyShow = "style='display:none;'";
    $adminIsCheck = "false";
}

//if not user level = 1 then keep the user on their own location. if loc_id is changed in querystring, redirect user back to their own loc_id.
if ($_SESSION['user_level'] != 1 && $_GET['loc_id'] != $_SESSION['user_loc_id']) {
    header("Location: ?loc_id=" . $_SESSION['user_loc_id'] . "");
    echo "<script>window.location.href='?loc_id=" . $_SESSION['user_loc_id'] . "';</script>";
} elseif ($_SESSION['user_level'] == 1 && $_GET['loc_id'] == "") {
    header("Location: ?loc_id=1");
    echo "<script>window.location.href='?loc_id=1';</script>";
} elseif ($multiBranch == 'false' && $_GET['loc_id'] != $_SESSION['user_loc_id']){
    header("Location: ?loc_id=1");
    echo "<script>window.location.href='?loc_id=1';</script>";
}

//html5 pattern property for input type=email
$emailValidatePattern = "(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}";

?>