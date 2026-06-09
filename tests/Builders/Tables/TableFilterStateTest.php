<?php

namespace Streams\Ui\Tests\Builders\Tables;

use Livewire\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Builders\Tables\Filters\TextFilter;
use Streams\Ui\Livewire\Tables\InteractsWithTables;
use Streams\Ui\Builders\Tables\Filters\SelectFilter;

class TableFilterStateTest extends UiTestCase
{
    protected function makeComponentWithFilters(): Component
    {
        return new class extends Component
        {
            use InteractsWithTables;

            public function table(Table $table): Table
            {
                return $table
                    ->filters([
                        TextFilter::make('name'),
                        SelectFilter::make('status')->options([
                            'active' => 'Active',
                            'inactive' => 'Inactive',
                        ]),
                    ]);
            }
        };
    }

    /** @test */
    public function it_reads_filter_values_from_table_state(): void
    {
        $component = $this->makeComponentWithFilters();
        $component->bootedInteractsWithTables();

        $table = $component->getTable();

        $table->setFilterValue('name', 'Ada');
        $table->setFilterValue('status', 'active');

        $this->assertSame('Ada', $table->getFilterValue('name'));
        $this->assertSame('active', $table->getFilterValue('status'));
        $this->assertSame(['name' => 'Ada', 'status' => 'active'], $table->getActiveFilterValues());
        $this->assertTrue($table->hasActiveFilters());
    }

    /** @test */
    public function it_exposes_filter_state_on_filter_instances(): void
    {
        $component = $this->makeComponentWithFilters();
        $component->bootedInteractsWithTables();

        $table = $component->getTable();
        $table->setFilterValue('status', 'inactive');

        $filter = $table->getFilter('status');

        $this->assertTrue($filter->isActive());
        $this->assertSame('inactive', $filter->getValue());
        $this->assertSame('Inactive', $filter->getIndicatorValue());
    }

    /** @test */
    public function livewire_can_read_table_filter_state(): void
    {
        $component = $this->makeComponentWithFilters();
        $component->bootedInteractsWithTables();

        $component->getTable()->setFilterValue('name', 'Luke');

        $this->assertSame(['value' => 'Luke'], $component->getTableFilterState('name'));
        $this->assertSame('Luke', $component->getTableFilterValue('name'));
        $this->assertSame(['name' => 'Luke'], $component->getTableActiveFilterValues());
    }

    /** @test */
    public function it_resets_filters_to_default_state(): void
    {
        $component = $this->makeComponentWithFilters();
        $component->bootedInteractsWithTables();

        $table = $component->getTable();
        $table->setFilterValue('name', 'Leia');

        $table->resetFilter('name');

        $this->assertFalse($table->getFilter('name')->isActive());
        $this->assertNull($table->getFilterValue('name'));
    }

    /** @test */
    public function it_initializes_missing_filter_keys_on_boot(): void
    {
        $component = $this->makeComponentWithFilters();
        $component->bootedInteractsWithTables();

        $state = $component->getTable()->getFiltersState();

        $this->assertArrayHasKey('name', $state);
        $this->assertArrayHasKey('status', $state);
        $this->assertNull($state['name']['value']);
        $this->assertNull($state['status']['value']);
    }
}
