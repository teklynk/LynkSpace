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
            echo "<h1 class='text-white featured'>" . $featuredHeading . "</h1>";
        }

        if (!empty($featuredBlurb)) {
            echo "<h3 class='text-white'>" . $featuredBlurb . "</h3>";
        }

        if (!empty($featuredContent)) {
            echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";
        }

        echo "</div>"; //col-xs-10 col-sm-8

        echo "<div class='col-xs-12 col-sm-4 hidden-xs'>" . $featuredImage . "</div>";

    } else {
        echo "<div class='col-xs-12 col-sm-4 hidden-xs'>" . $featuredImage . "</div>";

        echo "<div class='col-xs-8 col-sm-8'>";

        if (!empty($featuredHeading)) {
            echo "<h1 class='text-white featured'>" . $featuredHeading . "</h1>";
        }

        if (!empty($featuredBlurb)) {
            echo "<h3 class='text-white'>" . $featuredBlurb . "</h3>";
        }

        if (!empty($featuredContent)) {
            echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";
        }

        echo "</div>"; //col-xs-10 col-sm-8
    }

} else {

    echo "<div class='col-xs-12 col-sm-12'>";

    if (!empty($featuredHeading)) {
        echo "<h1 class='text-white featured'>" . $featuredHeading . "</h1>";
    }

    if (!empty($featuredBlurb)) {
        echo "<h3 class='text-white'>" . $featuredBlurb . "</h3>";
    }

    if (!empty($featuredContent)) {
        echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";
    }

    echo "</div>"; //col-xs-12 col-sm-12
}

echo "</div>"; // .row
?>
