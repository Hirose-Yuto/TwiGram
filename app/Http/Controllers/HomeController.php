<?php

namespace App\Http\Controllers;

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

        return ProgramExecutor::executeProgram($text, $lang);


        // return view("home", ["twig" => $text]);
        //return "<h1>".$text."</h1>";
    }

}
