<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

// Check that everything is installed on the server.
checkDependencies();

// Get server domain name
$server_domain = $_SERVER['SERVER_NAME'];

// Get client IP address
$user_ip = getRealIpAddr();

// Generate a random Blowfish Salt key using the random password string function
$blowfishHash = blowfishSaltRandomString(generateRandomPasswordString());

if (!empty($_POST) && $_POST['db_install'] == 'true') {
    if ($_POST['not_robot'] == 'e6a52c828d56b46129fbf85c4cd164b3') {

        //Truncate Uploads folder
        if (file_exists(__DIR__ . "/../uploads")) {
            unlink(__DIR__ . "/../uploads");
            sleep(1); // wait
            mkdir(__DIR__ . "/../uploads", 0755, true);
        }

        // MySQL host
        $mysql_host = $_POST["dbserver"];
        // MySQL username
        $mysql_username = $_POST["dbusername"];
        // MySQL password
        $mysql_password = $_POST["dbpassword"];
        // Database name
        $mysql_database = $_POST["dbname"];

        // establish config connection
        $db_conn = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysqli_error($db_conn));

        // Create database
        $sqlCreate = "CREATE DATABASE " . $mysql_database . "";
        if (mysqli_query($db_conn, $sqlCreate)) {
            echo "Database created successfully";
        } else {
            die("Error creating database: " . mysqli_error($db_conn));
        }

        mysqli_select_db($db_conn, $mysql_database) or die('Error selecting MySQL database: ' . mysqli_error($db_conn));

        // Temporary variable, used to store current query
        $templine = '';

        // Import sql dump file into the database.

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

        // Wait before proceeding to the next step
        sleep(2);

        // Write to dbconn file
        $dbfile = fopen($dbFileLoc, "w") or die("Unable to open $dbFileLoc");

        //Clear the file
        ftruncate($dbFileLoc, 0);

        $writeline = "<?php\n";
        fwrite($dbfile, $writeline);
        $writeline = "\$db_servername = '" . safeCleanStr($_POST['dbserver']) . "';\n";
        fwrite($dbfile, $writeline);
        $writeline = "\$db_username = '" . safeCleanStr($_POST['dbusername']) . "';\n";
        fwrite($dbfile, $writeline);
        $writeline = "\$db_password = '" . safeCleanStr($_POST['dbpassword']) . "';\n";
        fwrite($dbfile, $writeline);
        $writeline = "\$db_name = '" . safeCleanStr($_POST['dbname']) . "';\n";
        fwrite($dbfile, $writeline);
        $writeline = "?>";
        fwrite($dbfile, $writeline);

        fclose($dbfile);

        // Write to blowfish file
        $dbBlowfish = fopen($dbBlowfishLoc, "w") or die("Unable to open $dbBlowfishLoc");

        //Clear the file
        ftruncate($dbBlowfishLoc, 0);

        $writeline = "<?php";
        fwrite($dbBlowfish, $writeline);
        $writeline = "\n\$blowfishSalt = '" . $blowfishHash . "';\n";
        fwrite($dbBlowfish, $writeline);
        $writeline = "?>";
        fwrite($dbBlowfish, $writeline);

        fclose($dbBlowfish);

        // Empty the users table
        mysqli_query($db_conn, 'TRUNCATE TABLE users');

        // Wait before proceeding to the next step
        sleep(2);

        // Insert super admin user into users table. User Level 99 = Super Admin
        $userInsert = "INSERT INTO users (username, email, password, level, loc_id, datetime, clientip) VALUES ('" . safeCleanStr($_POST['username']) . "','" . validateEmail($_POST['useremail']) . "', SHA1('" . $blowfishHash . safeCleanStr($_POST['password']) . "'), 1, 1, '" . date("Y-m-d H:i:s") . "', '" . $user_ip . "')";
        mysqli_query($db_conn, $userInsert);

        // Wait before proceeding to the next step
        sleep(2);

        // Rename install page so that it can not be accessed after the initial install
        rename("install.php", "~install.old");

        // Redirect to admin login page
        header("Location: index.php");
        echo "<script>window.location.href='index.php';</script>"; // redirect to login page
    }

} // end of the big IF

// The Installer Form
?>
    <style type="text/css">
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            background: #fcfcfc url('images/color-splash-3.jpg') no-repeat center center fixed;
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
            display: none!important;
            visibility: hidden !important;
        }
    </style>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-body">
                    <section class="install-form">
                        <form name="frmInstall" class="form-signin" method="post" action="">
                            <fieldset>
                                <h2 class="form-signin-heading">Database Connection</h2>
                                <div class="form-group required">
                                    <label>Database Server</label>
                                    <input class="form-control" type="text" name="dbserver" maxlength="100" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="dbusername">Database Username</label>
                                    <input class="form-control" type="text" name="dbusername" maxlength="100" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="dbpassword">Database Password</label>
                                    <input class="form-control" type="text" name="dbpassword" maxlength="100" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="dbname">Database Name</label>
                                    <input class="form-control" type="text" name="dbname" maxlength="100" autocomplete="off" required>
                                </div>
                                <h2 class="form-signin-heading">Create an Admin user</h2>
                                <div class="form-group required">
                                    <label for="username">Username</label>
                                    <input class="form-control" type="text" name="username" id="user_name" maxlength="100" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="useremail">User Email</label>
                                    <input class="form-control" type="email" name="useremail" id="user_email" maxlength="100" pattern="<?php echo $emailValidationPattern; ?>" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="text" name="password" maxlength="100" pattern="<?php echo $passwordValidationPattern; ?>" data-toggle="tooltip" data-original-title="<?php echo $passwordValidationTitle; ?>" data-placement="top" autocomplete="off" required>
                                </div>
                                <div class="checkbox">
                                    <label><input title="I'm not a robot" class="checkbox" name="not_robot" id="not_robot" type="checkbox" required><i class="fa fa-android" aria-hidden="true"></i> I'm not a robot</label>
                                </div>
                                <input type="hidden" name="db_install" value="true">
                                <button class="run_installer btn btn-lg btn-primary btn-block" disabled="disabled" id="run_installer" name="install_submit" type="submit"><i class="fa fa-fw fa-cloud-upload"></i> Install</button>
                            </fieldset>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php
include_once('includes/footer.inc.php');
?>