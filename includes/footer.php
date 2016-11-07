<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
?>
        <!-- Footer -->
        <footer>
            <div class="footer" id='footer'>
                
				<?php 
                    getNav('Footer','false','left');
                ?>

            </div>
            <?php
            echo "<div class='row' id='socialmedia'>";
                echo "<div class='col-md-12'>";
    				include 'socialmedia_inc.php';
                echo "</div>";
            echo "</div>";
            ?>
            <div class="row copyright">
                <div class="col-lg-6 text-left">
                    <p>Copyright &copy; <?php echo str_replace(':8080','',$_SERVER['HTTP_HOST']."&nbsp;".date("Y"));?></p>
                </div>
				<div class="col-lg-6 text-right"><a href="//sayat.me/teklynk" target="_blank"><img style="max-width:60px;" src="core/teklynk_logo.png" border="0"/></a></div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.10.2.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script type="text/javascript" language="javascript">
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>
<?php
    //close all db connections
    mysqli_close($db_conn);
    die();
?>