<!-- Pages Section -->
<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-page'>";
?>
<div class="row">
    <div class="box">
        <div class="col-lg-12">
            <?php
            if ($_GET['loc_id'] == 1 && multiBranch == "true") {
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
echo "<div class='box' id='page'>";

echo "<div class='col-lg-12'>";
echo "<hr>";
echo "<h2 class='intro-text text-center'><strong>" . $pageTitle . "</strong></h2>";
echo "<hr>";
echo "</div>";

if ($pageImage > "") {

    if ($pageImageAlign == "right") {
        echo "<div class='col-xs-12 col-md-10 col-sm-4'>";
        echo $pageContent;
        echo "</div>";
        echo "<div class='hidden-xs col-md-2'>";
        echo $pageImage;
        echo "</div>";
    } else {
        echo "<div class='hidden-xs col-md-2'>";
        echo $pageImage;
        echo "</div>";
        echo "<div class='col-xs-12 col-md-10 col-sm-4'>";
        echo $pageContent;
        echo "</div>";
    }

} else {
    echo "<div class='col-xs-12 col-md-10 col-sm-12'>";
    echo $pageContent;
    echo "</div>";
}

echo "</div>";
echo "</div>";

echo "</div>";
include_once('includes/footer.inc.php');
?>