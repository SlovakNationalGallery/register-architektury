require('./bootstrap');

const mapboxgl = require('mapbox-gl');

mapboxgl.accessToken = 'pk.eyJ1IjoibGFiLXNuZyIsImEiOiJja2F6YWVoaHYwMnhkMnJtbmY0eWVmeW81In0.6fqLCnBSxXWFdJ2RfaDJCQ';

const map = new mapboxgl.Map({
	container: 'map',
	style: 'mapbox://styles/mapbox/streets-v11',
	center: [17.1144454, 48.1436024],
	zoom: 14
});
 
const marker = new mapboxgl.Marker()
	.setLngLat([17.1144454, 48.1436024])
	.addTo(map);