

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <!-- Scroll to Top -->
    <a href="#" class="scrollToTop">Scroll To Top</a>

    <footer>
        <span class="product-name"><?php echo cmsTitle; ?></span> <span
                class="product-version">v<?php echo ysmVersion; ?></span>
        <div class="pull-right">
            <ul class="nav-footer">
                <li>
                </li>
            </ul>
            <span class="copyright">&copy; <?php echo date("Y"); ?>&nbsp;<a href="<?php echo cmsWebsite; ?>"
                                                                            target="_blank"><?php echo cmsTitle; ?></a></span>
        </div>
    </footer>

    </div>
    <!-- /#wrapper -->

    </body>
    </html>
<?php
mysqli_close($db_conn);
die();
?>