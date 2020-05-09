<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('page_description', 'TODO')">
    <meta property="og:title" content="@yield('page_title', __('app.title'))" />
    <meta property="og:description" content="@yield('page_description', 'TODO')">
    <meta property="og:keywords" content="TODO" />
    <meta property="og:type" content="website" />
    <meta property="og:author" content="http://lab.sng.sk/" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="@yield('og_image', 'TODO')" />
    <meta property="og:site_name" content="Register architektúry" />

    <title>@yield('page_title', __('app.title'))</title>

    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @stack('styles')
  </head>

  <body class="h-100">
    <div id="app" class="d-flex flex-column h-100">
        <main role="main" class="flex-shrink-0">
            @yield('content')
        </main>

        <footer class="footer mt-auto py-3 border-top border-dark">
            <div class="container-fluid">
                <span class="ls-1">
                    Register modernej architektúry <a href="http://www.history.sav.sk/index.php?id=oddelenie-architektury" class="link-underline text-dark" target="_blank">Oddelenia architektúry</a> Historického ústavu <a href="https://www.sav.sk/" class="link-underline text-dark" target="_blank">Slovenskej akadémie vied</a>.
                </span>
            </div>
        </footer>
    </div>
    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    @stack('scripts')
  </body>
</html>
