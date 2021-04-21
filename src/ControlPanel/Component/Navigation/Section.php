<?php

namespace Streams\Ui\ControlPanel\Component\Navigation;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;

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
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'component' => 'section',
            'template' => null,

            'title' => null,
            'policy' => null,
            //'breadcrumb' => null,

            'active' => false,

            'buttons' => [],
        ], $attributes));
    }

    public function url(array $extra = [])
    {
        $target = Arr::get($this->attributes, 'href') ?: ('@cp/' . $this->id);

        if (Str::startsWith($target, '@cp/')) {
            return URL::cp(ltrim(substr($target, 4), '/'), $extra);
        }

        return URL::url($target);
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
