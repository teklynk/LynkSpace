<?php
define('inc_access', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

echo "<div class='page-team'>";

require_once(__DIR__ . '/includes/featured.inc.php');

require_once(__DIR__ . '/includes/staff.inc.php');

echo "</div>";

require_once(__DIR__ . '/includes/footer.inc.php');
?>