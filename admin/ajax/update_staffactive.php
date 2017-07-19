<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the teams active on staff.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'staff.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $teamActiveID = $_GET['id'];
        $teamActiveChecked = $_GET['checked'];

        if ($teamActiveID) {
            $teamActiveUpdate = "UPDATE team SET active='" . $teamActiveChecked . "' WHERE id=" . $teamActiveID . " ";
        }

        mysqli_query($db_conn, $teamActiveUpdate);
        mysqli_close($db_conn);

        die('Team Active ' . $teamActiveID . ' set ' . $teamActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
