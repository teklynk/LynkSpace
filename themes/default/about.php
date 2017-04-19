<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

include 'includes/featured.inc.php';

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && $multiBranch == 'true') {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

include 'includes/about.inc.php';

include 'includes/customersfeatured.inc.php';

include_once('includes/footer.inc.php');
?>