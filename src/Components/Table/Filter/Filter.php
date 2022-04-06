<?php

namespace Streams\Ui\Components\Table\Filter;

use Illuminate\Support\Str;
use Collective\Html\FormFacade;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Table\Filter\Query\GenericFilterQuery;

class Filter extends Component
{
    public string $component = 'filter';
    public string $template = 'ui::form.input';

    public string $handle;

    public ?string $field = null;
    public ?string $prefix = null;
    public ?string $column = null;
    public ?string $placeholder = null;

    public bool $active = false;
    public bool $exact = false;

    public ?string $query = GenericFilterQuery::class;

    public function render()
    {
        return FormFacade::input('text', $this->inputName(), $this->value(), [
            'placeholder' => $this->placeholder ?: Str::title(Str::humanize($this->handle)),
        ]);
    }

    public function value()
    {
        return Request::get($this->inputName());
    }

    public function inputName()
    {
        return $this->prefix . 'filter_' . $this->handle;
    }
}
