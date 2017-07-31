<?php
//This holds the CSS styles, selectors and properties that you want users to edit with a color picker on Admin panel > Settings > Site Options > Theme Editor
//Create 2 Arrays with the variable names $themeCssSelectors, $themeCssProperties
//These values are used in the admin panel to generate the color pickers shown on the Theme Editor
//Example:
//$themeCssSelectors = ['.themebasecolor', '.footerbgcolor', '.headerbgcolor', '.p,h1,h2,h3,h4'];
//$themeCssProperties = ['background-color', 'background-color', 'background-color', 'color'];

$themeCssSelectors = [
    '.themebase-bgcolor,.btn-primary',
    'p,h1,h2,h3,h4,.text-primary,.socialDiv .fa-inverse-socialmedia,.nav-pills>li.active>a,.nav-pills>li.active>a:hover,.nav-pills>li.active>a:focus',
    'a,a:link', 'a:hover,a:focus,.socialDiv .fa-inverse-socialmedia:hover',
    '.themebase-navbarbgcolor',
    '.themebase-footerbgcolor',
    '.themebase-footerbgcolor a'
];
$themeCssProperties = [
    'background',
    'color',
    'color',
    'color',
    'background',
    'background',
    'color'
];
?>