<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="no-referrer"/>
    <title>@yield('title') | Manga Site</title>
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
      <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
      <style>
        #app {
          background-color:#020d18;
          background-image: url('/img/background.jpg');
          background-repeat:no-repeat;
          background-size:cover;
          min-height:100vh;
        }
        .container {
          margin-right: auto;
          margin-left: auto;
          padding-left: 15px;
          padding-right: 15px;
        }
        /*Small devices*/
        @media (min-width: 600px) {
          #app {
            background-size:contain;
          }
        }
      </style>
  </head>
  <body>
    <div id="app">
      <nav-bar></nav-bar>
      <div class="container">
        @yield('content')
      </div>
    </div>
    <script src="/js/app.js"></script>
  </body>
</html>
