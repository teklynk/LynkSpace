<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>

</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<div class="version text-right">
    <small><a target="_blank" href="https://github.com/teklynk/businessCMS">Github</a></small>
</div>
</div>
<!-- /#wrapper -->
<!-- Scroll to Top -->
<a href="#" class="scrollToTop">Scroll To Top</a>
</body>
</html>
<?php
//close all db connections
mysqli_close($db_conn);
die();
?>
