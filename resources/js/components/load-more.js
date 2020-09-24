const InfiniteScroll = require("infinite-scroll");
const { initializeBuildingsCarousels } = require("./buildings-carousel");
const { initializeBuildingCards } = require("./building-card");

$(document).ready(function() {
    if ($(".pagination__next").length > 0) {
        const infScroll = new InfiniteScroll(".items", {
            path: ".pagination__next",
            append: ".item",
            history: "replace",
            status: ".page-load-status",
            button: ".view-more-button",
            scrollThreshold: false
        });

        infScroll.on('append', function(response, path, items) {
            items.forEach(item => initializeBuildingsCarousels(item))
            items.forEach(item => initializeBuildingCards(item))
        })
    }
});
