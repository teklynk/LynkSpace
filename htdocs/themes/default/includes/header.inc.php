<?php
session_start();

if ( ! defined( 'ALLOW_INC' ) ) {
	die( 'Direct access not permitted' );
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php

	getLocation( loc_id );

	getCoreHeader( loc_id );

	?>
    <script type="text/javascript" language="javascript">
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll >= 150) {
                $("#topNav").addClass("nav-shrink");
            } else {
                $("#topNav").removeClass("nav-shrink");
            }
        });
    </script>

    <!-- CSS Template -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/default-style.min.css?v=<?php echo ysmVersion; ?>">
    <!-- Custom over-write  -->
    <link rel="stylesheet" type="text/css"
          href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/custom-style.css">

</head>

<body>

<!--[if lte IE 9]>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger fade in" role="alert">
                <h4>Did you know that your Internet Explorer is out of date?</h4>
                <p>To get the best possible experience using our site we recommend that you use Google Chrome. To visit
                    the Chrome download page, click the Get Chrome button below.</p>
                <p><a href="https://www.google.com/chrome/browser/" target="_blank" class="btn btn-danger">Get
                    Chrome</a></p>
            </div>
        </div>
    </div>
</div>
<![endif]-->

<!-- Alerts box -->
<?php

//only show on index.php/homepage
if ( basename( $_SERVER['SCRIPT_FILENAME'] ) == 'index.php' ) {

	getEvents( loc_id );

	if ( ! empty( $eventAlert && $eventAlertDateCheck == 'true' ) ) {
		echo "<div class='alert fade in notify-bar'><h3 class='text-white'>" . $eventAlert . "</h3><button type='button' class='close alert_close_x' data-dismiss='alert'><span>&times;</span></button>
        <div><button type='button' class='btn btn-link notify-close text-white' data-dismiss='alert'>(Click to close)</button></div></div>";
	} else {
		echo "<div class='alert notify-bar hidden'></div>";
	}
}
?>

<!-- Navigation -->
<nav class="navbar navbar-fixed-top themebase-navbarbgcolor" id="topNav" role="navigation" style="margin-bottom: 0;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse-1">
                <i class="fa fa-bars fa-2x"></i>
                <span class="toggbutton">MENU</span>
            </button>
            <a href="<?php echo homePageURL; ?>" class="navbar-brand" target="_blank"><img
                        class="pull-left img-nonresponsive" src="<?php getLogo( loc_id, 'relative' ); ?>"
                        alt="Home" title="Home" border="0"/></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse navTabs navbar-Top" id="navbar-collapse-1">
			<?php
			//EXAMPLE: getNav($navSection,$dropdown,$pull)
			getNav( loc_id, 'Top', 'true', 'left' );
			?>
            <div class="socialDiv pull-right hidden-xs hidden-sm">
				<?php
				getGoogleTranslateCode( 'ar,en,es,fr,pl,tl,uk,ur,vi,zh-CN' );
				?>

				<?php require_once( __DIR__ . '/socialmedia.inc.php' ); ?>
            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<a name="main-content" tabindex="-1"></a>