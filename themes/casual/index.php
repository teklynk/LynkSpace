<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');
?>
    <div class="row">
        <div class="box">
            <div class="col-lg-12 text-center">
                <header id='myCarousel' class='carousel slide'>
                    <?php include 'includes/slider.inc.php'; ?>
                </header>
                <div style="clear:both;"></div>

                <div class="row">
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

    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <?php
                echo "<div class='panel with-nav-tabs panel-default hottitles'>";

                echo "<div class='panel-heading'>";
                echo "<ul class='nav nav-tabs'>";
                getHottitlesTabs(); //gets the tabs
                echo "</ul>";
                echo "</div>";

                echo "<div class='hotContainer loader panel-body'>";
                echo "<div class='iframe hidden tab-content'>";
                echo "<iframe class='hottitles-iframe embed-responsive-item' seamless src='themes/casual/includes/hottitles.inc.php?loc_id=".$_GET['loc_id']."&rssurl=".$hottitlesUrl."'></iframe>";
                echo "</div>";
                echo "</div>";

                echo "</div>";
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="box">
            <div class="col-lg-12">
                <?php include 'includes/featured.inc.php'; ?>
            </div>
        </div>
    </div>

    <?php
    include_once('includes/footer.inc.php');
    ?>
