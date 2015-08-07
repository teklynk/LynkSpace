<!-- Featured Section -->
<?php
$sqlFeatured = mysql_query("SELECT heading, introtext, content, image, image_align FROM featured");
$rowFeatured = mysql_fetch_array($sqlFeatured);

if ($rowFeatured === FALSE){ 
    die(mysql_error()); // TODO: better error handling
}

if (!empty($rowFeatured["content"])) {		
	echo "<div class='row'>";

	if (!empty($rowFeatured["heading"])){
		echo "<div class='col-lg-12' id='featured'>";
		echo "<h2 class='page-header featured'>".$rowFeatured["introtext"]."</h2>";
		echo "</div>";
	}
 
	if ($rowFeatured["image"] != "") {
		if ($rowFeatured["image_align"] =="right") {
			echo "<div class='col-md-10'>";
			echo $rowFeatured["content"];
			echo "</div>";
			echo "<div class='col-md-2'>";
			echo "<img class='img-responsive' src='uploads/".$rowFeatured["image"]."' alt='".$rowFeatured["title"]."' title='".$rowFeatured["title"]."'>";
			echo "</div>";
		} else {
			echo "<div class='col-md-2'>";
			echo "<img class='img-responsive' src='uploads/".$rowFeatured["image"]."' alt='".$rowFeatured["title"]."' title='".$rowFeatured["title"]."'>";
			echo "</div>";
			echo "<div class='col-md-10'>";
			echo $rowFeatured["content"];
			echo "</div>";
		}
	} else {
		echo "<div class='col-md-12'>";
		echo $rowFeatured["content"];
		echo "</div>";
	}
	
	echo "</div>";
}
?>


<!-- /.row -->