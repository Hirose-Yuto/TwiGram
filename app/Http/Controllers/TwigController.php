<?php

namespace App\Http\Controllers;

use App\Exceptions\ProgramExecutionException;
use App\Http\Controllers\ProgramExecution\ProgramExecutor;
use Illuminate\Http\Request;
use App\Models\Twig;
use Illuminate\Support\Facades\Auth;

class TwigController extends Controller
{
    /**
     * ツイッグページの表示
     * @param $twig_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function display($twig_id) {
        $twig = self::getTwig($twig_id);
        $user = UserController::getUser($twig->twig_from);
        $data = [
            "twig" => $twig,
            "user" => $user,
        ];
        return view("twigPage", $data);
    }

    /**
     * リツイッグをする。
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function retwig(Request $request) {
        $comment = $request->get("comment");
        if($comment != "") {
            return self::quoteRetwig($request);
        }

        $lang_index = $request->get("lang");
        $retwig_from = $request->get("retwig_from");

        // twigをDBに登録
        $data = [
            "program" => "",
            "program_result" => "",
            "program_language_id" => $lang_index,
            "execution_time" => 0,
            "num_of_likes" => 0,
            "num_of_retwigs" => 0,
            "num_of_retwigs_with_comment" => 0,
            "twig_from" => Auth::id(),
            "reply_for" => null,
            "is_retwig" => true,
            "retwig_comment" => null,
            "retwig_from" => $retwig_from,
        ];
        Twig::query()->create($data);

        self::addNumOfRetwigs($retwig_from);

        return redirect('/', 302, [], env("IS_SECURE"));
    }

    public static function quoteRetwig(Request $request) {
        $comment = $request->get("comment");
        $lang_index = $request->get("lang");
        $retwig_from = $request->get("retwig_from");
        if($request->get("ignore_warning")) {
            $ignoreWarning = true;
        } else {
            $ignoreWarning = false;
        }

        try {
            // 実行結果&実行時間取得
            $program_result = ProgramExecutor::executeProgram($comment, $lang_index, $ignoreWarning);
        }catch(ProgramExecutionException $e) {
            // 記録
            $e->report();

            // 表示するエラーメッセージ
            $data = [
                "exceptionMessage" => $e->exceptionMessage,
                "customMessage" => $e->customMessage,
                "twig_draft" => $comment,
            ];

            //ToDo:Retwig入力画面に戻す
            return view("home", $data);
        }
        // twigをDBに登録
        $data = [
            "program" => $comment,
            "program_result" => $program_result["program_result"],
            "program_language_id" => $lang_index,
            "execution_time" => $program_result["execution_time"],
            "num_of_likes" => 0,
            "num_of_retwigs" => 0,
            "num_of_retwigs_with_comment" => 0,
            "twig_from" => Auth::id(),
            "reply_for" => null,
            "is_retwig" => true,
            "retwig_comment" => null,
            "retwig_from" => $retwig_from,
        ];
        Twig::query()->create($data);

        self::addNumOfRetwigsWithComment($retwig_from);

        return redirect('/', 302, [], env("IS_SECURE"));
    }


    /**
     * ツイッグが存在するか
     * @param int $twig_id
     * @return bool
     */
    public static function exists(int $twig_id): bool {
        return Twig::query()->find($twig_id)->exists();
    }

    /**
     * ツイッグが存在しない
     * @param int $twig_id
     * @return bool
     */
    public static function doesntExists(int $twig_id): bool {
        return Twig::query()->find($twig_id)->doesntExist();
    }

    /**
     * ユーザがリツイッグしたかどうか
     * @param int $twig_id
     * @param int $user_id
     * @return bool
     */
    public static function is_retwigBy(int $twig_id, int $user_id): bool {
        return Twig::query()
            ->where("twig_from", "=", $user_id)
            ->where("is_retwig", "=", true)
            ->where("retwig_from", "=", $twig_id)
            ->exists();
    }

    /**
     * ツイッグを取得。
     * @param int $twig_id
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public static function getTwig(int $twig_id) {
        if(self::exists($twig_id)) {
            return Twig::query()->find($twig_id);
        }
        // ToDo: 例外処理
    }

    /**
     * ユーザのツイッグを取得(リプライは含めない)。
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTwigsWithoutReplies(int $user_id, int $num_of_twigs_to_get = 15) {
        return Twig::query()->where("twig_from", $user_id)
            ->where("reply_for", "=", null)
            ->orderByDesc("updated_at")
            ->take($num_of_twigs_to_get)
            ->get();
    }

    /**
     * ユーザのツイッグを取得(リプライも含める)。
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTwigsIncludingReplies(int $user_id, int $num_of_twigs_to_get = 15) {
        return Twig::query()
            ->where("twig_from", $user_id)
            ->orderByDesc("updated_at")
            ->take($num_of_twigs_to_get)
            ->get();
    }

    /**
     * ユーザがフォローしている人+自分自身のツイッグを取得する。(返信は含まない)
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getFollowingUserTwigs(int $user_id, int $num_of_twigs_to_get = 15) {
        // 返信含まない&自分自身
        $twigs = Twig::query()->where("twig_from", "=", Auth::id())
                              ->where("reply_for", "=", null);


        // フォローしてる人のツイッグ取得
        $followedUsers = FollowFollowedRelationshipController::getUsersFollowedBy($user_id);
        foreach($followedUsers as $followedUser) {
            $twigs->orWhere("twig_from", "=" , $followedUser->user_id);
        }

        return $twigs->orderByDesc("created_at")
                     ->take($num_of_twigs_to_get)
                     ->get();
    }

    /**
     * ふぁぼ数加算。
     * @param int $twig_id
     * @param int $num
     */
    public static function addNumOfLikes(int $twig_id, int $num = 1) {
        if(self::doesntExists($twig_id)) {
            // ToDo:例外処理
        }
        $num_of_likes = Twig::query()->find($twig_id)->num_of_likes;
        $data = [
            "num_of_likes" => $num_of_likes + $num
        ];
        Twig::query()->find($twig_id)->update($data);
    }

    /**
     * リツイッグ数加算。
     * @param int $twig_id
     * @param int $num
     */
    public static function addNumOfRetwigs(int $twig_id, int $num = 1) {
        if(self::doesntExists($twig_id)) {
            // ToDo:例外処理
        }
        $num_of_retwigs = Twig::query()->find($twig_id)->num_of_retwigs;
        $data = [
            "num_of_retwigs" => $num_of_retwigs + $num
        ];
        Twig::query()->find($twig_id)->update($data);
    }

    /**
     * 引用リツイッグ数加算。
     * @param int $twig_id
     * @param int $num
     */
    public static function addNumOfRetwigsWithComment(int $twig_id, int $num = 1) {
        if(self::doesntExists($twig_id)) {
            // ToDo:例外処理
        }
        $num_of_retwigs_with_comment = Twig::query()->find($twig_id)->num_of_retwigs_with_comment;
        $data = [
            "num_of_retwigs_with_comment" => $num_of_retwigs_with_comment + $num
        ];
        Twig::query()->find($twig_id)->update($data);
    }
}
