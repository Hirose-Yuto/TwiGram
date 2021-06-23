<?php

namespace App\Http\Controllers;

use App\Exceptions\ProgramExecutionException;
use App\Models\Twig;
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
            // 実行結果&実行時間取得
            $program_result = ProgramExecutor::executeProgram($text, $lang_index, $ignoreWarning);
        }catch(ProgramExecutionException $e) {
            // 記録
            $e->report();

            // 表示するエラーメッセージ
            $data = [
                "exceptionMessage" => $e->exceptionMessage,
                "customMessage" => $e->customMessage,
                "twig_draft" => $text,
            ];
            return view("home", $data);
        }

        // twigをDBに登録
        $data = [
            "program" => $text,
            "program_result" => $program_result["program_result"],
            "program_language_id" => $lang_index,
            "execution_time" => $program_result["execution_time"],
            "num_of_likes" => 0,
            "num_of_retwigs" => 0,
            "num_of_retwigs_with_comment" => 0,
            "twig_from" => Auth::id(),
            "reply_for" => null
        ];
        Twig::query()->create($data);

        return view("home", $data);

        // return view("home", ["twig" => $text]);
        //return "<h1>".$text."</h1>";
    }

}
