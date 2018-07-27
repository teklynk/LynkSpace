<?php
define('ALLOW_INC', TRUE);

//Create these files if they do not exist.
// Copy config-sample.php to config.php
if (!is_writable($_SERVER['DOCUMENT_ROOT'])) {
    echo "<div class='alert alert-danger'><span>" . $_SERVER['DOCUMENT_ROOT'] . " directory is not writable.</span></div>";
} else {
    if (!file_exists(__DIR__ . "/../config/config.php")) {
        @copy(__DIR__ . "/../config/config-sample.php", dbConfigLoc);
    }
    // Copy dbconn-sample.php to dbconn.php
    if (!file_exists(__DIR__ . "/../config/dbconn.php")) {
        @copy(__DIR__ . "/../config/dbconn-sample.php", dbFileLoc);
    }
    // Copy blowfishsalt-sample.php to blowfishsalt.php
    if (!file_exists(__DIR__ . "/../config/blowfishsalt.php")) {
        @copy(__DIR__ . "/../config/blowfishsalt-sample.php", dbBlowfishLoc);
    }
    // Copy htaccess-sample to .htaccess
    if (!file_exists(__DIR__ . "/../.htaccess")) {
        @copy(__DIR__ . "/../.htaccess-sample", __DIR__ . "/../.htaccess");
    }
}

define('recaptcha', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

// Check that everything is installed on the server.
checkDependencies();

// Get server domain name
$server_domain = $_SERVER['SERVER_NAME'];

// Get client IP address
$user_ip = getRealIpAddr();

// Generate a random Blowfish Salt key using the random password string function
$blowfishHash = blowfishSaltRandomString(generateRandomPasswordString());

$response = NULL;
$sucessfulResponse = NULL;

//Google Recaptcha validation
if (recaptcha_secret_key && recaptcha_site_key) {
    $reCaptcha_enabled = true;
    require_once(__DIR__ . '/core/recaptchalib.php');
    $reCaptcha = NEW ReCaptcha(recaptcha_secret_key);
} else {
    $reCaptcha_enabled = false;
    $reCaptcha = NULL;
}

if ($reCaptcha_enabled == true && $_POST["g-recaptcha-response"]) {
    $response = $reCaptcha->verifyResponse(
        filter_var($_SERVER["REMOTE_HOST"], FILTER_FLAG_HOST_REQUIRED),
        $_POST["g-recaptcha-response"]
    );
}

if (!empty($_POST) && $_POST['db_install'] == 'true') {

    // Check if using Google Recaptcha
    if ($reCaptcha_enabled == true) {
        if ($response != NULL && $response->success) {
            $sucessfulResponse = true;
        } else {
            $sucessfulResponse = false;
        }
        // Check if using standard checkbox validation
    } elseif ($reCaptcha_enabled == false) {
        if ($_POST['not_robot'] == 'e6a52c828d56b46129fbf85c4cd164b3') {
            $sucessfulResponse = true;
        } else {
            $sucessfulResponse = false;
        }
    }

    if ($sucessfulResponse == true) {

        //Truncate Uploads folder
        if (file_exists(__DIR__ . "/../uploads")) {
            unlink(__DIR__ . "/../uploads");
            sleep(1); // wait
            mkdir(__DIR__ . "/../uploads", 0755, true);
        } else {
            mkdir(__DIR__ . "/../uploads", 0755, true);
        }

        // open and truncate sitemap file
        $sitemapFile = fopen(__DIR__ . "/../sitemap.xml", "w") or die("Unable to open " . __DIR__ . "/../sitemap.xml. Check file permissions");
        //Clear the file sitemap file
        ftruncate($sitemapFile, 0);
        fclose($sitemapFile);

        // open and truncate robots.txt file
        $robotsTxtFile = fopen(__DIR__ . "/../robots.txt", "w") or die("Unable to open " . __DIR__ . "/../robots.txt. Check file permissions");
        //Clear the file robots.txt file
        ftruncate($robotsTxtFile, 0);
        fclose($robotsTxtFile);

        sleep(1); // wait

        // MySQL host
        $mysql_host = safeCleanStr($_POST['dbserver']);
        // MySQL username
        $mysql_username = safeCleanStr($_POST['dbusername']);
        // MySQL password
        $mysql_password = safeCleanStr($_POST['dbpassword']);
        // MySql Database name
        $mysql_database = safeCleanStr($_POST['dbname']);
        // User Name
        $username = safeCleanStr($_POST['user_name']);
        // User email
        $useremail = validateEmail($_POST['user_email']);
        // User Password
        $userpassword = safeCleanStr($_POST['user_password']);

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
        $lines = file(dbFilename);

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
        sleep(1);

        // Write to dbconn file
        $dbfile = fopen(dbFileLoc, "w") or die("Unable to open " . $dbfile . "");

        //Clear the file dbconn file
        ftruncate($dbfile, 0);

        $writeline = "<?php\n";
        fwrite($dbfile, $writeline);
        $writeline = "define('db_servername', '" . $mysql_host . "');\n";
        fwrite($dbfile, $writeline);
        $writeline = "define('db_username', '" . $mysql_username . "');\n";
        fwrite($dbfile, $writeline);
        $writeline = "define('db_password', '" . $mysql_password . "');\n";
        fwrite($dbfile, $writeline);
        $writeline = "define('db_name', '" . $mysql_database . "');\n";
        fwrite($dbfile, $writeline);
        $writeline = "?>";
        fwrite($dbfile, $writeline);

        fclose($dbfile);

        // Write to blowfish file
        $dbBlowfish = fopen(dbBlowfishLoc, "w") or die("Unable to open " . dbBlowfishLoc . "");

        //Clear the file blowfish file
        ftruncate($dbBlowfish, 0);

        $writeline = "<?php\n";
        fwrite($dbBlowfish, $writeline);
        $writeline = "define('blowfishSalt', '" . $blowfishHash . "');\n";
        fwrite($dbBlowfish, $writeline);
        $writeline = "?>";
        fwrite($dbBlowfish, $writeline);

        fclose($dbBlowfish);

        clearstatcache();

        // Empty the users table
        mysqli_query($db_conn, 'TRUNCATE TABLE users');

        // Wait before proceeding to the next step
        sleep(1);

        // Insert super admin user into users table.
        $userInsert = "INSERT INTO users (username, email, password, level, loc_id, datetime, clientip) VALUES ('" . $username . "','" . $useremail . "', SHA1('" . $blowfishHash . $userpassword . "'), 1, 1, '" . date("Y-m-d H:i:s") . "', '" . $user_ip . "');";
        mysqli_query($db_conn, $userInsert);

        // Wait before proceeding to the next step
        sleep(1);

        // Rename install page so that it can not be accessed after the initial install
        rename("install.php", "~install.old");

        // Redirect to admin login page
        header("Location: index.php", true, 302);
        echo "<script>window.location.href='index.php';</script>"; // redirect to login page
    } else {
        die("Install Failed.");
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
            display: none !important;
            visibility: hidden !important;
        }
    </style>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-body">
                    <div class="text-center login-logo">
                        <h3><?php echo cmsTitle; ?></h3>
                        <small><?php echo cmsDescription; ?></small>
                    </div>
                    <section class="install-form">
                        <form name="frmInstall" class="form-signin" method="post" action="">
                            <fieldset>
                                <h2 class="form-signin-heading">Database Connection</h2>
                                <div class="form-group required">
                                    <label>Database Server</label>
                                    <input class="form-control" type="text" name="dbserver" id="dbserver"
                                           maxlength="100" autofocus autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="dbusername">Database Username</label>
                                    <input class="form-control" type="text" name="dbusername" id="dbusername"
                                           maxlength="100" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="dbpassword">Database Password</label>
                                    <input class="form-control" type="text" name="dbpassword" id="dbpassword"
                                           maxlength="100" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="dbname">Database Name</label>
                                    <input class="form-control" type="text" name="dbname" id="dbname" maxlength="100"
                                           autocomplete="off" required>
                                </div>
                                <h2 class="form-signin-heading">Create an Admin user</h2>
                                <div class="form-group required">
                                    <label for="username">Username</label>
                                    <input class="form-control" type="text" name="user_name" id="user_name"
                                           maxlength="100" autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="useremail">User Email</label>
                                    <input class="form-control" type="email" name="user_email" id="user_email"
                                           maxlength="100" pattern="<?php echo emailValidationPattern; ?>"
                                           autocomplete="off" required>
                                </div>
                                <div class="form-group required">
                                    <label for="password">User Password</label>
                                    <input class="form-control" type="text" name="user_password" id="user_password"
                                           maxlength="100" pattern="<?php echo passwordValidationPattern; ?>"
                                           data-toggle="tooltip"
                                           data-original-title="<?php echo passwordValidationTitle; ?>"
                                           data-placement="top" autocomplete="off" required>
                                </div>
                                <?php if ($reCaptcha_enabled == true) { ?>
                                    <div class="checkbox g-recaptcha"
                                         data-sitekey=<?php echo recaptcha_site_key; ?>></div>
                                <?php } else { ?>
                                    <div class="checkbox">
                                        <label><input title="I'm not a robot" class="checkbox" name="not_robot"
                                                      id="not_robot" type="checkbox" required><i class="fa fa-android"
                                                                                                 aria-hidden="true"></i>&nbsp;I'm
                                            not a robot</label>
                                    </div>
                                <?php } ?>
                                <input type="hidden" name="db_install" value="true">
                                <button class="run_installer btn btn-lg btn-primary btn-block" disabled="disabled"
                                        id="run_installer" name="install_submit" type="submit"><i
                                            class="fa fa-fw fa-cloud-upload"></i> Install
                                </button>
                                <br/>
                            </fieldset>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php
require_once(__DIR__ . '/includes/footer.inc.php');
?>