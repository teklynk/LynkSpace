<?php
if(!defined('inc_access')) {
   die('Direct access not permitted');
}
?>

            </div>
            <!-- /.container-fluid -->

        </div>

        <!-- /#page-wrapper -->
		<div class="version text-right"><small><a target="_blank" href="https://github.com/teklynk/businessCMS">Github</a></small></div>
    </div>
    <!-- /#wrapper -->

</body>

</html>
<?php
//overwrite session timeout on re-load
$_SESSION['timeout'] = time();

//close all db connections
	mysqli_close($db_conn);
	die();
?>
