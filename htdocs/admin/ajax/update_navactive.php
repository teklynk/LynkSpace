<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
	die( 'Direct access not permitted' );
}

//updates the open in new window checkboxes on navigation.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'navigation.php' ) {

	require_once( __DIR__ . '/../../../config/config.php' );

	if ( ! empty( $_GET ) && $_GET['update'] ) {
		$navActiveID      = $_GET['id'];
		$navActiveChecked = $_GET['checked'];

		$navActiveUpdate = "UPDATE navigation SET active='" . $navActiveChecked . "' WHERE id=" . $navActiveID . ";";
		mysqli_query( $db_conn, $navActiveUpdate );

		mysqli_close( $db_conn );

		die( 'Navigation ' . $navActiveID . ' set ' . $navActiveChecked );
	}

} else {

	die( 'Direct access not permitted' );

}
?>
