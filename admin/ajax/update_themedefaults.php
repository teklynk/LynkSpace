<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the featured defaults. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'editor.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $themeDefaultsID = $_GET['id'];
        $themeDefaultsChecked = $_GET['checked'];

        //Do Update
        $themeDefaultsUpdate = "UPDATE setup SET theme_use_defaults='" . $themeDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=".$themeDefaultsID." ";
        mysqli_query($db_conn, $themeDefaultsUpdate);

        mysqli_close($db_conn);

        die('Theme Default set ' . $themeDefaultsChecked . ' for location: ' . $_SESSION['loc_id']);
    }

} else {

    die('Direct access not permitted');

}
?>