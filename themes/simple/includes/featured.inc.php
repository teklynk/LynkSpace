<!-- Featured Section -->
<a name="featured" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getFeatured();

echo "<div class='row' id='featured'>";

if (!empty($featuredImage)) {

    if ($featuredImageAlign == "right") {
        echo "<div class='col-lg-12'>";

        if (!empty($featuredHeading)) {
            echo "<h2 class='page-header featured'>" . $featuredHeading . "</h2>";
        }

        if (!empty($featuredBlurb)) {
            echo "<div class='col-lg-12'>";
            echo "<p class='text-center'>" . $featuredBlurb . "</p>";
            echo "</div>";
        }

        if (!empty($featuredContent)) {
            echo "<div class='col-md-10'>" . $featuredContent . "</div>";
        }

        echo "</div>"; //col-xs-10 col-sm-8

        echo "<div class='col-md-2 hidden-xs'>" . $featuredImage . "</div>";

    } else {
        echo "<div class='col-md-2 hidden-xs'>" . $featuredImage . "</div>";

        echo "<div class='col-lg-12'>";

        if (!empty($featuredHeading)) {
            echo "<h2 class='page-header featured'>" . $featuredHeading . "</h2>";
        }

        if (!empty($featuredBlurb)) {
            echo "<div class='col-lg-12'>";
            echo "<p class='text-center'>" . $featuredBlurb . "</p>";
            echo "</div>";
        }

        if (!empty($featuredContent)) {
            echo "<div class='col-md-10'>" . $featuredContent . "</div>";
        }

        echo "</div>"; //col-xs-10 col-sm-8
    }

} else {

    echo "<div class='col-lg-12'>";

    if (!empty($featuredHeading)) {
        echo "<h2 class='page-header featured'>" . $featuredHeading . "</h2>";
    }

    if (!empty($featuredBlurb)) {
        echo "<div class='col-lg-12'>";
        echo "<p class='text-center'>" . $featuredBlurb . "</p>";
        echo "</div>";
    }

    if (!empty($featuredContent)) {
        echo "<div class='col-md-10'>" . $featuredContent . "</div>";
    }

    echo "</div>"; //col-xs-12 col-sm-12
}

echo "</div>"; // .row
?>
