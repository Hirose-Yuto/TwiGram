<div>
    <ul class="nav flex-column">
<?php
    $menuList = [
        "Home" => "",
        "Profile" => "masu1017",
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
