<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

//abstract class Component extends \Illuminate\View\Component
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

        $this->id = $this->id ?? md5(implode('_', [
            $this->name(),
            $this->template,
            json_encode($attributes)
        ]));

        Cache::put($this->id, json_encode([
            'component' => static::class,
            'attributes' => $attributes,
        ]));
    }

    public function stream(): Stream
    {
        return $this->once(__METHOD__ . '.' . $this->stream, fn ()  => Streams::make($this->stream));
    }

    public function render(array $payload = []): string
    {
        $payload['component'] = $this;

        if (strpos($this->template, '<') !== false) {
            $rendered = View::parse($this->template, $payload)->render();
        } else {
            $rendered = View::make($this->template, $payload)->render();
        }

        return $this->finishRender($rendered);
    }

    public function name()
    {
        return $this->once(__METHOD__, fn () => Str::kebab(class_basename($this)));
    }

    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    public function __toString()
    {
        return $this->render();
    }

    protected function finishRender(string $rendered): string
    {
        $attributes = HtmlFacade::attributes([
            'ui:id' => $this->id,
            'ui:name' => $this->name(),
        ]);

        $rendered = preg_replace('/(<div\b[^><]*)>/i', '$1 ' . $attributes . '>', $rendered);

        return $rendered;
    }
}
