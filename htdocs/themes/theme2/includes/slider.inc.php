<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}
?>
    <!-- Slider Carousel -->
<?php

echo "<div class='container-fluid slider'>";
echo "<div class='container bannerwrapper'>";
echo "<header id='sliderCarousel' class='carousel slide' data-ride='carousel' data-interval='" . carouselSpeed . "'>";
getSlider( loc_id, "slide" );
echo "</header>";
echo "</div>";
echo "</div>";

if ( $sliderCount == 0 ) {
	echo "<style>.slider {display:none !important;}</style>";
}
?>