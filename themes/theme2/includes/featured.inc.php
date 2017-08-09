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

if (!empty($eventCalendar)) {

    echo "<div class='featuredcontent' style='float:left; width:70%;'>";

    if (!empty($featuredHeading)) {
        echo "<h1 class='featuredheading'>" . $featuredHeading . "</h1>";
    }

    if (!empty($featuredBlurb)) {
        echo "<h3>" . $featuredBlurb . "</h3>";
    }

    if (!empty($featuredContent)) {
        echo $featuredContent;
    }

    echo "</div>";

    echo "<div class='events' style='float:right; width:30%;'>";

    if (!empty($eventCalendar)) {

        if (!empty($eventHeading)) {
            echo "<h3>" . $eventHeading . "</h3>";
        }

        echo "<div class='eventsbox'>" . $eventCalendar . "</div>";
    }

    echo "</div>";

} elseif (empty($featuredContent) && !empty($eventCalendar)) {

    echo "<div class='events'>";

    if (!empty($eventCalendar)) {

        if (!empty($eventHeading)) {
            echo "<h3>" . $eventHeading . "</h3>";
        }

        echo "<div class='eventsbox'>" . $eventCalendar . "</div>";
    }

    echo "</div>";

} else {

    echo "<h1 class='featuredheading'>" . $featuredHeading . "</h1>";
    echo "<div class='featuredcontent'>" . $featuredContent . "</div>";

}

echo "</div>"; //col-xs-12 col-sm-12

echo "</div>"; // .row

echo "</div>";
echo "</div>";

echo "<div style='clear:both;'></div>";
?>
