<?php

namespace Streams\Ui\Builders;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;
use Streams\Ui\support\Facades\UI;

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

                dump($name);
                dd($content);
            }

            $attributes = Arr::undot($attributes);

            $instance = App::make(config("streams.ui.components.{$this->componentName}"), $attributes);

            return $instance->render([
            ] + $attributes + $data['__laravel_slots'])->with([
                'component' => $instance,
            ]);
        };
    }
}
