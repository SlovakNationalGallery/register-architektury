@if (!(Cookie::get('hide_news_ticker') == 'true'))
    @include('components.news-ticker')
@endif

<div class="container-fluid p-0 navbar-expand-md bg-white" id="header">
    <div class="row no-gutters align-items-stretch">
        <div class="d-none d-md-block col-md-12 col-lg-4 py-3 border-bl text-center align-items-center">
            <h1 class="ls-2 lh-base my-auto font-weight-normal">
                <a href="{{ route('home') }}">
                    {{ __('header.title') }}<span class="d-lg-none d-xl-inline"> oA HÚ SAV</span>
                </a>
            </h1>
        </div>
        <div class="col-12 col-md-8 col-lg-4 border-bl text-center d-flex border-left-md-0">
            <button class="navbar-toggler py-3 my-auto" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-menu"></span>
            </button>

            <form class="px-0 px-sm-3 py-sm-0 my-auto w-100" action="{{ route('building.index') }}">
                <div class="input-group border-0">
                    <input type="text" name="search" id="search" class="form-control border-0"
                    placeholder="{{ __('header.search_placeholder')}}"
                    value="{{ request('search') }}"
                    data-objects-title="{{ trans('header.objects') }}"
                    data-architects-title="{{ trans('header.architects') }}"
                    autocomplete="off"
                    autofocus
                    >
                    <div class="input-group-append">
                      <button class="btn bg-transparent" type="submit">
                        <span class="icon-search lead"></span>
                      </button>
                    </div>
                  </div>
            </form>

            <div class="d-block d-sm-none my-auto">
                @foreach(LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                    @if ($localeCode != LaravelLocalization::getCurrentLocale())
                        <a rel="alternate" hreflang="{{ $localeCode }}" title="{{ $properties['native'] }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="px-3 text-uppercase ls-3" >{{ $localeCode }}</a>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="d-none d-md-block col-md-4">
            @include('components.langswitch')
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-12">
            <nav class="nav nav-justified main-nav collapse navbar-collapse">
                <a href="{{ route('home') }}" class="nav-item py-3 ls-2 border-bl nav-link d-block d-sm-none">{{ __('header.title') }}</a>
                <a href="{{ route('about.department') }}" class="nav-item py-3 ls-2 border-bottom nav-link {{ Route::is('about.*') ? 'active' : '' }}">{{ __('header.about.index') }}</a>
                <a href="{{ route('architects.index') }}" class="nav-item py-3 ls-2 border-bl text-uppercase nav-link {{ Route::is('architects.*') ? 'active' : '' }}">{{ __('header.architects') }}</a>
                <a href="{{ route('building.index') }}" class="nav-item py-3 ls-2 border-bl text-uppercase nav-link {{ Route::is('building.*') ? 'active' : '' }}">{{ __('header.objects') }}</a>
                <a href="{{ route('collections.index') }}" class="nav-item py-3 ls-2 border-bl text-uppercase nav-link {{ Route::is('collections.*') ? 'active' : '' }}">{{ __('header.collections') }}</a>
            </nav>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-12">
            {{-- fields below should be taken from "featured" collections and translated within them --}}
            <nav class="nav nav-justified sub-nav collapse navbar-collapse">
                @php $unplanned_city_slug = 'unintended-city-architectural-and-town-planning-conceptions-of-19th-and-20th-century-in-the-urban-structure-of-bratislava' @endphp
                <a class="nav-item py-3 ls-3 border-bl nav-link {{ Route::is('about.projects.show') && $project->slug == 'docomomo' ? 'active' : '' }}" href="{{ route('about.projects.show', 'docomomo') }}" title="Do.co,mo.mo">Do.co,mo.mo</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link md-text-truncate {{ Route::is('about.projects.show') && $project->slug == $unplanned_city_slug ? 'active' : '' }}" href="{{ route('about.projects.show', $unplanned_city_slug) }}" title="{{ __('header.featured.unplanned_city') }}">{{ __('header.featured.unplanned_city') }}</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link {{ Route::is('about.projects.show') && $project->slug == 'momowo' ? 'active' : '' }}" href="{{ route('about.projects.show', 'momowo') }}" title="MoMoWo">MoMoWo</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link {{ Route::is('about.projects.show') && $project->slug == 'sur' ? 'active' : '' }}" href="{{ route('about.projects.show', 'sur') }}" title="ŠUR">ŠUR</a>
            </nav>
        </div>
    </div>
</div>
@if(Route::is('about.*'))
    <div class="row no-gutters">
        <div class="col-md-12">
            <nav class="nav nav-justified sub-nav bg-light align-items-stretch mt-n1 mt-md-0">
                <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.department') ? 'active' : '' }}" href="{{ route('about.department') }}">{!! __('header.about.department') !!}</a>
                <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.articles.*') ? 'active' : '' }}" href="{{ route('about.articles.index') }}">{{ __('header.about.news') }}</a>
                <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.projects.*') ? 'active' : '' }}" href="{{ route('about.projects.index') }}">{{ __('header.about.projects') }}</a>
                <a class="nav-item d-sm-flex align-items-center justify-content-center py-3 ls-3 border-bl nav-link {{ Route::is('about.publications') ? 'active' : '' }}" href="{{ route('about.publications') }}">{{ __('header.about.publications') }}</a>
            </nav>
        </div>
    </div>
@endif
