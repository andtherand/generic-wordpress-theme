(function ($) {
    var _initialized = false,
        $slidesInvoker = $('.flexslider'),
        $window = $(window);

    if ($window.width() >= 600) {
        resizeWindow();
    }
   // $window.resize(resizeWindow);

    function resizeWindow() {

            var $slidesHolder = $slidesInvoker.find('.slides'),
                template = '<li><img src="{{SRC}}"></li>',
                galleryString = '';

            $.each(svs_slider.imgs, function (i, value) {
                galleryString += template.split('{{SRC}}').join(svs_slider.baseurl + value);
            });

            $slidesHolder.append(galleryString);

            $slidesInvoker.flexslider({
                    animation: "slide",
                    controlNav: false,
                    directionNav: false,
                    slideshow: true,
                    slideToStart: 0,
                    slideshowSpeed: 20 * 1000
                }
            );
    }

})(jQuery);