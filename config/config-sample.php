<?php
//This is the main Config/Setup file for the admin panel and Global variables used throughout the site. Change values as needed.
//Create a virtual host alias for the directory that the project files are in.

require_once('dbconn.php');

if (basename($_SERVER['PHP_SELF']) != 'install.php') {

    //Establish config connection
    $db_conn = mysqli_connect(db_servername, db_username, db_password);
    mysqli_select_db($db_conn, db_name);

    //$db = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin123");

    if (mysqli_connect_error()) {
        $db_conn = NULL;
        echo "Go to <a href='../admin/install.php'>".$_SERVER['SERVER_NAME']."/admin/install.php</a> to install the database. " . PHP_EOL;
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    $sqlConfig = mysqli_query($db_conn, "SELECT theme, iprange, multibranch, loc_types, homepageurl, setuppacurl, searchlabel_ls2pac, searchlabel_ls2kids, searchplaceholder_ls2pac, searchplaceholder_ls2kids, customer_id, session_timeout, carousel_speed, analytics FROM config WHERE id=1");
    $rowConfig = mysqli_fetch_array($sqlConfig, MYSQLI_ASSOC);
}

//Protocol-relative/agnostic
$serverProtocol = '//';

//Get server host name
$serverHostname = $_SERVER['SERVER_NAME'];

//Get server port number. if not port 80
if ($_SERVER['SERVER_PORT'] == 80 || $_SERVER['SERVER_PORT'] == 443) {
    $serverPort = '';
} else {
    $serverPort = ':'.$_SERVER['SERVER_PORT'];
}

//Get Sub-folder name
$subURL = $_SERVER['REQUEST_URI'];
$subPath = parse_url($subURL, PHP_URL_PATH);
$subDir = explode('/', $subPath)[1];
$subDir = trim($subDir);

if (strpos($subDir, 'admin') !== false || strpos($subDir, '.php') !== false) {
    $subDirectory = '';
} else {
    $subDirectory = '/'.$subDir;
}

//CMS branding, title, description
define('cmsTitle', 'LynkSpace');
define('cmsDescription', 'small, simple, cms');
define('cmsWebsite', 'http://www.lynkspace.com');

//Build the server url string
define('serverUrlStr', $serverProtocol . $serverHostname . $serverPort . $subDirectory);

//Theme value
define('themeOption', $rowConfig['theme']);

//Limit/Lock access to admin panel to a specific IP range. leave off the last octet for range.
//example: "127.0.0."
define('IPrange', $rowConfig['iprange']);

//Multi-Branch - more than one location
//true or false
define('multiBranch', $rowConfig['multibranch']);

//Homepage URL
define('homePageURL', $rowConfig['homepageurl']);

//LS2PAC Server Domain or IP
define('setupPACURL', $rowConfig['setuppacurl']);

//LS2PAC Label
define('setupLS2PACLabel', $rowConfig['searchlabel_ls2pac']);

//LS2Kids Label
define('setupLS2KidsLabel', $rowConfig['searchlabel_ls2kids']);

//LS2PAC Placeholder
define('setupLS2PACPlaceholder', $rowConfig['searchplaceholder_ls2pac']);

//LS2Kids Placeholder
define('setupLS2KidsPlaceholder', $rowConfig['searchplaceholder_ls2kids']);

//Web Site Analytics
define('site_analytics', $rowConfig['analytics']);

//Customer Number
define('customerNumber', $rowConfig['customer_id']);

//Edit values for your web site. leave as is in most cases.
//physical path to uploads folder
define('image_dir', "../uploads/" . $_GET['loc_id'] . "/");

//Absolute web url path to uploads folder for tinyMCE
define('image_url', serverUrlStr . "/uploads/" . $_GET['loc_id'] . "/");

//Relative web url path to uploads folder for tinyMCE
define('image_baseURL', "uploads/" . $_GET['loc_id'] . "/");

// Name of the dbconn file
define('dbFileLoc', __DIR__ . "/dbconn.php");

// Name of the config file
define('dbConfigLoc', __DIR__ . "/config.php");

// Name of the blowfish file
define('dbBlowfishLoc', __DIR__ . "/blowfishsalt.php");

// Name of the Source sql dump file
define('dbFilename', __DIR__ . "/new_website.sql");

// Name of the sitemap file
define('sitemapFilename', __DIR__ . "/../sitemap.xml");

// Name of the robots.txt file
define('robotsFilename', __DIR__ . "/../robots.txt");

//Navigation options for front-end template
$navSections = array("Top", "Footer", "Search");

//Location Types
$defaultLocTypes = array("Default", "All");
$explodedLocTypes = explode(',', $rowConfig['loc_types']);

if (multiBranch == 'true') {
    $locTypes = array_merge($defaultLocTypes,$explodedLocTypes); //returns an array
} else {
    $locTypes = 'Default';
}

//Extra Pages
$extraPages = "<optgroup label='Additional Site Pages'><option value='about.php?loc_id=" . $_GET['loc_id'] . "'>About</option><option value='contact.php?loc_id=" . $_GET['loc_id'] . "'>Contact</option><option value='databases.php?loc_id=" . $_GET['loc_id'] . "'>Databases</option><option value='services.php?loc_id=" . $_GET['loc_id'] . "'>Services</option><option value='staff.php?loc_id=" . $_GET['loc_id'] . "'>Staff</option><option value='sitesearch.php?loc_id=" . $_GET['loc_id'] . "'>Site Search</option></optgroup>";

//Session timeout
//3600 = 60mins
if ($rowConfig['session_timeout'] == NULL){
    $session_timeout_minutes = 3600;
} else {
    $session_timeout_minutes = $rowConfig['session_timeout'] * 60;
}
define('sessionTimeout', $session_timeout_minutes);

//Slide Carousel Speed
//5000 = 5secs
if ($rowConfig['carousel_speed'] == NULL){
    $carousel_speed_seconds = 5000;
} else {
    $carousel_speed_seconds = $rowConfig['carousel_speed'] * 60;
}
$carousel_speed_seconds = $rowConfig['carousel_speed'] * 1000;
define('carouselSpeed', $carousel_speed_seconds);

//Blowfish Salt goes here after the installer runs.
require_once('blowfishsalt.php');

//Recaptcha API Key
define('recaptcha_secret_key', "");
define('recaptcha_site_key', "");

//Version Number
$versionFile = __DIR__ . 'version.txt';
$versionFile = str_replace('config', '', $versionFile);
define('ysmVersion', file_get_contents($versionFile));

//Updates remote URL requires: http:// or https://
define('updatesServer', "https://raw.githubusercontent.com/teklynk/LynkSpace/master/");

//Help URLs
define('helpURLUser', "#");
define('helpURLAdmin', "#");

//html5 pattern property for input type=email
define('emailValidationPattern', "(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&amp;'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,25}");

//html5 date validation - Full Date Validation (MM/DD/YYYY)
define('dateValidationPattern', "(?:(?:0[1-9]|1[0-2])[\/\\-. ]?(?:0[1-9]|[12][0-9])|(?:(?:0[13-9]|1[0-2])[\/\\-. ]?30)|(?:(?:0[13578]|1[02])[\/\\-. ]?31))[\/\\-. ]?(?:19|20)[0-9]{2}");

//html5 URL validation pattern
define('urlValidationPattern', "^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?");

//html5 password validation pattern
define('passwordValidationPattern', "(?=(?:[^a-zA-Z]*[a-zA-Z]){4})(?=(?:\D*\d){1}).*");
define('passwordValidationTitle', "1 or more digits and a minimum of 4 letters are required");

//define variables used throughout the site.
$errorMsg = '';
$pageMsg = '';
?>