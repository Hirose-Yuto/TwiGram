<x-layouts>
    <x-slot name="title">Twig</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/twig.css') }}">
    </x-slot>
    <x-slot name="menu">Home</x-slot>
    <x-slot name="body">
        <div style=" border-bottom-color: #203864; border-bottom-style: solid; border-width: thin; padding-bottom: 10px">
            <div style="margin: 38px 15px 15px;">
                <span style="font-size: larger">{{$user->user_name}}</span><br>
                <span style="color: darkgray">{{"@".$user->screen_name}}</span>

                <p style="font-size: x-large">{!! nl2br(e($twig->program_result)) !!}</p><br>
            </div>
            @if($user->user_id == \Illuminate\Support\Facades\Auth::id())
                <object onclick="doNothing(arguments[0])">
                    <button class="btn btn-secondary" style="float: right" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-html="true" data-content_div_id="more_button_{{$twig->twig_id}}">
                        More
                    </button>
                </object>
            @endif

            <div class="reply_retwig_like">
                <div class="reply" onclick="replyBox({{$twig->twig_id}}, {{\Illuminate\Support\Facades\Auth::id()}}, '{{csrf_token()}}')">
                    reply
                </div>

                @if($is_userRetwig)
                    <?php $retwig_color = "green"; ?>
                @else
                    <?php $retwig_color = "black"; ?>
                @endif
                <div class="retwig" onclick="retwigBox({{$twig->twig_id}}, {{\Illuminate\Support\Facades\Auth::id()}}, '{{csrf_token()}}')">
                <span id="twig_retwig_text_{{$twig->twig_id}}" style="color: {{$retwig_color}}">
                    retwig

                </span>
                </div>
                <div class="num_of_retwigs">
                <span id="twig_retwig_num_{{$twig->twig_id}}" style="color: {{$retwig_color}}">
                    {{$twig->num_of_retwigs}}
                </span>
                </div>

                @if($is_userLike)
                    <?php $like_color = "#DB4437"; ?>
                @else
                    <?php $like_color = "black"; ?>
                @endif
                <div id="twig_like_{{$twig->twig_id}}" class="like" onclick="like({{$twig->twig_id}}, {{\Illuminate\Support\Facades\Auth::id()}}, '{{csrf_token()}}')">
                <span id="twig_like_text_{{$twig->twig_id}}" style="color: {{$like_color}}">
                    like
                </span>
                </div>
                <div class="num_of_likes">
                <span id="twig_like_num_{{$twig->twig_id}}" style="color: {{$like_color}}">
                    {{$twig->num_of_likes}}
                </span>
                </div>
            </div>

            <div id="retwig_input_{{$twig->twig_id}}" style="display: none">
                <form action="/twig/retwig" method="post">
                    @csrf
                    <label for=comment">
                        <textarea name="comment" id="comment_{{$twig->twig_id}}" class="comment" placeholder="retwig comment" cols="42" rows="3"></textarea>
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
                    <input type="hidden" name="retwig_from" value="{{$twig->twig_id}}">
                    <button type="submit" class="submitRetwig" id="submitRetwig_{{$twig->twig_id}}">Retwig</button>
                </form>
            </div>

            <div id="reply_input_{{$twig->twig_id}}" style="display: none">
                <form action="/twig/reply" method="post">
                    @csrf
                    <label for=reply">
                        <textarea name="reply" id="reply_{{$twig->twig_id}}" class="reply" placeholder="reply" cols="42" rows="3"></textarea>
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
                    <input type="hidden" name="reply_from" value="{{$twig->twig_id}}">
                    <button type="submit" class="submitReply" id="submitReply_{{$twig->twig_id}}">Reply</button>
                </form>
            </div>
        </div>
        <h3 style="padding:10px; border-bottom-color: #203864; border-bottom-style: solid; border-width: thin;">
            Replies
        </h3>
        @foreach($replies as $reply)
            <x-twig :twig="$reply" />
        @endforeach

    </x-slot>
    <x-slot name="exceptionMessage">{{$exceptionMessage??""}}</x-slot>
    <x-slot name="customMessage">{{$customMessage??""}}</x-slot>
</x-layouts>
