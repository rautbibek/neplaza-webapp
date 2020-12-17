<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('custom-css/style.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('custom-css/adminLogin.css')}}" class="rel">
    <link rel="stylesheet" href="{{asset('css/app.css')}}" class="rel">
    <!-- <link rel="stylesheet" href="{{asset('custom-css/preloader.css')}}" class="rel"> -->
        <!-- Fonts -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        
    </head>
<body>
    <div id="admin-app">
        <div >
            @yield('content')
        </div>
    </div>
</body>
{{-- script part --}}
    
<!-- <script src="{{asset('js/app.js')}}"></script> -->
<script type="text/javascript">
    // Show/hide password onClick of button using Javascript only

// https://stackoverflow.com/questions/31224651/show-hide-password-onclick-of-button-using-javascript-only

function show() {
    var p = document.getElementById('pwd');
    p.setAttribute('type', 'text');
}

function hide() {
    var p = document.getElementById('pwd');
    p.setAttribute('type', 'password');
}

var pwShown = 0;

document.getElementById("eye").addEventListener("click", function () {
    if (pwShown == 0) {
        pwShown = 1;
        show();
    } else {
        pwShown = 0;
        hide();
    }
}, false);


</script>
</html>
