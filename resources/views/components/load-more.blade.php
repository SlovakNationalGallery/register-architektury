@if ($paginator->hasPages())
<div class="row my-2 my-sm-3 my-md-4">
  <div class="col-sm-12 text-center">

    <div class="page-load-status">
      <p class="infinite-scroll-request">
        <div class="spinner">
          <div class="double-bounce1"></div>
          <div class="double-bounce2"></div>
        </div>
      </p>
      <p class="infinite-scroll-last">{!! trans('katalog.last_page') !!}</p>
    </div>

    <div class="d-none">
        <ul class="pagination">
            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" class="pagination__next" rel="next">@lang('pagination.next')</a></li>
            @else
                <li class="disabled" aria-disabled="true"><span>@lang('pagination.next')</span></li>
            @endif
        </ul>
    </div>

    @if ($paginator->hasMorePages() )
    <a href="#" class="btn btn-outline-dark btn-big btn-with-icon text-uppercase mb-2 view-more-button">
      <i class="icon-chevron-down"></i>
      {!!__('general.show_more')!!}
    </a>
    @endif


  </div>
</div>
@endif