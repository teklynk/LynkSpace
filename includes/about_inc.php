<!-- About Section -->
<?php
$sqlAbout = mysql_query("SELECT heading, content, image, image_align FROM aboutus");
$rowAbout = mysql_fetch_array($sqlAbout);

if ($rowAbout === FALSE){ 
    die(mysql_error()); // TODO: better error handling
}

if (!empty($rowAbout["content"])) {
	echo "<div class='row'>";
	
	if (!empty($rowAbout["heading"])){
		echo "<div class='col-lg-12'>";
		echo "<h2 class='page-header about' id='about'>".$rowAbout["heading"]."</h2>";
		echo "</div>";
	}

	if ($rowAbout["image"] != "") {
		if ($rowAbout["image_align"] =="right") {
			echo "<div class='col-md-10'>";
			echo $rowAbout["content"];
			echo "</div>";
			echo "<div class='col-md-2'>";
			echo "<img class='img-responsive' src='uploads/".$rowAbout["image"]."' alt='".$rowAbout["title"]."' title='".$rowAbout["title"]."'>";
			echo "</div>";
		} else {
			echo "<div class='col-md-2'>";
			echo "<img class='img-responsive' src='uploads/".$rowAbout["image"]."' alt='".$rowAbout["title"]."' title='".$rowAbout["title"]."'>";
			echo "</div>";
			echo "<div class='col-md-10'>";
			echo $rowAbout["content"];
			echo "</div>";
		}
	} else {
		echo "<div class='col-md-12'>";
		echo $rowAbout["content"];
		echo "</div>";
	}

	echo "</div>";
}
?>