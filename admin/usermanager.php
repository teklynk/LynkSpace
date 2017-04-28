<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referer'] = 'usermanager.php';

// Only allow Admin users have access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1) {

    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}


$pageMsg = "";
$deleteMsg = "";
$usersCount=0;

//delete user
$deluserId = $_GET['deleteuser'];
$deluserTitle = $_GET['deletetitle'];

if ($_GET['deleteuser'] && $_GET['deletetitle'] && !$_GET['confirm']) {

    $deleteMsg = "<div class='alert alert-danger'>Are you sure you want to delete " . $deluserTitle . "? <a href='?loc_id=" . $_GET['loc_id'] . "&deleteuser=" . $deluserId . "&deletetitle=" . safeCleanStr(addslashes($deluserTitle)) . "&confirm=yes' class='alert-link'>Yes</a><button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";

} elseif ($_GET['deleteuser'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes') {
    //delete user after clicking Yes
    $userDelete = "DELETE FROM users WHERE id='$deluserId'";
    mysqli_query($db_conn, $userDelete);

    $deleteMsg = "<div class='alert alert-success'>" . $deluserTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}

//Add User
//insert data on submit
if ($_POST['save_main']) {
    if ($_POST['user_password'] == $_POST['user_password_confirm']) {
        $usersInsert = "INSERT INTO users (username, email, password, level, clientip, loc_id) VALUES ('" . safeCleanStr($_POST['user_name']) . "', '" . validateEmail($_POST['user_email']) . "', '" . SHA1($blowfishSalt . safeCleanStr($_POST['user_password'])) . "', " . safeCleanStr($_POST['user_level']) . ", '" . getRealIpAddr() . "', " . safeCleanStr($_POST['user_location']) . ")";
        mysqli_query($db_conn, $usersInsert);

        $pageMsg = "<div class='alert alert-success'>The user " . safeCleanStr($_POST['user_name']) . " has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php'\">x</button></div>";
    } else {
        $pageMsg = "<div class='alert alert-danger'>Passwords do not match.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php'\">x</button></div>";
    }
}

//Get user info, exclude super admin user
$sqlUsers = mysqli_query($db_conn, "SELECT id, username, email, clientip, level, datetime, loc_id FROM users WHERE username != 'libadmin' ORDER BY username, email, level, datetime ASC");
$rowcount = mysqli_num_rows($sqlUsers);

//Get Location ID and Name
$sqlUsersLoc = mysqli_query($db_conn, "SELECT id, name FROM locations WHERE active='true' ORDER BY name ASC");

//build locations drop down list
while ($rowUsersLoc = mysqli_fetch_array($sqlUsersLoc)) {
    $locUsersId = $rowUsersLoc['id'];
    $locUsersName = $rowUsersLoc['name'];

    if ($locUsersId == 1) {
        $isDefault = " (Default)";
    } else {
        $isDefault = "";
    }

    $locUsersMenuStr .= "<option value=" . $locUsersId . ">" . $locUsersName . $isDefault . "</option>";
}

?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="setup.php?loc=<?php echo $_GET['loc_id'] ?>">Home</a></li>
            <li class="active">User Manager</li>
        </ol>
        <h1 class="page-header">
            User Manager
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
<!-- Add user form-->
<button type="button" class="btn btn-primary" data-toggle="collapse" id="addUser_button" data-target="#addUserDiv">
    <i class='fa fa-fw fa-plus'></i> Add a User
</button>
<h2></h2>

<div id="addUserDiv" class="accordion-body collapse panel-body">
    <div class="row">
        <div class="col-lg-8">
            <fieldset class="well">
                <form name="userForm" class="dirtyForm" method="post" action="">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="user_name">Username</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                <input class="form-control" type="text" name="user_name" maxlength="255" placeholder="Username" autofocus autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="user_email">User Email</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                <input class="form-control" type="email" name="user_email" maxlength="255" placeholder="Email Address" pattern="<?php echo $emailValidationPattern; ?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="user_password">User Password</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input class="form-control" type="password" name="user_password" placeholder="Password" pattern="<?php echo $passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo $passwordValidationTitle; ?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="user_password_confirm">Password Confirm</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                <input class="form-control" type="password" name="user_password_confirm" placeholder="Password Confirm" pattern="<?php echo $passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo $passwordValidationTitle; ?>" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($multiBranch == 'true') {
                        ?>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="user_location">User Location</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-university" aria-hidden="true"></i></span>
                                    <select class="form-control" name="user_location" required>
                                        <option>Choose a location</option>
                                        <?php echo $locUsersMenuStr; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        //Set user_location = 1 if not a multibranch
                        echo "<input type='hidden' name='user_location' id='user_location' value='1'/>";
                    }
                    ?>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="user_level">User Level</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-secret" aria-hidden="true"></i></span>
                                <select class="form-control" name="user_level" required>
                                    <option>Choose a user level</option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="hidden" name="save_main" value="true">
                            <button type="submit" name="user_submit" class="btn btn-primary"><i class='fa fa-fw fa-plus'></i> Add User</button>
                        </div>
                    </div>
                </form>
            </fieldset>
            <hr/>
        </div>
    </div>
</div>

<!--Users table-->
<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped table-responsive">
                <thead>
                <tr>
                    <th>&nbsp;</th>
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
                <?php
                while ($rowUsers = mysqli_fetch_array($sqlUsers)) {
                    $usersID = $rowUsers['id'];
                    $usersName = $rowUsers['username'];
                    $usersEmail = $rowUsers['email'];
                    $usersClientIP = $rowUsers['clientip'];
                    $usersLevel = $rowUsers['level'];
                    $usersDateTime = $rowUsers['datetime'];
                    $usersLocID = $rowUsers['loc_id'];
                    $usersCount++;

                    //Prevent someone from accidentally deleting self.
                    if ($_SESSION['user_id'] == $usersID) {
                        $disable = 'disabled';
                        $usersID = '';
                    } else {
                        $disable = '';
                    }

                    if ($usersLevel == 1) {
                        $usersLevel = 'Admin';
                    } else {
                        $usersLevel = 'User';
                    }

                    //get location name for each user
                    $sqlUsersLocName = mysqli_query($db_conn, "SELECT id, name FROM locations WHERE id=".$usersLocID." ");
                    $rowLocName = mysqli_fetch_array($sqlUsersLocName);

                    $locationName = $rowLocName['name'];

                    echo "<tr>
                            <td><div class='text-center'><img class='img-circle' src=". getGravatar($usersEmail, 28) ."/></div></td>
                            <td>$usersName</td>
                            <td>$usersEmail</td>
                            <td>$usersLevel</td>
                            <td>$locationName</td>
                            <td>$usersDateTime</td>
                            <td>$usersClientIP</td>
                            <td>
                                <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger' " . $disable . " onclick=\"window.location.href='usermanager.php?loc_id=" . $_GET['loc_id'] . "&deleteuser=$usersID&deletetitle=" . safeCleanStr(addslashes($usersName)) . "'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                        </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.inc.php');
?>
