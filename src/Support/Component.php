<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Facades\View;
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

    public ?string $builder = null;
    public ?string $layout = null;

    public string $template;

    public function __construct(array $attributes = [])
    {
        $this->__constructPrototype($attributes);

        $this->build();

        // @todo meh, could be better
        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    public function render(array $payload = []): string
    {
        $payload['component'] = $this;

        if (strpos($this->template, '<') !== false) {
            $output = View::parse($this->template, $payload);
        } else {
            $output = View::make($this->template, $payload);
        }

        if (isset($this->layout)) {
            $output = View::make($this->layout, [
                'slot' => $output,
            ]);
        }

        return $output->render();
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

    public function __toString()
    {
        return $this->render();
    }
}
