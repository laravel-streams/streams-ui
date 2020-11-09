<?php

namespace Streams\Ui\ControlPanel\Component\Navigation;

use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

/**
 * Class NavigationLink
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationLink extends Component
{

    /**
     * Create a new
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if ($parent = $this->getPrototypeAttribute('parent')) {
            
            $extended = $this->stream->repository()->find($parent);

            $this->setPrototypeAttributes(
                array_merge($extended->toArray(), $this->toArray())
            );
        }
    }

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'component' => 'navigation_link',
            'template' => 'ui::cp.navigation_link',

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
        if (!$this->getPrototypeAttribute('attribute.href')) {
            return URL::to(Config::get('streams.cp.prefix', 'cp') . '/' . $this->handle);
        }

        return $this->url();
    }
}
