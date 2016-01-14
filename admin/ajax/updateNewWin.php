<?php 
//updates the new window checkboxes on navigation.php. Called from functions.js via jquery/ajax.
session_start();

if (isset($_SESSION["user_id"]) AND isset($_SESSION["user_name"]) AND isset($_SESSION['timeout'])) {

	include '../../db/dbsetup.php'; 

	if (!empty($_GET) AND $_GET["update"]) {
		$navWinID = $_GET["id"];
		$navWinChecked = $_GET["checked"];

		$navUpdate = "UPDATE navigation SET win='".$navWinChecked."' WHERE id=".$navWinID." ";
		mysql_query($navUpdate);

		mysql_close($db_conn);
		die();
	}

}else{

	echo "<p>You are not logged in</p>";

}
?>