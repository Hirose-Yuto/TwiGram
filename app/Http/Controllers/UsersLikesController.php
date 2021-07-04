<?php

namespace App\Http\Controllers;

use App\Models\UsersLikes;
use Illuminate\Http\Request;

class UsersLikesController extends Controller
{
    /**
     * ふぁぼをする。
     * @param Request $request
     */
    public static function like(Request $request) {

        $twig_id = $request->get("twig_id");
        $user_id = $request->get("user_id");

        if(UserController::doesntExists($user_id) || TwigController::doesntExists($twig_id)) {
            return;
        }

        if(self::is_userLikedTwig($user_id, $twig_id)) {
            UsersLikes::query()
                ->where("user_id", "=", $user_id)
                ->where("twig_id", "=", $twig_id)
                ->delete();
            TwigController::addNumOfLikes($twig_id, -1);
        } else {
            $data = [
                "user_id" => $user_id,
                "twig_id" => $twig_id
            ];
            UsersLikes::query()->updateOrCreate($data);

            TwigController::addNumOfLikes($twig_id);
        }
    }

    /**
     * ユーザがツイッグをふぁぼしてるかどうか
     * @param int $user_id
     * @param int $twig_id
     * @return bool
     */
    public static function is_userLikedTwig(int $user_id, int $twig_id) {
        return UsersLikes::query()
            ->where("user_id", "=", $user_id)
            ->where("twig_id", "=", $twig_id)
            ->exists();
    }

    /**
     * ふぁぼ数を返す
     * @param int $twig_id
     * @return int
     */
    public static function numOfLikes(int $twig_id): int {
        return UsersLikes::query()
            ->where("twig_id", "=", $twig_id)
            ->count();
    }

    /**
     * ユーザがふぁぼしたツイッグ数
     * @param int $user_id
     * @return int
     */
    public static function numOfLikesBy(int $user_id): int {
        return UsersLikes::query()
            ->where("user_id", "=", $user_id)
            ->count();
    }

    /**
     * ユーザによってふぁぼられたツイッグのIDを返す。
     * @param int $user_id
     * @param int $num_of_twigs_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getTwigsIdLikedBy(int $user_id, int $num_of_twigs_to_get = 15) {
        return UsersLikes::query()
            ->where("user_id", "=", $user_id)
            ->orderByDesc("updated_at")
            ->take($num_of_twigs_to_get)
            ->get("twig_id");
    }

    /**
     * ツイッグをふぁぼったユーザのIDを返す。
     * @param int $twig_id
     * @param int $num_of_users_to_get
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUserIdLikeTwig(int $twig_id, int $num_of_users_to_get = 100) {
        return UsersLikes::query()
            ->where("twig_id", "=", $twig_id)
            ->orderByDesc("updated_at")
            ->take($num_of_users_to_get)
            ->get("user_id");
    }

    /**
     * ふぁぼを消す
     * @param $data
     */
    public static function deleteLikeByData($data) {
        $query = UsersLikes::query();
        foreach($data as $key => $value) {
            $query->where($key, "=", $value);
        }
        $query->delete();
    }

}
