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

            if (!empty($rowCustomers['icon'])) {
                echo "<i class='fa fa-circle fa-stack-2x'></i>";
                echo "<i class='fa fa-".$rowCustomers['icon']." fa-stack-1x fa-inverse' title='".$rowCustomers['name']."'></i>";
            }

            if (!empty($rowCustomers['image'])) {
                echo "<img class='img-responsive img-circle' style='padding:8px;' src='uploads/".$_GET['loc_id']."/".$rowCustomers['image']."' alt='".$rowCustomers['name']."' title='".$rowServices['name']."'>";
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