        <hr>
        <!-- Footer -->
        <footer>
            <div class="footer" id='footer'>
                
				<?php 
                    getNav('Footer','false','left');
                ?>

            </div>
            <?php
            echo "<div class='row socialmedia'>";
            echo "<div class='col-md-12'>";
				include 'includes/socialmedia_inc.php';
            echo "</div>";
            echo "</div>";
            ?>
            <div class="row copyright">
                <div class="col-lg-12">
                    <p>Copyright &copy; <?php echo $_SERVER['HTTP_HOST']."&nbsp;".date("Y");?></p>
                </div>
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
    mysql_close($db_conn);
    die();
?>