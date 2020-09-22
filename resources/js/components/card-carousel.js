require('flickity-as-nav-for');
require('flickity-fullscreen');

$('.card-carousel-main').each(function(i, obj) {
    // const nextButton = $(obj).querySelector('.next-button')
    // const prevButton = $(obj).querySelector('.prev-button')

    // Initialize main carousel
    new Flickity(obj, {
        prevNextButtons: false,
        pageDots: false,
        lazyLoad: 2,
        fullscreen: false,
        cellSelector: '.carousel-cell'
    });
});
