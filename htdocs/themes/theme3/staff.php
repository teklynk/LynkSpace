<?php
define( 'ALLOW_INC', true );

require_once( __DIR__ . '/includes/header.inc.php' );

echo "<div class='page-team'>";

require_once( __DIR__ . '/includes/featured.inc.php' );

echo "<div class='grad-blue themebase-bgcolor container-fluid search'>";
echo "<div class='container bannerwrapper'>";

echo "</div>";
echo "</div>";

require_once( __DIR__ . '/includes/staff.inc.php' );

echo "</div>";

require_once( __DIR__ . '/includes/footer.inc.php' );
?>