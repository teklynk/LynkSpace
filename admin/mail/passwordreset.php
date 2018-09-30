<?php
session_start();

if ($_POST['user_name'] && $_POST['user_email'] && $_SESSION['file_referrer'] == 'index.php') {

    require_once(__DIR__ . '/../../config/config.php');
    require_once(__DIR__ . '/../core/functions.php');

    //create a random hashed string and set it as a session variable
    $temp_password_reset_hash = generateRandomString();

    //redirect to pages
    $redirectPage = "../index.php?msgsent=reset";
    $redirectPageRequest = "../index.php?msgsent=resetinstructions";

    //if an error user and email not found occurs
    $errorPageNotFound = "../index.php?forgotpassword=true&msgsent=notfound";

    //if an error occurs
    $errorPage = "../index.php?forgotpassword=true&msgsent=error";

    $server_domain = $_SERVER['SERVER_NAME'];
    $user_ip = getRealIpAddr();

    $user_name = sqlEscapeStr($_POST['user_name']);
    $email_address = sqlEscapeStr($_POST['user_email']);

    $sqlUsers = mysqli_query($db_conn, "SELECT username, email FROM users WHERE email='" . $email_address . "' AND username='" . $user_name . "';");
    $rowUsers = mysqli_fetch_array($sqlUsers, MYSQLI_ASSOC);

    // Check for empty fields
    if (empty($user_name) || empty($email_address) || !validateEmail($email_address)) {
        header("Location: $errorPage", true, 302);
        echo "<script>window.location.href='$errorPage';</script>";

    } elseif ($rowUsers['username'] != $user_name || $rowUsers['email'] != $email_address) {
        header("Location: $errorPageNotFound", true, 302);
        echo "<script>window.location.href='$errorPageNotFound';</script>";

    } else {
        //Reset the user password
        if ($_POST['password_reset'] == 'true' && !empty($_POST['key'])) {

            $newUserPassword = sqlEscapeStr($_POST['password']);
            $newUserPasswordConfirm = sqlEscapeStr($_POST['user_password_confirm']);
            $keyHashed = sha1(blowfishSalt . sqlEscapeStr($_POST['key']));
            $passwordHashed = sha1(blowfishSalt . sqlEscapeStr($_POST['password']));

            $sqlUserReset = mysqli_query($db_conn, "SELECT password_reset, password_reset_date, email FROM users WHERE password_reset='" . $keyHashed . "' AND email='" . $email_address . "' LIMIT 1;");
            $rowUserReset = mysqli_fetch_array($sqlUserReset, MYSQLI_ASSOC);

            if ($newUserPassword == $newUserPasswordConfirm && $keyHashed == $rowUserReset['password_reset'] && date("Y-m-d") == $rowUserReset['password_reset_date']) {

                // Create the email and send the message
                $email_subject = "$server_domain - User Account Information Change: $user_name";
                $email_body = "This email confirms that your password has been changed. To log on the site, use the following credentials.\n\n";
                $email_body .= "Username: $user_name\n\nEmail: $email_address\n\nReferrer: $server_domain\n\nIP Address: $user_ip\n\n";
                $email_body .= "Your password has been reset. Visit: " . serverUrlStr . "/index.php to sign in.\n\n";
                $email_body .= "If you have any questions or encounter any problems logging in, please contact the website administrator.\n\n";
                $headers = "From: noreply@$server_domain\n";
                $headers .= "Reply-To: noreply@$server_domain";

                //Update user password where password_reset and email match
                $userUpdate = "UPDATE users SET password='" . $passwordHashed . "' WHERE password_reset='" . $keyHashed . "' AND username='" . $user_name . "' AND email='" . $email_address . "';";
                mysqli_query($db_conn, $userUpdate);

                //Clear password_reset column and password_reset_date column. Set to nothing
                $userResetUpdate = "UPDATE users SET password_reset='', password_reset_date='' WHERE username='" . $user_name . "' AND email='" . $email_address . "';";
                mysqli_query($db_conn, $userResetUpdate);

                mail($email_address, $email_subject, $email_body, $headers);

                //redirect to successful reset message
                header("Location: $redirectPage", true, 302);
                echo "<script>window.location.href='$redirectPage';</script>";

            } else {

                //redirect to error message
                header("Location: $errorPageNotFound", true, 302);
                echo "<script>window.location.href='$errorPageNotFound';</script>";

            }

        } else {

            //Send email with password reset instructions.
            $tempPasswordHashed = sha1(blowfishSalt . safeCleanStr($temp_password_reset_hash));

            // Create the email and send the message
            $email_subject = "$server_domain - User Account Information Change: $user_name";
            $email_body .= "Username: $user_name\n\nEmail: $email_address\n\nReferrer: $server_domain\n\nIP Address: $user_ip\n\n";
            $email_body .= "To reset your password, visit the following address:\n\n" . serverUrlStr . "/admin/index.php?passwordreset=true&key=" . $temp_password_reset_hash . "\n\n";
            $email_body .= "If you have any questions or encounter any problems logging in, please contact the website administrator.\n\n";
            $headers = "From: noreply@$server_domain\n";
            $headers .= "Reply-To: noreply@$server_domain";

            //Update user password_reset with $temp_password_reset_hash where email and username match
            $userUpdate = "UPDATE users SET password_reset='" . $tempPasswordHashed . "', password_reset_date='" . date("Y-m-d h:i:s") . "' WHERE email='" . $email_address . "' AND username='" . $user_name . "';";
            mysqli_query($db_conn, $userUpdate);

            mail($email_address, $email_subject, $email_body, $headers);

            //send password reset request message
            header("Location: $redirectPageRequest", true, 302);
            echo "<script>window.location.href='$redirectPageRequest';</script>";
        }

    }
}
?>