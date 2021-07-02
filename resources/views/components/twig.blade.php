<div class="twig_at_home">
    <div onclick="jump('{{$twig_url}}')">
        <object>
            <a href="{{"/".$twig_from->screen_name}}" class="user_at_twig">
                <span style="font-size: large">{{$twig_from->user_name}}</span>
                {{"@".$twig_from->screen_name}}
            </a>
        </object>
        {{$twig_how_long_ago}}
        <p>{!! nl2br(e($twig->program_result)) !!}</p>
    </div>

    <div class="reply_retwig_like">
        <div class="reply" onclick="replyBox({{$twig_id}}, {{$auth_user_id}}, '{{csrf_token()}}')">
            reply
        </div>

        @if($is_userRetwig)
            <?php $retwig_color = "green"; ?>
        @else
            <?php $retwig_color = "black"; ?>
        @endif
        <div class="retwig" onclick="retwigBox({{$twig_id}}, {{$auth_user_id}}, '{{csrf_token()}}')">
            <span id="twig_retwig_text_{{$twig_id}}" style="color: {{$retwig_color}}">
                retwig
            </span>
        </div>

        @if($is_userLike)
            <?php $like_color = "#DB4437"; ?>
        @else
            <?php $like_color = "black"; ?>
        @endif
        <div id="twig_like_{{$twig_id}}" class="like" onclick="like({{$twig_id}}, {{$auth_user_id}}, '{{csrf_token()}}')">
            <span id="twig_like_text_{{$twig_id}}" style="color: {{$like_color}}">
                like
            </span>
        </div>

        <iframe name="reply_retwig_like" style="display: none"></iframe>
    </div>
</div>
