<?php

namespace Streams\Ui\Tables\Concerns;

trait HasEntryUrl
{
    protected string | \Closure | null $entryUrl = null;

    public function entryUrl(string | \Closure | null $url): static
    {
        $this->entryUrl = $url;

        return $this;
    }

    public function getEntryUrl($entry): ?string
    {
        return $this->evaluate(
            $this->entryUrl,
            namedInjections: [
                'entry' => $entry,
            ],
            typedInjections: [
                // Model::class => $entry,
                $entry::class => $entry,
            ],
        );
    }
}
