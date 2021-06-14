<form id = "following_state" action="{{$url}}" method="post" style="padding-top: 10px;">
    @csrf
    <input type="hidden" name="target" value="{{$target}}">
    <button type="submit" class="btn btn-outline-dark"
            id="ff_button"
            onmouseover="document.getElementById('ff_msg').innerHTML='{{$on_hover}}'"
            onmouseout="document.getElementById('ff_msg').innerHTML='{{$default}}'"
    >
        <div id="ff_msg">
            {{$default}}
        </div>
    </button>
</form>
