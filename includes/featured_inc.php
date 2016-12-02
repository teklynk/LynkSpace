<!-- Featured Section -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
	getFeatured();
		
	echo "<div class='row' id='featured'>";

 
	if (!empty($featuredImage)) {

		if ($featuredImageAlign == "right") {
			echo "<div class='col-xs-8 col-sm-6'>";

			if (!empty($featuredHeading)) {
				echo "<h1 class='text-white featured'>".$featuredHeading."</h1>";
			}

			if (!empty($featuredBlurb)) {
				echo "<h3>".$featuredBlurb."</h3><br/><br/>";
			}

			echo "<div>".$featuredContent."</div>";

			echo "</div>"; //col-xs-10 col-sm-8

			echo "<div class='col-xs-4 col-sm-4'>".$featuredImage."</div>";

		} else {
			echo "<div class='col-xs-4 col-sm-4'>".$featuredImage."</div>";

			echo "<div class='col-xs-8 col-sm-6'>";

			if (!empty($featuredHeading)) {
				echo "<h1 class='text-white featured'>".$featuredHeading."</h1>";
			}

			if (!empty($featuredBlurb)) {
				echo "<h3>".$featuredBlurb."</h3><br/><br/>";
			}

			echo "<div>".$featuredContent."</div>";

			echo "</div>"; //col-xs-10 col-sm-8
		}

	} else {

		echo "<div class='col-xs-12 col-sm-12'>";

		if (!empty($featuredHeading)) {
			echo "<h1 class='text-white featured'>".$featuredHeading."</h1>";
		}

		if (!empty($featuredBlurb)) {
			echo "<h3>".$featuredBlurb."</h3><br/><br/>";
		}

		echo "<div>".$featuredContent."</div>";
	}
	
	echo "</div>"; // .row
?>
