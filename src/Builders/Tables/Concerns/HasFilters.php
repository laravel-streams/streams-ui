<?php

namespace Streams\Ui\Builders\Tables\Concerns;

use Streams\Ui\Actions\Action;
use Streams\Ui\Builders\Tables\Filters\Filter;
use Streams\Ui\Forms\Form;

trait HasFilters
{
    protected array $filters = [];

    protected int | array | \Closure | null $filtersFormColumns = null;

    protected string | \Closure | null $filtersFormMaxHeight = null;

    protected string | \Closure | null $filtersFormWidth = null;

    protected \Closure | null $filtersLayout = null;

    protected ?\Closure $modifyFiltersTriggerActionUsing = null;

    protected bool | \Closure $shouldDeselectAllRecordsWhenFiltered = true;

    public function resetWhenFiltered(bool | \Closure $condition = true): static
    {
        $this->shouldDeselectAllRecordsWhenFiltered = $condition;

        return $this;
    }

    public function filters(array $filters, string | \Closure | null $layout = null): static
    {
        $this->filters = [];

        $this->pushFilters($filters);

        if ($layout) {
            $this->filtersLayout($layout);
        }

        return $this;
    }

    public function pushFilters(array $filters): static
    {
        foreach ($filters as $filter) {

            $filter->table($this);

            $this->filters[$filter->getName()] = $filter;
        }

        return $this;
    }

    public function filtersFormColumns(int | array | \Closure | null $columns): static
    {
        $this->filtersFormColumns = $columns;

        return $this;
    }

    public function filtersFormMaxHeight(string | \Closure | null $height): static
    {
        $this->filtersFormMaxHeight = $height;

        return $this;
    }

    public function filtersFormWidth(string | \Closure | null $width): static
    {
        $this->filtersFormWidth = $width;

        return $this;
    }

    public function filtersLayout(\Closure | null $filtersLayout): static
    {
        $this->filtersLayout = $filtersLayout;

        return $this;
    }

    public function filtersTriggerAction(?\Closure $callback): static
    {
        $this->modifyFiltersTriggerActionUsing = $callback;

        return $this;
    }

    public function getFilters(): array
    {
        return array_filter(
            $this->filters,
            fn (Filter $filter): bool => $filter->isVisible(),
        );
    }

    public function getFilter(string $name): ?Filter
    {
        return $this->getFilters()[$name] ?? null;
    }

    public function getFiltersForm(): Form
    {
        return $this->getLivewire()->getTableFiltersForm();
    }

    public function getFiltersTriggerAction(): Action
    {
        $action = Action::make('openFilters')
            ->label(__('filament-tables::table.actions.filter.label'))
            //->iconButton()
            ->icon('heroicon-m-funnel')
            ->color('gray');
        //->livewireClickHandlerEnabled(false)
        //->modalSubmitAction(false)
        // ->extraModalFooterActions([
        //     Action::make('resetFilters')
        //         ->label(__('filament-tables::table.filters.actions.reset.label'))
        //         ->color('danger')
        //         ->action('resetTableFiltersForm'),
        // ])
        // ->modalCancelActionLabel(__('filament::components/modal.actions.close.label'))
        //->table($this);

        if ($this->modifyFiltersTriggerActionUsing) {
            $action = $this->evaluate($this->modifyFiltersTriggerActionUsing, [
                'action' => $action,
            ]) ?? $action;
        }

        if ($action->getView() === 'button-group') {
            $action->defaultSize('sm');
        }

        return $action;
    }

    public function getFiltersFormColumns(): int | array
    {
        return $this->evaluate($this->filtersFormColumns)
            ?? match ($this->getFiltersLayout()) {
                'above-content', 'above-collapsible', 'below-content' => [
                    'sm' => 2,
                    'lg' => 3,
                    'xl' => 4,
                    '2xl' => 5,
                ],
                default => 1,
            };
    }

    public function getFiltersFormMaxHeight(): ?string
    {
        return $this->evaluate($this->filtersFormMaxHeight);
    }

    public function getFiltersFormWidth(): ?string
    {
        return $this->evaluate($this->filtersFormWidth) ?? match ($this->getFiltersFormColumns()) {
            2 => '2xl',
            3 => '4xl',
            4 => '6xl',
            default => null,
        };
    }

    public function getFiltersLayout(): string
    {
        return $this->evaluate($this->filtersLayout) ?? 'dropdown';
    }

    public function isFilterable(): bool
    {
        return (bool) count($this->getFilters());
    }

    public function shouldDeselectAllRecordsWhenFiltered(): bool
    {
        return (bool) $this->evaluate($this->shouldDeselectAllRecordsWhenFiltered);
    }
}
