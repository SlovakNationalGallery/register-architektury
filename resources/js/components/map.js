const mapboxgl = require('mapbox-gl');

mapboxgl.accessToken = process.env.MIX_MAPBOX_TOKEN;

var map_initialised = false;

function initMarker(marker, map, is_active = 0) {
	var el = document.createElement('div');
	el.className = 'marker';

	if (is_active) el.className += ' active';

	new mapboxgl.Marker(el)
	  .setLngLat(marker.geometry.coordinates)
	  .setPopup(new mapboxgl.Popup({ offset: 20 })
	      .setHTML('<a href="' + marker.properties.url + '" class="mt-2 link-no-underline">' + marker.properties.title + '</a>'))
	  .addTo(map);
}


function initMap() {
	map_initialised = true;

	const map_container = document.querySelector('#map');
	var center = JSON.parse(map_container.dataset.center);
	var zoom = map_container.dataset.zoom;
	var active_id = map_container.dataset.active_id;

	const map = new mapboxgl.Map({
		container: 'map',
		style: 'mapbox://styles/mapbox/streets-v11',
		center: center,
		zoom: zoom
	});

	$.getJSON('/api/markers', function(data) {
        data.features.forEach(function(marker) {
        	var is_active = (marker.properties.id == active_id) ? 1 : 0;
        	if (marker.geometry.coordinates) {
        		initMarker(marker, map, is_active);
        	}
        });
    });
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