<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
    die( 'Direct access not permitted' );
}

//updates the active checkboxes on socialmedia.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'socialmedia.php' ) {

    require_once( __DIR__ . '/../../../../config/config.php' );

    if ( ! empty( $_GET ) && $_GET['update'] ) {
        $socialActiveID      = $_GET['id'];
        $socialActiveChecked = $_GET['checked'];

        $navActiveUpdate = "UPDATE sociallinks SET active='" . $socialActiveChecked . "', DATETIME='" . date("Y-m-d H:i:s") . "' WHERE id=" . $socialActiveID . ";";
        mysqli_query( $db_conn, $navActiveUpdate );

        mysqli_close( $db_conn );

        die( 'Socialmedia ' . $socialActiveID . ' set ' . $socialActiveChecked );
    }

} else {

    die( 'Direct access not permitted' );

}
?>