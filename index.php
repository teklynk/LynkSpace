<?php
define('inc_access', TRUE);

    include 'includes/header.php';

    echo "<div class='grad-blue container-fluid featured'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/featured_inc.php';
    echo "</div>";
    echo "</div>";


    include 'includes/slider_inc.php';


    echo "<div class='grad-orange container-fluid search'>";
    echo "<div class='container bannerwrapper'>";
        if ($_GET['loc_id'] == 1) {
            include 'includes/searchlocations_inc.php';
        } else {
            include 'includes/searchpac_inc.php';
        }
    echo "</div>";
    echo "</div>";

    if ($_GET['loc_id'] != 1) {
        echo "<div class='container-fluid'>";
        echo "<div class='container bannerwrapper'>";
        include 'includes/customersfeatured_inc.php';
        echo "</div>";
        echo "</div>";
    }

	include 'includes/footer.php';
?>