<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Support\ViewComponent;
use Streams\Ui\Support\Concerns\HasId;
use Streams\Ui\Support\Concerns\HasColumns;
use Streams\Ui\Forms\Concerns\HasComponents;
use Streams\Ui\Support\Concerns\CanSpanColumns;
use Streams\Ui\Support\Concerns\HasHtmlAttributes;

class Grid extends ViewComponent
{
    use HasId;
    use HasColumns;
    use HasComponents;
    use HasHtmlAttributes;

    use CanSpanColumns;

    protected string $view = 'ui::components.form.grid';

    final public function __construct(array | int | string | null $columns)
    {
        $this->columns($columns);
    }

    public static function make(array | int | string | null $columns = 2): static
    {
        $static = app(static::class, ['columns' => $columns]);

        $static->configure();

        return $static;
    }
}
