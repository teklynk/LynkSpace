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
                getNav('Footer', 'false', 'left', 'false');
                ?>
            </div>
            <div class="socialDiv pull-left ">
                <div class="row">
                    <?php include 'socialmedia.inc.php'; ?>
                </div>
            </div>
            <div style="clear:both;"></div>
            <?php include 'generalinfo.inc.php'; ?>
        </div>
        <div id="belowfooter">
            <div class="container">
                <div style="clear:both;"></div>
                <div class="row row_pad">
                    <p>
                        <span id="currentYear">Copyright &copy; <?php echo $_SERVER['SERVER_NAME'] . "&nbsp;" . date("Y"); ?></span>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <div id="ysm_brand_footer">
        <span class="product-name">YouSeeMore</span> <span class="product-version">v<?php echo ysmVersion; ?></span>
        <div class="pull-right">
            <ul class="nav-footer">
            </ul>
            <span class="copyright">&copy; <?php echo date("Y"); ?>&nbsp;<a href="//www.tlcdelivers.com" target="_blank">The Library Corporation</a></span>
        </div>
    </div>

    <!-- Scroll to Top -->
    <a href="#" class="scrollToTop">Scroll To Top</a>

<?php if (basename($_SERVER['PHP_SELF']) == 'index.php') { ?>
    <!-- Script to Activate the Carousel -->
    <script type="text/javascript">
        //toggleSrc(url, loc_id, index)
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