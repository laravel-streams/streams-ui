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
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
            
            'content' => [],

            'steps' => [
                'make_component' => [$this, 'make'],

                'make_content' => [$this, 'makeContent'],
                // 'detect_navigation' => [$this, 'detectNavigation'],

                // 'make_shortcuts' => [$this, 'makeShortcuts'],
                // 'make_buttons' => [$this, 'makeButtons'],
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

        return $this->instance->content = $content;
    }
}
