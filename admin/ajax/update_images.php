<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

define('inc_access', TRUE);
session_start();
//Called from js/functions.js via jquery/ajax.
//Create location upload folder if it does not exist.
//Copy contents from defaults location to the other uploads folders.
//This will add files and not delete existing.

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referrer'] == 'uploads.php') {

    require_once('../../config/config.php');
    require_once('../core/functions.php');

    if (!empty($_GET) && $_GET['update'] && multiBranch == 'true') {

        //Copy images from default location
        $srcPath = str_replace('admin/ajax', 'uploads/1', __DIR__);

        $sqlLocations = mysqli_query($db_conn, "SELECT id, active FROM locations WHERE active='true' AND id != 1");
        while ($rowLocations = mysqli_fetch_array($sqlLocations)) {

            $destPath = str_replace('admin/ajax', 'uploads/' . $rowLocations['id'], __DIR__);

            if ($rowLocations['id'] != 1) {
                recurse_copy($srcPath, $destPath);

                print_r($destPath . PHP_EOL);
            }

        }

        die('Images Copied to ALL locations');
    }

} else {

    die('Direct access not permitted');

}
?>