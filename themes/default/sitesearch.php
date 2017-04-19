<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";

    include 'includes/searchsite.inc.php';

echo "</div>";
echo "</div>";

echo "<div class='container'>";
echo "<div class='row row_pad content'>";
echo "<div class='col-md-12'>";

if (!empty($_POST['sitesearchterm'])) {

    getSiteSearchResults($_POST['sitesearchterm'], true);

    if ($siteSearchCount == 0){
        echo "<div class='col-lg-12'><h1 class='page'>No results found.</h1></div>";
        echo "<div class='col-xs-12 col-lg-12'>Try a different search term.</div>";
    }
}

echo "</div>";
echo "</div>";
echo "</div>";

include_once('includes/footer.inc.php');
?>