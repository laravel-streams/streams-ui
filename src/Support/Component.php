<?php

namespace Streams\Ui\Support;

use Streams\Core\Stream\Stream;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component extends \Livewire\Component
{
    // use Prototype {
    //     Prototype::__construct as protected __constructPrototype;
    //     Prototype::__call as protected __callPrototype;
    // }

    use HasMemory;
    use FiresCallbacks;

    public $workflow = null;

    public ?string $stream = null;

    public ?string $layout = null;

    public string $template;

    public function __construct($id = null)
    {
        parent::__construct($id);
    }

    public function booted()
    {
        $this->build();

        $this->fire('booted', [
            'component' => $this,
        ]);
    }

    public function stream(): Stream|null
    {
        if (!$this->stream) {
            return null;
        }
        
        return $this->once(
            __METHOD__ . '.' . $this->stream,
            fn ()  => Streams::exists($this->stream) ? Streams::make($this->stream) : null
        );
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

    protected function build()
    {
        if (!$this->workflow) {
            return;
        }
        
        $this->fire('building', [
            'component' => $this,
        ]);

        if (is_string($this->workflow)) {
            $workflow = new $this->workflow;
        } elseif (is_array($this->workflow)) {
            $workflow = new Workflow($this->workflow);
        } else {
            throw new \Exception('Invalid or missing workflow encountered.');
        }

        $workflow
            ->passThrough($this)
            ->process([
                'component' => $this,
            ]);

        $this->fire('built', [
            'component' => $this,
        ]);
    }

    public function __call($method, $parameters)
    {
        return parent::__call($method, $parameters);
    }
}
