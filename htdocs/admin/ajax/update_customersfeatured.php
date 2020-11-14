<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
	die( 'Direct access not permitted' );
}

//updates the databases featured on databases.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'databases.php' ) {

	require_once( __DIR__ . '/../../../config/config.php' );

	if ( ! empty( $_GET ) && $_GET['update'] ) {
		$customersFeaturedID      = $_GET['id'];
		$customersFeaturedChecked = $_GET['checked'];

		if ( $customersFeaturedID ) {
			if ( $customersFeaturedChecked == 'true' ) {
				$customersFeaturedUpdate = "UPDATE customers SET featured='" . $customersFeaturedChecked . "', catid=0 WHERE id=" . $customersFeaturedID . ";";
			} else {
				$customersFeaturedUpdate = "UPDATE customers SET featured='" . $customersFeaturedChecked . "' WHERE id=" . $customersFeaturedID . ";";
			}
		}

		mysqli_query( $db_conn, $customersFeaturedUpdate );
		mysqli_close( $db_conn );

		die( 'Customers Featured ' . $customersFeaturedID . ' set ' . $customersFeaturedChecked );
	}

} else {

	die( 'Direct access not permitted' );

}
?>
