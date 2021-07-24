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
                <label for=twig" class="w-100">
                    <textarea class="form-control" name="twig" id="twig" class="twig" placeholder="twig" cols="42" rows="3">{{$twig_draft??""}}</textarea>
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
                <div class="form-check form-group m-2 ms-0">
                    @if(\App\Models\User::query()->find(\Illuminate\Support\Facades\Auth::id())->value("ignore_compiler_warning"))
                        <input class="form-check-input" type="checkbox" name="ignore_warning" id="ignore_warning_checkbox" checked>
                    @else
                        <input class="form-check-input" type="checkbox" name="ignore_warning" id="ignore_warning_checkbox">
                    @endif
                    <label class="form-check-label" for="ignore_warning">
                        Ignore compiler warning
                    </label>
                </div>
                <button type="submit" class="btn btn-primary" style="color: white;">Twig</button>
            </form>
        </div>
        @foreach($twigs as $twig)
            <x-twig :twig="$twig" />
        @endforeach
    </x-slot>
    <x-slot name="exceptionMessage">{{$exceptionMessage??""}}</x-slot>
    <x-slot name="customMessage">{{$customMessage??""}}</x-slot>
</x-layouts>
