<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-page'>";

include 'includes/featured.inc.php';

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

echo "<div class='container'>";
echo "<div class='row row_pad content' id='page'>";

echo "<div class='col-lg-12'>";
echo "<h1 class='page'>" . $pageTitle . "</h1>";
echo "</div>";

echo "<div class='col-xs-12 col-lg-12 page-content'>";

echo $pageContent;

echo "</div>";

echo "</div>";
echo "</div>";

include 'includes/databasesfeatured.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>