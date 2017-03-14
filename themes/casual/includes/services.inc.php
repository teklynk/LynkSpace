<!-- Services Section -->
<a name="services" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

if ($servicesNumRows > 0) {

    echo "<div class='row' id='services'>";
    echo "<div class='box'>";

    echo "<div class='col-lg-12'>";

    if (!empty($servicesHeading)) {
        echo "<hr>";
        echo "<h2 class='intro-text text-center'>" . $servicesHeading . "</h2>";
        echo "<hr>";
    }

    echo "</div>"; //col-lg-12

    if (!empty($servicesBlurb)) {
        echo "<div class='col-md-6'>";
        echo "<p>" . $servicesBlurb . "</p>";
        echo "</div>";
        //echo "<div class='clearfix'></div>";
    }


    echo "</div>"; //box
    echo "</div>"; //row

    echo "<div class='row'>";
    echo "<div class='box'>";

    while ($rowServices = mysqli_fetch_array($sqlServices)) {

        echo "<div class='col-sm-4 text-center'>";

        if (!empty($rowServices['icon']) || !empty($rowServices['image'])) {
            echo "<div class='panel-heading'>";
            echo "<span class='fa-stack fa-5x'>";
        } else {
            echo "<div>";
            echo "<span>";
        }

        if (!empty($rowServices['icon'])) {
            echo "<i class='fa fa-circle fa-stack-2x text-primary'></i>";
            echo "<i class='fa fa-" . $rowServices['icon'] . " fa-stack-1x fa-inverse' title='" . $rowServices['title'] . "'></i>";
        }

        if (!empty($rowServices['image'])) {
            echo "<img class='img-responsive img-square' style='padding:8px;' src='uploads/" . $_GET['loc_id'] . "/" . $rowServices['image'] . "' alt='" . $rowServices['title'] . "' title='" . $rowServices['title'] . "'>";
        }

        echo "</span>"; //fa-stack fa-5x
        echo "</div>"; //panel-heading

        echo "<div class='panel-body'>";

        if (!empty($rowServices['title'])) {
            echo "<h3>" . $rowServices['title'] . "</h3>";
        }

        if (!empty($rowServices['content'])) {
            echo "<p>" . $rowServices['content'] . "</p>";
        }

        if (!empty($rowServices['link'])) {
            echo "<a href='" . $rowServices['link'] . "' class='btn btn-primary'>Learn More</a>";
        }

        echo "</div>"; //panel-body

        echo "</div>"; //col-sm-4 text-center
    }

    echo "</div>"; //box
    echo "</div>"; //row
}
?>