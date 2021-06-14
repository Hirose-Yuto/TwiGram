<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FollowFollowedRelationship;
use Illuminate\Support\Facades\Auth;
use function Sodium\add;

class ProfileController extends Controller
{
    public function main($screen_name, $mode=""){
        if(User::query()->where("screen_name", "=" , $screen_name)->exists()) {
            $user = User::query()->where("screen_name", "=", $screen_name);
            $data["user"] = $user;

            // , with_replies, media, likes, following, followers
            $data["mode"] = $mode;
            if ($mode) {
                $data["profile_body"] = $mode . "が入ります";
            } else {
                $data["profile_body"] = "Twigが入ります";
            }

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


            // Follow関係
            if(Auth::check()) {
                if (Auth::id() == $user->value("user_id")) {
                    $data["followingState"] = "edit";
                } else if (FollowFollowedRelationship::query()
                    ->where("following_user_id", "=", Auth::id())
                    ->where("followed_user_id", "=", $user->value("user_id"))
                    ->exists()) {
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
                } else if (FollowFollowedRelationship::query()
                    ->where("following_user_id", "=", $user->value("user_id"))
                    ->where("followed_user_id", "=", Auth::id())
                    ->exists()) {
                    // フォローしてる
                    $data["followedState"] = "following";
                } else {
                    $data["followedState"] = "not_following";
                }
            }else {
                $data["followedState"] = "guest";
            }

            //FFの数
            $data["following"] = FollowFollowedRelationship::query()
                ->where("following_user_id", "=", $user->value("user_id"))->count();
            $data["followers"] = FollowFollowedRelationship::query()
                ->where("followed_user_id", "=", $user->value("user_id"))->count();

            return view("profiles.profile", $data);
        } else {
            $data["screen_name"] = $screen_name;
            return view("profiles.notExist", $data);
        }
    }

    public function showFF($mode) {

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
}
