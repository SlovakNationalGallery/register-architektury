const { Flickity } = require('./carousel');
require('flickity-as-nav-for');
require('flickity-fullscreen');

const caption = document.querySelector('.gallery-carousel-main .caption')

// Initialize main carousel
new Flickity(document.querySelector('.gallery-carousel-main'), {
    pageDots: false,
    lazyLoad: 2,
    fullscreen: true,
    cellSelector: '.carousel-cell',

    on: {
        ready() {
            // Initialize first caption
            caption.innerHTML = this.selectedElement.getAttribute('data-caption')
        },
        change() {
            // Update caption on cell change
            caption.innerHTML = this.selectedElement.getAttribute('data-caption')
        },
        fullscreenChange(isFullScreen) {
            this.cells
            .map(cell => cell.element.querySelector('img'))
            .forEach(img => {

                // Remove size restriction when going fullscreen
                if (isFullScreen) {
                    img.setAttribute('data-default-sizes', img.getAttribute('sizes'))
                    img.setAttribute('sizes', null)
                    return
                }

                // Revert to initial sizes when exiting fullscreen
                img.setAttribute('sizes', img.getAttribute('data-default-sizes'))
            })
        }
    }
})


// Initialize navigation carousel
new Flickity(document.querySelector('.gallery-carousel-nav'), {
    cellAlign: 'left',
    freeScroll: true,
    contain: true,
    prevNextButtons: false,
    pageDots: false,
    setGallerySize: false,
    asNavFor: '.gallery-carousel-main'
})
