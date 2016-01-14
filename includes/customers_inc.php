<!-- Our Customers -->
<?php
	getCustomers();

    if ($customerNumRows > 0) {

		echo "<div class='row' id='customers'>";

		if (!empty($customerHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h2 class='page-header customers'>".$customerHeading."</h2>";
			echo "</div>";
		}

        echo "<div class='col-lg-12'>";
        echo "<p class='text-center'>".$customerBlurb."</p>";
        echo "</div>";
    	
    	echo "<div class='text-center'>";

        while ($rowCustomers = mysql_fetch_array($sqlCustomers)) {
        	if (!empty($rowCustomers['image'])){
				echo "<div class='col-xs-".$customerColWidth."'>";
				echo "<a href='".$rowCustomers['link']."'><img class='img-responsive customer-img' src='uploads/".$rowCustomers['image']."' alt='".$rowCustomers['name']."' title='".$rowCustomers['name']."'></a>";
				echo "</div>";
			}
		}

		echo "</div>";
		
		echo "</div>";

	}
?>