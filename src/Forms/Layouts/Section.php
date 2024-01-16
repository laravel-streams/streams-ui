<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasColumns;
use Streams\Ui\Builders\Concerns\HasHeading;
use Streams\Ui\Forms\Concerns\HasComponents;
use Streams\Ui\Builders\Concerns\HasLivewire;
use Streams\Ui\Builders\Concerns\CanSpanColumns;
use Streams\Ui\Builders\Concerns\HasDescription;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;

class Section extends ViewComponent
{
    use HasId;
    use HasHeading;
    use HasColumns;
    use HasLivewire;
    use HasComponents;
    use HasDescription;
    use HasHtmlAttributes;

    use CanSpanColumns;

    protected string $view = 'ui::components.form.section';

    public function __construct(string | array | \Closure | null $heading = null)
    {
        is_array($heading)
            ? $this->components($heading)
            : $this->heading($heading);
    }

    public static function make(string | array | \Closure | null $heading = null): static
    {
        $static = app(static::class, ['heading' => $heading]);

        $static->configure();

        return $static;
    }
}
