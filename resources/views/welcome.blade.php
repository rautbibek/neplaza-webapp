<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Neplaza</title>
        <style>
            body{
                background-color: #f8fafc !important;
            }

            #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background-image: url("{{asset('storage/loading.svg')}}");
            background-repeat: no-repeat;
            background-color: #171f30;
            background-position: center;
            text-align: center;
            align-self: center;
            z-index: 9999;
}
        </style>
    <link rel="stylesheet" href="{{asset('custom-css/style.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('custom-css/preloader.css')}}" class="rel">
        <!-- Fonts -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
    </head>
    <body onload="myFunction()" style="margin:0;">
        <div id="loader">
        </div>
        <div id="myDiv" style="min-height: 300px">
            <div id="app">
                <main-component></main-component>       
            </div>
        </div>
        
    </body>

    {{-- script part --}}
    <script type="text/javascript">
        window.Auth ={!! json_encode([
            'loggedIn' => Auth::check(),
            'user'     => Auth::user()
        ]) !!}
    </script>
    <script>
        let myVar;
        function myFunction() {
           myVar = setTimeout(showPage, 500);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }
    </script>
<script src="{{asset('js/app.js')}}"></script>

</html>
