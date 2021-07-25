<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FollowFollowedRelationship;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FollowFollowedRelationshipController as FFController;

class ProfileController extends Controller
{
    /**
     * プロフィール画面を取得
     * @param string $screen_name
     * @param string $mode
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function main(string $screen_name, string $mode=""){
        // ユーザが存在してたら
        if(User::query()->where("screen_name", "=" , $screen_name)->exists()) {
            $user = User::query()->where("screen_name", "=", $screen_name)->first();
            $data["user"] = $user;

            // (profile), with_replies, likes, following, followers
            $data["mode"] = $mode;
            switch ($mode) {
                case "":
                    $data["contents"] = TwigController::getTwigsWithoutReplies($user->user_id);
                    break;

                case "with_replies":
                    $data["contents"] = TwigController::getTwigsIncludingReplies($user->user_id);
                    break;

                case "likes":
                    $data["contents"] = UsersLikesController::getTwigsLikedBy($user->user_id);
                    break;

                case "following":
                    $data["followed_users"] = FFController::getUsersFollowedBy($user->user_id);
                    break;

                case "followers":
                    $data["following_users"] = FFController::getUsersFollow($user->user_id);
                    break;

                default:
                    break;
            }


            // Follow関係
            if(Auth::check()) {
                if (Auth::id() == $user->user_id) {
                    $data["followingState"] = "edit";
                } else if (FFController::isFollowed(Auth::id(), $user->user_id)) {
                    // フォローしてる
                    $data["followingState"] = "following";
                } else {
                    $data["followingState"] = "not_following";
                }
            } else {
                $data["followingState"] = "guest";
            }

            // Followed関係
            if(Auth::check()) {
                if (Auth::id() == $user->user_id) {
                    $data["followedState"] = "none";
                } else if (FFController::isFollowed($user->user_id, Auth::id())) {
                    // フォローされてる
                    $data["followedState"] = "following";
                } else {
                    $data["followedState"] = "not_following";
                }
            }else {
                $data["followedState"] = "guest";
            }

            //FFの数
            $data["following"] = FFController::getNumOfFollowingUsers($user->user_id);
            $data["followers"] = FFController::getNumOfFollowedUsers($user->user_id);

            return view("profiles.profile", $data);
        } else {
            // ユーザが存在してなかったら
            $data["screen_name"] = $screen_name;
            return view("profiles.notExist", $data);
        }
    }

    public function editProfilePage() {
        $bio = User::query()->find(Auth::id())->value("bio");
        return view("profiles.editProfile", ["bio" => $bio]);
    }

    public function editProfile(Request $request) {
        $ar = [
            "bio" => $request->get("bio")
        ];
        User::query()->find(Auth::id())->update($ar);


        return redirect('./../'.User::query()->find(Auth::id())->value("screen_name"), 302, [], env("IS_SECURE"));
    }


}
