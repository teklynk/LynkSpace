<?php
//updates the teams active on team.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'team.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
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
