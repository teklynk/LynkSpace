<!-- General Info Section -->
<?php
	getGeneralInfo();
	
	echo "<div class='row'>";
	
	echo "<div class='col-lg-12'>";
	echo "<h2 class='page-header generalinfo' id='generalinfo'>".$generalInfoHeading."</h2>";
	echo "</div>";
	
	echo "<div class='col-md-12'>";
	echo $generalInfoContent;
	echo "</div>";

	echo "</div>";
?>