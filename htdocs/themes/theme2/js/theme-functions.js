$(document).ready(function (e) {
    $('.search-panel .dropdown-menu').find('a').click(function (e) {
        e.preventDefault();
        var param = $(this).attr("href").replace("#", "");
        var concept = $(this).text();
        $('.search-panel span#search_concept').text(concept);
        $('.input-group #search_param').val(param);
    });

    $(window).scroll(function () {
        var scroll = $(window).scrollTop();

        if (scroll >= 150) {
            $("#topNav").addClass("nav-shrink");
        } else {
            $("#topNav").removeClass("nav-shrink");
        }
    });


});
$(function () {
    $(".navbar-search > .input-group-btn > .dropdown-menu li a").click(function () {

        var selText = $(this).html();

        //working version - for single button //
        //$('.btn:first-child').html(selText+'<span class="caret"></span>');

        //working version - for multiple buttons //
        $(this).parents('.input-group-btn').find('.btn-search').html(selText);

    });
});