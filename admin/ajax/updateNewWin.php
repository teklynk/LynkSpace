<?php 
//updates the new window checkboxes on navigation.php. Called from functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION["loggedIn"]) AND $_SESSION["file_referer"]=="navigation.php") {

	include '../../db/dbsetup.php'; 

	if (!empty($_GET) AND $_GET["update"]) {
		$navWinID = $_GET["id"];
		$navWinChecked = $_GET["checked"];

		$navUpdate = "UPDATE navigation SET win='".$navWinChecked."' WHERE id=".$navWinID." ";
		mysql_query($navUpdate);

		mysql_close($db_conn);
		die();
	}

} else {

	die('Direct access not permitted');

}
?>