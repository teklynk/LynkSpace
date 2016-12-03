<?php
define('inc_access', TRUE);

    include 'includes/header.php';

    echo "<div class='grad-blue container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/featured_inc.php';
    echo "</div>";
    echo "</div>";

    include 'includes/slider_inc.php';

    echo "<div class='grad-orange container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/searchpac_inc.php';
    echo "</div>";
    echo "</div>";

    echo "<div class='container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/customers_inc.php';
    echo "</div>";
    echo "</div>";

	include 'includes/footer.php';
?>