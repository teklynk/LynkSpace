<?php
include 'dbconn.php';


//Global Vars
//Edit values for your web site. leave as is in most cases.
$image_dir = "../uploads/"; //physical path to uploads folder
$image_url = "//".$_SERVER['HTTP_HOST']."/uploads/"; //web path to uploads folder
//$image_url = "http://".$_SERVER['HTTP_HOST']."/uploads/"; //web path to uploads folder
$image_baseURL = "uploads/";

$target_dir = $image_dir;

//Custom CSS file paths
$customCss_dir = '../css/custom.css'; //physical path to custom css file
$customCss_url = "//".$_SERVER['HTTP_HOST']."/css/custom.css"; //web path to custom css file
//$customCss_url = "http://".$_SERVER['HTTP_HOST']."/css/custom.css"; //web path to custom css file

if ($customCss_url != "") {
    $customCss = "<link rel='stylesheet' type='text/css' href='".$customCss_url."' >";
}

//Navigation options for front-end template
$navSections = array("Top", "Footer");

//Extra Pages
$extraPages = "<optgroup label='Other Pages'><option value='about.php'>About</option><option value='contact.php'>Contact</option><option value='services.php'>Services</option><option value='team.php'>Team</option></optgroup>";

//Establish db connection 
$db_conn = mysql_connect($db_servername, $db_username, $db_password);
mysql_select_db($db_name, $db_conn);

//db connection is closed in includes/footer.php
?>