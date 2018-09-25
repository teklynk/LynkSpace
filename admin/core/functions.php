<?php
if (!defined('ALLOW_INC')) {
    die('Direct access not permitted');
}

//Output to browser console
function debugToConsole($data)
{
    $output = $data;

    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}

function getGuid($prefix = false, $entropy = false)
{
    return sha1(uniqid($prefix, $entropy));
}

function loginAttempts($userIp, $maxAttempts, $maxTimeout)
{

    global $db_conn;
    global $loginFailed;

    $sqlGetLoginAttempt = mysqli_query($db_conn, "SELECT ip, attempts, datetime FROM login_attempts WHERE ip='" . $userIp . "';");
    $rowLoginAttempt = mysqli_fetch_array($sqlGetLoginAttempt, MYSQLI_ASSOC);

    $currentTime = strtotime(date('Y-m-d H:i:s'));
    $loginAttemptTime = strtotime($rowLoginAttempt['datetime']);
    $loginAttempts = $rowLoginAttempt['attempts'];
    $loginUserIp = $rowLoginAttempt['ip'];

    if ($rowLoginAttempt) {

        $attempts = $loginAttempts + 1;

        if ($attempts != $maxAttempts) {

            $loginFailed = false;

            $sqlUpdateLoginAttempt = "UPDATE login_attempts SET attempts=" . $attempts . ", datetime=CURRENT_TIMESTAMP() WHERE ip='" . $userIp . "';";
            mysqli_query($db_conn, $sqlUpdateLoginAttempt);

        } else {

            if ($currentTime - $loginAttemptTime >= $maxTimeout) {
                $loginFailed = false;
                $sqlLoginAttemptDelete = "DELETE FROM login_attempts WHERE ip='" . $userIp . "';";
                mysqli_query($db_conn, $sqlLoginAttemptDelete);
            } else {
                $loginFailed = true;
                echo "<style>#wrapper {padding-left: 0 !important;}</style>";
                echo "<div class='alert alert-danger' role='alert'>Maximum failed login attempts has been reached. Please wait " . $maxTimeout . " seconds before trying again. <a href='index.php'>Back to login</a></div>";
                die();
            }

        }

    } else {

        $sqlUpdateLoginAttempt = "INSERT INTO login_attempts (attempts, ip, datetime) VALUES (1, '" . $userIp . "', CURRENT_TIMESTAMP());";
        mysqli_query($db_conn, $sqlUpdateLoginAttempt);
    }

    return $loginFailed;

}

//Import from CSV
function importFromCsv($fileInput, $dbTable)
{
    global $db_conn;
    global $rowCount;
    global $rowInsert;

    //Check if action is Post, File input exists and that file is not empty
    if (!empty($_POST) && !empty($_FILES[$fileInput]) && $_FILES[$fileInput]['size'] > 0) {

        $rowCount = 0;

        $dbTable = db_name . "." . $dbTable;

        //Check if table name exists
        $sqlCheckTable = "SELECT count(*) FROM " . $dbTable . ";";
        $rowCheckTable = mysqli_query($db_conn, $sqlCheckTable);

        if (!$rowCheckTable) {
            die($dbTable . " table does not exist.");
        }

        //Get the csv file
        $csvFile = $_FILES[$fileInput]['tmp_name'];
        $handle = fopen($csvFile, 'r');

        //Get Header row
        $header = fgetcsv($handle, 0, ",", '"');

        //Convert csv array to string
        $headerRowValues = implode(",", $header);

        while (($csvData = fgetcsv($handle, 0, ",", '"')) !== false) {

            $csvValues = '';

            foreach ($csvData as $csvElement) {
                $csvElement = safeCleanStr($csvElement);
                //Check if csv value is an integer, else wrap the value in quotes.
                if (preg_match("/^([0-9]+)$/", $csvElement) || is_numeric($csvElement) || is_int($csvElement) || is_float($csvElement)) {
                    $csvValues .= (int)$csvElement . ",";
                } else {
                    $csvValues .= "'" . (string)$csvElement . "',";
                }
            }

            //Remove the last comma in the string
            $csvValues = rtrim($csvValues, ",");

            if ($csvValues != null || $csvValues != '') {

                $rowCount++;

                $sqlInsert = "INSERT INTO $dbTable ($headerRowValues) VALUES ($csvValues);";
                $rowInsert = mysqli_query($db_conn, $sqlInsert);

            } else {

                $csvData = array();
                $csvValues = null;
                $sqlOffersInsert = null;
                $rowCount = 0;

                fclose($handle);

                return false;
            }

        }

        fclose($handle);

        return true;
    }

    return false;
}

//$type = success, warning, info, danger
function flashMessageSet($type, $message)
{
    if (!isset($_SESSION['message'][$type])) {
        $_SESSION['message'][$type] = "<div class='alert alert-" . $type . "'>" . $message . "</div>";
    }

    return $_SESSION['message'][$type];
}

//$type = success, warning, info, danger
function flashMessageGet($type)
{
    $message = isset($_SESSION['message'][$type]) ? $_SESSION['message'][$type] : null;

    if (!is_null($message)) {
        unset($_SESSION['message'][$type]);
    }

    return $message;
}

//Renders binary images from database or other source.
function renderBinaryImage($mimeType, $fileData)
{
    $imageSource = "data:image/" . $mimeType . ";charset=utf8;base64," . base64_encode($fileData) . "";
    return $imageSource;
}

//File Uploader
function fileUploads($postAction, $target, $maxFileSize = 2048000, $type = null, $type_id = null, $user = null, $loc_id, $uniqueFileNames = true, $storeOnDb = true, $storeOnDisk = true, $allowedFileTypes = array())
{
    global $db_conn;
    global $uploadError;

    if ($postAction) {

	    $uploadError = false;

        //Create upload folder if it does not exist.
        if (is_numeric($_GET['loc_id'])) {
            if (!file_exists($target)) {
                @mkdir($target, 0755);
            }
        }

        //Gets the original file name before converting it.
        $original_file = strtolower(basename($_FILES['fileToUpload']['name']));

        //Check if using uniqueFileNames. Prepend unique string to the front of file names
        if ($uniqueFileNames == true) {
            //Creates a unique id for file name
            $uniqueId = uniqid();
            $target_file = strtolower($target . $uniqueId . '-' . basename($_FILES['fileToUpload']['name'])) ?: NULL;
        } else {
            $target_file = strtolower($target . basename($_FILES['fileToUpload']['name'])) ?: NULL;
        }

        //Get data of file. Used to store file in database as a blob
        if ($storeOnDb == true) {
            $fileData = addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));
        } else {
            $fileData = NULL;
        }

        //Store file inside the uploads directory if true
        if ($storeOnDisk == true) {
            $uploadFile = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file);
        } else {
            $uploadFile = $target_file;
        }

        //Upload the file
        if ($uploadFile) {

            //Get file info
            $fileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)) ?: NULL;
            $fileName = strtolower(pathinfo($target_file, PATHINFO_BASENAME)) ?: NULL;
            $fileMime = strtolower(basename($_FILES['fileToUpload']['type'])) ?: NULL;
            $fileSize = basename($_FILES['fileToUpload']['size']) ?: NULL;
            $fileSizeLimit = $maxFileSize;

            //Check if file is allowed
            if (in_array($fileExt, $allowedFileTypes)) {

                //Check if file is less than 2mb
                if ($fileSize <= $fileSizeLimit) {

                    //rename file if it contains spaces, parenthesis, apostrophes or other characters and low case the file name
                    $search = array('(', ')', ' ', '\'', ':', ';', '@', '!', '?');
                    $replace = array('-', '-', '-', '-', '-', '-', '', '', '');

                    //Get file if file name matches existing filename else return null
                    $sqlUploads = mysqli_query($db_conn, "SELECT * FROM uploads WHERE type_id=" . $type_id . " AND orig_file_name='" . $original_file . "' AND loc_id=" . $loc_id . " LIMIT 1;");
                    $rowUploads = mysqli_fetch_array($sqlUploads, MYSQLI_ASSOC);

                    if ($uniqueFileNames == false && $rowUploads['orig_file_name'] == $original_file){
                        //Update existing file in the database, where guid=$uploads_row['guid']
                        $sqlUpdateUploads = "UPDATE uploads SET datetime = '" . date("Y-m-d H:i:s") . "', file_name = '" . $original_file . "', file_data = '" . $fileData . "' WHERE guid = '" . $rowUploads['guid'] . "' AND loc_id=" . $loc_id . ";";
                        mysqli_query($db_conn, $sqlUpdateUploads) OR DIE(mysqli_error($db_conn));
                    } else {
                        //Save uploaded file to the database
                        $sqlInsertUploads = "INSERT INTO uploads (type, type_id, file_name, orig_file_name, file_data, file_ext, file_mime, file_size, author_name, guid, datetime, loc_id) VALUES ('" . $type . "', " . $type_id . ", '" . $fileName . "', '" . $original_file . "', '" . $fileData . "', '" . $fileExt . "', '" . $fileMime . "', " . $fileSize . ", '" . $user . "', '" . getGuid() . "', '" . date("Y-m-d H:i:s") . "', " . $_GET['loc_id'] . ");";
                        mysqli_query($db_conn, $sqlInsertUploads) OR DIE(mysqli_error($db_conn));
                    }

                    if (file_exists($target_file)) {
                        rename($target_file, str_replace($search, $replace, strtolower($target_file)));
                    }

                } else {

                    if (file_exists($target_file)) {
                        $uploadError = true;
                        //Delete the file if it is too large
                        unlink($target_file) OR DIE('Could not delete file');
                    }

                }

            } else {

                //Delete the file if it is not an image
                if (file_exists($target_file)) {
	                $uploadError = true;
                    unlink($target_file) OR die('Could not delete file');
                }

            }

        } else {
	        $uploadError = true;
        }
    }
}

function getAllUploads($type_id=null, $type=null, $loc_id, $orderBy='DESC')
{
    global $db_conn;

    $sqlUploads = mysqli_query($db_conn, "SELECT * FROM uploads WHERE type_id = " . $type_id . " AND type='" . $type . "' AND loc_id=" . $loc_id . " ORDER BY datetime " . $orderBy . ";");
    $rowUploads = mysqli_fetch_all($sqlUploads, MYSQLI_ASSOC);

    return $rowUploads;
}

function getSingleUploads($arg_id, $guid)
{
    global $db_conn;

    $sqlSingleUploads = mysqli_query($db_conn, "SELECT * FROM uploads WHERE id = " . $arg_id . " AND guid='" . $guid . "' LIMIT 1;");
    $rowSingleUploads = mysqli_fetch_array($sqlSingleUploads, MYSQLI_ASSOC);

    return $rowSingleUploads;
}

function deleteUploads($target, $arg_id, $guid)
{
    global $db_conn;

    $uploads_sql = mysqli_query($db_conn, "SELECT * FROM uploads WHERE id = " . $arg_id . " AND guid = '" . $guid . "' LIMIT 1;");
    $uploads_row = mysqli_fetch_array($uploads_sql, MYSQLI_ASSOC);

    //Get the file name
    $fileName = $uploads_row['file_name'];

    if ($arg_id == $uploads_row['id'] && $guid == $uploads_row['guid']) {
        //Remove file from the database
        $uploads_sql = "DELETE FROM uploads WHERE id = " . $arg_id . " AND guid = '" . $guid . "' LIMIT 1;";
        mysqli_query($db_conn, $uploads_sql) OR die('SQL Error: ' . $uploads_sql);

        //Delete file from uploads folder
        if (file_exists($target . $fileName)){
            unlink($target . $fileName) OR die('Could not delete file');
        }
    }

    return true;
}

//Resizes image for thumbnails
function resizeImage($imagePath, $resizedFileName, $width = '200', $height = '200')
{
    $image = new Imagick();
    $image_filehandle = fopen($imagePath, 'a+');
    $image->readImageFile($image_filehandle);
    $image->scaleImage($width, $height, true);
    $image_resize_filehandle = fopen($resizedFileName, 'a+');
    $image->writeImageFile($image_resize_filehandle);
}

//File size conversion to KB, MB, GB....
function filesizeFormatted($theFile, $readFile=false)
{

    if ($readFile == true) {
        $size = filesize($theFile); //read file from disk and convert the file size
    } else {
        $size = $theFile; //convert number
    }

    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $power = $size > 0 ? floor(log($size, 1024)) : 0;

    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

//Random password generator for password reset - generates characters, symbol and number
function generateRandomPasswordString()
{
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
function generateRandomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return md5($randomString);
}

//Renames directory if it exists
function renameDir($oldname, $newname)
{
    if (file_exists(dirname($oldname))) {
        return rename($oldname, $newname);
    } else {
        return false;
    }
}

//Random Blowfish Salt
function blowfishSaltRandomString($saltThisString)
{
    return password_hash($saltThisString, PASSWORD_DEFAULT);
}

//Generates a drop down list of theme thumbnails
function getThemesDropdownList($theme_selected)
{
    global $themesStr;

    // Get theme names from themes folder
    $themeDirectories = glob('../themes/*', GLOB_ONLYDIR);

    // Build themes drop down list
    foreach ($themeDirectories as $themes) {
        $themes = str_replace('../themes/', '', $themes);
        $themesImg = '../themes/' . $themes . '/screenshot.png';
        $themesThumbnail = '../themes/' . $themes . '/screenshot_thumb.png';

        if ($themes == $theme_selected) {
            $isThemeSelected = ' SELECTED ';
        } else {
            $isThemeSelected = '';
        }

        echo "<option data-ays-ignore='true' data-content=\"<span class='img-label'><img class='img-select-option' src='" . $themesThumbnail . "'/>&nbsp;" . ucwords($themes) . "</span>\" value='" . $themes . "' $isThemeSelected>" . ucwords($themes) . "</option>";

    }
}

//Fontawesome icon list
function getIconDropdownList($icon_selected)
{
    global $db_conn;

    $sqlServicesIcon = mysqli_query($db_conn, "SELECT icon FROM icons_list ORDER BY icon ASC;");
    while ($rowIcon = mysqli_fetch_array($sqlServicesIcon, MYSQLI_ASSOC)) {
        $icon = $rowIcon['icon'];
        if ($icon === $icon_selected) {
            $iconCheck = ' SELECTED ';
        } else {
            $iconCheck = '';
        }
        echo "<option class='icon-select-option' data-ays-ignore='true' data-icon='fa fa-" . $icon . "' value='" . $icon . "' " . $iconCheck . ">" . $icon . "</option>";
    }
}

//Get gravatar image based on users email value
function getGravatar($email, $size)
{
    $default = "//cdn2.iconfinder.com/data/icons/basic-4/512/user-24.png";

    return "//www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?d=" . urlencode($default) . "&s=" . $size . "&secure=true";
}

//Cleans strings - removes html characters, trims spaces, converts to html entities.
function safeCleanStr($cleanStr)
{
    return htmlspecialchars(strip_tags(trim((STRING)$cleanStr)), ENT_QUOTES);
}

//escape Quotes in textareas and string values - Escape special characters in a string
function sqlEscapeStr($cleanStr)
{
    global $db_conn;

    return mysqli_real_escape_string($db_conn, trim((STRING)$cleanStr));
}

//sanitize string - Remove all HTML tags from a string
function sanitizeStr($cleanStr)
{
    return filter_var(trim((STRING)$cleanStr), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

//sanitize integers - removes anything that is not a number
function sanitizeInt($cleanInt) {
    $cleanInt = preg_replace("/[^0-9]/","", $cleanInt);

    if ($cleanInt == "") {
        $cleanInt = 0;
    }

    return filter_var(trim((INT)$cleanInt), FILTER_SANITIZE_NUMBER_INT);
}

//validate url - Check if the variable $cleanStr is a valid URL
function validateUrl($cleanStr)
{
    global $errorMsg;
    if (!filter_var($cleanStr, FILTER_VALIDATE_URL) == false) {
        return filter_var(trim($cleanStr), FILTER_SANITIZE_URL);
    } else {
        $errorMsg = "<div class='alert alert-danger fade in' data-alert='alert'>" . $cleanStr . " URL is not valid<button type='button' class='close' data-dismiss='alert'>×</button></div>";

        return false;
    }
}

//validate email - Check if the variable $email is a valid email address
function validateEmail($cleanStr)
{
    global $errorMsg;
    if (!filter_var($cleanStr, FILTER_VALIDATE_EMAIL) === false) {
        return filter_var(trim($cleanStr), FILTER_SANITIZE_EMAIL);
    } else {
        $errorMsg = "<div class='alert alert-danger fade in' data-alert='alert'>" . $cleanStr . " Email is not valid<button type='button' class='close' data-dismiss='alert'>×</button></div>";

        return false;
    }
}

//Gets clients real IP address
function getRealIpAddr()
{
    global $clientip;

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $clientip = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $clientip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $clientip = filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP);
    } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $clientip = filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP);
    } else {
        $clientip = "Client IP Not Found";
    }

    return $clientip;
}

//Location list for level 1 admins only
function getLocList($active = null, $showActiveOnly)
{
    global $locList;
    global $db_conn;

    //Selects Active of InActive locations.
    if ($showActiveOnly == 'true') {
        $showActive = "WHERE active='true'";
    } else {
        $showActive = "";
    }

    $sqlGetLocSearch = mysqli_query($db_conn, "SELECT id, name, active FROM locations " . $showActive . " ORDER BY name ASC;");

    while ($rowLocationSearch = mysqli_fetch_array($sqlGetLocSearch, MYSQLI_ASSOC)) {
        if ($rowLocationSearch['id'] == 1) {
            $isDefault = " (Default)";
        } else {
            $isDefault = "";
        }
        //Check if action value is a list - used for multi-selects
        if (strpos(safeCleanStr($active), ',') !== false) {
            $activeList = explode(',', $active); //Convert the list into an array

            //Check if item is in the array
            if (in_array($rowLocationSearch['id'], $activeList)) {
                $isSectionSelected = ' SELECTED ';
            } else {
                $isSectionSelected = '';
            }
        } else {
            //Check if action value is a single item
            if (safeCleanStr($rowLocationSearch['id']) == safeCleanStr($active)) {
                $isSectionSelected = ' SELECTED ';
            } else {
                $isSectionSelected = '';
            }
        }
        $locList .= "<option class='loc_list_option' data-icon='fa fa-fw fa-university' value='" . $rowLocationSearch['id'] . "' " . $isSectionSelected . ">" . $rowLocationSearch['name'] . $isDefault . "</option>";
    }

    return $locList;
}

function getLocGroups($active = null)
{
    global $locTypes;
    global $locMenuStr;
    //loop through the array of location Types
    $locMenuStr = "";
    $locArrlength = count($locTypes);

    for ($x = 0; $x < $locArrlength; $x++) {
        if (safeCleanStr($locTypes[$x]) == safeCleanStr($active)) {
            $isSectionSelected = ' SELECTED ';
        } else {
            $isSectionSelected = '';
        }
        $locMenuStr .= "<option value=" . safeCleanStr($locTypes[$x]) . " " . $isSectionSelected . ">" . safeCleanStr($locTypes[$x]) . "</option>";
    }

    return $locMenuStr;
}

//Get extra pages from config
function getExtraPages($pagesArray)
{

    $extraPages = '';

    foreach ($pagesArray as $label => $value) {
        $extraPages .= "<option value='" . $value . "'>" . $label . "</option>";
    }

    return "<optgroup label='Additional Site Pages'>" . $extraPages . "</optgroup>";
}

//Get existing Pages
function getPages($loc)
{
    global $pagesList;
    global $extraPagesArray; //from config.php
    global $db_conn;

    $sqlServicesLink = mysqli_query($db_conn, "SELECT id, title FROM pages WHERE active='true' AND loc_id=" . $loc . " ORDER BY title ASC;");
    while ($rowServicesLink = mysqli_fetch_array($sqlServicesLink, MYSQLI_ASSOC)) {
        $serviceLinkId = $rowServicesLink['id'];
        $serviceLinkTitle = $rowServicesLink['title'];

        $pagesList .= "<option value='page.php?page_id=" . $serviceLinkId . "&loc_id=" . $loc . " '>" . $serviceLinkTitle . "</option>";
    }

    $pagesList = "<optgroup label='Existing Pages'>" . $pagesList . "</optgroup>" . getExtraPages($extraPagesArray);

    return $pagesList;
}

//List files inside a directory/folder
function getDirContents($src)
{

    global $fileIgnoreArray;

    if ($handle = opendir($src)) {

        echo "<ul>";

        while (false !== ($file = readdir($handle))) {

            if (in_array($file, $fileIgnoreArray)) {
                continue;
            }

            echo "<li>" . $file . "</li>";
        }

        closedir($handle);

        echo "</ul>";

        return true;
    } else {
        return false;
    }

}

//Images folder drop down list
function getImageDropdownList($loc, $imageDir, $image_selected)
{
    global $db_conn;
    global $sharedFilesList;
    global $fileList;
    global $fileIgnoreArray;

    $sharedFilesListArr[] = null;
    $allfiles[] = null;

    //Build a list of shared images
    $sqlSharedList = mysqli_query($db_conn, "SELECT shared, filename FROM shared_uploads ORDER BY filename ASC;");
    while ($rowSharedList = mysqli_fetch_array($sqlSharedList, MYSQLI_ASSOC)) {

        $sharedOptions = $rowSharedList['shared'];
        $sharedFileName = $rowSharedList['filename'];

        $sharedOptionsArr = explode(',', trim($sharedOptions));

        if (in_array($loc, $sharedOptionsArr) || in_array($_SESSION['loc_type'], $sharedOptionsArr)) {
            $sharedFilesList .= $sharedFileName . ',';
        }
    }

    $sharedFilesListArr = explode(",", trim($sharedFilesList, ','));

    if ($handle = opendir($imageDir)) {

        while (false !== ($file = readdir($handle))) {

            if (in_array($file, $fileIgnoreArray)) {
                continue;
            }

            $allfiles[] = strtolower($file);
        }
        closedir($handle);
    }

    //Merge the lists / arrays
    $allImagesArr = array_merge($allfiles, $sharedFilesListArr);
    sort($allImagesArr);

    foreach ($allImagesArr as $file) {
        if (in_array($file, $sharedFilesListArr)) {
            $location = '../uploads/1/';
        } else {
            $location = '../uploads/' . $loc . '/';
        }
        if ($location . $file === $image_selected) {
            $imageCheck = ' SELECTED ';
        } else {
            $imageCheck = '';
        }
        if ($file != '') {
            $fileList .= "<option data-ays-ignore='true' data-content=\"<span class='img-label'><img class='img-select-option' src='" . $location . $file . "'/>&nbsp;" . $file . "</span>\" value='" . $location . $file . "' $imageCheck>" . $file . "</option>";
        }
    }
    echo $fileList;

}

//Get list of shared files for the specific location id.
function getFilesJsonList($loc)
{
    $fileListJson = null;

    $fileList = getAllUploads(1, 'upload', $loc, 'ASC'); //returns an array

    foreach ($fileList as $imgfiles) {
        $fileListJson .= "{title: '" . $imgfiles['file_name'] . "', value: '" . image_url . $imgfiles['file_name'] . "'},"; //creates a json list of images
    }

    $fileListJson = ltrim($fileListJson, ',');
    $fileListJson = rtrim($fileListJson, ',');

    return $fileListJson;

}

function getPagesJsonList($loc)
{
    global $linkListJson;
    global $db_conn;

    //get and build page list for TinyMCE
    $sqlGetPages = mysqli_query($db_conn, "SELECT id, title, active FROM pages WHERE active='true' AND loc_id=" . $loc . " ORDER BY title;");
    while ($rowGetPages = mysqli_fetch_array($sqlGetPages, MYSQLI_ASSOC)) {
        $getPageId = $rowGetPages['id'];
        $getPageTitle = $rowGetPages['title'];
        if ($getPageTitle != '') {
            $linkListJson .= "{title: '" . $getPageTitle . "', value: 'page.php?loc_id=" . $_GET['loc_id'] . "&page_id=" . $getPageId . "'},"; //Create a json list of pages
        }
    }
    //Clean string
    $linkListJson = ltrim($linkListJson, ',');
    $linkListJson = rtrim($linkListJson, ',');

    return $linkListJson;

}

// Modal and Dialog Confirm
function showModalConfirm($id, $title, $body, $action, $custom = false)
{
    echo "<div id='" . $id . "' class='modal fade' role='dialog' data-keyboard='false' data-backdrop='static'>
    <div class='modal-dialog modal-sm'>
    <div class='modal-content'>
    <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal'>&times;</button>
    <h4 class='modal-title'>" . $title . "</h4>
    </div>
    <div class='modal-body'>
    <p>" . $body . "</p>
    </div>
    <div class='modal-footer text-left'>";

    if ($custom == false || $custom == null || $custom == '') {
        echo "<button type='button' class='btn btn-danger' onclick=\"window.location.href='" . $action . "'\"><i class='fa fa-trash'></i> Delete</button>
                <button type='button' class='btn btn-link' data-dismiss='modal'>Cancel</button>";
    } else {
        echo $action;
    }

    echo "</div>
    </div>
    </div>
    </div>";
}

// Modal Preview using iframe
function showModalPreview($id)
{
    echo "<div class='modal fade' id='" . $id . "'>
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
function checkDependencies()
{
    $apacheModulesArray = array(
        'mod_rewrite',
        'mod_headers',
        'mod_vhost_alias'
    );

    $phpExtentionsArray = array(
        'curl',
        'xml',
        'zip',
        'imagick',
        'mbstring',
        'mcrypt',
        'mysqli',
        'mysqlnd'
    );

    $filesArray = array(
        dbFileLoc,
        dbBlowfishLoc,
        sitemapFilename,
        robotsFilename
    );

    foreach ($apacheModulesArray as $module) {
        if (!in_array($module, apache_get_modules())) {
            echo "<div class='alert alert-danger'><span>" . $module . " is not installed on the server.</span></div>";
        }
    }

    foreach ($phpExtentionsArray as $extention) {
        if (!in_array($extention, get_loaded_extensions())) {
            echo "<div class='alert alert-danger'><span>" . $extention . " is not installed on the server.</span></div>";
        }
    }

    foreach ($filesArray as $file) {
        if (!file_exists($file) || !is_writable($file)) {
            echo "<div class='alert alert-danger'><span>" . $file . " does not exist and/or is not writable.</span></div>";
        }
    }
}

//Copy folder contents to another
function recurseCopy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst, 0755, true);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                recurseCopy($src . '/' . $file, $dst . '/' . $file);
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

//Deletes files inside a directory ($src)
function recurseDelete($src)
{
    array_map('unlink', glob($src));
}

//Database Dump Backup
function databaseDumpBackup($dest)
{

    global $db_conn;

    $sql = "SHOW TABLES FROM " . db_name . ";";
    $result = mysqli_query($db_conn, $sql);

    //Turn off foreign key constraints
    mysqli_query($db_conn, 'SET FOREIGN_KEY_CHECKS=0');

    while ($row = mysqli_fetch_row($result)) {

        $backup_file = $dest . $row[0] . '-' . date("Y-m-d-H-i-s") . '.csv';
        mysqli_query($db_conn, "SELECT * INTO OUTFILE '" . $backup_file . "' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' FROM " . $row[0] . ";");

        if (mysqli_error($db_conn)) {
            die('Could not make a database backup: ' . mysqli_error($db_conn));
        }

    }

    //Turn on foreign key constraints
    mysqli_query($db_conn, 'SET FOREIGN_KEY_CHECKS=1');
    mysqli_free_result($result);

}

//Remove Directory
function rrmDir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) == "dir") {
                    rrmDir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rrmDir($dir);
    }
}

//cURL a URL to get contents
function getUrlContents($getUrl)
{
    global $http_status;

    $ch = curl_init($getUrl);
    $timeout = 30;
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, 400);
    $data = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo '<div class="updates_error clearfix">HTTP status : ' . $http_status . ' : Error loading URL.</div>';
        curl_close($ch);
    }
    curl_close($ch);

    return $data;
}

//Check if a new version is available
function checkForUpdates()
{
    //global $getVersion;
    global $http_status;

    //Checks the version.txt on the remote server (github master branch)
    $getVersion = getUrlContents(trim(updatesDownloadServer));

    if ($http_status == 200) {
        if ((string)trim($getVersion) > (string)trim(ysmVersion)) {
            echo "<a href='" . updatesServer . "' target='_blank'><button type='button' class='btn btn-xs btn-warning' id='updates_btn'><i class='fa fa-bell'></i> Update Available</button></a>";
        } else {
            echo '<span></span>';
        }
    } else {
        echo '<span></span>';
    }

    return true;
}


//Download file and save to a directory on the server
function downloadFile($url, $path)
{
    //example: downloadFile($updatesUrl, 'upgrade/version.zip');
    $fileResource = fopen($path, 'w');
    // Get The Zip File From Server
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
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
    if ($curl_errno > 0) {
        echo '<div class="updates_error clearfix">Error : ' . $curl_errno . $page . ' : Error loading URL.</div>';
        //Delete the downloaded file
        unlink($path) OR die('Could not delete file');;

        return false;
    }
    curl_close($ch);

    return true;
}

// compress all files in the source directory to destination directory
function zipFile($src, $dest)
{
    if (!extension_loaded('zip') || !file_exists($src)) {
        return false;
    }

    $flag = '';

    $zip = new ZipArchive();

    if (!$zip->open($dest, ZIPARCHIVE::CREATE)) {
        return false;
    }

    $src = str_replace('\\', '/', realpath($src));

    if ($flag) {
        $flag = basename($src) . '/';
    }

    if (is_dir($src) === true) {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {

            $file = str_replace('\\', '/', realpath($file));

            if (strpos($flag . $file, $src) !== false) { // this will add only the folder we want to add in zip

                if (is_dir($file) === true) {

                    $zip->addEmptyDir(str_replace($src . '/', '', $flag . $file . '/'));

                } elseif (is_file($file) === true) {

                    $zip->addFromString(str_replace($src . '/', '', $flag . $file), file_get_contents($file));

                }
            }
        }

    } elseif (is_file($src) === true) {
        $zip->addFromString($flag . basename($src), file_get_contents($src));
    }

    sleep(3);

    return $zip->close();
}

//Extract zip files/folder to specified destination
function extractZip($filename, $dest, $ignoreListArr)
{
    if (is_dir($dest)) {
        // Load up the zip
        $zip = new ZipArchive;
        $unzip = $zip->open($filename);

        //$ignoreListArr = array('custom-style.css', 'Thumbs.db', '.DS_Store', 'dbconn.php', 'blowfishsalt.php', 'robots.txt', 'sitemap.xml');

        if ($unzip === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
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
                    @mkdir($dir, 0755, true);
                }

                // Check if $name is a file or directory
                if (substr($file, -1) == "/") {
                    // $name is a directory
                    // Create the directory
                    if (!is_dir($file)) {
                        @mkdir($file, 0755, true);
                    }

                } else {
                    // $name is a file
                    // Read from Zip and write to disk

                    if ('.' === $file) {
                        continue;
                    }
                    if ('..' === $file) {
                        continue;
                    }
                    if (in_array($file, $ignoreListArr)) {
                        continue;
                    }

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

function checkIPRange()
{
    //IP Restrictions set in config
    if (defined('IPrange') && !empty(IPrange)) {

        //Turn the string into an array
        $IPrangeArr = explode(',', IPrange);
        //Get users IP address
        $usersIP = getRealIpAddr();

        $IPmatch = '';

        if (count($IPrangeArr) > 0 && is_array($IPrangeArr)) {
            foreach ($IPrangeArr as $IPrangeItems) {
                $IPmatch = str_replace($IPrangeItems, '', $usersIP) != $usersIP;

                if ($IPmatch) {
                    break;
                }
            }
        } else {
            $IPmatch = true;
        }

        if ($IPmatch === false) {
            header("Location: ../index.php?loc_id=1", true, 302);
            die('Permission denied. Your IP is ' . $usersIP); //Do not execute anymore code on the page
        }
    }
}

function dateTimeFormat($format = null, $date = null)
{
    switch ($format) {
        case 1:
            return date("Y-m-d", strtotime(safeCleanStr($date)));
            break;
        case 2:
            return date("m-d-Y", strtotime(safeCleanStr($date)));
            break;
        default:
            return date("m-d-Y", strtotime(safeCleanStr($date)));
    }
}

//Simple SQL CRUD statements
function dbQuery($method = null, $table = null, $fields = null, $values = null, $where = null, $orderBy = null)
{
    $query = null;
    $clause = null;
    $order = null;
    $tableDb = null;
    $query = null;
    $queryExecute = null;

    //Create connection
    global $db_conn;

    if (isset($table)) {
        $tableDb = "`" . db_name . "`.`" . $table . "`";
    }

    if (isset($where)) {
        $clause = " WHERE " . trim($where);
    } else {
        $clause = "";
    }

    if (isset($orderBy)) {
        $order = " ORDER BY " . trim($orderBy);
    } else {
        $order = "";
    }

    if (isset($method)) {
        switch ($method) {
            case "select":
                $query = "SELECT " . $fields . " FROM " . $tableDb . $clause . $order . ";";
                break;
            case "insert":
                $query = "INSERT INTO " . trim($tableDb) . " (" . trim($fields) . ") VALUES (" . trim($values) . ")" . ";";
                break;
            case "update":
                $fields = explode(",", $fields);
                $values = explode(",", $values);
                $count = count($fields);
                $fieldValues = "";

                for ($i = 0; $i < $count; $i++) {
                    $fieldValues .= trim($fields[$i]) . "=" . trim($values[$i]) . ",";
                }

                $query = "UPDATE " . $tableDb . " SET " . rtrim($fieldValues, ",") . $clause . $order . ";";
                break;
            case "delete":
                $query = "DELETE FROM " . $tableDb . $clause . ";";
                break;
            default:
                $query = null;
                $queryExecute = null;
        }


        $queryExecute = mysqli_query($db_conn, $query);

        if ($db_conn->connect_error || $queryExecute == false) {
            die("Error: " . $method . " : " . $query . " : " . $db_conn->connect_error);
        }

        return $queryExecute;

    } else {

        return false;

    }
}

//CSRF token validation
function csrf_validate($token)
{
    if (!empty($_POST)) {
        if (safeCleanStr($_POST['csrf']) != $token) {
            //Clear session.
            session_unset();
            //TODO: log errors
            die('Direct access not permitted');
        }
    }
    print_r($token);
}

//Variable to hide elements from non-admin users
if ($_SESSION['user_level'] == 1 && multiBranch == 'true' && $_GET['loc_id'] == 1) {
    $adminOnlyShow = "";
    $adminIsCheck = "true";
} else {
    $adminOnlyShow = "style='display:none !important;'";
    $adminIsCheck = "false";
}

//if not user level = 1 then keep the user on their own location. if loc_id is changed in querystring, redirect user back to their own loc_id.
if ($_SESSION['user_level'] != 1 && $_GET['loc_id'] != $_SESSION['user_loc_id']) {
    header("Location: ?loc_id=" . $_SESSION['user_loc_id'] . "", true, 302);
    echo "<script>window.location.href='?loc_id=" . $_SESSION['user_loc_id'] . "';</script>";
} elseif ($_SESSION['user_level'] == 1 && $_GET['loc_id'] == "") {
    header("Location: ?loc_id=1", true, 302);
    echo "<script>window.location.href='?loc_id=1';</script>";
} elseif (multiBranch == 'false' && $_GET['loc_id'] != $_SESSION['user_loc_id']) {
    header("Location: ?loc_id=1", true, 302);
    echo "<script>window.location.href='?loc_id=1';</script>";
}

?>
