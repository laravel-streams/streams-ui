<?php

namespace Streams\Ui\Blade;

use Illuminate\Support\Arr;
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

                    $data['__laravel_slots']['slot'] = Arr::pull(
                        $data['__laravel_slots'],
                        '__default'
                    );

                    continue;
                }
            }

            $attributes = Arr::undot($attributes);

            $instance = UI::make(str_replace('ui-', '', $this->componentName), $attributes);

            return $instance->render([
                $instance->component => $instance
            ] + $attributes + $data['__laravel_slots']);
        };
    }
}
