<?php
if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}

getTeam( loc_id );

if ( $teamNumRows > 0 ) {
    echo "<a name='team' tabindex='-1'></a>";

	echo "<div class='container-fluid team'>";
	echo "<div class='container bannerwrapper'>";

	if ( ! empty( $teamHeading ) ) {
		echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
		echo "<h1 class='text-left teamheading'>" . $teamHeading . "</h1>";
		echo "</div>";
	}

	if ( ! empty( $teamBlurb ) ) {
		echo "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>";
		echo "<p class='text-left teamblurb'>" . $teamBlurb . "</h3>";
		echo "</div>";
	}

	echo "<div class='row' id='team'>";

	while ( $rowTeam = mysqli_fetch_array( $sqlTeam, MYSQLI_ASSOC ) ) {
		echo "<div class='col-sm-6 col-md-3 col-lg-3 team-item'>";
		echo "<div class='thumbnail'>";

		if ( ! empty( $rowTeam['image'] ) ) {
			echo "<img class='img-responsive img-circle' src='" . getAbsoluteImagePath( $rowTeam['image'] ) . "' alt='" . $rowTeam['name'] . "' title='" . $rowTeam['name'] . "'>";
		}

		echo "<div class='caption'>";

		echo "<h3>";

		if ( ! empty( $rowTeam['name'] ) ) {
			echo $rowTeam['name'] . "<br>";
		}

		if ( ! empty( $rowTeam['title'] ) ) {
			echo "<small>" . $rowTeam['title'] . "</small>";
		}

		echo "</h3>";

		if ( ! empty( $rowTeam['content'] ) ) {
			echo "<p>" . $rowTeam['content'] . "</p>";
		}

		echo "</div>";
		echo "</div>";
		echo "</div>";
	}

	echo "</div>";

	echo "</div>";
	echo "</div>";

} else {

    echo "";

}
?>