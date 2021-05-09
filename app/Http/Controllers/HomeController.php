<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function timeline() {
        return view("home");
    }

    // 投稿したものの処理を行う
    public function twig(Request $request){
        $request->validate([
            "twig" => "required"
        ]);

        $text = $request->get("twig");

        return view("home", ["twig" => $text]);
        //return "<h1>".$text."</h1>";
    }
}
