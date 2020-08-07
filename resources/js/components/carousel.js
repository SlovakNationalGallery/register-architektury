const Flickity = require('flickity');
require('flickity-imagesloaded');
require('flickity-as-nav-for');
require('flickity-fullscreen');

function hydrateCarousels(nodes) {
    $(nodes).find('[data-flickity]').each(function(index, element) {
        new Flickity(element, $(element).data('flickity'))
    })
}

export {
    hydrateCarousels
}

$(document).ready(function(){
    const main = Flickity.data(document.querySelector('.gallery-carousel-main'))

    main.on('fullscreenChange', isFullscreen => {
        main.cells
            .map(cell => cell.element.querySelector('img'))
            .forEach(img => {
                if (isFullscreen) {
                    img.setAttribute('data-default-sizes', img.getAttribute('sizes'))
                    img.setAttribute('sizes', null)
                    return
                }

                // Revert to initial sizes when exiting fullscreen
                img.setAttribute('sizes', img.getAttribute('data-default-sizes'))
            })
    })
})
