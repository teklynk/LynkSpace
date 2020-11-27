<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}

echo "<div class='grad-blue themebase-bgcolor container-fluid slider'>";

echo "<header id='sliderCarousel' class='carousel slide' data-ride='carousel' data-interval='" . carouselSpeed . "'>";

getSlider( loc_id, "slide", null);

echo "</header>";

echo "</div>";

if ( $sliderCount == 0 ) {
	echo "<style>.slider {display:none !important;}</style>";
}

?>