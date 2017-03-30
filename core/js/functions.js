$(document).ready(function () {
    
    //Add responsive classes to wysiwyg elements
    $('.content img, #featured img').addClass('img-responsive');
    $('.content iframe, #featured iframe').addClass('embed-responsive-item iframe');

    // Sticky Footer initial page load and resize
    $(window).on('load resize', function () {
        var bodyHeight = $(window).height();
        var navbarHeight = $('.navbar-static-top:first').height();
        var bannerHeight = $('.bannerwrapper:first').height();
        var searchlocationHeight = $('.searchlocations:first').height();
        var searchpacHeight = $('.searchpac:first').height();
        var databasesHeight = $('.databases:first').height();
        var footerHeight = $('.footer:first').height();
        var calcContentHeight = bodyHeight - navbarHeight - bannerHeight - searchlocationHeight - searchpacHeight - databasesHeight - footerHeight - 300; //change last value to compensate for padding.

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

    //Hot Titles carousel
    $('#hottitlesCarousel .carousel-inner .item').each(function () {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        var next2 = next.next();
        if (!next2.length) {
            next2 = $(this).siblings(':first');
        }
        next2.children(':first-child').clone().appendTo($(this));

        var next3 = next2.next();
        if(!next3.length){
            next3 = $(this).siblings(':first');
        }
        next3.children(':first-child').clone().appendTo($(this));
    });

});

function toggleSrc(loc, count) {
    $('#hottitlesCarousel').addClass('loader');
    $('#hottitlesCarousel .carousel-inner').addClass('hidden');
    $('#hottitlesCarousel .carousel-control').addClass('hidden');

    //$('#hottitlesTabs').addClass('hidden');
    
    $.ajax({
        url: '../core/ajax/request_hottitles.php?loc_id=1&rssurl='+loc,
        success: function(result){
        $('#hottitlesCarousel').removeClass('loader');
        $('#hottitlesCarousel .carousel-control').removeClass('hidden');
        $('#hottitlesCarousel .carousel-inner').removeClass('hidden');
        $('#hottitlesCarousel .carousel-inner').html(result); //show hot titles
        //$('#hottitlesTabs').removeClass('hidden');
    }});
}

//Page Load/Performance Checker
window.onload = function () {
    //var loadTime = ((window.performance.timing.domComplete- window.performance.timing.navigationStart)/1000)+" sec.";
    var loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
    console.log('Page load time is ' + loadTime);
    console.log(window.performance);
};