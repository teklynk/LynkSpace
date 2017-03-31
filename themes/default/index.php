<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='grad-blue container-fluid featured'>";
echo "<div class='container bannerwrapper'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='grad-blue container-fluid slider'>";
echo "<div class='container'>";
echo "<header id='sliderCarousel' class='carousel slide' data-ride='carousel' data-interval='$carouselSpeed'>";
    include 'includes/slider.inc.php';
echo "</header>";
echo "</div>";
echo "</div>";

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

//Hot Titles Carousel
if ($_GET['loc_id']) {

    echo "<div class='grad-blue container-fluid hottitles'>";
    echo "<div class='container bannerwrapper'>";
    echo "<div class='col-xs-12 col-lg-12 hottitles-title'>";
    echo "<h1 class='text-white'>New Titles</h1>";
    echo "</div>";
    echo "<div style='clear:both;'></div>";
    echo "<div class='well'>";

    //Carousel Tabs
    echo "<div id='hottitlesTabs'>";
    echo "<div class='panel text-center'>";
    echo "<ul class='nav nav-pills center-tabs'>";
        getHottitlesTabs(); //gets the hot title tabs
    echo "</ul>";
    echo "</div>"; //.panel
    echo "</div>"; //.container


    //Main Carousel
    echo "<div class='carousel slide' data-ride='carousel' data-interval='$carouselSpeed' id='hottitlesCarousel'>";

    echo "<div class='carousel-inner'></div>";

    echo "<a class='left carousel-control' href='#hottitlesCarousel' data-slide='prev'><i class='icon-prev'></i></a>";
    echo "<a class='right carousel-control' href='#hottitlesCarousel' data-slide='next'><i class='icon-next'></i></a>";

    echo "</div>"; //.carousel

    echo "</div>"; //.well
    echo "</div>"; //.container
    echo "</div>"; //.grad-blue
}

include_once('includes/footer.inc.php');
?>