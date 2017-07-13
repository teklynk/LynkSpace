<?php
//Back-end Admin Panel functions
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
//Output to browser console
function debug_to_console($data) {
    $output = $data;

    if (is_array($output)){
        $output = implode(',', $output);
    }

    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}

//Phinx migration runner
function phinxMigration($phinxCommand, $environment){
    require __DIR__ . '/../../vendor/autoload.php';

    $phinxApp = new \Phinx\Console\PhinxApplication();
    $phinxTextWrapper = new \Phinx\Wrapper\TextWrapper($phinxApp);

    $phinxConfigFile = __DIR__ . '/../../phinx.php';

    $phinxTextWrapper->setOption('configuration', $phinxConfigFile);
    $phinxTextWrapper->setOption('parser', 'PHP');
    $phinxTextWrapper->setOption('environment', $environment);

    if ($phinxCommand == 'migrate'){
        $log = $phinxTextWrapper->getMigrate();
    } elseif ($phinxCommand == 'rollback') {
        $log = $phinxTextWrapper->getRollback();
    }
}

//File Uploader
function uploadFile($postName, $target, $thumbnail){
    global $uploadMsg;

    if (isset($postName) && is_writable($target)) {
        //Create upload folder if it does not exist.
        if (is_numeric($_GET['loc_id'])) {
            if (!file_exists($target)) {
                @mkdir($target, 0755);
            }
        }

        $target_file = $target . basename($_FILES["fileToUpload"]["name"]);
        $target_thumb_file = $target . 'thumb-' . basename($_FILES["fileToUpload"]["name"]);

        //Upload the file
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

            //Get file info
            $fileInfo = getimagesize($target_file);
            $fileExt = pathinfo($target_file, PATHINFO_EXTENSION);
            $fileName = pathinfo($target_file, PATHINFO_BASENAME);
            $fileMime = $fileInfo['mime'];
            $fileDim_width = $fileInfo[0];
            $fileDim_height = $fileInfo[1];
            $fileSize = basename($_FILES["fileToUpload"]["size"]);
            $fileSizeLimit = 2048000; //Max file size limit

            //Check if file is a image format
            if ($fileExt == "png" || $fileExt == "jpg" || $fileExt == "gif" || $fileInfo !== false) {

                //Check if file is less than 2mb
                if ($fileSize <= $fileSizeLimit) {

                    //Creates a thumbnail image
                    if ($thumbnail == 'true') {
                        if ($fileDim_width >= 1000 || $fileDim_height >= 1000) {
                            $thumb_width = $fileDim_width / 4;
                            $thumb_height = $fileDim_height / 4;
                            resizeImage($target_file, $target_thumb_file, $thumb_width, $thumb_height);
                        }
                    }

                    //rename file if it contains spaces, parenthesis, apostrophes or other characters and low case the file name
                    $search = array('(', ')', ' ', '\'', ':', ';', '@', '!', '?');
                    $replace = array('-', '-', '-', '-', '-', '-', '', '', '');

                    rename($target_file, str_replace($search, $replace, strtolower($target_file)));
                    rename($target_thumb_file, str_replace($search, $replace, strtolower($target_thumb_file)));

                    $uploadMsg = "<div class='alert alert-success' style='margin-top:12px;'>The file " . $fileName . " has been uploaded.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
                } else {
                    //Delete the file if it is too large
                    unlink($target_file);
                    $uploadMsg = "<div class='alert alert-danger' style='margin-top:12px;'>The file " . $fileName . " is larger than 2mb.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";

                }

            } else {

                //Delete the file if it is not an image
                unlink($target_file);
                $uploadMsg = "<div class='alert alert-danger' style='margin-top:12px;'>The file " . $fileName . " is not allowed.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='uploads.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
            }

        } else {
            $uploadMsg = "<div class='alert alert-danger fade in'>Sorry, there was an error uploading your file.</div>";
        }
    }
}

//Resizes image for thumbnails
function resizeImage($imagePath, $resizedFileName, $width, $height) {
    $image = new Imagick();
    $image_filehandle = fopen($imagePath, 'a+');
    $image->readImageFile($image_filehandle);

    $image->scaleImage($width, $height, FALSE);

    $image_resize_filehandle = fopen($resizedFileName, 'a+');
    $image->writeImageFile($image_resize_filehandle);
}

//File size conversion to KB, MB, GB....
function filesize_formatted($theFile){
    $size = filesize($theFile);
    $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
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

//Renames directory if it exists
function renameDir($oldname, $newname){
    if (file_exists(dirname($oldname))) {
        return rename($oldname, $newname);
    }
}

//Random Blowfish Salt
function blowfishSaltRandomString($saltThisString){
    return password_hash($saltThisString, PASSWORD_DEFAULT);
}

//Generates a drop down list of theme thumbnails
function getThemesDropdownList($theme_selected){
    global $themesStr;

    // Get theme names from themes folder
    $themeDirectories = glob('../themes/*' , GLOB_ONLYDIR);

    // Build themes drop down list
    foreach($themeDirectories as $themes) {
        $themes = str_replace('../themes/', '', $themes);
        $themesImg = '../themes/'.$themes.'/screenshot.png';
        $themesThumbnail= '../themes/'.$themes.'/screenshot_thumb.png';

        if ($themes == $theme_selected) {
            $isThemeSelected = "SELECTED";
        } else {
            $isThemeSelected = "";
        }

        echo "<option data-ays-ignore='true' data-content=\"<span class='img-label'><img class='img-select-option' src='".$themesThumbnail."'/>&nbsp;".ucwords($themes)."</span>\" value='".$themes."' $isThemeSelected>".ucwords($themes)."</option>";

    }
}

//Images folder drop down list
function getImageDropdownList($imageDir, $image_selected) {
    if ($handle = opendir($imageDir)) {
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
        echo "<option data-ays-ignore='true' data-content=\"<span class='img-label'><img class='img-select-option' src='../uploads/".$_GET['loc_id']."/".$file."'/>&nbsp;".$file."</span>\" value='".$file."' $imageCheck>".$file."</option>";
        //echo "<option class='img-select-option' data-ays-ignore='true' value='".$file."' $imageCheck>".$file."</option>";

    }
}
//Fontawesome icon list
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
        echo "<option class='icon-select-option' data-ays-ignore='true' data-icon='fa fa-".$icon."' value='".$icon."' ".$iconCheck.">".$icon."</option>";
    }
}

//Get gravatar image based on users email value
function getGravatar($email, $size){
    $default = "//cdn2.iconfinder.com/data/icons/basic-4/512/user-24.png";
    return "//www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size . "&secure=true";
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
function getLocList($active) {
    global $locList;
    global $db_conn;

    if ($active == 'true'){
        $getActive = "WHERE active='true'";
    } else {
        $getActive = "";
    }

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name FROM locations $getActive ORDER BY name ASC");

    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch)) {
        if ($rowLocationSearch['id'] == 1) {
            $isDefault = " (Default)";
        } else {
            $isDefault = "";
        }
        $locList .= "<option class='loc_list_option' data-icon='fa fa-fw fa-university' value='" . $rowLocationSearch['id'] . "' >" . $rowLocationSearch['name'] . $isDefault ."</option>";
    }
    return $locList;
}
//Get existing Pages
function getPages($loc) {
    global $pagesList;
    global $db_conn;

    $sqlServicesLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active='true' AND loc_id=".$loc." ORDER BY title ASC");
    while ($rowServicesLink = mysqli_fetch_array($sqlServicesLink)) {
        $serviceLinkId=$rowServicesLink['id'];
        $serviceLinkTitle=$rowServicesLink['title'];

        $pagesList .= "<option value='page.php?page_id=" . $serviceLinkId . "&loc_id=".$loc." '>" . $serviceLinkTitle . "</option>";
    }

    $pagesList = "<optgroup label='Existing Pages'>".$pagesList."</optgroup>";
    return $pagesList;
}
// Modal and Dialog Confirm
function showModalConfirm($id, $title, $body, $action){
    echo "<div id='".$id."' class='modal fade' role='dialog' data-keyboard='false' data-backdrop='static'>
    <div class='modal-dialog modal-sm'>
    <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h4 class='modal-title'>".$title."</h4>
    </div>
    <div class='modal-body'>
    <p>".$body."</p>
    </div>
    <div class='modal-footer text-left'>
    <button type='button' class='btn btn-danger' data-dismiss='modal' onclick=\"window.location.href='".$action."'\"><i class='fa fa-trash'></i> Delete</button>
    <button type='button' class='btn btn-link' data-dismiss='modal'>Cancel</button>
    </div>
    </div>
    </div>
    </div>";
}
// Modal Preview using iframe
function showModalPreview($id){
    echo "<div class='modal fade' id='".$id."'>
    <div class='modal-dialog'>
    <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h4 class='modal-title'>&nbsp;</h4>
    </div>
    <div class='modal-body'>
    <iframe id='myModalFile' src='' frameborder='0'></iframe>
    </div>
    <div class='modal-footer text-left'>&nbsp;</div>
    </div>
    </div>
    </div>";
}

// Script to test if extensions/modules are installed and permissions are correct on this server
function checkDependencies(){

    if  (!in_array('curl', get_loaded_extensions())) {
        echo "<div class='alert alert-danger'><span>cURL (php-curl) is not installed on the server.<br/>Try: sudo apt-get install php-curl</span></div>";
    }
    if  (!in_array('xml', get_loaded_extensions())) {
        echo "<div class='alert alert-danger'><span>xml (php-xml) is not installed on the server.<br/>Try: sudo apt-get install php-xml</span></div>";
    }
    if  (!in_array('zip', get_loaded_extensions())) {
        echo "<div class='alert alert-danger'><span>zip (php-zip) is not installed on the server.<br/>Try: sudo apt-get install php-zip</span></div>";
    }
    if  (!in_array('mbstring', get_loaded_extensions())) {
        echo "<div class='alert alert-danger'><span>mbstring (php-mbstring) is not installed on the server.<br/>Try: sudo apt-get install php-mbstring</span></div>";
    }
    if (!in_array('mod_rewrite', apache_get_modules())) {
        echo "<div class='alert alert-danger'><span>Apache module (mod_rewrite) is not enabled on the server.<br/>Try: sudo a2enmod rewrite</span></div>";
    }
    if (!in_array('mod_headers', apache_get_modules())) {
        echo "<div class='alert alert-danger'><span>Apache module (mod_headers) is not enabled on the server.<br/>Try: sudo a2enmod headers</span></div>";
    }
    if (!in_array('mod_vhost_alias', apache_get_modules())) {
       echo "<div class='alert alert-danger'><span>Apache module (mod_vhost_alias) is not enabled on the server.<br/>Try: sudo a2enmod vhost_alias</span></div>";
    }

    // Check if dbconn file exists
    if (!file_exists(dbFileLoc)) {
        echo "<div class='alert alert-danger'><span>".dbFileLoc." does not exist.</span></div>";
    } else {
        if (!is_writeable(dbFileLoc)) {
            echo "<div class='alert alert-danger'><span>".dbFileLoc." is not writable. Check file permissions.</span></div>";
        }
    }
    // Check if blowfishsalt.php file exists
    if (!file_exists(dbBlowfishLoc)) {
        echo "<div class='alert alert-danger'><span>".dbBlowfishLoc." does not exist.</span></div>";
    } else {
        if (!is_writeable(dbBlowfishLoc)) {
            echo "<div class='alert alert-danger'><span>".dbBlowfishLoc." is not writable. Check file permissions.</span></div>";
        }
    }
    // Check if sitemap.xml file exists
    if (!file_exists(sitemapFilename)) {
        echo "<div class='alert alert-danger'><span>".sitemapFilename." does not exist.</span></div>";
    } else {
        if (!is_writeable(sitemapFilename)) {
            echo "<div class='alert alert-danger'><span>".sitemapFilename." is not writable. Check file permissions.</span></div>";
        }
    }
    // Check if robots.txt file exists
    if (!file_exists(robotsFilename)) {
        echo "<div class='alert alert-danger'><span>".robotsFilename." does not exist.</span></div>";
    } else {
        if (!is_writeable(robotsFilename)) {
            echo "<div class='alert alert-danger'><span>".robotsFilename." is not writable. Check file permissions.</span></div>";
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
    $timeout = 10;
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
    global $getVersion;
    global $http_status;

    $updatesURL = updatesServer.'/version.txt';
    $getVersion = getUrlContents($updatesURL);
    $getVersion = trim($getVersion);
    if (!isset($_SESSION['updates_available'])) {
        if ($http_status == 200) {
            if ((string)trim($getVersion) > (string)trim(ysmVersion)){
                return "<a href='updates.php?loc_id=".$_SESSION['loc_id']."'><button type='button' class='btn btn-xs btn-warning' id='updates_btn'><i class='fa fa-bell'></i> Update Available</button></a>";
            }
        } else {
            return false;
        }
    }
    return true;
}
//Set update variables
function getUpdates(){
    checkForUpdates();
    global $getVersion;
    global $updatesRemoteFile;
    global $changeLogFile;
    global $updatesDestination;
    global $updatesCheckerURL;

    $changeLogFile = updatesServer.'/changelog'.$getVersion.'.txt';
    $updatesRemoteFile = updatesServer.'/version'.$getVersion.'.zip';
    $updatesDestination = 'upgrade/version'.$getVersion.'.zip';
    $updatesCheckerURL = updatesServer.'/versionupdatechecker.php';
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
    $page = curl_exec($ch);
    if (!$page) {
        echo 'Error: ' . curl_error($ch) . PHP_EOL;
    }
    if ($curl_errno > 0) {
        echo 'downloadFile() Error ($curl_errno): $curl_error' . PHP_EOL;
        //Delete the downloaded file
        unlink($path);
        return false;
    }
    curl_close($ch);
    return true;
}
// compress all files in the source directory to destination directory
function zipFile($source, $destination, $flag = '') {
    if (!extension_loaded('zip') || !file_exists($source)) {
        return false;
    }

    $zip = new ZipArchive();

    if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $source = str_replace('\\', '/', realpath($source));

    if ($flag) {
        $flag = basename($source) . '/';
    }

    if (is_dir($source) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {

            $file = str_replace('\\', '/', realpath($file));

            if (strpos($flag.$file,$source) !== false) { // this will add only the folder we want to add in zip

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $flag.$file . '/'));
                } elseif (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $flag.$file), file_get_contents($file));
                }
            }
        }
    } elseif (is_file($source) === true) {
        $zip->addFromString($flag.basename($source), file_get_contents($source));
    }

    return $zip->close();
}
//Extract zip files/folder to specified destination
function extractZip($filename, $dest){
    if (is_dir($dest)) {
        // Load up the zip
        $zip = new ZipArchive;
        $unzip = $zip->open($filename);

        $ignoreListArr = array('custom-style.css', 'Thumbs.db', '.DS_Store', 'dbconn.php', 'blowfishsalt.php', 'robots.txt', 'sitemap.xml');

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

function checkIPRange(){
    //If Super Admin then bypass iprange restriction.
    //super admin
    if ($_SESSION['super_admin'] == false){

        //IP Restrictions set in config
        if (defined('IPrange') && !empty(IPrange)) {

            $IPrangeArr = explode(',', IPrange);
            $usersIP = getRealIpAddr();

            if (count($IPrangeArr) > 0 && is_array($IPrangeArr)) {
                foreach ($IPrangeArr as $IPrangeItems) {
                    $IPmatch = str_replace($IPrangeItems, '', $usersIP) != $usersIP;

                    if ($IPmatch){
                        break;
                    }
                }
            } else {
                $IPmatch = true;
            }

            if ($IPmatch === false) {
                header("HTTP/1.1 302 Moved Temporarily");
                header("Location: ../index.php?loc_id=1");
                die('Permission denied. Your IP is ' . $usersIP); //Do not execute any more code on the page
            }
        }
    }
}

//Variable to hide elements from non-admin users
if ($_SESSION['user_level'] == 1 && multiBranch == 'true' && $_GET['loc_id'] == 1 ){
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
} elseif (multiBranch == 'false' && $_GET['loc_id'] != $_SESSION['user_loc_id']){
    header("Location: ?loc_id=1");
    echo "<script>window.location.href='?loc_id=1';</script>";
}
?>