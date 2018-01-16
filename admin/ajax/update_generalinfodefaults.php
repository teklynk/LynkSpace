<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the generalinfo default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'generalinfo.php') {

    include_once('../../config/config.php');

    if (!empty($_GET) && $_GET['update']) {
        $generalinfoDefaultsID = $_GET['id'];
        $generalinfoDefaultsChecked = $_GET['checked'];

        $sqlGeneralInfo = mysqli_query($db_conn, "SELECT loc_id FROM generalinfo WHERE loc_id=" . $_SESSION['loc_id'] . " ");
        $rowGeneralInfo = mysqli_fetch_array($sqlGeneralInfo, MYSQLI_ASSOC);

        if ($rowGeneralInfo['loc_id'] == $_SESSION['loc_id']) {
            //Do Update
            $generalinfoDefaultsUpdate = "UPDATE generalinfo SET use_defaults='" . $generalinfoDefaultsChecked . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE loc_id=" . $generalinfoDefaultsID . " ";
            mysqli_query($db_conn, $generalinfoDefaultsUpdate);
        } else {
            //Do Insert
            $generalinfoDefaultsInsert = "INSERT INTO generalinfo (heading, content, use_defaults, author_name, datetime, loc_id) VALUES ('', '', 'true', '" . $_SESSION['user_name'] . "', '" . date("Y-m-d H:i:s") . "', " . $_SESSION['loc_id'] . ")";
            mysqli_query($db_conn, $generalinfoDefaultsInsert);
        }

        mysqli_close($db_conn);

        die('Gernalinfo Defaults ' . $generalinfoDefaultsID . ' set ' . $generalinfoDefaultsChecked);
    }

} else {

    die('Direct access not permitted');

}
?>
