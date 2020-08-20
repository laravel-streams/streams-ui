<?php

namespace Anomaly\Streams\Ui\Support;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View as ViewInterface;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Support\Traits\Properties;
use Anomaly\Streams\Platform\Support\Traits\FiresCallbacks;

/**
 * Class Ui
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Component implements Arrayable, Jsonable
{
    use Macroable;
    use Properties;
    use FiresCallbacks;

    public function render(): ViewInterface
    {
        return View::make("ui::{$this->component}/{$this->component}", [
            $this->component => $this,
        ]);
    }

    public function prefix($target = null): string
    {
        return $this->options->get('prefix') . $target;
    }

    public function toArray(): array
    {
        return Hydrator::dehydrate($this);
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }
}
