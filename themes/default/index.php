<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-index'>";

include 'includes/featured.inc.php';

include 'includes/slider.inc.php';

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";


include 'includes/databasesfeatured.inc.php';

include 'includes/hottitles.inc.php';

include 'includes/staff.inc.php';

include 'includes/services.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>