<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'usermanager.php';

// Only allow Admin users have access to this page
if ( isset( $_SESSION['loggedIn'] ) && $_SESSION['user_level'] != 1 ) {
	header( 'Location: index.php?logout=true', true, 302 );
	echo "<script>window.location.href='index.php?logout=true';</script>";
}

$usersCount = 0;

//Delete user
$deluserId    = isset( $_GET['deleteuser'] ) ? safeCleanStr( $_GET['deleteuser'] ) : false;
$deluserTitle = isset( $_GET['deletetitle'] ) ? safeCleanStr( addslashes( $_GET['deletetitle'] ) ) : false;
$deluserGuid  = isset( $_GET['guid'] ) ? safeCleanStr( $_GET['guid'] ) : false;

//Add User
//insert data on submit
$userName            = isset( $_POST['user_name'] ) ? sqlEscapeStr( $_POST['user_name'] ) : null;
$userEmail           = isset( $_POST['user_email'] ) ? validateEmail( $_POST['user_email'] ) : null;
$userPassword        = sha1( blowfishSalt . safeCleanStr( $_POST['user_password'] ) );
$userPasswordConfirm = isset( $_POST['user_password_confirm'] ) ? safeCleanStr( $_POST['user_password_confirm'] ) : null;
$userLevel           = isset( $_POST['user_level'] ) ? safeCleanStr( $_POST['user_level'] ) : null;
$userLocation        = isset( $_POST['user_location'] ) ? safeCleanStr( $_POST['user_location'] ) : null;
$userIp              = getRealIpAddr();

if ( $deluserId && $deluserTitle && ! $_GET['confirm'] ) {
	showModalConfirm(
		"confirm",
		"Delete User?",
		"Are you sure you want to delete: " . $deluserTitle . "?",
		"usermanager.php?loc_id=" . loc_id . "&deleteuser=" . $deluserId . "&deletetitle=" . $deluserTitle . "&guid=" . $deluserGuid . "&confirm=yes",
		false
	);

} elseif ( $deluserId && $deluserTitle && $deluserGuid && $_GET['confirm'] == 'yes' ) {
	//delete user after clicking Yes
	dbQuery(
		'delete',
		'users',
		null,
		null,
		'id=' . $deluserId . ' AND guid="' . $deluserGuid . '" ',
		null
	);

	flashMessageSet( 'success', $deluserTitle . " has been deleted." );

	//Redirect back to main page
	header( "Location: usermanager.php?loc_id=" . loc_id . "", true, 302 );
	echo "<script>window.location.href='usermanager.php?loc_id=" . loc_id . "';</script>";
	exit();
}

if ( $_POST['save_main'] ) {
	if ( $_POST['user_password'] == $_POST['user_password_confirm'] ) {

		$sqlUsersInfo = dbQuery(
			'select',
			'users',
			'username, email',
			null,
			'username="' . $userName . '" AND email="' . $userEmail . '" ',
			null
		);

		$rowCheckUser = mysqli_num_rows( $sqlUsersInfo );

		if ( $rowCheckUser > 0 ) {
			$pageMsg = "<div class='alert alert-danger'>Username: " . $userName . " and Email: " . $userEmail . " already exist. Try a different username or email.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='usermanager.php'\">×</button></div>";
		} else {

			dbQuery(
				'insert',
				'users',
				'username, email, password, password_reset, password_reset_date, level, guid, clientip, datetime, loc_id',
				' "' . $userName . '", "' . $userEmail . '", "' . $userPassword . '", "", now(), ' . $userLevel . ', "' . getGuid() . '", "' . $userIp . '", "' . date( "Y-m-d h:i:s" ) . '", "' . $userLocation . '" ',
				null,
				null
			);

			flashMessageSet( 'success', $userName . " has been added." );

			//Redirect back to main page
			header( "Location: usermanager.php?loc_id=" . loc_id . "", true, 302 );
			echo "<script>window.location.href='usermanager.php?loc_id=" . loc_id . "';</script>";
			exit();
		}

	} else {
		flashMessageSet( 'success', "Passwords do not match." );
	}
}

?>

    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li class="active">User Manager</li>
            </ol>
            <h1 class="page-header">
                User Manager
            </h1>
        </div>
    </div>

<?php echo flashMessageGet( 'success' ); ?>

    <!-- Add user form-->
    <button type="button" class="btn btn-primary" data-toggle="collapse" id="addUser_button" data-target="#addUserDiv">
        <i class='fa fa-fw fa-plus'></i> Add a User
    </button>
    <h2></h2>

    <div id="addUserDiv" class="accordion-body collapse panel-body">
        <div class="row">
            <div class="col-lg-8">
                <fieldset class="well">
                    <form name="userForm" class="dirtyForm" method="post">
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_name">Username</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                    <input class="form-control" type="text" name="user_name" maxlength="255"
                                           value="<?php echo $userName; ?>" placeholder="Username" autofocus
                                           autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_email">User Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"
                                                                       aria-hidden="true"></i></span>
                                    <input class="form-control" type="email" name="user_email" maxlength="255"
                                           value="<?php echo $userEmail; ?>" placeholder="Email Address"
                                           pattern="<?php echo emailValidationPattern; ?>" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_password">User Password</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input class="form-control" type="password" name="user_password"
                                           placeholder="Password" value=""
                                           pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip"
                                           data-original-title="<?php echo passwordValidationTitle; ?>"
                                           autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group required">
                                <label for="user_password_confirm">Password Confirm</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                    <input class="form-control" type="password" name="user_password_confirm"
                                           placeholder="Password Confirm" value=""
                                           pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip"
                                           data-original-title="<?php echo passwordValidationTitle; ?>"
                                           autocomplete="off" required>
                                </div>
                            </div>
                        </div>
						<?php
						if ( multiBranch == 'true' ) {
							?>
                            <div class="col-lg-12">
                                <div class="form-group required">
                                    <label for="user_location">User Location</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-university"
                                                                           aria-hidden="true"></i></span>
                                        <select class="form-control selectpicker show-tick" data-live-search="true"
                                                data-container="body" data-dropup-auto="false" data-size="10"
                                                name="user_location" title="Choose a location" required>
											<?php echo getLocList( loc_id, 'true' ); ?>
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
                                    <select class="form-control selectpicker show-tick" data-container="body"
                                            data-dropup-auto="false" data-size="10" name="user_level"
                                            title="Choose a user level" required>
                                        <option value="0">User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">

                                <input type="hidden" name="csrf"
                                       value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                                <input type="hidden" name="save_main" value="true">
                                <button type="submit" name="user_submit" class="btn btn-primary"><i
                                            class='fa fa-fw fa-save'></i> Save Changes
                                </button>
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
						'id, username, email, clientip, level, guid, datetime, loc_id',
						null,
						null,
						'level, email, username ASC'
					);
					//$sqlUsers = mysqli_query($db_conn, $sqlUsers);
					while ( $rowUsers = mysqli_fetch_array( $sqlUsers, MYSQLI_ASSOC ) ) {

						$usersID       = $rowUsers['id'];
						$usersName     = safeCleanStr( addslashes( $rowUsers['username'] ) );
						$usersEmail    = $rowUsers['email'];
						$usersClientIP = $rowUsers['clientip'];
						$usersLevel    = $rowUsers['level'];
						$usersDateTime = $rowUsers['datetime'];
						$usersLocID    = $rowUsers['loc_id'];
						$usersGuid     = $rowUsers['guid'];
						$usersCount ++;

						//Prevent someone from accidentally deleting self.
						if ( $_SESSION['user_id'] == $usersID ) {
							$disable   = 'disabled';
							$usersID   = '';
							$usersGuid = '';
						} else {
							$disable = '';
						}

						if ( $usersLevel == 1 ) {
							$usersLevel = 'Admin';
						} else {
							$usersLevel = 'User';
						}

						//get location name for each user
						$sqlUsersLocName = dbQuery(
							'select',
							'locations',
							'id, name',
							null,
							'id=' . $usersLocID,
							null
						);

						$rowLocName = mysqli_fetch_array( $sqlUsersLocName, MYSQLI_ASSOC );

						$locationName = $rowLocName['name'];

						echo "<tr>
                            <td><div class='text-center'><img class='img-circle' src=" . getGravatar( $usersEmail, 28 ) . "/></div></td>
                            <td>$usersName</td>
                            <td>$usersEmail</td>
                            <td>$usersLevel</td>
                            <td>$locationName</td>
                            <td>$usersDateTime</td>
                            <td>$usersClientIP</td>
                            <td>
                                <button type='button' data-toggle='tooltip' title='Delete' class='btn btn-danger " . $disable . "' " . $disable . " onclick=\"window.location.href='usermanager.php?loc_id=" . loc_id . "&deleteuser=" . $usersID . "&deletetitle=" . $usersName . "&guid=" . $usersGuid . "'\"><i class='fa fa-fw fa-trash'></i></button>
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
        $(document).ready(function () {
            $('#confirm').on('hidden.bs.modal', function () {
                setTimeout(function () {
                    window.location.href = 'usermanager.php?loc_id=<?php echo loc_id; ?>';
                }, 100);
            });

            var url = window.location.href;
            if (url.indexOf('deleteuser') != -1 && url.indexOf('confirm') == -1) {
                setTimeout(function () {
                    $('#confirm').modal('show');
                }, 100);
            }
        });
    </script>
<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>