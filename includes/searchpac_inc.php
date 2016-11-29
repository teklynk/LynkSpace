<!-- Featured Section -->
<?php
if (!defined('inc_access')) {
   die('Direct access not permitted');
}
	getSetup(); //gets search pac options for the loc_id
	//getLocation(); //gets location name if needed
		
	echo "<div class='row' id='searchpac'>";

		echo "<div class='col-lg-12'>";
		echo "Search box goes here";
		echo "</div>";

	echo "</div>";
?>
<!-- /.row -->