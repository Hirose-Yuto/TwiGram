<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FollowFollowedRelationship;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FollowFollowedRelationshipController as FFController;

class ProfileController extends Controller
{
    public function main($screen_name, $mode=""){
        if(User::query()->where("screen_name", "=" , $screen_name)->exists()) {
            $user = User::query()->where("screen_name", "=", $screen_name);
            $data["user"] = $user;

            // (profile), with_replies, likes, following, followers
            $data["mode"] = $mode;
            switch ($mode) {
                case "":
                    $data["contents"] = TwigController::getTwigsWithoutReplies($user->value("user_id"));
                    break;

                case "with_replies":
                    $data["contents"] = TwigController::getTwigsIncludingReplies($user->value("user_id"));
                    break;

                case "likes":
                    break;

                case "following":
                    break;

                case "followers":
                    break;

                default:
                    break;
            }

            if ($mode) {
                $data["profile_body"] = $mode . "が入ります";
            } else {
                $data["profile_body"] = "Twigが入ります";
            }


            // Follow関係
            if(Auth::check()) {
                if (Auth::id() == $user->value("user_id")) {
                    $data["followingState"] = "edit";
                } else if (FFController::isFollowed(Auth::id(), $user->value("user_id"))) {
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
                if (Auth::id() == $user->value("user_id")) {
                    $data["followedState"] = "none";
                } else if (FFController::isFollowed($user->value("user_id"), Auth::id())) {
                    // フォローされてる
                    $data["followedState"] = "following";
                } else {
                    $data["followedState"] = "not_following";
                }
            }else {
                $data["followedState"] = "guest";
            }

            // フォロー中ユーザ、フォロワー取得
            if($mode == "following") {
                $followed_users_id = FollowFollowedRelationship::query()
                    ->where("following_user_id", "=", $user->value("user_id"))->get("followed_user_id");
                $followed_users = [];
                foreach ($followed_users_id as $followed_user_id) {
                    $followed_users[] = User::query()->find($followed_user_id->followed_user_id);
                }
                $data["followed_users"] = $followed_users;
            } else if ($mode == "followers") {
                $following_users_id = FollowFollowedRelationship::query()
                    ->where("followed_user_id", "=", $user->value("user_id"))->get("following_user_id");
                $following_users = [];
                foreach ($following_users_id as $following_user_id) {
                    $following_users[] = User::query()->find($following_user_id->following_user_id);
                }
                $data["following_users"] = $following_users;
            }


            //FFの数
            $data["following"] = FFController::getNumOfFollowingUsers($user->value("user_id"));
            $data["followers"] = FFController::getNumOfFollowedUsers($user->value("user_id"));

            return view("profiles.profile", $data);
        } else {
            $data["screen_name"] = $screen_name;
            return view("profiles.notExist", $data);
        }
    }

    public function editProfilePage() {
        return view("profiles.editProfile");
    }

    public function editProfile(Request $request) {
        $ar = [
            "bio" => $request->get("bio")
        ];
        User::query()->find(Auth::id())->update($ar);


        return redirect('./../'.User::query()->find(Auth::id())->value("screen_name"), 302, [], env("IS_SECURE"));
    }

    private function showFF($mode) {

    }


}
