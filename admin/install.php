<?php
define('inc_access', TRUE);

include_once('includes/header.php');

$_SESSION['file_referer'] = 'install.php';

// Name of the dbconn file
$dbFileLoc = "../db/dbconn.php";

// Name of the Source sql dump file
$filename = '../db/bootstrap_business.sql';

if (!file_exists($dbFileLoc)) {
    echo "$dbFileLoc does not exist";
}
if (!file_exists($filename)) {
    echo "$filename does not exist";
}

if (!empty($_POST)) {
    // MySQL host
    $mysql_host = $_POST["dbserver"];
    // MySQL username
    $mysql_username = $_POST["dbusername"];
    // MySQL password
    $mysql_password = $_POST["dbpassword"];
    // Database name
    $mysql_database = $_POST["dbname"];

    // establish db connection
    $db_conn = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysqli_error($db_conn));
    mysqli_select_db($db_conn, $mysql_database) or die('Error selecting MySQL database: ' . mysqli_error($db_conn));

    // Temporary variable, used to store current query
    $templine = '';
    // Read in entire file
    $lines = file($filename);

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

    $userInsert = "INSERT INTO users (username, email, password) VALUES ('" . safeCleanStr($_POST['username']) . "','" . filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) . "', password('" . safeCleanStr($_POST['password']) . "'))";
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
    $writeline = "\$db_name = '" . safeCleanStr($_POST['dbname']) . "';\n";
    fwrite($dbfile, $writeline);
    $writeline = "?>";
    fwrite($dbfile, $writeline);

    fclose($dbfile);

    rename("install.php", "install.old"); // rename install page so that it can not be accessed after the initial install
    header("Location: index.php");
    echo "<script>window.location.href='index.php';</script>"; // redirect to login page

} // the big IF
?>
    <style>
        html, body {
            margin-top: 0 !important;
            background-color: #fff !important;
        }

        .navbar-inverse {
            display: none !important;
        }

        #wrapper {
            padding-left: 0 !important;
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
                <h2 class="form-signin-heading">Database info</h2>
                <label for="dbserver" class="sr-only">DB Server</label>
                <input class="form-control" type="text" name="dbserver" maxlength="255" placeholder="DB Server" required>
                <label for="dbusername" class="sr-only">DB Username</label>
                <input class="form-control" type="text" name="dbusername" maxlength="255" placeholder="DB Username" required>
                <label for="dbpassword" class="sr-only">DBPassword</label>
                <input class="form-control" type="text" name="dbpassword" maxlength="255" placeholder="DB Password" required>
                <label for="dbname" class="sr-only">DB Name</label>
                <input class="form-control" type="text" name="dbname" maxlength="255" placeholder="DB Name" required>
                <h2 class="form-signin-heading">Create an Admin user</h2>
                <label for="username" class="sr-only">Username</label>
                <input class="form-control" type="text" name="username" maxlength="255" placeholder="Username" required>
                <label for="useremail" class="sr-only">User Email</label>
                <input class="form-control" type="email" name="useremail" maxlength="255" placeholder="Email" required>
                <label for="password" class="sr-only">Password</label>
                <input class="form-control" type="text" name="password" maxlength="255" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" name="install_submit" type="submit">Create</button>
            </form>
        </div>
    </div>
<?php
include_once('includes/footer.php');
?>