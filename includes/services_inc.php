<!-- Service Panels -->
<?php
    $sqlServicesHeading = mysql_query("SELECT servicesheading, servicescontent FROM setup");
    $rowServicesHeading = mysql_fetch_array($sqlServicesHeading);

    $sqlServices = mysql_query("SELECT id, icon, image, title, link, content, active FROM services WHERE active=1 ORDER BY datetime DESC"); //While loop
    $num_rows = mysql_num_rows($sqlServices);
    $servicesCount=0;

    if ($num_rows==2) {
        $colWidth=6;
    } elseif ($num_rows==3) {
        $colWidth=4;
    } elseif ($num_rows==4) {
        $colWidth=3;
    }

    if ($num_rows > 0) {
        echo "<div class='row'>";
        echo "<div class='col-lg-12'>";
        echo "<h2 class='page-header services' id='services'>".$rowServicesHeading['servicesheading']."</h2>";
        echo "</div>";

        if (!empty($rowServicesHeading['servicescontent'])) {
            echo "<div class='col-lg-12'>";
            echo "<p class='text-center'>".$rowServicesHeading['servicescontent']."</p>";
            echo "</div>";
        }

        while ($rowServices = mysql_fetch_array($sqlServices)){
            $servicesCount++;

            echo "<div class='col-md-".$colWidth." text-center'>";
            echo "<div class='panel panel-default text-center'>";
            echo "<div class='panel-heading'>";
            echo "<span class='fa-stack fa-5x'>";

            if (!empty($rowServices['icon'])){
                echo "<i class='fa fa-circle fa-stack-2x text-primary'></i>";
                echo "<i class='fa fa-".$rowServices['icon']." fa-stack-1x fa-inverse' title='".$rowServices['title']."'></i>";
            }
            if (!empty($rowServices['image'])){
                echo "<img class='img-responsive img-circle' style='padding:8px;' src='uploads/".$rowServices['image']."' alt='".$rowServices['title']."' title='".$rowServices['title']."'>";
            }

            echo "</span>";
            echo "</div>";
            echo "<div class='panel-body'>";

            if (!empty($rowServices['title'])){
                echo "<h4>".$rowServices['title']."</h4>";
            }
            
            if (!empty($rowServices['content'])){
                echo "<p>".$rowServices['content']."</p>";
            }

            if (!empty($rowServices['link'])){
                echo "<a href='page.php?ref=".$rowServices['link']."' class='btn btn-primary'>Learn More</a>";
            }

            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    }
?>