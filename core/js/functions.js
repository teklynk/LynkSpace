$(document).ready(function () {
    //Add responsive classes to wysiwyg elements
    $('.container img, #featured img').addClass('img-responsive');
    $('.container iframe, #featured iframe').addClass('embed-responsive-item iframe');

    // Sticky Footer initial page load and resize
    $(window).on('load resize', function () {
        var bodyHeight = $(window).height();
        var navbarHeight = $('.navbar-static-top:first').height();
        var bannerHeight = $('.bannerwrapper:first').height();
        var sitesearchHeight = $('.sitesearch:first').height();
        var searchlocationHeight = $('.searchlocations:first').height();
        var searchpacHeight = $('.searchpac:first').height();
        var databasesHeight = $('.databases:first').height();
        var footerHeight = $('.footer:first').height();
        var calcContentHeight = bodyHeight - navbarHeight - bannerHeight - searchlocationHeight - sitesearchHeight - searchpacHeight - databasesHeight - footerHeight - 300; //change last value to compensate for padding.

        if (calcContentHeight > 0) {
            $('.content:first').css({'min-height': calcContentHeight});
        }
    });

    //Scroll to top button
    //Check to see if the window is top if not then display button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });
    //Click event to scroll to top
    $('.scrollToTop').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 500);

        return false;
    });
});

//Hot titles container and spinner loader
function toggleSrc(rss, loc_id) {
    //Check if hottitlesCarousel container is on the page.
    if ($('#hottitlesCarousel').length) {
        $('#hottitlesCarousel').addClass('loader');
        $('#hottitlesCarousel .carousel-inner').addClass('hidden');
        $('#hottitlesCarousel .carousel-control').addClass('hidden');
        //disables the tabs until request finishes
        $('#hottitlesTabs li.hot-tab a').addClass('disable-anchor');
        setTimeout(function() {
            $.ajax({
                url: 'core/ajax/request_hottitles.php?loc_id='+loc_id+'&rssurl='+rss,
                type: 'GET',
                timeout: 20000, //20 seconds
                success: function(result){
                    $('#hottitlesTabs li.hot-tab a').removeClass('disable-anchor');
                    $('#hottitlesCarousel').removeClass('loader');
                    $('#hottitlesCarousel .carousel-control').removeClass('hidden');
                    $('#hottitlesCarousel .carousel-inner').removeClass('hidden');
                    $('#hottitlesCarousel .carousel-inner').html(result); //show hot titles
                },
                error: function() {
                    $('#hottitlesTabs li.hot-tab a').removeClass('disable-anchor');
                    $('#hottitlesCarousel').removeClass('loader');
                    $('#hottitlesCarousel .carousel-control').removeClass('hidden');
                    $('#hottitlesCarousel .carousel-inner').removeClass('hidden');
                    $('#hottitlesCarousel .carousel-inner').html('Error loading URL.');
                }
            })
        }, 500);
    }
    return false;
}

//Page Load/Performance Checker
window.onload = function () {
    //var loadTime = ((window.performance.timing.domComplete- window.performance.timing.navigationStart)/1000)+" sec.";
    var loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
    console.log('Page load time is ' + loadTime);
    console.log(window.performance);
};