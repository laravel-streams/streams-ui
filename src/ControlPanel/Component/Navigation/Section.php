<?php

namespace Streams\Ui\ControlPanel\Component\Navigation;

use Collective\Html\HtmlFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

/**
 * Class Section
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Section extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'component' => 'section',
            'template' => null,

            'title' => null,
            //'policy' => null,
            //'breadcrumb' => null,

            'active' => false,
            //'favorite' => false,

            'buttons' => [],
        ], $attributes));
    }

    public function url()
    {
        return URL::to($this->getPrototypeAttribute('attributes.href'));
    }

    public function link(array $attributes = [])
    {
        return HtmlFacade::link(
            $this->url(),
            $this->title,
            $this->attributes($attributes)
        );
    }

    public function render()
    {
        return $this->link();
    }
}
