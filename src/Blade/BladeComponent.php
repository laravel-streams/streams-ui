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

            // @todo this idea should maybe be moved to the component?
            $attributes = Arr::undot($data['attributes']->getAttributes());

            foreach ($data['__laravel_slots'] as $name => $content) {

                if ($name == '__default') {

                    $data['__laravel_slots']['slot'] = Arr::pull(
                        $data['__laravel_slots'],
                        '__default'
                    );

                    continue;
                }
            }

            $attributes = Arr::undot($attributes);

            $instance = UI::make($this->componentName, $attributes);

            return (string) $instance->render($data['__laravel_slots']);
        };
    }
}
