<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the services default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'services.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $servicesDefaultsID = $_GET['id'];
        $servicesDefaultsChecked = $_GET['checked'];

        $servicesDefaultsUpdate = "UPDATE setup SET services_use_defaults='" . $servicesDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $servicesDefaultsID . " ";
        mysqli_query($db_conn, $servicesDefaultsUpdate);

        mysqli_close($db_conn);

        die('Services Defaults ' . $servicesDefaultsID . ' set ' . $servicesDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
