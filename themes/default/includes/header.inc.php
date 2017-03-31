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
    <meta http-equiv="refresh" content="3600;URL=index.php?loc_id=<?php echo $_GET['loc_id']; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index,follow">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=2.0,user-scalable=yes">
    <meta name="description" content="<?php echo $setupDescription; ?>">
    <meta name="keywords" content="<?php echo $setupKeywords; ?>">
    <meta name="author" content="<?php echo $setupAuthor; ?>">

    <title><?php echo $theTitle; ?></title>

    <!-- Bootstrap Core CSS CDN -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Custom Fonts CDN -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- JQueryUI CSS CDN -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/cupertino/jquery-ui.min.css">

    <!-- Default CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/css/core-style.min.css">
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/css/core-hottitles.min.css">

    <!-- CSS Template -->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/themes/<?php echo $themeOption ?>/css/cps-style.min.css">

    <!-- Custom over-write  -->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/themes/<?php echo $themeOption ?>/css/custom-style.css">

    <?php
    //Google Analytics UID
    if (!empty($site_analytics)) {
        ?>
        <!-- Google Analytics UID -->
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $site_analytics;?>']);
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

    <!-- jQuery CDN -->
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    <!-- jQuery UI AutoComplete CDN -->
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Google Translate -->
    <script type="text/javascript" language="javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <!-- TLC LS2 search script -->
    <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/js/searchscript.min.js"></script>

    <!-- Core js file-->
    <script type="text/javascript" language="javascript" src="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/js/functions.min.js"></script>

    <!-- TLC search variables -->
    <!-- getSearchString (version #, this, domain, config, branch, searchBoxType [ls2, kids5, kids, classic]?, new window?)-->
    <script type="text/javascript" language="javascript">
        var TLCDomain = "//<?php echo $setupPACURL ?>";
        var TLCConfig = "<?php echo $setupConfig ?>";
        var TLCBranch = "";
        var TLCClassicDomain = "//<?php echo $setupPACURL ?>";
        var TLCClassicConfig = "<?php echo $setupConfig ?>";
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <noscript><p>Javascript is not enabled in your browser.</p></noscript>
</head>

<body>

<!--[if lte IE 9]>
<div id="ie7alertdiv">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger fade in" role="alert" >
                    <button id="btnIE7alertclose" type="button" class="close">
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4>
                        Did you know that your Internet Explorer is out of date?
                    </h4>
                    <p>
                        To get the best possible experience using our site we recommend that you use Google Chrome. To visit the Chrome download page, click the Get Chrome button below.</p>
                    <p>
                        <a href="http://www.google.com/chrome/browser/" target="_blank" class="btn btn-danger">Get Chrome</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<![endif]-->

<!-- Navigation -->
<nav class="navbar navbar-static-top" id="top" role="navigation" style="margin-bottom: 0;">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
                <i class="fa fa-bars fa-2x cps-blue"></i>
                <span class="cps-blue toggbutton">MENU</span>
            </button>
            <a href="http://<?php echo $homePageURL; ?>" class="navbar-brand" target="_blank"><img class="pull-left" src="uploads/<?php echo $_GET['loc_id']; ?>/<?php echo $setupLogo; ?>" width="144" alt="" title="" border="0"/></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="navbar-collapse collapse navTabs navbar-Top" id="navbar-collapse-1">
            <?php
            //EXAMPLE: getNav($navSection,$dropdown,$pull)
            getNav('Top', 'true', 'left');
            ?>
            <div class="socialDiv pull-right hidden-xs" style="min-width:300px;">
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
                <?php include 'socialmedia.inc.php'; ?>
            </div>
            <div style="clear:both;"></div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<a name="main-content" tabindex="-1"></a>
