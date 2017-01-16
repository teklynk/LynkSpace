<!-- Databases Section -->
<a name="databases" tabindex="-1"></a>
<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
//getCustomers();

if ($customerNumRows > 0) {

    echo "<div class='row' id='databases'>";

    if (!empty($customerCatName)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h1 class='customers'>" . $customerCatName . "</h1>";
        echo "</div>";
    } elseif (!empty($customerHeading)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<h1 class='customers'>" . $customerHeading . "</h1>";
        echo "</div>";
    }

    if (!empty($customerBlurb)) {
        echo "<div class='col-xs-12 col-lg-12'>";
        echo "<p class='text-left'>" . $customerBlurb . "</p>";
        echo "</div>";
    }

    echo "<div class='row row_pad'>";

    $customersCatCount = 0;
    $customersItemCount = 0;

    //Gets catname
    $sqlCatCustomers = mysqli_query($db_conn, "SELECT id, name FROM category_customers WHERE cust_loc_id=" . $_GET['loc_id'] . " ORDER BY id DESC");
    while ($rowCatCustomers = mysqli_fetch_array($sqlCatCustomers)) {

        $customerCatId = $rowCatCustomers['id'];
        $customerCatName = $rowCatCustomers['name'];

        if ($customerCatId != 0) {
            $customersCatCount++;
            echo "<div class='col-xs-12 col-lg-12 catnameid-".$customerCatId." catname-".strtolower($customerCatName)."'>";
            echo "<h1 class='customers'>" . $customerCatName . "</h1>";
            echo "</div>";
        } else {
            //If category = none
            echo "<div class='col-xs-12 col-lg-12 catnameid-".$customerCatId." catname-".strtolower($customerCatName)."'>";
            echo "<h1 class='customers'>Other</h1>";
            echo "</div>";
        }

        //Gets links for each cat
        $sqlCustomers = mysqli_query($db_conn, "SELECT id, image, icon, name, link, catid, content, featured, datetime, active, loc_id FROM customers WHERE active='true' AND catid=".$customerCatId." AND loc_id=" . $_GET['loc_id'] . " ORDER BY datetime DESC"); //While loop
        while ($rowCustomers = mysqli_fetch_array($sqlCustomers)) {

            if ($rowCustomers['featured'] == 'false' OR $rowCustomers['featured'] == '') {

                $customersItemCount++;

                echo "<div class='col-sm-8 col-md-4 col-lg-4 database-item catid-".$customerCatId."'>";

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
                    echo "<img class='img-responsive img-square' style='padding:8px;' src='uploads/" . $_GET['loc_id'] . "/" . $rowCustomers['image'] . "' alt='" . $rowCustomers['name'] . "' title='" . $rowServices['name'] . "'>";
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

            }
        }
    }

    echo "</div>"; //row

    echo "</div>"; //#customers
}
?>