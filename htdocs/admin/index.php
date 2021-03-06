<?php
define('ALLOW_INC', true);

define('recaptcha', true);

require_once(__DIR__ . '/includes/header.inc.php');

// Clear all session variables
session_unset();

$_SESSION['file_referrer'] = 'index.php';

// Creates a unique referring value/token
$_SESSION['unique_referrer'] = generateRandomString();

$response = null;
$sucessfulResponse = null;

// Get client IP address
$user_ip = getRealIpAddr();

// Check that everything is installed on the server.
checkDependencies();

// Google Recaptcha validation
if (recaptcha_secret_key && recaptcha_site_key) {
    $reCaptcha_enabled = true;
    require_once(__DIR__ . '/core/recaptchalib.php');
    $reCaptcha = new ReCaptcha(recaptcha_secret_key);
} else {
    $reCaptcha_enabled = false;
    $reCaptcha = null;
}

if ($reCaptcha_enabled == true && $_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        filter_var($_SERVER["REMOTE_HOST"], FILTER_FLAG_HOST_REQUIRED),
        $_POST["g-recaptcha-response"]
    );
}

//check if admin user exists in the db
$userExists = mysqli_query($db_conn, "SELECT level FROM users WHERE level=1 LIMIT 1;");
$rowUserExists = mysqli_fetch_array($userExists, MYSQLI_ASSOC);

// Login Action
if (!empty($_POST)) {

    // Make sure post values is okay and cleaned
    $postPassword = isset($_POST['password']) ? sqlEscapeStr($_POST['password']) : null;
    $userName = isset($_POST['username']) ? sqlEscapeStr($_POST['username']) : null;
    $userEmail = isset($_POST['email']) ? validateEmail($_POST['email']) : null;
    $userPassword = sha1(blowfishSalt . $postPassword);

    // Check and record failed login attempts
    loginAttempts($user_ip, 4, 30);

    // Check if using Google Recaptcha
    if ($reCaptcha_enabled == true) {
        if ($response != null && $response->success) {
            $sucessfulResponse = true;
        } else {
            $sucessfulResponse = false;
        }
        // Check if using standard checkbox validation
    } elseif ($reCaptcha_enabled == false) {
        if ($_POST['not_robot'] == '814ff90c56a74b5e2bb48cd240331867a95357e1') {
            $sucessfulResponse = true;
        } else {
            $sucessfulResponse = false;
        }
    }

    // Check if password meets the regex requirement - Server Side Check
    if (!preg_match(passwordValidationPattern, $postPassword)) {
        $sucessfulResponse = true;
    } else {
        $sucessfulResponse = false;
    }

    if ($sucessfulResponse == true && isset($_SESSION['unique_referrer']) && $_SESSION['file_referrer'] == 'index.php') {

        $userLogin = mysqli_query($db_conn, "SELECT id, username, password, email, level, loc_id FROM users WHERE username='" . $userName . "' AND password='" . $userPassword . "' AND email='" . $userEmail . "' LIMIT 1;");
        $rowLogin = mysqli_fetch_array($userLogin, MYSQLI_ASSOC);

        if (is_array($rowLogin)) {
            $_SESSION['user_id'] = $rowLogin['id'];
            $_SESSION['user_name'] = $rowLogin['username'];
            $_SESSION['user_email'] = $rowLogin['email'];
            $_SESSION['user_level'] = $rowLogin['level'];
            $_SESSION['user_loc_id'] = $rowLogin['loc_id'];
            $_SESSION['user_ip'] = getRealIpAddr();
            $_SESSION['loggedIn'] = 1;
            $_SESSION['session_hash'] = md5($rowLogin['username']);
            $_SESSION['updates_available'] = checkForUpdates();

            // If is Admin
            if ($rowLogin['level'] == 1 && multiBranch == 'true') {
                //Loads the getLocList as a session variable
                $_SESSION['loc_list'] = getLocList(loc_id, 'false');
            }

            // Get the client IP and datetime at each log in. update the database row
            if ($_SESSION['user_ip'] == '' || $_SESSION['user_ip'] == null) {
                $_SESSION['user_ip'] = '0.0.0.0';
            }

            if (isset($_SESSION['user_ip'])) {
                $userUpdate = "UPDATE users SET clientip='" . $_SESSION['user_ip'] . "', DATETIME='" . date("Y-m-d H:i:s") . "' WHERE id=" . $_SESSION['user_id'] . ";";
                mysqli_query($db_conn, $userUpdate);
            }

            // Delete failed login attempts from login_attempts table
            $sqlLoginAttemptDelete = "DELETE FROM login_attempts WHERE ip='" . getRealIpAddr() . "';";
            mysqli_query($db_conn, $sqlLoginAttemptDelete);

        } elseif (!$rowUserExists) {

            // Insert admin user into users table.
            $userInsert = "INSERT INTO users (username, email, password, password_reset, password_reset_date, level, guid, loc_id, datetime, clientip) VALUES ('" . $userName . "','" . $userEmail . "', '" . $userPassword . "', 0, '" . date( "Y-m-d" ) . "', 1, '" . getGuid($userName, false) . "', 1, '" . date( "Y-m-d H:i:s" ) . "', '" . $user_ip . "');";
            mysqli_query( $db_conn, $userInsert );

            // Redirect to login page
            header("Location: index.php?loc_id=" . $_SESSION['user_loc_id'] . "", true, 302);
            echo "<script>window.location.href='index.php?loc_id=" . $_SESSION['user_loc_id'] . "';</script>";
            exit();

        } else {

            session_unset();
            $message = "<div class='alert alert-warning' role='alert'>Your username and/or password was incorrect. Please try again.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
        }

    }

}

// Reset password error messages
if ($_GET['forgotpassword'] == 'true' && $_GET['msgsent'] == 'notfound') {
    $message = "<div class='alert alert-warning' role='alert'>Invalid email. Please see your Website Administrator to correct.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
} elseif ($_GET['forgotpassword'] == 'true' && $_GET['msgsent'] == 'error') {
    $message = "<div class='alert alert-warning' role='alert'>An error occurred while resetting your password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
}

// Password reset instructions
if ($_GET['msgsent'] == 'resetinstructions') {
    $message = "<div class='alert alert-warning' role='alert'>Please check your email for instructions on how to reset your password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
}

// Password reset message
if ($_GET['msgsent'] == 'reset') {
    $message = "<div class='alert alert-warning' role='alert'>Your password is reset. Please sign in with your new password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
}

// If logged in then...
if (isset($_SESSION['loggedIn'])) {

    // Redirect user to setup page
    header("Location: setup.php?loc_id=" . $_SESSION['user_loc_id'] . "", true, 302);
    echo "<script>window.location.href='setup.php?loc_id=" . $_SESSION['user_loc_id'] . "';</script>";
    exit();

}

?>
    <style type="text/css">
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fcfcfc url('assets/images/color-splash-3.jpg') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .form-signin {
            max-width: 330px;
            padding: 0;
            margin: 0 auto;
        }

        #page-wrapper {
            background-color: transparent !important;
        }

        .navbar-inverse, .scrollToTop {
            display: none !important;
        }

        #wrapper {
            padding-left: 0 !important;
        }

        .login-panel {
            margin-top: 60px;
        }

        .login-panel img {
            margin: 20px auto;
            vertical-align: middle;
        }

        .login-panel .img-center {
            display: inline;
        }

        footer {
            display: inline-block !important;
            visibility: visible !important;
        }
    </style>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="message">
                    <?php
                    if ($message != "") {
                        echo $message;
                    }
                    ?>
                </div>
                <div class="panel-body">
                    <div class="text-center login-logo">
                        <h3><?php echo cmsTitle; ?></h3>
                        <small><?php echo cmsDescription; ?></small>
                    </div>
                    <section class="login-form">
                        <?php
                        if ($_GET['forgotpassword']) {
                            ?>
                            <form name="frmForgotPassword" class="form-signin" method="post"
                                  action="core/mail/passwordreset.php">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <h3 class="text-center">Request a new password</h3>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="20" placeholder="Username"
                                                   id="user_name" name="user_name" type="text"
                                                   pattern="<?php echo usernameValidationPattern; ?>" autocomplete="off"
                                                   autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Email Address"
                                                   id="user_email" name="user_email" type="email"
                                                   pattern="<?php echo emailValidationPattern; ?>" autocomplete="off"
                                                   required>
                                        </div>
                                    </div>
                                    <?php if ($reCaptcha_enabled == true) { ?>
                                        <div class="checkbox g-recaptcha"
                                             data-sitekey="<?php echo recaptcha_site_key; ?>"></div>
                                    <?php } else { ?>
                                        <div class="checkbox">
                                            <label><input title="I'm not a robot" class="checkbox" name="not_robot"
                                                          id="not_robot" type="checkbox" required><i
                                                        class="fa fa-android" aria-hidden="true"></i>&nbsp;I'm not a
                                                robot</label>
                                        </div>
                                    <?php } ?>

                                    <button class="btn btn-lg btn-primary btn-block" name="forgot_password_submit"
                                            id="sign_in" disabled="disabled" type="submit">Reset Password
                                    </button>
                                </fieldset>
                            </form>
                            <div class="panel-heading text-center">
                                <small><i class="fa fa-long-arrow-left"></i> <a href="index.php">Back to Login</a>
                                </small>
                            </div>
                            <?php
                        } elseif ($_GET['passwordreset'] == "true" && $_GET['key']) {
                            ?>
                            <form name="frmResetPassword" class="form-signin" method="post"
                                  action="core/mail/passwordreset.php">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <h3 class="text-center">Change your password</h3>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="20" placeholder="Username"
                                                   id="user_name" name="user_name" type="text"
                                                   pattern="<?php echo usernameValidationPattern; ?>" autocomplete="off"
                                                   autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Email Address"
                                                   id="user_email" name="user_email" type="email"
                                                   pattern="<?php echo emailValidationPattern; ?>" autocomplete="off"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password"
                                                   id="user_password" name="password" type="password" value=""
                                                   autocomplete="off" pattern="<?php echo passwordValidationPattern; ?>"
                                                   title="<?php echo passwordValidationTitle; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Confirm</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password Confirm"
                                                   id="user_password_confirm" name="user_password_confirm"
                                                   type="password" value="" autocomplete="off"
                                                   pattern="<?php echo passwordValidationPattern; ?>"
                                                   title="<?php echo passwordValidationTitle; ?>" required>
                                        </div>
                                    </div>
                                    <?php if ($reCaptcha_enabled == true) { ?>
                                        <div class="checkbox g-recaptcha"
                                             data-sitekey="<?php echo recaptcha_site_key; ?>"></div>
                                    <?php } else { ?>
                                        <div class="checkbox">
                                            <label><input title="I'm not a robot" class="checkbox" name="not_robot"
                                                          id="not_robot" type="checkbox" required><i
                                                        class="fa fa-android" aria-hidden="true"></i>&nbsp;I'm not a
                                                robot</label>
                                        </div>
                                    <?php } ?>

                                    <input type="hidden" id="password_reset" name="password_reset"
                                           value="<?php echo $_GET['passwordreset']; ?>"/>
                                    <input type="hidden" id="key" name="key" value="<?php echo $_GET['key']; ?>"/>
                                    <button class="btn btn-lg btn-primary btn-block" name="forgot_password_submit"
                                            id="sign_in" disabled="disabled" type="submit">Reset Password
                                    </button>
                                </fieldset>
                            </form>
                            <div class="panel-heading text-center">
                                <small><i class="fa fa-long-arrow-left"></i> <a href="index.php">Back to Login</a>
                                </small>
                            </div>
                        <?php } elseif (!$rowUserExists) { ?>
                            <div class="alert alert-info text-center"><strong>Admin user does not exist. Create a Admin user.</strong>
                            </div>
                            <form name="frmSignin" class="form-signin" method="post" action="">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="20" placeholder="Username"
                                                   id="user_name" name="username" type="text"
                                                   pattern="<?php echo usernameValidationPattern; ?>" autocomplete="off"
                                                   autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Email Address"
                                                   id="user_email" name="email" type="email"
                                                   pattern="<?php echo emailValidationPattern; ?>" autocomplete="off"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password"
                                                   id="user_password" name="password" type="password" value=""
                                                   autocomplete="off" pattern="<?php echo passwordValidationPattern; ?>"
                                                   title="<?php echo passwordValidationTitle; ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password Confirm</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password Confirm"
                                                   id="user_password_confirm" name="user_password_confirm"
                                                   type="password" value="" autocomplete="off"
                                                   pattern="<?php echo passwordValidationPattern; ?>"
                                                   title="<?php echo passwordValidationTitle; ?>" required>
                                        </div>
                                    </div>

                                    <?php if ($reCaptcha_enabled == true) { ?>
                                        <div class="checkbox g-recaptcha"
                                             data-sitekey="<?php echo recaptcha_site_key; ?>"></div>
                                    <?php } else { ?>
                                        <div class="checkbox">
                                            <label><input title="I'm not a robot" class="checkbox" name="not_robot"
                                                          id="not_robot" type="checkbox" required><i
                                                        class="fa fa-android" aria-hidden="true"></i>&nbsp;I'm not a
                                                robot</label>
                                        </div>
                                    <?php } ?>

                                    <button class="btn btn-lg btn-primary btn-block" name="sign_in_submit" id="sign_in"
                                            disabled="disabled" type="submit"><i class="fa fa-fw fa-sign-in"></i> Log in
                                    </button>
                                </fieldset>
                            </form>
                            <?php
                        } else {
                            ?>
                            <form name="frmSignin" class="form-signin" method="post" action="">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user-circle"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="20" placeholder="Username"
                                                   id="user_name" name="username" type="text"
                                                   pattern="<?php echo usernameValidationPattern; ?>" autocomplete="off"
                                                   autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Email Address"
                                                   id="user_email" name="email" type="email"
                                                   pattern="<?php echo emailValidationPattern; ?>" autocomplete="off"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-fw fa-lock"
                                                                               aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password"
                                                   id="user_password" name="password" type="password" value=""
                                                   autocomplete="off" pattern="<?php echo passwordValidationPattern; ?>"
                                                   title="<?php echo passwordValidationTitle; ?>" required>
                                        </div>
                                    </div>

                                    <?php if ($reCaptcha_enabled == true) { ?>
                                        <div class="checkbox g-recaptcha"
                                             data-sitekey="<?php echo recaptcha_site_key; ?>"></div>
                                    <?php } else { ?>
                                        <div class="checkbox">
                                            <label><input title="I'm not a robot" class="checkbox" name="not_robot"
                                                          id="not_robot" type="checkbox" required><i
                                                        class="fa fa-android" aria-hidden="true"></i>&nbsp;I'm not a
                                                robot</label>
                                        </div>
                                    <?php } ?>

                                    <button class="btn btn-lg btn-primary btn-block" name="sign_in_submit" id="sign_in"
                                            disabled="disabled" type="submit"><i class="fa fa-fw fa-sign-in"></i> Log in
                                    </button>
                                </fieldset>
                            </form>
                            <div class="panel-heading text-center">
                                <small><a href="index.php?forgotpassword=true">Forgot Password</a> <i
                                            class='fa fa-fw fa-question-circle'></i></small>
                            </div>
                            <?php
                        }
                        ?>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>