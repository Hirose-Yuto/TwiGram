<x-layouts>
    <x-slot name="title">{{"@".$screen_name}}</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    </x-slot>
    <x-slot name="menu">Profile</x-slot>
    <x-slot name="body">
        <div id="profile">
            <div id="account_header" style="border: thin #203864 solid; text-align: center">

                <h1>ヘッダー予定</h1>
            </div>
            <div id="name_id">
                <span style="font-size: large">{{$account_name??"名無しさん"}}</span> <br>
                {{"@".$screen_name}}
            </div>
            <div id="bio">
                自己紹介文が入る予定です。<br>
                よろしくおねがいします。
            </div>
            <div id="following_followers">
                {{$following??"0"}} <span style="color: darkgray;">Following</span>
                {{$followers??"0"}} <span style="color: darkgray;">Followers</span>
            </div>
        </div>
        <ul class="nav nav-tabs nav-fill">
            <?php $modes=[
                "" => "Twigs",
                "with_replies" => "Twigs & Replies",
                "media" => "Media",
                "likes" => "Likes",
            ]?>
            @foreach($modes as $m => $msg)
                @if($m == $mode)
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/{{$screen_name}}/{{$m}}">{{$msg}}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/{{$screen_name}}/{{$m}}">{{$msg}}</a>
                    </li>
                @endif
            @endforeach
        </ul>
            {{$profile_body??""}}
    </x-slot>
</x-layouts>
