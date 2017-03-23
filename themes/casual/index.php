<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');
?>
    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <?php include 'includes/featured.inc.php'; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">
                <header id='myCarousel' class='carousel slide'>
                    <?php include 'includes/slider.inc.php'; ?>
                </header>
                <div style="clear:both;"></div>

                <div class="row row_pad">
                    <div class="box">
                        <div class="col-lg-12">
                            <?php
                            if ($_GET['loc_id'] == 1 && $multiBranch == "true") {
                                include 'includes/searchlocations.inc.php';
                            } else {
                                include 'includes/searchpac.inc.php';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php

if ($_GET['loc_id']) {
    echo "<div class='row'>";
    echo "<div class='box'>";
    echo "<div class='col-lg-12'>";
        include 'includes/customersfeatured.inc.php';
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

include_once('includes/footer.inc.php');
?>
