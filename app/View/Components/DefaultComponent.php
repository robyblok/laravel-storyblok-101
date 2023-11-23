<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DefaultComponent extends Component
{
    public function __construct(
        public array $component
    ) {
        //
    }

    public function render(): View|Closure|string
    {
        return view('components.default')->with('component', $this->component['component']);
    }
}
