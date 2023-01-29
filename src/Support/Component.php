<?php

namespace Streams\Ui\Support;

use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component extends \Livewire\Component
{
    use HasMemory;
    use FiresCallbacks;

    protected string $alias;

    public ?string $stream = null;

    //public string $handle;

    public string $template;

    public array $attributes = [];

    public function __construct($id = null)
    {
        $config = Config::get('ui::components.' . $this->alias, []);

        foreach ($config as $attribute => $value) {
            $this->{$attribute} = $value;
        }

        return parent::__construct($id);
    }

    public function stream(): Stream
    {
        if (!$this->stream) {
            throw new \Exception("Stream not configured for [{$this->alias}].");
        }

        return $this->once(__METHOD__ . '.' . $this->stream, fn ()  => Streams::make($this->stream));
    }

    public function render(array $payload = [])
    {
        return View::make($this->template, $payload);
    }
}
