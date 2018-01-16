<?php
define('inc_access', TRUE);

require_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'usermanager.php';

// Only allow Admin users have access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1) {
    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}

$pageMsg = "";
$deleteMsg = "";
$usersCount = 0;

//delete user
$deluserId = $_GET['deleteuser'];
$deluserTitle = safeCleanStr(addslashes($_GET['deletetitle']));

if ($_GET['deleteuser'] && $_GET['deletetitle'] && !$_GET['confirm']) {
    showModalConfirm(
        "confirm",
        "Delete User?",
        "Are you sure you want to delete: ".$deluserTitle."?",
        "usermanager.php?loc_id=".$_GET['loc_id']."&deleteuser=".$deluserId."&deletetitle=".$deluserTitle."&confirm=yes",
        false
    );

} elseif ($_GET['deleteuser'] && $_GET['deletetitle'] && $_GET['confirm'] == 'yes') {
    //delete user after clicking Yes
    dbQuery(
        'delete',
        'users',
        NULL,
        NULL,
        'id=' . $deluserId,
        NULL
    );

    $deleteMsg = "<div class='alert alert-success'>" . $deluserTitle . " has been deleted.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php?loc_id=" . $_GET['loc_id'] . "'\">×</button></div>";
}

//Add User
//insert data on submit
$userName = sqlEscapeStr($_POST['user_name']);
$userEmail = $_POST['user_email'];
$userPassword = sha1(blowfishSalt . safeCleanStr($_POST['user_password']));
$userPasswordConfirm = $_POST['user_password_confirm'];
$userLevel = safeCleanStr($_POST['user_level']);
$userLocation = safeCleanStr($_POST['user_location']);
$userIp = getRealIpAddr();

if ($_POST['save_main']) {
    if ($_POST['user_password'] == $_POST['user_password_confirm']) {

        $sqlUsersInfo = dbQuery(
            'select',
            'users',
            'username, email',
            NULL,
            'username="' . $userName . '" AND email="' . validateEmail($userEmail) . '" ',
            NULL
        );

        $rowCheckUser = mysqli_num_rows($sqlUsersInfo);

        if ($rowCheckUser > 0) {
            $pageMsg = "<div class='alert alert-danger'>Username: " . $userName . " and Email: " . $userEmail . " already exist. Try a different username or email.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php'\">×</button></div>";
        } else {

            dbQuery(
                'insert',
                'users',
                'username, email, password, password_reset, password_reset_date, level, clientip, loc_id',
                ' "' . $userName . '", "' . $userEmail . '", "' . $userPassword . '", "", 0000-00-00, "' . $userLevel . '", "' . $userIp . '", "' . $userLocation . '" ',
                NULL,
                NULL
            );

            $pageMsg = "<div class='alert alert-success'>The user " . $userName . " has been added.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php'\">×</button></div>";
        }

    } else {
        $pageMsg = "<div class='alert alert-danger'>Passwords do not match.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php'\">×</button></div>";
    }
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
                            <div class="form-group required">
                                <label for="user_name">Username</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                    <input class="form-control" type="text" name="user_name" maxlength="255" value="<?php echo $userName; ?>" placeholder="Username" autofocus autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_email">User Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                    <input class="form-control" type="email" name="user_email" maxlength="255" value="<?php echo $userEmail; ?>" placeholder="Email Address" pattern="<?php echo emailValidationPattern; ?>" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_password">User Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input class="form-control" type="password" name="user_password" placeholder="Password" value="" pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo passwordValidationTitle; ?>" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_password_confirm">Password Confirm</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input class="form-control" type="password" name="user_password_confirm" placeholder="Password Confirm" value="" pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo passwordValidationTitle; ?>" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <?php
                        if (multiBranch == 'true') {
                            ?>
                            <div class="col-lg-12">
                                <div class="form-group required">
                                    <label for="user_location">User Location</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-university" aria-hidden="true"></i></span>
                                        <select class="form-control selectpicker show-tick" data-live-search="true" data-container="body" data-dropup-auto="false" data-size="10" name="user_location" title="Choose a location" required>
                                            <?php echo getLocList($_GET['loc_id'], 'true'); ?>
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
                            <div class="form-group required">
                                <label for="user_level">User Level</label>
                                <div class="input-group required">
                                    <span class="input-group-addon"><i class="fa fa-user-secret" aria-hidden="true"></i></span>
                                    <select class="form-control selectpicker show-tick" data-container="body" data-dropup-auto="false" data-size="10" name="user_level" title="Choose a user level" required>
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">

                                <input type="hidden" name="csrf" value="<?php csrf_validate($_SESSION['unique_referrer']); ?>"/>

                                <input type="hidden" name="save_main" value="true">
                                <button type="submit" name="user_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save Changes</button>
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
            <div>
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
                    //Get user info, exclude super admin user

                    $sqlUsers = dbQuery(
                        'select',
                        'users',
                        'id, username, email, clientip, level, datetime, loc_id',
                        NULL,
                        NULL,
                        'level, email, username ASC'
                    );
                    //$sqlUsers = mysqli_query($db_conn, $sqlUsers);
                    while ($rowUsers = mysqli_fetch_array($sqlUsers, MYSQLI_ASSOC)) {

                        $usersID = $rowUsers['id'];
                        $usersName = safeCleanStr(addslashes($rowUsers['username']));
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
                        $sqlUsersLocName = dbQuery(
                            'select',
                            'locations',
                            'id, name',
                            NULL,
                            'id=' . $usersLocID,
                            NULL
                        );

                        $rowLocName = mysqli_fetch_array($sqlUsersLocName, MYSQLI_ASSOC);

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
                                <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger " . $disable. "' " . $disable . " onclick=\"window.location.href='usermanager.php?loc_id=" . $_GET['loc_id'] . "&deleteuser=$usersID&deletetitle=" . $usersName . "'\"><i class='fa fa-fw fa-trash'></i></button>
                            </td>
                        </tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal javascript logic -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#confirm').on('hidden.bs.modal', function(){
                setTimeout(function(){
                    window.location.href='usermanager.php?loc_id=<?php echo $_GET['loc_id']; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deleteuser') != -1 && url.indexOf('confirm') == -1){
                setTimeout(function(){
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once('includes/footer.inc.php');
?>