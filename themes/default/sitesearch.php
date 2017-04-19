<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='container-fluid sitesearch'>";
echo "<div class='container bannerwrapper'>";

if (!empty($_POST['sitesearchterm'])) {

    getSiteSearchResults($_POST['sitesearchterm'], true);

    if ($siteSearchCount == 0){
        echo "<div class='col-lg-12'><h1 class='page'>No results found.</h1></div>";
        echo "<div class='col-xs-12 col-lg-12'>Try a different search term.</div>";
    }
}

echo "</div>";
echo "</div>";

include_once('includes/footer.inc.php');
?>