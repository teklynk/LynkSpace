        <hr>
        <!-- Footer -->
        <footer>
            <div class="footer" id='footer'>
                
				<?php 
				$sqlNavLinks = mysql_query("SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='Footer' AND sort>0 ORDER BY sort");
				//returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, category.id, category.name
				$tempLink = 0;

				while ($rowNavLinks = mysql_fetch_array($sqlNavLinks)) {
					if ($rowNavLinks[4] == $rowNavLinks[7] AND $rowNavLinks[4] != 29) {
						if ($rowNavLinks[4] != $tempLink) {
							$sqlNavCatLinks = mysql_query("SELECT * FROM navigation JOIN category ON navigation.catid=category.id WHERE section='Footer' AND category.id=".$rowNavLinks[4]." AND sort>0 ORDER BY sort");
							//returns: navigation.id, navigation.name, navigation.url, navigation.catid, navigation.section, navigation.win, category.id, category.name
                			$num_rows = mysql_num_rows($sqlNavCatLinks);	
                                if ($num_rows==2) {
                                    $colWidth=6;
                                } elseif ($num_rows==3) {
                                    $colWidth=4;
                                } elseif ($num_rows==4) {
                                    $colWidth=3;
                                }
                                echo "<div class='col-md-".$colWidth."'>";
                                echo "<h4>".$rowNavLinks[8]."</h4>";
								echo "<ul class='footer-subnav'>";
								while ($rowNavCatLinks = mysql_fetch_array($sqlNavCatLinks)) {
									echo "<li>";
									echo "<a href='".$rowNavCatLinks[3]."'>".$rowNavCatLinks[2]."</a>";
									echo "</li>";
								}
								echo "</ul>";
                                echo "</div>";
						}
					} else {
                        echo "<div class='col-md-2'>";
						echo "<ul class='footer-nav' style='display:inline-block;'>";
						echo "<li>";
						echo "<a href='".$rowNavLinks[3]."'>".$rowNavLinks[2]."</a>";
						echo "</li>";
						echo "</ul>";
                        echo "</div>";
					}
					$tempLink = $rowNavLinks[4]; 
				}

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