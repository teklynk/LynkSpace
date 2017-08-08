<?php
//This holds the CSS styles, selectors and properties that you want users to edit with a color picker on Admin panel > Settings > Site Options > Theme Editor
//Create 2 Arrays with the variable names $themeCssSelectors, $themeCssProperties
//These values are used in the admin panel to generate the color pickers shown on the Theme Editor
//Example:
//$themeCssLabels =['Base Color','Fonts','Links']
//$themeCssSelectors = ['.themebasecolor', '.p,h1,h2,h3,h4', 'a'];
//$themeCssProperties = ['background-color', 'color', 'color'];

$themeCssLabels = [
    'Navbar Header',
    'Navbar Header: Links',
    'Navbar Main',
    'Navbar Main: Links',
    'Footer',
    'Footer: Links',
    'Buttons',
    'Icons'
];
$themeCssSelectors = [
    '.nav-header',
    '.navbar-Search>li>a,.navbar-Search>li>a:focus,.navbar-Search>li>a:hover',
    '.nav-top',
    '.navbar-default .navbar-nav>li>a,.navbar-default .navbar-nav>li>a:focus,.navbar-default .navbar-nav>li>a:hover',
    'footer',
    '.navbar-Footer>.nav-Footer>a,.navbar-Footer>.nav-Footer>a:focus,.navbar-Footer>.nav-Footer>a:hover,.nav-Footer>.cat-links>a',
    '.btn-primary,.btn-default,#hottitlesTabs .nav-pills>li a',
    '.database-item .media-object, .service-item .media-object,.socialDiv>a'
];
$themeCssProperties = [
    'background-color',
    'color',
    'background-color',
    'color',
    'background-color',
    'color',
    'background-color',
    'color'
];
?>