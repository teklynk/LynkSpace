<?php
//updates the disqus options on page.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION["loggedIn"]) AND $_SESSION["session_hash"]==md5($_SESSION["user_name"])) {

	include '../../db/config.php';

	if (!empty($_GET) AND $_GET["update"]) {
		$pageDisqusID = $_GET["id"];
		$pageDisqusChecked = $_GET["checked"];

		if ($pageDisqusID) {
			$pageDisqusUpdate = "UPDATE pages SET disqus='".$pageDisqusChecked."' WHERE id=".$pageDisqusID." ";
		}

		mysqli_query($db_conn, $pageDisqusUpdate);
		mysqli_close($db_conn);

		die('Page Disqus Active set');
	}

} else {

	die('Direct access not permitted');

}
?>
