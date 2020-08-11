const Flickity = require('flickity');

function hydrateCarousels(nodes) {
    $(nodes).find('[data-flickity]').each(function(index, element) {
        new Flickity(element, $(element).data('flickity'))
    })
}

export {
    hydrateCarousels,
    Flickity,
}
