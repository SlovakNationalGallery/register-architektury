<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('page_description', 'TODO')">
    <meta property="og:title" content="@yield('page_title', __('app.title'))" />
    <meta property="og:description" content="@yield('page_description', 'TODO')">
    <meta property="og:keywords" content="TODO" />
    <meta property="og:type" content="website" />
    <meta property="og:author" content="http://lab.sng.sk/" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', 'TODO')" />
    <meta property="og:site_name" content="{{ __('app.title') }}" />

    <title>
        @hasSection('title')
           @yield('title') | {{__('app.title')}}
        @else
            {{__('app.title')}}
        @endif
    </title>


    @include('components.favicons')
    @include('components.hreflangs', [
      'localizedURLs' => getLocalizedURLArray(),
    ])

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @stack('styles')
  </head>

  <body class="h-100">
    <div id="app" class="d-flex flex-column h-100">
        <main role="main" class="flex-shrink-0">
            @yield('content')
        </main>

        <footer class="footer mt-auto py-3 border-top">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-auto ls-2">
                        {{ __('app.title') }} <a href="http://www.history.sav.sk/index.php?id=oddelenie-architektury" class="link-underline" target="_blank">{{ __('app.oa_genitive') }}</a> {{ __('app.hu') }} <a href="https://www.sav.sk/" class="link-underline" target="_blank">{{ __('app.sav') }}</a>.
                    </div>
                    <div class="col-md ls-2 text-right">
                        {{ __('app.produced_by') }} <a href="https://lab.sng.sk" class="link-underline" target="_blank">lab.SNG</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    @stack('scripts')
  </body>
</html>
