@if ($paginator->hasPages())
	<div class="page-load-status">
		<p class="infinite-scroll-request">
			<div class="spinner-border text-dark" role="status">
				<span class="sr-only">{{ __('app.loading') }}Loading...</span>
			</div>
		</p>
		<p class="infinite-scroll-last">{{ __('app.last_page') }}</p>
	</div>

	<div class="d-none">
		<ul class="pagination">
			@if ($paginator->hasMorePages())
				<li><a href="{{ $paginator->nextPageUrl() }}" class="pagination__next" rel="next">@lang('pagination.next')</a></li>
			@else
				<li class="disabled" aria-disabled="true"><span>@lang('pagination.next')</span></li>
			@endif
		</ul>
	</div>

	@if ($paginator->hasMorePages() )
		<a href="#" class="btn btn-outline-dark my-5 view-more-button px-5">
			{!!__('app.load_more')!!}
		</a>
	@endif
@endif