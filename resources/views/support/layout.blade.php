<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Bikri Bazzar') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:title" content="buy and sell anything online">
        <meta property="og:url" content="https://www.bikribazzar.com">
        <meta property="og:type" content="website">
         @stack('meta')
         <meta name=”robots” content="index, follow">
         <meta name="author" content="Bibek raut">
         <!-- <meta http-equiv="refresh" content="30"> -->
         <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
         <script  src="{{asset('js/app.js')}}" defer></script>
         <link rel="stylesheet" href="{{asset('css/app.css')}}">
         <link rel="stylesheet" href="{{asset('/custom-css/preloader.css')}}">
    </head>
    <body style="background:#ddd">
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
        <div>
            <div id="app">
                <support-topbar></support-topbar>
                <div>
                    @yield('content')
                     <div class="fb-customerchat"
                            attribution="setup_tool"
                            page_id="106546471305792">
                     </div>
                    </div>
                <support-footer></support-footer>
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
    <script type="text/javascript">

window.URL = "{{config('app.url')}}"
</script>
    
    
    <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    
</html>
