<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{$title}} / TwiGram</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/home.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    {{$header??""}}
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2" id="menu">
            <div style="position: fixed">
                <x-menu/>
            </div>
        </div>
        <div class="col-7" style="padding: 0">
            <div id="header">
                <!--Header-->
                {{$title}}
            </div>
            <div id="body">
                {{$body}}
           </div>
            </div>

        <div class="col-3" id="r_sidebar">
            <div style="position: fixed">
                {{$rsidebar??"Right Sidebar"}}
            </div>
        </div>
    </div>
</div>


</body>
</html>
