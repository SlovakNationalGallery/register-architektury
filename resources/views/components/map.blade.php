<div class="container-fluid p-0 position-relative {{ ($show_map) ? 'vh-38' : '' }}" id="map-container">
    <div class="position-absolute bg-light border-bottom vh-38 w-100 {{ ($show_map) ? '' : 'hide' }}" id="map" data-location="{{ $location }}" data-location="" data-center="" data-zoom=""></div>
    <div class="row no-gutters">
    	  <div class="col-sm-4 order-sm-2 text-sm-right z-index-1 p-3">
        	  <button class="btn btn-outline-dark btn-lg mb-2" id="map-toggle">MAPA</button>
     	  </div>
        <div class="col-sm-8 order-sm-1 z-index-1 p-3">
            @include('components.tags', ['tags' => $tags])
        </div>
	  </div>
</div>