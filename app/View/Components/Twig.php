<?php

namespace App\View\Components;

use App\Http\Controllers\TwigController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsersLikesController;
use App\Models\UsersLikes;
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

    public $is_retwig;
    public $retwig_from;
    public $retwig_from_twig;

    public $auth_user_id;

    public $num_of_retwigs;
    public $num_of_likes;
    public $is_userRetwig;
    public $is_userLike;

    /**
     * Create a new component instance.
     *
     * @return void
     * @throws \Exception
     */
    public function __construct(T $twig)
    {
        $this->twig = $twig;
        $this->twig_from = UserController::getUser($twig->twig_from);
        $this->twig_how_long_ago = $this->getTwigHowLongAgo($twig->created_at);
        $this->is_retwig = $twig->is_retwig;
        if($this->is_retwig) {
            $this->retwig_from = new self(TwigController::getTwig($twig->retwig_from));
            $this->retwig_from_twig = $this->retwig_from->twig;
        }

        $this->twig_url = "/twig/".$twig->twig_id;

        $this->twig_id = $twig->twig_id;
        $this->auth_user_id = Auth::id();

        $this->num_of_likes = $twig->num_of_likes;
        $this->num_of_retwigs = $twig->num_of_retwigs + $twig->num_of_retwigs_with_comment;
        $this->is_userRetwig = TwigController::is_retwigBy($this->twig_id, $this->auth_user_id);
        $this->is_userLike = UsersLikesController::is_userLikedTwig($this->auth_user_id, $this->twig_id);

    }

    /**
     * ツイッグがどれだけ前になされたか。
     * 一日以上前だったら日付をフルで表示
     * @param $twig_at
     * @return string
     * @throws \Exception
     */
    private function getTwigHowLongAgo($twig_at): string {
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
