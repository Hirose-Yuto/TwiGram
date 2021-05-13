<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <form action="/" method="post">
        @csrf
        <label for=twig">
            <input type="text" name="twig" id="twig" style="font-size:3em;">
        </label>
        <label for="lang">
            <select name="lang">
                @foreach(config("languages.languageList") as $key => $lang)
                    <option value={{$key}}>{{$lang}}</option>
                @endforeach
            </select>
        </label>
        <button type="submit">Twig</button>
    </form>

    <p>{{$twig??""}}</p>
    <button type="button" class="btn btn-primary">Link</button>
</body>
</html>
