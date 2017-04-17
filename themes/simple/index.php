<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<header id='sliderCarousel' class='carousel slide' data-ride='carousel' data-interval='$carouselSpeed'>";
    include 'includes/slider.inc.php';
echo "</header>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";
include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";
if ($_GET['loc_id'] == 1 && $multiBranch == 'true') {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}
echo "</div>";
echo "</div>";

?>
    <div class="container-fluid hottitlesCarousel">
        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <h2 class="page-header"><?php echo getHottitlesHeading(); ?></h2>


                    <div id="hottitlesTabs">
                        <div class="panel text-center">
                            <ul class="nav nav-tabs center-tabs">
                                <?php getHottitlesTabs(); ?>
                            </ul>
                        </div>
                    </div>

                    <div class="carousel slide" id="hottitlesCarousel">
                        <div class="carousel-inner"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php

echo "<div class='container-fluid'>";
echo "<div class='container'>";
include 'includes/customersfeatured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";
include 'includes/about.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";
include 'includes/services.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";
include 'includes/team.inc.php';
echo "</div>";
echo "</div>";

include_once('includes/footer.inc.php');
?>