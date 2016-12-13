$(document).ready(function() {

    //Page Load/Performance Checker
    window.onload = function() {
        //var loadTime = ((window.performance.timing.domComplete- window.performance.timing.navigationStart)/1000)+" sec.";
        var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart;
        console.log('Page load time is '+ loadTime);
        console.log(window.performance);
    };

    //Responsive classes
    $('.content img').addClass('img-responsive');
    $('.content iframe').addClass('embed-responsive-item iframe');
});