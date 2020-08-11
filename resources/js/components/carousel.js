const Flickity = require('flickity');

function initializeCarousels(nodes) {
    $(nodes).find('[data-flickity]').each(function(index, element) {
        new Flickity(element, $(element).data('flickity'))
    })
}

export {
    initializeCarousels,
    Flickity,
}
