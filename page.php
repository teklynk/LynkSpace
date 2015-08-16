<?php
include 'includes/header.php';

	echo "<div class='container'>"; //closed in footer
	echo "<div class='row'>";

		getPage();

		echo "<div class='col-lg-12'>";
	    echo "<h2 class='page-header'>".$pageTitle."</h2>";
	    echo "</div>";

	    if ($pageImage>"") {
		
			if ($pageImageAlign=="right") {
				echo "<div class='col-md-10'>";
				echo $pageContent;
				echo "</div>";
				echo "<div class='col-md-2'>";
				echo $pageImage;
				echo "</div>";
			} else {
				echo "<div class='col-md-2'>";
				echo $pageImage;
				echo "</div>";
				echo "<div class='col-md-10'>";
				echo $pageContent;
				echo "</div>";
			}
			
		} else {
			echo "<div class='col-lg-12'>";
		    echo $pageContent;
		    echo "</div>";
		}

	echo "</div>";
	//contianer is closed in footer

include 'includes/footer.php';
?>