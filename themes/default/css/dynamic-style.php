<?php
define('inc_access', TRUE);

require_once('../../../config/config.php');
//require_once('../../../core/functions.php');

header("Content-type: text/css; charset: UTF-8");
header('Cache-control: must-revalidate');

//TODO: Create a frontend function called themOptions. Pass in an array of the classes and id's. Iterate through the array and process it as css.
//function themeOptions($loc, array('.basecolor', '.footercolor', '.navcolor')){}

//Color Picker Options
//Create a list/array of css classes and id's that you want to use with the Theme Editor Color Picker

//Gets themoptions
$sqlThemeOpions = mysqli_query($db_conn, "SELECT id, themename, themeoptions, loc_id FROM theme_options WHERE themename='" . themeOption . "' AND loc_id=" . $_GET['loc_id'] . " ");
$rowThemeOpions = mysqli_fetch_array($sqlThemeOpions);

$themeSelector = ['.themebasecolor', '.footerbgcolor', '.headerbgcolor', '.fontcolor'];
$themeProperties = ['background-color', 'background-color', 'background-color', 'font-color'];

//Builds array from themeoptions column
$themOption = explode(',', trim($rowThemeOpions['themeoptions']));

//Generates the CSS
foreach ($themeSelector as $key => $value) {
    echo $themeSelector[$key] . " {" . $themeProperties[$key] . ": " . $themOption[$key] . ";}" . PHP_EOL;
}

?>