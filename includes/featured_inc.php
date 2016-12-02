<!-- Featured Section -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
	getFeatured();
		
	echo "<div class='row' id='featured'>";
	echo "<div class='col-xs-12 col-sm-8'>";

	if (!empty($featuredHeading)) {
		echo "<h1 class='text-white featured'>".$featuredHeading."</h1>";
		//echo "</div>";
	}

	if (!empty($featuredBlurb)) {
		//echo "<div class='col-lg-12'>";
		echo "<p class='text-center'>".$featuredBlurb."</p>";
	}

	echo "</div>";
 
	if (!empty($featuredImage)) {

		if ($featuredImageAlign == "right") {
			echo "<div class='col-md-10'>";
			echo $featuredContent;
			echo "</div>";
			echo "<div class='col-md-2'>";
			echo $featuredImage;
			echo "</div>";
		} else {
			echo "<div class='col-md-2'>";
			echo $featuredImage;
			echo "</div>";
			echo "<div class='col-md-10'>";
			echo $featuredContent;
			echo "</div>";
		}

	} else {
		echo "<div class='col-md-12'>";
		echo $featuredContent;
		echo "</div>";
	}
	
	echo "</div>";
?>
<!-- /.row -->