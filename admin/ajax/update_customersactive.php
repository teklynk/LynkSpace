<?php
//updates the databases active on databases.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'databases.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $customersActiveID = $_GET['id'];
        $customersActiveChecked = $_GET['checked'];

        if ($customersActiveID) {
            $customersActiveUpdate = "UPDATE customers SET active='" . $customersActiveChecked . "' WHERE id=" . $customersActiveID . " ";
        }

        mysqli_query($db_conn, $customersActiveUpdate);
        mysqli_close($db_conn);

        die('Customers Active ' . $customersActiveID . ' set ' . $customersActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
