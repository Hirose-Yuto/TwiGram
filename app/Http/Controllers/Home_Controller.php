<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ProgramExecution\ProgramExecutor;

class Home_Controller extends Controller
{
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
