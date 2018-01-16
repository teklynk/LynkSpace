<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the services active on page.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'services.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $servicesActiveID = $_GET['id'];
        $servicesActiveChecked = $_GET['checked'];

        if ($servicesActiveID) {
            $servicesActiveUpdate = "UPDATE services SET active='" . $servicesActiveChecked . "' WHERE id=" . $servicesActiveID . " ";
        }

        mysqli_query($db_conn, $servicesActiveUpdate);
        mysqli_close($db_conn);

        die('Services Active ' . $servicesActiveID . ' set ' . $servicesActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
