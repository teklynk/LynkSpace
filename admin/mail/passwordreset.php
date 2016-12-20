<?php

if (isset($_POST['user_name'])) {

    include '../../db/config.php';

    $redirectPage = "../index.php?msgsent=reset";

    //if an error user and email combo not found in db occurs
    $errorPageNotFound = "../index.php?forgotpassword=true&msgsent=notfound";

    //if an error occurs
    $errorPage = "../index.php?forgotpassword=true&msgsent=error";

    //*7561F5295A1A35CB8E0A7C46921994D383947FA5 = r00t

    $user_name = trim($_POST['user_name']);
    $email_address = trim($_POST['user_email']);
    $temp_password = trim($_POST['temp_password']);

    $sqlUsers = mysqli_query($db_conn, "SELECT username, email FROM users WHERE email='".$email_address."' AND username='".$user_name."' ");
    $rowUsers = mysqli_fetch_array($sqlUsers);

    // Check for empty fields
    if (empty($user_name) || empty($email_address) || !filter_var($email_address, FILTER_VALIDATE_EMAIL) || empty($temp_password)) {

        echo "<script>window.location.href='$errorPage';</script>";
        return false;

    } else if ($rowUsers['username'] != $user_name || $rowUsers['email'] != $email_address) {

        echo "<script>window.location.href='$errorPageNotFound';</script>";
        return false;

    } else {
        // Create the email and send the message
        $email_subject = "Website User Account Form:  $user_name";
        $email_body = "Your password has been reset.\n\n" . "Here are the details:\n\nUser Name: $user_name\n\nEmail: $email_address\n\nTemp Password: $temp_password\n\n";
        $headers = "From: noreply@dev-vm.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
        $headers .= "Reply-To: noreply@dev-vm.com";

        //Update user password with temp_password where email and username match
        $contactUpdate = "UPDATE users SET username='".htmlspecialchars(strip_tags($user_name), ENT_QUOTES)."', password=password('".strip_tags($temp_password)."') WHERE email='".filter_var($email_address, FILTER_VALIDATE_EMAIL)."' AND username='".htmlspecialchars(strip_tags($user_name), ENT_QUOTES)."' ";
        mysqli_query($db_conn, $contactUpdate);

        mail($email_address, $email_subject, $email_body, $headers);

        echo "<script>window.location.href='$redirectPage';</script>";
        return true;
    }
}

?>