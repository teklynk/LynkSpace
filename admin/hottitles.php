<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'hottitles.php';

$pageMsg = "";
$deleteMsg = "";

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Hot Titles
        </h1>
    </div>
</div>
<?php
if ($pageMsg != "") {
    echo $pageMsg;
}
if ($deleteMsg != "") {
    echo $deleteMsg;
}
?>
<!-- Add user form-->
<button type="button" class="btn btn-primary" data-toggle="collapse" id="addUser_button" data-target="#addUserDiv">
    <i class='fa fa-fw fa-plus'></i> Add a List
</button>
<h2></h2>

<div id="addUserDiv" class="accordion-body collapse panel-body">
<fieldset class="well">
<div class="row">
    <div class="col-lg-8">
        <form name="userForm" class="dirtyForm" method="post" action="">
            <div class="form-group">
                <label>Title</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-book" aria-hidden="true"></i></span>
                    <input class="form-control" type="text" name="hottitles_title" maxlength="255" placeholder="Title" required>
                </div>
            </div>
            <div class="form-group">
                <label>Saved Search RSS URL</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-rss" aria-hidden="true"></i></span>
                    <input class="form-control" type="text" name="hottitles_url" maxlength="255" placeholder="http://mydomain.com:8080/list/dynamic/8675309/rss" required>
                </div>
            </div>

            <input type="hidden" name="save_main" value="true"/>
            <button type="submit" name="hottitles_submit" class="btn btn-primary"><i class='fa fa-fw fa-plus'></i> Add List</button>
        </form>
    </div>
</div>
</fieldset>
</div>

<!--Users table-->
<div class="row">
    <div class="col-lg-12">
        <div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>Sort</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.inc.php');
?>
