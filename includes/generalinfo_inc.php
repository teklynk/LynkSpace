<!-- General Info Section -->
<?php
	getGeneralInfo();

	if ($generalInfoContent > "") {
		echo "<div class='row' id='generalinfo'>";
		
		echo "<div class='col-lg-12'>";
		echo "<h2 class='page-header generalinfo'>".$generalInfoHeading."</h2>";
		echo "</div>";
		
		echo "<div class='col-md-12'>";
		echo $generalInfoContent;
		echo "</div>";

		echo "</div>";
	}
?>