<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

  <body>
    <div id="app">
        @yield('content')
    </div>
    <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    @stack('scripts')
  </body>
</html>
