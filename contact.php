<?php
include 'includes/header.php';

$sqlContact = mysql_query("SELECT heading, introtext, mapcode, email, sendtoemail, address, city, state, zipcode, phone, hours FROM contactus");
$rowContact = mysql_fetch_array($sqlContact);
?>
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header"><?php echo $rowContact['heading']; ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3><?php echo $rowContact['introtext']; ?></h3><br/>
            </div>
        </div>
            
        <?php
        echo "<div class='row'>";

        //Embedded Google Map -->
        if (!empty($rowContact['mapcode'])) {
            echo "<div class='col-md-8'>";
            echo $rowContact['mapcode'];
            echo "</div>";
        }

        //Contact Details Column -->
        echo "<div class='col-md-4'>";

        echo "<p>".$rowContact['address']."<br>".$rowContact['city'].", ".$rowContact['state']." ".$rowContact['zip']."<br></p>";
        
        if (!empty($rowContact['phone'])) {
            echo "<p><i class='fa fa-phone'></i>";
            echo "&nbsp;<abbr title='Phone'>P</abbr>:&nbsp;".$rowContact['phone']."</p>";
        }
        if (!empty($rowContact['email'])) {
            echo "<p><i class='fa fa-envelope-o'></i>";
            echo "&nbsp;<abbr title='Email'>E</abbr>:&nbsp;<a href='mailto:".$rowContact['email']."'>".$rowContact['email']."</a></p>";
        }
        if (!empty($rowContact['hours'])) {
            echo "<p><i class='fa fa-clock-o'></i>";
            echo "&nbsp;<abbr title='Hours'>H</abbr>:&nbsp;".$rowContact['hours']."</p>";
        }

        //include 'includes/socialmedia_inc.php';

        echo "</div>";

        echo "</div>";
        ?>

        <!-- Contact Form -->
        <div class="row">
            <div class="col-md-8">
                <h3>Send us a Message</h3>
                <form name="sentMessage" id="contactForm" method="post" action="mail/contact_me2.php">
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
                    <input type="hidden" id="sendToEmail" name="sendToEmail" value="<?php echo $rowContact["sendtoemail"];?>"/>
                    <br>
                    <!-- For success/fail messages -->
                    <?php
                        if ($_GET["msgsent"]=="thankyou") {
                            echo "<div id='success'><div class='alert alert-success'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='contact.php'\">×</button><strong>Your message has been sent. </strong></div></div>";
                        } else if ($_GET["msgsent"]=="error") {
                            echo "<div id='success'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true' onclick=\"window.location.href='contact.php'\">×</button><strong>An error occured while sending your message. </strong></div></div>";
                        }
                    ?>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

        </div>
<?php
include 'includes/footer.php';
?>