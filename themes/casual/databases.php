<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-databases'>";
?>
    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <?php
                if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
                    include 'includes/searchlocations.inc.php';
                } else {
                    include 'includes/searchpac.inc.php';
                }
                ?>
            </div>
        </div>
    </div>
<?php

echo "<div class='row'>";
echo "<div class='box'>";
echo "<div class='col-lg-12'>";

if (!empty($_GET['cat_id'])) {
    include 'includes/customers_catid.inc.php';
} else {
    include 'includes/customers.inc.php';
}

echo "</div>";
echo "</div>";
echo "</div>";

echo "</div>";

include_once('includes/footer.inc.php');
?>