<?php
//updates the generalinfo default. Called from js/functions.js via jquery/ajax.
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'generalinfo.php') {

    include_once('../../db/config.php');

    if (!empty($_GET) AND $_GET['update']) {
        $generalinfoDefaultsID = $_GET['id'];
        $generalinfoDefaultsChecked = $_GET['checked'];

        $sqlGeneralInfo = mysqli_query($db_conn, "SELECT loc_id FROM generalinfo WHERE loc_id=" . $_SESSION['loc_id'] . " ");
        $rowGeneralInfo = mysqli_fetch_array($sqlGeneralInfo);

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

        die('Gernalinfo Defaults set');
    }

} else {

    die('Direct access not permitted');

}
?>
