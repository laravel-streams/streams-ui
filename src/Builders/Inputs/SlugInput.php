<?php

namespace Streams\Ui\Builders\Inputs;

/**
 * Text input that can auto-slugify from a sibling field.
 *
 * Mirrors Streams {@see \Streams\Core\Field\Types\SlugFieldType} config:
 * `"slugify": "name"`, `"separator": "-"`.
 */
class SlugInput extends TextInput
{
    protected string $view = 'ui::builders.inputs.slug';

    protected string|\Closure|null $slugify = null;

    protected string|\Closure $separator = '-';

    /**
     * Source field handle (sibling in the same form) to slugify from.
     */
    public function slugify(string|\Closure|null $field): static
    {
        $this->slugify = $field;

        return $this;
    }

    public function getSlugify(): ?string
    {
        $slugify = $this->evaluate($this->slugify);

        return filled($slugify) ? (string) $slugify : null;
    }

    public function separator(string|\Closure $separator): static
    {
        $this->separator = $separator;

        return $this;
    }

    public function getSeparator(): string
    {
        return (string) $this->evaluate($this->separator);
    }

    /**
     * Full Livewire state path for the source field (e.g. data.finder-form.name).
     */
    public function getSlugifyStatePath(): ?string
    {
        $from = $this->getSlugify();

        if ($from === null) {
            return null;
        }

        $parts = explode('.', $this->getStatePath());
        array_pop($parts);
        $parts[] = $from;

        return implode('.', $parts);
    }

    /**
     * Keep auto-sync on only while the slug is still empty (create flow).
     * Prefill on edit starts unsynced so renaming does not overwrite the slug.
     */
    public function shouldSyncSlugify(): bool
    {
        if (! filled($this->getSlugify())) {
            return false;
        }

        if (! isset($this->livewire)) {
            return true;
        }

        return blank(data_get($this->livewire, $this->getStatePath()));
    }
}
