<?php
//updates the search defaults on setup.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'setup.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
        $searchDefaultID = $_GET['value'];
        $searchDefault = $_GET['checked'];

        if ($searchDefaultID > 0 AND $searchDefault <> '') {
            $searchDefaultUpdate = "UPDATE setup SET searchdefault=" . $searchDefaultID . " WHERE loc_id=" . $_SESSION['loc_id'] . " ";
        }

        mysqli_query($db_conn, $searchDefaultUpdate);
        mysqli_close($db_conn);

        die('Search Defaults ' . $searchDefaultID . ' set ' . $searchDefault);
    }

} else {

    die('Direct access not permitted');

}
?>
