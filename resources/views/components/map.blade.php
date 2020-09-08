<div class="container-fluid p-0 position-relative {{ ($show_map) ? 'vh-38' : '' }}" id="map-container">
    <div class="position-absolute bg-light border-bottom vh-38 w-100 {{ ($show_map) ? '' : 'hide' }}" id="map" data-location="{{ json_encode($location) }}" data-center="" data-zoom="" data-title="{{ $title }}"></div>
    <div class="row no-gutters">
    	<div class="col-12 text-sm-right z-index-1 p-3">
            <button class="btn btn-outline-dark btn-lg mb-2 text-uppercase {{ ($show_map) ? 'active' : '' }}" id="map-toggle">{{ __('map.map') }}</button>
     	</div>
	</div>
</div>