<?php

namespace App\View\Components;

use Closure;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StoryblokComponent extends Component
{
    private $name;

    private $editable;

    public function __construct(
        public array $component,
        public string $language = ''
    ) {
        $this->editable = $this->extractEditableInfo($component);
    }

    private function extractEditableInfo($blok)
    {
        if (! is_array($blok) || ! array_key_exists('_editable', $blok)) {
            return [];
        }

        $options = json_decode(
            preg_replace(['/^<!--#storyblok#/', '/-->$/'], '', $blok['_editable']),
            true
        );

        if ($options) {
            return [
                'data-blok-c' => json_encode($options),
                'data-blok-uid' => $options['id'].'-'.$options['uid'],
            ];
        }

        return [];
    }

    private function getEditableString()
    {
        return "data-blok-c='".$this->editable['data-blok-c']."' "
        ." data-blok-uid='".$this->editable['data-blok-uid']."'";
    }

    public function render(): View|Closure|string
    {
        try {
            return view('components.'.$this->component['component'])
                ->with('language', $this->language)
                ->with('editableAttributes', $this->getEditableString());
        } catch (Exception $e) {
            $c = new DefaultComponent($this->component);

            return $c->render();
        }
    }
}
