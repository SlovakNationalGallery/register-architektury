<div class="container-fluid p-0">
    <div class="row no-gutters align-items-stretch">
        <div class="col-md-4 py-3 border-bl text-center align-items-center">
            <h1 class="ls-2 my-auto">{{ __('header.title') }}</h1>
        </div>
        <div class="col-md-4 border-bl text-center d-flex">
            <form class="px-3 my-auto w-100">
                <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
            </form>
        </div>
        <div class="col-md-4 py-3 border-bl text-center">
            @include('components.langswitch')
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-md-12">
            <nav class="nav nav-justified main-nav">
                <a class="nav-item py-3 ls-2 border-bl nav-link" href="#">{{ __('header.oa') }}</a>
                <a class="nav-item py-3 ls-2 border-bl text-uppercase nav-link" href="#">{{ __('header.architects') }}</a>
                <a class="nav-item py-3 ls-2 border-bl text-uppercase nav-link" href="#">{{ __('header.objects') }}</a>
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
</div>