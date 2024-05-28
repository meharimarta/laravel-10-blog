<!doctype html>
<html>
<head>
    @yield('ogmeta')
    <meta name="viewport" content="width=device-width">
    <meta charset="utf-8">
    <title>ProTech | @yield('title','Home')</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    @section('stylesheets')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/master.css')}}">
    @show
</head>
    <body>
        <div id="app">
<!--            header navigation script file-->
            <div class="nav">
                @yield('navigation')
            </div>
            
            <div class="container">
                @yield('content')
            </div>
            
<!--            sites footeer -->
            <div class="footer">
                @yield('footer')
            </div>
        </div>
        @section('scripts')
        @show
    </body>
</html>