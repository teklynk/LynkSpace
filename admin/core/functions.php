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

// Script to test if extension are installed and permissions are correct on this server
function checkDependencies(){
    global $dbFileLoc;
    global $dbFilename;
    global $dbBlowfishLoc;
    global $sitemapFilename;
    global $robotsFilename;

    if  (!in_array('curl', get_loaded_extensions())) {
        print_r("<div class='alert alert-danger'><span>cURL (php-curl) is NOT installed on the server.<br/>Try: sudo apt-get install php-curl</span></div><br/>");
    }
    if  (!in_array('xml', get_loaded_extensions())) {
        print_r("<div class='alert alert-danger'><span>xml (php-xml) is NOT installed on the server.<br/>Try: sudo apt-get install php-xml</span></div><br/>");
    }
    if  (!in_array('zip', get_loaded_extensions())) {
        print_r("<div class='alert alert-danger'><span>zip (php-zip) is NOT installed on the server.<br/>Try: sudo apt-get install php-zip</span></div><br/>");
    }
    if  (!in_array('mbstring', get_loaded_extensions())) {
        print_r("<div class='alert alert-danger'><span>mbstring (php-mbstring) is NOT installed on the server.<br/>Try: sudo apt-get install php-mbstring</span></div><br/>");
    }
    if (!in_array('mod_rewrite', apache_get_modules())) {
        print_r("<div class='alert alert-danger'><span>Apache module (mod_rewrite) is not enabled on the server.<br/>Try: sudo a2enmod rewrite</span></div><br/>");
    }
    if (!in_array('mod_headers', apache_get_modules())) {
        print_r("<div class='alert alert-danger'><span>Apache module (mod_headers) is not enabled on the server.<br/>Try: sudo a2enmod headers</span></div><br/>");
    }
    if (!in_array('mod_vhost_alias', apache_get_modules())) {
        print_r("<div class='alert alert-danger'><span>Apache module (mod_vhost_alias) is not enabled on the server.<br/>Try: sudo a2enmod vhost_alias</span></div><br/>");
    }

    // Check if sql file exists
    if (!file_exists($dbFileLoc)) {
        echo "$dbFileLoc does not exist";
    } else {
        if (!is_writeable($dbFileLoc)) {
            die("$dbFileLoc is not writable. Check file permissions.");
        }
    }
    // Check if dbconn.php file exists
    if (!file_exists($dbFilename)) {
        echo "$dbFilename does not exist";
    } else {
        if (!is_writeable($dbFilename)) {
            die("$dbFilename is not writable. Check file permissions.");
        }
    }
    // Check if blowfishsalt.php file exists
    if (!file_exists($dbBlowfishLoc)) {
        echo "$dbBlowfishLoc does not exist";
    } else {
        if (!is_writeable($dbBlowfishLoc)) {
            die("$dbBlowfishLoc is not writable. Check file permissions.");
        }
    }
    // Check if sitemap.xml file exists
    if (!file_exists($sitemapFilename)) {
        echo "$sitemapFilename does not exist";
    } else {
        if (!is_writeable($sitemapFilename)) {
            die("$sitemapFilename is not writable. Check file permissions.");
        }
    }
    // Check if robots.txt file exists
    if (!file_exists($robotsFilename)) {
        echo "$robotsFilename does not exist";
    } else {
        if (!is_writeable($robotsFilename)) {
            die("$robotsFilename is not writable. Check file permissions.");
        }
    }
    return false;
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
//Database Dump Backup
function databaseDumpBackup($dest, $table_name){

    global $db_name;
    global $db_conn;

    $backup_file = $dest . $table_name . '-' . date("Y-m-d-H-i-s") . '.sql';
    $sqlDump = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";

    mysqli_select_db($db_conn, $db_name);
    $retval = mysqli_query($db_conn, $sqlDump);

    if(!$retval ) {
        die('Could not make a database backup: ' . mysqli_error($db_conn));
    }

}
//Remove Directory
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir"){
                    rrmdir($dir."/".$object);
                } else {
                    unlink($dir."/".$object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}
//cURL a URL to get contents
function getUrlContents($getUrl) {
    global $http_status;

    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo "HTTP status ".$http_status.". Error loading URL. " .curl_error($ch);
        curl_close($ch);
    }
    curl_close($ch);

    return $data;
}
//Check if a new version is available
function checkForUpdates(){
    global $ysmVersion;
    global $getVersion;
    global $http_status;
    global $updatesSever;
    $updatesURL = $updatesSever.'/version.txt';
    $getVersion = getUrlContents($updatesURL);
    $getVersion = trim($getVersion);
    if (!isset($_SESSION['updates_available'])) {
        if ($http_status == 200) {
            if ((string)trim($getVersion) > (string)trim($ysmVersion)){
                return "<a href='updates.php?loc_id=".$_SESSION['loc_id']."'><button type='button' class='btn btn-xs btn-warning'><i class='fa fa-bell'></i> Update Available</button></a>";
            }
        } else {
            return false;
        }
    }
}
//Set update variables
function getUpdates(){
    checkForUpdates();
    global $getVersion;
    global $updatesRemoteFile;
    global $changeLogFile;
    global $updatesDestination;
    global $updatesCheckerURL;
    global $updatesSever;

    $changeLogFile = $updatesSever.'/changelog'.$getVersion.'.txt';
    $updatesRemoteFile = $updatesSever.'/version'.$getVersion.'.zip';
    $updatesDestination = 'upgrade/version'.$getVersion.'.zip';
    $updatesCheckerURL = $updatesSever.'/versionupdatechecker.php';
}
//Download file and save to a directory on the server
function downloadFile($url, $path) {
    //example: downloadFile($updatesFile, 'upgrade/version' . $getVersion . '.zip');
    $fileResource = fopen($path, 'w');
    // Get The Zip File From Server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 400);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FILE, $fileResource);
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    $page = curl_exec($ch);
    if (!$page) {
        echo 'Error :- ' . curl_error($ch) . PHP_EOL;
    }
    if ($curl_errno > 0) {
        echo 'downloadFile() Error ($curl_errno): $curl_error' . PHP_EOL;
    }
    curl_close($ch);
}
//Extract zip files/folder to specified destination
function extractZip($filename, $dest){
    if (is_dir($dest)) {
        // Load up the zip
        $zip = new ZipArchive;
        $unzip = $zip->open($filename);

        $ignoreListArr = array('custom-style.css', 'Thumbs.db', '.DS_Store');

        if ($unzip === true) {
            for ($i=0; $i<$zip->numFiles; $i++) {
                $name = $zip->getNameIndex($i);

                // Remove the first directory in the string if necessary
                $parts = explode('/', $name);

                if (count($parts) > 1) {
                    array_shift($parts);
                }

                $file = $dest . '/' . implode('/', $parts);

                // Create the directories if necessary
                $dir = dirname($file);

                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }

                // Check if $name is a file or directory
                if (substr($file, -1) == "/") {
                    // $name is a directory
                    // Create the directory
                    if (!is_dir($file)) {
                        mkdir($file, 0755, true);
                    }

                } else {
                    // $name is a file
                    // Read from Zip and write to disk

                    if ('.' === $file) continue;
                    if ('..' === $file) continue;
                    if (in_array($file, $ignoreListArr)) continue;

                    $fpr = $zip->getStream($name);
                    $fpw = fopen($file, 'w');

                    while ($data = fread($fpr, 1024)) {
                         fwrite($fpw, $data);
                    }

                    fclose($fpr);
                    fclose($fpw);
                }
            }
            echo 'Success';
        } else {
            echo 'Extraction of zip failed.';
        }
    } else {
        echo 'The output directory does not exist!';
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