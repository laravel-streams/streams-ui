<?php

namespace Streams\Ui\Components\Table\View;

use Illuminate\Support\Str;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Components\Table\View\ViewQuery;
use Streams\Ui\Components\Table\View\ViewHandler;

class View extends Component
{
    public string $template = 'ui::components.tables.view';
    
    public string $component = 'view';

    public ?string $text = null;
    
    public ?string $icon = null;
    public ?string $label = null;

    public array $actions = [];
    public array $buttons = [];
    public array $columns = [];
    public array $entries = [];
    public array $filters = [];

    public bool $active = false;

    public $classes = [
        'c-table__view',
    ];

    public string $query = ViewQuery::class;
    public string $handler = ViewHandler::class;

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_filter(array_merge([
            'href' => $this->url(),
        ], $attributes)));
    }

    public function class($extra = [])
    {
        if ($this->active) {
            $extra[] = '--active';
        }
        
        return parent::class($extra);
    }

    public function text(): string|null
    {
        if ($this->text === false) {
            return null;
        }

        if ($this->text === null) {
            $this->text = Str::title(Str::humanize($this->handle));
        }

        return $this->text;
    }

    public function url()
    {
        return URL::current() . '?' . $this->prefix('view') . '=' . $this->handle;
    }
}
