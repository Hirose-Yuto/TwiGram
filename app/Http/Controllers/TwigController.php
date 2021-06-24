<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Twig;

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
     * ユーザがフォローしている人のツイッグを取得する。
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return array
     */
    public static function getFollowingUserTwigs(int $user_id, int $num_of_twigs_to_get = 15): array
    {
        return [];
    }
}
