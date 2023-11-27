<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Concerns;
use Streams\Ui\Support\ViewComponent;
use Streams\Ui\Support\Concerns\HasId;
use Streams\Ui\Support\Concerns\HasName;
use Streams\Ui\Support\Concerns\HasLabel;
use Streams\Core\Support\Traits\HasMemory;

abstract class Input extends ViewComponent
{
    use HasId;
    use HasName;
    use HasLabel;
    use HasMemory;

    use Concerns\HasKey;
    use Concerns\HasState;

    use Concerns\CanBeHidden;
    use Concerns\CanBeDisabled;
    use Concerns\CanBeReadonly;
    use Concerns\CanBeValidated;

    protected string $viewIdentifier = 'field';

    final public function __construct(string $name)
    {
        $this->name($name);
        $this->statePath($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);

        $static->configure();

        return $static;
    }

    public function getId(): string
    {
        return $this->id ?: $this->getStatePath();
    }

    public function getKey(): string
    {
        return $this->key ?: $this->getStatePath();
    }
}
