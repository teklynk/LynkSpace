<!-- Featured Section -->
<?php
	getFeatured();
		
	echo "<div class='row' id='featured'>";
	
	if (!empty($featuredBlurb)) {
		echo "<div class='col-lg-12'>";
		echo "<h2 class='page-header featured'>".$featuredBlurb."</h2>";
		echo "</div>";
	}
 
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