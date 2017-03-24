<!-- Contact Section -->
<?php
define('inc_access', TRUE);

include_once('includes/header.inc.php');

//needed for mailprocessor.php
$_SESSION['file_referer'] = 'contact.php';

//Creates a unique refering value/token - exposed in post
$_SESSION['unique_referer'] = generateRandomString();

?>
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

<div class="row">
    <div class="box">
        <div class="col-lg-12">
            <hr>
            <h2 class="intro-text text-center">
                <strong><?php echo $contactHeading; ?></strong>
            </h2>
            <hr>
        </div>
        <div class="col-md-8">
            <?php echo $contactMap; ?>
        </div>
        <div class="col-md-4">
            <p>Phone:
                <strong><?php echo $contactPhone; ?></strong>
            </p>
            <?php if (!empty($contactEmail)) { ?>
            <p>Email:
                <strong><a href="mailto:<?php echo $contactEmail; ?>"><?php echo $contactEmail; ?></a></strong>
            </p>
            <?php }?>
            <p>Address:
                <strong><?php echo $contactAddress; ?>
                    <br><?php echo $contactCity; ?>, <?php echo $contactState; ?> <?php echo $contactZipcode; ?></strong>
            </p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="row contactform">
    <div class="box">
        <div class="col-lg-12">
            <p><?php echo $contactBlurb; ?></p>
            <form name="sentMessage" id="contactForm" method="post" action="../../core/mail/mailprocessor.php?loc_id=<?php echo $_GET['loc_id']; ?>">
                <div class="row">
                    <div class="form-group col-lg-4">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" maxlength="255" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Email Address</label>
                        <input type="email" pattern="<?php echo $emailValidatePattern ?>" class="form-control" id="email" name="email" maxlength="255" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" maxlength="25" placeholder="555-5555" required>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-lg-12">
                        <label>Message</label>
                        <textarea class="form-control" rows="6" id="message" name="message" maxlength="999" style="resize:none" required></textarea>
                    </div>
                    <input type="hidden" id="sendToEmail" name="sendToEmail" value="<?php echo $contactFormSendToEmail; ?>"/>
                    <input type="hidden" id="referer" name="referer" value="<?php echo $_SESSION['unique_referer']; ?>"/>
                    <br>
                    <!-- For success/fail messages -->
                    <?php
                    echo $contactFormMsg;
                    ?>
                    <div class="form-group col-lg-12">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.inc.php');
?>