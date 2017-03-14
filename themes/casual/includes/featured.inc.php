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
        echo "<div class='col-xs-12 col-sm-8'>";

        if (!empty($featuredHeading)) {
            echo "<h2 class='brand-before text-white featured text-center'><small>" . $featuredHeading . "</small></h2>";
        }

        if (!empty($featuredBlurb)) {
            echo "<h1 class='brand-name text-white text-center'>" . $featuredBlurb . "</h1>";
        }

        echo "<hr class='tagline-divider'><br>";

        if (!empty($featuredContent)) {
            echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";
        }

        echo "</div>"; //col-xs-10 col-sm-8

        echo "<div class='col-xs-12 col-sm-4 hidden-xs'>" . $featuredImage . "</div>";

    } else {
        echo "<div class='col-xs-12 col-sm-4 hidden-xs'>" . $featuredImage . "</div>";

        echo "<div class='col-xs-8 col-sm-8'>";

        if (!empty($featuredHeading)) {
            echo "<h2 class='brand-before text-white featured text-center'><small>" . $featuredHeading . "</small></h2>";
        }

        if (!empty($featuredBlurb)) {
            echo "<h1 class='brand-name text-white text-center'>" . $featuredBlurb . "</h1>";
        }

        echo "<hr class='tagline-divider'><br>";

        if (!empty($featuredContent)) {
            echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";
        }

        echo "</div>"; //col-xs-10 col-sm-8
    }

} else {

    echo "<div class='col-xs-12 col-sm-12'>";

    if (!empty($featuredHeading)) {
        echo "<h2 class='brand-before text-white featured text-center'><small>" . $featuredHeading . "</small></h2>";
    }

    if (!empty($featuredBlurb)) {
        echo "<h1 class='brand-name text-white text-center'>" . $featuredBlurb . "</h1>";
    }

    echo "<hr class='tagline-divider'><br>";

    if (!empty($featuredContent)) {
        echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";
    }

    echo "</div>"; //col-xs-12 col-sm-12
}

echo "</div>"; // .row
?>
