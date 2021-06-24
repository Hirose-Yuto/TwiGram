<?php

namespace App\View\Components;

use App\Http\Controllers\TwigController;
use App\Http\Controllers\UserController;
use Illuminate\View\Component;
use App\Models\Twig as T;

class Twig extends Component
{
    public $twig;
    public $user;
    public $twig_how_long_ago;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(T $twig)
    {
        $this->twig = $twig;
        $this->user = UserController::getUser($twig->twig_from);
        $this->twig_how_long_ago = $this->getTwigHowLongAgo($twig->updated_at);
    }

    private function getTwigHowLongAgo() {
        return "1m -ToDO:Component/Twig直す ";
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
