<x-layouts>
    <x-slot name="title">Home</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    </x-slot>
    <x-slot name="menu">Home</x-slot>
    <x-slot name="body">
        <ul class="nav nav-tabs nav-fill">
                @if($mode == "twig")
                    <form action="/search/twig" method="post">
                        @csrf
                        <input type="hidden" name="search" value="{{$search}}">
                        <button class="nav-link active" aria-current="page" type="submit">Twig</button>
                    </form>
                    <form action="/search/user" method="post">
                        @csrf
                        <input type="hidden" name="search" value="{{$search}}">
                        <button class="nav-link" type="submit">User</button>
                    </form>
                @elseif($mode == "user")
                    <form action="/search/twig" method="post">
                        @csrf
                        <input type="hidden" name="search" value="{{$search}}">
                        <button class="nav-link" type="submit">Twig</button>
                    </form>
                    <form action="/search/user" method="post">
                        @csrf
                        <input type="hidden" name="search" value="{{$search}}">
                        <button class="nav-link active" aria-current="page" type="submit">User</button>
                    </form>
                @endif
        </ul>
        @if($mode == "twig")
            @foreach($twigs as $twig)
                <x-twig :twig="$twig" />
            @endforeach
        @elseif($mode == "user")
            @foreach($users as $user)
            @endforeach
        @endif
    </x-slot>
    <x-slot name="search">{{$search}}</x-slot>
    <x-slot name="exceptionMessage">{{$exceptionMessage??""}}</x-slot>
    <x-slot name="customMessage">{{$customMessage??""}}</x-slot>
</x-layouts>
