<!-- Featured Section -->
<a name="featured" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getFeatured($_GET['loc_id']);
getEvents($_GET['loc_id']);

echo "<div class='grad-blue themebase-bgcolor container-fluid featured'>";
echo "<div class='container bannerwrapper'>";

echo "<div class='row' id='featured'>";

echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";

if (!empty($featuredContent) && !empty($eventCalendar)) {

    echo "<div class='text-white featuredcontent' style='float:left; width:70%;'>";

    if (!empty($featuredHeading)) {
        echo "<h1 class='text-white featuredheading'>" . $featuredHeading . "</h1>";
    }

    if (!empty($featuredBlurb)) {
        echo "<h3 class='text-white'>" . $featuredBlurb . "</h3>";
    }

    if (!empty($featuredContent)) {
        echo $featuredContent;
    }

    echo "</div>";

    echo "<div class='text-white events' style='float:right; width:30%;'>";

    if (!empty($eventCalendar)) {

        if (!empty($eventHeading)) {
            echo "<h3>" . $eventHeading . "</h3>";
        }

        echo "<div class='eventsbox'>" . $eventCalendar . "</div>";
    }

    echo "</div>";

} elseif (empty($featuredContent) && !empty($eventCalendar)) {

    echo "<div class='text-white events'>";

    if (!empty($eventCalendar)) {

        if (!empty($eventHeading)) {
            echo "<h3>" . $eventHeading . "</h3>";
        }

        echo "<div class='eventsbox'>" . $eventCalendar . "</div>";
    }

    echo "</div>";

} else {

    echo "<div class='text-white featuredcontent'>" . $featuredContent . "</div>";

}

echo "</div>"; //col-xs-12 col-sm-12

echo "</div>"; // .row

echo "</div>";
echo "</div>";
echo "<div style='clear:both;'></div>";
?>
