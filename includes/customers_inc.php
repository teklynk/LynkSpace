<!-- Databases -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
	getCustomers();

    if ($customerNumRows > 0) {

		echo "<div class='row' id='customers'>";

		if (!empty($customerHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h1 class='customers'>".$customerHeading."</h1>";
			echo "</div>";
		}

	    if (!empty($customerBlurb)) {
			echo "<div class='col-lg-12'>";
			echo "<p class='text-center'>".$customerBlurb."</p>";
			echo "</div>";
		}
    	
    	echo "<div class='text-center'>";

        while ($rowCustomers = mysqli_fetch_array($sqlCustomers)) {
            echo "<div class='col-xs-".$customerColWidth."'>";

        	if (!empty($rowCustomers['image'])) {
				echo "<a href='".$rowCustomers['link']."'><img class='img-responsive customer-img' src='uploads/".$_GET['loc_id']."/".$rowCustomers['image']."' alt='".$rowCustomers['name']."' title='".$rowCustomers['name']."'></a>";
			} else {
                echo "<a href='".$rowCustomers['link']."'>".$rowCustomers['name']."</a>";
            }

            echo "</div>";
		}

		echo "</div>";
		
		echo "</div>";

	}
?>