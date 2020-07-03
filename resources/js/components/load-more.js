const InfiniteScroll = require("infinite-scroll");
const Flickity = require('flickity');

$(document).ready(function() {
    if ($(".pagination__next").length > 0) {
        var infScroll = new InfiniteScroll(".items", {
            loadOnScroll: false,
            path: ".pagination__next",
            append: ".item",
            history: "replace",
            status: ".page-load-status",
            button: ".view-more-button",
            scrollThreshold: false
        });

        infScroll.on('append', function(response, path, items) {

            // Hydrate new flickity carousels
            $(items).find('[data-flickity]').each(function(index, element) {
                new Flickity(element, $(element).data('flickity'))
            })
        })
    }
});
