require('flickity-as-nav-for');
require('flickity-fullscreen');

$('.card-carousel').each(function(i, obj) {
    const nextButton = $(obj).find('.next-button')[ 0 ];
    const prevButton = $(obj).find('.prev-button')[ 0 ];

    // Initialize main carousel
    new Flickity(obj, {
        prevNextButtons: false,
        pageDots: false,
        lazyLoad: 2,
        fullscreen: false,
        cellSelector: '.carousel-cell',

        on: {
            ready() {
                nextButton.onclick = this.next.bind(this)
                prevButton.onclick = this.previous.bind(this)

                nextButton.disabled = this.selectedIndex === this.slides.length - 1 || this.slides.length === 0
                prevButton.disabled = this.selectedIndex === 0
            },
            change(event, index) {
                nextButton.disabled = this.selectedIndex === this.slides.length - 1 || this.slides.length === 0
                prevButton.disabled = this.selectedIndex === 0
            }
        }
    });
});
