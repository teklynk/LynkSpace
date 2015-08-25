<?php
include 'dbconn.php';

//Global Vars
//Edit values for your web site. leave as is in most cases.
$image_dir = "../uploads/"; //physical path to uploads folder
$image_url = "//".$_SERVER['HTTP_HOST']."/uploads/"; //web path to uploads folder
$image_baseURL = "uploads/";
//$image_url = "http://".$_SERVER['HTTP_HOST']."/uploads/"; //web path to uploads folder
$target_dir = $image_dir;
$icon_dir = "../icons/";

//Custom CSS file paths
$customCss_dir = '../css/custom.css'; //physical path to custom css file
$customCss_url = "//".$_SERVER['HTTP_HOST']."/css/custom.css"; //web path to custom css file
//$customCss_url = "http://".$_SERVER['HTTP_HOST']."/css/custom.css"; //web path to custom css file

if ($customCss_url != "") {
    $customCss = "<link rel='stylesheet' type='text/css' href='".$customCss_url."' >";
}

//Navigation options for front-end template
$navSections = array("Top", "Footer");

//Establish db connection 
$db_conn = mysql_connect($db_servername, $db_username, $db_password);
mysql_select_db($db_name, $db_conn);

//db connection is closed in includes/footer.php
?>