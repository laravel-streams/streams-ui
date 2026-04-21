<?php

namespace Streams\Ui\Builders\Forms;

use Livewire\Component;
use Illuminate\Support\Str;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Support\Facades\Forms;
use Streams\Ui\Builders\Concerns as Common;

class Form extends ViewBuilder
{
    use Common\BelongsToParent;
    use Common\BelongsToLivewire;
    use Common\HasName;

    use Common\HasState;
    use Common\HasStream;
    use Common\HasActions;
    use Common\HasHeading;
    use Common\HasComponents;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;
    
    use Concerns\HandlesValidation;

    protected string $view = 'ui::builders.form';

    protected string $viewIdentifier = 'form';

    public function __construct(?Component $livewire = null, ?string $name = null)
    {
        $this->livewire($livewire);

        $this->name($name ?? static::getDefaultName());
    }

    public static function make(?Component $livewire = null, ?string $name = null): static
    {
        $resolvedName = $name ?? static::getDefaultName();

        $instance = new static($livewire, $resolvedName);

        $instance->configure();

        return $instance;
    }

    public static function register(Component $livewire, ?string $name = null): void
    {
        $name = $name ?? self::getDefaultName();

        Forms::register($name, fn () => static::make($livewire, $name));
    }

    public static function resolve(?string $name = null): ?static
    {
        $name = $name ?? self::getDefaultName();

        return Forms::resolve($name);
    }

    protected static function getDefaultName(): string
    {
        $parts = explode('\\', static::class);

        return Str::kebab(end($parts));
    }

    public function getComponents(bool $withHidden = false): array
    {
        $components = array_map(function ($component) {

            if ($component instanceof Common\BelongsToLivewire) {
                $component->livewire($this->getLivewire());
            }

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return $components;
    }
}
