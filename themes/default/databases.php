<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-databases'>";

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

if (!empty($_GET['cat_id'])) {
    include 'includes/databases_catid.inc.php';
} else {
    include 'includes/databases.inc.php';
}

echo "</div>";

include_once('includes/footer.inc.php');
?>