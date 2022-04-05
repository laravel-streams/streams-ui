<?php

namespace Streams\Ui\Blade;

use Illuminate\View\Component;
use Streams\Ui\Support\Facades\UI;

class BladeComponent extends Component
{

    public function render()
    {

        return function (array $data) {

            // $data['componentName'];
            // $data['attributes'];
            // $data['slot'];

            $attributes = $data['attributes']->getAttributes();

            foreach ($data['__laravel_slots'] as $name => $content) {

                if ($name == '__default') {
                    
                    $attributes['text'] = (string) $content;
                    
                    continue;
                }
            }

            $instance = UI::make(str_replace('ui-', '', $this->componentName), $attributes);

            return $instance->render([
                $instance->component => $instance
            ] + $attributes);
        };
    }
}
