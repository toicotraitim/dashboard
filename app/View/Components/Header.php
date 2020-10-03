<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    public $url;
    public $contentHeader;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $this->url = explode("/",url()->current());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.header');
    }
}
