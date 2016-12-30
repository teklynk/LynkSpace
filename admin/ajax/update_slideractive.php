<?php
//updates the slider active on slider.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name'])) {

    include '../../db/config.php';

    if (!empty($_GET) AND $_GET['update']) {
        $sliderActiveID = $_GET['id'];
        $sliderActiveChecked = $_GET['checked'];

        if ($sliderActiveID) {
            $sliderActiveUpdate = "UPDATE slider SET active='" . $sliderActiveChecked . "' WHERE id=" . $sliderActiveID . " ";
        }

        mysqli_query($db_conn, $sliderActiveUpdate);
        mysqli_close($db_conn);

        die('Slider Active set');
    }

} else {

    die('Direct access not permitted');

}
?>
