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
            </div>

        <div class="col-3" id="r_sidebar">
            <div style="position: fixed">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                {{$rsidebar??"Right Sidebar"}}
            </div>
        </div>
    </div>
</div>


</body>
</html>
