<?php
define('ALLOW_INC', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

echo "<div class='page-page'>";

require_once(__DIR__ . '/includes/featured.inc.php');

echo "<div class='container bannerwrapper'>";
echo "<div class='row content' id='page'>";

echo "<div class='col-lg-12'>";
echo "<h1 class='page'>" . $pageTitle . "</h1>";
echo "</div>";

echo "<div class='col-xs-12 col-lg-12 page-content'>";
echo $pageContent;
echo "</div>";

echo "<div>" . getDisqusCode(pageUrlStr,  $_SESSION['unique_referrer']) . "</div>";

echo "</div>";
echo "</div>";

echo "</div>";

require_once(__DIR__ . '/includes/footer.inc.php');
?>