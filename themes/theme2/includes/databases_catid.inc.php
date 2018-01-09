<!-- Databases Section -->
<a name="databases" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

if ($customerNumRows > 0) {

    echo "<div class='container-fluid cat_databases'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='row' id='databases'>";

    if (!empty($customerHeading)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h1 class='customers customersheading'>" . $customerHeading . "</h1>";
        echo "</div>";
    }

    if (!empty($customerBlurb)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<p class='text-left customersblurb'>".$customerBlurb."</p>";
        echo "</div>";
    }

    if (!empty($customerCatName)) {
        echo "<div class='col-xs-12 col-lg-12 cat-title'>";
        echo "<h1 class='customers'>" . $customerCatName . "</h1>";
        echo "</div>";
    }

    echo "<div style='clear:both;'></div>";

    $customersItemCount = 0;

    echo "<div class='row'>";

    while ($rowCustomers = mysqli_fetch_array($sqlCustomers, MYSQLI_ASSOC)) {

        if ($rowCustomers['featured'] == 'false' || $rowCustomers['featured'] == "" || $rowCustomers['featured'] == NULL) {

            $customersItemCount++;

            echo "<div class='col-sm-8 col-md-4 col-lg-4 database-item'>";

            if (!empty($rowCustomers['link'])) {
                echo "<a href='" . $rowCustomers['link'] . "' title='" . $rowCustomers['name'] . "' target='_blank'>";
            }

            echo "<div class='media'>";

            echo "<span class='media-object pull-left'>";
            echo "<span class='fa-stack fa-2x'>";

            if (!empty($rowCustomers['icon'])) {
                echo "<i class='fa fa-circle fa-stack-2x'></i>";
                echo "<i class='fa fa-" . $rowCustomers['icon'] . " fa-stack-1x fa-inverse' title='" . $rowCustomers['name'] . "'></i>";
            }

            if (!empty($rowCustomers['image'])) {
                echo "<img class='img-responsive img-circle' src='" . getAbsoluteImagePath($rowCustomers['image']) . "' alt='" . $rowCustomers['name'] . "' title='" . $rowCustomers['name'] . "'>";
            }

            echo "</span>";
            echo "</span>";

            echo "<div class='media-body'>";

            if (!empty($rowCustomers['name'])) {
                echo "<h3 class='sublinktitle'>" . $rowCustomers['name'] . "</h3>";
            }

            if (!empty($rowCustomers['content'])) {
                echo "<p>" . $rowCustomers['content'] . "</p>";
            }

            echo "</div>"; //media-body

            echo "</div>"; //media

            if (!empty($rowCustomers['link'])) {
                echo "</a>"; //close href
            }

            echo "</div>"; //database-item

            //Start a new row if item count is divisible by 3
            if (($customersItemCount % 3) === 0) {
                echo "<div class='database-break'></div>";
            }
        }
    }

    echo "</div>"; //row

    echo "</div>"; //#customers

    echo "</div>";
    echo "</div>";
}
?>