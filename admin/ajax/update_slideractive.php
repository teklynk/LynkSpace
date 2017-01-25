<?php
//updates the slider active on slider.php. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'slider.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $sliderActiveID = $_GET['id'];
        $sliderActiveChecked = $_GET['checked'];

        if ($sliderActiveID) {
            $sliderActiveUpdate = "UPDATE slider SET active='" . $sliderActiveChecked . "' WHERE id=" . $sliderActiveID . " ";
        }

        mysqli_query($db_conn, $sliderActiveUpdate);
        mysqli_close($db_conn);

        die('Slider Active ' . $sliderActiveID . ' set ' . $sliderActiveChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
