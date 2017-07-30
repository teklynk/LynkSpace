<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-services'>";

include 'includes/featured.inc.php';

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

include 'includes/services.inc.php';

include 'includes/databasesfeatured.inc.php';

echo "</div>";

include_once('includes/footer.inc.php');
?>