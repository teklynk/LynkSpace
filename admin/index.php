<?php
define('inc_access', TRUE);

include 'includes/header.php';

//Random password generator
function generateRandomString($length = 10) {
    global $randomString;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//clear all session variables
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['user_loc_id']);
    unset($_SESSION['timeout']);
    unset($_SESSION['loggedIn']);
    unset($_SESSION['file_referer']);
    unset($_SESSION['session_hash']);
    unset($_SESSION['loc_id']);
    unset($_SESSION['loc_name']);

    $message = "";

    if (!empty($_POST)) {
        if ($_POST['not_robot'] == 'e6a52c828d56b46129fbf85c4cd164b3') {

            $userLogin = mysqli_query($db_conn, "SELECT id, username, password, email, level, loc_id FROM users WHERE username='".strip_tags($_POST['username'])."' AND password=password('".strip_tags($_POST['password'])."') AND email='".filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)."' LIMIT 1");
            $rowLogin = mysqli_fetch_array($userLogin);

            if (is_array($rowLogin)) {
                $_SESSION['user_id'] = $rowLogin['id'];
                $_SESSION['user_name'] = $rowLogin['username'];
                $_SESSION['user_level'] = $rowLogin['level'];
                $_SESSION['user_loc_id'] = $rowLogin['loc_id'];
                $_SESSION['timeout'] = time();
                $_SESSION['loggedIn'] = 1;
                $_SESSION['file_referer'] = 'index.php';
                $_SESSION['session_hash'] = md5($rowLogin['username']);

            } else {
                $message = "<div class='alert alert-danger' role='alert'>Invalid Username or Password!<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
            }
        }
    }

    if (file_exists('install.php')) {
        $message = "<div class='alert alert-danger' role='alert'>Please remove install.php from the admin folder.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
    }

    //Password reset messages for forgotpassword
    if ($_GET['msgsent'] == 'reset') {
        $message = "<div class='alert alert-success' role='alert'>Your user password has been reset. A temporary password has been sent to your email.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
    }

    if ($_GET['msgsent'] == 'error') {
        $message = "<div class='alert alert-danger' role='alert'>An error occurred while resetting your password.<button type='button' class='close' data-dismiss='alert' onclick=\"window.location.href='index.php'\">×</button></div>";
    }

    //If logged in then...
    if (isset($_SESSION['loggedIn'])) {

        if ($_GET['msgsent'] == 'reset') {
            echo "<script>window.location.href='users.php?updatepassword=true&loc_id=".$_SESSION['user_loc_id']."';</script>";
        } else {
            echo "<script>window.location.href='setup.php?loc_id=".$_SESSION['user_loc_id']."';</script>";
        }

    }

    ?>
    <style>
        html, body {
            margin-top: 0px !important;
            /*background: #0033A0 center center /cover;*/
            /*background: linear-gradient(-200deg, #0033a0, #008eaa);*/
            /*background-color: #0033a0;*/
            /*-webkit-background-size: cover;*/
            /*-moz-background-size: cover;*/
            /*-o-background-size: cover;*/
            /*background-size: cover;*/
            /*background: linear-gradient(#111,#414141,#414141);*/
            background-color: #222;
        }

    #page-wrapper {
        background-color: transparent !important;
    }

    .navbar-inverse {
        display: none !important;
    }

    #wrapper {
        padding-left: 0px !important;
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
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="message">
                    <?php

                        if ($message != "") {
                            echo $message;
                        }
                    ?>
                </div>
                <div class="panel-body">
                    <?php
                    if (!$_GET['forgotpassword']) {
                    ?>
                        <form name="frmUser" class="form-signin" method="post" action="">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" maxlength="255" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" maxlength="255" placeholder="Email Address" name="email" type="email">
                                </div>
                                <div class="form-group">
                                    <input class="form-control" maxlength="255" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <div class="checkbox">
                                    <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox"><i class="fa fa-android" aria-hidden="true"></i> I'm not a robot</label>
                                </div>
                                <button class="btn btn-lg btn-primary btn-block" name="sign_in_submit" id="sign_in" disabled="disabled" type="submit">Sign in</button>
                            </fieldset>
                        </form>
                        <p></p>
                        <div class="form-group text-center">
                            <small><a href="index.php?forgotpassword=true">Forgot Password</a></small>
                        </div>
                    <?php
                    } else {
                    ?>
                        <form name="frmForgotPassword" class="form-signin" method="post" action="mail/passwordreset.php">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" maxlength="255" placeholder="Username" name="user_name" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" maxlength="255" placeholder="Email Address" name="user_email" type="email" autofocus>
                                </div>
                                <div class="checkbox">
                                    <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox"><i class="fa fa-android" aria-hidden="true"></i> I'm not a robot</label>
                                </div>
                                <input type="hidden" name="temp_password" value="<?php echo generateRandomString();?>" >
                                <button class="btn btn-lg btn-primary btn-block" name="forgot_password_submit" id="sign_in" disabled="disabled" type="submit">Reset Password</button>
                            </fieldset>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php
    include 'includes/footer.php';
?>
