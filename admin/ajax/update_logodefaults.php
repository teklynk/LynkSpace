<?php
//Check if requested via Ajax
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    die('Direct access not permitted');
}

//updates the featured defaults. Called from js/functions.js via jquery/ajax.
define('inc_access', TRUE);
session_start();

//check if user is logged in and that the requesting page is valid.
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] == 1 && $_SESSION['session_hash'] == md5($_SESSION['user_name']) && $_SESSION['file_referer'] == 'setup.php') {

    include_once('../../config/config.php');
    require_once('../core/functions.php');

    if (!empty($_GET) && $_GET['update'] && multiBranch == 'true') {
        $logoDefault= $_GET['defaultlogo'];

        //Do Update
        $logoDefaultsUpdate = "UPDATE setup SET logo='" . $logoDefault . "', author_name='" . $_SESSION['user_name'] . "', datetime='" . date("Y-m-d H:i:s") . "' ";
        mysqli_query($db_conn, $logoDefaultsUpdate);

        //Copy logo from default location
        $srcPath = str_replace('admin/ajax', 'uploads/1/'.$logoDefault, __DIR__);

        $sqlLocations = mysqli_query($db_conn, "SELECT id, active FROM locations WHERE active='true' AND id != 1");
        while ($rowLocations = mysqli_fetch_array($sqlLocations)) {
            $locId = $rowLocations['id'];

            $destPath = str_replace('admin/ajax', 'uploads/'.$locId.'/'.$logoDefault, __DIR__);

            if ($locId != 1 && file_exists($srcPath)) {

                @mkdir(dirname($destPath), 0755, true);

                @copy($srcPath, $destPath);

                print_r('from: ' . $srcPath . ' to: ' . $destPath . PHP_EOL);
            }

        }

        mysqli_close($db_conn);

        die('Logo Defaults set ' . $logoDefault . ' for all locations');
    }

} else {

    die('Direct access not permitted');

}
?>
