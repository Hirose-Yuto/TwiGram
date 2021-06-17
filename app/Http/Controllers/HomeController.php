<?php

namespace App\Http\Controllers;

use App\Exceptions\ProgramExecutionException;
use Illuminate\Http\Request;
use App\Http\Controllers\ProgramExecution\ProgramExecutor;

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
        $lang = $request->get("lang");

        try {
            $program_result = ProgramExecutor::executeProgram($text, $lang);
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
