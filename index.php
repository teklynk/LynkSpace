<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='grad-blue container-fluid featured'>";
echo "<div class='container bannerwrapper'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

include 'includes/slider.inc.php';

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && $multiBranch == "true") {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}
echo "</div>";
echo "</div>";

if ($_GET['loc_id']) {
    echo "<div class='container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/customersfeatured.inc.php';
    echo "</div>";
    echo "</div>";
}
if ($_GET['loc_id']) {
    echo "<div class='grad-gray container-fluid hottitles'>";
    echo "<div class='container bannerwrapper'>";
    include 'includes/hottitles.inc.php';
    echo "</div>";
    echo "</div>";
}

include_once('includes/footer.inc.php');
?>