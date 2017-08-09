<?php
session_start();

if (!defined('inc_access')) {
    die('Direct access not permitted');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php

    getLocation($_GET['loc_id']);

    getCoreHeader($_GET['loc_id']);

    ?>

    <script type="text/javascript" language="javascript">
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            if (scroll >= 150) {
                $("#topNav").addClass("nav-shrink");
            } else {
                $("#topNav").removeClass("nav-shrink");
            }
        });
    </script>

    <!-- CSS Template -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/summertime-style.min.css?v=<?php echo ysmVersion; ?>">
    <!-- Custom over-write  -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/custom-style.min.css?v=<?php echo ysmVersion; ?>">

</head>

<body>

<!--[if lte IE 9]>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger fade in" role="alert" >
                <h4>Did you know that your Internet Explorer is out of date?</h4>
                <p>To get the best possible experience using our site we recommend that you use Google Chrome. To visit the Chrome download page, click the Get Chrome button below.</p>
                <p><a href="https://www.google.com/chrome/browser/" target="_blank" class="btn btn-danger">Get Chrome</a></p>
            </div>
        </div>
    </div>
</div>
<![endif]-->

<!-- Alerts box -->
<?php

//only show on index.php/homepage
if (basename($_SERVER['SCRIPT_FILENAME']) == 'index.php'){

    getEvents($_GET['loc_id']);

    if (!empty($eventAlert && $eventAlertDateCheck == 'true')) {
        echo "<div class='alert fade in notify-bar'><h3 class='text-white'>". $eventAlert ."</h3><button type='button' class='close alert_close_x' data-dismiss='alert'>&times;</button>
        <div><button type='button' class='btn btn-link notify-close text-white' data-dismiss='alert'>(Click to close)</button></div></div>";
    } else {
        echo "<div class='alert notify-bar hidden'></div>";
    }
}
?>

<!-- Navigation -->
<div class="container nav-header">
    <nav id="top" class="navbar-static-top" role="navigation">
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-Search">
            <?php
            //EXAMPLE: getNav($navSection,$dropdown,$pull,$sitesearchlink)
            getNav($_GET['loc_id'], 'Search', 'true', 'right', 'false');
            ?>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>

<div class="container bannerwrapper header-top">
    <div class="pull-left col-xs-12 col-sm-6 col-lg-6">
        <?php
        if (!empty($setupLogo)) {
            ?>
            <a href="<?php echo homePageURL; ?>" class="navbar-brand" target="_blank"><img class="pull-left img-nonresponsive" src="<?php getLogo($_GET['loc_id'], 'relative'); ?>" alt="Home" title="Home" border="0"/></a>
            <?php
        }
        ?>
    </div>
    <div class="pull-right col-xs-12 col-sm-6 col-lg-6">
        <?php
        if ($_GET['loc_id'] == 1 && multiBranch == 'true') {
            include 'searchlocations.inc.php';
        } else {
            include 'searchpac.inc.php';
        }
        ?>
    </div>
</div>

<!-- Navigation -->
<nav id="top" class="container navbar navbar-default nav-top navbar-static-top" role="navigation" id="topNav">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
            <i class="fa fa-bars fa-2x"></i>
            <span class="toggbutton">MENU</span>
        </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse navTabs navbar-Top" id="navbar-collapse-1">
        <?php
        //EXAMPLE: getNav($navSection,$dropdown,$pull,$sitesearchlink)
        getNav($_GET['loc_id'], 'Top', 'true', 'center', 'false');
        ?>
    </div>
    <!-- /.navbar-collapse -->
</nav>


<a name="main-content" tabindex="-1"></a>