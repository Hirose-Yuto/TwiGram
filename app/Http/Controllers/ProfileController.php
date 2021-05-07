<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function main($id){
        $data["id"] = $id;
        return view("profile", $data);
    }
}
