<?php

namespace Streams\Ui\Builders\Display;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Common;

/**
 * Read-only display of entry values. Never emits input elements.
 */
class Display extends ViewBuilder
{
    use Common\HasActions;
    use Common\HasHeading;

    protected string $viewIdentifier = 'display';

    protected string $view = 'ui::builders.display';

    protected array $entries = [];

    public static function make(array $entries = []): static
    {
        $instance = app(static::class);
        $instance->entries($entries);
        $instance->configure();

        return $instance;
    }

    public function entries(array $entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getEntries(): array
    {
        return $this->entries;
    }

    public function fill(mixed $data): static
    {
        $data = is_object($data) && method_exists($data, 'toArray')
            ? $data->toArray()
            : (array) $data;

        foreach ($this->entries as $entry) {
            $entry->state(data_get($data, $entry->getName()));
        }

        return $this;
    }
}
