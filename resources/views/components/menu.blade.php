<div>
    <ul class="nav flex-column">
        <?php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
            $menuList = [
                "Home" => "",
                "Profile" => Auth::check()?\App\Models\User::find(Auth::id())->value("screen_name"):"Amida_CP",
                "Settings" => "settings"];
        ?>

        @foreach($menuList as $m => $l)
            @if($menu == $m)
                <li class="nav-item">
                    <a class="nav-link element active" aria-current="page" href="/{{$l}}">{{$m}}</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link element" href="/{{$l}}">{{$m}}</a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
