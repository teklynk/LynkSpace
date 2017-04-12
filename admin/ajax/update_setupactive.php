<?php
//updates the active location table Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'setup.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $setupActiveID = $_GET['id'];
        $setupActiveChecked = $_GET['checked'];

        if ($setupActiveID) {
            $setupActiveUpdate = "UPDATE locations SET active='" . $setupActiveChecked . "' WHERE id=" . $setupActiveID . " ";
            mysqli_query($db_conn, $setupActiveUpdate);
        }

        mysqli_close($db_conn);

        die('Setup Active ' . $setupActiveID . ' set ' . $setupActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
