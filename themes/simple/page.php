<!-- Pages Section -->
<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='container-fluid featured'>";
echo "<div class='container'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='container-fluid search'>";
echo "<div class='container'>";

if ($_GET['loc_id'] == 1) {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

echo "<div class='container'>";
echo "<div class='row content' id='page'>";

echo "<div class='col-lg-12'>";
echo "<h2 class='page-header page'>" . $pageTitle . "</h2>";
echo "</div>";

if ($pageImage > "") {

    if ($pageImageAlign == "right") {
        echo "<div class='col-xs-12 col-md-10'>";
        echo $pageContent;
        echo "</div>";
        echo "<div class='hidden-xs col-md-2'>";
        echo $pageImage;
        echo "</div>";
    } else {
        echo "<div class='hidden-xs col-md-2'>";
        echo $pageImage;
        echo "</div>";
        echo "<div class='col-xs-12 col-md-10'>";
        echo $pageContent;
        echo "</div>";
    }

} else {
    echo "<div class='col-lg-12'>";
    echo $pageContent;
    echo "</div>";
}

echo "</div>";
echo "</div>";

include_once('includes/footer.inc.php');
?>