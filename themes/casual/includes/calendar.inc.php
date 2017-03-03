<!-- Calendar iframe -->
<?php
define('inc_access', TRUE);
include_once '../../../db/config.php';
include_once '../../../core/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <script type="text/javascript">
        gcal$perf$serverTime=18;
        gcal$perf$headStartTime=new Date().getTime()
    </script>
    <link type="text/css" rel="stylesheet" href="//calendar.google.com/calendar/static/a1e2b869e252d9695bea868555d963f4embedcompiled_fastui.css">
    <script type="text/javascript">
        function _DumpException(e) { throw e; }
    </script>
    <script type="text/javascript" src="//calendar.google.com/calendar/_/scs/calendar-static/_/js/k=calendar.embed.en.60hWPjRN2-Q.O/m=embed/rt=j/d=1/rs=ANwU0p5kLu_PFJVxIjhGKAOmiqOXB-nrWQ"></script>
    <script>function _onload() {window._init({"features":[1,1,1,1,0,0,0,1,1,0,1,0,1,0,0,0,1,1,0,0,0,1,1,0,1,1,0,1,1,0,0,0,1,0,0,1,1,0,0,1,1,1,1,0,1,0,1,0,0,1,0,0,1,1,0,0,0,0,0,1,1,0,0,1,0,0,0,1,0,1,0,1,1,1,1,0,1,0,1,0,1,0,1,0,0,0,1,1,0,1,1,0,1,0,1,1,1,1,1,1,1,1,1,1,0,0,0,1,1,0],"loggedin":true,"cids":{"jewell-library@globalccs.net":{"color":"#2952a3","access":20,"title":"jewell-library@globalccs.net"}},"view":"month","weekstart":0,"format24hour":false,"dateFieldOrder":0,"preloadStart":"20170225","preloadEnd":"20170407","container":"container","baseUrl":"/","imagePath":"//calendar.google.com/googlecalendar/images/","showNavigation":true,"showDateMarker":true,"showTabs":false,"showCalendarMenu":true,"showCurrentTime":false,"showTz":false,"showPrintButton":false,"showElementsLogo":false,"collapseAllday":false,"showSubscribeButton":false,"embedStyle":"WyJhdDplbWI6c3QiXQo\u003d","proxyUrl":"https://clients6.google.com","calendarApiVersion":"v3","developerKey":"AIzaSyBNlYH01_9Hc5S1J9vuFmu2nUqBZJNAXxs"});}</script>
    <script type="text/javascript">
        var pageLoaded_ = false;
        var clientLibraryLoaded_ = false;

        function clientLibraryLoaded() {
            clientLibraryLoaded_ = true;
            if (pageLoaded_) _onload();
        }

        function pageLoaded() {
            pageLoaded_ = true;
            if (clientLibraryLoaded_) _onload();
        }
    </script>
    <script type="text/javascript" src="//apis.google.com/js/client.js?onload=clientLibraryLoaded"></script>
    <!-- Bootstrap Core CSS CDN -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- Default template CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/core/css/core-style.min.css">
    <!-- theme template CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/themes/<?php echo $themeOption ?>/css/business-casual.min.css">
    <!-- theme template CSS - Do not remove-->
    <link rel="stylesheet" type="text/css" href="//<?php echo $_SERVER['HTTP_HOST'] ?>/themes/<?php echo $themeOption ?>/css/custom-style.min.css">
    <style>
        html, head, body {padding:0; margin:0; border: none; background: transparent; overflow: hidden;}
    </style>
</head>
<body onload="pageLoaded()" style="background:#fff">

<div id="container" style="width:100%" class="locale-en"></div>

</body>
</html>