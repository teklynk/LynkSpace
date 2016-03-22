<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
?>

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
//overwrite session timeout on re-load
$_SESSION['timeout'] = time();

//close all db connections
	mysql_close($db_conn);
	die();
?>