<?php
define('inc_access', TRUE);

require_once('includes/header.inc.php');

echo "<div class='page-index'>";

require_once('includes/slider.inc.php');

require_once('includes/featured.inc.php');

require_once('includes/hottitles.inc.php');

require_once('includes/databasesfeatured.inc.php');

echo "</div>";

require_once('includes/footer.inc.php');
?>