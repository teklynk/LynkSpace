<?php
//updates the customers featured on customers.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name'])) {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
        $customersFeaturedID = $_GET['id'];
        $customersFeaturedChecked = $_GET['checked'];

        if ($customersFeaturedID) {
            $customersFeaturedUpdate = "UPDATE customers SET featured='" . $customersFeaturedChecked . "' WHERE id=" . $customersFeaturedID . " ";
        }

        mysqli_query($db_conn, $customersFeaturedUpdate);
        mysqli_close($db_conn);

        die('Customers Featured set');
    }

} else {

    die('Direct access not permitted');

}
?>
