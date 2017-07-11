<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-services'>";

include 'includes/featured.inc.php';

include 'includes/services.inc.php';

include 'includes/customersfeatured.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>