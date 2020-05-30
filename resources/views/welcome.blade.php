<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    <link rel="stylesheet" href="{{asset('custom-css/style.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="rel">
        <!-- Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
    </head>
    <body>
        <div id="app">
            <main-component></main-component>       
        </div>
    </body>
    <script type="text/javascript">
        window.Auth ={!! json_encode([
            'loggedIn' => Auth::check(),
            'user'     => Auth::user()
        ]) !!}
    </script>
<script src="{{asset('js/app.js')}}"></script>

</html>
