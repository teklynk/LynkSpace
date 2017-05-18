<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'updates.php';
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

if (!is_writable(dirname('upgrade'))) {

    echo "Unable to write to folder. Check file permissions.";

} else {

    if (isset($_SESSION['updates_available'])) {
        echo "<h2>An updated version of YouSeeMore is available: ".$getVersion."</h2>";
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
        echo "<p>You are currently on version ".$getVersion."</p>";
        unset($_SESSION['updates_available']);
    }

}

//Download the updated zip file from a remote server
if ($_GET['download'] == 'true' && $upgradeOption == 'download') {
    if (!file_exists('upgrade')) {
        mkdir('upgrade', 0755, true);
    } else {
        echo 'Could not create Upgrade directory.';
    }

    sleep(1); // wait

    if (!file_exists($updatesDestination)) {
        downloadFile($updatesRemoteFile, $updatesDestination);
    }
}

//MD5 Checksum Compare
if ($upgradeOption == 'install' && file_exists($updatesDestination)) {
    if (md5_file($updatesDestination) !== getUrlContents($updatesCheckerURL)) {
        echo 'MD5 check sums do not match. The downloaded file may be incomplete. Please download again.';
        //Delete the zip file
        unlink($updatesDestination);
    }
}

//Extract and install the zip file contents
if ($_GET['install'] == 'true' && $upgradeOption == 'install' && file_exists($updatesDestination)) {
    if (file_exists($updatesDestination)) {

        extractZip($updatesDestination, $_SERVER['DOCUMENT_ROOT'].'/');

        sleep(1); // wait

        //Delete the zip file
        unlink($updatesDestination);
        //remove session variable
        unset($_SESSION['updates_available']);
    }
}
?>
    <!--modal preview window-->

    <style>
        #webslideDialog iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        .modal-dialog {
            width: 50%;
        }
    </style>

    <div class="modal fade" id="webslideDialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </a>
                    <h4 class="modal-title">&nbsp;</h4>
                </div>
                <div class="modal-body">
                    <iframe id="myModalFile" src="" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">&nbsp;</div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php
include_once('includes/footer.inc.php');
?>