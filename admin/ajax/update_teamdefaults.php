<?php
//updates the teams default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'team.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
        $teamDefaultsID = $_GET['id'];
        $teamDefaultsChecked = $_GET['checked'];

        $teamDefaultsUpdate = "UPDATE setup SET team_use_defaults='" . $teamDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $teamDefaultsID . " ";
        mysqli_query($db_conn, $teamDefaultsUpdate);

        mysqli_close($db_conn);

        die('Team Defaults ' . $teamDefaultsID . ' set ' . $teamDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
