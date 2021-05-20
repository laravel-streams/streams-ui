<?php

namespace Streams\Ui\Support\Traits;

use Illuminate\Support\Arr;
use Streams\Ui\Layout\LayoutCollection;
use Streams\Ui\Support\Facades\UI;

trait HasContent
{

    public function setContentAttribute($value)
    {
        foreach ($value as $key => $content) {

            $content['handle'] = Arr::get($content, 'handle', $key);
            $content['component'] = Arr::get($content, 'component', $key);

            if (is_null(Arr::get($content, 'stream'))) {
                $content['stream'] = $this->stream;
            }

            $value[$key] = UI::make(Arr::get($content, 'component'), $content);
        }

        $this->setPrototypeAttributeValue('content', new LayoutCollection($value));
    }
}
