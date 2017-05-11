<?php
if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>

</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<footer>
    <span class="product-name">YouSeeMore</span> <span class="product-version">v<?php echo $ysmVersion; ?></span>
    <div class="pull-right">
        <ul class="nav-footer">
            <li>
                <a href="#" target="_blank">Privacy</a>
            </li>
            <li>
                <a href="#" target="_blank">Feedback</a>
            </li>
            <li>
                <a href="#" target="_blank">Help</a>
            </li>
        </ul>
        <span class="copyright">&copy; <?php echo date("Y"); ?>&nbsp;<a href="https://www.tlcdelivers.com" target="_blank">The Library Corporation</a></span>
    </div>
</footer>
</div>
<!-- /#wrapper -->
<!-- Scroll to Top -->
<a href="#" class="scrollToTop">Scroll To Top</a>
<?php
if (defined('datePicker')) {
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('.datepicker').length) {
                $('.datepicker').datepicker({
                    format: "yyyy-mm-dd",
                    startView: "month",
                    startDate: Date(),
                    todayHighlight: true,
                    autoclose: true,
                    forceParse: false
                });
            }
        });
    </script>
    <?php
}
?>
</body>
</html>
<?php
//close all database connections
mysqli_close($db_conn);
die();
?>
