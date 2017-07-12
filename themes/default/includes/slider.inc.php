<!-- Slider Carousel -->
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
echo "<div class='grad-blue container-fluid slider'>";

echo "<header id='sliderCarousel' class='carousel slide' data-ride='carousel' data-interval='".carouselSpeed."'>";
getSlider("slide");
echo "</header>";

echo "</div>";

if ($sliderCount == 0) {
    echo "<style>.slider {display:none !important;}</style>";
}
?>