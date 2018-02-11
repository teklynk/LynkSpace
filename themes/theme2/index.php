<?php
define('inc_access', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

echo "<div class='page-index'>";

require_once(__DIR__ . '/includes/slider.inc.php');

require_once(__DIR__ . '/includes/featured.inc.php');

require_once(__DIR__ . '/includes/hottitles.inc.php');

require_once(__DIR__ . '/includes/databasesfeatured.inc.php');

echo "</div>";

require_once(__DIR__ . '/includes/footer.inc.php');
?>