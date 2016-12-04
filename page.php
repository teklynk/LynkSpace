<?php
define('inc_access', TRUE);

include 'includes/header.php';

    echo "<div class='grad-orange container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        if ($_GET['loc_id'] == 1) {
            include 'includes/searchlocations_inc.php';
        } else {
            include 'includes/searchpac_inc.php';
        }
    echo "</div>";
    echo "</div>";

	echo "<div class='container'>";
	echo "<div class='row row_pad' id='page'>";

    getPage();

    echo "<div class='col-lg-12'>";
    echo "<h1 class='page'>".$pageTitle."</h1>";
    echo "</div>";

    if ($pageImage>"") {

        if ($pageImageAlign=="right") {
            echo "<div class='col-md-10'>";
            echo $pageContent;
            echo "</div>";
            echo "<div class='col-md-2'>";
            echo $pageImage;
            echo "</div>";
        } else {
            echo "<div class='col-md-2'>";
            echo $pageImage;
            echo "</div>";
            echo "<div class='col-md-10'>";
            echo $pageContent;
            echo "</div>";
        }

    } else {
        echo "<div class='col-lg-12'>";
        echo $pageContent;
        echo "</div>";
    }

	echo "</div>";
    echo "</div>";

    echo "<div class='container bannerwrapper'>";
        include 'includes/customers_inc.php';
    echo "</div>";

include 'includes/footer.php';
?>