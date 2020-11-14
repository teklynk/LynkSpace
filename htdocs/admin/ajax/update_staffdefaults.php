<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
	die( 'Direct access not permitted' );
}

//updates the teams default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'staff.php' ) {

	require_once( __DIR__ . '/../../../config/config.php' );

	if ( ! empty( $_GET ) && $_GET['update'] ) {
		$teamDefaultsID      = $_GET['id'];
		$teamDefaultsChecked = $_GET['checked'];

		$teamDefaultsUpdate = "UPDATE setup SET team_use_defaults='" . $teamDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . $teamDefaultsID . ";";
		mysqli_query( $db_conn, $teamDefaultsUpdate );

		mysqli_close( $db_conn );

		die( 'Team Defaults ' . $teamDefaultsID . ' set ' . $teamDefaultsChecked );
	}

} else {

	die( 'Direct access not permitted' );

}
?>
