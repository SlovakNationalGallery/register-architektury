<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="@yield('page_description', __('app.description'))">
    <meta property="og:title" content="@yield('page_title', __('app.title'))" />
    <meta property="og:description" content="@yield('page_description', __('app.description'))">
    <meta property="og:keywords" content="ustarch, sav, bratislava, slovensko, architekt, register, stavba, dom, byvanie, dielo, pamiatka, docomomo, atrium, slovakia, architect, building, monument, residence" />
    <meta property="og:type" content="website" />
    <meta property="og:author" content="http://lab.sng.sk/" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))" />
    <meta property="og:site_name" content="{{ __('app.title') }}" />

    @if(App::environment('production'))
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179323873-1"></script>
    <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-179323873-1'); </script>
    @endif

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
    <div id="app" class="d-flex flex-column min-vh-100">
        <main role="main" class="flex-fill {{ (isSet($error_number)) ? 'bg-light' : '' }}">
            @yield('content')
        </main>

        <footer class="footer py-3 border-top">
            <div class="container-fluid">
                <div class="row ls-2">
                    <div class="col-md-10">
                        {{ __('app.title') }} <a href="http://www.history.sav.sk/index.php?id=oddelenie-architektury" class="link-underline" target="_blank">{{ __('app.oa_genitive') }}</a> {{ __('app.hu') }} <a href="https://www.sav.sk/" class="link-underline" target="_blank">{{ __('app.sav') }}</a>. {{ __('app.financial_support') }}
                    </div>
                    <div class="col-12 mt-3 order-lg-first">
                        <ul class="list-unstyled">
                            <li>
                                <a href="https://www.facebook.com/oAoddeleniearchitektury/" class="link-underline">Facebook</a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/oddelenie_architektury/" class="link-underline">Instagram</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-2 text-lg-right">
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
