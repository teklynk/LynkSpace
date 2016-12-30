<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <div class="container">
            <div class="row row_pad">
                <?php
                getNav('Footer', 'false', 'left');
                ?>
            </div>
            <?php include 'includes/generalinfo_inc.php'; ?>
        </div>
        <div id="belowfooter">
            <div class="container">
                <div class="socialDiv pull-left hidden-sm hidden-md hidden-lg hidden-xl">
                    <div class="row">
                        <?php include 'socialmedia_inc.php'; ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="row row_pad">
                    <p><span
                            id="currentYear">Copyright &copy; <?php echo $_SERVER['HTTP_HOST'] . "&nbsp;" . date("Y"); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <a href="#" class="scrollToTop">Scroll To Top</a>

    <!-- Script to Activate the Carousel -->
    <script type="text/javascript" language="javascript">
        $('.carousel').carousel({
            interval: <?php echo $carouselSpeed; ?> //change the speed in config.php
        })
    </script>

    </body>
    </html>
<?php
//close all db connections
mysqli_close($db_conn);
die();
?>