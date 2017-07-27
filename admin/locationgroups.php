<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

$_SESSION['file_referrer'] = 'locationgroups.php';

// Only allow Admin users access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1) {
    header('Location: index.php?logout=true');
    echo "<script>window.location.href='index.php?logout=true';</script>";
}
//Hide admin navigation and header, footer
echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";

?>
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
    <tr>
        <th>Name</th>
        <th>Type</th>
    </tr>
    </thead>
        <tbody>
        <?php
            $sqlLocList = mysqli_query($db_conn, "SELECT type, name FROM locations ORDER BY type, name");
            while ($rowLocList = mysqli_fetch_array($sqlLocList)){
                echo "<tr><td>".$rowLocList['name']."</td><td>".$rowLocList['type']."</td></tr>";
            }
        ?>
        <tbody>
    </tbody>
</table>
<?php

include_once('includes/footer.inc.php');
?>
