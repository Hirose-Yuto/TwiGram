<x-layouts>
    <x-slot name="title">Edit Profile</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    </x-slot>
    <x-slot name="menu">Profile</x-slot>
    <x-slot name="body">
        <form action="/edit-profile" method="post">
            @csrf
            <label for=bio">
                <textarea name="bio" id="bio" class="bio" placeholder="bioを入力してください" cols="42" rows="3" >
                    bioを入力してください
                </textarea>
            </label><br>
            <button type="submit" class="submitTwig">Update</button>
        </form>
    </x-slot>
</x-layouts>
