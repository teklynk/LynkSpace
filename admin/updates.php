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

getUpdates();
?>

<ul>
    <li>
        After login, Check a remote file/script to get the latest YSM7 version.<br/>
        file_get_contents('http://your-server.com/CMS-UPDATE-PACKAGES/current-release-versions.php') or die ('ERROR');<br/>
    </li>
    <li>
        Compare remote version number to local version number. If remote version greater than local then create a session object and Update Available button.
    </li>
    <li>
        Show link/button to download a remote zip file containing the new files and any migration scripts.<br/>
        Show a link to changelog file.
    </li>
    <li>
        Check that file has been downloaded and inside the temp "upgrade" folder and file size and/or MD5 hash matches remote zip.
    </li>
    <li>
        Show link to install updates.
    </li>
    <li>
        $openZip = zip_open('upgrades/newversion-7-0-2.zip');<br/>
        $readZip = zip_read($openZip);<br/>
        $fileName = zip_entry_name($readZip);<br/>
        Loop through zip, create folders if not in project.<br/>
        zip_entry_read to read contents of each file.<br/>
        fwrite to write the file contents.
    </li>
    <li>
        Execute migration scripts.<br/>
        Delete migration scripts.<br/>
        clear session object.<br/>
    </li>
    <li>
        Show a success message.
    </li>
</ul>

<?php
include_once('includes/footer.inc.php');
?>
