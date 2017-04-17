<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>

    <!-- Footer -->
    <div class="container-fluid footer">
        <div class="container">
            <footer>
                <?php
                include 'generalinfo.inc.php';

                echo "<div style='clear:both;'></div>";

                getNav('Footer', 'false', 'left');
                ?>
                <div class="row" id="socialmedia">
                    <div class="col-md-12">
                        <?php include 'socialmedia.inc.php'; ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="row copyright">
                    <div class="col-lg-6 text-left">
                        <p>
                            Copyright &copy; <?php echo $_SERVER['SERVER_NAME'] . "&nbsp;" . date("Y"); ?>
                        </p>
                    </div>
                </div>
            </footer>
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
//close all db connections
mysqli_close($db_conn);
die();
?>