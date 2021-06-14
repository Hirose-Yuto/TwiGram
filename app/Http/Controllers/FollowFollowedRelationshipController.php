<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\FollowFollowedRelationship;
use Illuminate\Support\Facades\Auth;

class FollowFollowedRelationshipController extends Controller
{
    public function follow(Request $request){
        $target_id = $request->get("target");
        if(!FollowFollowedRelationship::query()
            ->where("following_user_id", "=", Auth::id())
            ->where("followed_user_id", "=", $target_id)
            ->exists()) {
            $data = [
                "following_user_id" => Auth::id(),
                "followed_user_id" => $target_id,
            ];
            FollowFollowedRelationship::query()->create($data);
        }
        return redirect('./../'.User::query()->find($target_id)->screen_name, 302, [], env("IS_SECURE"));
    }

    public function unFollow(Request $request) {
        $target_id = $request->get("target");
        if(FollowFollowedRelationship::query()
            ->where("following_user_id", "=", Auth::id())
            ->where("followed_user_id", "=", $target_id)
            ->exists()) {
            FollowFollowedRelationship::query()
                ->where("following_user_id", "=", Auth::id())
                ->where("followed_user_id", "=", $target_id)
                ->delete();
        }
        return redirect('./../'.User::query()->find($target_id)->screen_name, 302, [], env("IS_SECURE"));
    }
}
