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
    echo $hottitlesTile;
    echo "<div class='grad-blue container-fluid hottitles'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='panel with-nav-tabs panel-default'>";

    echo "<div class='panel-heading'>";
    echo "<ul class='nav nav-tabs'>";
    getHottitlesTabs(); //gets the tabs
    echo "</ul>";
    echo "</div>";

    echo "<div class='hotContainer loader panel-body'>";
    echo "<div class='iframe hidden tab-content'>";
    echo "<iframe class='hottitles-iframe' seamless src='includes/hottitles.inc.php?loc_id=".$_GET['loc_id']."&rssurl=".$hottitlesUrl."'></iframe>";
    echo "</div>";
    echo "</div>";

    echo "</div>";

    echo "</div>";
    echo "</div>";
}

include_once('includes/footer.inc.php');
?>