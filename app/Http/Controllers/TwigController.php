<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Twig;
use Illuminate\Support\Facades\Auth;

class TwigController extends Controller
{
    /**
     * ユーザのツイッグを取得(リプライは含めない)。
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTwigsWithoutReplies(int $user_id, int $num_of_twigs_to_get = 15) {
        return Twig::query()->where("twig_from", $user_id)->where("reply_for", "=", null)->orderByDesc("updated_at")->take($num_of_twigs_to_get)->get();
    }

    /**
     * ユーザのツイッグを取得(リプライも含める)。
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTwigsIncludingReplies(int $user_id, int $num_of_twigs_to_get = 15) {
        return Twig::query()->where("twig_from", $user_id)->orderByDesc("updated_at")->take($num_of_twigs_to_get)->get();
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

        return $twigs->orderByDesc("updated_at")
                     ->take($num_of_twigs_to_get)
                     ->get();
    }
}
