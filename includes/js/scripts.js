jQuery(document).ready(function( $ ) {

    // FIX NAVBAR WHEN SCROLL...
    (function() {

        var $menu = $('.navbar');
        var origOffsetY = $menu.offset().top;

        function scroll () {
            console.log($(window).scrollTop()+" - "+origOffsetY);
            if ($(window).scrollTop() >= origOffsetY) {
                $menu.addClass('navbar-fixed-top');
                $('.site-navigation').addClass('paddingfix');
            } else {
                $menu.removeClass('navbar-fixed-top');
                $('.site-navigation').removeClass('paddingfix');
            }

            // Slider fade to black when scrolling
            $slider = $('.nextend-loaded');
            opa = 1 - ($(window).scrollTop() / origOffsetY);
            $slider.css({
                opacity: opa
            })
        }
        document.onscroll = scroll;
    })();

});
