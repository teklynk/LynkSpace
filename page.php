<!-- Pages Section -->
<?php
define('inc_access', TRUE);

include_once('includes/header.php');

echo "<div class='grad-blue container-fluid featured'>";
echo "<div class='container bannerwrapper'>";
include 'includes/featured_inc.php';
echo "</div>";
echo "</div>";

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";
if ($_GET['loc_id'] == 1) {
    include 'includes/searchlocations_inc.php';
} else {
    include 'includes/searchpac_inc.php';
}
echo "</div>";
echo "</div>";

echo "<div class='container'>";
echo "<div class='row row_pad content' id='page'>";

echo "<div class='col-lg-12'>";
echo "<h1 class='page'>" . $pageTitle . "</h1>";
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
    echo "<div class='col-xs-12 col-lg-12'>";
    echo $pageContent;
    echo "</div>";
}

echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container bannerwrapper databases'>";
include 'includes/customersfeatured_inc.php';
echo "</div>";
echo "</div>";

include_once('includes/footer.php');
?>