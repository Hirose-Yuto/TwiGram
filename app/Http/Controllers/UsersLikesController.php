<?php

namespace App\Http\Controllers;

use App\Models\UsersLikes;
use Illuminate\Http\Request;

class UsersLikesController extends Controller
{

    /**
     * ふぁぼをする。
     * @param int $user_id
     * @param int $twig_id
     */
    public static function like(int $user_id, int $twig_id) {
        if(UserController::doesntExists($user_id) || TwigController::doesntExists($twig_id)) {
            return;
        }

        $data = [
            "user_id" => $user_id,
            "twig_id" => $twig_id
        ];
        UsersLikes::query()->updateOrCreate($data);

        TwigController::addNumOfLikes($twig_id);
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

}
