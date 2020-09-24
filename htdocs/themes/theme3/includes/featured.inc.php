<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}
?>
<!-- Featured Section -->
<a name="featured" tabindex="-1"></a>
<?php

getFeatured( loc_id );
getEvents( loc_id );

echo "<div class='grad-blue themebase-bgcolor container-fluid featured'>";
echo "<div class='container bannerwrapper'>";

echo "<div class='row' id='featured'>";

echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";

if ( ! empty( $featuredHeading ) && ! empty( $eventCalendar ) ) {

	echo "<div class='col-lg-8 text-white featuredcontent'>";

	if ( ! empty( $featuredHeading ) ) {
		echo "<h1 class='text-white featuredheading'>" . $featuredHeading . "</h1>";
	}

	if ( ! empty( $featuredBlurb ) ) {
		echo "<h3 class='text-white'>" . $featuredBlurb . "</h3>";
	}

	if ( ! empty( $featuredContent ) ) {
		echo $featuredContent;
	}

	echo "</div>";

	echo "<div class='col-lg-4 text-white events'>";

	if ( ! empty( $eventCalendar ) ) {

		if ( ! empty( $eventHeading ) ) {
			echo "<h3>" . $eventHeading . "</h3>";
		}

		echo "<div class='eventsbox'>" . $eventCalendar . "</div>";
	}

	echo "</div>";

} elseif ( empty( $featuredHeading ) && ! empty( $eventCalendar ) ) {

	echo "<div class='col-lg-12 text-white events'>";

	if ( ! empty( $eventCalendar ) ) {

		if ( ! empty( $eventHeading ) ) {
			echo "<h3>" . $eventHeading . "</h3>";
		}

		echo "<div class='eventsbox'>" . $eventCalendar . "</div>";
	}

	echo "</div>";

} else {

	echo "<h1 class='text-white featuredheading'>" . $featuredHeading . "</h1>";
	echo "<div class='col-lg-12 text-white featuredcontent'>" . $featuredContent . "</div>";

}

echo "</div>"; //col-xs-12 col-sm-12

echo "</div>"; // .row

echo "</div>";
echo "</div>";

echo "<div style='clear:both;'></div>";
?>
