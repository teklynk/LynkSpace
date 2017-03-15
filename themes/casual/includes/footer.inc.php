<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>
    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="footer" id="footer">
        <div class="container">
            <div class="row row_pad">
                <?php
                getNav('Footer', 'false', 'left');
                ?>
            </div>
            <?php include 'includes/generalinfo.inc.php'; ?>
        </div>
        <div id="belowfooter">
            <div class="container">
                <div class="socialDiv pull-left hidden-sm hidden-md hidden-lg hidden-xl">
                    <div class="row row_pad">
                        <?php include 'socialmedia.inc.php'; ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="col-lg-12 text-center">
                    <p>
                        <span id="currentYear">Copyright &copy; <?php echo $_SERVER['SERVER_NAME'] . "&nbsp;" . date("Y"); ?></span>
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
        //remove loader once the iframe has finished loading
        $('iframe.hottitles-iframe').load(function() {
            $('.hotContainer.loader').removeClass('loader');
            $('.iframe.hidden').removeClass('hidden');
        });
    </script>

    </body>
    </html>
<?php
//close all db connections
mysqli_close($db_conn);
die();
?>