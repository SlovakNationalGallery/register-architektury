require('./bootstrap');

const mapboxgl = require('mapbox-gl');

mapboxgl.accessToken = 'pk.eyJ1IjoibGFiLXNuZyIsImEiOiJja2F6YWVoaHYwMnhkMnJtbmY0eWVmeW81In0.6fqLCnBSxXWFdJ2RfaDJCQ';

function initMap() {
	const map_container = document.querySelector('#map');
	var location = JSON.parse(map_container.dataset.location);

	const map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: location,
		zoom: 14
	});
	 
	const marker = new mapboxgl.Marker()
		.setLngLat(location)
		.addTo(map);
}


$(document).ready(function(){
	$('#map-toggle').click(function(){
		if(!$('#map').length){
			return false;
		}
		if(!$('#map').hasClass('hide')){
			$('#map').fadeOut(300,function(){
				$('#map').addClass('hide');
				jQuery(window).trigger('resize');
			});
			$('#menu-map-toggle').closest('li').removeClass('active');
		}else{
			$('#menu-map-toggle').closest('li').addClass('active');
			$('#map').removeClass('hide').fadeIn(300, function(){
				if(!mapAppInitialised){
					initMapApp();
				}
				jQuery(window).trigger('resize');
			});
		}

		return false;
	});

	if($('#map').length){
		initMap();
	}
});