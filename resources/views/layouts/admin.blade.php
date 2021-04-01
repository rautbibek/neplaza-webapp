<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">    
    <link rel="icon" href="{{asset('image/favicon.ico')}}" type="image/ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('custom-css/style.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('custom-css/adminLogin.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="rel">
    <!-- <link rel="stylesheet" href="{{asset('custom-css/preloader.css')}}" class="rel"> -->
        <!-- Fonts -->
    
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    </head>
<body>
   <div id="particles-js"> 
        <div class="heading"> 
            @yield('content')
        </div> 
    </div> 
    <script src="{{asset('custom-css/particles.js')}}"> </script> 
    
    <script src="{{asset('custom-css/app.js')}}"> </script> 
</body>

</html>
