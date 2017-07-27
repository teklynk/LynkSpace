<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    if (!defined('inc_access')) {
        die('Direct access not permitted');
    }

    getLocation();

    ?>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="3600; URL=index.php?loc_id=<?php echo $_GET['loc_id']; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0,user-scalable=yes">
    <meta property="og:title" content="<?php echo $theTitle; ?>"/>
    <meta property="og:url" content="<?php echo serverUrlStr; ?>"/>
    <meta property="og:site_name" content="<?php echo $theTitle; ?>"/>
    <meta property="og:description" content="<?php echo $theTitle; ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:image" content="<?php getLogo($_GET['loc_id'], 'absolute'); ?>"/>
    <meta name="description" content="<?php echo $setupDescription; ?>">
    <meta name="keywords" content="<?php echo $setupKeywords; ?>">
    <meta name="author" content="<?php echo $setupAuthor; ?>">

    <title><?php echo $theTitle; ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/images/favicon.ico">

    <!-- Core CSS Libraries -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/main.min.css?v=<?php echo ysmVersion; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/font-awesome.min.css?v=<?php echo ysmVersion; ?>">

    <!-- Default CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/core/css/core-style.min.css?v=<?php echo ysmVersion; ?>">

    <!-- CSS Template -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/default-style.min.css?v=<?php echo ysmVersion; ?>">

    <!-- Custom over-write  -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/custom-style.css">

    <?php
    //Google Analytics UID
    if (!empty(site_analytics)) {
        getGoogleAnalyticsTrackingCode(site_analytics);
    }
    ?>

    <!-- Core JS Libraries -->
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/main.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- TLC LS2 search script -->
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/searchscript.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- Core js file-->
    <script type="text/javascript" language="javascript" src="<?php echo serverUrlStr; ?>/core/js/functions.min.js?v=<?php echo ysmVersion; ?>"></script>

    <!-- TLC search variables -->
    <!-- getSearchString (version #, this, domain, config, branch, searchBoxType [ls2, kids5, kids, classic]?, new window?)-->
    <script type="text/javascript" language="javascript">
        var TLCDomain = "<?php echo setupPACURL; ?>";
        var TLCConfig = "<?php echo $setupConfig; ?>";
        var TLCBranch = "";
        var TLCClassicDomain = "<?php echo setupPACURL; ?>";
        var TLCClassicConfig = "<?php echo $setupConfig; ?>";

        //scroll detect
        $(window).scroll(function() {
            var scroll = $(window).scrollTop();

            if (scroll >= 150) {
                $("#topNav").addClass("nav-shrink");
            } else {
                $("#topNav").removeClass("nav-shrink");
            }
        });
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <noscript>Javascript is not enabled in your browser.</noscript>
</head>

<body>

<!--[if lte IE 9]>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-danger fade in" role="alert" >
                <h4>Did you know that your Internet Explorer is out of date?</h4>
                <p>To get the best possible experience using our site we recommend that you use Google Chrome. To visit the Chrome download page, click the Get Chrome button below.</p>
                <p><a href="https://www.google.com/chrome/browser/" target="_blank" class="btn btn-danger">Get Chrome</a></p>
            </div>
        </div>
    </div>
</div>
<![endif]-->

<!-- Navigation -->
<nav class="navbar navbar-fixed-top" id="topNav" role="navigation" style="margin-bottom: 0;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                <i class="fa fa-bars fa-2x"></i>
                <span class="toggbutton">MENU</span>
            </button>
            <a href="<?php echo homePageURL; ?>" class="navbar-brand" target="_blank"><img class="pull-left img-nonresponsive" src="<?php getLogo($_GET['loc_id'], 'relative'); ?>" alt="Home" title="Home" border="0"/></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse navTabs navbar-Top" id="navbar-collapse-1">
            <?php
            //EXAMPLE: getNav($navSection,$dropdown,$pull)
            getNav('Top', 'true', 'left');
            ?>
            <div class="socialDiv pull-right hidden-xs hidden-sm">
                <?php
                getGoogleTranslateCode('ar,en,es,fr,pl,tl,uk,ur,vi,zh-CN');
                ?>

                <?php include 'socialmedia.inc.php'; ?>
            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<a name="main-content" tabindex="-1"></a>