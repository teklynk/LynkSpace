<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-page'>";

include 'includes/featured.inc.php';

echo "<div class='container'>";
echo "<div class='row content' id='page'>";

echo "<div class='col-lg-12'>";
echo "<h1 class='page'>" . $pageTitle . "</h1>";
echo "</div>";

echo "<div class='col-xs-12 col-lg-12 page-content'>";
echo $pageContent;
echo "</div>";

echo "</div>";
echo "</div>";

include 'includes/customersfeatured.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>