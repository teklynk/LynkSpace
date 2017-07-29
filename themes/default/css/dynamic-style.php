<?php
define('inc_access', TRUE);

require_once('../../../core/functions.php');

header("Content-type: text/css; charset: UTF-8");
header('Cache-control: must-revalidate');

getDynamicCss(
    ['.themebasecolor', '.footerbgcolor', '.headerbgcolor', '.fontcolor'],
    ['background-color', 'background-color', 'background-color', 'font-color']
);


?>