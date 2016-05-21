<!-- About Section -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

getAbout();

	echo "<div class='row' id='about'>";
	
	if (!empty($aboutTitle)) {
		echo "<div class='col-lg-12'>";
		echo "<h2 class='page-header about'>".$aboutTitle."</h2>";
		echo "</div>";
	}

	if (!empty($aboutImage)) {
		if ($aboutImageAlign=="right") {
			echo "<div class='col-md-10'>";
			echo $aboutContent;
			echo "</div>";
			echo "<div class='col-md-2'>";
			echo $aboutImage;
			echo "</div>";
		} else {
			echo "<div class='col-md-2'>";
			echo $aboutImage;
			echo "</div>";
			echo "<div class='col-md-10'>";
			echo $aboutContent;
			echo "</div>";
		}
	} else {
		echo "<div class='col-md-12'>";
		echo $aboutContent;
		echo "</div>";
	}

	echo "</div>";

?>