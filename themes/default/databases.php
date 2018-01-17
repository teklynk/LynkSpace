<?php
define('inc_access', TRUE);

require_once('includes/header.inc.php');

echo "<div class='page-databases'>";

require_once('includes/featured.inc.php');

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
    require_once('includes/searchlocations.inc.php');
} else {
    require_once('includes/searchpac.inc.php');
}

echo "</div>";
echo "</div>";

if (!empty($_GET['cat_id'])) {
    require_once('includes/databases_catid.inc.php');
} else {
    require_once('includes/databases.inc.php');
}

echo "</div>";


require_once('includes/footer.inc.php');
?>