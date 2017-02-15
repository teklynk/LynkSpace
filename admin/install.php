<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

// Name of the dbconn file
$dbFileLoc = "../db/dbconn.php";

// Name of the Source sql dump file
$dbFilename = '../db/bootstrap_business.sql';

// Database Name for web app
$dbName = 'tlc_website';

// Check if sql file exists
if (!file_exists($dbFileLoc)) {
    echo "$dbFileLoc does not exist";
}
// Check if dbconn.php file exists
if (!file_exists($dbFilename)) {
    echo "$dbFilename does not exist";
}

// Get server domain name
$server_domain = $_SERVER['SERVER_NAME'];

// Get client IP address
$user_ip = getRealIpAddr();

if (!empty($_POST) && $_POST['db_install'] == 'true') {
    // MySQL host
    $mysql_host = $_POST["dbserver"];
    // MySQL username
    $mysql_username = $_POST["dbusername"];
    // MySQL password
    $mysql_password = $_POST["dbpassword"];
    // Database name
    $mysql_database = $dbName;

    // establish db connection
    $db_conn = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysqli_error($db_conn));

    // Create database
    $sqlCreate = "CREATE DATABASE ".$dbName."";
    if (mysqli_query($db_conn, $sqlCreate)) {
        echo "Database created successfully";
    } else {
        die("Error creating database: " . mysqli_error($db_conn));
    }

    mysqli_select_db($db_conn, $mysql_database) or die('Error selecting MySQL database: ' . mysqli_error($db_conn));

    // Temporary variable, used to store current query
    $templine = '';

    // Read in entire file
    $lines = file($dbFilename);

    // Loop through each line
    foreach ($lines as $line) {

        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == '')
            continue;

        // Add this line to the current segment
        $templine .= $line;

        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';') {
            // Perform the query
            mysqli_query($db_conn, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($db_conn) . '<br /><br />');
            // Reset temp variable to empty
            $templine = '';
        }
    }

    //Empty the users table
    mysqli_query($db_conn,'TRUNCATE TABLE users');

    // Insert admin user into users table
    $userInsert = "INSERT INTO users (username, email, password, level, loc_id, datetime, clientip) VALUES ('" . safeCleanStr($_POST['username']) . "','" . filter_var(trim($_POST['useremail']), FILTER_VALIDATE_EMAIL) . "', SHA1('" . $blowfishSalt . safeCleanStr($_POST['password']) . "'), 1, 1, '" . date("Y-m-d H:i:s") . "', '".$user_ip."')";
    mysqli_query($db_conn, $userInsert);

    $dbfile = fopen($dbFileLoc, "w") or die("Unable to open file!");

    $writeline = "<?php\n";
    fwrite($dbfile, $writeline);
    $writeline = "\$db_servername = '" . safeCleanStr($_POST['dbserver']) . "';\n";
    fwrite($dbfile, $writeline);
    $writeline = "\$db_username = '" . safeCleanStr($_POST['dbusername']) . "';\n";
    fwrite($dbfile, $writeline);
    $writeline = "\$db_password = '" . safeCleanStr($_POST['dbpassword']) . "';\n";
    fwrite($dbfile, $writeline);
    $writeline = "\$db_name = '" . safeCleanStr($dbName) . "';\n";
    fwrite($dbfile, $writeline);
    $writeline = "?>";
    fwrite($dbfile, $writeline);

    fclose($dbfile);

    // Create the email and send the message
    $email_subject = "$server_domain - User Account has been added:  $user_name";
    $email_body = "To log on the site, use the following credentials.\n\n";
    $email_body .= "Username: " . safeCleanStr($_POST['username']) . "\n\nEmail: " . filter_var(trim($_POST['useremail']), FILTER_VALIDATE_EMAIL) . "\n\nPassword: " . safeCleanStr($_POST['password']) . "\n\nReferrer: $server_domain\n\nIP Address: $user_ip\n\n";
    $email_body .= "If you have any questions or encounter any problems logging in, please contact the web site administrator.\n\n";
    $headers = "From: noreply@$server_domain\n";
    $headers .= "Reply-To: noreply@$server_domain";

    // Send the email
    mail(filter_var(trim($_POST['useremail']), FILTER_VALIDATE_EMAIL), $email_subject, $email_body, $headers);

    // Rename install page so that it can not be accessed after the initial install
    rename("install.php", "~install.old");

    // Redirect to admin login page
    header("Location: index.php");
    echo "<script>window.location.href='index.php';</script>"; // redirect to login page

} // end of the big IF

// The Installer Form
?>

    <style>
        html, body {
            margin-top: 0px !important;
            background-color: #fff !important;
        }
        label {
            margin-top:6px;
            margin-bottom:0px;
        }
        .navbar-inverse, .scrollToTop {
            display: none !important;
        }
        #wrapper {
            padding-left: 0px !important;
        }
        .form-signin {
            max-width: 350px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>

    <div class="container">
        <div class="row">
            <form name="frmInstall" class="form-signin" method="post" action="">
                <h2 class="form-signin-heading">Database Connection</h2>
                <label for="dbserver">DB Server</label>
                <input class="form-control" type="text" name="dbserver" maxlength="255" required>
                <label for="dbusername">DB Username</label>
                <input class="form-control" type="text" name="dbusername" maxlength="255" required>
                <label for="dbpassword">DB Password</label>
                <input class="form-control" type="text" name="dbpassword" maxlength="255" required>
                <h2 class="form-signin-heading">Create an Admin user</h2>
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" maxlength="255" required>
                <label for="useremail">User Email</label>
                <input class="form-control" type="email" name="useremail" maxlength="255" required>
                <label for="password">Password</label>
                <input class="form-control" type="text" name="password" maxlength="255" required>
                <br />
                <input type="hidden" name="db_install" value="true">
                <button class="btn btn-lg btn-primary btn-block" name="install_submit" type="submit">Install</button>
            </form>
        </div>
    </div>

<?php
include_once('includes/footer.inc.php');
?>