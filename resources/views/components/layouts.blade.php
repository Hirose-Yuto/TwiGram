<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title}} / TwiGram</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/home.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/twig.css') }}">

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/twig.js') }}"></script>
    {{$header??""}}
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2" id="menu">
            <div style="position: fixed">
                <x-menu>
                    <x-slot name="menu">{{$menu}}</x-slot>
                </x-menu>
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

            @if(isset($exceptionMessage) && $exceptionMessage != "")
                <p id="exception" class="rounded">
                    error! <br>
                    {!! nl2br(e($exceptionMessage)) !!}<br>
                    {!! nl2br(e($customMessage)) !!}
                </p>
                <script type="text/javascript" src="{{mix('js/exception.js')}}"></script>
            @endif
        </div>

        <div class="col-3" id="r_sidebar">
            <div style="position: fixed; padding-top: 10px">
                @guest
                    <nav class="nav">
                        @if (Route::has('login'))
                            <a class="nav-link btn btn-outline-dark" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="nav-link btn btn-outline-dark" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </nav>
                @else
                    <li class="nav-item dropdown" style="list-style: none">
                        <!--
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        -->
                        <a class="btn btn-outline-dark" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
                {{$rsidebar??""}}
            </div>
        </div>
    </div>
</div>

</body>
</html>
