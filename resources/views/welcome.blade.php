<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="{{asset('image/favicon.ico')}}" type="image/ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Bikri Bazzar') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:title" content="buy and sell anything online">
        <meta property="og:url" content="https://www.bikribazzar.com">
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{asset('image/logo.png')}}">
        <meta name="keywords" content="bikribazzar,Bikribazzar,bikri bazzar,house, land, 
            classified website nepal,
         bikes, cars, new bike, old bikes">
         <meta name="description" content="
         BIKRI BAZZAR is a classified website in Nepal where you can buy and sell locally. Find the latest classified ads for realestate, jobs, cars, bikes, furniture, fashion, mobiles and more for sale in Nepal. Find buyers and sellers that suit your need">
         <meta name=”robots” content="index, follow">
         <meta name="author" content="Bibek raut">
         <!-- <meta http-equiv="refresh" content="30"> -->
         <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <style>
            
        </style>
    
    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="rel">
    
       
    </head>
    <body onload="myFunction()" style="margin:0;">
    <div id="fb-root"></div>

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
           myVar = setTimeout(showPage, 100);
        }

        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("myDiv").style.display = "block";
        }
    </script>
<script src="{{asset('js/app.js')}}"></script>

</html>
