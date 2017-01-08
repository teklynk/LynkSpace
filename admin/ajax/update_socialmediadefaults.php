<?php
//updates the socialmedia default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'socialmedia.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
        $socialmediaDefaultsID = $_GET['id'];
        $socialmediaDefaultsChecked = $_GET['checked'];

        $sqlSocialmedia = mysqli_query($db_conn, "SELECT loc_id FROM socialmedia WHERE loc_id=" . $_SESSION['loc_id'] . " ");
        $rowSocialmedia = mysqli_fetch_array($sqlSocialmedia);

        if ($rowSocialmedia['loc_id'] == $_SESSION['loc_id']) {
            //Do Update
            $socialmediaDefaultsUpdate = "UPDATE socialmedia SET use_defaults='" . $socialmediaDefaultsChecked . "' WHERE loc_id=" . $socialmediaDefaultsID . " ";
            mysqli_query($db_conn, $socialmediaDefaultsUpdate);
        } else {
            //Do Insert
            $socialmediaDefaultsInsert = "INSERT INTO socialmedia (heading, facebook, twitter, pinterest, google, instagram, youtube, tumblr, use_defaults, loc_id) VALUES ('', '', '', '', '', '', '', '','true', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $socialmediaDefaultsInsert);
        }

        mysqli_close($db_conn);

        die('Socialmedia Defaults ' . $socialmediaDefaultsID . ' set ' . $socialmediaDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
