<?php
include 'includes/header.php';

if ($_GET["ref"]>""){
	$pageRefId=$_GET["ref"];
	$sqlPage = mysql_query("SELECT id, title, image, image_align, content, active FROM pages WHERE id='$pageRefId'");
	$rowPage = mysql_fetch_array($sqlPage);

	echo "<div class='container'>"; //closed in footer
	echo "<div class='row'>";
	//echo "<div class='col-lg-12'>";

	if ($rowPage['active']=1 AND $_GET["ref"]>"" AND $pageRefId=$rowPage['id']) {

		echo "<div class='col-lg-12'>";
	    echo "<h2 class='page-header'>".$rowPage['title']."</h2>";
	    echo "</div>";

	    if ($rowPage['image']>"") {	
			if ($rowPage["image_align"]=="right") {
				echo "<div class='col-md-10'>";
				echo $rowPage["content"];
				echo "</div>";
				echo "<div class='col-md-2'>";
				echo "<img class='img-responsive' src='uploads/".$rowPage["image"]."' alt='".$rowPage["title"]."' title='".$rowPage["title"]."'>";
				echo "</div>";
			} else {
				echo "<div class='col-md-2'>";
				echo "<img class='img-responsive' src='uploads/".$rowPage["image"]."' alt='".$rowPage["title"]."' title='".$rowPage["title"]."'>";
				echo "</div>";
				echo "<div class='col-md-10'>";
				echo $rowPage["content"];
				echo "</div>";
			}
		} else {
			echo "<div class='col-lg-12'>";
		    echo $rowPage['content'];
		    echo "</div>";
		}
	} else {

	    echo "<div class='col-lg-12'>";
	    echo "<h2 class='page-header'>Page not found</h2>";
	    echo "</div>";

	    echo "<div class='col-lg-12'>";
	    echo "<p>This page has been removed.</p>";
	    echo "</div>";

	}

	//echo "</div>";
	echo "</div>";
	//contianer is closed in footer
}

include 'includes/footer.php';
?>