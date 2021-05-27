<x-layouts>
    <x-slot name="title">Home</x-slot>
    <x-slot name="header">
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    </x-slot>
    <x-slot name="menu">Home</x-slot>
    <x-slot name="body">
        <div id="twig_input">
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
        </div>

        <h1>{!! nl2br(e($twig??"")) !!}</h1>
    </x-slot>
</x-layouts>
