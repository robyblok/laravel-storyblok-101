<?php

namespace App\View\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StoryblokComponent extends Component
{
    private $name;

    public function __construct(
        public array $component
    ) {
        //$this->name = $component["name"];
    }

    public function render(): View|Closure|string
    {
        try {
            return view('components.'.$this->component['component']);
        } catch (Exception $e) {
            $c = new DefaultComponent($this->component);

            return $c->render();
        }
    }
}
