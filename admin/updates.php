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
        echo "<div class='alert alert-danger'><span>version.txt is not writable. Check file permissions.<br/>Files and folders will need write access in order to complete the upgrade.</span></div>";
    }

    //Message
    echo "<div class='alert alert-info'><strong>Important:</strong>&nbsp;Before updating, please back up your database and files.</div>";
    echo "<h2>An updated version is available: ".$getVersion."</h2>";
    echo "<button type='button' class='btn btn-link' onclick=\"showMyModal('" . safeCleanStr($getVersion) . "', '" . safeCleanStr($changeLogFile) . "')\">Change log</button>";
    echo "<p>You can update to version ".$getVersion." automatically:</p>";

    if (!file_exists($updatesDestination)) {
        $upgradeOption = 'download';
        echo "<button type='button' class='btn btn-primary update' id='update_download' onclick=\"window.location.href='updates.php?download=true&version=" . $getVersion . "'\"><i class='fa fa-fw fa-cloud-download'></i> Download Now</button>";
    } else {
        $upgradeOption = 'install';
        echo "<button type='button' class='btn btn-primary update' id='update_install' onclick=\"window.location.href='updates.php?install=true&version=" . $getVersion . "'\"><i class='fa fa-fw fa-cloud-upload'></i> Install Now</button>";
    }

} else {
    echo "<h2>No updates available.</h2>";
    echo "<p>You are on the current version: ".$getVersion."</p>";
    unset($_SESSION['updates_available']);
}

//Download the updated zip file from a remote server
if ($_GET['download'] == 'true' && $upgradeOption == 'download') {
    if (!file_exists('upgrade')) {
        mkdir('upgrade', 0755, true);
    } else {
        echo '<div class="alert alert-danger" >Could not create Upgrade directory.</div>';
    }

    sleep(1); // wait

    if (!file_exists($updatesDestination)) {
        downloadFile($updatesRemoteFile, $updatesDestination);
    }
}

//MD5 Checksum - Compare Downloaded File with Remote File Checksum
if ($upgradeOption == 'install' && file_exists($updatesDestination)) {
    if (md5_file($updatesDestination) !== getUrlContents($updatesCheckerURL)) {
        echo '<div class="updates_error" >MD5 checksums do not match. The downloaded file may be incomplete. Please download again.</div>';
        //Delete the zip file
        unlink($updatesRemoteFile);
    }
}

//Extract and install the zip file contents
if ($_GET['install'] == 'true' && $upgradeOption == 'install' && file_exists($updatesDestination)) {
    if (file_exists($updatesDestination)) {

        extractZip($updatesDestination, $_SERVER['DOCUMENT_ROOT'].'/'.$subDirectory.'/');

        sleep(1); // wait

        //Run Phinx migrations
        phinxMigration('migrate', 'development');

        sleep(1); // wait

        //Delete the zip file
        unlink($updatesDestination);
        //remove session variable
        unset($_SESSION['updates_available']);
    }
}

//Modal preview box
showModalPreview("webpageDialog");

require_once('includes/footer.inc.php');
?>