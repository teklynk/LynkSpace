<!-- Our Customers -->
<?php
    $sqlCustomerHeading = mysql_query("SELECT customersheading, customerscontent FROM setup");
    $rowCustomerHeading = mysql_fetch_array($sqlCustomerHeading);

    $sqlCustomers = mysql_query("SELECT id, image, name, link, active FROM customers WHERE active=1 ORDER BY datetime DESC"); //While loop
    $num_rows = mysql_num_rows($sqlCustomers);
    $customersCount=0;

    if ($num_rows > 0) {
		echo "<div class='row'>";

		echo "<div class='col-lg-12'>";
		echo "<h2 class='page-header customers' id='customers'>".$rowCustomerHeading['customersheading']."</h2>";
		echo "</div>";

		if (!empty($rowCustomerHeading['customerscontent'])) {
	        echo "<div class='col-lg-12'>";
	        echo "<p class='text-center'>".$rowCustomerHeading['customerscontent']."</p>";
	        echo "</div>";
    	}
    	echo "<div align='center' class='text-center'>";
        while ($rowCustomers = mysql_fetch_array($sqlCustomers)) {
        	$customersCount++;
        	if (!empty($rowCustomers['image'])){
				echo "<div class='col-md-2 col-sm-4 col-xs-6 text-center'>";
				echo "<a href='".$rowCustomers['link']."'><img class='img-responsive customer-img' src='uploads/".$rowCustomers['image']."' title='".$rowCustomers['title']."'></a>";
				echo "</div>";
			}
		}
		echo "</div>";

		echo "</div>";
	}
?>