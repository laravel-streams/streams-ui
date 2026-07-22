<?php

namespace Streams\Ui\Builders\Inputs;

class TagsInput extends Input
{
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::builders.inputs.tags';

    /**
     * @var array<string>|\Closure|null
     */
    protected array|\Closure|null $suggestions = null;

    /**
     * Keys that commit the draft tag (Enter always works in the view).
     *
     * @var array<string>|\Closure
     */
    protected array|\Closure $splitKeys = [','];

    public function suggestions(array|\Closure|null $suggestions): static
    {
        $this->suggestions = $suggestions;

        return $this;
    }

    /**
     * @return array<string>
     */
    public function getSuggestions(): array
    {
        return array_values(array_filter(
            (array) ($this->evaluate($this->suggestions) ?? []),
            fn (mixed $suggestion): bool => is_string($suggestion) && $suggestion !== '',
        ));
    }

    /**
     * @param  array<string>|\Closure  $keys
     */
    public function splitKeys(array|\Closure $keys): static
    {
        $this->splitKeys = $keys;

        return $this;
    }

    /**
     * @return array<string>
     */
    public function getSplitKeys(): array
    {
        return array_values(array_filter(
            (array) $this->evaluate($this->splitKeys),
            fn (mixed $key): bool => is_string($key) && $key !== '',
        ));
    }
}
