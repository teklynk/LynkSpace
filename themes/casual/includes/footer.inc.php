<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>
    </div>
    <!-- /.container -->

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })
    </script>

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