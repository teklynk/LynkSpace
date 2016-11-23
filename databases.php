<?php
define('inc_access', TRUE);

include 'includes/header.php';

echo "<div class='container'>";

echo "<div class='row row_pad' id='databases'>";
echo "<div class='col-md-12'>";
    include 'includes/databases_inc.php';
echo "</div>";
echo "</div>";

include 'includes/footer.php';
?>