$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#","");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 150) {
            $("#topNav").addClass("nav-shrink");
        } else {
            $("#topNav").removeClass("nav-shrink");
        }
    });
});