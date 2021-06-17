<?php

namespace App\Http\Controllers;

use App\Exceptions\ProgramExecutionException;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ProgramExecution\ProgramExecutor;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function timeline() {
        return view("home");
    }

    // 投稿したものの処理を行う
    public function twig(Request $request){
        // validation
        $request->validate([
            "twig" => "required"
        ]);

        $text = $request->get("twig");
        $lang_index = $request->get("lang");
        if($request->get("ignore_warning")) {
            $ignoreWarning = true;
        } else {
            $ignoreWarning = false;
        }

        try {
            $program_result = ProgramExecutor::executeProgram($text, $lang_index, $ignoreWarning);
        }catch(ProgramExecutionException $e) {
            $e->report();
            $data = [
                "exceptionMessage" => $e->exceptionMessage,
                "customMessage" => $e->customMessage,
            ];
            return view("home", $data);
        }

        $data = [
            "twig" => $program_result,
            "twig_draft" => "",
        ];
        return view("home", $data);

        // return view("home", ["twig" => $text]);
        //return "<h1>".$text."</h1>";
    }

}
