$(document).ready(function () {
    //Add responsive classes to wysiwyg elements
    $('.container img, #featured img').addClass('img-responsive img');
    $('iframe, frame, embed, video, object').wrap("<div class='embed-responsive embed-responsive-16by9'/>");
    $('iframe, frame, embed, video, object').addClass('embed-responsive-item iframe');
    $('table, frameset').addClass('table-responsive');

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
        setTimeout(function () {
            $.ajax({
                url: 'core/ajax/request_hottitles.php?loc_id=' + loc_id + '&rssurl=' + rss,
                type: 'GET',
                timeout: 10000, //10 seconds
                tryCount: 0,
                retryLimit: 2,
                success: function (result) {
                    $('#hottitlesTabs li.hot-tab a').removeClass('disable-anchor');
                    $('#hottitlesCarousel').removeClass('loader');
                    $('#hottitlesCarousel .carousel-control').removeClass('hidden');
                    $('#hottitlesCarousel .carousel-inner').removeClass('hidden');
                    $('#hottitlesCarousel .carousel-inner').html(result); //show hot titles
                },
                error: function () {
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        return;
                    }
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