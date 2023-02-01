<?php

namespace Streams\Ui\Support;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component
{
    use Prototype {
        Prototype::__construct as protected __constructPrototype;
    }

    use HasMemory;
    use FiresCallbacks;
    
    public ?string $stream = null;

    public string $template;

    public function __construct(array $attributes = [])
    {
        $this->__constructPrototype($attributes);

        // Replace this with a UI manager controlled method
        // UI::make should boot, and do all the callbacks and stuff.
        $this->booted();
    }

    public function booted()
    {
        $this->id = $this->id ?? md5($this->template);
    }

    public function stream(): Stream
    {
        return $this->once(__METHOD__ . '.' . $this->stream, fn ()  => Streams::make($this->stream));
    }

    public function render(array $payload = [])
    {
        $payload['component'] = $this;

        return View::make($this->template, $payload);
    }

    public function __toString()
    {
        return (string) $this->render();
    }
}
