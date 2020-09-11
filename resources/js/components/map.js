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

	// map.addControl(new mapboxgl.NavigationControl());

	// $.getJSON('/api/markers', function(data) {
    //     data.features.forEach(function(marker) {
    //     	var is_active = (marker.properties.id == active_id) ? 1 : 0;
    //     	initMarker(marker, map, is_active);
    //     });
    // });

	map.on('load', function () {

	 	// Add a GeoJSON source with 2 points
	 	map.addSource('points', {
	 		'type': 'geojson',
	 		'data': '/api/markers',
	 		'cluster': true,
	 		'clusterMaxZoom': 14, // Max zoom to cluster points on
	 		'clusterRadius': 50 // Radius of each cluster when clustering points (defaults to 50)
		});

		map.addLayer({
			id: 'clusters',
			type: 'circle',
			source: 'points',
			filter: ['has', 'point_count'],
			paint: {
				// Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
				// with three steps to implement three types of circles:
				//   * Blue, 20px circles when point count is less than 100
				//   * Yellow, 30px circles when point count is between 100 and 750
				//   * Pink, 40px circles when point count is greater than or equal to 750
				'circle-color': [
					'step',
					['get', 'point_count'],
					'#51bbd6',
					10,
					'#f1f075',
					50,
					'#f28cb1'
				],
				'circle-radius': [
					'step',
					['get', 'point_count'],
					20,
					10,
					30,
					50,
					40
				]
			}
		});

		map.addLayer({
			id: 'cluster-count',
			type: 'symbol',
			source: 'points',
			filter: ['has', 'point_count'],
			layout: {
				'text-field': '{point_count_abbreviated}',
				'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
				'text-size': 12
			}
		});

		map.addLayer({
			id: 'unclustered-point',
			type: 'circle',
			source: 'points',
			filter: ['!', ['has', 'point_count']],
			paint: {
				'circle-color': '#11b4da',
				'circle-radius': 7,
				'circle-stroke-width': 1,
				'circle-stroke-color': '#fff'
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