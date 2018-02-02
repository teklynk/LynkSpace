<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the event defaults. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'events.php') {

    require_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $eventDefaultsID = $_GET['id'];
        $eventDefaultsChecked = $_GET['checked'];

        $sqlEvent = mysqli_query($db_conn, "SELECT loc_id FROM events WHERE loc_id=" . $_SESSION['loc_id'] . ";");
        $rowEvent = mysqli_fetch_array($sqlEvent, MYSQLI_ASSOC);

        if ($rowEvent['loc_id'] == $_SESSION['loc_id']) {
            //Do Update
            $eventDefaultsUpdate = "UPDATE events SET use_defaults='" . $eventDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $eventDefaultsID . ";";
            mysqli_query($db_conn, $eventDefaultsUpdate);
        } else {
            //Do Insert
            $eventDefaultsInsert = "INSERT INTO events (heading, alert, startdate, enddate, calendar, use_defaults, author_name, datetime, loc_id) VALUES ('', '', '', '', '', '".$eventDefaultsChecked."', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $eventDefaultsInsert);
        }

        mysqli_close($db_conn);

        //print_r($eventDefaultsUpdate);
        print_r($eventDefaultsInsert);

        die('Event Defaults ' . $eventDefaultsID . ' set ' . $eventDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
