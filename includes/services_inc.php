<!-- Service Panels -->
<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}

getServices();

    if ($servicesNumRows > 0) {

        echo "<div class='row' id='services'>";
		
		if (!empty($servicesHeading)) {
			echo "<div class='col-lg-12'>";
			echo "<h1 class='services'>".$servicesHeading."</h1>";
			echo "</div>";
		}
        
        if (!empty($servicesBlurb)) {
            echo "<div class='col-lg-12'>";
            echo "<h3>".$servicesBlurb."</h3>";
            echo "</div>";
        }

        while ($rowServices = mysqli_fetch_array($sqlServices)) {

            echo "<div class='col-md-".$servicesColWidth." text-center'>";
            echo "<div class='panel panel-default text-center'>";

            if (!empty($rowServices['icon']) || !empty($rowServices['image'])) {
                echo "<div class='panel-heading'>";
                echo "<span class='fa-stack fa-5x'>";
            } else {
                echo "<div>";
                echo "<span>";
            }

            if (!empty($rowServices['icon'])) {
                echo "<i class='fa fa-circle fa-stack-2x text-primary'></i>";
                echo "<i class='fa fa-".$rowServices['icon']." fa-stack-1x fa-inverse' title='".$rowServices['title']."'></i>";
            }

            if (!empty($rowServices['image'])) {
                echo "<img class='img-responsive img-circle' style='padding:8px;' src='uploads/".$_GET['loc_id']."/".$rowServices['image']."' alt='".$rowServices['title']."' title='".$rowServices['title']."'>";
            }

            echo "</span>";
            echo "</div>";

            echo "<div class='panel-body'>";

            if (!empty($rowServices['title'])) {
                echo "<h1>".$rowServices['title']."</h1>";
            }
            
            if (!empty($rowServices['content'])) {
                echo "<p>".$rowServices['content']."</p>";
            }

            if (!empty($rowServices['link'])) {
                echo "<a href='page.php?page_id=".$rowServices['link']."&loc_id=".$_GET['loc_id']."' class='btn btn-primary'>Learn More</a>";
            }

            echo "</div>";

            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
    }
?>