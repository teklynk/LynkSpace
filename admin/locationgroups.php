<?php

require_once(__DIR__ . '/includes/header.inc.php');

$_SESSION['file_referrer'] = 'locationgroups.php';

// Only allow Admin users access to this page
if (isset($_SESSION['loggedIn']) && $_SESSION['user_level'] != 1) {
    header('Location: index.php?logout=true', true, 302);
    echo "<script>window.location.href='index.php?logout=true';</script>";
}

//Hide admin navigation and header, footer
echo "<style type='text/css'>html, body {margin-top:0 !important;} nav, .row, .version {display:none !important;} #wrapper {padding-left: 0px !important;} #page-wrapper {min-height: 200px !important;}</style>";

?>
<table class="table table-bordered table-hover table-striped table-responsive">
    <thead>
    <tr>
        <th>Location</th>
        <th>Location Group</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sqlLocList = mysqli_query($db_conn, "SELECT type, name FROM locations ORDER BY type, name DESC;");
    while ($rowLocList = mysqli_fetch_array($sqlLocList, MYSQLI_ASSOC)) {
        echo "<tr><td>" . $rowLocList['name'] . "</td><td>" . $rowLocList['type'] . "</td></tr>";
    }
    ?>
    <tbody>
    </tbody>
</table>
<?php

require_once(__DIR__ . '/includes/footer.inc.php');
?>
