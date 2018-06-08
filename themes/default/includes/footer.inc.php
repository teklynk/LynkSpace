
    <!-- Footer -->
    <footer class="footer themebase-footerbgcolor" id="footer">
        <div class="container">
            <div class="row row_pad">
                <?php
                getNav($_GET['loc_id'], 'Footer', 'false', 'left', 'false');
                ?>
            </div>
            <?php require_once(__DIR__ . '/generalinfo.inc.php'); ?>
        </div>
        <div id="belowfooter">
            <div class="container">
                <div class="socialDiv pull-left hidden-sm hidden-md hidden-lg hidden-xl">
                    <div class="row">
                        <?php require_once(__DIR__ . '/socialmedia.inc.php'); ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </footer>

    <div id="ysm_brand_footer">
        <span class="product-name"><?php echo cmsTitle; ?></span> <span
                class="product-version">v<?php echo ysmVersion; ?></span>
        <div class="pull-right">
            <ul class="nav-footer">
            </ul>
            <span class="copyright">&copy; <?php echo date("Y"); ?>&nbsp;<a href="<?php echo cmsWebsite; ?>"
                                                                            target="_blank"><?php echo cmsTitle; ?></a></span>
        </div>
    </div>

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
//close all config connections
mysqli_close($db_conn);
die();
?>