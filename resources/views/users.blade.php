<x-layouts>
    <x-slot name="title">Home</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    </x-slot>
    <x-slot name="menu">Home</x-slot>
    <x-slot name="body">
        @foreach($users as $user)
            <x-user :user="$user" />
        @endforeach
    </x-slot>
    <x-slot name="exceptionMessage">{{$exceptionMessage??""}}</x-slot>
    <x-slot name="customMessage">{{$customMessage??""}}</x-slot>
</x-layouts>
