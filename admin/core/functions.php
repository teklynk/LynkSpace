<?php 
//Admin Panel Functions
function fileUploader(){
	global $uploadMsg;
	global $target_file;
	global $target_dir;

	//Upload function
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$pageMsg="";

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		$uploadMsg = "<div class='alert alert-success'>The file ". basename( $_FILES["fileToUpload"]["name"]) ." has been uploaded.<button type='button' class='close' data-dismiss='alert'>×</button></div>";
	} else {
		$uploadMsg = "";
	}
}

function pageUpdater(){
	global $pageMsg;
	global $pageUpdate;
	global $thePageId;

	$pageUpdate = "UPDATE pages SET title='".$_POST["page_title"]."', content='".$_POST["page_content"]."', image='".$_POST["page_image"]."', image_align='".$_POST["page_image_align"]."', active=".$_POST["page_status"].", datetime='".date("Y-m-d H:i:s")."' WHERE id='$thePageId'";
	mysql_query($pageUpdate);
	$pageMsg="<div class='alert alert-success'>The page ".$_POST["page_title"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='page.php'\">×</button></div>";
}

function teamUpdater(){
	global $teamMsg;
	global $teamUpdate;
	global $theteamId;

	$teamUpdate = "UPDATE team SET title='".$_POST["team_title"]."', content='".$_POST["team_content"]."', name='".$_POST["team_name"]."', image='".$_POST["team_image"]."', active=".$_POST["team_status"].", datetime='".date("Y-m-d H:i:s")."' WHERE id='$theteamId'";
	mysql_query($teamUpdate);
	$teamMsg="<div class='alert alert-success'>The team member ".$_POST["team_name"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='team.php'\">×</button></div>";
}

function serviceFunc($dbOption){
	global $dbOption;
	global $servicesUpdate;
	global $theserviceId;
	global $serviceMsg;
	global $sqlServices;
	global $row;

	if ($dbOption="update"){
		$servicesUpdate = "UPDATE services SET title='".$_POST["service_title"]."', content='".$_POST["service_content"]."', link=".$_POST["service_link"].", icon='".$_POST["service_icon_select"]."', image='".$_POST["service_image_select"]."', active=".$_POST["service_status"].",datetime='".date("Y-m-d H:i:s")."' WHERE id='$theserviceId'";
		mysql_query($servicesUpdate);
		$serviceMsg="<div class='alert alert-success'>The service ".$_POST["service_title"]." has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='services.php'\">×</button></div>";
	}elseif ($dbOption="select"){
		$sqlServices = mysql_query("SELECT id, title, icon, image, content, link, active, datetime FROM services WHERE id=5");
		$row  = mysql_fetch_array($sqlServices);
		$serviceMsg="";
	}
}

function aboutFunc($dbOption){
	global $dbOption;
	global $aboutUpdate;
	global $pageMsg;
	global $sqlAbout;
	global $row;

	if ($dbOption="update"){
		$aboutUpdate = "UPDATE aboutus SET heading='".$_POST["about_heading"]."', content='".$_POST["about_content"]."', image='".$_POST["about_image"]."', image_align='".$_POST["about_image_align"]."' ";
		mysql_query($aboutUpdate);
		$pageMsg="<div class='alert alert-success'>The about section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='aboutus.php'\">×</button></div>";
	}
}

function setupFunc($dbOption){
	global $dbOption;
	global $setupUpdate;
	global $pageMsg;
	global $sqlSetup;
	global $row;

	if ($dbOption="update"){
		$setupUpdate = "UPDATE setup SET title='".$_POST["site_title"]."', author='".$_POST["site_author"]."', keywords='".$_POST["site_keywords"]."', description='".$_POST["site_description"]."', headercode='".mysql_real_escape_string($_POST["site_header"])."', disqus='".mysql_real_escape_string($_POST['site_disqus'])."', googleanalytics='".$_POST["site_google"]."', tinymce=".$_POST["site_tinymce"]." ";
		mysql_query($setupUpdate);
		$pageMsg="<div class='alert alert-success'>The setup section has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='setup.php'\">×</button></div>";
	}
}

?>