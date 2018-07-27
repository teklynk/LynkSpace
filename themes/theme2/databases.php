<?php
define('ALLOW_INC', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

echo "<div class='page-databases'>";

require_once(__DIR__ . '/includes/featured.inc.php');

if (!empty($_GET['cat_id'])) {
    require_once(__DIR__ . '/includes/databases_catid.inc.php');
} else {
    require_once(__DIR__ . '/includes/databases.inc.php');
}

echo "</div>";

require_once(__DIR__ . '/includes/footer.inc.php');
?>