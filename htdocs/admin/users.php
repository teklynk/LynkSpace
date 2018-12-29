<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

$_SESSION['file_referrer'] = 'users.php';

$user_name             = isset($_POST['user_name']) ? safeCleanStr($_POST['user_name']) : NULL;
$user_email            = isset($_POST['user_email']) ? validateEmail($_POST['user_email']) : NULL;
$user_password         = isset($_POST['user_password']) ? safeCleanStr($_POST['user_password']) : NULL;
$user_password_confirm = isset($_POST['user_password_confirm']) ? safeCleanStr($_POST['user_password_confirm']) : NULL;
$user_id               = isset($_POST['user_id']) ? sanitizeInt($_POST['user_id']) : NULL;

$sqlUsers = dbQuery(
	'select',
	'users',
	'username, password, email, datetime, id',
	null,
	'id=' . loc_id,
	null
);

$rowUsers = mysqli_fetch_array( $sqlUsers, MYSQLI_ASSOC );

//update table on submit
if ( ! empty( $_POST ) ) {

	if ( $user_password == $user_password_confirm ) {

		dbQuery(
			'update',
			'users',
			'username, password, email, datetime, clientip',
			" '" . $user_name . "', SHA1('" . blowfishSalt . $user_password . "'), '" . $user_email . "', '" . date( 'Y-m-d H:i:s' ) . "', '" . getRealIpAddr() . "' ",
			"id=" . loc_id . " ",
			null
		);

		flashMessageSet( 'success', $user_name . " has been updated." );
	} else {
		flashMessageSet( 'success', "Passwords do not match." );
	}

}
?>
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li><a href="setup.php?loc_id=<?php echo loc_id ?>">Home</a></li>
                <li class="active">My Account</li>
            </ol>
            <h1 class="page-header">
                My Account
            </h1>
        </div>
    </div>

<?php echo flashMessageGet( 'success' ); ?>

    <div class="row">
        <div class="col-lg-8">
            <form name="userForm" class="dirtyForm" method="post">
                <div class="form-group">
                    <div class="input-group">
                        <img class='img-circle img-responsive'
                             src="<?php echo getGravatar( $rowUsers['email'], 60 ); ?>"/>
                    </div>
                </div>

                <div class="form-group required">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                        <input class="form-control" type="text" name="user_name" maxlength="255"
                               value="<?php echo $rowUsers['username']; ?>" placeholder="Username" autofocus
                               autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group required">
                    <label>User Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input class="form-control" type="email" name="user_email" maxlength="255"
                               value="<?php echo $rowUsers['email']; ?>" placeholder="Email Address"
                               pattern="<?php echo emailValidationPattern; ?>" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group required">
                    <label>User Password</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input class="form-control" type="password" name="user_password" placeholder="Password"
                               value="<?php echo $user_password; ?>" pattern="<?php echo passwordValidationPattern; ?>"
                               data-toggle="tooltip" data-original-title="<?php echo passwordValidationTitle; ?>"
                               autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group required">
                    <label>Password Confirm</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input class="form-control" type="password" name="user_password_confirm"
                               placeholder="Password Confirm" value="<?php echo $user_password_confirm; ?>"
                               pattern="<?php echo passwordValidationPattern; ?>" data-toggle="tooltip"
                               data-original-title="<?php echo passwordValidationTitle; ?>" autocomplete="off" required>
                    </div>
                </div>

                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>"/>

                <div class="form-group">
                    <span><small><?php echo "Last Logged In: " . date( 'm-d-Y, H:i:s', strtotime( $rowUsers['datetime'] ) ); ?></small></span>
                </div>

                <input type="hidden" name="csrf" value="<?php csrf_validate( $_SESSION['unique_referrer'] ); ?>"/>

                <button type="submit" name="user_submit" class="btn btn-primary"><i class='fa fa-fw fa-save'></i> Save
                    Changes
                </button>
                <button type="reset" class="btn btn-default"><i class='fa fa-fw fa-reply'></i> Reset</button>

            </form>

        </div>
    </div>

<?php
require_once( __DIR__ . '/includes/footer.inc.php' );
?>