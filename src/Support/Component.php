<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component
{
    use Prototype {
        Prototype::__construct as protected __constructPrototype;
        Prototype::__call as protected __callPrototype;
    }

    use HasMemory;
    use FiresCallbacks;

    public string $id;

    public ?string $builder = null;
    public ?string $layout = null;
    public ?string $handle = null;

    public string $template;

    public function __construct(array $attributes = [])
    {
        $attributes['id'] = $attributes['id'] ?? Str::random(20);

        if ($data = Arr::pull($attributes, 'parse_data')) {
            $attributes = Arr::parse($attributes, $data);
        }

        //$this->syncPrototypePropertyAttributes();
        $this->syncOriginalPrototypeAttributes($attributes);

        $this->setPrototypeAttributes($attributes);

        $this->build();

        // @todo meh, could be better
        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    public function __invoke()
    {
        return $this->render();
    }

    public function render(array $payload = []): string
    {
        $payload['component'] = $this;

        if (strpos($this->template, '<') !== false) {
            $output = View::parse($this->template, $payload);
        } else {
            $output = View::make($this->template, $payload);
        }

        if ($this->layout) {
            $output = View::make($this->layout, [
                'content' => $output,
            ]);
        }

        $rendered = $output->render();

        return $this->finishRender($rendered);
    }

    protected function build()
    {
        if (!$this->builder) {
            return;
        }

        $this->fire('building', [
            'component' => $this,
        ]);

        (new $this->builder)
            ->passThrough($this)
            ->process([
                'component' => $this,
            ]);

        $this->fire('built', [
            'component' => $this,
        ]);
    }

    protected function finishRender(string $rendered): string
    {
        $attributes = HtmlFacade::attributes([
            'ui:id' => $this->id,
            'ui:name' => $this->id,
        ]);

        $data = Hydrator::dehydrate($this, [
            'template',
            'builder',
            'layout',
            'handle',
            'id',
        ]);

        $data['component'] = addslashes(static::class);
        
        $attributes .= ' ui:data="' . e(json_encode($data)) . '"';

        // $attributes = HtmlFacade::attributes([
        //     'ui:id' => $this->id,
        //     'ui:name' => $this->id,
        //     'ui:data' => json_encode(Hydrator::dehydrate($this, [
        //         'template',
        //         'builder',
        //         'layout',
        //         'handle',
        //         'id',
        //     ])),
        // ]);

        $rendered = preg_replace('/(<div\b[^><]*)>/i', '$1 ' . $attributes . '>', $rendered, 1);

        return $rendered;
    }

    public function __toString()
    {
        return $this->render();
    }

    public function toArray(): array
    {
        return Hydrator::dehydrate($this, [
            'builder',
            'layout',
        ]);
    }
}
