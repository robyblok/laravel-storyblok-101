<?php

namespace App\View\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StoryblokComponent extends Component
{
    private $name;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public array $component
    ) {
        //$this->name = $component["name"];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        //dd($this->component);
        try {
            return view('components.'.$this->component['component']);
        } catch (Exception $e) {
            $c = new DefaultComponent($this->component);

            return $c->render();
            //return "Component = " . $this->component['component'] . " is missing";
        }
    }
}
