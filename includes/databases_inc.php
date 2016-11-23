<!-- Our Customers -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
	getDatabases();

    if ($databasesNumRows > 0) {

		echo "<div class='row' id='databases'>";

		if (!empty($databasesHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header customers'>".$databasesHeading."</h2>";
			echo "</div>";
		}

	    if (!empty($databasesBlurb)) {
			echo "<div class='col-lg-12'>";
			echo "<p class='text-center'>".$databasesBlurb."</p>";
			echo "</div>";
		}
    	
    	echo "<div class='text-center'>";

        while ($rowDatabases = mysqli_fetch_array($sqlDatabases)) {
            echo "<div class='col-xs-".$databasesColWidth."'>";

        	if (!empty($rowDatabases['image'])) {
				echo "<a href='".$rowDatabases['link']."'><img class='img-responsive databases-img' src='uploads/".$_GET['loc_id']."/".$rowDatabases['image']."' alt='".$rowDatabases['name']."' title='".$rowDatabases['name']."'></a>";
			} else {
                echo "<a href='".$rowDatabases['link']."'>".$rowDatabases['name']."</a>";
            }

            echo "</div>";
		}

		echo "</div>";
		
		echo "</div>";

	}
?>