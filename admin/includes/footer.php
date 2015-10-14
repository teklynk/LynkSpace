

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
		<div class="version text-right"><small><?php include 'core/version.txt'; ?></small></div>
    </div>
    <!-- /#wrapper -->

</body>

</html>
<?php
//close all db connections
	mysql_close($db_conn);
	die();
?>