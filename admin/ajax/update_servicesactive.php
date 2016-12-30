<?php
//updates the services active on page.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name'])) {

    include '../../db/config.php';

    if (!empty($_GET) AND $_GET['update']) {
        $servicesActiveID = $_GET['id'];
        $servicesActiveChecked = $_GET['checked'];

        if ($servicesActiveID) {
            $servicesActiveUpdate = "UPDATE services SET active='" . $servicesActiveChecked . "' WHERE id=" . $servicesActiveID . " ";
        }

        mysqli_query($db_conn, $servicesActiveUpdate);
        mysqli_close($db_conn);

        die('Services Active set');
    }

} else {

    die('Direct access not permitted');

}
?>
