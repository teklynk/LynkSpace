<!-- Databases Section -->
<a name="databases" tabindex="-1"></a>
<?php

if ($customerNumRows > 0) {

    echo "<div class='container-fluid databases'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='row' id='databases'>";

    if (!empty($customerHeading)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h1 class='customersheading'>" . $customerHeading . "</h1>";
        echo "</div>";
    }

    if (!empty($customerBlurb)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<p class='text-left customersblurb'>" . $customerBlurb . "</p>";
        echo "</div>";
    }

    if (!empty($customerCatName)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h1 class='customers'>" . $customerCatName . "</h1>";
        echo "</div>";
    }

    echo "<div class='row row_pad'>";

    $customersCatCount = 0;

    //Gets catname
    $sqlCatCustomers = mysqli_query($db_conn, "SELECT id, name, section FROM category_customers WHERE section='" . $customerSection . "' AND cust_loc_id=" . $custDefaultLoc . " ORDER BY sort, name ASC");
    while ($rowCatCustomers = mysqli_fetch_array($sqlCatCustomers, MYSQLI_ASSOC)) {

        $customerCatId = $rowCatCustomers['id'];
        $customerCatName = $rowCatCustomers['name'];

        if ($customerCatId != 0) {
            //prints the cat title/name
            $customersCatCount++;
            echo "<div class='col-xs-12 col-lg-12 cat-title catnameid-" . $customerCatId . " '>";
            echo "<a href='databases.php?loc_id=" . $_GET['loc_id'] . "&section=" . $customerSection . "&cat_id=" . $customerCatId . "' title='" . $customerCatName . "'><h1 class='customers'>" . $customerCatName . "</h1></a>";
            echo "</div>";
            echo "<div style='clear:both;'></div>";
        }

        $customersItemCount = 0;

        //Gets links for each cat
        $sqlCustomers = mysqli_query($db_conn, "SELECT id, image, icon, name, link, catid, section, content, featured, sort, datetime, active, loc_id FROM customers WHERE active='true' AND section='" . $customerSection . "' AND featured='false' AND catid=" . $customerCatId . " AND loc_id=" . $custDefaultLoc . " ORDER BY catid, sort, name ASC"); //While loop
        $itemCount = mysqli_num_rows($sqlCustomers);
        while ($rowCustomers = mysqli_fetch_array($sqlCustomers, MYSQLI_ASSOC)) {

            $customersItemCount++;

            echo "<div class='col-sm-8 col-md-4 col-lg-4 database-item item-" . $customersItemCount . " catid-" . $customerCatId . "'>";

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

    echo "</div>"; //row_pad

    echo "</div>";
    echo "</div>";

} else {
    echo "<div class='container-fluid databases'>";
    echo "<div class='container bannerwrapper'>";

    echo "<div class='col-lg-12'><h1 class='page'>Page not found</h1></div>";
    echo "<div class='col-xs-12 col-lg-12'>This page is not available.</div>";

    echo "</div>";
    echo "</div>";
}
?>