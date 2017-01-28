<?php
//This is the main Config/Setup file for the admin panel and Global variables used throughout the site. Change values as needed.
//Create a virtual host alias for the directory that the project files are in.

require_once('dbconn.php');

//Limit/Lock access to admin panel to a specific IP range. leave off the last octet for range.
//example: "127.0.0."
$IPrange = "";

//Multi-Branch - more than one location
$multiBranch = "true";

//Homepage URL
$homePageURL = "http://www.cps.edu";

//LS2PAC Server Domain or IP
$setupPACURL = "https://pac.library.cps.edu";

//Edit values for your web site. leave as is in most cases.
$image_dir = "../uploads/" . $_GET['loc_id'] . "/"; //physical path to uploads folder

$image_url = "//" . $_SERVER['HTTP_HOST'] . "/uploads/" . $_GET['loc_id'] . "/"; //absolute web url path to uploads folder for tinyMCE

$image_baseURL = "uploads/" . $_GET['loc_id'] . "/"; //relative web url path to uploads folder for tinyMCE

//Upload function
$target_file = $image_dir . basename($_FILES["fileToUpload"]["name"]);

//Navigation options for front-end template
$navSections = array("Top", "Footer", "Search");

//Database Sections
$custSections = array("1", "2", "3");

//Google Analytics UUID Key ex: UA-8675309-1
$googleAnalytics = "";

//Extra Pages
$extraPages = "<optgroup label='Other Pages'><option value='about.php?loc_id=" . $_GET['loc_id'] . "'>About</option><option value='contact.php?loc_id=" . $_GET['loc_id'] . "'>Contact</option><option value='databases.php?loc_id=" . $_GET['loc_id'] . "'>Databases</option><option value='services.php?loc_id=" . $_GET['loc_id'] . "'>Services</option><option value='team.php?loc_id=" . $_GET['loc_id'] . "'>Team</option></optgroup>";

//Session timeout
$sessionTimeout = 30; //mins

//Slide Carousel Speed
$carouselSpeed = "5000"; //5000 = 5secs

//Hash Salt
$hashSalt = "814ff90c56a74b5e2bb48cd240331867a95357e1";

//establish db connection
$db_conn = mysqli_connect($db_servername, $db_username, $db_password);
mysqli_select_db($db_conn, $db_name);

if (mysqli_connect_errno($db_conn)) {
    die("Failed to connect to MySQL: " . mysqli_connect_error($db_conn));
}

//db connection is closed in includes/footer.php
?>