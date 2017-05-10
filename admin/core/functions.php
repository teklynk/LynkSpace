<?php
//Back-end Admin Panel functions
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

//Random password generator for password reset - generates characters, symbol and number
function generateRandomPasswordString(){
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $specialCharacters = '!@#$%';
    $specialCharactersLength = strlen($specialCharacters);
    $numberCharacters = '0123456789';
    $numberCharactersLength = strlen($numberCharacters);
    $randomCharString = '';
    $randomSpecialCharString = '';
    $randomNumberCharString = '';
    //Generate 6 characters
    for ($i = 0; $i < 6; $i++) {
        $randomCharString .= $characters[rand(0, $charactersLength - 1)];
    }
    //Generate 1 special character
    for ($i = 0; $i < 1; $i++) {
        $randomSpecialCharString .= $specialCharacters[rand(0, $specialCharactersLength - 1)];
    }
    //Generate 1 number
    for ($i = 0; $i < 1; $i++) {
        $randomNumberCharString .= $numberCharacters[rand(0, $numberCharactersLength - 1)];
    }
    //Shuffle the string to generate a randomly mixed, 6 char, 1 special char, 1 digit string
    return str_shuffle($randomCharString . $randomSpecialCharString . $randomNumberCharString);
}

//Random string generator - used to create a unique md5 referrer
function generateRandomString(){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return md5($randomString);
}

//Random Blowfish Salt
function blowfishSaltRandomString($saltThisString){
    return password_hash($saltThisString, PASSWORD_DEFAULT);
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
        //echo "<option data-ays-ignore='true' data-content=\"<span class='img-label'><img class='img-select-option' src='../uploads/".$_GET['loc_id']."/".$file."'/>&nbsp;".$file."</span>\" value='".$file."' $imageCheck>".$file."</option>";
        echo "<option data-ays-ignore='true' value='".$file."' $imageCheck>".$file."</option>";

    }
}

function getIconDropdownList($icon_selected) {
    global $db_conn;

    $sqlServicesIcon = mysqli_query($db_conn, "SELECT icon FROM icons_list ORDER BY icon ASC");
    while ($rowIcon = mysqli_fetch_array($sqlServicesIcon)) {
        $icon=$rowIcon['icon'];
        if ($icon === $icon_selected) {
            $iconCheck="SELECTED";
        } else {
            $iconCheck="";
        }
        echo "<option data-ays-ignore='true' data-icon='fa fa-".$icon."' value='".$icon."' ".$iconCheck.">".$icon."</option>";
    }
}

//Get gravatar image based on users email value
function getGravatar($email, $size){
    $default = "//cdn2.iconfinder.com/data/icons/basic-4/512/user-24.png";
    return "//www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size;
}

//Cleans strings - removes html characters, trims spaces, converts to html entities.
function safeCleanStr($cleanStr) {
    return htmlspecialchars(strip_tags(trim($cleanStr)), ENT_QUOTES);
}

//escape Quotes in textareas and string values - Escape special characters in a string
function sqlEscapeStr($cleanStr) {
    global $db_conn;
    return mysqli_real_escape_string($db_conn, trim($cleanStr));
}

//sanitize string - Remove all HTML tags from a string:
function sanitizeStr($cleanStr) {
    return filter_var(trim($cleanStr), FILTER_SANITIZE_STRING);
}

//validate url - Check if the variable $cleanStr is a valid URL
function validateUrl($cleanStr) {
    global $errorMsg;
    if (!filter_var($cleanStr, FILTER_VALIDATE_URL) === false) {
        return filter_var(trim($cleanStr), FILTER_VALIDATE_URL);
    } else {
        $errorMsg = "<div class='alert alert-danger fade in' data-alert='alert'>".$cleanStr." is not a valid URL<button type='button' class='close' data-dismiss='alert'>×</button></div>";
        return false;
    }
}

//validate email - Check if the variable $email is a valid email address
function validateEmail($cleanStr) {
    global $errorMsg;
    if (!filter_var($cleanStr, FILTER_VALIDATE_EMAIL) === false) {
        return filter_var(trim($cleanStr), FILTER_VALIDATE_EMAIL);
    } else {
        $errorMsg = "<div class='alert alert-danger fade in' data-alert='alert'>".$cleanStr." is not a valid Email<button type='button' class='close' data-dismiss='alert'>×</button></div>";
        return false;
    }
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
function getLocList() {
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
    $adminOnlyShow = "style='display:none !important;'";
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
$emailValidationPattern = "(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,25}";
//html5 date validation - Full Date Validation (YYYY-MM-DD)
$dateValidationPattern = "[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])";
//html5 URL validation pattern
$urlValidationPattern = "^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?";
//html5 password validation pattern
$passwordValidationPattern = "(?=(?:[^a-zA-Z]*[a-zA-Z]){4})(?=(?:\D*\d){1}).*";
$passwordValidationTitle = "1 or more digits and a min. of 4 letters are required";
?>