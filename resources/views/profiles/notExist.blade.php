<x-layouts>
    <x-slot name="title">{{"Profile"}}</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    </x-slot>
    <x-slot name="menu">Profile</x-slot>
    <x-slot name="body">
        <div id="profile">
            <div id="account_header" style="border: thin #203864 solid; text-align: center">

            </div>
            <div id="name_id">
                <span style="font-size: large">{{"@".$screen_name??""}}</span> <br>
            </div>
        </div>
        <div style="text-align: center; padding-top: 50px">
            <h3> This account doesn't exist </h3>
            <h5> <span style="color: darkgray"> Try searching for another. </span> </h5>
        </div>
    </x-slot>
</x-layouts>
