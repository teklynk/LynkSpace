<?php
//updates the open in new window checkboxes on navigation.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION["loggedIn"]) AND $_SESSION["session_hash"]==md5($_SESSION["user_name"])) {

	include '../../db/config.php';

	if (!empty($_GET) AND $_GET["update"]) {
		$navWinID = $_GET["id"];
		$navWinChecked = $_GET["checked"];

		$navUpdate = "UPDATE navigation SET win='".$navWinChecked."' WHERE id=".$navWinID." ";
		mysqli_query($db_conn, $navUpdate);

		mysqli_close($db_conn);

		die('Navigation target set');
	}

} else {

	die('Direct access not permitted');

}
?>
