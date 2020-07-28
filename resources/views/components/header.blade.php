<div class="container-fluid p-0">
    <div class="row no-gutters align-items-stretch">
        <div class="col-md-4 py-3 border-bl text-center align-items-center">
            <h1 class="ls-2 my-auto"><a href="{{ route('home') }}">{{ __('header.title') }}</a></h1>
        </div>
        <div class="col-md-4 border-bl text-center d-flex">
            <form class="px-3 my-auto w-100" action="{{ route('building.index') }}">
                <div class="input-group border-0">
                    <input type="text" name="search" class="form-control border-0" value="{{ request('search') }}" placeholder="Hľadať . . ." >
                    <div class="input-group-append">
                      <button class="btn bg-transparent" type="button">
                        <span class="icon-search lead"></span>
                      </button>
                    </div>
                  </div>
            </form>
        </div>
        <div class="col-md-4 py-3 border-bl text-center">
            @include('components.langswitch')
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-12">
            <nav class="nav nav-justified main-nav">
                <a href="{{ route('about.department') }}" class="nav-item py-3 ls-2 border-bl nav-link {{ Route::is('about.*') ? 'active' : '' }}">{{ __('header.about.index') }}</a>
                <a href="{{ route('architects.index') }}" class="nav-item py-3 ls-2 border-bl text-uppercase nav-link {{ Route::is('architects.*') ? 'active' : '' }}">{{ __('header.architects') }}</a>
                <a href="{{ route('building.index') }}" class="nav-item py-3 ls-2 border-bl text-uppercase nav-link {{ Route::is('building.*') ? 'active' : '' }}" href="#">{{ __('header.objects') }}</a>
                <a class="nav-item py-3 ls-2 border-bl text-uppercase nav-link" href="#">{{ __('header.collections') }}</a>
            </nav>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-12">
            {{-- fields bellow should be taken from "featured" collections and translated within them --}}
            <nav class="nav nav-justified sub-nav">
                <a class="nav-item py-3 ls-3 border-bl nav-link" href="#">MoMoWo</a>
                <a class="nav-item py-3 ls-3 border-bl text-uppercase nav-link" href="#">ATRIUM</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link" href="#">ŠUR</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link" href="#">Do.co,mo.mo</a>
            </nav>
        </div>
    </div>
    @if(Route::is('about.*'))
    <div class="row no-gutters">
        <div class="col-md-12">
            <nav class="nav nav-justified sub-nav bg-light">
                <a class="nav-item py-3 ls-3 border-bl nav-link {{ Route::is('about.department') ? 'active' : '' }}" href="{{ route('about.department') }}">{!! __('header.about.department') !!}</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link {{ Route::is('about.articles.*') ? 'active' : '' }}" href="{{ route('about.articles.index') }}">{{ __('header.about.news') }}</a>
                <a class="nav-item py-3 ls-3 border-bl nav-link {{ Route::is('about.publications') ? 'active' : '' }}" href="{{ route('about.publications') }}">{{ __('header.about.publications') }}</a>
            </nav>
        </div>
    </div>
    @endif
</div>
