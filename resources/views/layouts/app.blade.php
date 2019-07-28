<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="referrer" content="no-referrer"/>
    <title>@yield('title') | Manga Series</title>
      <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet" type="text/css">
      <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
      <style>
        body {
          background-color:#020d18;
        }
        #app {
          background-color:#020d18;
          background-image: url('/img/background.jpg');
          background-repeat:no-repeat;
          background-size: auto;
          min-height:100vh;
          position: relative;
          padding-bottom:115px;
        }
        .container {
          margin-right: auto;
          margin-left: auto;
          padding-left: 15px;
          padding-right: 15px;
        }
        a {
          text-decoration: inherit;
          color:inherit;
        } 
        a:hover, footer a {
          text-decoration: underline;
          color:#dcf836;
        }
        footer {
          position:absolute;
          bottom:0;
          background-color: #0b1a2a;
          border-top: 1px solid #172533;
          color: white;
          width: 100%;
          padding: 10px 0;
          height: 55px;
          text-align: center;
          font-size: 95%;
        }
        
        /*Small devices*/
        @media (min-width: 600px) {
          #app {
            background-size:contain;
          }
          .container {
            padding-left: 15px;
            padding-right: 15px;
          }
        }
        /*Medium devices*/
        @media (min-width: 1022px) {
          .container {
            margin:0 auto;
            width: 970px;
          }
        }
        /*Large devices*/
        @media (min-width: 1919px) {
          .container {
            margin:0 auto;
            width: 1170px;
          }
        }
      </style>
  </head>
  <body>
    <div id="app">
      <div class="container">
        <nav-bar></nav-bar>
        <search-bar></search-bar>
        @yield('content')
      </div>
      <footer>
        <p>Designed by <a href="https://www.findmattfinnigan.com">Matt Finnigan</a></p>
      </footer>
    </div>
    <script src="/js/app.js"></script>
  </body>
</html>
