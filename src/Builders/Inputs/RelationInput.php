<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Concerns\HasPlaceholder;

class RelationInput extends Input
{
    use HasPlaceholder;

    protected string $view = 'ui::builders.inputs.relation';

    protected string|\Closure|null $stream = null;

    protected ?\Closure $query = null;

    protected bool|\Closure $searchable = true;

    protected bool|\Closure $multiple = false;

    protected ?\Closure $createUsing = null;

    protected string|\Closure $display = 'id';

    protected int $limit = 25;

    /** @var array<string, static> */
    protected static array $registry = [];

    public function stream(string|\Closure|null $stream): static
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream(): ?string
    {
        return $this->evaluate($this->stream);
    }

    /**
     * Closure receiving the search term (and the input), returning an iterable of records.
     * Takes precedence over the stream when set.
     */
    public function query(?\Closure $query): static
    {
        $this->query = $query;

        return $this;
    }

    public function searchable(bool|\Closure $condition = true): static
    {
        $this->searchable = $condition;

        return $this;
    }

    public function isSearchable(): bool
    {
        return (bool) $this->evaluate($this->searchable);
    }

    public function multiple(bool|\Closure $condition = true): static
    {
        $this->multiple = $condition;

        return $this;
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->multiple);
    }

    /**
     * Closure receiving the typed text and returning the new record (or its id).
     */
    public function createUsing(?\Closure $callback): static
    {
        $this->createUsing = $callback;

        return $this;
    }

    public function canCreate(): bool
    {
        return $this->createUsing !== null;
    }

    /**
     * Field name on the record, or closure receiving the record, used as the option label.
     */
    public function display(string|\Closure $display): static
    {
        $this->display = $display;

        return $this;
    }

    public function limit(int $limit): static
    {
        $this->limit = max(1, $limit);

        return $this;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function labelFor(mixed $record): string
    {
        $label = $this->display instanceof \Closure
            ? ($this->display)($record)
            : data_get($record, $this->display);

        return (string) $label;
    }

    public function idFor(mixed $record): string|int
    {
        return is_scalar($record) ? $record : data_get($record, 'id');
    }

    /**
     * @return array<int, array{value: string|int, label: string}>
     */
    public function search(string $term = ''): array
    {
        if ($this->query) {
            $records = ($this->query)($term, $this);
        } elseif ($stream = $this->getStream()) {
            $entries = \Streams\Core\Support\Facades\Streams::entries($stream);

            if ($term !== '') {
                $field = $this->display instanceof \Closure ? 'id' : $this->display;

                $entries = $entries->where($field, 'LIKE', '%'.$term.'%');
            }

            $records = $entries->limit($this->limit)->get();
        } else {
            $records = [];
        }

        $options = [];

        foreach ($records as $record) {
            $options[] = ['value' => $this->idFor($record), 'label' => $this->labelFor($record)];

            if (count($options) >= $this->limit) {
                break;
            }
        }

        return $options;
    }

    /**
     * Options for the currently selected ids.
     *
     * @return array<int, array{value: string|int, label: string}>
     */
    public function selected(): array
    {
        $state = $this->getState();

        if (blank($state)) {
            return [];
        }

        $ids = array_map('strval', (array) $state);

        return array_values(array_filter(
            $this->search(''),
            fn (array $option): bool => in_array((string) $option['value'], $ids, true),
        ));
    }

    /**
     * @return array{value: string|int, label: string}|null
     */
    public function create(string $text): ?array
    {
        if (! $this->createUsing) {
            return null;
        }

        $record = ($this->createUsing)($text, $this);

        if ($record === null) {
            return null;
        }

        return [
            'value' => $this->idFor($record),
            'label' => is_scalar($record) ? $text : $this->labelFor($record),
        ];
    }

    public function register(): static
    {
        static::$registry[$this->getStatePath()] = $this;

        return $this;
    }

    public static function registered(string $statePath): ?static
    {
        return static::$registry[$statePath] ?? null;
    }
}
