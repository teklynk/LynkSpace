<?php
//updates the hot titles default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'hottitles.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $hottitlesDefaultsID = $_GET['id'];
        $hottitlesDefaultsChecked = $_GET['checked'];

        $hottitlesDefaultsUpdate = "UPDATE setup SET hottitles_use_defaults='" . $hottitlesDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $hottitlesDefaultsID . " ";
        mysqli_query($db_conn, $hottitlesDefaultsUpdate);

        mysqli_close($db_conn);

        die('Hot Titles Defaults ' . $hottitlesDefaultsID . ' set ' . $hottitlesDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
