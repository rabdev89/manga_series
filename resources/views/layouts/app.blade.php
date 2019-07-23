<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Manga Site</title>
    {{-- Styles --}}
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/2.5.94/css/materialdesignicons.min.css">
  </head>
  <body>
    <div id="app">
      <nav-bar></nav-bar>
      @yield('content')
    </div>
    <script src="/js/app.js"></script>
  </body>
</html>
