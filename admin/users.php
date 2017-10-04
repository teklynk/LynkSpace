<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'users.php';

$sqlUsers = mysqli_query($db_conn, "SELECT username, password, email, datetime, id FROM users WHERE id=" . $_SESSION['user_id'] . " ");
$rowUsers = mysqli_fetch_array($sqlUsers);

//update table on submit
if (!empty($_POST) && $_POST['csrf'] == $_SESSION['unique_referrer']) {
    $username = $_POST['user_name'];
    $useremail = $_POST['user_email'];
    $userpass = $_POST['user_password'];
    $userpassconfirm = $_POST['user_password_confirm'];
    $userid = $_POST['user_id'];

    if ($userpass == $userpassconfirm) {
        $usersUpdate = "UPDATE users SET username='" . sqlEscapeStr($username) . "', password=SHA1('" . blowfishSalt . safeCleanStr($userpass) . "'), email='" . validateEmail($useremail) . "', datetime='" . date("Y-m-d H:i:s") . "', clientip='".getRealIpAddr()."' WHERE id=" . $userid . " ";
        mysqli_query($db_conn, $usersUpdate);

        $pageMsg = "<div class='alert alert-success fade in'>The user has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='users.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    } else {
        $pageMsg = "<div class='alert alert-danger fade in'>Passwords do not match.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='users.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
    }

    if ($_GET['updatepassword'] == 'true') {
        header("Location: users.php?passwordupdated=true&loc_id=" . $_GET['loc_id'] . "");
        echo "<script>window.location.href='users.php?passwordupdated=true&loc_id=" . $_GET['loc_id'] . "';</script>";
    }
}

if ($_GET['updatepassword'] == 'true') {
    $pageMsg = "<div class='alert alert-warning'>Please update your password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='users.php?loc_id=" . $_GET['loc_id'] . "'\"></button></div>";
}

if ($_GET['passwordupdated'] == 'true') {
    $pageMsg = "<div class='alert alert-success'>The user has been updated.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='users.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}
?>
<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">My Account</li>
        </ol>
        <h1 class="page-header">
            My Account
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <?php
        if ($errorMsg !="") {
            echo $errorMsg;
        } else {
            echo $pageMsg;
        }
        ?>
        <form name="userForm" class="dirtyForm" method="post" action="">
            <div class="form-group">
                <div class="input-group">
                    <img class='img-circle img-responsive' src="<?php echo getGravatar($rowUsers['email'], 60); ?>"/>
                </div>
            </div>

            <div class="form-group required">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                    <input class="form-control" type="text" name="user_name" maxlength="255" value="<?php echo $rowUsers['username']; ?>" placeholder="Username" autofocus autocomplete="off" required>
                </div>
            </div>
            <div class="form-group required">
                <label>User Email</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    <input class="form-control" type="email" name="user_email" maxlength="255" value="<?php echo $rowUsers['email']; ?>" placeholder="Email Address" pattern="<?php echo emailValidationPattern; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group required">
                <label>User Password</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <input class="form-control" type="password" name="user_password" placeholder="Password" value="<?php echo $_POST['user_password']; ?>" pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo passwordValidationTitle; ?>" autocomplete="off" required>
                </div>
            </div>
            <div class="form-group required">
                <label>Password Confirm</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    <input class="form-control" type="password" name="user_password_confirm" placeholder="Password Confirm" value="<?php echo $_POST['user_password_confirm']; ?>" pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo passwordValidationTitle; ?>" autocomplete="off" required>
                </div>
            </div>
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"/>
            <input type="hidden" name="passwdUpdated" value="<?php echo $pagePasswdUpdate; ?>"/>

            <div class="form-group">
                <span><small><?php echo "Last Logged In: " . date('m-d-Y, H:i:s', strtotime($rowUsers['datetime'])); ?></small></span>
            </div>

            <input type="hidden" name="csrf" value="<?php echo $_SESSION['unique_referrer']; ?>"/>

            <button type="submit" name="user_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
            <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

        </form>

    </div>
</div>

<?php
include_once('includes/footer.inc.php');
?>