<?php
//This holds the CSS styles, selectors and properties that you want users to edit with a color picker on Admin panel > Settings > Site Options > Theme Editor
//Create 2 Arrays with the variable names $themeCssSelectors, $themeCssProperties
//These values are used in the admin panel to generate the color pickers shown on the Theme Editor
//Example:
//$themeCssLabels =['Base Color','Fonts','Links']
//$themeCssSelectors = ['.themebasecolor', '.p,h1,h2,h3,h4', 'a'];
//$themeCssProperties = ['background-color', 'color', 'color'];

$themeCssLabels = [
    'Base Color',
    'Fonts',
    'Links',
    'Links Hover',
    'Navigation Bar',
    'Footer Background',
    'Footer Links'
];
$themeCssSelectors = [
    '.themebase-bgcolor,.btn-primary',
    'p,h1,h2,h3,h4,.text-primary,.socialDiv .fa-inverse-socialmedia,.nav-pills>li.active>a,.nav-pills>li.active>a:hover,.nav-pills>li.active>a:focus',
    'a,a:link',
    'a:hover,a:focus,.socialDiv .fa-inverse-socialmedia:hover',
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