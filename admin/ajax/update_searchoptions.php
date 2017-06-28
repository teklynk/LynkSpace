<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the search options on setup.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'setup.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $searchOptID = $_GET['id'];
        $searchOptChecked = $_GET['checked'];

        if ($searchOptID == 'ls2pac') {
            $searchOptUpdate = "UPDATE setup SET ls2pac='" . $searchOptChecked . "' WHERE loc_id=" . $_SESSION['loc_id'] . " ";
        } elseif ($searchOptID == 'ls2kids') {
            $searchOptUpdate = "UPDATE setup SET ls2kids='" . $searchOptChecked . "' WHERE loc_id=" . $_SESSION['loc_id'] . " ";
        }

        mysqli_query($db_conn, $searchOptUpdate);
        mysqli_close($db_conn);

        die('Search Options ' . $searchOptID . ' set ' . $searchOptChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
