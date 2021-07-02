<?php

namespace App\View\Components;

use App\Http\Controllers\TwigController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersLikesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use App\Models\Twig as T;

class Twig extends Component
{
    public $twig;
    public $twig_id;
    public $twig_from;
    public $twig_how_long_ago;

    public $twig_url;
    public $num_of_retwigs;
    public $num_of_likes;

    public $auth_user_id;

    public $is_userRetwig;
    public $is_userLike;


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(T $twig)
    {
        $this->twig = $twig;
        $this->twig_from = UserController::getUser($twig->twig_from);
        $this->twig_how_long_ago = $this->getTwigHowLongAgo($twig->updated_at);

        $this->twig_url = "/twig/".$twig->twig_id;

        $this->twig_id = $twig->twig_id;
        $this->auth_user_id = Auth::id();

        $this->is_userLike = UsersLikesController::is_userLikedTwig($this->auth_user_id, $this->twig_id);
        $this->is_userRetwig = false;//TwigController::re
    }

    private function getTwigHowLongAgo($twig_at) {
        $at = new \DateTimeImmutable($twig_at);
        $diff = $at->diff(new \DateTimeImmutable());
        if($diff->format("%Y%M%D") != "000000") {
            return $at->format("Y-m-d");
        } else if($diff->format("%H") != "00") {
            return $diff->format("%hh");
        } else if($diff->format("%I") != "00") {
            return $diff->format("%im");
        } else {
            return $diff->format("%ss");
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.twig');
    }
}
