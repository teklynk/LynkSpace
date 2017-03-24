<!-- Databases Section -->
<a name="databases" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}

if ($customerNumRows > 0) {

    if (!empty($customerCatName)) {
        echo "<div class='col-lg-12'>";
        echo "<h2 class='page-header customers'>" . $customerCatName . "</h2>";
        echo "</div>";
    } elseif (!empty($customerHeading)) {
        echo "<div class='col-lg-12'>";
        echo "<h2 class='page-header customers'>" . $customerHeading . "</h2>";
        echo "</div>";
    }
    echo "<div style='clear:both;'></div>";

    $customersItemCount = 0;

    while ($rowCustomers = mysqli_fetch_array($sqlCustomers)) {

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
                echo "<img class='img-responsive img-circle' src='uploads/" . $_GET['loc_id'] . "/" . $rowCustomers['image'] . "' alt='" . $rowCustomers['name'] . "' title='" . $rowServices['name'] . "'>";
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

}
?>