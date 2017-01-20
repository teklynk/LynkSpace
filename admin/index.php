<?php
define('inc_access', TRUE);

include_once('includes/header.php');

$_SESSION['file_referer'] = 'index.php';

//clear all session variables
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
unset($_SESSION['user_level']);
unset($_SESSION['user_loc_id']);
unset($_SESSION['user_ip']);
unset($_SESSION['timeout']);
unset($_SESSION['loggedIn']);
unset($_SESSION['session_hash']);
unset($_SESSION['loc_id']);
unset($_SESSION['loc_name']);
unset($_SESSION['loc_list']);

if (!empty($_POST)) {
    if ($_POST['not_robot'] == 'e6a52c828d56b46129fbf85c4cd164b3') {

        $userLogin = mysqli_query($db_conn, "SELECT id, username, password, email, level, loc_id FROM users WHERE username='" . safeCleanStr($_POST['username']) . "' AND password=password('" . safeCleanStr($_POST['password']) . "') AND email='" . filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) . "' LIMIT 1");
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
            if ($_SESSION['user_ip'] == '') {
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

//if install.php file exists
//if (file_exists('install.php')) {
//    $message = "<div class='alert alert-danger' role='alert'>Please remove install.php from the admin folder.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
//}

//Reset password page messages
if ($_GET['forgotpassword'] == 'true' AND $_GET['msgsent'] == 'notfound') {
    $message = "<div class='alert alert-danger' role='alert'>Invalid email.  Please see your Website Administrator to correct.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
} elseif ($_GET['forgotpassword'] == 'true' AND $_GET['msgsent'] == 'error') {
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

?>
    <style type="text/css">
        html, body {
            margin-top: 0 !important;
            background: #BEA69A url('images/color-splash-3.jpg') center center /cover;
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

        .navbar-inverse {
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
                    <div class="text-center"><a href="../index.php"><img src="images/cpslogo_v2@2x.png" class="img-responsive img-center" title="Home" alt="Home"/></a></div>
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
                                            <input class="form-control" maxlength="255" placeholder="Email Address" id="user_email" name="email" type="email" pattern="<?php echo $emailValidatePattern ?>" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>User Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                            <input class="form-control" maxlength="255" placeholder="Password" id="user_password" name="password" type="password" value="" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox" required><i class="fa fa-android" aria-hidden="true"></i> I'm not a robot</label>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block" name="sign_in_submit" id="sign_in" disabled="disabled" type="submit">Sign in</button>
                                </fieldset>
                            </form>
                            <div class="panel-heading text-center">
                                <small><a href="index.php?forgotpassword=true">Forgot Password</a> <i class='fa fa-question-circle-o'></i></small>
                            </div>
                            <?php
                        } else {
                            //create a random password and set it as a session variable
                            session_start();
                            $_SESSION['temp_password'] = generateRandomString();
                            //Creates a unique refering value/token - exposed in post
                            $_SESSION['unique_referer'] = generateRandomString();
                            ?>
                            <form name="frmForgotPassword" class="form-signin" method="post" action="mail/passwordreset.php">
                                <fieldset>
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
                                            <input class="form-control" maxlength="255" placeholder="Email Address" id="user_email" name="user_email" type="email" pattern="<?php echo $emailValidatePattern ?>" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="checkbox">
                                        <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox" required><i class="fa fa-android" aria-hidden="true"></i>I'm not a robot</label>
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
include_once('includes/footer.php');
?>