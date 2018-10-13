<?php
if (!defined('ALLOW_INC')) {
	die('Direct access not permitted');
}
?>
<!-- Databases Section -->
<a name="databases" tabindex="-1"></a>
<?php

getCustomers($_GET['loc_id'], 'featured');

$customersItemCount = 0;

if ($customerNumRows > 0) {
    echo "<div class='page-container container-fluid featureddatabases'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='row' id='featureddatabases'>";

    if (!empty($customerHeading)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h1 class='customers customersheading'>" . $customerHeading . "</h1>";
        echo "</div>";
    }

    if (!empty($customerBlurb)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<p class='text-left customersblurb'>" . $customerBlurb . "</p>";
        echo "</div>";
    }

    echo "<div class='row row_pad'>";

    while ($rowCustomers = mysqli_fetch_array($sqlCustomers, MYSQLI_ASSOC)) {
        if ($rowCustomers['featured'] == 'true') {

            $customersItemCount++;

            echo "<div class='col-sm-12 col-md-4 col-lg-4 database-item'>";

            if (!empty($rowCustomers['link'])) {
                //Check if the link contains any shortCode
                $rowCustomers['link'] = getShortCode($rowCustomers['link']);

                echo "<a href='" . $rowCustomers['link'] . "' title='" . $rowCustomers['name'] . "'>";
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

            echo "</div>"; //col-

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