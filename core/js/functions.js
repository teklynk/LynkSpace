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

    //show animated loader until iframe loads
    //$('iframe').load(function(){
    //    $('div.hotContainer').removeClass('loader');
    //    $('.iframe').css('display', 'block');
    //}).show();

    //Hot Titles carousel
    //$('.carousel-inner img').addClass('img-responsive');
    $('.carousel[data-type="multi"] .item').each(function(){
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));

        for (var i=0;i<4;i++) {
            next=next.next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }

            next.children(':first-child').clone().appendTo($(this));
        }
        //$('.hottitlesCarousel.carousel').carousel('pause');
    });

});

function toggleSrc(loc, count) {
    $('iframe.hottitles-iframe').attr('src', loc, count);
    $('.hotContainer').addClass('loader');
    $('.iframe').addClass('hidden');
}

//Page Load/Performance Checker
window.onload = function () {
    //var loadTime = ((window.performance.timing.domComplete- window.performance.timing.navigationStart)/1000)+" sec.";
    var loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
    console.log('Page load time is ' + loadTime);
    console.log(window.performance);
};