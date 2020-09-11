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
		style: 'mapbox://styles/lab-sng/ckey3tyxr0ak719qgxj4y219b/draft',
		center: center,
		zoom: zoom
	});

	var hoveredBuildingId = null;

	// map.addControl(new mapboxgl.NavigationControl());

	// $.getJSON('/api/markers', function(data) {
    //     data.features.forEach(function(marker) {
    //     	var is_active = (marker.properties.id == active_id) ? 1 : 0;
    //     	initMarker(marker, map, is_active);
    //     });
    // });

	map.on('load', function () {

	 	// Add a GeoJSON source with markers
	 	map.addSource('buildings', {
	 		'type': 'geojson',
	 		'data': '/api/markers',
	 		'generateId': true, // This ensures that all features have unique IDs
	 		'cluster': true,
	 		'clusterMaxZoom': 14, // Max zoom to cluster points on
	 		'clusterRadius': 50 // Radius of each cluster when clustering points (defaults to 50)
		});

		map.addLayer({
			id: 'clusters',
			type: 'circle',
			source: 'buildings',
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
			source: 'buildings',
			filter: ['has', 'point_count'],
			layout: {
				'text-field': '{point_count_abbreviated}',
				'text-font': ['IBM Plex Mono Medium'],
				'text-size': 12
			}
		});

		map.addLayer({
			id: 'unclustered-point',
			type: 'circle',
			source: 'buildings',
			filter: ['!', ['has', 'point_count']],
			paint: {
				'circle-color': '#000000',
				'circle-radius': 7,
				'circle-stroke-width': [
					'case',
					['boolean', ['feature-state', 'hover'], false],
					1,
					3
				],
				// 'circle-stroke-width': 1,
				'circle-stroke-color': '#707070'
			}
		});

		// inspect a cluster on click
		map.on('click', 'clusters', function (e) {
			var features = map.queryRenderedFeatures(e.point, {
				layers: ['clusters']
			});
			var clusterId = features[0].properties.cluster_id;
			map.getSource('buildings').getClusterExpansionZoom(
				clusterId,
				function (err, zoom) {
					if (err) return;

					map.easeTo({
						center: features[0].geometry.coordinates,
						zoom: zoom
					});
				}
			);
		});

		// When a click event occurs on a feature in
		// the unclustered-point layer, open a popup at
		// the location of the feature, with
		// description HTML from its properties.
		map.on('click', 'unclustered-point', function (e) {
			var coordinates = e.features[0].geometry.coordinates.slice();

			new mapboxgl.Popup({ offset: 5 })
				.setLngLat(coordinates)
				.setHTML(
					'<div class="d-inline-block p-1 pt-2"><a href="' + e.features[0].properties.url + '" class="link-no-underline">' + e.features[0].properties.title + '</a></div>'
					)
				.addTo(map);
		});

		// hover clusters
		map.on('mouseenter', 'clusters', function () {
			map.getCanvas().style.cursor = 'pointer';
		});
		map.on('mouseleave', 'clusters', function () {
			map.getCanvas().style.cursor = '';
		});

		// hover points
		map.on('mousemove', 'unclustered-point', function (e) {
			map.getCanvas().style.cursor = 'pointer';
			if (e.features.length > 0) {
				if (hoveredBuildingId) {
					map.setFeatureState(
						{ source: 'buildings', id: hoveredBuildingId },
						{ hover: false }
					);
				}
				hoveredBuildingId = e.features[0].id;
				map.setFeatureState(
					{ source: 'buildings', id: hoveredBuildingId },
					{ hover: true }
				);
			}
		});

		map.on('mouseleave', 'unclustered-point', function () {
			map.getCanvas().style.cursor = '';

			if (hoveredBuildingId) {
				map.setFeatureState(
					{ source: 'buildings', id: hoveredBuildingId },
					{ hover: false }
				);
			}
			hoveredBuildingId = null;
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