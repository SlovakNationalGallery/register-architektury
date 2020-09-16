<div class="container-fluid p-0 position-relative {{ ($show_map) ? 'vh-38' : '' }}" id="map-container">
    <div class="position-absolute bg-light border-bottom vh-38 w-100 {{ ($show_map) ? '' : 'hide' }}" id="map" data-center="{{ json_encode($center) }}" data-zoom="{{ $zoom }}" data-active_id="{{ $active_id ?? 0 }}"></div>
    <div class="row no-gutters">
    	<div class="col-12 text-right z-index-1 p-3">
            <button class="btn btn-outline-dark btn-lg mb-2 text-uppercase {{ ($show_map) ? 'active' : '' }}" id="map-toggle">{{ __('map.map') }}</button>
     	</div>
	</div>
</div>