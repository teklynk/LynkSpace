<?php
define('inc_access', TRUE);

include 'includes/header.php';

    echo "<div class='grad-orange container-fluid'>";
    echo "<div class='container bannerwrapper'>";
        if ($_GET['loc_id'] == 1) {
            include 'includes/searchlocations_inc.php';
        } else {
            include 'includes/searchpac_inc.php';
        }
    echo "</div>";
    echo "</div>";
?>
    <div class="container" id="contact">

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
            echo "<div class='col-md-8'>";
            echo $contactMap;
            echo "</div>";
        }

        //Contact Details Column -->
        echo "<div class='col-md-4'>";

        echo "<p>".$contactAddress."<br>".$contactCity.", ".$contactState." ".$contactZipcode."<br></p>";
        
        if (!empty($contactPhone)) {
            echo "<p><i class='fa fa-phone'></i>";
            echo "&nbsp;<abbr title='Phone'>P</abbr>:&nbsp;".$contactPhone."</p>";
        }

        if (!empty($contactEmail)) {
            echo "<p><i class='fa fa-envelope-o'></i>";
            echo "&nbsp;<abbr title='Email'>E</abbr>:&nbsp;<a href='mailto:".$contactEmail."'>".$contactEmail."</a></p>";
        }

        if (!empty($contactHours)) {
            echo "<p><i class='fa fa-clock-o'></i>";
            echo "&nbsp;<abbr title='Hours'>H</abbr>:&nbsp;".$contactHours."</p>";
        }

        echo "</div>";
        echo "</div>";
        ?>

        <!-- Contact Form -->
        <div class="row row_pad">
            <div class="col-md-8">
                <h3>Send us a Message</h3>
                <form name="sentMessage" id="contactForm" method="post" action="mail/contact_me.php">
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
                            <input type="email" pattern="<?php echo $emailValidatePattern ?>" class="form-control" id="email" name="email" maxlength="255" placeholder="your@email.com" required>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Message:</label>
                            <textarea rows="10" cols="100" class="form-control" id="message" name="message" maxlength="999" style="resize:none" required></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="sendToEmail" name="sendToEmail" value="<?php echo $contactFormSendToEmail;?>"/>
                    <br>
                    <!-- For success/fail messages -->
                    <?php
                        echo $contactFormMsg;
                    ?>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
        <!--.container-->
    </div>
<?php
    include 'includes/footer.php';
?>