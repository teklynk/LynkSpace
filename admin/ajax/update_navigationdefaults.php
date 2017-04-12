<?php
//updates the navigation default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'navigation.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $navSubSection = $_GET['sub_section'];
        $navigationDefaultsID = $_GET['id'];
        $navigationDefaultsChecked = $_GET['checked'];

        $navigationDefaultsUpdate = "UPDATE setup SET navigation_use_defaults_$navSubSection='" . $navigationDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $navigationDefaultsID . " ";
        mysqli_query($db_conn, $navigationDefaultsUpdate);

        mysqli_close($db_conn);

        die('Navigation Defaults '. $navigationDefaultsID .' - '. $navSubSection .' set ' . $navigationDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
