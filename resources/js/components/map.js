const mapboxgl = require('mapbox-gl');

mapboxgl.accessToken = process.env.MIX_MAPBOX_TOKEN;

var map_initialised = false;

function initMap() {
	map_initialised = true;

	const map_container = document.querySelector('#map');
	var location = JSON.parse(map_container.dataset.location);

	const map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: location,
		zoom: 14
	});

	var el = document.createElement('div');
	 el.className = 'marker';

	const marker = new mapboxgl.Marker(el)
		.setLngLat(location)
		.addTo(map);
}


$(document).ready(function(){
	$('#map-toggle').click(function(){

		if(!$('#map').length){
			return false;
		}

		if(!$('#map').hasClass('hide')) {
			$.post("/map/hide");
			$('#map').fadeOut(300, function(){
				$('#map').addClass('hide');
				$('#map-container').removeClass('vh-38');
				$(window).trigger('resize');
			});
			$('#map-toggle').removeClass('active');
		} else {
			$.post("/map/show");
			$('#map-toggle').addClass('active');
			$('#map-container').addClass('vh-38');
			$('#map').removeClass('hide').fadeIn(300, function(){
				if(!map_initialised){
					initMap();
				}
				$(window).trigger('resize');
			});
		}

		return false;
	});

	if($('#map').length && !$('#map').hasClass('hide')){
		initMap();
	}
});