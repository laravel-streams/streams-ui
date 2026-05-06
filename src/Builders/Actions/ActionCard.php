<?php

namespace Streams\Ui\Builders\Actions;

use Illuminate\Support\Str;
use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\ViewBuilder;

class ActionCard extends ViewBuilder
{
    use Concerns\HasAction;
    use Concerns\HasDescription;
    use Concerns\HasHtmlAttributes;
    use Concerns\HasIcon;
    use Concerns\HasId;
    use Concerns\HasLabel;

    protected string $view = 'ui::builders.action-card';

    protected string $viewIdentifier = 'card';

    public function __construct(string $id)
    {
        $this->id($id);
    }

    public static function make(?string $id = null): static
    {
        $id = $id ?? self::getDefaultName();

        $static = new static($id);

        $static->configure();

        return $static;
    }

    protected static function getDefaultName(): string
    {
        $parts = explode('\\', static::class);

        return Str::kebab(end($parts));
    }
}
