<?php
//This holds the CSS styles, selectors and properties that you want users to edit with a color picker on Admin panel > Settings > Site Options > Theme Editor
//Create 2 Arrays with the variable names $themeCssSelectors, $themeCssProperties
//These values are used in the admin panel to generate the color pickers shown on the Theme Editor
//Example:
//$themeCssLabels =['Base Color','Fonts','Links']
//$themeCssSelectors = ['.themebasecolor', '.p,h1,h2,h3,h4', 'a'];
//$themeCssProperties = ['background-color', 'color', 'color'];

$themeCssLabels     = [
	'Base Color',
	'Buttons',
	'Buttons: Hover',
	'Fonts',
	'Links',
	'Links: Hover',
	'Navigation Bar',
	'Navigation Bar: Links',
	'Navigation Bar: Sub-Links',
	'Footer Background',
	'Footer: Fonts',
	'Footer: Links',
	'Alert Box: Background',
	'Alert Box: Font'
];
$themeCssSelectors  = [
	'.themebase-bgcolor,.grad-blue',
	'.btn-primary,ul.nav-pills>li.active>a,ul.nav-pills>li>a',
	'.btn-primary:hover,.btn-primary:focus',
	'p,h1,h2,h3,h4,.text-primary,.service-item .text-primary',
	'a,a:link',
	'a:hover,a:focus,.fa-inverse-socialmedia:hover',
	'.themebase-navbarbgcolor',
	'ul.navbar-Top>li>a,.fa-inverse-socialmedia',
	'.dropdown-menu>li>a',
	'.themebase-footerbgcolor,.footer',
	'#generalinfo>p',
	'ul.navbar-Footer>li>a',
	'.notify-bar',
	'.notify-bar>.text-white'
];
$themeCssProperties = [
	'background',
	'background',
	'background',
	'color',
	'color',
	'color',
	'background',
	'color',
	'color',
	'background',
	'color',
	'color',
	'background',
	'color'
];
?>