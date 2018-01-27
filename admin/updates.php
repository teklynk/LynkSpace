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

if ($errorMsg !="") {
    echo $errorMsg;
} else {
    echo $pageMsg;
}
if ($deleteMsg != "") {
    echo $deleteMsg;
}

$upgradeOption = '';

//Check for updates. Get global variables.
getUpdates();

if (isset($_SESSION['updates_available'])) {

    //Check that files are writeable
    if (!is_writeable('../version.txt')) {
        echo "<div class='alert alert-danger clearfix'><span><b>version.txt is not writable.</b> Check file permissions.<br/>Files and folders will need write access in order to complete the upgrade.</span></div>";
    }

    //Message
    echo "<div class='alert alert-warning clearfix'><strong><i class='fa fa-exclamation' aria-hidden='true'></i>  Important:</strong>&nbsp;Before updating, please back up your database and files.</div>";
    echo "<h2>An updated version is available: ".$getVersion."</h2>";
    echo "<a href='" . updatesChangeLogFile . "' target='_blank' class='btn btn-link' role='button' aria-pressed='true'>Change log</a>";
    echo "<p>You can update to version ".$getVersion." automatically:</p>";

    if (!file_exists($updatesDestination)) {
        $upgradeOption = 'download';
        echo "<div><button type='button' class='btn btn-primary update' id='update_download' onclick=\"window.location.href='updates.php?download=true&version=" . $getVersion . "'\"><i class='fa fa-fw fa-cloud-download'></i> Auto Update</button></div>";
        echo "<div><a href='" . updatesDownloadServer . "/" . $getVersion . ".zip' target='_blank' class='btn btn-link' role='button' aria-pressed='true'>Manually Download File</a></div>";
    } else {
        $upgradeOption = 'install';
        echo "<div><button type='button' class='btn btn-primary update' id='update_install' onclick=\"window.location.href='updates.php?install=true&version=" . $getVersion . "'\"><i class='fa fa-fw fa-cloud-upload'></i> Install Now</button></div>";
        echo "<div><a href='updates.php?delete=true' class='btn btn-link' role='button' aria-pressed='true'>Remove (admin/upgrade/" . $getVersion . ".zip)</a></div>";
        echo "<p>A backup will be automatically created in (admin/backups)</p>";
    }

    if ($_GET['delete'] == 'true') {

        //Delete the zip file
        unlink($updatesDestination);

        header("updates.php?loc_id=" . $_GET['loc_id'] . "");
        echo "<script>window.location.href='updates.php?loc_id=" . $_GET['loc_id'] . "';</script>";
    }

} else {
    echo "<h2>No updates available.</h2>";
    echo "<p>You are on the current version: " . $getVersion . "</p>";
    unset($_SESSION['updates_available']);
}

//Download the updated zip file from a remote server
if ($_GET['download'] == 'true' && $upgradeOption == 'download') {

    if (!file_exists('upgrade')) {
        mkdir('upgrade', 0755, true);
    } else {
        echo '<div class="alert alert-danger clearfix" ><b>Could not create Upgrade directory.</b> Check file permissions.</div>';
    }

    sleep(1); // wait

    if (!file_exists($updatesDestination)) {
        downloadFile($updatesRemoteFile, $updatesDestination);
    }
}

//Extract and install the zip file contents
if ($_GET['install'] == 'true' && $upgradeOption == 'install' && file_exists($updatesDestination)) {
    if (file_exists($updatesDestination)) {

        //TODO: Add database backups using something like: https://davidwalsh.name/backup-mysql-database-php

        //Backup files into admin/backups/currentDate.zip
        zipFile(__DIR__ . "/../", __DIR__ . "/backups/" . date('Y-m-d-H-i-s') . ".zip");

        //Extract/Un-zip the downloaded update from admin/upgrade
        extractZip($updatesDestination, $_SERVER['DOCUMENT_ROOT'].'/'.$subDirectory.'/', array('custom-style.css', 'Thumbs.db', '.DS_Store', 'dbconn.php', 'blowfishsalt.php', '.htaccess', 'robots.txt', 'sitemap.xml'));

        sleep(2); // wait

        //Run Phinx migrations
        phinxMigration('migrate', 'development');

        sleep(2); // wait

        //Delete the update zip file
        unlink($updatesDestination);
        //remove session variable
        unset($_SESSION['updates_available']);
    }
}

require_once('includes/footer.inc.php');
?>