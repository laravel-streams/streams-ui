<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasColumns;
use Streams\Ui\Builders\Forms\Concerns\HasComponents;
use Streams\Ui\Builders\Concerns\CanSpanColumns;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;

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
