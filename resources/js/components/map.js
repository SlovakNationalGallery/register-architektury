const mapboxgl = require('mapbox-gl');

mapboxgl.accessToken = process.env.MIX_MAPBOX_TOKEN;

var map_initialised = false;

function initMarker(marker, map) {
	var el = document.createElement('div');
	el.className = 'marker';

	new mapboxgl.Marker(el)
	  .setLngLat(marker.geometry.coordinates)
	  .setPopup(new mapboxgl.Popup({ offset: 20 })
	      .setHTML('<a href="' + marker.properties.url + '" class="mt-2 link-no-underline">' + marker.properties.title + '</a>'))
	  .addTo(map);
}


function initMap() {
	map_initialised = true;

	const map_container = document.querySelector('#map');
	var location = JSON.parse(map_container.dataset.location);
	var popup = new mapboxgl.Popup({ offset: 25 }).setText(map_container.dataset.title);

	const map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: location,
		zoom: 14
	});

	// map.addSource('markers', {
	// 	type: 'geojson',
	// 	data: 'https://www.register-architektury.local/api/markers'
	// });

	// map.addLayer({
	// 	'id': 'markers',
	// 	'type': 'symbol',
	// 	'source': 'markers',
	// 	'layout': {
	// 		'icon-image': 'custom-marker',
	// 		// get the title name from the source's "title" property
	// 		'text-field': ['get', 'title'],
	// 		'text-font': [
	// 			'IBM Plex Mono'
	// 		],
	// 		'text-offset': [0, 1.25],
	// 		'text-anchor': 'top'
	// 	}
	// });

	$.getJSON('/api/markers', function(data) {
        data.features.forEach(function(marker) {
        	initMarker(marker, map)
        });
    });

	// var el = document.createElement('div');
	//  el.className = 'marker';

	// const marker = new mapboxgl.Marker(el)
	// 	.setLngLat(location)
	// 	.setPopup(popup)
	// 	.addTo(map);
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