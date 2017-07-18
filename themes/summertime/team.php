<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-team'>";

include 'includes/featured.inc.php';

include 'includes/team.inc.php';

include 'includes/databasesfeatured.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>