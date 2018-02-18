<!-- Slider Carousel -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
echo "<div class='grad-blue themebase-bgcolor container-fluid slider'>";

echo "<header id='sliderCarousel' class='carousel slide' data-ride='carousel' data-interval='" . carouselSpeed . "'>";

getSlider($_GET['loc_id'], "slide");

echo "</header>";

echo "</div>";

if ($sliderCount == 0) {
    echo "<style>.slider {display:none !important;}</style>";
}
?>