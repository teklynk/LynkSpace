<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
?>
        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">

                <?php
                    getNav('Footer','false','left');
                ?>

                </div>

            </div>
        </footer>
        <div id="belowfooter">
            <div class="container">
                <p><span id="currentYear">Copyright &copy; <?php echo $_SERVER['HTTP_HOST']."&nbsp;".date("Y");?></span></p>
            </div>
        </div>

    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <!-- template js file-->
    <script type="text/javascript" language="javascript" src="js/cps-scripts.js"></script>
    <!-- Script to Activate the Carousel -->
    <script type="text/javascript" language="javascript">
    $('.carousel').carousel({
        interval: <?php echo $carouselSpeed; ?> //change the speed in config.php
    })
    </script>

    <!-- Google Translate -->
    <script type="text/javascript" language="javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <!--scroll to top-->
    <a href="#" class="scrollToTop">Scroll To Top</a>
</body>
</html>
<?php
    //close all db connections
    mysqli_close($db_conn);
    die();
?>