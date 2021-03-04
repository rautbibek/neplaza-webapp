<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <link rel="icon" href="{{asset('image/favicon.ico')}}" type="image/ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <title>{{ config('app.name', 'Bikri Bazzar') }}</title>

    @stack('css')
    <style>
    .custom-control{
      height: 50px !important;
      border:2px solid #2F3B59 !important;
      border-radius:0px !important;
    }
    .button-control{
      height: 50px !important;

    }
    .reg-form-control{

      border:1px solid #2F3B59 !important;
      border-radius:0px !important;
    }
    </style>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('custom-css/styles.css') }}" rel="stylesheet">
    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

</head>
<body >
    <div id="app">
        <div class="l-form">
          
            @yield('content')
      </div>
    </div>

    <script type="text/javascript">
        window.Auth ={!! json_encode(['loggedIn'=>Auth::check(),'user'=>Auth::user()]) !!}
    </script>
    <!-- <script src="{{asset('js/app.js')}}" charset="utf-8"></script> -->

</body>
</html>
