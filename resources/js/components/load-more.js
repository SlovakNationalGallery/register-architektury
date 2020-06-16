const InfiniteScroll = require('infinite-scroll');

$(document).ready(function(){
	if($('.catalog').length >0 ) {
		var infScroll = new InfiniteScroll( '.catalog', {
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