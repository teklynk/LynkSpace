<!-- Contact Section -->
<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

echo "<div class='page-contact'>";

//needed for mailprocessor.php
$_SESSION['file_referrer'] = 'contact.php';

//Creates a unique refering value/token - exposed in post
$_SESSION['unique_referrer'] = generateRandomString();

echo "<div class='container-fluid'>";
echo "<div class='container'>";
    include 'includes/featured.inc.php';
echo "</div>";
echo "</div>";

echo "<div class='container-fluid'>";
echo "<div class='container'>";

if ($_GET['loc_id'] == 1) {
    include 'includes/searchlocations.inc.php';
} else {
    include 'includes/searchpac.inc.php';
}

echo "</div>";
echo "</div>";

?>
<div class="container row_pad" id="contact">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header contact"><?php echo $contactHeading; ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2><?php echo $contactBlurb; ?></h2><br/>
            </div>
        </div>

        <?php
        echo "<div class='row'>";

        //Embedded Google Map -->
        if (!empty($contactMap)) {
            echo "<div class='col-md-8'>";
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

        include 'includes/socialmedia.inc.php';

        echo "</div>"; //row
        echo "</div>"; //col-md-4
        ?>
    <!-- Contact Form -->
    <div class="row row_pad contactform">
        <div class="col-xs-12 col-md-12">
            <h3>Send us a Message</h3>
            <form name="sentMessage" id="contactForm" method="post" action="../../core/mail/mailprocessor.php?loc_id=<?php echo $_GET['loc_id']; ?>">
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Full Name:</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="255" required>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Phone Number:</label>
                        <input type="tel" class="form-control" id="phone" name="phone" maxlength="25" placeholder="304-555-5555" required>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Email Address:</label>
                        <input type="email" pattern="<?php echo emailValidationPattern ?>" class="form-control" id="email" name="email" maxlength="255" placeholder="your@email.com" required>
                    </div>
                </div>
                <div class="control-group form-group">
                    <div class="controls">
                        <label>Message:</label>
                        <textarea rows="10" cols="100" class="form-control" id="message" name="message" maxlength="999" style="resize:none" required></textarea>
                    </div>
                </div>
                <input type="hidden" id="sendToEmail" name="sendToEmail" value="<?php echo $contactFormSendToEmail; ?>"/>
                <input type="hidden" id="referrer" name="referrer" value="<?php echo $_SESSION['unique_referrer']; ?>"/>
                <br>
                <!-- For success/fail messages -->
                <?php
                echo $contactFormMsg;
                ?>
                <div class="control-group form-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

</div>
<?php
include_once('includes/footer.inc.php');
?>