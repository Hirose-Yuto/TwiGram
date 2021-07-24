<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Twig;

class SearchController extends Controller
{
    /**
     * @param Request $request
     */
    public function search(Request $request, $mode="twig") {
        $query = $request->get("search");
        $data = [];
        if($mode == "twig") {
            $data = [
                "twigs" => Twig::search($query)->get(),
                "mode" => $mode,
                "search" => $query
            ];
        } elseif ($mode == "user") {
            $data = [
                "users" => User::search($query)->get(),
                "mode" => $mode,
                "search" => $query
            ];
        }

        return view('search', $data);
    }
}
