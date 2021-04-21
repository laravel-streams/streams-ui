<?php

namespace Streams\Ui\Layout;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Ui\Button\Button;
use Streams\Ui\Layout\Layout;
use Streams\Ui\Support\Builder;
use Streams\Ui\Support\Normalizer;
use Streams\Ui\Button\ButtonRegistry;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Streams;

class LayoutBuilder extends Builder
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([

            'content' => [],

            'steps' => [
                'make_component' => [$this, 'make'],
                'make_content' => [$this, 'makeContent'],
            ],

            'component' => 'layout',
            'layout' => Layout::class,
        ], $attributes));
    }

    public function makeContent()
    {
        $this->make();

        if ($this->instance->content->isNotEmpty()) {
            return $this->instance->content;
        }

        $content = $this->content;

        foreach ($content as $handle => $content) {

            if (!isset($content['type'])) {
                $content['type'] = $handle;
            }
        }

        return $this->instance->content = new LayoutCollection($content);
    }
}
