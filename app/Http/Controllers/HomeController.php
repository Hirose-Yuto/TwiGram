<?php

namespace App\Http\Controllers;

use App\Exceptions\ProgramExecutionException;
use App\Models\Twig;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ProgramExecution\ProgramExecutor;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FollowFollowedRelationshipController as FFController;
use App\Http\Controllers\TwigController;
use const http\Client\Curl\AUTH_ANY;

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

    /**
     * タイムライン表示
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function timeline() {
        $data = [
            "twigs" => TwigController::getFollowingUserTwigs(Auth::id()),
        ];
        return view("home", $data);
    }

    /**
     * 投稿したものの処理を行う
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function twig(Request $request){
        // validation
        $request->validate([
            "twig" => "required"
        ]);

        // リクエストを処理
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
            "reply_for" => null,
            "is_retwig" => false,
            "retwig_comment" => null,
            "retwig_from" => null,
        ];
        Twig::query()->create($data);


        return $this->timeline();
    }

}
