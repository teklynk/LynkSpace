<?php
define('inc_access', TRUE);

include 'includes/header.php';
    echo "<div class='grad-orange container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        include 'includes/searchpac_inc.php';
    echo "</div>";
    echo "</div>";

    echo "<div class='container'>";
    echo "<div class='row row_pad' id='about'>";
    echo "<div class='col-md-12'>";
        include 'includes/about_inc.php';
    echo "</div>";
    echo "</div>";
    echo "</div>";

    echo "<div class='container bannerwrapper'>";
    echo "<div class='row row_pad' id='about'>";
        include 'includes/customers_inc.php';
    echo "</div>";
echo "</div>";

include 'includes/footer.php';
?>