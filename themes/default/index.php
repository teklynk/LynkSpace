<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='grad-blue container-fluid featured'>";
echo "<div class='container bannerwrapper'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<header id='myCarousel' class='carousel slide' data-interval='0'>";
include 'includes/slider.inc.php';
echo "</header>";

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1 && $multiBranch == "true") {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

if ($_GET['loc_id']) {
    echo "<div class='container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/customersfeatured.inc.php';
    echo "</div>";
    echo "</div>";
}

if ($_GET['loc_id']) {

    echo "<div class='grad-blue container-fluid hottitles'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='container'>";
    echo "<div class='row'>";

    echo "<div class='panel with-nav-tabs panel-default'>";

    echo "<div class='panel-heading'>";

    echo "<ul class='nav nav-tabs'>";
        getHottitlesTabs(); //gets the tabs
    echo "</ul>";

    echo "</div>";

    echo "</div>";

    echo "</div>";
    echo "</div>";

    echo "<div class='container'>";
    echo "<div class='row'>";
    echo "<div class='span12'>";
    echo "<div class='well'>";

    echo "<div id='hottitlesCarousel' class='carousel fdi-Carousel slide'>";
    echo "<div class='carousel fdi-Carousel slide' data-ride='carousel' data-type='multi' data-interval='$carouselSpeed' id='eventCarousel'>";

    echo "<div class='carousel-inner onebyone-carousel'></div>";

    echo "<a class='left carousel-control' href='#eventCarousel' data-slide='prev'><i class='glyphicon glyphicon-chevron-left icon-prev'></i></a>";
    echo "<a class='right carousel-control' href='#eventCarousel' data-slide='next'><i class='glyphicon glyphicon-chevron-right icon-next'></i></a>";

    echo "</div>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "</div>";
    echo "</div>";

}

include_once('includes/footer.inc.php');
?>