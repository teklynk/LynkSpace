<!-- Featured Section -->
<a name="featured" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getFeatured($_GET['loc_id']);
echo "<div class='container-fluid featured'>";
echo "<div class='container bannerwrapper'>";

echo "<div class='row' id='featured'>";

echo "<div class='col-xs-12 col-sm-12 featured-heading'>";

if (!empty($featuredHeading)) {
    echo "<h1>" . $featuredHeading . "</h1>";
}

if (!empty($featuredBlurb)) {
    echo "<h3>" . $featuredBlurb . "</h3>";
}

if (!empty($featuredContent)) {
    echo "<div class='featured-content'>" . $featuredContent . "</div>";
}

echo "</div>"; //col-xs-12 col-sm-12

echo "</div>"; // .row

echo "</div>";
echo "</div>";
?>
