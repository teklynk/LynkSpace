<?php
define('inc_access', TRUE);

include 'includes/header.php';

?>
    <div class="container row_pad" id="contact">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header contact"><?php echo $contactHeading; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3><?php echo $contactBlurb; ?></h3><br/>
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

        include 'includes/socialmedia_inc.php';

        echo "</div>";
        echo "</div>";
        ?>

        <!-- Contact Form -->
        <div class="row">
            <div class="col-md-8">
                <h3>Send us a Message</h3>
                <form name="sentMessage" id="contactForm" method="post" action="mail/sendmail.asp">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Full Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Message:</label>
                            <textarea rows="10" cols="100" class="form-control" id="message" name="message" required maxlength="999" style="resize:none"></textarea>
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
<?php
include 'includes/footer.php';
?>