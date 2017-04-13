<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

//clear all session variables
session_unset();

$_SESSION['file_referer'] = 'index.php';

if (!empty($_POST)) {
    if ($_POST['not_robot'] == 'e6a52c828d56b46129fbf85c4cd164b3') {

        $userLogin = mysqli_query($db_conn, "SELECT id, username, password, email, level, loc_id FROM users WHERE username='" . safeCleanStr($_POST['username']) . "' AND password=SHA1('" . $blowfishSalt . safeCleanStr($_POST['password']) . "') AND email='" . validateEmail($_POST['email']) . "' LIMIT 1");
        $rowLogin = mysqli_fetch_array($userLogin);

        if (is_array($rowLogin)) {
            $_SESSION['user_id'] = $rowLogin['id'];
            $_SESSION['user_name'] = $rowLogin['username'];
            $_SESSION['user_email'] = $rowLogin['email'];
            $_SESSION['user_level'] = $rowLogin['level'];
            $_SESSION['user_loc_id'] = $rowLogin['loc_id'];
            $_SESSION['user_ip'] = getRealIpAddr();
            $_SESSION['timeout'] = time();
            $_SESSION['loggedIn'] = 1;
            $_SESSION['session_hash'] = md5($rowLogin['username']);

            //If is Admin
            if ($rowLogin['level'] == 1) {
                //Loads the getLocList as a session variable
                $_SESSION['loc_list'] = getLocList();
            }

            //get the client IP and datetime at each log in. update the database row
            if ($_SESSION['user_ip'] == '' || $_SESSION['user_ip'] == NULL) {
                $_SESSION['user_ip'] = '0.0.0.0';
            }

            if (isset($_SESSION['user_ip'])) {
                $userUpdate = "UPDATE users SET clientip='" . $_SESSION['user_ip'] . "', datetime='" . date("Y-m-d H:i:s") . "' WHERE id=" . $_SESSION['user_id'] . " ";
                mysqli_query($db_conn, $userUpdate);
            }

        } else {
            $message = "<div class='alert alert-danger' role='alert'>Invalid Username or Password!<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
        }

    }
}

//Reset password page messages
if ($_GET['forgotpassword'] == 'true' && $_GET['msgsent'] == 'notfound') {
    $message = "<div class='alert alert-danger' role='alert'>Invalid email.  Please see your Website Administrator to correct.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
} elseif ($_GET['forgotpassword'] == 'true' && $_GET['msgsent'] == 'error') {
    $message = "<div class='alert alert-danger' role='alert'>An error occurred while resetting your password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
}

//Password reset message
if ($_GET['msgsent'] == 'reset') {
    $message = "<div class='alert alert-danger' role='alert'>Your password is reset.  A temporary password was sent to your email address.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
}

//If logged in then...
if (isset($_SESSION['loggedIn'])) {

    // redirect user to user manager page to update password info
    if ($_GET['msgsent'] == 'reset') {
        header("Location: users.php?updatepassword=true&loc_id=" . $_SESSION['user_loc_id'] . "");
        echo "<script>window.location.href='users.php?updatepassword=true&loc_id=" . $_SESSION['user_loc_id'] . "';</script>";
    } else {
        header("Location: setup.php?loc_id=" . $_SESSION['user_loc_id'] . "");
        echo "<script>window.location.href='setup.php?loc_id=" . $_SESSION['user_loc_id'] . "';</script>";
    }

}

// get default location logo
$userSetup = mysqli_query($db_conn, "SELECT logo, loc_id FROM setup WHERE loc_id = 1 LIMIT 1");
$rowSetup = mysqli_fetch_array($userSetup);

$userLogo = $rowSetup['logo'];

?>
    <style type="text/css">
        html, body {
            margin-top: 0 !important;
            background: #fcfcfc url('images/color-splash-3.jpg') center center;
            /*background: #fcfcfc;*/
            background-size: cover;
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

        #page-wrapper {
            background-color: transparent !important;
        }

        .navbar-inverse, .scrollToTop {
            display: none !important;
        }

        #wrapper {
            padding-left: 0 !important;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
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
                    <div class="text-center">
                        <?php
                        if (!empty($userLogo)) {
                            echo "<a href='../index.php'><img src='../uploads/1/".$userLogo."' class='img-responsive img-center' title='Home' alt='Home'/></a>";
                        } else {
                            echo "<p></p>";
                        }
                        ?>
                    </div>
                    <section class="login-form">
                        <?php
                        if (!$_GET['forgotpassword']) {
                            ?>
                            <form name="frmSignin" class="form-signin" method="post" action="">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Username" id="user_name" name="username" type="text" autocomplete="off" autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Email Address" id="user_email" name="email" type="email" pattern="<?php echo $emailValidationPattern ?>" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password" id="user_password" name="password" type="password" value="" autocomplete="off" pattern="<?php echo $passwordValidationPattern; ?>" title="<?php echo $passwordValidationTitle; ?>" required>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox" required><i class="fa fa-android" aria-hidden="true"></i> I'm not a robot</label>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block" name="sign_in_submit" id="sign_in" disabled="disabled" type="submit"><i class="fa fa-fw fa-sign-in"></i> Log in</button>
                                </fieldset>
                            </form>
                            <div class="panel-heading text-center">
                                <small><a href="index.php?forgotpassword=true">Forgot Password</a> <i class='fa fa-question-circle-o'></i></small>
                            </div>
                            <?php
                        } else {
                            //create a random password and set it as a session variable
                            $_SESSION['temp_password'] = generateRandomPasswordString();

                            //Creates a unique refering value/token - exposed in post
                            $_SESSION['unique_referer'] = generateRandomString();
                            ?>

                            <form name="frmForgotPassword" class="form-signin" method="post" action="mail/passwordreset.php">
                                <fieldset>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <h3 class="text-center">Request a new password</h3>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Username" id="user_name" name="user_name" type="text" autocomplete="off" autofocus required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Email Address" id="user_email" name="user_email" type="email" pattern="<?php echo $emailValidationPattern ?>" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox" required><i class="fa fa-android" aria-hidden="true"></i> I'm not a robot</label>
                                    </div>
                                    <input type="hidden" id="referer" name="referer" value="<?php echo $_SESSION['unique_referer']; ?>"/>
                                    <button class="btn btn-lg btn-primary btn-block" name="forgot_password_submit" id="sign_in" disabled="disabled" type="submit">Reset Password</button>
                                </fieldset>
                            </form>
                            <div class="panel-heading text-center">
                                <small><i class="fa fa-long-arrow-left"></i> <a href="index.php">Back to Login</a></small>
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
include_once('includes/footer.inc.php');
?>