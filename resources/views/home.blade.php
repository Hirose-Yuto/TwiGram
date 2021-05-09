<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <form action="/" method="post">
        @csrf
        <label for=twig">
            <input type="text" name="twig" id="twig">
        </label>
        <button type="submit">Twig</button>
    </form>
    <p>{{$twig??""}}</p>
</body>
</html>
