<?php
//updates the slider default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'slider.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
        $sliderDefaultsID = $_GET['id'];
        $sliderDefaultsChecked = $_GET['checked'];

        $sliderDefaultsUpdate = "UPDATE setup SET slider_use_defaults='" . $sliderDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $sliderDefaultsID . " ";
        mysqli_query($db_conn, $sliderDefaultsUpdate);

        mysqli_close($db_conn);

        die('Slider Defaults set');
    }

} else {

    die('Direct access not permitted');

}
?>
