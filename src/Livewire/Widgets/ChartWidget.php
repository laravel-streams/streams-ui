<?php

namespace Streams\Ui\Livewire\Widgets;

use Streams\Ui\Builders\Concerns as Common;

class ChartWidget extends Widget
{
    use Common\HasColor;
    use Common\HasComponents;
    use Common\HasDescription;
    use Common\HasHeading;
    use Concerns\CanPoll;

    protected static string $view = 'ui::builders.chart';

    protected static string $type = 'line';

    protected static array $options = [];

    protected static array $callbacks = [];

    protected static array $functions = [];

    public function getType(): string
    {
        return static::$type;
    }

    public function getData(): array
    {
        return [];
    }

    public function getOptions(): array
    {
        return static::$options;
    }

    public function getCallbacks(): array
    {
        return static::$callbacks;
    }

    public function getFunctions(): array
    {
        return static::$functions;
    }

    /**
     * Accessible name for the canvas (`role="img"`). Defaults to the heading.
     */
    public function getAriaLabel(): ?string
    {
        return $this->getHeading();
    }

    /**
     * Label for the first dataset (table column header / legend).
     */
    public function getDatasetLabel(): ?string
    {
        $label = $this->getData()['datasets'][0]['label'] ?? null;

        return $label !== null ? (string) $label : null;
    }

    /**
     * Tabular equivalent of chart points for screen readers.
     *
     * @return list<array{label: string, value: mixed}>
     */
    public function getAccessibleRows(): array
    {
        $data = $this->getData();
        $labels = $data['labels'] ?? [];
        $values = $data['datasets'][0]['data'] ?? [];

        if (! is_array($labels) || $labels === []) {
            return [];
        }

        $rows = [];

        foreach (array_values($labels) as $index => $label) {
            $rows[] = [
                'label' => (string) $label,
                'value' => is_array($values) ? ($values[$index] ?? null) : null,
            ];
        }

        return $rows;
    }

    public function hasChartData(): bool
    {
        return $this->getAccessibleRows() !== [];
    }

    public function getEmptyMessage(): string
    {
        return (string) __('ui::messages.chart_empty');
    }
}
