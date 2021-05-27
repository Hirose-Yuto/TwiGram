<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function main($screen_name, $mode=""){
        $data["screen_name"] = $screen_name;
        $data["mode"] = $mode;
        if($mode) {
            $data["profile_body"] = $mode . "が入ります";
        } else {
            $data["profile_body"] = "Twigが入ります";
        }
        return view("profile", $data);
    }
}
