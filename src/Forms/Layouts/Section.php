<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Support\ViewComponent;
use Streams\Ui\Support\Concerns\HasId;
use Streams\Ui\Support\Concerns\HasColumns;
use Streams\Ui\Support\Concerns\HasHeading;
use Streams\Ui\Forms\Concerns\HasComponents;
use Streams\Ui\Support\Concerns\HasLivewire;
use Streams\Ui\Support\Concerns\CanSpanColumns;
use Streams\Ui\Support\Concerns\HasDescription;
use Streams\Ui\Support\Concerns\HasHtmlAttributes;

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
