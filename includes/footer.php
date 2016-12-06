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

    <!--scroll to top-->
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