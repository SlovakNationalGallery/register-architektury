const InfiniteScroll = require('infinite-scroll');

$(document).ready(function(){
	if($('.items').length > 0) {
		var infScroll = new InfiniteScroll( '.items', {
			loadOnScroll: false,
			path: '.pagination__next',
			append: '.item',
			history: 'replace',
			status: '.page-load-status',
			button: '.view-more-button',
			scrollThreshold: false,
		});
	}
});