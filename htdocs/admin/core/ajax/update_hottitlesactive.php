<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
	die( 'Direct access not permitted' );
}

//updates the slider active on hottitles.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'hottitles.php' ) {

	require_once( __DIR__ . '/../../../../config/config.php' );

	if ( ! empty( $_GET ) && $_GET['update'] ) {
		$hottitlesActiveID      = $_GET['id'];
		$hottitlesActiveChecked = $_GET['checked'];

		if ( $hottitlesActiveID ) {
			$hottitlesActiveUpdate = "UPDATE hottitles SET active='" . $hottitlesActiveChecked . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE id=" . $hottitlesActiveID . ";";
		}

		mysqli_query( $db_conn, $hottitlesActiveUpdate );
		mysqli_close( $db_conn );

		die( 'Hot Titles Active ' . $hottitlesActiveID . ' set ' . $hottitlesActiveChecked );
	}

} else {

	die( 'Direct access not permitted' );

}
?>
