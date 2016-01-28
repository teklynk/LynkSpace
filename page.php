<?php
define('MyConst', TRUE);

include 'includes/header.php';

	echo "<div class='container'>"; //closed in footer
	echo "<div class='row row_pad' id='page'>";

		//getPage(); //already being called in functions.php

		echo "<div class='col-lg-12'>";
	    echo "<h2 class='page-header page'>".$pageTitle."</h2>";
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
		
		include 'includes/disqus_inc.php';

	echo "</div>";
	//container is closed in footer

include 'includes/footer.php';
?>