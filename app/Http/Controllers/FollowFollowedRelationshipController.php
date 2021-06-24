<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FollowFollowedRelationship;
use Illuminate\Support\Facades\Auth;

class FollowFollowedRelationshipController extends Controller
{
    /**
     * フォローする。
     * 既にフォローしていた場合はスルー。自分自身をフォローしようとしたら跳ねる。
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function follow(Request $request){
        $target_id = $request->get("target");

        if(self::isNotFollowed(Auth::id(), $target_id)) {
            if($target_id != Auth::id()) {
                // 自身をフォローすることはできない。
                $data = [
                    "following_user_id" => Auth::id(),
                    "followed_user_id" => $target_id,
                ];
                FollowFollowedRelationship::query()->create($data);
            }
        }
        return redirect('./../'.User::query()->find($target_id)->screen_name, 302, [], env("IS_SECURE"));
    }

    /**
     * フォローを外す。
     * もともとフォローしてなかったらスルー。
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function unFollow(Request $request) {
        $target_id = $request->get("target");
        if(self::isFollowed(Auth::id(), $target_id)) {
            FollowFollowedRelationship::query()
                ->where("following_user_id", "=", Auth::id())
                ->where("followed_user_id", "=", $target_id)
                ->delete();
        }
        return redirect('./../'.User::query()->find($target_id)->screen_name, 302, [], env("IS_SECURE"));
    }

    /**
     * フォローしているか
     * @param int $following_user_id
     * @param int $followed_user_id
     * @return bool
     */
    public static function isFollowed(int $following_user_id, int $followed_user_id): bool {
        return FollowFollowedRelationship::query()
            ->where("following_user_id", "=", $following_user_id)
            ->where("followed_user_id", "=", $followed_user_id)
            ->exists();
    }

    /**
     * フォローしていないか
     * @param int $following_user_id
     * @param int $followed_user_id
     * @return bool
     */
    public static function isNotFollowed(int $following_user_id, int $followed_user_id): bool {
        return !self::isFollowed($following_user_id, $followed_user_id);
    }

    /**
     * ユーザがフォローしている人をすべてゲットする。
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUsersFollowedBy(int $user_id) {
        $usersFollowedBy = [];
        foreach(FollowFollowedRelationship::query()
            ->where("following_user_id", "=", $user_id)->get("followed_user_id") as $followed_user_id) {
            $usersFollowedBy[] = User::query()->find($followed_user_id)[0];
        }
        return $usersFollowedBy;
    }

    /**
     * ユーザをフォローしている人をすべてゲットする。
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getUsersFollow(int $user_id) {
        $usersFollow = [];
        foreach(FollowFollowedRelationship::query()
                    ->where("followed_user_id", "=", $user_id)->get("following_user_id") as $following_user_id) {
            $usersFollow[] = User::query()->find($following_user_id)[0];
        }
        return $usersFollow;
    }

    /**
     * ユーザがフォローしている他ユーザの人数をゲットする。
     * @param int $user_id
     * @return int
     */
    public static function getNumOfFollowingUsers(int $user_id): int {
        return FollowFollowedRelationship::query()
            ->where("following_user_id", "=", $user_id)->count();
    }

    /**
     * ユーザをフォローしている他ユーザの人数をゲットする。
     * @param int $user_id
     * @return int
     */
    public static function getNumOfFollowedUsers(int $user_id): int {
        return FollowFollowedRelationship::query()
            ->where("followed_user_id", "=", $user_id)->count();
    }
}
