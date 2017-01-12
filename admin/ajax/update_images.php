<?php
define('inc_access', TRUE);
session_start();
//Called from js/functions.js via jquery/ajax.
//Create location upload folder if it does not exist.
//Copy contents from defaults location to the other uploads folders.
//This will add files and not delete existing.

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) AND $_SESSION['session_hash'] == md5($_SESSION['user_name']) AND $_SESSION['file_referer'] == 'uploads.php') {

    include_once('../../db/config.php');
    include_once('../core/functions.php');

    if (!empty($_GET) AND $_GET['update']) {
        $uploadsID = $_GET['id'];
        $srcPath = str_replace('admin/ajax', 'uploads/'.$uploadsID, __DIR__);

        $sqlLocations = mysqli_query($db_conn, "SELECT id, active FROM locations WHERE active='true' ");
        while ($rowLocations = mysqli_fetch_array($sqlLocations)) {
            $destPath = str_replace('admin/ajax', 'uploads/' . $rowLocations['id'], __DIR__);

            if ($rowLocations['id'] != 1) {
                recurse_copy($srcPath, $destPath);
            }
        }

        die('Images Copied to ALL locations');
    }

} else {

    die('Direct access not permitted');

}
?>