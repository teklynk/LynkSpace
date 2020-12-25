<?php
//Check if requested via Ajax
if ( empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) != 'xmlhttprequest' ) {
    die( 'Direct access not permitted' );
}

//updates the social media default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['session_hash'] == md5( $_SESSION['user_name'] ) && $_SESSION['file_referrer'] == 'socialmedia.php' ) {

    require_once( __DIR__ . '/../../../../config/config.php' );

    if ( ! empty( $_GET ) && $_GET['update'] ) {
        $socialDefaultsID      = $_GET['id'];
        $socialDefaultsChecked = $_GET['checked'];

        $socialDefaultsUpdate = "UPDATE setup SET socialmedia_use_defaults='" . $socialDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', DATETIME='" . date( "Y-m-d H:i:s" ) . "' WHERE loc_id=" . $socialDefaultsID . ";";
        mysqli_query( $db_conn, $socialDefaultsUpdate );

        mysqli_close( $db_conn );

        die( 'Social Media Defaults ' . $socialDefaultsID . ' set ' . $socialDefaultsChecked );
    }

} else {

    die( 'Direct access not permitted' );

}
?>
