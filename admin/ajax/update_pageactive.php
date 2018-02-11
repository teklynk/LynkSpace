<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the page active on page.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'page.php') {

    require_once(__DIR__ . '/../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $pageActiveID = $_GET['id'];
        $pageActiveChecked = $_GET['checked'];

        if ($pageActiveID) {
            $pageActiveUpdate = "UPDATE pages SET active='" . $pageActiveChecked . "' WHERE id=" . $pageActiveID . ";";
        }

        mysqli_query($db_conn, $pageActiveUpdate);
        mysqli_close($db_conn);

        die('Page Active ' . $pageActiveID . ' set ' . $pageActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
