<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Streams\Ui\Traits\HasColumns;
use Streams\Ui\Builders\ViewComponent;
use Streams\Ui\Builders\Concerns\HasId;
use Streams\Ui\Builders\Concerns\HasHeading;
use Streams\Ui\Builders\Concerns\HasLivewire;
use Streams\Ui\Builders\Concerns\CanSpanColumns;
use Streams\Ui\Builders\Concerns\HasDescription;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;
use Streams\Ui\Builders\Forms\Concerns\HasComponents;

class Section extends ViewComponent
{
    use CanSpanColumns;
    use HasColumns;
    use HasComponents;
    use HasDescription;
    use HasHeading;
    use HasHtmlAttributes;
    use HasId;
    use HasLivewire;

    protected string $view = 'ui::components.form.section';

    public function __construct(string|array|\Closure|null $heading = null)
    {
        is_array($heading)
            ? $this->components($heading)
            : $this->heading($heading);
    }

    public static function make(string|array|\Closure|null $heading = null): static
    {
        $static = app(static::class, ['heading' => $heading]);

        $static->configure();

        return $static;
    }
}
