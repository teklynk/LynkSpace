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
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=2.0,user-scalable=yes">
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
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/summertime-style.min.css?v=<?php echo ysmVersion; ?>">

    <!-- Custom over-write  -->
    <link rel="stylesheet" type="text/css" href="<?php echo serverUrlStr; ?>/themes/<?php echo themeOption; ?>/css/custom-style.css">

    <?php
    //Google Analytics UID
    if (!empty(site_analytics)) {
        ?>
        <!-- Google Analytics UID -->
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo site_analytics; ?>']);
            _gaq.push(['_trackPageview']);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <?php
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
<div class="container bannerwrapper">
    <div class="row">
        <div class="pull-right col-lg-12 hidden-sm hidden-xs">
            <!--Google Translate code taken from: https://translate.google.com/manager/website/-->
            <div style="padding-left:10px; padding-top:6px; float:right; min-width:174px;" id="google_translate_element"></div>
            <script type="text/javascript">
                function googleTranslateElementInit() {
                    new google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'ar,en,es,pl,tl,uk,ur,vi,zh-CN',
                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                        autoDisplay: false
                    }, 'google_translate_element');
                }
            </script>
            <!--End Google Translate Code -->
        </div>
    </div>
</div>
<div class="container bannerwrapper">
    <div class="row">
        <div class="pull-left col-xs-12 col-sm-6 col-lg-4 pull-left">
            <?php
            if (!empty($setupLogo)) {
                ?>
                <a href="<?php echo homePageURL; ?>" class="navbar-brand" target="_blank"><img class="pull-left img-nonresponsive" src="uploads/<?php echo $_GET['loc_id']; ?>/<?php echo $setupLogo; ?>" alt="Home" title="Home" border="0"/></a>
                <?php
            }
            ?>
        </div>
        <div class="pull-right col-xs-12 col-sm-6 col-lg-8">
            <?php
            include 'searchpac.inc.php';
            ?>
        </div>
    </div>
</div>

<div class="container bannerwrapper">
    <div class="row">
        <!-- Navigation -->
        <nav class="navbar" id="top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <i class="fa fa-bars fa-2x"></i>
                    <span class="cps-blue toggbutton">MENU</span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="navbar-collapse collapse navTabs navbar-Top" id="navbar-collapse-1">
                <?php
                //EXAMPLE: getNav($navSection,$dropdown,$pull,$sitesearchlink)
                getNav('Top', 'true', 'center', 'false');
                ?>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </div>
</div>


<a name="main-content" tabindex="-1"></a>