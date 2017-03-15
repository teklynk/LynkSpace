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
            User Manager
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
    <i class='fa fa-fw fa-plus'></i> Add a User
</button>
<h2></h2>

<div id="addUserDiv" class="accordion-body collapse panel-body">
<fieldset class="well">
<div class="row">
    <div class="col-lg-8">
        <form name="userForm" class="dirtyForm" method="post" action="">
            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                    <input class="form-control" type="text" name="user_name" maxlength="255" placeholder="Username" required>
                </div>
            </div>
            <div class="form-group">
                <label>User Email</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <input class="form-control" type="email" name="user_email" maxlength="255" placeholder="Email Address" required>
                </div>
            </div>
            <div class="form-group">
                <label>User Password</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <input class="form-control" type="password" name="user_password" placeholder="Password" pattern=".{8,}" title="8 characters minimum" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password Confirm</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <input class="form-control" type="password" name="user_password_confirm" placeholder="Password Confirm" pattern=".{8,}" title="8 characters minimum" required>
                </div>
            </div>
            <div class="form-group">
                <label>User Location</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-university" aria-hidden="true"></i></span>
                    <select class="form-control" name="user_location" required>
                        <option>Choose a location</option>
                        <?php echo $locUsersMenuStr;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>User Level</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user-secret" aria-hidden="true"></i></span>
                    <select class="form-control" name="user_level" required>
                        <option>Choose a user level</option>
                        <option value="0">User</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="save_main" value="true"/>
            <button type="submit" name="user_submit" class="btn btn-primary"><i class='fa fa-fw fa-plus'></i> Add User</button>
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
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Location</th>
                    <th>Last Login</th>
                    <th>Client IP</th>
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
