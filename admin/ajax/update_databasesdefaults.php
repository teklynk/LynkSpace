<?php
//updates the generalinfo default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'databases.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $databasesSubSection = $_GET['sub_section'];
        $databasesDefaultsID = $_GET['id'];
        $databasesDefaultsChecked = $_GET['checked'];

        $databasesDefaultsUpdate = "UPDATE setup SET databases_use_defaults_$databasesSubSection='" . $databasesDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $databasesDefaultsID . " ";
        mysqli_query($db_conn, $databasesDefaultsUpdate);

        mysqli_close($db_conn);

        die('Database Defaults ' . $databasesDefaultsID . ' - ' . $databasesSubSection .  ' set ' . $databasesDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
