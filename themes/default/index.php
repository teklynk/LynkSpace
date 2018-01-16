<?php
define('inc_access', TRUE);

require_once('includes/header.inc.php');

echo "<div class='page-index'>";

require_once('includes/featured.inc.php');

require_once('includes/slider.inc.php');

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
    require_once('includes/searchlocations.inc.php');
} else {
    require_once('includes/searchpac.inc.php');
}

echo "</div>";
echo "</div>";


require_once('includes/databasesfeatured.inc.php');

require_once('includes/hottitles.inc.php');

require_once('includes/staff.inc.php');

require_once('includes/services.inc.php');

echo "</div>";

require_once('includes/footer.inc.php');
?>