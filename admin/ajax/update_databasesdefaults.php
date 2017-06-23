<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the generalinfo default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'databases.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $databasesSubSection = $_GET['section'];
        $databasesDefaultsID = $_GET['id'];
        $databasesDefaultsChecked = $_GET['checked'];

        $sqlSections = mysqli_query($db_conn, "SELECT section, loc_id FROM sections_customers WHERE section='".$databasesSubSection."' AND loc_id=" . $databasesDefaultsID . " ");
        $rowSection = mysqli_fetch_array($sqlSections);

        if ($rowSection['loc_id'] == $databasesDefaultsID && $rowSection['section'] == $databasesSubSection) {
            //Do Update
            $databasesDefaultsUpdate = "UPDATE sections_customers SET use_defaults='" . $databasesDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE section='".$databasesSubSection."' AND loc_id=" . $databasesDefaultsID . " ";
            mysqli_query($db_conn, $databasesDefaultsUpdate);
        } else {
            //Do Insert
            $databasesDefaultsInsert = "INSERT INTO sections_customers (section, use_defaults, author_name, datetime, loc_id) VALUES ('".$databasesSubSection."', '".$databasesDefaultsChecked."', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $databasesDefaultsInsert);
        }

        mysqli_close($db_conn);

        die('Database Defaults ' . $databasesDefaultsID . ' - ' . $databasesSubSection .  ' set ' . $databasesDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
