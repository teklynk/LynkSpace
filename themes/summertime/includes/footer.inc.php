<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>

    <!-- Footer -->
    <footer class="footer" id="footer">
        <div class="container">
            <!-- Navigation -->
            <nav id="top" class="navbar navbar-static-bottom" role="navigation">
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="navbar-Footer">
                    <?php
                    //EXAMPLE: getNav($navSection,$dropdown,$pull,$sitesearchlink)
                    getNav('Footer', 'false', 'center', 'false');
                    ?>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div style="clear:both;"></div>
            <div class="socialDiv fa-1x">
                <?php include 'socialmedia.inc.php'; ?>
            </div>
            <div style="clear:both;"></div>
            <div class="no-side-padding" id="generalinfo">
                <?php include 'generalinfo.inc.php'; ?>
            </div>
            <div style="clear:both;"></div>
            <div id="belowfooter">
                <p>
                    <span id="currentYear">Copyright &copy; <?php echo $_SERVER['SERVER_NAME'] . "&nbsp;" . date("Y"); ?></span>
                </p>
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