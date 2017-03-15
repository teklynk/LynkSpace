<?php
//updates the aboutus defaults. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'aboutus.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $aboutusDefaultsID = $_GET['id'];
        $aboutusDefaultsChecked = $_GET['checked'];

        $sqlAboutus = mysqli_query($db_conn, "SELECT loc_id FROM aboutus WHERE loc_id=" . $_SESSION['loc_id'] . " ");
        $rowAboutus = mysqli_fetch_array($sqlAboutus);

        if ($rowAboutus['loc_id'] == $aboutusDefaultsID) {
            //Do Update
            $aboutusDefaultsUpdate = "UPDATE aboutus SET use_defaults='" . $aboutusDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $aboutusDefaultsID . " ";
            mysqli_query($db_conn, $aboutusDefaultsUpdate);
        } else {
            //Do Insert
            $aboutusDefaultsInsert = "INSERT INTO aboutus (heading, content, image, image_align, use_defaults, author_name, datetime, loc_id) VALUES ('', '', '', '', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $aboutusDefaultsInsert);
        }

        die('Aboutus Defaults ' . $aboutusDefaultsID . ' set ' . $aboutusDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
