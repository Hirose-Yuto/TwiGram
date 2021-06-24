<x-layouts>
    <x-slot name="title">Twig</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/twig.css') }}">
    </x-slot>
    <x-slot name="menu">Home</x-slot>
    <x-slot name="body">
        <span style="font-size: large">{{$user->user_name}}</span>
        {{"@".$user->screen_name}}
        <p>{!! nl2br(e($twig->program_result)) !!}</p><br>
    </x-slot>
    <x-slot name="exceptionMessage">{{$exceptionMessage??""}}</x-slot>
    <x-slot name="customMessage">{{$customMessage??""}}</x-slot>
</x-layouts>
