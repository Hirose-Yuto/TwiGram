<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * ユーザが存在するか
     * @param $user_id
     * @return bool
     */
    public static function exists($user_id) :bool{
        return User::query()->find($user_id)->exists();
    }

    /**
     * ユーザが存在しないか
     * @param $user_id
     * @return bool
     */
    public static function doesntExists($user_id) :bool{
        return User::query()->find($user_id)->doesntExist();
    }

    /**
     * ユーザを取得
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public static function getUser(int $user_id) {
        if(self::exists($user_id)) {
            return User::query()->find($user_id);
        }
        // ToDo:例外処理
    }
}
