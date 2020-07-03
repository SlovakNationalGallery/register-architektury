const InfiniteScroll = require("infinite-scroll");
const { hydrateCarousels } = require("./carousel");

$(document).ready(function() {
    if ($(".pagination__next").length > 0) {
        const infScroll = new InfiniteScroll(".items", {
            loadOnScroll: false,
            path: ".pagination__next",
            append: ".item",
            history: "replace",
            status: ".page-load-status",
            button: ".view-more-button",
            scrollThreshold: false
        });

        infScroll.on('append', function(response, path, items) {
            hydrateCarousels(items);
        })
    }
});
