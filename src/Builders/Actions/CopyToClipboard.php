<?php

namespace Streams\Ui\Builders\Actions;

use Closure;

class CopyToClipboard extends Action
{
    protected string | Closure | null $content = null;

    protected string $view = 'ui::copy-to-clipboard';

    protected string $viewIdentifier = 'copy-to-clipboard';

    protected string $evaluationIdentifier = 'copy-to-clipboard';

    public function __construct(string $name)
    {
        parent::__construct($name);
        
        // Default to button tag for clipboard actions
        $this->tag('button');
    }

    static public function make($name, string | Closure | null $content = null): static
    {
        $instance = app(static::class, ['name' => $name]);

        if ($content !== null) {
            $instance->content($content);
        }

        $instance->configure();

        return $instance;
    }

    public function content(string | Closure | null $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->evaluate($this->content) ?? '';
    }

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'content' => [$this->getContent()],
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
