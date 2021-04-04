<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">  
    <link rel="icon" href="{{asset('image/favicon.ico')}}" type="image/ico">  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
    <title>{{ config('app.name', 'BIKRI BAZZAR') }}</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="rel">
    
        <!-- Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
    </head>
<body>
    <div id="app">
         <div class="mt-5">
            @yield('content')
        </div>
    </div>
</body>
{{-- script part --}}
    <script type="text/javascript">
    window.Auth ={!! json_encode([
        'loggedIn' => false,
    ]) !!}
</script>
<script src="{{asset('js/app.js')}}"></script>
</html>
