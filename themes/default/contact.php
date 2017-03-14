<!-- Contact Section -->
<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

//Creates a unique refering value/token - exposed in post
$_SESSION['unique_referer'] = generateRandomString();

echo "<div class='grad-blue container-fluid featured'>";
echo "<div class='container bannerwrapper'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='grad-orange container-fluid search'>";
echo "<div class='container bannerwrapper'>";

if ($_GET['loc_id'] == 1) {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

?>
<div class="container" id="contact">
    <div class="content">
        <div class="row row_pad">
            <div class="col-lg-12">
                <h1 class="contact"><?php echo $contactHeading; ?></h1>
            </div>
        </div>

        <div class="row row_pad">
            <div class="col-lg-12">
                <h3><?php echo $contactBlurb; ?></h3><br/>
            </div>
        </div>

        <?php
        echo "<div class='row row_pad'>";

        //Embedded Google Map -->
        if (!empty($contactMap)) {
            echo "<div class='col-xs-12 col-md-8'>";
            echo $contactMap;
            echo "</div>";
        }

        //Contact Details Column -->
        echo "<div class='col-md-4'>";

        if (!empty($contactAddress)) {
            echo "<p><i class='fa fa-home'></i>";
            echo "&nbsp;" . $contactAddress . ",&nbsp;" . $contactCity . ",&nbsp;" . $contactState . "&nbsp;" . $contactZipcode . "</p>";
        }

        if (!empty($contactPhone)) {
            echo "<p><i class='fa fa-phone'></i>";
            echo "&nbsp;<a>" . $contactPhone . "</a></p>";
        }

        if (!empty($contactEmail)) {
            echo "<p><i class='fa fa-envelope-o'></i>";
            echo "&nbsp;<a href='mailto:" . $contactEmail . "'>" . $contactEmail . "</a></p>";
        }

        if (!empty($contactHours)) {
            echo "<p><i class='fa fa-clock-o'></i>";
            echo "&nbsp;" . $contactHours . "</p>";
        }

        echo "</div>"; //row
        echo "</div>"; //col-md-4
        ?>

        </div>
    </div>
</div>
<?php
include_once('includes/footer.inc.php');
?>