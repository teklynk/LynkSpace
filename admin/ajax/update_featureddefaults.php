<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the featured defaults. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'featured.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $featuredDefaultsID = $_GET['id'];
        $featuredDefaultsChecked = $_GET['checked'];

        $sqlFeatured = mysqli_query($db_conn, "SELECT loc_id FROM featured WHERE loc_id=" . $_SESSION['loc_id'] . " ");
        $rowFeatured = mysqli_fetch_array($sqlFeatured);

        if ($rowFeatured['loc_id'] == $_SESSION['loc_id']) {
            //Do Update
            $featuredDefaultsUpdate = "UPDATE featured SET use_defaults='" . $featuredDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $featuredDefaultsID . " ";
            mysqli_query($db_conn, $featuredDefaultsUpdate);
        } else {
            //Do Insert
            $featuredDefaultsInsert = "INSERT INTO featured (heading, introtext, content, image, image_align, use_defaults, author_name, datetime, loc_id) VALUES ('', '', '', '', '',  'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $featuredDefaultsInsert);
        }

        mysqli_close($db_conn);

        die('Featured Defaults ' . $featuredDefaultsID . ' set ' . $featuredDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
