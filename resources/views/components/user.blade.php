<div class="user_ff_mode">
    <a href="{{"/".$user->screen_name}}" class="user_at_twig">
        <span style="font-size: large">{{$user->user_name}}</span>
        <span style="color: darkgray">{{"@".$user->screen_name}}</span>
    </a>
    <br>
    {{$user->bio}}
</div>
