<?php

namespace Streams\Ui\Builders\Calendars;

use Streams\Ui\Builders\Containers\Section;

class Calendar extends Section
{
    protected string $viewIdentifier = 'calendar';

    protected string $view = 'ui::builders.calendar';

    protected array|\Closure $events = [];

    protected array $options = [];

    protected string|\Closure $initialView = 'dayGridMonth';

    protected string|\Closure|null $locale = null;

    protected string|\Closure|null $timezone = null;

    public function events(array|\Closure $events): static
    {
        $this->events = $events;

        return $this;
    }

    public function getEvents(): array
    {
        return $this->evaluate($this->events) ?: [];
    }

    public function options(array|\Closure $options): static
    {
        $this->options = [$options];

        return $this;
    }

    public function mergeOptions(array|\Closure $options): static
    {
        $this->options[] = $options;

        return $this;
    }

    public function getOptions(): array
    {
        $options = [];

        foreach ($this->options as $optionSet) {
            $options = [
                ...$options,
                ...($this->evaluate($optionSet) ?: []),
            ];
        }

        return $options;
    }

    public function initialView(string|\Closure $initialView): static
    {
        $this->initialView = $initialView;

        return $this;
    }

    public function getInitialView(): string
    {
        return $this->evaluate($this->initialView);
    }

    public function locale(string|\Closure|null $locale): static
    {
        $this->locale = $locale;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->evaluate($this->locale);
    }

    public function timezone(string|\Closure|null $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->evaluate($this->timezone);
    }

    public function getConfig(): array
    {
        return array_filter([
            'initialView' => $this->getInitialView(),
            'locale' => $this->getLocale(),
            'timeZone' => $this->getTimezone(),
            ...$this->getOptions(),
            'events' => $this->getEvents(),
        ], fn ($value) => $value !== null);
    }
}
