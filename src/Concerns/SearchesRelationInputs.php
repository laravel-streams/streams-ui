<?php

namespace Streams\Ui\Concerns;

use Streams\Ui\Builders\Inputs\RelationInput;

/**
 * Add to a Livewire page that renders RelationInput. Provides the search and
 * create endpoints the input's view calls ($wire.searchRelationInputOptions).
 * Override relationInputs() to return inputs by state path when they are not
 * built during the render pass.
 */
trait SearchesRelationInputs
{
    /**
     * @return array<string, RelationInput>
     */
    protected function relationInputs(): array
    {
        return [];
    }

    protected function resolveRelationInput(string $statePath): RelationInput
    {
        $input = $this->relationInputs()[$statePath] ?? RelationInput::registered($statePath);

        abort_unless($input instanceof RelationInput, 404);

        return $input;
    }

    public function searchRelationInputOptions(string $statePath, string $term = ''): array
    {
        return $this->resolveRelationInput($statePath)->search($term);
    }

    public function createRelationInputOption(string $statePath, string $text): ?array
    {
        return $this->resolveRelationInput($statePath)->create($text);
    }
}
