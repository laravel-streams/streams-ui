<?php

namespace Streams\Ui\Layout;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Streams\Ui\Support\Facades\UI;

class Layout extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        $this->loadPrototypeProperties([
            'content' => [
                'type' => 'collection',
            ],
        ]);

        return parent::initializePrototypeAttributes(array_merge([
            'component' => 'layout',
            'template'  => 'ui::layouts.layout',
            'content' => [],
        ], $attributes));
    }

    public function setContentAttribute($value)
    {
        foreach ($value as $key => &$content) {

            $content['handle'] = Arr::get($content, 'handle', $key);
            $content['component'] = Arr::get($content, 'component', $key);

            $content = UI::make(Arr::get($content, 'component'), $content);
        }

        $this->setPrototypeAttributeValue('content', $value);
    }
}
