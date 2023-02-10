<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component extends \Livewire\Component
{
    // use Prototype {
    //     Prototype::__construct as protected __constructPrototype;
    // }

    use HasMemory;
    use FiresCallbacks;

    public ?string $stream = null;

    public string $template;

    public function stream(): Stream
    {
        return $this->once(__METHOD__ . '.' . $this->stream, fn ()  => Streams::make($this->stream));
    }

    public function render(array $payload = [])
    {
        $payload['component'] = $this;

        if (strpos($this->template, '<') !== false) {
            $rendered = View::parse($this->template, $payload);
        } else {
            $rendered = View::make($this->template, $payload);
        }
        
        if (isset($this->layout)) {
            $rendered = $rendered->layout($this->layout);
        }

        return $rendered;
    }
}
