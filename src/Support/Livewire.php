<?php

namespace Streams\Ui\Support;

use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Livewire extends \Livewire\Component
{
    // use Prototype {
    //     Prototype::__construct as protected __constructPrototype;
    //     Prototype::__call as protected __callPrototype;
    // }

    use HasMemory;
    use FiresCallbacks;

    public $builder = null;

    public ?string $layout = null;

    public string $template;

    public function booted()
    {
        $this->build();

        $this->fire('booted', [
            'component' => $this,
        ]);
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
            $output = $output->layout($this->layout);
        }

        return $output->render();
    }
}
