<?php

namespace Streams\Ui\Tests\Feature;

use Livewire\Component;
use Streams\Ui\Tests\UiTestCase;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Livewire\Tables\InteractsWithTables;
use Streams\Ui\Builders\Tables\Filters\TextFilter;
use Streams\Ui\Builders\Tables\Filters\SelectFilter;

class TableDefaultFiltersTest extends UiTestCase
{
    protected function makeComponent(bool $viaFilter = false): Component
    {
        return new class($viaFilter) extends Component
        {
            use InteractsWithTables;

            public function __construct(public bool $viaFilter = false) {}

            public function table(Table $table): Table
            {
                $status = SelectFilter::make('status')->options(['active' => 'Active', 'inactive' => 'Inactive']);

                if ($this->viaFilter) {
                    $status->default('active');
                }

                $table->filters([TextFilter::make('name'), $status]);

                return $this->viaFilter ? $table : $table->defaultFilters(['status' => 'active']);
            }
        };
    }

    /** @test */
    public function it_renders_filtered_on_first_load_and_clears_on_reset(): void
    {
        $component = $this->makeComponent();
        $component->bootedInteractsWithTables();

        $this->assertSame('active', $component->getTable()->getFilterValue('status'));
        $this->assertTrue($component->getTable()->hasActiveFilters());

        $component->resetTableFilters();

        $this->assertNull($component->getTable()->getFilterValue('status'));
        $this->assertFalse($component->getTable()->hasActiveFilters());
    }

    /** @test */
    public function filter_default_seeds_first_load(): void
    {
        $component = $this->makeComponent(true);
        $component->bootedInteractsWithTables();

        $this->assertSame('active', $component->getTable()->getFilterValue('status'));
        $this->assertNull($component->getTable()->getFilterValue('name'));
    }
}
