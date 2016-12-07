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

        echo "<div class='row row_pad'>";

        while ($rowCustomers = mysqli_fetch_array($sqlCustomers)) {

            echo "<div class='col-sm-6 col-md-3 col-lg-3 database-item'>";

            echo "<a href='" . $rowCustomers['link'] . "' title='" . $rowCustomers['name'] . "'>";

            echo "<div class='media'>";

            echo "<span class='media-object pull-left'>";
            echo "<span class='fa-stack fa-2x'>";

            if (!empty($rowCustomers['image'])) {
                echo "<img class='img-responsive customer-img' src='uploads/" . $_GET['loc_id'] . "/" . $rowCustomers['image'] . "' alt='" . $rowCustomers['name'] . "' title='" . $rowCustomers['name'] . "'>";
            } else {
                echo "<img class='img-responsive customer-img' src='http://placehold.it/150x150'>";
            }

            echo "</span>";
            echo "</span>";

            echo "<div class='media-body'>";
            echo "<h3 class='sublinktitle'>" . $rowCustomers['name'] . "</h3>";
            echo "<p>" . $rowCustomers['content'] . "</p>";
            echo "</div>"; //media-body

            echo "</div>"; //media

            echo "</a>";

            echo "</div>"; //col-
        }

        echo "</div>"; //row
		
		echo "</div>"; //#customers
	}
?>