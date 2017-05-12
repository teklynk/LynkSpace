<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-team'>";

echo "<div class='grad-blue container-fluid featured'>";
echo "<div class='container bannerwrapper'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1) {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

echo "<div class='container'>";
echo "<div class='row row_pad content'>";
echo "<div class='col-md-12'>";
    include 'includes/team.inc.php';
echo "</div>";
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container bannerwrapper databases'>";
    include 'includes/customersfeatured.inc.php';
echo "</div>";
echo "</div>";

echo "</div>";

include_once('includes/footer.inc.php');
?>