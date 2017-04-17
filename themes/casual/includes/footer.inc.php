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
            <div class="row">
                <?php
                getNav('Footer', 'false', 'left');
                ?>
            </div>
        </div>
        <?php include 'generalinfo.inc.php'; ?>

        <div id="belowfooter">
            <div class="container">
                <div class="socialDiv pull-left hidden-sm hidden-md hidden-lg hidden-xl">
                    <div class="row row_pad">
                        <?php include 'socialmedia.inc.php'; ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <p>
                                <span id="currentYear">Copyright &copy; <?php echo $_SERVER['SERVER_NAME'] . "&nbsp;" . date("Y"); ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <a href="#" class="scrollToTop">Scroll To Top</a>

<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { ?>
    <!-- Script to Activate the Carousel -->
    <script type="text/javascript">
        toggleSrc('<?php echo $hottitlesLoadFirstUrl; ?>', <?php echo $hottitlesLocID; ?>, 1);
    </script>
<?php } ?>

    </body>
    </html>
<?php
//close all db connections
mysqli_close($db_conn);
die();
?>