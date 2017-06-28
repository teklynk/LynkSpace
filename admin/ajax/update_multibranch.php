<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the multibranch option Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'siteoptions.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $multibranchActiveID = $_GET['id'];
        $multibranchActiveChecked = $_GET['checked'];

        if ($multibranchActiveID) {
            $multibranchActiveUpdate = "UPDATE config SET multibranch='" . $multibranchActiveChecked . "' ";
        }

        mysqli_query($db_conn, $multibranchActiveUpdate);
        mysqli_close($db_conn);

        die('Multibranch Active ' . $multibranchActiveID . ' set ' . $multibranchActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
