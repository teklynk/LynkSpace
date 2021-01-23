<?php
//Contains DB connection
require_once('dbconn.php');

$rowConfig = '';
$db_conn = '';

//Establish config connection
$db_conn = mysqli_connect(db_servername, db_username, db_password);
mysqli_select_db($db_conn, db_name);
mysqli_set_charset($db_conn, 'UTF-8');

// If DB not found then halt the script.
if (mysqli_connect_error() || mysqli_connect_errno()) {
    echo "<h1>Database not found. Please configure dbconn.php with your connection settings.</h1>";
    die("MySQL Error: " . mysqli_connect_error() . " : " . mysqli_connect_errno());
} else {
    $sqlConfig = mysqli_query($db_conn, "SELECT theme, iprange, multibranch, loc_types, homepageurl, setuppacurl, searchlabel_ls2pac, searchlabel_ls2kids, searchplaceholder_ls2pac, searchplaceholder_ls2kids, customer_id, session_timeout, carousel_speed, analytics FROM config WHERE id=1;");
    $rowConfig = mysqli_fetch_array($sqlConfig, MYSQLI_ASSOC);
}
?>