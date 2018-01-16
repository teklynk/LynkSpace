<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the generalinfo default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'contactus.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $contactDefaultsID = $_GET['id'];
        $contactDefaultsChecked = $_GET['checked'];

        $sqlContact = mysqli_query($db_conn, "SELECT loc_id FROM contactus WHERE loc_id=" . $_SESSION['loc_id'] . " ");
        $rowContact = mysqli_fetch_array($sqlContact, MYSQLI_ASSOC);

        if ($rowContact['loc_id'] == $_SESSION['loc_id']) {
            //Do Update
            $contactDefaultsUpdate = "UPDATE contactus SET use_defaults='" . $contactDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $contactDefaultsID . " ";
            mysqli_query($db_conn, $contactDefaultsUpdate);
        } else {
            //Do Insert
            $contactDefaultsInsert = "INSERT INTO contactus (heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours, use_defaults, author_name, datetime, loc_id) VALUES ('', '', '', '', '', '', '', '', '', '', '', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $contactDefaultsInsert);
        }

        mysqli_close($db_conn);

        die('Contact Defaults ' . $contactDefaultsID . ' set ' . $contactDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
