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
?>
<ul>
    <li>
        Check a remote file/script to get the latest YSM7 version.<br/>
        file_get_contents('http://your-server.com/CMS-UPDATE-PACKAGES/current-release-versions.php') or die ('ERROR');<br/>
    </li>
    <li></li>
</ul>

<?php
include_once('includes/footer.inc.php');
?>
