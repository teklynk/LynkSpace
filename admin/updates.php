<?php
define('inc_access', TRUE);

require_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'updates.php';

?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
                <li class="active">Updates</li>
            </ol>
            <h1 class="page-header">
                Updates
            </h1>
        </div>
    </div>

<?php

$upgradeOption = '';

//Check for updates. Get global variables.
getUpdates();

if (isset($_SESSION['updates_available'])) {

    //Create the backup folder
    if (!file_exists(__DIR__ . '/backups/')) {
        @mkdir(__DIR__ . '/backups/', 0755);
    }

    //Check that backups folder is writable.
    if (!is_writeable(__DIR__ . '/backups/')){
        $pageMsg = "<div class='alert alert-danger'>" . __DIR__ . "/backups is not writable. Check folder permissions.</div>";
    }

    //Check that files are writeable
    if (!is_writeable('../version.txt')) {
        echo "<div class='alert alert-danger clearfix'><span><b>version.txt is not writable.</b> Check file permissions.<br/>Files and folders will need write access in order to complete the upgrade.</span></div>";
    }

    //Message
    echo "<div class='alert alert-warning clearfix'><strong><i class='fa fa-exclamation' aria-hidden='true'></i>  Important:</strong>&nbsp;Before updating, please back up your database and files.  <a href='updates.php?backup=true'>Run a backup now.</a></div>";
    echo "<h2>An updated version is available: ".$getVersion."</h2>";
    echo "<p>You can update to version ".$getVersion." automatically:</p>";

    if (!file_exists($updatesDestination)) {
        $upgradeOption = 'download';
        echo "<div><button type='button' class='btn btn-primary update' id='update_download' onclick=\"window.location.href='updates.php?download=true&version=" . $getVersion . "'\"><i class='fa fa-fw fa-cloud-download'></i> Auto Update</button></div>";
    } else {
        $upgradeOption = 'install';
        echo "<div><button type='button' class='btn btn-primary update' id='update_install' onclick=\"window.location.href='updates.php?install=true&version=" . $getVersion . "'\"><i class='fa fa-fw fa-cloud-upload'></i> Install Update Now</button></div>";
        echo "<div><a href='updates.php?delete=true' class='btn btn-link' role='button' aria-pressed='true'><i class='fa fa-trash-o' aria-hidden='true'></i> Remove " . $getVersion . ".zip</a></div>";
    }

    echo "<hr/>";
    echo "<div><a href='" . updatesDownloadServer . "/" . $getVersion . ".zip' target='_blank' class='btn btn-link' role='button' aria-pressed='true'><i class='fa fa-fw fa-download'></i> Manually download and install files</a></div>";
    echo "<div><a href='" . updatesChangeLogFile . "' target='_blank' class='btn btn-link' role='button' aria-pressed='true'><i class='fa fa-code-fork' aria-hidden='true'></i> Change log</a></div>";
    echo "<div><a href='updates.php?backup=true' class='btn btn-link' role='button' aria-pressed='true'><i class='fa fa-file-archive-o' aria-hidden='true'></i> Backup now </a></div>";
    echo "<div><small><b>Backups (admin/backups)</b></small></div>";
    echo "<div><small>";
        getDirContents(__DIR__ . "/backups/");
    echo "</small></div>";


    //Download the updated zip file from a remote server
    if ($_GET['download'] == 'true' && $upgradeOption == 'download') {

        if (!file_exists('upgrade')) {
            mkdir('upgrade', 0755, true);
        } else {
            echo '<div class="alert alert-danger clearfix" ><b>Could not create Upgrade directory.</b> Check file permissions.</div>';
        }

        if (!file_exists($updatesDestination)) {
            downloadFile($updatesRemoteFile, $updatesDestination);
        }
    }

    //Extract and install the zip file contents
    if ($_GET['install'] == 'true' && $upgradeOption == 'install' && file_exists($updatesDestination)) {
        if (file_exists($updatesDestination)) {

            //Extract/Un-zip the downloaded update from admin/upgrade
            extractZip(__DIR__ . "/" . $updatesDestination, __DIR__ . "/../", array("updates.php", "custom-style.css", "Thumbs.db", ".DS_Store", "dbconn.php", "blowfishsalt.php", ".htaccess", "robots.txt", "sitemap.xml"));

            sleep(1); // wait

            // Copy htaccess-sample to .htaccess
            if (!file_exists("install.php")) {
                @unlink("~install.old");
                copy("install.php", "~install.old");
            }

            sleep(1); // wait

            //Run Phinx migrations
            phinxMigration('migrate', 'development');

            sleep(1); // wait

            //Delete the update zip file
            unlink($updatesDestination);
            //remove session variable
            unset($_SESSION['updates_available']);
        } else {
            echo $updatesDestination . "  - does not exist.";
        }
    }

    if ($_GET['delete'] == 'true') {

        //Delete the zip file
        unlink($updatesDestination);

        header("updates.php?loc_id=" . $_GET['loc_id'] . "");
        echo "<script>window.location.href='updates.php?loc_id=" . $_GET['loc_id'] . "';</script>";
    }

    //Create a backup zip file
    if ($_GET['backup'] == 'true') {

        //Removes old backups before creating a new backup
        recurse_delete(__DIR__ . "/backups/*.zip");

        sleep(1); // wait

        //Backup files into admin/backups/currentDate.zip
        zipFile(__DIR__ . "/../", __DIR__ . "/backups/" . cmsTitle . "-" . date('Y-m-d-H-i-s') . ".zip");

        sleep(1); // wait

        header("updates.php?loc_id=" . $_GET['loc_id'] . "");
        echo "<script>window.location.href='updates.php?loc_id=" . $_GET['loc_id'] . "';</script>";
    }

} else {
    echo "<h2>No updates available.</h2>";
    echo "<p>You are on the current version: " . $getVersion . "</p>";
    unset($_SESSION['updates_available']);
}

require_once('includes/footer.inc.php');
?>