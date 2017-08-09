<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-index'>";

include 'includes/slider.inc.php';

include 'includes/featured.inc.php';

include 'includes/hottitles.inc.php';

include 'includes/databasesfeatured.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>