<!-- Services Section -->
<a name="services" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

getServices($_GET['loc_id']);

echo "<a name='services'></a>";

if ($servicesNumRows > 0) {
    echo "<div class='container-fluid services'>";
    echo "<div class='container bannerwrapper'>";

    if (!empty($servicesHeading)) {
        echo "<div class='col-lg-12'>";
        echo "<h1 class='text-left servicesheading'>" . $servicesHeading . "</h1>";
        echo "</div>";
    }

    if (!empty($servicesBlurb)) {
        echo "<div class='col-lg-12'>";
        echo "<p class='text-left servicesblurb'>" . $servicesBlurb . "</p>";
        echo "</div>";
    }

    echo "<div class='row' id='services'>";

    while ($rowServices = mysqli_fetch_array($sqlServices, MYSQLI_ASSOC)) {

        echo "<div class='col-sm-6 col-md-3 col-lg-3 service-item'>";
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
            echo "<i class='fa fa-" . $rowServices['icon'] . " fa-stack-1x fa-inverse' title='" . $rowServices['title'] . "'></i>";
        }

        if (!empty($rowServices['image'])) {
            echo "<img class='img-responsive img-square' style='padding:8px;' src='" . $rowServices['image'] . "' alt='" . $rowServices['title'] . "' title='" . $rowServices['title'] . "'>";
        }

        echo "</span>";
        echo "</div>";

        echo "<div class='panel-body'>";

        if (!empty($rowServices['title'])) {
            echo "<h1>" . $rowServices['title'] . "</h1>";
        }

        if (!empty($rowServices['content'])) {
            echo "<p>" . $rowServices['content'] . "</p>";
        }

        if (!empty($rowServices['link'])) {
            echo "<a href='" . $rowServices['link'] . "' class='btn btn-primary'>Learn More</a>";
        }

        echo "</div>";

        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
    echo "</div>";

    echo "</div>";
    echo "</div>";
}
?>