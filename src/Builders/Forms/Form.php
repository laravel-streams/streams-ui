<?php

namespace Streams\Ui\Builders\Forms;

use Livewire\Component;
use Illuminate\Support\Str;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Support\Facades\Forms;
use Streams\Ui\Builders\Concerns as Common;

class Form extends ViewBuilder
{
    use Common\BelongsToLivewire;
    use Common\BelongsToParent;
    use Common\HasActions;
    use Common\HasComponents;
    use Common\HasDescription;
    use Common\HasEntry;
    use Common\HasHeading;
    use Common\HasHtmlAttributes;
    use Common\HasName;
    use Common\HasState;
    use Common\HasStream;
    use Concerns\HandlesValidation;

    protected string $view = 'ui::builders.form';

    protected string $viewIdentifier = 'form';

    public function __construct(?string $name = null)
    {
        $this->name($name ?? static::getDefaultName());
    }

    public static function make(?string $name = null): static
    {
        $resolvedName = $name ?? static::getDefaultName();

        $instance = new static($resolvedName);

        $instance->configure();

        return $instance;
    }

    public static function for(Component $livewire, ?string $name = null): static
    {
        $resolvedName = $name ?? static::getDefaultName();

        $static = new static($resolvedName);

        $static->livewire($livewire);
        $static->configure();

        return $static;
    }

    public static function register(Component $livewire, ?string $name = null): void
    {
        $name = $name ?? self::getDefaultName();

        Forms::register($name, fn () => static::for($livewire, $name));
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
        $host = $this->getLivewire();

        $components = array_map(function ($component) use ($host) {
            $this->assignLivewireToComponentTree($component, $host);

            return $component;
        }, $this->evaluate($this->components));

        if ($withHidden) {
            return $components;
        }

        return $components;
    }

    /**
     * Ensure every field under containers (e.g. Grid) shares the form’s Livewire host.
     */
    protected function assignLivewireToComponentTree(mixed $component, Component $host): void
    {
        if ($component instanceof Common\BelongsToLivewire) {
            $component->livewire($host);
        }

        if ($component instanceof Input) {
            $component->statePathPrefix($this->getStatePath());
        }

        if (is_object($component) && method_exists($component, 'getComponents')) {
            foreach ($component->getComponents() as $child) {
                $this->assignLivewireToComponentTree($child, $host);
            }
        }
    }
}
