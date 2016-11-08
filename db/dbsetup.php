<?php
//This is the main Config/Setup file for the admin panel and Global variables used throughout the site. Change values as needed.

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

//Google Analytics
$googleAnalytics = '';

//Extra Pages
$extraPages = "<optgroup label='Other Pages'><option value='about.php'>About</option><option value='contact.php'>Contact</option><option value='services.php'>Services</option><option value='team.php'>Team</option></optgroup>";

//Default values
$pageMsg="";

//Session timeout
$sessionTimeout=60; //mins

//establish db connection
$db_conn = mysqli_connect($db_servername, $db_username, $db_password);
mysqli_select_db($db_conn, $db_name);

if (mysqli_connect_errno($db_conn)){
  echo "Failed to connect to MySQL:" . mysqli_connect_error();
}
//db connection is closed in includes/footer.php

//Error handling . Add debug=true to the querystring
if (isset($_GET["debug"])) {
  ini_set('display_errors', TRUE);
} else {
  ini_set('display_errors', FALSE);
}
?>
