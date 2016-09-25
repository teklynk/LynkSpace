<?php
//This is the main Config/Setup file for the admin panel.

include 'dbconn.php';

//Limit/Lock access to admin panel to a specific IP range. leave off the last octet for range.
//example: "192.168.0."
$IPrange = "";

//Edit values for your web site. leave as is in most cases.
$image_dir = "../uploads/"; //physical path to uploads folder
$image_url = "//".$_SERVER['HTTP_HOST']."/businessCMS/uploads/"; //web path to uploads folder
$image_baseURL = "uploads/";

$target_dir = $image_dir;

//Upload function
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//Custom CSS file paths
$customCss_dir = '../css/custom.css'; //physical path to custom css file
$customCss_url = "//".$_SERVER['HTTP_HOST']."/businessCMS/css/custom.css"; //web path to custom css file

if ($customCss_url != "") {
    $customCss = "<link rel='stylesheet' type='text/css' href='".$customCss_url."' >";
}

//Navigation options for front-end template
$navSections = array("Top", "Footer");

//Extra Pages
$extraPages = "<optgroup label='Other Pages'><option value='about.php'>About</option><option value='contact.php'>Contact</option><option value='services.php'>Services</option><option value='team.php'>Team</option></optgroup>";

//Default values
$pageMsg="";

//Session timeout
$sessionTimeout=30; //30mins

//Establish db connection
$db_conn = mysql_connect($db_servername, $db_username, $db_password);
mysql_select_db($db_name, $db_conn);

//db connection is closed in includes/footer.php

//Error handling . Add debug=true to the querystring
if (isset($_GET["debug"])) {
	error_reporting(E_ALL | E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED);
	ini_set('display_errors', TRUE);
  error_reporting(1);
} else {
  error_reporting(E_ALL | E_WARNING | E_NOTICE | E_STRICT | E_DEPRECATED);
  ini_set('display_errors', FALSE);
  error_reporting(0);
}
?>
