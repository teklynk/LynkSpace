<?php
session_start();

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once (__DIR__ . '/../../vendor/autoload.php');

require_once(__DIR__ . '/../../config/config.php');

$mail = new PHPMailer(true);

//Server settings
$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = '';
$mail->Password = '';
$mail->SMTPSecure = 'tls';
$mail->Port = 465;

//redirect back to contact form or home page
$redirectPage = "../../contact.php?loc_id=" . $_GET['loc_id'] . "&msgsent=thankyou#contactForm";
//if an error occurs
$errorPage = "../../contact.php?loc_id=" . $_GET['loc_id'] . "&msgsent=error#contactForm";

$name = $_POST['name'];
$email_address = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];
$sendTo = '';

if (!empty($_POST) && $_POST['referrer'] == $_SESSION['unique_referrer']) {
    // Check for empty fields
    if (empty($name) ||
        empty($email_address) ||
        empty($phone) ||
        empty($message)
    ) {
        header("Location: $errorPage", true, 302);
        echo "<script>window.location.href='$errorPage';</script>";
        return false;
    } else {

    	try {
		    // Create the email and send the message
		    $mail->setFrom($email_address, $name);
		    $mail->addAddress($sendTo, 'Contact Form');
		    $mail->Subject = "Website Contact Form:  $name";
		    $mail->Body    = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nMessage:\n$message";
		    $mail->send();
	    } catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		    die();
	    }

        header("Location: $redirectPage", true, 302);
        echo "<script>window.location.href='$redirectPage';</script>";
        return true;
    }
} else {
    die('Direct access not permitted');
}
?>