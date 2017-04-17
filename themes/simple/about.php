<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='container-fluid'>";
echo "<div class='container'>";
if ($_GET['loc_id'] == 1) {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";
include 'includes/about.inc.php';
echo "</div>";
echo "</div>";

include_once('includes/footer.inc.php');
?>