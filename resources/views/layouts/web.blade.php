<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8">
    
    <title>
            @yield('title','禁毒')
    </title>
    <link type="text/css" rel="stylesheet" href="{{asset('resources/views/web/css/index.css')}}">
    <script type="text/javascript" src="{{asset('resources/views/public/vue.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/web/js/common.js')}}"></script>
</head>
<body>

@hasSection ('body')
@yield('body')
@else
<div class="body" style="width: 100%;">
    <div class="header" style="width: 100%;background: black;">
        @section('headerfont')
        @show
    </div>
    <div class="headerfont">
        @section('headerfont')
        @show
    </div>
     @yield('content')
</div>
@endif 
</body>
</html>