<?php
define('inc_access', TRUE);

require_once(__DIR__ . '/includes/header.inc.php');

echo "<div class='page-search'>";

echo "<div class='container bannerwrapper' id='sitesearch'>";
echo "<div class='row'>";

require_once(__DIR__ . '/includes/searchsite.inc.php');

if (!empty($_POST['sitesearchterm'])) {

    echo "<div class='sitesearchresultsmsg'><h1>Search results for: \"" . $_POST['sitesearchterm'] . "\"</h1></div>";

    //getSiteSearchResults(search term, show page contents in results)
    getSiteSearchResults($_POST['sitesearchterm'], 'false');

    if ($siteSearchCount == 0){
        echo "<div class='col-lg-12'><h1>No results found.</h1></div>";
        echo "<div class='col-xs-12 col-lg-12'>Try a different search term.</div>";
    }
}

echo "</div>";
echo "</div>";

echo "</div>";

require_once('includes/footer.inc.php');
?>