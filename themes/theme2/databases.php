<?php
define('inc_access', TRUE);

require_once('includes/header.inc.php');

echo "<div class='page-databases'>";

require_once('includes/featured.inc.php');

if (!empty($_GET['cat_id'])) {
    require_once('includes/databases_catid.inc.php');
} else {
    require_once('includes/databases.inc.php');
}

echo "</div>";

require_once('includes/footer.inc.php');
?>