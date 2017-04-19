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
        <div class="col-lg-12">

            <header id="sliderCarousel" class="carousel slide" data-ride="carousel" data-interval="<?php echo $carouselSpeed; ?>">
                <?php include 'includes/slider.inc.php'; ?>
            </header>
            
            <div style="clear:both;"></div>

            <div class="row row_pad">
                <div class="box">
                    <div class="col-lg-12">
                        <?php
                        if ($_GET['loc_id'] == 1 && $multiBranch == 'true') {
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
getHottitlesTabs();

if ($hottitlesCount > 0) {
?>
<div class="row hottitlesCarousel">
    <div class="box">

        <div class="col-lg-12">
            <h1><?php echo $hottitlesHeading; ?></h1>
        </div>

        <div class="col-lg-12">
                
            <div id="hottitlesTabs">
                <div class="panel text-center">
                    <ul class="nav nav-pills center-tabs">
                        <?php echo $hottitlesTabs; ?>
                    </ul>
                </div> 
            </div>
            
            <div class="carousel slide" id="hottitlesCarousel">
                <div class="carousel-inner"></div>
            </div>
            
        </div>
        
    </div>
</div>
<?php
}
?>

<div class="row">
    <div class="box">
        <div class="col-lg-12">
            <?php include 'includes/customersfeatured.inc.php'; ?>
        </div>
    </div>
</div>

<?php include_once("includes/footer.inc.php"); ?>
