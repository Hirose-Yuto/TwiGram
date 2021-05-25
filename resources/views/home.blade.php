<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{asset('css/home.css')}}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>

<!-- ToDo:サイドバー化-->
<x-menu/>

    <form action="/" method="post">
        @csrf
        <label for=twig">
            <textarea name="twig" id="twig" class="twig" placeholder="twig" cols="42" rows="3"></textarea>
        </label><br>
        <label for="lang">
            <select name="lang" class="form-select" aria-label="Default select example">
                @foreach(config("languages.languageList") as $key => $lang)
                    <option value={{$key}}>{{$lang}}</option>
                @endforeach
            </select>
        </label>
        <button type="submit" class="submitTwig">Twig</button>
    </form>

    <p>{!! nl2br(e($twig??"")) !!}</p>

</body>
</html>
