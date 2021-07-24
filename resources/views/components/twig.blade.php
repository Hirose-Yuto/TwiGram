@if($is_retwig && $twig->program_result == "")
        <span style="color: darkgray; margin-left: 5px;">
                {{$twig_from->user_name."がRetwig"}}
        </span>
    <x-twig :twig="$retwig_from_twig" />
@else
    <div class="twig_at_home" id='twig_{{$twig_id}}'>
    <div onclick="jump('{{$twig_url}}')">
        <object>
            <a href="{{"/".$twig_from->screen_name}}" class="user_at_twig">
                <span style="font-size: large">{{$twig_from->user_name}}</span>
                <span style="color: darkgray">{{"@".$twig_from->screen_name}}</span>
            </a>
        </object>
        <span style="color: darkgray">{{$twig_how_long_ago}}</span>
        @if($twig_from->user_id == $auth_user_id)
            <object onclick="doNothing(arguments[0])">
                <button class="btn btn-secondary" style="float: right" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-html="true" data-content_div_id="more_button_{{$twig_id}}">
                    More
                </button>
            </object>
        @endif

        <p class="twig_body">{!! nl2br(e($twig->program_result)) !!}</p>

    </div>
    @if($is_retwig)
        <div class="retwig_from" onclick="jump('{{$retwig_from->twig_url}}')">
            <span>{{$retwig_from->twig_from->user_name}}</span>
            <span style="color: darkgray">{{"@".$retwig_from->twig_from->screen_name}}</span>
            <span style="color: darkgray">{{$retwig_from->twig_how_long_ago}}</span> <br>
            <div style="padding-left: 5px">
                {!! nl2br(e($retwig_from->twig->program_result)) !!}
            </div>
        </div>
    @endif

    <div class="reply_retwig_like">
        <div class="reply" onclick="replyBox({{$twig_id}})">
            reply
        </div>

        @if($is_userRetwig)
            <?php $retwig_color = "green"; ?>
        @else
            <?php $retwig_color = "black"; ?>
        @endif
        <div class="retwig" onclick="retwigBox({{$twig_id}})">
            <span id="twig_retwig_text_{{$twig_id}}" style="color: {{$retwig_color}}">
                retwig

            </span>
        </div>
        <div class="num_of_retwigs">
            <span id="twig_retwig_num_{{$twig_id}}" style="color: {{$retwig_color}}">
                {{$num_of_retwigs}}
            </span>
        </div>

        @if($is_userLike)
            <?php $like_color = "#DB4437"; ?>
        @else
            <?php $like_color = "black"; ?>
        @endif
        <div id="twig_like_{{$twig_id}}" class="like" onclick="like({{$twig_id}})">
            <span id="twig_like_text_{{$twig_id}}" style="color: {{$like_color}}">
                like
            </span>
        </div>
        <div class="num_of_likes">
            <span id="twig_like_num_{{$twig_id}}" style="color: {{$like_color}}">
                {{$num_of_likes}}
            </span>
        </div>
    </div>

    <div id="retwig_input_{{$twig_id}}" style="display: none">
        <form action="/twig/retwig" method="post">
            @csrf
            <label for=comment">
                <textarea name="comment" id="comment_{{$twig_id}}" class="comment" placeholder="retwig comment" cols="42" rows="3"></textarea>
            </label><br>

            <label for="lang">
                <select name="lang" class="form-select" aria-label="Default select example">
                    @foreach(config("languages.languageList") as $key => $lang)
                        @if(\App\Models\User::query()->find(\Illuminate\Support\Facades\Auth::id())->last_select_program_language_id == $key)
                            <option selected value={{$key}} >{{$lang}}</option>
                        @else
                            <option value={{$key}}>{{$lang}}</option>
                        @endif
                    @endforeach
                </select>
            </label>
            <div class="form-check form-group">
                @if(\App\Models\User::query()->find(\Illuminate\Support\Facades\Auth::id())->value("ignore_compiler_warning"))
                    <input class="form-check-input" type="checkbox" name="ignore_warning" id="ignore_warning_checkbox" checked>
                @else
                    <input class="form-check-input" type="checkbox" name="ignore_warning" id="ignore_warning_checkbox">
                @endif
                <label class="form-check-label" for="ignore_warning">
                    Ignore compiler warning
                </label>
            </div>
            <input type="hidden" name="retwig_from" value="{{$twig_id}}">
            <button type="submit" class="submitRetwig" id="submitRetwig_{{$twig_id}}">Retwig</button>
        </form>
    </div>

    <div id="reply_input_{{$twig_id}}" style="display: none">
        <form action="/twig/reply" method="post">
            @csrf
            <label for=reply">
                <textarea name="reply" id="reply_{{$twig_id}}" class="reply" placeholder="reply" cols="42" rows="3"></textarea>
            </label><br>

            <label for="lang">
                <select name="lang" class="form-select" aria-label="Default select example">
                    @foreach(config("languages.languageList") as $key => $lang)
                        @if(\App\Models\User::query()->find(\Illuminate\Support\Facades\Auth::id())->last_select_program_language_id == $key)
                            <option selected value={{$key}} >{{$lang}}</option>
                        @else
                            <option value={{$key}}>{{$lang}}</option>
                        @endif
                    @endforeach
                </select>
            </label>
            <div class="form-check form-group">
                @if(\App\Models\User::query()->find(\Illuminate\Support\Facades\Auth::id())->value("ignore_compiler_warning"))
                    <input class="form-check-input" type="checkbox" name="ignore_warning" id="ignore_warning_checkbox" checked>
                @else
                    <input class="form-check-input" type="checkbox" name="ignore_warning" id="ignore_warning_checkbox">
                @endif
                <label class="form-check-label" for="ignore_warning">
                    Ignore compiler warning
                </label>
            </div>
            <input type="hidden" name="reply_from" value="{{$twig_id}}">
            <button type="submit" class="submitReply" id="submitReply_{{$twig_id}}">Reply</button>
        </form>
    </div>

</div>
@endif
