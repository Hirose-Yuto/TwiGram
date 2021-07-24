<x-layouts>
    <x-slot name="title">{{"@".$user->screen_name}}</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    </x-slot>
    <x-slot name="menu">Profile</x-slot>
    <x-slot name="body">
        <div id="profile">
            <div id="account_header" style="border: thin #203864 solid; text-align: center">

                <h1>ヘッダー予定</h1>
            </div>
            <div class="container-fluid">
                <div class="row" style="margin: 0">
                    <div class="col-6" id="name_id">
                        <span style="font-size: large">{{$user->user_name}}</span> <br>
                        {{"@".$user->screen_name}}
                    </div>
                    <div class="col-6" >
                        <div style="float: right">
                        @switch($followingState)
                            @case("edit")
                            <a id = "follow_state" class="btn btn-outline-dark" href="/edit-profile">Edit Profile</a>
                                @break

                            @case("following")
                                <x-profile.following_followed_button>
                                    <x-slot name="url">/un-follow</x-slot>
                                    <x-slot name="default">Following</x-slot>
                                    <x-slot name="on_hover">Unfollow</x-slot>
                                    <x-slot name="target">{{$user->user_id}}</x-slot>
                                </x-profile.following_followed_button>
                                @break

                            @case("not_following")
                            <x-profile.following_followed_button>
                                <x-slot name="url">/follow</x-slot>
                                <x-slot name="default">Follow</x-slot>
                                <x-slot name="on_hover">Follow</x-slot>
                                <x-slot name="target">{{$user->user_id}}</x-slot>
                            </x-profile.following_followed_button>
                                @break
                        @endswitch

                        @switch($followedState)
                            @case("none")
                            @case("not_following")
                            @break

                            @case("following")
                            <div id="followed_state">Follows you</div>
                            @break
                        @endswitch
                        </div>
                    </div>
                </div>
            </div>
            <div id="bio">
                {!! nl2br(e($user->bio??"")) !!}
            </div>
            <div id="following_followers">
                <a href={{"/".$user->screen_name."/following"}}>{{$following??"0"}} <span style="color: darkgray;">Following</span></a>
                <a href={{"/".$user->screen_name."/followers"}}>{{$followers??"0"}} <span style="color: darkgray;">Followers</span></a>
            </div>
        </div>
        @if($mode == "following")
            <a id="profile_back_button" href={{"/".$user->screen_name}}>戻る<a/>
            @foreach($followed_users as $followed_user)
                <x-user :user="$followed_user" />
            @endforeach
        @elseif($mode === "followers")
            <a id="profile_back_button" href={{"/".$user->screen_name}}>戻る<a/>
            @foreach($following_users as $following_user)
                <x-user :user="$following_user" />
            @endforeach
        @else
            <ul class="nav nav-tabs nav-fill">
                <?php $modes=[
                    "" => "Twigs",
                    "with_replies" => "Twigs & Replies",
                    "likes" => "Likes",
                ]?>
                @foreach($modes as $m => $msg)
                    @if($m == $mode)
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/{{$user->screen_name}}/{{$m}}">{{$msg}}</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/{{$user->screen_name}}/{{$m}}">{{$msg}}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            @switch($mode)
                @case("")
                    @foreach($contents as $twig)
                        <x-twig :twig="$twig" />
                    @endforeach
                @break

                @case("with_replies")
                    @foreach($contents as $twig)
                        <x-twig :twig="$twig" />
                    @endforeach
                @break

                @case("likes")
                    @foreach($contents as $twig)
                        <x-twig :twig="$twig" />
                    @endforeach
                @break
            @endswitch
        @endif
    </x-slot>
</x-layouts>
